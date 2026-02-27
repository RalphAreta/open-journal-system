<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\LayoutEditorAssignment;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * View final layout for author confirmation
     */
    public function viewFinalLayout(Submission $submission): View
    {
        // Check if user is the author
        if ($submission->author_id !== request()->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        // Only allow viewing if in author confirmation status
        if ($submission->status !== Submission::STATUS_AUTHOR_CONFIRMATION) {
            abort(403, 'This submission is not ready for your review.');
        }

        // Get the layout assignment
        $layoutAssignment = $submission->layoutEditorAssignments()->first();

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
