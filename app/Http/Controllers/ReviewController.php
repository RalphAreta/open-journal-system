<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewAssignment;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReviewController extends Controller
{
    /**
     * List submissions assigned to the current user for review (reviewer).
     */
    public function index(Request $request): View
    {
        $assignments = $request->user()
            ->reviewAssignments()
            ->with(['submission.author'])
            ->latest()
            ->paginate(15);

        return view('reviews.index', compact('assignments'));
    }

    /**
     * Show submission and form to submit review (reviewer).
     */
    public function create(ReviewAssignment $assignment): View|RedirectResponse
    {
        if ($assignment->reviewer_id !== request()->user()->id) {
            abort(403);
        }
        if ($assignment->status === ReviewAssignment::STATUS_COMPLETED) {
            return redirect()->route('reviews.index')->with('info', 'You have already submitted this review.');
        }

        $assignment->load('submission.author');
        $submission = $assignment->submission;

        return view('reviews.create', compact('assignment', 'submission'));
    }

    /**
     * Store review (reviewer).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'review_assignment_id' => ['required', 'exists:review_assignments,id'],
            'recommendation' => ['required', 'in:accept,minor_revisions,major_revisions,reject'],
            'comments_for_author' => ['nullable', 'string'],
            'comments_for_editor' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $assignment = ReviewAssignment::findOrFail($validated['review_assignment_id']);
        if ($assignment->reviewer_id !== $request->user()->id) {
            abort(403);
        }
        if ($assignment->status === ReviewAssignment::STATUS_COMPLETED) {
            return redirect()->route('reviews.index')->with('error', 'Review already submitted.');
        }

        Review::create([
            'submission_id' => $assignment->submission_id,
            'reviewer_id' => $request->user()->id,
            'review_assignment_id' => $assignment->id,
            'recommendation' => $validated['recommendation'],
            'comments_for_author' => $validated['comments_for_author'] ?? null,
            'comments_for_editor' => $validated['comments_for_editor'] ?? null,
            'rating' => $validated['rating'] ?? null,
            'submitted_at' => now(),
        ]);

        $assignment->update([
            'status' => ReviewAssignment::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review submitted successfully.');
    }

    /**
     * Editor: list all submissions for management.
     */
    public function editorSubmissions(Request $request): View
    {
        $submissions = Submission::with(['author', 'reviews.reviewer', 'reviewAssignments.reviewer'])
            ->latest()
            ->paginate(15);

        return view('reviews.editor-submissions', compact('submissions'));
    }

    /**
     * Editor: show submission and make decision.
     */
    public function editorShow(Submission $submission): View
    {
        $submission->load(['author', 'reviews.reviewer', 'reviewAssignments.reviewer']);
        return view('reviews.editor-show', compact('submission'));
    }

    /**
     * Editor: assign reviewer to submission.
     */
    public function assignReviewer(Request $request, Submission $submission): RedirectResponse
    {
        $validated = $request->validate([
            'reviewer_id' => ['required', 'exists:users,id'],
            'due_at' => ['nullable', 'date'],
        ]);

        $reviewerId = $validated['reviewer_id'];
        $exists = ReviewAssignment::where('submission_id', $submission->id)
            ->where('reviewer_id', $reviewerId)
            ->exists();
        if ($exists) {
            return back()->with('error', 'This reviewer is already assigned.');
        }

        ReviewAssignment::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewerId,
            'assigned_by' => $request->user()->id,
            'due_at' => $validated['due_at'] ?? null,
        ]);

        $submission->update(['status' => Submission::STATUS_UNDER_REVIEW]);

        return back()->with('success', 'Reviewer assigned.');
    }

    /**
     * Editor: make decision on submission.
     */
    public function editorDecision(Request $request, Submission $submission): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:accepted,rejected,revisions_requested'],
            'editor_notes' => ['nullable', 'string'],
        ]);

        $submission->update([
            'status' => $validated['status'],
            'editor_id' => $request->user()->id,
            'editor_decision_at' => now(),
            'editor_notes' => $validated['editor_notes'] ?? null,
        ]);

        return redirect()->route('editor.submissions')->with('success', 'Decision recorded.');
    }

    /**
     * Admin: list all submissions for management.
     */
    public function adminSubmissions(Request $request): View
    {
        $submissions = Submission::with(['author', 'reviews.reviewer', 'reviewAssignments.reviewer'])
            ->latest()
            ->paginate(15);

        return view('reviews.admin-submissions', compact('submissions'));
    }

    /**
     * Admin: show submission details.
     */
    public function adminShow(Submission $submission): View
    {
        $submission->load(['author', 'reviews.reviewer', 'reviewAssignments.reviewer']);
        return view('reviews.admin-show', compact('submission'));
    }

    /**
     * Download submission file (reviewer or editor access).
     */
    public function downloadFile(Submission $submission): StreamedResponse
    {
        $user = request()->user();

        // Check if user is an editor (can download any submission)
        if ($user->isEditor()) {
            return $this->serializeFile($submission);
        }

        // Check if user is a reviewer assigned to this submission
        $isAssignedReviewer = ReviewAssignment::where('submission_id', $submission->id)
            ->where('reviewer_id', $user->id)
            ->exists();

        if ($isAssignedReviewer) {
            return $this->serializeFile($submission);
        }

        // Check if user is admin
        if ($user->isAdmin()) {
            return $this->serializeFile($submission);
        }

        abort(403);
    }

    /**
     * Helper method to download file.
     */
    private function serializeFile(Submission $submission): StreamedResponse
    {
        if (!$submission->file_path || !Storage::disk('local')->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download(
            $submission->file_path,
            $submission->file_name
        );
    }
}
