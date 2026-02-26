@extends('layouts.app')

@section('title', 'Submit Revision Review')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
            <a href="{{ route('reviews.index') }}" class="hover:text-red-600 transition-colors">My Reviews</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
            <span class="text-slate-900 tracking-widest">Revision Review</span>
        </nav>
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter mb-2">
            Review Revised Manuscript
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

    {{-- Author's Revision Notes --}}
    @if ($revisionReview->revisionRequest->revision_notes)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <p class="text-xs font-bold text-blue-700 uppercase tracking-widest mb-2">Author's Revision Notes</p>
            <p class="text-slate-700 whitespace-pre-wrap">{{ $revisionReview->revisionRequest->revision_notes }}</p>
        </div>
    @endif

    {{-- Original Revision Request --}}
    <div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
        <p class="text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">Original Revision Request</p>
        <div class="flex items-center justify-between mb-3">
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $revisionReview->revisionRequest->revision_type === 'minor' ? 'bg-yellow-100 text-yellow-700' : 'bg-orange-100 text-orange-700' }}">
                {{ $revisionReview->revisionRequest->revision_type === 'minor' ? '⚡ Minor Revisions' : '🔴 Major Revisions' }}
            </span>
            <span class="text-xs text-slate-500">{{ $revisionReview->revisionRequest->requested_at->format('M d, Y') }}</span>
        </div>
        <p class="text-sm text-slate-700 whitespace-pre-wrap mb-4">{{ $revisionReview->revisionRequest->reason }}</p>
    </div>

    {{-- Files Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Original Manuscript --}}
        <div class="bg-white rounded-lg shadow border border-slate-200 p-6">
            <p class="text-xs font-bold text-slate-600 uppercase tracking-widest mb-4">Original Manuscript</p>
            @if($submission->original_file_path)
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-700 mb-1">{{ $submission->original_file_name }}</p>
                        <p class="text-xs text-slate-500">Submitted on {{ $submission->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('submissions.download-original', $submission) }}"
                   class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
            @else
                <p class="text-slate-700 italic text-sm">No original file available.</p>
            @endif
        </div>

        {{-- Revised Manuscript --}}
        <div class="bg-white rounded-lg shadow border border-slate-200 p-6">
            <p class="text-xs font-bold text-slate-600 uppercase tracking-widest mb-4">Revised Manuscript</p>
            @if($submission->file_path && $revisionReview->revisionRequest->revised_at)
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-700 mb-1">{{ $submission->file_name }}</p>
                        <p class="text-xs text-slate-500">Revised on {{ $revisionReview->revisionRequest->revised_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('submissions.download', $submission) }}"
                   class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
            @else
                <p class="text-slate-700 italic text-sm">No revised file submitted yet.</p>
            @endif
        </div>
    </div>

    {{-- Review Form --}}
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Submit Your Revision Review</h2>

        <form method="POST" action="{{ route('reviews.revision-store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="revision_review_id" value="{{ $revisionReview->id }}">

            {{-- Recommendation --}}
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-3">
                    Recommendation <span class="text-red-600">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach (\App\Models\RevisionReview::recommendationOptions() as $value => $label)
                        <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-red-300 transition-colors {{ old('recommendation', $revisionReview->recommendation) === $value ? 'border-red-600 bg-red-50' : '' }}">
                            <input type="radio" name="recommendation" value="{{ $value }}" class="w-4 h-4 mr-3" {{ old('recommendation', $revisionReview->recommendation) === $value ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('recommendation') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- Comments for Author --}}
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">
                    Comments for Author <span class="text-slate-500 font-normal text-xs">(These will be visible to author)</span>
                </label>
                <textarea name="comments_for_author" rows="5" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Provide constructive feedback...">{{ old('comments_for_author', $revisionReview->comments_for_author) }}</textarea>
                @error('comments_for_author') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Comments for Editor --}}
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">
                    Comments for Editor <span class="text-slate-500 font-normal text-xs">(Confidential - not shared with author)</span>
                </label>
                <textarea name="comments_for_editor" rows="5" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Any additional notes for the editor...">{{ old('comments_for_editor', $revisionReview->comments_for_editor) }}</textarea>
                @error('comments_for_editor') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Rating --}}
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-3">
                    Rating <span class="text-slate-500 font-normal text-xs">(Optional)</span>
                </label>
                <div class="flex gap-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" class="w-4 h-4" {{ old('rating', $revisionReview->rating) == $i ? 'checked' : '' }}>
                            <span class="ml-2 text-lg">{{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}</span>
                        </label>
                    @endfor
                </div>
                @error('rating') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-between pt-6 border-t border-slate-200 gap-3">
                <a href="{{ route('reviews.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                    Cancel
                </a>
                <div class="flex items-center gap-3">
                    <button type="submit" name="action" value="save_draft"
                        class="bg-slate-400 hover:bg-slate-500 text-white px-6 py-3 rounded-lg
                               text-sm font-bold uppercase tracking-[.06em]
                               transition-all duration-200 hover:-translate-y-0.5
                               shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-slate-300/50">
                        Save & Submit Later
                    </button>
                    <button type="submit" name="action" value="submit"
                        class="bg-slate-900 hover:bg-red-600 text-white px-6 py-3 rounded-lg
                               text-sm font-bold uppercase tracking-[.06em]
                               transition-all duration-200 hover:-translate-y-0.5
                               shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-red-200/50">
                        Submit Revision Review
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
