@extends('layouts.app')

@section('title', 'Manage Submission')

@section('content')
<div class="max-w-4xl">
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <h3 class="font-semibold text-red-900 mb-2">Validation Error</h3>
            <ul class="text-red-700 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
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

    <h1 class="text-2xl font-semibold mb-6">{{ $submission->title }}</h1>
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6 space-y-4 mb-6">
        <p><span class="text-slate-700 font-medium">Author:</span> <span class="text-slate-900">{{ $submission->author->name }}</span></p>
        <p><span class="text-slate-700 font-medium">Status:</span> <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-900">{{ $submission->status }}</span></p>
        <p><span class="text-slate-700 font-medium">Research Field:</span>
            <span class="inline-block bg-red-50 border border-red-200 text-red-700 px-2 py-0.5 rounded-full text-sm">
                {{ $submission->research_field ?? 'Not specified' }}
            </span>
        </p>
        <p><span class="text-slate-700 font-medium">Abstract:</span> <span class="text-slate-900">{{ $submission->abstract }}</span></p>

        <div class="border-t pt-4">
            <p class="font-medium text-slate-900 mb-3">Submission File</p>
            @if($submission->file_path)
                <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded">
                    <p class="text-sm text-blue-900"><strong>File:</strong> {{ $submission->file_name }}</p>
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

    <!-- Initial Screening Section -->
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6 mb-6">
        <h2 class="text-lg font-medium mb-4">Initial Screening Status</h2>
        
        @if ($submission->isPendingInitialScreening())
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <p class="text-yellow-900 font-semibold mb-4">⏳ Pending Initial Screening</p>
                <p class="text-yellow-800 text-sm mb-6">This manuscript has not been screened yet. Please perform the initial screening before assigning reviewers.</p>
                <a href="{{ route('editor.initial-screening', $submission) }}"
                   class="inline-block px-6 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition">
                    Perform Initial Screening
                </a>
            </div>
        @elseif ($submission->hasPassedInitialScreening())
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <p class="text-green-900 font-semibold mb-3">✓ Passed Initial Screening</p>
                <div class="space-y-3 mb-4">
                    <div>
                        <label class="text-sm font-medium text-green-800">Screened By</label>
                        <p class="text-green-900">{{ $submission->initialScreeningBy?->name ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-green-800">Screening Date</label>
                        <p class="text-green-900">{{ $submission->initial_screening_at?->format('F d, Y \\a\\t h:i A') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-green-800">Screening Comments</label>
                        <p class="text-green-900 mt-1">{{ $submission->initial_screening_comments }}</p>
                    </div>
                </div>
                <a href="{{ route('editor.initial-screening', $submission) }}"
                   class="inline-block text-green-700 hover:text-green-900 font-medium text-sm">
                    Edit Screening Decision
                </a>
            </div>
        @else
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <p class="text-red-900 font-semibold mb-3">✗ Failed Initial Screening</p>
                <div class="space-y-3 mb-4">
                    <div>
                        <label class="text-sm font-medium text-red-800">Screened By</label>
                        <p class="text-red-900">{{ $submission->initialScreeningBy?->name ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-red-800">Screening Date</label>
                        <p class="text-red-900">{{ $submission->initial_screening_at?->format('F d, Y \\a\\t h:i A') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-red-800">Screening Comments</label>
                        <p class="text-red-900 mt-1">{{ $submission->initial_screening_comments }}</p>
                    </div>
                </div>
                <a href="{{ route('editor.initial-screening', $submission) }}"
                   class="inline-block text-red-700 hover:text-red-900 font-medium text-sm">
                    Override Decision
                </a>
            </div>
        @endif
    </div>

    {{-- Revision Re-Review Section --}}
    @if($submission->status === 'revision_under_review')
        @php
            $revisions = $submission->revisionRequests()->whereNotNull('revised_at')->get();
            $latestRevision = $revisions->last();
        @endphp
        @if($latestRevision)
            <div class="bg-white rounded-lg shadow border border-slate-200 p-6 mb-6">
                <h2 class="text-lg font-medium mb-4">📋 Reviewer Feedback on Revised Manuscript</h2>

                {{-- Author's Revision Notes --}}
                @if ($latestRevision->author_notes)
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">Author's Revision Notes</p>
                        <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $latestRevision->author_notes }}</p>
                    </div>
                @endif

                {{-- Revision Reviews --}}
                <div class="space-y-4">
                    @forelse ($latestRevision->revisionReviews as $rr)
                        <div class="bg-slate-50 rounded-lg border border-slate-200 p-4">
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
            </div>
        @endif
    @endif

    <!-- Editor Decision Section -->
    @if($submission->reviews->isNotEmpty() || $submission->status === 'revision_under_review')
        <div class="bg-white rounded-lg shadow border border-slate-200 p-6 mb-6">
            <h2 class="text-lg font-medium mb-4">Editor Decision</h2>

            @if(in_array($submission->status, ['accepted', 'rejected']))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <p class="text-blue-900 font-semibold mb-3">✓ Decision Already Recorded</p>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-blue-800">Status</label>
                            <p class="text-blue-900 font-semibold">{{ \App\Models\Submission::statusOptions()[$submission->status] }}</p>
                        </div>
                        @if($submission->editor_notes)
                            <div>
                                <label class="text-sm font-medium text-blue-800">Editor Notes</label>
                                <p class="text-blue-900 mt-1">{{ $submission->editor_notes }}</p>
                            </div>
                        @endif
                        @if($submission->editor_decision_at)
                            <div>
                                <label class="text-sm font-medium text-blue-800">Decision Made On</label>
                                <p class="text-blue-900">{{ $submission->editor_decision_at->format('F d, Y \\a\\t h:i A') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif($submission->status === 'revision_under_review')
                <form id="revision-decision-form" method="POST" action="{{ route('editor.revision-decision', $submission) }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-900 mb-3">
                            Final Decision <span class="text-red-600">*</span>
                        </label>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <input type="radio" id="revision_accepted" name="decision" value="accepted" class="mt-1 h-4 w-4 text-green-600" required>
                                <label for="revision_accepted" class="ml-3 cursor-pointer">
                                    <p class="font-medium text-slate-900">✓ Accept</p>
                                    <p class="text-sm text-slate-600">Revisions are satisfactory, accept for publication</p>
                                </label>
                            </div>
                            <div class="flex items-start">
                                <input type="radio" id="revision_rejected" name="decision" value="rejected" class="mt-1 h-4 w-4 text-red-600" required>
                                <label for="revision_rejected" class="ml-3 cursor-pointer">
                                    <p class="font-medium text-slate-900">✗ Reject</p>
                                    <p class="text-sm text-slate-600">Revisions are unsatisfactory, reject the manuscript</p>
                                </label>
                            </div>
                            <div class="flex items-start">
                                <input type="radio" id="revision_more" name="decision" value="revisions_requested" class="revision-option-rev mt-1 h-4 w-4 text-amber-600" required>
                                <label for="revision_more" class="ml-3 cursor-pointer">
                                    <p class="font-medium text-slate-900">🔄 More Revisions</p>
                                    <p class="text-sm text-slate-600">Further revisions required for acceptance</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="revision-fields-more" style="display: none; border-t pt-6 mt-6">
                        <div class="mb-4">
                            <label for="revision_type_rev" class="block text-sm font-semibold text-slate-900 mb-2">
                                Revision Type <span class="text-red-600">*</span>
                            </label>
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

                        <div class="mb-4">
                            <label for="revision_reason_rev" class="block text-sm font-semibold text-slate-900 mb-2">
                                Reason for Further Revisions <span class="text-red-600">*</span>
                            </label>
                            <textarea
                                id="revision_reason_rev"
                                name="revision_reason"
                                rows="3"
                                class="block w-full rounded-md border-slate-300 shadow-sm"
                                placeholder="Explain why further revisions are needed"
                            ></textarea>
                        </div>
                    </div>

                    <div>
                        <label for="editor_notes_rev" class="block text-sm font-semibold text-slate-900 mb-2">
                            Decision Notes (Optional)
                        </label>
                        <textarea
                            id="editor_notes_rev"
                            name="editor_notes"
                            rows="4"
                            maxlength="2000"
                            class="block w-full rounded-md border-slate-300 shadow-sm"
                            placeholder="Add your final comments on this decision..."
                        ></textarea>
                        <p class="text-xs text-slate-500 mt-1">Maximum 2000 characters</p>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                        <p class="text-sm text-slate-600">Make your final decision on the revised manuscript</p>
                        <button
                            type="submit"
                            class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition"
                        >
                            Confirm Final Decision
                        </button>
                    </div>
                </form>

                <script>
                    const revisionDecisionRadios = document.querySelectorAll('input[name="decision"][type="radio"]');
                    const revisionFieldsMore = document.getElementById('revision-fields-more');
                    const revisionOptionRevs = document.querySelectorAll('.revision-option-rev');

                    function toggleRevisionFieldsMore() {
                        const isMoreRevisions = Array.from(revisionOptionRevs).some(r => r.checked);
                        revisionFieldsMore.style.display = isMoreRevisions ? 'block' : 'none';
                        
                        // Disable/enable fields when hidden/shown to prevent submission
                        const revisionFields = revisionFieldsMore.querySelectorAll('input, textarea, select');
                        revisionFields.forEach(field => {
                            field.disabled = !isMoreRevisions;
                        });
                    }

                    revisionDecisionRadios.forEach(radio => {
                        radio.addEventListener('change', toggleRevisionFieldsMore);
                    });
                    
                    // Initialize on page load
                    toggleRevisionFieldsMore();
                </script>
            @elseif($submission->status === 'revisions_requested')
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-6">
                    <p class="text-amber-900 font-semibold mb-3">⏳ Awaiting Revised Manuscript</p>
                    <p class="text-amber-800 text-sm">You have requested revisions from the author. This submission will move to "Revision Under Review" once the author submits their revised manuscript.</p>
                </div>
            @else
                <form id="decision-form" method="POST" action="{{ route('editor.decision', $submission) }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-900 mb-3">
                            Decision <span class="text-red-600">*</span>
                        </label>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <input type="radio" id="accepted" name="status" value="accepted" class="mt-1 h-4 w-4 text-green-600" required>
                                <label for="accepted" class="ml-3 cursor-pointer">
                                    <p class="font-medium text-slate-900">✓ Accept</p>
                                    <p class="text-sm text-slate-600">Manuscript is accepted for publication</p>
                                </label>
                            </div>
                            <div class="flex items-start">
                                <input type="radio" id="rejected" name="status" value="rejected" class="mt-1 h-4 w-4 text-red-600" required>
                                <label for="rejected" class="ml-3 cursor-pointer">
                                    <p class="font-medium text-slate-900">✗ Reject</p>
                                    <p class="text-sm text-slate-600">Manuscript is rejected</p>
                                </label>
                            </div>
                            <div class="flex items-start">
                                <input type="radio" id="minor" name="status" value="revisions_requested" class="revision-option mt-1 h-4 w-4 text-amber-600" required>
                                <label for="minor" class="ml-3 cursor-pointer">
                                    <p class="font-medium text-slate-900">⚡ Request Minor Revisions</p>
                                    <p class="text-sm text-slate-600">Minor revisions required before acceptance</p>
                                </label>
                            </div>
                            <div class="flex items-start">
                                <input type="radio" id="major" name="status" value="revisions_requested" class="revision-option mt-1 h-4 w-4 text-orange-600" required>
                                <label for="major" class="ml-3 cursor-pointer">
                                    <p class="font-medium text-slate-900">⚠️ Request Major Revisions</p>
                                    <p class="text-sm text-slate-600">Major revisions required before re-review</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="revision-fields" style="display: none; border-t pt-6 mt-6">
                        <div class="mb-4">
                            <label for="revision_type" class="block text-sm font-semibold text-slate-900 mb-2">
                                Revision Type <span class="text-red-600">*</span>
                            </label>
                            <select id="revision_type" name="revision_type" class="block w-full rounded-md border-slate-300 shadow-sm">
                                <option value="">-- Select revision type --</option>
                                <option value="minor">Minor Revisions</option>
                                <option value="major">Major Revisions</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="revision_reason" class="block text-sm font-semibold text-slate-900 mb-2">
                                Revision Reason <span class="text-red-600">*</span>
                            </label>
                            <textarea
                                id="revision_reason"
                                name="revision_reason"
                                rows="4"
                                class="block w-full rounded-md border-slate-300 shadow-sm"
                                placeholder="Explain what revisions are needed"
                            ></textarea>
                        </div>
                    </div>

                    <div>
                        <label for="editor_notes" class="block text-sm font-semibold text-slate-900 mb-2">
                            Editor Notes (Optional)
                        </label>
                        <textarea
                            id="editor_notes"
                            name="editor_notes"
                            rows="4"
                            maxlength="2000"
                            class="block w-full rounded-md border-slate-300 shadow-sm"
                            placeholder="Add any additional notes for the author..."
                        ></textarea>
                        <p class="text-xs text-slate-500 mt-1">Maximum 2000 characters</p>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                        <p class="text-sm text-slate-600">Make a decision based on the reviewer feedback above</p>
                        <button
                            type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                        >
                            Record Decision
                        </button>
                    </div>
                </form>

                <script>
                    const statusRadios = document.querySelectorAll('input[name="status"]');
                    const revisionRadios = document.querySelectorAll('.revision-option');
                    const revisionFields = document.getElementById('revision-fields');
                    const revisionTypeSelect = document.getElementById('revision_type');
                    const revisionReasonInput = document.getElementById('revision_reason');
                    const decisionForm = document.getElementById('decision-form');

                    function toggleRevisionFields() {
                        const isRevisionSelected = Array.from(revisionRadios).some(radio => radio.checked);
                        if (isRevisionSelected) {
                            revisionFields.style.display = 'block';
                            revisionTypeSelect.setAttribute('required', 'required');
                            revisionReasonInput.setAttribute('required', 'required');
                            revisionTypeSelect.disabled = false;
                            revisionReasonInput.disabled = false;
                        } else {
                            revisionFields.style.display = 'none';
                            revisionTypeSelect.removeAttribute('required');
                            revisionReasonInput.removeAttribute('required');
                            revisionTypeSelect.disabled = true;
                            revisionReasonInput.disabled = true;
                        }
                    }

                    statusRadios.forEach(radio => {
                        radio.addEventListener('change', toggleRevisionFields);
                    });

                    toggleRevisionFields();
                </script>
            @endif
        </div>
    @endif

    @if(in_array($submission->status, ['submitted', 'under_review', 'revisions_requested']))
        <div class="bg-white rounded-lg shadow border border-slate-200 p-6 mb-6">
            <h2 class="text-lg font-medium mb-1">Assign Reviewer</h2>

            {{-- Matched reviewers notice --}}
            @if($matchedReviewers->count() > 0)
                <p class="text-sm text-green-700 bg-green-50 border border-green-200 rounded px-3 py-2 mb-4">
                    ✅ Showing <strong>{{ $matchedReviewers->count() }}</strong> reviewer(s) matched to
                    <strong>{{ $submission->research_field }}</strong>
                </p>
            @else
                <p class="text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded px-3 py-2 mb-4">
                    ⚠️ No reviewers matched for <strong>{{ $submission->research_field ?? 'this research field' }}</strong>.
                    Showing all reviewers as fallback.
                </p>
            @endif

            <form method="POST" action="{{ route('editor.assign-reviewer', $submission) }}" class="flex gap-2 flex-wrap items-end">
                @csrf
                <div>
                    <label for="reviewer_id" class="block text-sm text-slate-700 font-medium mb-1">Reviewer</label>
                    <select id="reviewer_id" name="reviewer_id" required class="rounded-md border-slate-300 shadow-sm min-w-64">
                        <option value="">Select...</option>

                        {{-- Matched reviewers (by research field) --}}
                        @if($matchedReviewers->count() > 0)
                            <optgroup label="✅ Matched — {{ $submission->research_field }}">
                                @foreach($matchedReviewers as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </optgroup>
                        @endif

                        {{-- Other reviewers --}}
                        @if($otherReviewers->count() > 0)
                            <optgroup label="Other Reviewers">
                                @foreach($otherReviewers as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                </div>
                <div>
                    <label for="due_at" class="block text-sm text-slate-700 font-medium mb-1">Due date</label>
                    <input type="date" name="due_at" id="due_at" class="rounded-md border-slate-300 shadow-sm">
                </div>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium shadow-sm transition-colors">
                    Assign
                </button>
            </form>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('editor.submissions') }}" class="text-red-600 hover:text-red-700 hover:underline font-medium">← Back to submissions</a>
    </div>
</div>
@endsection