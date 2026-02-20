<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionAssignment;
use App\Models\User;
use App\Models\EditorExpertise;
use Illuminate\Http\Request;

class ChiefEditorController extends Controller
{
    public function dashboard()
    {
        $pendingSubmissions = Submission::where('status', Submission::STATUS_SUBMITTED)
            ->whereNull('assigned_editor_id')
            ->with('author')
            ->latest('submitted_at')
            ->paginate(10);

        $assignedSubmissions = Submission::whereNotNull('assigned_editor_id')
            ->with('assignedEditor', 'author')
            ->latest('chief_editor_review_at')
            ->paginate(10, ['*'], 'assigned');

        $stats = [
            'total_submissions'   => Submission::count(),
            'pending_assignments' => Submission::where('status', Submission::STATUS_SUBMITTED)
                ->whereNull('assigned_editor_id')
                ->count(),
            'assigned_count'      => Submission::whereNotNull('assigned_editor_id')->count(),
            'under_review'        => Submission::where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'completed'           => Submission::whereIn('status', [
                Submission::STATUS_ACCEPTED,
                Submission::STATUS_REJECTED,
            ])->count(),
        ];

        return view('chief-editor.dashboard', compact('pendingSubmissions', 'assignedSubmissions', 'stats'));
    }

    public function showSubmission(Submission $submission)
    {
        $researchField = $submission->research_field;

        // Only load editors whose expertise MATCHES the submission's research field
        $matchingEditors = User::whereHas('roles', function ($query) {
                $query->where('name', 'editor');
            })
            ->whereHas('editorExpertise', function ($query) use ($researchField) {
                $query->where('field_name', $researchField);
            })
            ->with('editorExpertise')
            ->get();

        // Group by expertise field (will mostly be one field, but keeps structure consistent)
        $editorsByField = [];
        foreach ($matchingEditors as $editor) {
            foreach ($editor->editorExpertise as $expertise) {
                if ($expertise->field_name === $researchField) {
                    $editorsByField[$expertise->field_name][] = $editor;
                }
            }
        }

        // Also pass all editors as fallback so chief editor can still assign manually if no match
        $allEditors = User::whereHas('roles', function ($query) {
                $query->where('name', 'editor');
            })
            ->with('editorExpertise')
            ->get();

        $allEditorsByField = [];
        foreach ($allEditors as $editor) {
            foreach ($editor->editorExpertise as $expertise) {
                $allEditorsByField[$expertise->field_name][] = $editor;
            }
        }

        return view('chief-editor.show-submission', compact(
            'submission',
            'editorsByField',      // matched editors (same field as submission)
            'allEditorsByField',   // all editors grouped by field (fallback)
            'researchField',
        ));
    }

    public function initialScreening(Submission $submission)
    {
        return view('chief-editor.initial-screening', compact('submission'));
    }

    public function storeInitialScreening(Request $request, Submission $submission)
{
    $validated = $request->validate([
        'screening_status' => 'required|in:passed,failed',
        'comments'         => 'required|string|max:2000',
    ]);

    $submission->update([
        'initial_screening_status'   => $validated['screening_status'],
        'initial_screening_comments' => $validated['comments'],
        'initial_screening_by'       => auth()->id(),
        'initial_screening_at'       => now(),
    ]);

    // Send in-system notification to author
    $isPassed = $validated['screening_status'] === 'passed';

    \App\Models\Notification::create([
        'user_id'        => $submission->author_id,
        'title'          => $isPassed ? '✅ Submission Passed Initial Screening' : '❌ Submission Failed Initial Screening',
        'message'        => $isPassed
            ? "Your manuscript \"{$submission->title}\" has passed the initial screening and will proceed to editorial review.\n\nComments: {$validated['comments']}"
            : "Your manuscript \"{$submission->title}\" did not pass the initial screening.\n\nComments: {$validated['comments']}",
        'type'           => $isPassed ? 'success' : 'danger',
        'notifiable_id'  => $submission->id,
        'notifiable_type' => Submission::class,
    ]);

    return redirect()->route('chief-editor.submission.show', $submission)
        ->with('success', $isPassed
            ? 'Initial screening passed. Author has been notified.'
            : 'Initial screening failed. Author has been notified.'
        );
}

    public function assignSubmission(Request $request, Submission $submission)
    {
        // Check if initial screening has passed
        if (!$submission->hasPassedInitialScreening()) {
            return back()->withErrors('This manuscript must pass the initial screening before being assigned to an editor.');
        }

        $validated = $request->validate([
            'editor_ids'   => 'required|array|min:1',
            'editor_ids.*' => 'exists:users,id',
            'notes'        => 'nullable|string|max:1000',
        ]);

        $editors = User::whereIn('id', $validated['editor_ids'])->get();

        foreach ($editors as $editor) {
            if (!$editor->hasRole('editor')) {
                return back()->withErrors("{$editor->name} is not an editor.");
            }
        }

        $editorNames   = [];
        $primaryEditor = null;

        foreach ($editors as $index => $editor) {
            $expertiseField = $editor->editorExpertise->first()?->field_name ?? 'General';

            SubmissionAssignment::create([
                'submission_id'       => $submission->id,
                'assigned_to_user_id' => $editor->id,
                'assigned_by_user_id' => auth()->id(),
                'expertise_field'     => $expertiseField,
                'assignment_notes'    => $validated['notes'] ?? null,
                'assigned_at'         => now(),
            ]);

            $editorNames[] = $editor->name;

            if ($index === 0) {
                $primaryEditor = $editor->id;
            }
        }

        $submission->update([
            'assigned_editor_id'     => $primaryEditor,
            'chief_editor_review_at' => now(),
        ]);

        return redirect()->route('chief-editor.submission.show', $submission)
            ->with('success', 'Submission assigned to: ' . implode(', ', $editorNames) . '.');
    }

    public function reassignSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'editor_ids'   => 'required|array|min:1',
            'editor_ids.*' => 'exists:users,id',
            'notes'        => 'nullable|string|max:1000',
        ]);

        $editors = User::whereIn('id', $validated['editor_ids'])->get();

        foreach ($editors as $editor) {
            if (!$editor->hasRole('editor')) {
                return back()->withErrors("{$editor->name} is not an editor.");
            }
        }

        $submission->assignments()->latest()->get()->each(function ($assignment) {
            if (!$assignment->isAccepted()) {
                $assignment->update(['rejected_at' => now()]);
            }
        });

        $editorNames   = [];
        $primaryEditor = null;

        foreach ($editors as $index => $editor) {
            $expertiseField = $editor->editorExpertise->first()?->field_name ?? 'General';

            SubmissionAssignment::create([
                'submission_id'       => $submission->id,
                'assigned_to_user_id' => $editor->id,
                'assigned_by_user_id' => auth()->id(),
                'expertise_field'     => $expertiseField,
                'assignment_notes'    => $validated['notes'] ?? null,
                'assigned_at'         => now(),
            ]);

            $editorNames[] = $editor->name;

            if ($index === 0) {
                $primaryEditor = $editor->id;
            }
        }

        $submission->update(['assigned_editor_id' => $primaryEditor]);

        return back()->with('success', 'Submission reassigned to: ' . implode(', ', $editorNames) . '.');
    }

    public function reviewSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $submission->update([
            'chief_editor_notes'     => $validated['notes'],
            'chief_editor_review_at' => now(),
        ]);

        return back()->with('success', 'Submission review notes added.');
    }
}