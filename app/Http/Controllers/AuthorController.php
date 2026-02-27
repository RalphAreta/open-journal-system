<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\LayoutEditorAssignment;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * View layout editor feedback and notes
     */
    public function viewLayoutFeedback(Submission $submission): View
    {
        // Check if user is the author
        if ($submission->author_id !== request()->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        // Get the layout assignment(s) - layout editor work is available once completed
        $layoutAssignments = $submission->layoutEditorAssignments()
            ->where('status', 'completed')
            ->with(['layoutEditor'])
            ->get();

        if ($layoutAssignments->isEmpty()) {
            abort(404, 'No layout editor feedback available yet.');
        }

        return view('author.layout-feedback', compact('submission', 'layoutAssignments'));
    }

    /**
     * View final layout for author confirmation
     */
    public function viewFinalLayout(Submission $submission): View
    {
        // Check if user is the author
        if ($submission->author_id !== request()->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        // Allow viewing if in author confirmation status OR if layout is completed and layout-editing/layout-review status
        $allowedStatuses = [
            Submission::STATUS_AUTHOR_CONFIRMATION,
            Submission::STATUS_LAYOUT_EDITING,
            Submission::STATUS_LAYOUT_REVIEW,
        ];

        if (!in_array($submission->status, $allowedStatuses)) {
            abort(403, 'This submission is not ready for your review.');
        }

        // Get the layout assignment
        $layoutAssignment = $submission->layoutEditorAssignments()
            ->where('status', 'completed')
            ->first();

        if (!$layoutAssignment) {
            abort(403, 'Layout file is not ready yet.');
        }

        return view('author.final-layout', compact('submission', 'layoutAssignment'));
    }

    /**
     * Download layout file as author
     */
    public function downloadLayout(Submission $submission)
    {
        // Check if user is the author
        if ($submission->author_id !== request()->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        // Get the layout assignment
        $layoutAssignment = $submission->layoutEditorAssignments()->first();

        if (!$layoutAssignment || !$layoutAssignment->layout_file_path) {
            abort(404, 'Layout file not found.');
        }

        if (!Storage::disk('local')->exists($layoutAssignment->layout_file_path)) {
            abort(404, 'File not found.');
        }

        return response()->download(
            Storage::disk('local')->path($layoutAssignment->layout_file_path),
            $layoutAssignment->layout_file_name
        );
    }
}
