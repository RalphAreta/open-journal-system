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
    public function dashboard(Request $request)
    {
        $request->session()->put('preferred_dashboard', 'editor-in-chief');
        $request->session()->put('active_role', 'editor-in-chief');

        $pendingSubmissions = Submission::where('status', Submission::STATUS_SUBMITTED)
            ->whereNull('assigned_editor_id')
            ->with('author')
            ->latest('submitted_at')
            ->paginate(10);

        // Assigned submissions with optional search
        $assignedQuery = Submission::whereNotNull('assigned_editor_id')
            ->with('assignedEditor', 'author');

        // Apply search filter if provided
        $searchTerm = $request->query('search');
        if ($searchTerm) {
            $assignedQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('abstract', 'like', "%{$searchTerm}%")
                  ->orWhereHas('assignedEditor', function($q2) use ($searchTerm) {
                      $q2->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $assignedSubmissions = $assignedQuery
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

        return view('chief-editor.dashboard', compact('pendingSubmissions', 'assignedSubmissions', 'pendingAppeals', 'completedAppeals', 'stats', 'searchTerm'));
    }

    public function showSubmission(Submission $submission)
    {
        $researchField = $submission->research_field;

        // Check if original file exists
        $originalFileExists = $submission->original_file_path &&
                             \Illuminate\Support\Facades\Storage::disk('local')->exists($submission->original_file_path);

        // Fetch the latest appeal (if any)
        $latestAppeal = $submission->appeals()->latest('created_at')->first();

        // 1. MATCHING editors
        $matchingEditors = User::whereHas('roles', fn($q) => $q->where('name', 'editor'))
            ->whereHas('editorExpertise', fn($q) => $q->where('field_name', $researchField))
            ->withCount(['submissionAssignments as active_assignments_count' => fn($q) =>
                $q->whereNull('rejected_at')
                  ->whereHas('submission', fn($q2) => $q2->whereNotIn('status', ['accepted', 'rejected']))
            ])
            ->with('editorExpertise')
            ->get();

        $editorsByField = [];
        foreach ($matchingEditors as $editor) {
            foreach ($editor->editorExpertise as $expertise) {
                if ($expertise->field_name === $researchField) {
                    $editorsByField[$expertise->field_name][] = $editor;
                }
            }
        }

        // 2. ALL editors (Fallback)
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
            'originalFileExists',
            'latestAppeal',
        ));
    }

    public function initialScreening(Submission $submission)
    {
        $researchField = $submission->research_field;

        // 1. MATCHING editors
        $matchingEditors = User::whereHas('roles', fn($q) => $q->where('name', 'editor'))
            ->whereHas('editorExpertise', fn($q) => $q->where('field_name', $researchField))
            ->withCount(['submissionAssignments as active_assignments_count' => fn($q) =>
                $q->whereNull('rejected_at')
                  ->whereHas('submission', fn($q2) => $q2->whereNotIn('status', ['accepted', 'rejected']))
            ])
            ->with('editorExpertise')
            ->get();

        $editorsByField = [];
        foreach ($matchingEditors as $editor) {
            foreach ($editor->editorExpertise as $expertise) {
                if ($expertise->field_name === $researchField) {
                    $editorsByField[$expertise->field_name][] = $editor;
                }
            }
        }

        // 2. ALL editors (Fallback)
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

        return view('chief-editor.initial-screening', compact(
            'submission',
            'researchField',
            'editorsByField',
            'allEditorsByField'
        ));
    }

    public function storeInitialScreening(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'screening_status' => 'required|in:passed,failed,revision',
            'comments'         => 'required|string|max:2000',
            'revision_type'    => 'nullable|in:minor,major|required_if:screening_status,revision',
        ]);

        if ($validated['screening_status'] === 'revision') {
            RevisionService::createRevisionRequest(
                $submission,
                Auth::user(),
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
            'role'            => 'author',
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
            'editor_id'   => 'required|exists:users,id',
            'notes'       => 'nullable|string|max:1000',
        ]);

        $editor = User::findOrFail($validated['editor_id']);
        $submission->load('author');
        $expertiseField = $editor->editorExpertise->first()?->field_name ?? 'General';

        SubmissionAssignment::create([
            'submission_id'       => $submission->id,
            'assigned_to_user_id' => $editor->id,
            'assigned_by_user_id' => Auth::id(),
            'expertise_field'     => $expertiseField,
            'assignment_notes'    => $validated['notes'] ?? null,
            'assigned_at'         => now(),
        ]);

        \App\Models\Notification::create([
            'user_id'         => $editor->id,
            'role'            => 'editor',
            'title'           => '📋 New Manuscript Assigned',
            'message'         => "You have been assigned to handle the manuscript \"{$submission->title}\" by {$submission->author->name}.",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        $submission->update([
            'assigned_editor_id'     => $editor->id,
            'chief_editor_review_at' => now(),
        ]);

        return redirect()->route('chief-editor.submission.show', $submission)
            ->with('success', 'Submission assigned to: ' . $editor->name . '.');
    }

    /**
     * Reassign submission to a different editor.
     */
    public function reassignSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'editor_id' => 'required|exists:users,id',
            'notes'     => 'nullable|string|max:1000',
        ]);

        $editor = User::findOrFail($validated['editor_id']);
        $submission->load('author');
        $expertiseField = $editor->editorExpertise->first()?->field_name ?? 'General';

        // Mark all existing assignments as rejected (archived in history)
        $submission->assignments()
            ->whereNull('rejected_at')
            ->update(['rejected_at' => now()]);

        // Create new assignment
        SubmissionAssignment::create([
            'submission_id'       => $submission->id,
            'assigned_to_user_id' => $editor->id,
            'assigned_by_user_id' => Auth::id(),
            'expertise_field'     => $expertiseField,
            'assignment_notes'    => $validated['notes'] ?? null,
            'assigned_at'         => now(),
        ]);

        \App\Models\Notification::create([
            'user_id'         => $editor->id,
            'role'            => 'editor',
            'title'           => '📋 Manuscript Reassigned to You',
            'message'         => "The manuscript \"{$submission->title}\" has been reassigned to you. Please review the assignment.",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        $submission->update([
            'assigned_editor_id'     => $editor->id,
            'chief_editor_review_at' => now(),
        ]);

        return redirect()->route('chief-editor.submission.show', $submission)
            ->with('success', 'Submission reassigned to: ' . $editor->name . '.');
    }
}
