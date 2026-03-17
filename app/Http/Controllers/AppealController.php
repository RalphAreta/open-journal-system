<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppealController extends Controller
{
    /**
     * Store a new appeal for a rejected submission.
     */
    public function store(Request $request, Submission $submission): RedirectResponse
    {
        // Verify the user is the author
        if ($submission->author_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Verify the submission is rejected at initial screening
        if ($submission->initial_screening_status !== Submission::SCREENING_STATUS_FAILED) {
            return redirect()->back()->with('error', 'This submission is not eligible for appeal.');
        }

        // Check if max appeals have been reached
        $appealCount = Appeal::where('submission_id', $submission->id)->count();
        if ($appealCount >= Appeal::MAX_APPEALS) {
            return redirect()->back()->with('error', 'You have exhausted the maximum number of appeals for this submission.');
        }

        // Validate the request
        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:50', 'max:2000'],
        ], [
            'reason.required' => 'Please provide your appeal reason.',
            'reason.min' => 'Your appeal reason must be at least 50 characters.',
            'reason.max' => 'Your appeal reason cannot exceed 2000 characters.',
        ]);

        // Create the appeal
        Appeal::create([
            'submission_id' => $submission->id,
            'author_id' => auth()->id(),
            'reason' => $validated['reason'],
            'status' => Appeal::STATUS_PENDING,
        ]);

        // Notify editor-in-chief of the new appeal
        $chiefEditors = User::whereHas('roles', fn ($q) => $q->where('name', 'editor-in-chief'))->get();
        foreach ($chiefEditors as $chiefEditor) {
            \App\Models\Notification::create([
                'user_id'    => $chiefEditor->id,
                'role'       => 'editor-in-chief',
                'title'      => '📋 New Appeal Submitted',
                'message'    => "Author {$submission->author->name} has submitted an appeal for manuscript: {$submission->title}",
            ]);
        }

        return redirect()->route('submissions.show', $submission)
            ->with('success', 'Your appeal has been submitted successfully. The editor will review it shortly.');
    }

    /**
     * Get appeals for the editor to review.
     */
    public function index(): View
    {
        $appeals = Appeal::with(['submission', 'author'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('appeals.index', compact('appeals'));
    }

    /**
     * Show appeal review form.
     */
    public function show(Appeal $appeal): View
    {
        return view('appeals.show', compact('appeal'));
    }

    /**
     * Update appeal status (approve or reject).
     */
    public function update(Request $request, Appeal $appeal): RedirectResponse
    {
        // Verify the user is an editor-in-chief
        if (!auth()->user()->isEditorInChief()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'editor_response' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'editor_response.required' => 'Please provide a response to the appeal.',
            'editor_response.min' => 'Your response must be at least 10 characters.',
        ]);

        // Check rejection count BEFORE updating (this counts existing rejected appeals)
        $rejectedCountBeforeUpdate = Appeal::where('submission_id', $appeal->submission_id)
            ->where('status', Appeal::STATUS_REJECTED)
            ->count();

        // Update the appeal
        $appeal->update([
            'status' => $validated['status'],
            'editor_response' => $validated['editor_response'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // If approved, update submission status to pass initial screening
        if ($validated['status'] === Appeal::STATUS_APPROVED) {
            $appeal->submission->update([
                'initial_screening_status' => Submission::SCREENING_STATUS_PASSED,
            ]);

            // Notify author of appeal approval
            \App\Models\Notification::create([
                'user_id'    => $appeal->author_id,
                'role'       => 'author',
                'title'      => '✅ Appeal Approved',
                'message'    => "Your appeal for '{$appeal->submission->title}' has been approved. Your manuscript will now proceed to the review stage.",
            ]);

            $message = 'Appeal approved. The submission will now proceed to the review stage.';
        } else if ($validated['status'] === Appeal::STATUS_REJECTED) {
            // If this is a rejection, check if we've reached max rejections
            // rejectedCountBeforeUpdate = count of already rejected appeals
            // If this count is already >= MAX_APPEALS - 1, then after this rejection we'll be AT or OVER MAX
            if ($rejectedCountBeforeUpdate >= Appeal::MAX_APPEALS - 1) {
                // This is the final rejection - mark submission as REJECTED
                $appeal->submission->update([
                    'status' => Submission::STATUS_REJECTED,
                    'initial_screening_status' => Submission::SCREENING_STATUS_FAILED,
                ]);
                $message = 'Appeal rejected. The submission has completed the appeal process and cannot be appealed further.';
                $appealNum = 'final';
            } else {
                // Author still has appeals remaining
                $message = 'Appeal rejected. The author may submit one additional appeal.';
                $appealNum = 'first';
            }

            // Notify author of appeal rejection
            \App\Models\Notification::create([
                'user_id'    => $appeal->author_id,
                'role'       => 'author',
                'title'      => '❌ Appeal Rejected',
                'message'    => "Your $appealNum appeal for '{$appeal->submission->title}' has been reviewed and rejected. Editor's response: {$validated['editor_response']}",
            ]);
        }

        return redirect()->route('appeals.index')
            ->with('success', $message);
    }
}
