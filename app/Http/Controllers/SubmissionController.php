<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $submissions = $request->user()
            ->submissionsAsAuthor()
            ->latest()
            ->paginate(15);

        return view('submissions.index', compact('submissions'));
    }

    public function create(): View
    {
        return view('submissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $file = $request->file('file');
        $path = $file->store('submissions/' . $request->user()->id, 'local');

        Submission::create([
            'author_id' => $request->user()->id,
            'title' => $validated['title'],
            'abstract' => $validated['abstract'],
            'keywords' => $validated['keywords'] ?? null,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'status' => Submission::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);

        return redirect()->route('submissions.index')->with('success', 'Submission created successfully.');
    }

    public function show(Submission $submission): View|RedirectResponse
    {
        $this->authorizeView($submission);
        $submission->load(['author', 'reviews.reviewer', 'reviewAssignments.reviewer']);

        return view('submissions.show', compact('submission'));
    }

    public function edit(Submission $submission): View|RedirectResponse
    {
        $this->authorizeView($submission);
        if (! $submission->isEditableByAuthor()) {
            return redirect()->route('submissions.show', $submission)
                ->with('error', 'This submission can no longer be edited.');
        }

        return view('submissions.edit', compact('submission'));
    }

    public function update(Request $request, Submission $submission): RedirectResponse
    {
        $this->authorizeView($submission);
        if (! $submission->isEditableByAuthor()) {
            return redirect()->route('submissions.show', $submission)
                ->with('error', 'This submission can no longer be edited.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $data = [
            'title' => $validated['title'],
            'abstract' => $validated['abstract'],
            'keywords' => $validated['keywords'] ?? null,
        ];

        if ($request->hasFile('file')) {
            if ($submission->file_path) {
                Storage::disk('local')->delete($submission->file_path);
            }
            $file = $request->file('file');
            $data['file_path'] = $file->store('submissions/' . $request->user()->id, 'local');
            $data['file_name'] = $file->getClientOriginalName();
        }

        $submission->update($data);

        return redirect()->route('submissions.show', $submission)->with('success', 'Submission updated.');
    }

    private function authorizeView(Submission $submission): void
    {
        $user = request()->user();
        if ($submission->author_id !== $user->id && ! $user->isEditor() && ! $user->isAdmin()) {
            abort(403);
        }
    }
}
