   @php
    use App\Models\Submission;
    @endphp

    @extends('layouts.app')

    @section('title', 'Review & Assign Submission')

    @section('content')
    <div class="mb-8">
        <h1 class="text-5xl font-bold text-slate-900 mb-2">{{ $submission->title }}</h1>
        <p class="text-lg text-slate-600">{{ $submission->author->name }}</p>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <!-- Submission Details -->
        <div class="col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 mb-6">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Submission Details</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Research Field</label>
                        <span class="inline-block bg-red-50 border border-red-200 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $submission->research_field ?? 'Not specified' }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Abstract</label>
                        <p class="text-slate-700 leading-relaxed">{{ $submission->abstract }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Keywords</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach (explode(',', $submission->keywords) as $keyword)
                                <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                                    {{ trim($keyword) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Status</label>
                        <span class="inline-block px-4 py-2 rounded-lg font-semibold
                            {{ $submission->status === 'submitted'    ? 'bg-yellow-50 text-yellow-700' : '' }}
                            {{ $submission->status === 'under_review' ? 'bg-blue-50 text-blue-700'     : '' }}
                            {{ $submission->status === 'accepted'     ? 'bg-green-50 text-green-700'   : '' }}
                            {{ $submission->status === 'rejected'     ? 'bg-red-50 text-red-700'       : '' }}
                        ">
                            {{ \App\Models\Submission::statusOptions()[$submission->status] ?? $submission->status }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Submitted</label>
                        <p class="text-slate-700">{{ $submission->submitted_at->format('F d, Y \\a\\t h:i A') }}</p>
                    </div>

                    @if ($submission->file_name)
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Submission File</label>
                            <a href="{{ route('submissions.download-original', $submission) }}"
                            class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-semibold">
                                📥 {{ $submission->original_file_name ?? $submission->file_name }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Initial Screening Status -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 mb-6">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Initial Screening</h2>
                
                @if ($submission->isPendingInitialScreening())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                        <p class="text-yellow-900 font-semibold mb-4">⏳ Pending Initial Screening</p>
                        <p class="text-yellow-800 text-sm mb-6">This manuscript has not been screened yet.</p>
                        <a href="{{ route('chief-editor.initial-screening', $submission) }}"
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
                        <a href="{{ route('chief-editor.initial-screening', $submission) }}"
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
                        <a href="{{ route('chief-editor.initial-screening', $submission) }}"
                        class="inline-block text-red-700 hover:text-red-900 font-medium text-sm">
                            Override Decision
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Revision History --}}
    @if ($submission->revisionRequests()->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 mb-6">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Revision History</h2>

            <div class="space-y-4">
                @foreach ($submission->revisionRequests()->with('requestedBy')->latest('requested_at')->get() as $revision)
                    <div class="border border-slate-200 rounded-lg p-5
                        {{ $revision->revised_at ? 'border-l-4 border-l-green-500' : 'border-l-4 border-l-amber-400' }}">

                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <span class="font-semibold text-slate-900">
                                    {{ ucfirst($revision->revision_type) }} Revision
                                </span>
                                <span class="ml-2 text-xs text-slate-500">
                                    Requested by {{ $revision->requestedBy?->name ?? 'Unknown' }}
                                    on {{ $revision->requested_at->format('M d, Y h:i A') }}
                                </span>
                            </div>
                            @if ($revision->revised_at)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    ✓ Revised
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    ⏳ Awaiting Revision
                                </span>
                            @endif
                        </div>

                        <div class="bg-slate-50 rounded p-3 mb-3">
                            <p class="text-xs font-semibold text-slate-600 mb-1">Reason</p>
                            <p class="text-sm text-slate-700">{{ $revision->reason }}</p>
                        </div>

                        @if ($revision->revised_at)
                            <div class="bg-green-50 rounded p-3">
                                <p class="text-xs font-semibold text-green-700 mb-1">
                                    Author's Revision Notes
                                    <span class="font-normal text-green-600 ml-1">
                                        — submitted {{ $revision->revised_at->format('M d, Y h:i A') }}
                                    </span>
                                </p>
                                <p class="text-sm text-green-900">{{ $revision->revision_notes }}</p>

                                @if ($submission->file_name)
                                    <div class="mt-3 pt-3 border-t border-green-200">
                                        <a href="{{ route('submissions.download', $submission) }}"
                                        class="inline-flex items-center gap-1 text-sm font-semibold text-green-700 hover:text-green-900">
                                            📥 Download Revised File — {{ $submission->file_name }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
     </div> {{-- end col-span-2 --}}


        <!-- Assignment Panel -->
        <div class="col-span-1">
            <!-- Current Assignment -->
            @php
                $currentAssignments = $submission->assignments()
                    ->whereNull('rejected_at')
                    ->latest('assigned_at')
                    ->get();
            @endphp

            @if ($currentAssignments->count() > 0)
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6">
                    <h3 class="font-bold text-green-900 mb-3">✓ Currently Assigned</h3>
                    <div class="space-y-2">
                        @foreach ($currentAssignments as $assignment)
                            <div class="bg-white rounded-lg p-3">
                                <p class="font-semibold text-slate-900">{{ $assignment->assignedTo->name }}</p>
                                <p class="text-xs text-slate-500">{{ $assignment->expertise_field }}</p>
                                @if ($assignment->isAccepted())
                                    <p class="text-xs text-green-700 font-semibold mt-1">✓ Accepted</p>
                                @elseif ($assignment->isPending())
                                    <p class="text-xs text-yellow-700 font-semibold mt-1">⏳ Pending</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button type="button"
                        onclick="document.getElementById('reassign-form').style.display = 'block'"
                        class="mt-4 w-full text-sm text-green-700 hover:text-green-900 font-semibold transition-colors">
                        Change Assignments
                    </button>
                </div>
            @endif

            <!-- Assign Form -->
            <form id="reassign-form" method="POST"
                action="{{ !$submission->assignedEditor ? route('chief-editor.assign', $submission) : route('chief-editor.reassign', $submission) }}"
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-6"
                {{ $submission->assignedEditor ? 'style=display:none' : '' }}>
                @csrf

                <h3 class="font-bold text-slate-900 mb-1">
                    {{ $submission->assignedEditor ? 'Reassign Editors' : 'Assign Editors' }}
                </h3>
                <p class="text-sm text-slate-500 mb-4">
                    Showing editors matched to
                    <span class="font-semibold text-red-600">{{ $researchField }}</span>
                </p>

                <div class="space-y-4 mb-4 max-h-72 overflow-y-auto">

                    {{-- MATCHED editors --}}
                    @if (!empty($editorsByField))
                        @foreach ($editorsByField as $field => $editors)
                            <div class="border-l-4 border-red-400 bg-red-50 p-3 rounded">
                                <p class="text-xs font-semibold text-red-700 uppercase mb-2">
                                    ✅ {{ $field }} — Matched
                                </p>
                                <div class="space-y-2">
                                   @foreach ($editors as $editor)
@php
    $activeCount = $editor->active_assignments_count ?? 0;
  $isAssignedHere = $submission->assignments()
        ->whereNull('rejected_at')
        ->where('assigned_to_user_id', $editor->id)
        ->exists();
@endphp
    <label class="flex items-start gap-3 cursor-pointer">
        <input type="checkbox" name="editor_ids[]" value="{{ $editor->id }}"
            class="editor-cb mt-1 rounded border-slate-300 text-red-600 focus:ring-red-500"
            {{ $isAssignedHere ? 'checked' : '' }}>
        <div>
            <p class="text-sm font-medium text-slate-900">
                {{ $editor->name }}
                @if ($isAssignedHere)
                    <span class="ml-1 text-xs font-semibold text-green-600">✓ Assigned</span>
                @endif
            </p>
            <p class="text-xs text-slate-500">{{ $editor->email }}</p>
            <p class="text-xs mt-0.5
                {{ $activeCount === 0 ? 'text-green-600' : ($activeCount <= 3 ? 'text-amber-600' : 'text-red-500') }}">
                {{ $activeCount === 0 ? '✓ Available' : $activeCount . ' active assignment' . ($activeCount > 1 ? 's' : '') }}
            </p>
        </div>
    </label>
@endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-yellow-700">
                            ⚠️ No editors matched for <strong>{{ $researchField }}</strong>.
                        </div>
                    @endif

                    {{-- OTHER editors (collapsed by default) --}}
                    @php
                        $otherFields = array_diff_key($allEditorsByField, $editorsByField);
                    @endphp

                    @if (!empty($otherFields))
                        <div>
                            <button type="button" onclick="toggleOthers()"
                                class="text-xs text-slate-500 hover:text-slate-700 font-semibold underline mt-1"
                                id="toggle-others-btn">
                                + Show other editors
                            </button>

                            <div id="other-editors" class="hidden mt-3 space-y-3">
                                <p class="text-xs text-slate-400 italic">These editors have different expertise fields</p>
                                @foreach ($otherFields as $field => $editors)
                                    <div class="border-l-4 border-slate-300 bg-slate-50 p-3 rounded">
                                        <p class="text-xs font-semibold text-slate-500 uppercase mb-2">{{ $field }}</p>
                                        <div class="space-y-2">
                                           @foreach ($editors as $editor)
  @php
    $activeCount = $editor->active_assignments_count ?? 0;
    $isAssignedHere = $submission->assignments()
        ->whereNull('rejected_at')
        ->where('assigned_to_user_id', $editor->id)
        ->exists();
@endphp
    <label class="flex items-start gap-3 cursor-pointer">
        <input type="checkbox" name="editor_ids[]" value="{{ $editor->id }}"
            class="editor-cb mt-1 rounded border-slate-300 text-red-600 focus:ring-red-500"
            {{ $isAssignedHere ? 'checked' : '' }}>
        <div>
            <p class="text-sm font-medium text-slate-900">
                {{ $editor->name }}
                @if ($isAssignedHere)
                    <span class="ml-1 text-xs font-semibold text-green-600">✓ Assigned</span>
                @endif
            </p>
            <p class="text-xs text-slate-500">{{ $editor->email }}</p>
            <p class="text-xs mt-0.5
                {{ $activeCount === 0 ? 'text-green-600' : ($activeCount <= 3 ? 'text-amber-600' : 'text-red-500') }}">
                {{ $activeCount === 0 ? '✓ Available' : $activeCount . ' active assignment' . ($activeCount > 1 ? 's' : '') }}
            </p>
        </div>
    </label>
@endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Notes (Optional)</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Add assignment notes..."></textarea>
                </div>

                <button type="submit" id="assign-btn" disabled
                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-semibold
                        transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ $submission->assignedEditor ? '✓ Reassign' : '✓ Assign' }}
                </button>

                @if ($submission->assignedEditor)
                    <button type="button"
                        onclick="document.getElementById('reassign-form').style.display = 'none'"
                        class="w-full mt-2 bg-slate-100 text-slate-700 py-2 rounded-lg hover:bg-slate-200 font-semibold transition-colors">
                        Cancel
                    </button>
                @endif
            </form>

            <script>
                const checkboxes = document.querySelectorAll('.editor-cb');
                const assignBtn  = document.getElementById('assign-btn');

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', () => {
                        assignBtn.disabled = ![...checkboxes].some(c => c.checked);
                    });
                });

                function toggleOthers() {
                    const el  = document.getElementById('other-editors');
                    const btn = document.getElementById('toggle-others-btn');
                    const hidden = el.classList.toggle('hidden');
                    btn.textContent = hidden ? '+ Show other editors' : '− Hide other editors';
                }
            </script>

            <!-- Assignment History -->
            @if ($submission->assignments()->count() > 0)
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-6 mt-6">
                    <h3 class="font-bold text-slate-900 mb-4">Assignment History</h3>
                    <div class="space-y-3">
                        @foreach ($submission->assignments()->latest()->get() as $assignment)
                            <div class="bg-white rounded-lg p-3 text-sm border-l-4
                                {{ $assignment->isAccepted() ? 'border-green-500' : ($assignment->isRejected() ? 'border-red-500' : 'border-yellow-500') }}">
                                <p class="font-semibold text-slate-900">{{ $assignment->assignedTo->name }}</p>
                                <p class="text-xs text-slate-600">{{ $assignment->expertise_field }}</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $assignment->assigned_at->format('M d, Y') }}
                                    @if ($assignment->isAccepted())
                                        <span class="text-green-700 font-semibold">✓ Accepted</span>
                                    @elseif ($assignment->isRejected())
                                        <span class="text-red-700 font-semibold">✗ Rejected</span>
                                    @else
                                        <span class="text-yellow-700 font-semibold">⏳ Pending</span>
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('chief-editor.dashboard') }}"
        class="inline-block text-red-600 hover:text-red-700 transition-colors font-medium">
            ← Back to Dashboard
        </a>
    </div>
    @endsection