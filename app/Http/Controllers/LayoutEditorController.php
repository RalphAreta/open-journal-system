<?php

namespace App\Http\Controllers;

use App\Models\LayoutEditorAssignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LayoutEditorController extends Controller
{
    /**
     * Show layout editor dashboard with pending assignments
     */
  public function dashboard(Request $request): View
{
    $user = $request->user();

    $assignments = LayoutEditorAssignment::where('layout_editor_id', $user->id)
        ->with(['submission.author'])
        ->latest('assigned_at')
        ->paginate(15);

    $inProgressCount = LayoutEditorAssignment::where('layout_editor_id', $user->id)
        ->where('status', LayoutEditorAssignment::STATUS_IN_PROGRESS)
        ->count();

    $completedCount = LayoutEditorAssignment::where('layout_editor_id', $user->id)
        ->where('status', LayoutEditorAssignment::STATUS_COMPLETED)
        ->count();

    $pendingReviewCount = LayoutEditorAssignment::where('layout_editor_id', $user->id)
        ->where('status', LayoutEditorAssignment::STATUS_PENDING)
        ->count();

    // ← DAGDAG DITO bago ang return
    $revisionAssignments = LayoutEditorAssignment::with(['submission.author'])
        ->where('layout_editor_id', $user->id)
        ->where('status', LayoutEditorAssignment::STATUS_PENDING)
        ->where('notes', 'like', 'Author revision request:%')
        ->get();

    return view('layout-editor.dashboard', [
        'assignments'        => $assignments,
        'inProgressCount'    => $inProgressCount,
        'completedCount'     => $completedCount,
        'pendingReviewCount' => $pendingReviewCount,
        'revisionAssignments' => $revisionAssignments, // ← dagdag
    ]);
}
    /**
     * Show a specific layout assignment details
     */
    public function show($id, Request $request): View
    {
        $user = $request->user();
        $assignment = LayoutEditorAssignment::findOrFail($id);

        // Log for debugging
        Log::info('LayoutEditorController::show() called', [
            'user_id' => $user->id ?? null,
            'user_name' => $user->name ?? null,
            'assignment_id' => $assignment->id,
            'assignment.layout_editor_id' => $assignment->layout_editor_id,
            'match' => ($assignment->layout_editor_id === $user->id),
        ]);

        // Check if this layout assignment belongs to the user
        if ($assignment->layout_editor_id !== $user->id) {
            Log::error('Authorization failed', [
                'expected_editor_id' => $assignment->layout_editor_id,
                'actual_user_id' => $user->id,
            ]);
            abort(403, 'You are not authorized to view this assignment.');
        }

        $submission = $assignment->submission;

        return view('layout-editor.show', [
            'assignment' => $assignment,
            'submission' => $submission,
            'paper' => [
                'id' => $submission->id,
                'title' => $submission->title,
                'abstract' => $submission->abstract,
                'category' => $submission->research_field,
                'author' => $submission->author->name ?? 'Anonymous',
            ]
        ]);
    }

    /**
     * Download the file from editor
     */
    public function downloadFile($id, Request $request)
    {
        $user = $request->user();
        $assignment = LayoutEditorAssignment::findOrFail($id);

        if ($assignment->layout_editor_id !== $user->id) {
            abort(403, 'You are not authorized to download this file.');
        }

        $submission = $assignment->submission;

        if (!$submission) {
            abort(404, 'Submission not found.');
        }

        if (!$submission->file_path) {
            abort(404, 'No file attached to this submission.');
        }

        $disk = Storage::disk('local');

        if (!$disk->exists($submission->file_path)) {
            Log::error('File not found', [
                'file_path' => $submission->file_path,
                'disk_root' => $disk->path(''),
                'full_path' => $disk->path($submission->file_path),
            ]);
            abort(404, 'File not found: ' . $submission->file_path);
        }

        // Update status to in_progress if pending
        if ($assignment->status === LayoutEditorAssignment::STATUS_PENDING) {
            $assignment->update([
                'status' => LayoutEditorAssignment::STATUS_IN_PROGRESS,
                'started_at' => now(),
            ]);
        }

        return response()->download(
            $disk->path($submission->file_path),
            $submission->file_name ?? 'document.pdf'
        );
    }

    /**
     * Upload edited file
     */
 public function uploadFile(Request $request, $id): RedirectResponse
{
    $user = $request->user();
    $assignment = LayoutEditorAssignment::findOrFail($id);

    if ($assignment->layout_editor_id !== $user->id) {
        abort(403);
    }

    $request->validate([
        'file'  => 'required|mimes:pdf|max:51200', // Max 50MB
        'notes' => 'nullable|string|max:1000',
    ]);

    // Store the layout editor's version
    $file     = $request->file('file');
    $filename = 'layout-' . $assignment->submission_id . '-' . time() . '.' . $file->getClientOriginalExtension();
    $path     = $file->storeAs('layouts', $filename, 'local');

    // Update assignment
    $assignment->update([
        'layout_file_path' => $path,
        'layout_file_name' => $file->getClientOriginalName(),
        'notes'            => $request->input('notes'),
        'status'           => LayoutEditorAssignment::STATUS_COMPLETED,
        'completed_at'     => now(),
    ]);

   // Update submission status
$submission = $assignment->submission;
$submission->update(['status' => Submission::STATUS_LAYOUT_REVIEW]);

$notes = $request->input('notes');
$notesPart = $notes
    ? "\n\nLayout Editor's Notes:\n\"{$notes}\""
    : "";

// Notify Managing Editor (NOT editor/author yet)
$managingEditor = $submission->managingEditor;
if ($managingEditor) {
    \App\Models\Notification::create([
        'user_id'         => $managingEditor->id,        'role'            => 'managing-editor',        'title'           => '🎨 Layout File Ready for Review',
'message' => "The layout editor has completed formatting \"{$submission->title}\". Go to your dashboard and click 'Review Layout' to view and download the file.{$notesPart}",
        'type'            => 'info',
        'notifiable_id'   => $submission->id,
        'notifiable_type' => \App\Models\Submission::class,
    ]);
}

   // Notify author
$author = $submission->author;
if ($author) {
    $notes = $request->input('notes');
    $notesPart = $notes
        ? "\n\nLayout Editor's Notes:\n\"{$notes}\""
        : "\n\nNo additional notes were provided by the layout editor.";

    \App\Models\Notification::create([
        'user_id'         => $author->id,
        'role'            => 'author',
        'title'           => '🎨 Layout Version Ready for Review',
       'message' => "The layout editor has completed formatting \"{$submission->title}\". Go to your dashboard and click 'Review Layout' to view and download the file.{$notesPart}",
        'type'            => 'info',
        'notifiable_id'   => $submission->id,
        'notifiable_type' => \App\Models\Submission::class,
    ]);
}

    return redirect()->route('layout-editor.dashboard')
        ->with('success', 'Layout file uploaded successfully. Waiting for editor review.');
}

    /**
     * Download the layout file created by layout editor
     */
    public function downloadLayoutFile($id, Request $request)
    {
        $user = $request->user();
        $assignment = LayoutEditorAssignment::findOrFail($id);

        // Editor can download the layout file
        $submission = $assignment->submission;
        $isEditor = $user->id === $submission->assigned_editor_id || $user->isEditor();

        if ($assignment->layout_editor_id !== $user->id && !$isEditor) {
            abort(403);
        }

        if (!$assignment->layout_file_path || !Storage::disk('local')->exists($assignment->layout_file_path)) {
            abort(404, 'Layout file not found.');
        }

        return response()->download(
            Storage::disk('local')->path($assignment->layout_file_path),
            $assignment->layout_file_name
        );
    }
}
