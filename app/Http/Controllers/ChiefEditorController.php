<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionAssignment;
use App\Models\User;
use App\Models\EditorExpertise;
use App\Models\Appeal;
use App\Services\RevisionService;
use Illuminate\Http\Request;
use App\Models\RevisionRequest;
use Illuminate\Support\Facades\Auth;

class ChiefEditorController extends Controller
{
    public function dashboard(\Illuminate\Http\Request $request)
    {
        // remember that chief editor dashboard was visited last
        $request->session()->put('preferred_dashboard', 'editor-in-chief');

        $pendingSubmissions = Submission::where('status', Submission::STATUS_SUBMITTED)
            ->whereNull('assigned_editor_id')
            ->with('author')
            ->latest('submitted_at')
            ->paginate(10);

        $assignedSubmissions = Submission::whereNotNull('assigned_editor_id')
            ->with('assignedEditor', 'author')
            ->latest('chief_editor_review_at')
            ->paginate(10, ['*'], 'assigned');

        $pendingAppeals = Appeal::where('status', Appeal::STATUS_PENDING)
            ->with(['submission', 'author'])
            ->latest('created_at')
            ->paginate(10, ['*'], 'appeals');

        $completedAppeals = Appeal::whereIn('status', [Appeal::STATUS_APPROVED, Appeal::STATUS_REJECTED])
            ->with(['submission', 'author', 'reviewedBy'])
            ->latest('reviewed_at')
            ->paginate(10, ['*'], 'completed_appeals');

        $stats = [
            'total_submissions'      => Submission::count(),
            'pending_assignments'    => Submission::where('status', Submission::STATUS_SUBMITTED)
                ->whereNull('assigned_editor_id')
                ->count(),
            'assigned_count'         => Submission::whereNotNull('assigned_editor_id')->count(),
            'under_review'           => Submission::where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'revision_under_review'  => Submission::where('status', Submission::STATUS_REVISION_UNDER_REVIEW)->count(),
            'completed'              => Submission::whereIn('status', [
                Submission::STATUS_ACCEPTED,
                Submission::STATUS_REJECTED,
            ])->count(),
            'pending_appeals'        => Appeal::where('status', Appeal::STATUS_PENDING)->count(),
        ];

        return view('chief-editor.dashboard', compact('pendingSubmissions', 'assignedSubmissions', 'pendingAppeals', 'completedAppeals', 'stats'));
    }

