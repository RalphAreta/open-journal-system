@extends('layouts.app')

@section('title', 'Manage Submission')

@section('content')
<div class="max-w-4xl">
    <h1 class="text-2xl font-semibold mb-6">{{ $submission->title }}</h1>
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6 space-y-4 mb-6">
        <p><span class="text-slate-700 font-medium">Author:</span> <span class="text-slate-900">{{ $submission->author->name }}</span></p>
        <p><span class="text-slate-700 font-medium">Status:</span> <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-900">{{ $submission->status }}</span></p>
        <p><span class="text-slate-700 font-medium">Abstract:</span> <span class="text-slate-900">{{ $submission->abstract }}</span></p>
        
        <div class="border-t pt-4">
            <p class="font-medium text-slate-900 mb-3">Submission File</p>
            @if($submission->file_path)
                <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded">
                    <div>
                        <p class="text-sm text-blue-900"><strong>File:</strong> {{ $submission->file_name }}</p>
                    </div>
                    <a href="{{ route('submissions.download', ['submission' => $submission]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                        Download file
                    </a>
                </div>
            @else
                <p class="text-slate-700 italic">No file submitted.</p>
            @endif
        </div>

        @if($submission->reviews->isNotEmpty())
            <div class="border-t pt-4">
                <p class="font-medium text-slate-900 mb-2">Reviews</p>
                @foreach($submission->reviews as $r)
                    <div class="mb-3 p-3 bg-slate-50 rounded">
                        <p class="text-sm text-slate-900"><strong>{{ $r->reviewer->name }}</strong> — {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}</p>
                        @if($r->comments_for_editor)<p class="mt-1 text-slate-700 text-sm">{{ $r->comments_for_editor }}</p>@endif
                        @if($r->comments_for_author)<p class="mt-1 text-slate-700 text-sm">For author: {{ Str::limit($r->comments_for_author, 100) }}</p>@endif
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
                    <label for="reviewer_id" class="block text-sm text-slate-700 font-medium">Reviewer</label>
                    <select id="reviewer_id" name="reviewer_id" required class="rounded-md border-slate-300 shadow-sm">
                        <option value="">Select...</option>
                        @foreach(\App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'reviewer'))->get() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="due_at" class="block text-sm text-slate-700 font-medium">Due date</label>
                    <input type="date" name="due_at" id="due_at" class="rounded-md border-slate-300 shadow-sm">
                </div>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium shadow-sm transition-colors">Assign</button>
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
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium shadow-sm transition-colors">Record Decision</button>
            </form>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('editor.submissions') }}" class="text-red-600 hover:text-red-700 hover:underline font-medium">← Back to submissions</a>
    </div>
</div>
@endsection
