<?php

namespace App\Http\Controllers;

use App\Models\LayoutEditorAssignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagingEditorController extends Controller
{
    public function dashboard(): View
{
    $submissions = Submission::with('author')
        ->where('managing_editor_id', auth()->id())
        ->orderBy('updated_at', 'desc')
        ->get();

    $stats = [
        'pending'   => $submissions->filter(fn($s) => is_null($s->managing_editor_status) || $s->managing_editor_status === 'pending')->count(),
        'ctf_sent'  => $submissions->where('managing_editor_status', 'ctf_sent')->count(),
        'forwarded' => $submissions->where('managing_editor_status', 'forwarded')->count(),
        'total'     => $submissions->count(),
    ];

    $layoutEditors = User::whereHas('roles', fn($q) => $q->where('name', 'layout-editor'))->get();

    return view('managing-editor.dashboard', compact('submissions', 'stats', 'layoutEditors'));
}
    /**
     * Generate / mark Copyright Transfer Form as sent.
     */
    public function generateCtf(Submission $submission): RedirectResponse
    {
        if ($submission->managing_editor_id !== auth()->id()) {
            abort(403);
        }

        $submission->update([
            'managing_editor_status' => 'ctf_sent',
            'ctf_sent_at'            => now(),
        ]);

        \App\Models\Notification::create([
            'user_id'         => $submission->author_id,
            'title'           => '📄 Copyright Transfer Form',
            'message'         => "A Copyright Transfer Form has been issued for your manuscript \"{$submission->title}\". Please check your email.",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        return redirect()
            ->route('managing-editor.dashboard')
            ->with('success', 'Copyright Transfer Form has been sent to the author.');
    }

    /**
     * Assign a Layout Editor and forward the manuscript.
     */
    public function forwardToLayout(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->managing_editor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'layout_editor_id' => ['required', 'exists:users,id'],
        ]);

        // Create layout editor assignment
        LayoutEditorAssignment::create([
            'submission_id'    => $submission->id,
            'layout_editor_id' => $request->input('layout_editor_id'),
            'assigned_at'      => now(),
            'status'           => LayoutEditorAssignment::STATUS_PENDING,
        ]);

        $submission->update([
            'managing_editor_status' => 'forwarded',
            'forwarded_to_layout_at' => now(),
            'status'                 => Submission::STATUS_LAYOUT_EDITING,
        ]);

        \App\Models\Notification::create([
            'user_id'         => $request->input('layout_editor_id'),
            'title'           => '📋 New Layout Assignment',
            'message'         => "You have been assigned to do layout editing for \"{$submission->title}\".",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        return redirect()
            ->route('managing-editor.dashboard')
            ->with('success', 'Manuscript forwarded to Layout Editor.');
    }

    public function show(Submission $submission): View
{
    // Only the assigned managing editor can view
    if ($submission->managing_editor_id !== auth()->id()) {
        abort(403);
    }

    $submission->load(['author', 'assignedEditor']);

    return view('managing-editor.show', compact('submission'));
}
public function showLayout(Submission $submission): View
{
    if ($submission->managing_editor_id !== auth()->id()) {
        abort(403);
    }

    $submission->load(['author', 'assignedEditor', 'layoutEditorAssignments.layoutEditor']);

    // Get the latest completed layout assignment
    $layoutAssignment = $submission->layoutEditorAssignments()
        ->where('status', LayoutEditorAssignment::STATUS_COMPLETED)
        ->latest('completed_at')
        ->first();

    return view('managing-editor.show-layout', compact('submission', 'layoutAssignment'));
}

public function approveLayout(Submission $submission): RedirectResponse
{
    if ($submission->managing_editor_id !== auth()->id()) {
        abort(403);
    }

    $submission->update(['status' => Submission::STATUS_LAYOUT_REVIEW]);

    // Notify assigned editor
    $editor = $submission->assignedEditor;
    if ($editor) {
        \App\Models\Notification::create([
            'user_id'         => $editor->id,
            'title'           => '✅ Layout Approved by Managing Editor',
            'message'         => "The managing editor has approved the layout for \"{$submission->title}\". Please review and send to author for final confirmation.",
            'type'            => 'success',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    return redirect()
        ->route('managing-editor.dashboard')
        ->with('success', 'Layout approved and editor has been notified.');
}
public function downloadLayout(Submission $submission)
{
    if ($submission->managing_editor_id !== auth()->id()) {
        abort(403);
    }

    $layoutAssignment = $submission->layoutEditorAssignments()
        ->where('status', LayoutEditorAssignment::STATUS_COMPLETED)
        ->latest('completed_at')
        ->first();

    if (!$layoutAssignment || !$layoutAssignment->layout_file_path) {
        abort(404, 'Layout file not found.');
    }

    return response()->download(
        \Illuminate\Support\Facades\Storage::disk('local')->path($layoutAssignment->layout_file_path),
        $layoutAssignment->layout_file_name ?? 'layout.pdf'
    );
}

}