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
        <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $revisionReview->revisionRequest->reason }}</p>
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
                        <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-red-300 transition-colors {{ old('recommendation') === $value ? 'border-red-600 bg-red-50' : '' }}">
                            <input type="radio" name="recommendation" value="{{ $value }}" required class="w-4 h-4 mr-3" {{ old('recommendation') === $value ? 'checked' : '' }}>
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
                <textarea name="comments_for_author" rows="5" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Provide constructive feedback...">{{ old('comments_for_author') }}</textarea>
                @error('comments_for_author') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Comments for Editor --}}
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">
                    Comments for Editor <span class="text-slate-500 font-normal text-xs">(Confidential - not shared with author)</span>
                </label>
                <textarea name="comments_for_editor" rows="5" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Any additional notes for the editor...">{{ old('comments_for_editor') }}</textarea>
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
                            <input type="radio" name="rating" value="{{ $i }}" class="w-4 h-4" {{ old('rating') == $i ? 'checked' : '' }}>
                            <span class="ml-2 text-lg">{{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}</span>
                        </label>
                    @endfor
                </div>
                @error('rating') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 font-semibold transition-colors">
                    ✓ Submit Revision Review
                </button>
                <a href="{{ route('reviews.index') }}" class="flex-1 bg-slate-200 text-slate-900 py-3 rounded-lg hover:bg-slate-300 font-semibold transition-colors text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    {{-- Download Link --}}
    <div class="mt-6 text-center">
        <a href="{{ route('submissions.download', $submission) }}" class="text-red-600 hover:text-red-700 font-medium text-sm">
            📥 Download Revised Manuscript
        </a>
    </div>
</div>
@endsection