    public function showSubmission(Submission $submission)
    {
        $researchField = $submission->research_field;

        // Only load editors whose expertise MATCHES the submission's research field
        $matchingEditors = User::whereHas('roles', fn($q) => $q->where('name', 'editor'))
            ->whereHas('editorExpertise', fn($q) => $q->where('field_name', $researchField))
            ->withCount(['submissionAssignments as active_assignments_count' => fn($q) =>
                $q->whereNull('rejected_at')
                  ->whereHas('submission', fn($q2) => $q2->whereNotIn('status', ['accepted', 'rejected']))
            ])
            ->with('editorExpertise')
            ->get();

        // Group by expertise field
        $editorsByField = [];
        foreach ($matchingEditors as $editor) {
            foreach ($editor->editorExpertise as $expertise) {
                if ($expertise->field_name === $researchField) {
                    $editorsByField[$expertise->field_name][] = $editor;
                }
            }
        }

        // Fallback for manual assignment
        $allEditors = User::whereHas('roles', fn($q) => $q->where('name', 'editor'))
            ->withCount(['submissionAssignments as active_assignments_count' => fn($q) =>
                $q->whereNull('rejected_at')
                  ->whereHas('submission', fn($q2) => $q2->whereNotIn('status', ['accepted', 'rejected']))
            ])
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
            'editorsByField',
            'allEditorsByField',
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
            'screening_status' => 'required|in:passed,failed,revision',
            'comments'         => 'required|string|max:2000',
            'revision_type'    => 'nullable|in:minor,major|required_if:screening_status,revision',
        ]);

        /** @var User $currentUser */
        $currentUser = Auth::user();

        if ($validated['screening_status'] === 'revision') {
            RevisionService::createRevisionRequest(
                $submission,
                $currentUser,
                $validated['revision_type'],
                $validated['comments'],
                'initial_screening'
            );

            $submission->update([
                'initial_screening_status'   => 'failed',
                'initial_screening_comments' => $validated['comments'],
                'initial_screening_by'       => Auth::id(),
                'initial_screening_at'       => now(),
            ]);

            return redirect()->route('chief-editor.submission.show', $submission)
                ->with('success', 'Revision requested. Author has been notified.');
        }

        $isPassed = $validated['screening_status'] === 'passed';

        $submission->update([
            'initial_screening_status'   => $validated['screening_status'],
            'initial_screening_comments' => $validated['comments'],
            'initial_screening_by'       => Auth::id(),
            'initial_screening_at'       => now(),
        ]);

        \App\Models\Notification::create([
            'user_id'         => $submission->author_id,
            'title'           => $isPassed ? '✅ Submission Passed Initial Screening' : '❌ Submission Failed Initial Screening',
            'message'         => $isPassed
                ? "Your manuscript \"{$submission->title}\" has passed the initial screening.\n\nComments: {$validated['comments']}"
                : "Your manuscript \"{$submission->title}\" did not pass the initial screening.\n\nComments: {$validated['comments']}",
            'type'            => $isPassed ? 'success' : 'danger',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        return redirect()->route('chief-editor.submission.show', $submission)
            ->with('success', $isPassed ? 'Passed. Author notified.' : 'Failed. Author notified.');
    }

    public function assignSubmission(Request $request, Submission $submission)
    {
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

$submission->load('author');

foreach ($editors as $index => $editor) {
            $expertiseField = $editor->editorExpertise->first()?->field_name ?? 'General';

            SubmissionAssignment::create([
                'submission_id'       => $submission->id,
                'assigned_to_user_id' => $editor->id,
                'assigned_by_user_id' => Auth::id(),
                'expertise_field'     => $expertiseField,
                'assignment_notes'    => $validated['notes'] ?? null,
                'assigned_at'         => now(),
            ]);

         $editorNames[] = $editor->name;

if ($index === 0) {
    $primaryEditor = $editor->id;
}

\App\Models\Notification::create([
    'user_id'         => $editor->id,
    'title'           => '📋 New Manuscript Assigned',
    'message'         => "You have been assigned to handle the manuscript \"{$submission->title}\" by {$submission->author->name}.",
    'type'            => 'info',
    'notifiable_id'   => $submission->id,
    'notifiable_type' => Submission::class,
]);
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

$submission->load('author');

foreach ($editors as $index => $editor) {
            $expertiseField = $editor->editorExpertise->first()?->field_name ?? 'General';

            SubmissionAssignment::create([
                'submission_id'       => $submission->id,
                'assigned_to_user_id' => $editor->id,
                'assigned_by_user_id' => Auth::id(),
                'expertise_field'     => $expertiseField,
                'assignment_notes'    => $validated['notes'] ?? null,
                'assigned_at'         => now(),
            ]);

         $editorNames[] = $editor->name;

if ($index === 0) {
    $primaryEditor = $editor->id;
}

\App\Models\Notification::create([
    'user_id'         => $editor->id,
    'title'           => '🔄 Manuscript Reassigned to You',
    'message'         => "The manuscript \"{$submission->title}\" by {$submission->author->name} has been reassigned to you.",
    'type'            => 'info',
    'notifiable_id'   => $submission->id,
    'notifiable_type' => Submission::class,
]);
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

        \App\Models\Notification::create([
            'user_id'         => $submission->author_id,
            'title'           => '📝 Chief Editor Added a Review Note',
            'message'         => "The Chief Editor has added a note on your manuscript \"{$submission->title}\".\n\nNote: {$validated['notes']}",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        return back()->with('success', 'Submission review notes added.');
    }

    public function requestRevision(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'revision_type'   => ['required', 'in:minor,major'],
            'revision_reason' => ['required', 'string', 'max:2000'],
        ]);

        /** @var User $authUser */
        $authUser = Auth::user();

        RevisionService::createRevisionRequest(
            $submission,
            $authUser,
            $validated['revision_type'],
            $validated['revision_reason'],
            'initial_screening'
        );

        return back()->with('success', 'Revision request sent to author.');
    }
}
