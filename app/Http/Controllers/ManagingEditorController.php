<?php

namespace App\Http\Controllers;

use App\Models\LayoutEditorAssignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\CtfTemplate;
use Illuminate\Support\Facades\Storage;

class ManagingEditorController extends Controller
{
    public function dashboard(): View
{
    $submissions = Submission::with('author')
        ->where('managing_editor_id', Auth::id())
        ->orderBy('updated_at', 'desc')
        ->limit(1)
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
  public function generateCtf(Request $request, Submission $submission): RedirectResponse
{
    if ($submission->managing_editor_id !== Auth::id()) {
        abort(403);
    }

    $template = CtfTemplate::latest()->first();
    if (!$template) {
        return back()->with('error', 'No CTF template uploaded yet. Please upload one first.');
    }

    $submission->update([
        'managing_editor_status' => 'ctf_sent',
        'ctf_sent_at'            => now(),
    ]);

    // Only notify immediately if template is already released
    if ($template->is_released) {
        \App\Models\Notification::create([
            'user_id'         => $submission->author_id,
            'role'            => 'author',
            'title'           => '📄 Copyright Transfer Form Available',
            'message'         => "The Copyright Transfer Form for your manuscript \"{$submission->title}\" is now available for download. Please download, sign, and return it.",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    return redirect()
        ->route('managing-editor.dashboard')
        ->with('success', $template->is_released
            ? 'CTF sent — author has been notified.'
            : 'Manuscript marked for CTF. Author will be notified once you release the template.'
        );
}
    /**
     * Assign a Layout Editor and forward the manuscript.
     */
   public function forwardToLayout(Request $request, Submission $submission): RedirectResponse
{
    if ($submission->managing_editor_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'layout_editor_id' => ['required', 'exists:users,id'],
    ]);

    // ← dagdag dito, pagkatapos ng validate
    if ($submission->managing_editor_status !== 'ctf_returned') {
        return back()->with('error', 'Cannot forward until the author returns the signed CTF.');
    }

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
        'role'            => 'layout-editor',
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
    if ($submission->managing_editor_id !== Auth::id()) {
        abort(403);
    }

    $submission->load(['author', 'assignedEditor']);

    return view('managing-editor.show', compact('submission'));
}
public function showLayout(Submission $submission): View
{
    if ($submission->managing_editor_id !== Auth::id()) {
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
    if ($submission->managing_editor_id !== Auth::id()) {
        abort(403);
    }

    $layoutAssignment = $submission->layoutEditorAssignments()
        ->where('status', LayoutEditorAssignment::STATUS_COMPLETED)
        ->latest('completed_at')
        ->first();

    $submission->update(['status' => Submission::STATUS_AUTHOR_CONFIRMATION]);

    // Notify assigned editor
    $editor = $submission->assignedEditor;
    if ($editor) {
        \App\Models\Notification::create([
            'user_id'         => $editor->id,
            'role'            => 'editor',
            'title'           => '✅ Layout Approved — Action Required',
            'message'         => "The managing editor has approved the layout for \"{$submission->title}\". Please review and send to the author for final confirmation.",
            'type'            => 'success',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    // Notify author
    $author = $submission->author;
    if ($author) {
        $layoutEditorName = $layoutAssignment?->layoutEditor->name ?? 'the layout editor';
        $fileName = $layoutAssignment?->layout_file_name ?? 'layout file';
        $notes = $layoutAssignment?->notes;
        $notesPart = $notes ? "\n\nLayout Editor's Notes:\n\"{$notes}\"" : "";

        \App\Models\Notification::create([
            'user_id'         => $author->id,
            'role'            => 'author',
            'title'           => '🎨 Layout Ready — Please Review',
            'message'         => "Your manuscript \"{$submission->title}\" has been formatted by {$layoutEditorName}. The layout file \"{$fileName}\" is now ready for your final review and confirmation.{$notesPart}",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    // ✅ DAGDAG: Notify layout editor
    $layoutEditor = $layoutAssignment?->layoutEditor;
    if ($layoutEditor) {
        \App\Models\Notification::create([
            'user_id'         => $layoutEditor->id,
            'role'            => 'layout-editor',
            'title'           => '✅ Layout Approved by Managing Editor',
            'message'         => "Your layout work for \"{$submission->title}\" has been approved by the managing editor and forwarded to the author for final confirmation.",
            'type'            => 'success',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    return redirect()
        ->route('managing-editor.dashboard')
        ->with('success', 'Layout approved. Editor, author, and layout editor have been notified.');
}
public function downloadLayout(Submission $submission)
{
    if ($submission->managing_editor_id !== Auth::id()) {
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

public function downloadCtf(Submission $submission)
{
    if (Auth::id() !== $submission->author_id &&
        Auth::id() !== $submission->managing_editor_id) {
        abort(403);
    }
    if (!$submission->ctf_file_path) {
        abort(404, 'CTF file not found.');
    }
    return response()->download(
        \Illuminate\Support\Facades\Storage::disk('local')->path($submission->ctf_file_path),
        $submission->ctf_file_name ?? 'copyright-transfer-form.pdf'
    );
}

public function publishPaper(Submission $submission): RedirectResponse
{
    if ($submission->managing_editor_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    if ($submission->status !== Submission::STATUS_WITH_MANAGING_EDITOR ||
        $submission->managing_editor_status !== 'ready_to_publish') {
        return back()->with('error', 'This submission is not ready for publishing.');
    }

    // Get the latest completed layout assignment
    $layoutAssignment = $submission->layoutEditorAssignments()
        ->where('status', LayoutEditorAssignment::STATUS_COMPLETED)
        ->latest('completed_at')
        ->first();

    // Update submission to use layout editor's formatted file
    $updateData = [
        'status' => Submission::STATUS_PUBLISHED,
        'published_at' => now(),
        'managing_editor_status' => 'published',
    ];

    if ($layoutAssignment && $layoutAssignment->layout_file_path) {
        // Copy layout file details to submission for public download
        $updateData['file_path'] = $layoutAssignment->layout_file_path;
        $updateData['file_name'] = $layoutAssignment->layout_file_name;
        $updateData['layout_editor_assignment_id'] = $layoutAssignment->id;
    }

    // Publish the paper
    $submission->update($updateData);

    // Notify author of publication
    $author = $submission->author;
    if ($author) {
        \App\Models\Notification::create([
            'user_id'         => $author->id,
            'role'            => 'author',
            'title'           => '🎉 Paper Published Successfully!',
            'message'         => "Congratulations! Your manuscript \"{$submission->title}\" has been officially published and is now available to the public.",
            'type'            => 'success',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    // Notify assigned editor
    $editor = $submission->assignedEditor;
    if ($editor) {
        \App\Models\Notification::create([
            'user_id'         => $editor->id,
            'role'            => 'editor',
            'title'           => '📰 Paper Published',
            'message'         => "\"{$submission->title}\" has been published and is now live.",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    return redirect()
        ->route('managing-editor.dashboard')
        ->with('success', 'Paper published successfully!');
}
// Dagdag na method:
public function downloadSignedCtf(Submission $submission)
{
    if ($submission->managing_editor_id !== Auth::id()) {
        abort(403);
    }
    if (!$submission->ctf_signed_file_path) {
        abort(404, 'Signed CTF not found.');
    }
    return response()->download(
        \Illuminate\Support\Facades\Storage::disk('local')->path($submission->ctf_signed_file_path),
        $submission->ctf_signed_file_name ?? 'signed-ctf.pdf'
    );
}
public function reassignLayout(Request $request, Submission $submission)
{
    $request->validate([
        'layout_editor_id' => 'required|exists:users,id',
        'assignment_id'    => 'required|exists:layout_editor_assignments,id',
    ]);

    $oldAssignment = \App\Models\LayoutEditorAssignment::findOrFail($request->assignment_id);

    // ← I-clear ang author_status para mawala sa Author Responses
    \Illuminate\Support\Facades\DB::table('layout_editor_assignments')
        ->where('id', $oldAssignment->id)
        ->update([
            'status'         => \App\Models\LayoutEditorAssignment::STATUS_REJECTED,
            'author_status'  => null,
            'author_feedback' => null,
        ]);

    // Create new assignment with author's feedback as notes
    \App\Models\LayoutEditorAssignment::create([
        'submission_id'    => $submission->id,
        'layout_editor_id' => $request->layout_editor_id,
        'assigned_at'      => now(),
        'status'           => \App\Models\LayoutEditorAssignment::STATUS_PENDING,
        'notes'            => 'Author revision request: ' . $oldAssignment->author_feedback,
    ]);

    $submission->update(['status' => 'layout_editing']);

    // Notify layout editor
    \App\Models\Notification::create([
        'user_id'         => $request->layout_editor_id,
        'role'            => 'layout-editor',
        'title'           => '📋 New Layout Assignment',
        'message'         => "You have been assigned to revise the layout for \"{$submission->title}\". Author note: {$oldAssignment->author_feedback}",
        'type'            => 'info',
        'notifiable_id'   => $submission->id,
        'notifiable_type' => Submission::class,
    ]);

    return back()->with('success', 'Revision forwarded to layout editor with author\'s comments.');
}

public function ctfTemplate(): View
{
    $template = CtfTemplate::latest()->first();
    return view('managing-editor.dashboard', array_merge(
        $this->getDashboardData(),
        compact('template')
    ));
}

public function uploadCtfTemplate(Request $request): RedirectResponse
{
    $request->validate([
        'ctf_template_file' => 'required|mimes:pdf,doc,docx|max:51200',
    ]);

    // Delete old file if exists
    $old = CtfTemplate::latest()->first();
    if ($old) {
        Storage::disk('local')->delete($old->file_path);
        $old->delete();
    }

    $file     = $request->file('ctf_template_file');
    $filename = 'ctf-template-' . time() . '.' . $file->getClientOriginalExtension();
    $path     = $file->storeAs('ctf-templates', $filename, 'local');

    CtfTemplate::create([
        'file_path'   => $path,
        'file_name'   => $file->getClientOriginalName(),
        'is_released' => false,
        'uploaded_by' => Auth::id(),
    ]);

    return redirect()
        ->route('managing-editor.dashboard')
        ->with('success', 'CTF template uploaded successfully.');
}

public function toggleCtfRelease(Request $request): RedirectResponse
{
    $template = CtfTemplate::latest()->first();

    if (!$template) {
        return back()->with('error', 'No CTF template uploaded yet.');
    }

    // One-way only — ignore if already released
    if ($template->is_released) {
        return back()->with('info', 'CTF template is already released.');
    }

    $template->update([
        'is_released' => true,
        'released_at' => now(),
    ]);

    // Notify all authors with ctf_sent status
    $submissions = Submission::where('managing_editor_status', 'ctf_sent')
        ->whereNotNull('author_id')
        ->get();

    foreach ($submissions as $sub) {
        \App\Models\Notification::create([
            'user_id'         => $sub->author_id,
            'role'            => 'author',
            'title'           => '📄 Copyright Transfer Form Available',
            'message'         => "The Copyright Transfer Form for your manuscript \"{$sub->title}\" is now available for download. Please download, sign, and return it.",
            'type'            => 'info',
            'notifiable_id'   => $sub->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    return redirect()
        ->route('managing-editor.dashboard')
        ->with('success', 'CTF released to authors. All pending authors have been notified.');
}

public function downloadCtfTemplate(): mixed
{
    $template = CtfTemplate::latest()->first();

    if (!$template) {
        abort(404, 'No CTF template found.');
    }

    return response()->download(
        Storage::disk('local')->path($template->file_path),
        $template->file_name
    );
}

}
