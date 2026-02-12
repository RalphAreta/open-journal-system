@extends('layouts.app')

@section('title', 'Manage Submission')

@section('content')
<div class="max-w-4xl">
    <h1 class="text-2xl font-semibold mb-6">{{ $submission->title }}</h1>
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6 space-y-4 mb-6">
        <p><span class="text-slate-500">Author:</span> {{ $submission->author->name }}</p>
        <p><span class="text-slate-500">Status:</span> <span class="px-2 py-1 rounded-full bg-slate-100">{{ $submission->status }}</span></p>
        <p><span class="text-slate-500">Abstract:</span> {{ $submission->abstract }}</p>
        
        <div class="border-t pt-4">
            <p class="font-medium text-slate-700 mb-3">Submission File</p>
            @if($submission->file_path)
                <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded">
                    <div>
                        <p class="text-sm text-blue-700"><strong>File:</strong> {{ $submission->file_name }}</p>
                    </div>
                    <a href="{{ route('submissions.download', ['submission' => $submission]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 inline-block text-sm">
                        📥 Download
                    </a>
                </div>
            @else
                <p class="text-slate-500 italic">No file submitted.</p>
            @endif
        </div>

        @if($submission->reviews->isNotEmpty())
            <div class="border-t pt-4">
                <p class="font-medium text-slate-700 mb-2">Reviews</p>
                @foreach($submission->reviews as $r)
                    <div class="mb-3 p-3 bg-slate-50 rounded">
                        <p class="text-sm"><strong>{{ $r->reviewer->name }}</strong> — {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}</p>
                        @if($r->comments_for_editor)<p class="mt-1 text-slate-600 text-sm">{{ $r->comments_for_editor }}</p>@endif
                        @if($r->comments_for_author)<p class="mt-1 text-slate-500 text-sm">For author: {{ Str::limit($r->comments_for_author, 100) }}</p>@endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if(in_array($submission->status, ['submitted', 'under_review', 'revisions_requested']))
        <div class="bg-white rounded-lg shadow border border-slate-200 p-6 mb-6">
            <h2 class="text-lg font-medium mb-4">Assign Reviewer</h2>
            <form method="POST" action="{{ route('editor.assign-reviewer', $submission) }}" class="flex gap-2 flex-wrap items-end">
                @csrf
                <div>
                    <label for="reviewer_id" class="block text-sm text-slate-600">Reviewer</label>
                    <select id="reviewer_id" name="reviewer_id" required class="rounded-md border-slate-300 shadow-sm">
                        <option value="">Select...</option>
                        @foreach(\App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'reviewer'))->get() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="due_at" class="block text-sm text-slate-600">Due date</label>
                    <input type="date" name="due_at" id="due_at" class="rounded-md border-slate-300 shadow-sm">
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Assign</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow border border-slate-200 p-6">
            <h2 class="text-lg font-medium mb-4">Editor Decision</h2>
            <form method="POST" action="{{ route('editor.decision', $submission) }}" class="space-y-4">
                @csrf
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700">Decision</label>
                    <select id="status" name="status" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
                        <option value="accepted">Accept</option>
                        <option value="rejected">Reject</option>
                        <option value="revisions_requested">Revisions Requested</option>
                    </select>
                </div>
                <div>
                    <label for="editor_notes" class="block text-sm font-medium text-slate-700">Notes (optional)</label>
                    <textarea id="editor_notes" name="editor_notes" rows="3" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">{{ old('editor_notes') }}</textarea>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Record Decision</button>
            </form>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('editor.submissions') }}" class="text-indigo-600 hover:underline">← Back to submissions</a>
    </div>
</div>
@endsection
