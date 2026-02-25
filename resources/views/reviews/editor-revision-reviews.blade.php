@extends('layouts.app')

@section('title', 'Revision Review Management')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-slate-900 mb-2">Revision Review Management</h1>
        <p class="text-slate-600">Review revised manuscripts and make final editorial decisions</p>
    </div>

    {{-- ── Completed Decisions Section ── --}}
    @if ($completedSubmissions->isNotEmpty())
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">✓ Completed Decisions</h2>
            <div class="space-y-4">
                @foreach ($completedSubmissions as $completed)
                    <div class="bg-linear-to-r {{ $completed->status === 'accepted' ? 'from-emerald-50 to-green-50 border-emerald-200' : 'from-red-50 to-rose-50 border-red-200' }} rounded-lg border p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 {{ $completed->status === 'accepted' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }} rounded-lg flex items-center justify-center text-lg font-bold">
                                    {{ $completed->status === 'accepted' ? '✓' : '✗' }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $completed->title }}</p>
                                    <p class="text-xs text-slate-600 mt-1">Author: <span class="font-medium">{{ $completed->author->name }}</span> • Decision: {{ $completed->editor_decision_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <span class="px-4 py-2 rounded-lg {{ $completed->status === 'accepted' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} text-xs font-semibold whitespace-nowrap">
                                {{ ucfirst($completed->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── Pending Revisions Section ── --}}
    <div>
        <h2 class="text-2xl font-bold text-slate-900 mb-4">⏳ Awaiting Your Decision</h2>
        @if ($pendingSubmissions->isEmpty())
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center">
                <p class="text-blue-700 font-semibold">No revised manuscripts awaiting your review.</p>
            </div>
        @else
        <div class="space-y-6">
            @foreach ($pendingSubmissions as $submission)
                @php
                    $revisions = $submission->revisionRequests()->whereNotNull('revised_at')->get();
                @endphp
                @foreach ($revisions as $revision)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ $submission->title }}</h2>
                                <p class="text-sm text-slate-600 mb-2">
                                    Author: <span class="font-semibold text-slate-900">{{ $submission->author->name }}</span>
                                </p>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $revision->revision_type === 'minor' ? 'bg-yellow-100 text-yellow-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ $revision->revision_type === 'minor' ? '⚡ Minor' : '🔴 Major' }}
                                    </span>
                                    <span class="text-xs text-slate-500">Revised: {{ $revision->revised_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-4 py-2 rounded-lg bg-amber-100 text-amber-700 text-sm font-semibold block mb-2">
                                    ⏳ Awaiting Your Decision
                                </span>
                            </div>
                        </div>

                        {{-- Author's Revision Notes --}}
                        @if ($revision->revision_notes)
                            <div class="bg-slate-50 rounded-lg p-4 mb-4">
                                <p class="text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">Author's Revision Notes</p>
                                <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $revision->revision_notes }}</p>
                            </div>
                        @endif

                        {{-- Revision Reviews from Reviewers --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Reviewer Feedback on Revised Manuscript</h3>
                            <div class="space-y-4">
                                @forelse ($revision->revisionReviews as $rr)
                                    <div class="border border-slate-200 rounded-lg p-4 {{ $rr->status === \App\Models\RevisionReview::STATUS_COMPLETED ? 'bg-slate-50' : 'bg-yellow-50' }}">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <p class="font-semibold text-slate-900">Reviewer {{ $loop->index + 1 }}</p>
                                                @if ($rr->status === \App\Models\RevisionReview::STATUS_COMPLETED)
                                                    <span class="inline-block mt-1 px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-700">
                                                        ✓ Completed
                                                    </span>
                                                @else
                                                    <span class="inline-block mt-1 px-2 py-1 rounded text-xs font-semibold bg-amber-100 text-amber-700">
                                                        ⏳ Pending
                                                    </span>
                                                @endif
                                            </div>
                                            @if ($rr->recommendation)
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                                    {{ \App\Models\RevisionReview::recommendationOptions()[$rr->recommendation] ?? $rr->recommendation }}
                                                </span>
                                            @endif
                                        </div>

                                        @if ($rr->comments_for_author)
                                            <div class="mb-3">
                                                <p class="text-xs font-bold text-slate-600 uppercase tracking-widest mb-1">Comments for Author</p>
                                                <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $rr->comments_for_author }}</p>
                                            </div>
                                        @endif

                                        @if ($rr->comments_for_editor)
                                            <div>
                                                <p class="text-xs font-bold text-slate-600 uppercase tracking-widest mb-1">Comments for Editor</p>
                                                <p class="text-sm text-slate-600 italic whitespace-pre-wrap">{{ $rr->comments_for_editor }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-slate-600 text-sm">No revision reviews submitted yet.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Final Decision Form --}}
                        @php
                            $allReviewsCompleted = $revision->revisionReviews->every(fn($r) => $r->status === \App\Models\RevisionReview::STATUS_COMPLETED);
                        @endphp
                        <form method="POST" action="{{ route('editor.revision-decision', $submission) }}" class="space-y-4 pt-4 border-t border-slate-200">
                            @csrf
                            <input type="hidden" name="revision_request_id" value="{{ $revision->id }}">

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-3">
                                    Final Editorial Decision <span class="text-red-600">*</span> {{ !$allReviewsCompleted ? '(⚠️ Some reviews pending)' : '' }}
                                </label>
                                <div class="grid grid-cols-3 gap-3">
                                    <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-slate-300 transition-colors">
                                        <input type="radio" name="decision" value="accepted" required class="w-4 h-4 mr-3">
                                        <span class="text-sm font-medium text-slate-700">✓ Accept</span>
                                    </label>
                                    <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-slate-300 transition-colors">
                                        <input type="radio" name="decision" value="rejected" required class="w-4 h-4 mr-3">
                                        <span class="text-sm font-medium text-slate-700">✗ Reject</span>
                                    </label>
                                    <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-slate-300 transition-colors">
                                        <input type="radio" name="decision" value="revisions_requested" required class="w-4 h-4 mr-3">
                                        <span class="text-sm font-medium text-slate-700">🔄 More Revisions</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Conditional revision fields --}}
                            <div id="revisionFields" class="hidden space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-900 mb-2">Revision Type</label>
                                    <div class="flex gap-3">
                                        <label class="flex items-center">
                                            <input type="radio" name="revision_type" value="minor" class="w-4 h-4 mr-2">
                                            <span class="text-sm font-medium">⚡ Minor Revisions</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="revision_type" value="major" class="w-4 h-4 mr-2">
                                            <span class="text-sm font-medium">🔴 Major Revisions</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-900 mb-2">Reason for Further Revisions</label>
                                    <textarea name="revision_reason" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Explain why further revisions are needed..."></textarea>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Editor Notes (Optional)</label>
                                <textarea name="editor_notes" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Internal notes about this decision..."></textarea>
                            </div>

                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 font-semibold transition-colors">
                                    ✓ Confirm Final Decision
                                </button>
                                <a href="{{ route('editor.submissions') }}" class="flex-1 bg-slate-200 text-slate-900 py-3 rounded-lg hover:bg-slate-300 font-semibold transition-colors text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                @endforeach
            @endforeach
        </div>
        @endif
    </div>
</div>

<script>
document.querySelectorAll('input[name="decision"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('#revisionFields').forEach(el => {
            el.classList.toggle('hidden', this.value !== 'revisions_requested');
        });
    });
});
</script>
@endsection
