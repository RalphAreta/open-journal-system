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
            <p class="text-sm text-slate-500">Author</p>
            <p>{{ $submission->author->name }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Submitted</p>
            <p>{{ $submission->submitted_at?->format('F j, Y') ?? '-' }}</p>
        </div>
        @if($submission->keywords)
            <div>
                <p class="text-sm text-slate-500">Keywords</p>
                <p>{{ $submission->keywords }}</p>
            </div>
        @endif
        <div>
            <p class="text-sm text-slate-500">Abstract</p>
            <p class="text-slate-700">{{ $submission->abstract }}</p>
        </div>
        @if($submission->file_name)
            <div>
                <p class="text-sm text-slate-500">File</p>
                <p>{{ $submission->file_name }}</p>
            </div>
        @endif
        @if($submission->editor_notes && (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
            <div class="border-t pt-4">
                <p class="text-sm text-slate-500">Editor notes</p>
                <p class="text-slate-700">{{ $submission->editor_notes }}</p>
            </div>
        @endif
        @if($submission->reviews->isNotEmpty() && (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
            <div class="border-t pt-4">
                <p class="text-sm font-medium text-slate-700 mb-2">Reviews</p>
                @foreach($submission->reviews as $r)
                    <div class="mb-4 p-3 bg-slate-50 rounded">
                        <p class="text-sm text-slate-500">Reviewer: {{ $r->reviewer->name }} — Recommendation: {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}</p>
                        @if($r->comments_for_author && (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
                            <p class="mt-2 text-slate-700">{{ $r->comments_for_author }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="mt-4 flex gap-2">
        @if($submission->isEditableByAuthor() && auth()->user()->id === $submission->author_id)
            <a href="{{ route('submissions.edit', $submission) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Edit</a>
        @endif
        <a href="{{ route('submissions.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-md hover:bg-slate-300">Back to list</a>
    </div>
</div>
@endsection
