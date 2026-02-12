@extends('layouts.app')

@section('title', 'Submit Review')

@section('content')
<h1 class="text-2xl font-semibold mb-2">Submit Review</h1>
<p class="text-slate-600 mb-6">Submission: <strong>{{ $submission->title }}</strong> by {{ $submission->author->name }}</p>

<div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <h2 class="text-lg font-semibold text-blue-900 mb-4">Submission File</h2>
    @if($submission->file_path)
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-blue-700 mb-2"><strong>File:</strong> {{ $submission->file_name }}</p>
            </div>
            <a href="{{ route('submissions.download', ['submission' => $submission]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 inline-block">
                📥 Download File
            </a>
        </div>
    @else
        <p class="text-slate-500 italic">No file submitted.</p>
    @endif
</div>

<form method="POST" action="{{ route('reviews.store') }}" class="max-w-2xl space-y-4">
    @csrf
    <input type="hidden" name="review_assignment_id" value="{{ $assignment->id }}">
    <div>
        <label for="recommendation" class="block text-sm font-medium text-slate-700">Recommendation *</label>
        <select id="recommendation" name="recommendation" required
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach(\App\Models\Review::recommendationOptions() as $value => $label)
                <option value="{{ $value }}" {{ old('recommendation') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="comments_for_author" class="block text-sm font-medium text-slate-700">Comments for Author</label>
        <textarea id="comments_for_author" name="comments_for_author" rows="4"
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('comments_for_author') }}</textarea>
    </div>
    <div>
        <label for="comments_for_editor" class="block text-sm font-medium text-slate-700">Comments for Editor (confidential)</label>
        <textarea id="comments_for_editor" name="comments_for_editor" rows="4"
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('comments_for_editor') }}</textarea>
    </div>
    <div>
        <label for="rating" class="block text-sm font-medium text-slate-700">Rating (1-5, optional)</label>
        <input id="rating" type="number" name="rating" min="1" max="5" value="{{ old('rating') }}"
            class="mt-1 block w-20 rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Submit Review</button>
        <a href="{{ route('reviews.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-md hover:bg-slate-300">Cancel</a>
    </div>
</form>
@endsection
