@extends('layouts.app')

@section('title', 'Manage Submissions')

@section('content')
@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <h3 class="font-semibold text-red-900 mb-2">Error</h3>
        <ul class="text-red-700 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-700 font-semibold">
        ✓ {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 text-red-700 font-semibold">
        ✗ {{ session('error') }}
    </div>
@endif

<h1 class="text-2xl font-semibold mb-6">Manage Submissions</h1>

@php
    $revisionPending = $submissions->filter(fn($s) => $s->status === 'revision_under_review');
    $others = $submissions->filter(fn($s) => $s->status !== 'revision_under_review');
@endphp

{{-- ── REVISION DECISIONS SECTION ── --}}
@if ($revisionPending->isNotEmpty())
    <div class="mb-8">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-slate-900">⏳ Awaiting Revision Decisions</h2>
            <p class="text-sm text-slate-600">Review the revised manuscripts and make your final decision</p>
        </div>

        <div class="space-y-4">
            @foreach ($revisionPending as $submission)
                @php
                    $revisions = $submission->revisionRequests()->whereNotNull('revised_at')->get();
                    $latestRevision = $revisions->last();
                @endphp
                <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-amber-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 mb-1">{{ $submission->title }}</h3>
                                <p class="text-sm text-slate-600">
                                    Author: <span class="font-medium">{{ $submission->author->name }}</span>
                                    • Revised: <span class="font-medium">{{ $latestRevision?->revised_at?->format('M d, Y') ?? 'N/A' }}</span>
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">Awaiting Decision</span>
                        </div>
                    </div>

                    {{-- Revision Details Body --}}
                    <div class="px-6 py-4">
                        {{-- Author's Revision Notes --}}
                        @if ($latestRevision?->author_notes)
                            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">Author's Revision Notes</p>
                                <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $latestRevision->author_notes }}</p>
                            </div>
                        @endif

                        {{-- Reviewer's Re-Review Feedback --}}
                        <div class="mb-6">
                            <p class="text-lg font-bold text-slate-900 mb-4">📋 Reviewer Feedback on Revised Manuscript</p>
                            @forelse ($latestRevision->revisionReviews as $rr)
                                <div class="bg-slate-50 rounded-lg border border-slate-200 p-4 mb-3">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <p class="font-semibold text-slate-900">Reviewer: {{ $rr->reviewer->name }}</p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $rr->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        @if ($rr->recommendation)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                                {{ \App\Models\RevisionReview::recommendationOptions()[$rr->recommendation] ?? $rr->recommendation }}
                                            </span>
                                        @endif
                                    </div>

                                    @if ($rr->rating)
                                        <p class="text-sm text-slate-600 mb-3">
                                            <span class="font-semibold">Rating:</span> {{ $rr->rating }}/5.0
                                        </p>
                                    @endif

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

                        {{-- Final Decision Form --}}
                        <div class="border-t border-slate-200 pt-6">
                            <p class="font-bold text-slate-900 mb-4">✓ Make Final Decision</p>
                            <form method="POST" action="{{ route('editor.revision-decision', $submission) }}" class="space-y-4">
                                @csrf
                                
                                <div>
                                    <label class="block text-sm font-semibold text-slate-900 mb-3">Decision <span class="text-red-600">*</span></label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <label class="flex items-center p-3 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-slate-300 transition-colors">
                                            <input type="radio" name="decision" value="accepted" required class="w-4 h-4 mr-3 accent-green-600">
                                            <span class="text-sm font-medium text-slate-700">✓ Accept</span>
                                        </label>
                                        <label class="flex items-center p-3 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-slate-300 transition-colors">
                                            <input type="radio" name="decision" value="rejected" required class="w-4 h-4 mr-3 accent-red-600">
                                            <span class="text-sm font-medium text-slate-700">✗ Reject</span>
                                        </label>
                                        <label class="flex items-center p-3 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-slate-300 transition-colors">
                                            <input type="radio" name="decision" value="revisions_requested" required class="w-4 h-4 mr-3 accent-amber-600">
                                            <span class="text-sm font-medium text-slate-700">🔄 More Revisions</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Conditional revision fields --}}
                                <div id="revisionFields_{{ $submission->id }}" class="hidden space-y-4">
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
                                        <textarea name="revision_reason" rows="2" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="Explain why further revisions are needed..."></textarea>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-900 mb-2">Decision Notes (Optional)</label>
                                    <textarea name="editor_notes" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500" placeholder="Your final comments on this decision..."></textarea>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-semibold transition-colors">
                                        ✓ Confirm Decision
                                    </button>
                                    <a href="{{ route('editor.submission.show', $submission) }}" class="flex-1 bg-slate-200 text-slate-900 py-2 rounded-lg hover:bg-slate-300 font-semibold transition-colors text-center">
                                        View Full Details
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    const decisionInputs_{{ $submission->id }} = document.querySelectorAll('input[name="decision"][type="radio"]');
                    const revisionFields_{{ $submission->id }} = document.getElementById('revisionFields_{{ $submission->id }}');
                    
                    decisionInputs_{{ $submission->id }}.forEach(input => {
                        input.addEventListener('change', function() {
                            revisionFields_{{ $submission->id }}.classList.toggle('hidden', this.value !== 'revisions_requested');
                        });
                    });
                </script>
            @endforeach
        </div>
    </div>
@endif

{{-- ── OTHER SUBMISSIONS TABLE ── --}}
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Author</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Reviews</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-700 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($others as $s)
                @php
                    $reviews = $s->reviews()->get();
                    $assignments = $s->reviewAssignments()->get();
                    $completed = $reviews->count();
                    $pending = $assignments->where('status', 'assigned')->count();
                    
                    $accepts = $reviews->where('recommendation', 'accept')->count();
                    $rejects = $reviews->where('recommendation', 'reject')->count();
                    $minorRevisions = $reviews->where('recommendation', 'minor_revisions')->count();
                    $majorRevisions = $reviews->where('recommendation', 'major_revisions')->count();
                @endphp
                <tr>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ Str::limit($s->title, 40) }}</td>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ $s->author->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full font-semibold
                            {{ $s->status === 'submitted' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $s->status === 'under_review' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $s->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $s->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $s->status === 'revisions_requested' ? 'bg-orange-100 text-orange-700' : '' }}
                        ">
                            {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if ($completed > 0 || $pending > 0)
                            <div class="flex items-center gap-2 text-xs">
                                @if ($accepts > 0)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full font-semibold">✓ {{ $accepts }}</span>
                                @endif
                                @if ($rejects > 0)
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full font-semibold">✗ {{ $rejects }}</span>
                                @endif
                                @if ($minorRevisions > 0)
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-semibold">⚠ {{ $minorRevisions }}</span>
                                @endif
                                @if ($majorRevisions > 0)
                                    <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-semibold">🔴 {{ $majorRevisions }}</span>
                                @endif
                                @if ($pending > 0)
                                    <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded-full font-semibold">⏳ {{ $pending }}</span>
                                @endif
                            </div>
                        @else
                            <span class="text-xs text-slate-500">No reviews yet</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('editor.submission.show', $s) }}" class="text-red-600 hover:underline text-sm font-medium">Manage</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-700">No submissions.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <p class="text-sm text-blue-700">
        <strong>Legend:</strong>
        <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs mr-2">✓ Accept</span>
        <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded text-xs mr-2">✗ Reject</span>
        <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs mr-2">⚠ Minor</span>
        <span class="inline-block bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs mr-2">🔴 Major</span>
        <span class="inline-block bg-slate-100 text-slate-700 px-2 py-1 rounded text-xs">⏳ Pending</span>
    </p>
</div>
@endsection
