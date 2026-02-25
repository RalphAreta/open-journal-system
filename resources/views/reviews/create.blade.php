@extends('layouts.app')

@section('title', 'Submit Review')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    {{-- Header Section --}}
    <div class="mb-10">
        <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
            <a href="{{ route('reviews.index') }}" class="hover:text-red-600 transition-colors">My Reviews</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
            <span class="text-slate-900 tracking-widest">Submit Review</span>
        </nav>
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter mb-2">
            Review Submission
        </h1>
        <p class="text-slate-600">{{ $submission->title }}</p>
    </div>

    {{-- Submission Info --}}
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6 mb-6">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Author</p>
                <p class="text-slate-900 font-semibold">{{ $submission->author->name }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Research Field</p>
                <span class="inline-block bg-red-50 border border-red-200 text-red-700 px-2 py-0.5 rounded-full text-sm">
                    {{ $submission->research_field ?? 'Not specified' }}
                </span>
            </div>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Abstract</p>
            <p class="text-slate-700 leading-relaxed">{{ $submission->abstract }}</p>
        </div>
    </div>

    {{-- Submission File --}}
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6 mb-6">
        <p class="text-xs font-bold text-slate-600 uppercase tracking-widest mb-4">Submission File</p>
        @if($submission->file_path)
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-700 mb-1">{{ $submission->file_name }}</p>
                    <p class="text-xs text-slate-500">PDF, DOC, or DOCX</p>
                </div>
                <a href="{{ route('submissions.download', ['submission' => $submission]) }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download file
                </a>
            </div>
        @else
            <p class="text-slate-700 italic text-sm">No file submitted.</p>
        @endif
    </div>

    {{-- Review Form --}}
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Submit Your Review</h2>

        <form method="POST" action="{{ route('reviews.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="review_assignment_id" value="{{ $assignment->id }}">

            {{-- Recommendation --}}
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-3">
                    Recommendation <span class="text-red-600">*</span>
                </label>
                <select id="recommendation" name="recommendation" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-white text-slate-900 font-medium focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all">
                    <option value="">— Select Recommendation —</option>
                    @foreach(\App\Models\Review::recommendationOptions() as $value => $label)
                        <option value="{{ $value }}" {{ old('recommendation') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('recommendation') <p class="text-red-600 text-xs font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Comments for Author --}}
            <div>
                <label for="comments_for_author" class="block text-sm font-semibold text-slate-900 mb-3">
                    Comments for Author
                </label>
                <textarea id="comments_for_author" name="comments_for_author" rows="5"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all resize-none"
                    placeholder="Provide constructive feedback for the author...">{{ old('comments_for_author') }}</textarea>
                @error('comments_for_author') <p class="text-red-600 text-xs font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Comments for Editor --}}
            <div>
                <label for="comments_for_editor" class="block text-sm font-semibold text-slate-900 mb-3">
                    Comments for Editor <span class="text-slate-500 font-normal text-xs">(confidential)</span>
                </label>
                <textarea id="comments_for_editor" name="comments_for_editor" rows="5"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all resize-none"
                    placeholder="Share any confidential notes with the editor...">{{ old('comments_for_editor') }}</textarea>
                @error('comments_for_editor') <p class="text-red-600 text-xs font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Rating --}}
            <div>
                <label for="rating" class="block text-sm font-semibold text-slate-900 mb-3">
                    Rating <span class="text-slate-500 font-normal text-xs">(1-5, optional)</span>
                </label>
                <div class="flex items-center gap-3">
                    <input id="rating" type="number" name="rating" min="1" max="5" value="{{ old('rating') }}"
                        class="w-20 px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 font-medium focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all">
                    <span class="text-xs text-slate-500">out of 5 stars</span>
                </div>
                @error('rating') <p class="text-red-600 text-xs font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                <a href="{{ route('reviews.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-slate-900 hover:bg-red-600 text-white px-8 py-3 rounded-lg
                           text-sm font-bold uppercase tracking-[.06em]
                           transition-all duration-200 hover:-translate-y-0.5
                           shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-red-200/50">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
