<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\Submission;
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

        // Check if an appeal already exists
        $existingAppeal = Appeal::where('submission_id', $submission->id)->first();
        if ($existingAppeal) {
            return redirect()->back()->with('error', 'You have already submitted an appeal for this submission.');
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
        ]);

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
                'initial_screening_comments' => 'Appeal approved. Manuscript moved to review stage.',
            ]);
            
            $message = 'Appeal approved. The submission will now proceed to the review stage.';
        } else {
            $message = 'Appeal rejected. The author has been notified.';
        }

        return redirect()->route('appeals.index')
            ->with('success', $message);
    }
}
