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
            'total_submissions' => Submission::count(),
            'pending_assignments' => Submission::where('status', Submission::STATUS_SUBMITTED)
                ->whereNull('assigned_editor_id')
                ->count(),
            'assigned_count' => Submission::whereNotNull('assigned_editor_id')->count(),
            'under_review' => Submission::where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'completed' => Submission::whereIn('status', [
                Submission::STATUS_ACCEPTED,
                Submission::STATUS_REJECTED
            ])->count(),
        ];

        return view('chief-editor.dashboard', compact('pendingSubmissions', 'assignedSubmissions', 'stats'));
    }

    public function showSubmission(Submission $submission)
    {
        // Load available editors with their expertise
        $editorsWithExpertise = User::whereHas('roles', function ($query) {
            $query->where('name', 'editor');
        })
            ->with('editorExpertise')
            ->get();

        // Group editors by expertise field
        $editorsByField = [];
        foreach ($editorsWithExpertise as $editor) {
            if ($editor->editorExpertise->isNotEmpty()) {
                foreach ($editor->editorExpertise as $expertise) {
                    if (!isset($editorsByField[$expertise->field_name])) {
                        $editorsByField[$expertise->field_name] = [];
                    }
                    $editorsByField[$expertise->field_name][] = $editor;
                }
            }
        }

        return view('chief-editor.show-submission', compact('submission', 'editorsWithExpertise', 'editorsByField'));
    }

    public function assignSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'editor_ids' => 'required|array|min:1',
            'editor_ids.*' => 'exists:users,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $editorIds = $validated['editor_ids'];
        $editors = User::whereIn('id', $editorIds)->get();

        // Validate all selected users are editors
        foreach ($editors as $editor) {
            if (!$editor->hasRole('editor')) {
                return back()->withErrors("{$editor->name} is not an editor.");
            }
        }

        // Create assignment records for each selected editor
        $editorNames = [];
        $primaryEditor = null;

        foreach ($editors as $index => $editor) {
            // Get editor's primary expertise field
            $expertiseField = $editor->editorExpertise->first()?->field_name ?? 'General';

            // Create assignment
            SubmissionAssignment::create([
                'submission_id' => $submission->id,
                'assigned_to_user_id' => $editor->id,
                'assigned_by_user_id' => auth()->id(),
                'expertise_field' => $expertiseField,
                'assignment_notes' => $validated['notes'] ?? null,
                'assigned_at' => now(),
            ]);

            $editorNames[] = $editor->name;

            // Set first selected editor as primary
            if ($index === 0) {
                $primaryEditor = $editor->id;
            }
        }

        // Update submission with primary assigned editor
        $submission->update([
            'assigned_editor_id' => $primaryEditor,
            'chief_editor_review_at' => now(),
        ]);

        $editorList = implode(', ', $editorNames);
        return redirect()->route('chief-editor.submission.show', $submission)
            ->with('success', "Submission assigned to: {$editorList}.");
    }

    public function reassignSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'editor_ids' => 'required|array|min:1',
            'editor_ids.*' => 'exists:users,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $editorIds = $validated['editor_ids'];
        $editors = User::whereIn('id', $editorIds)->get();

        // Validate all selected users are editors
        foreach ($editors as $editor) {
            if (!$editor->hasRole('editor')) {
                return back()->withErrors("{$editor->name} is not an editor.");
            }
        }

        // Mark previous assignments as rejected
        $submission->assignments()->latest()->get()->each(function ($assignment) {
            if (!$assignment->isAccepted()) {
                $assignment->update(['rejected_at' => now()]);
            }
        });

        // Create new assignment records
        $editorNames = [];
        $primaryEditor = null;

        foreach ($editors as $index => $editor) {
            // Get editor's primary expertise field
            $expertiseField = $editor->editorExpertise->first()?->field_name ?? 'General';

            // Create assignment
            SubmissionAssignment::create([
                'submission_id' => $submission->id,
                'assigned_to_user_id' => $editor->id,
                'assigned_by_user_id' => auth()->id(),
                'expertise_field' => $expertiseField,
                'assignment_notes' => $validated['notes'] ?? null,
                'assigned_at' => now(),
            ]);

            $editorNames[] = $editor->name;

            // Set first selected editor as primary
            if ($index === 0) {
                $primaryEditor = $editor->id;
            }
        }

        // Update submission
        $submission->update([
            'assigned_editor_id' => $primaryEditor,
        ]);

        $editorList = implode(', ', $editorNames);
        return back()->with('success', "Submission reassigned to: {$editorList}.");
    }

    public function reviewSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $submission->update([
            'chief_editor_notes' => $validated['notes'],
            'chief_editor_review_at' => now(),
        ]);

        return back()->with('success', 'Submission review notes added.');
    }
}
