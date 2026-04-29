<?php
// app/Http/Controllers/ManagingEditor/VolumeController.php

namespace App\Http\Controllers\ManagingEditor;

use App\Http\Controllers\Controller;
use App\Models\Volume;
use App\Models\Issue;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    // Show all volumes + issues (rendered inside ME dashboard or its own page)
    public function index()
    {
        $volumes = Volume::with('issues')->orderByDesc('number')->get();
        return view('managing-editor.volumes.index', compact('volumes'));
    }

    // Store a new volume
    public function storeVolume(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|integer|min:1|unique:volumes,number',
            'year'   => 'required|integer|min:1900|max:2100',
        ]);

        Volume::create($data);

        return back()->with('success', "Volume {$data['number']} ({$data['year']}) created.");
    }

 public function storeIssue(Request $request, Volume $volume)
{
    $data = $request->validate([
        'number'      => "nullable|integer|min:1|unique:issues,number,NULL,id,volume_id,{$volume->id}",
        'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
    ]);

    $path = null;
    if ($request->hasFile('cover_image')) {
        $path = $request->file('cover_image')
            ->store("covers/vol-{$volume->number}", 'public');
    }

    $volume->issues()->create([
        'number'      => $data['number'] ?? null,
        'cover_image' => $path,
    ]);

    $issueLabel = $data['number'] ? "Issue {$data['number']}" : "a new issue";
    return back()->with('success', "{$issueLabel} added to Volume {$volume->number}.");
}

    // Upload / replace cover image for an existing issue
    public function uploadCover(Request $request, Issue $issue)
    {
        $request->validate([
            'cover_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Delete old file if exists
        if ($issue->cover_image) {
            \Storage::disk('public')->delete($issue->cover_image);
        }

        $path = $request->file('cover_image')
            ->store("covers/vol-{$issue->volume->number}", 'public');

        $issue->update(['cover_image' => $path]);

        return back()->with('success', "Cover image updated for Issue {$issue->number}.");
    }
}