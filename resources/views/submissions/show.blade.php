@extends('layouts.app')

@section('title', $submission->title)

@section('content')
<div class="max-w-4xl">
    <div class="flex justify-between items-start mb-6">
        <h1 class="text-2xl font-semibold">{{ $submission->title }}</h1>
        <span class="px-3 py-1 rounded-full text-sm bg-slate-100">{{ $submission->status }}</span>
    </div>
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6 space-y-4">
        <div>
            <p class="text-sm text-slate-700 font-medium">Author</p>
            <p class="text-slate-900">{{ $submission->author->name }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-700 font-medium">Submitted</p>
            <p class="text-slate-900">{{ $submission->submitted_at?->format('F j, Y') ?? '-' }}</p>
        </div>
        @if($submission->keywords)
            <div>
                <p class="text-sm text-slate-700 font-medium">Keywords</p>
                <p class="text-slate-900">{{ $submission->keywords }}</p>
            </div>
        @endif
        <div>
            <p class="text-sm text-slate-700 font-medium">Abstract</p>
            <p class="text-slate-900">{{ $submission->abstract }}</p>
        </div>
        @if($submission->file_name)
            <div>
                <p class="text-sm text-slate-700 font-medium">File</p>
                <p class="text-slate-900">{{ $submission->file_name }}</p>
            </div>
        @endif
        @if($submission->editor_notes && (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
            <div class="border-t pt-4">
                <p class="text-sm text-slate-700 font-medium">Editor notes</p>
                <p class="text-slate-900">{{ $submission->editor_notes }}</p>
            </div>
        @endif

        @php
            $pendingRevisions = $submission->revisionRequests()->whereNull('revised_at')->count();
        @endphp
        @if ($pendingRevisions > 0 && auth()->user()->id === $submission->author_id)
            <div class="border-t pt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="font-semibold text-yellow-900">Revisions Requested</p>
                        <p class="text-sm text-yellow-800 mt-1">{{ $pendingRevisions }} revision{{ $pendingRevisions > 1 ? 's' : '' }} awaiting your response.</p>
                        <a href="{{ route('submissions.revisions', $submission) }}" class="inline-block mt-2 text-yellow-700 hover:text-yellow-900 font-semibold text-sm">
                            View & Submit Revisions →
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($submission->reviews->isNotEmpty() && (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
            <div class="border-t pt-4">
                <p class="text-sm font-medium text-slate-900 mb-2">Reviews</p>
                @foreach($submission->reviews as $r)
                    <div class="mb-4 p-3 bg-slate-50 rounded">
                        <p class="text-sm text-slate-700">Reviewer: {{ $r->reviewer->name }} — Recommendation: {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}</p>
                        @if($r->comments_for_author && (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
                            <p class="mt-2 text-slate-900">{{ $r->comments_for_author }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="mt-4 flex gap-2">
        @if($submission->isEditableByAuthor() && auth()->user()->id === $submission->author_id && $submission->status === 'submitted')
            <a href="{{ route('submissions.edit', $submission) }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium shadow-sm transition-colors">Edit</a>
        @endif
        <a href="{{ route('submissions.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-md hover:bg-slate-300">Back to list</a>
    </div>
</div>
@endsection
