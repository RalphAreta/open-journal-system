@php
use App\Models\Submission;
@endphp

@extends('layouts.app')

@section('title', 'Review & Assign Submission')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@400;500;600&display=swap');

    .page-root { font-family: 'DM Sans', sans-serif; }
    .page-title { font-family: 'Fraunces', serif; }

    .status-badge {
        font-family: 'DM Sans', sans-serif;
        letter-spacing: 0.03em;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8eaf0;
        box-shadow: 0 1px 4px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.03);
    }

    .side-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8eaf0;
        box-shadow: 0 1px 4px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.03);
    }

    .field-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #8b92a5;
        margin-bottom: 4px;
    }

    .editor-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.15s;
    }
    .editor-row:hover { background: #f8f8fb; }

    .editor-row input[type=checkbox] {
        margin-top: 2px;
        flex-shrink: 0;
        accent-color: #c0392b;
        width: 15px;
        height: 15px;
    }

    .load-dot {
        display: inline-block;
        width: 7px; height: 7px;
        border-radius: 50%;
        margin-right: 4px;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(to right, #f0f1f5, #e8eaf0 40%, #f0f1f5);
        margin: 20px 0;
    }

    .sticky-panel {
        position: sticky;
        top: 24px;
    }

    /* Scrollbar for editor list */
    .editor-scroll::-webkit-scrollbar { width: 4px; }
    .editor-scroll::-webkit-scrollbar-thumb { background: #e0e2ea; border-radius: 4px; }

    /* Revision card */
    .revision-card {
        border-radius: 10px;
        border: 1px solid #e8eaf0;
        overflow: hidden;
    }
    .revision-card .rev-header {
        padding: 12px 14px;
        border-bottom: 1px solid #f0f1f5;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .revision-card .rev-body { padding: 12px 14px; }

    /* Assignment history items */
    .hist-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 10px;
        border-radius: 8px;
        background: #f9f9fb;
        border: 1px solid #eef0f5;
        gap: 8px;
    }

    .btn-primary {
        width: 100%;
        background: #c0392b;
        color: #fff;
        padding: 10px 0;
        border-radius: 9px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: background 0.15s, box-shadow 0.15s;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(192,57,43,.25);
    }
    .btn-primary:hover:not(:disabled) { background: #a93226; box-shadow: 0 4px 14px rgba(192,57,43,.35); }
    .btn-primary:disabled { opacity: 0.45; cursor: not-allowed; box-shadow: none; }

    .btn-secondary {
        width: 100%;
        background: #f3f4f7;
        color: #4a5068;
        padding: 9px 0;
        border-radius: 9px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: background 0.15s;
        border: none;
        cursor: pointer;
        margin-top: 8px;
    }
    .btn-secondary:hover { background: #e8eaf0; }

    .tag-pill {
        display: inline-flex;
        align-items: center;
        background: #f3f4f7;
        color: #4a5068;
        padding: 3px 10px;
        border-radius: 100px;
        font-size: 0.72rem;
        font-weight: 500;
    }
</style>

<div class="page-root">

    {{-- ── Header ── --}}
    <div class="mb-7 flex items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('chief-editor.dashboard') }}" class="text-slate-400 hover:text-red-600 text-sm font-medium transition-colors">
                    ← Dashboard
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sm text-slate-500">Review</span>
            </div>
            <h1 class="page-title text-4xl font-bold text-slate-900 leading-tight max-w-2xl">
                {{ $submission->title }}
            </h1>
            <p class="mt-1.5 text-slate-500 text-sm font-medium">by {{ $submission->author->name }}</p>
        </div>

        {{-- Status badge in header --}}
        <div class="flex-shrink-0 mt-1">
            <span class="status-badge inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                {{ $submission->status === 'submitted'    ? 'bg-amber-50  text-amber-700  ring-1 ring-amber-200'  : '' }}
                {{ $submission->status === 'under_review' ? 'bg-blue-50   text-blue-700   ring-1 ring-blue-200'   : '' }}
                {{ $submission->status === 'accepted'     ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : '' }}
                {{ $submission->status === 'rejected'     ? 'bg-red-50    text-red-700    ring-1 ring-red-200'    : '' }}
            ">
                <span class="w-1.5 h-1.5 rounded-full inline-block
                    {{ $submission->status === 'submitted'    ? 'bg-amber-500'   : '' }}
                    {{ $submission->status === 'under_review' ? 'bg-blue-500'    : '' }}
                    {{ $submission->status === 'accepted'     ? 'bg-emerald-500' : '' }}
                    {{ $submission->status === 'rejected'     ? 'bg-red-500'     : '' }}
                "></span>
                {{ \App\Models\Submission::statusOptions()[$submission->status] ?? $submission->status }}
            </span>
        </div>
    </div>

    {{-- ── Main Grid ── --}}
    <div class="grid grid-cols-12 gap-6 items-start">

        {{-- ── LEFT / CENTER COLUMN ── --}}
        <div class="col-span-8 space-y-5">

            {{-- Submission Details Card --}}
            <div class="card p-7">
                <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                    <span class="w-5 h-5 rounded bg-red-100 flex items-center justify-center text-xs text-red-600">📄</span>
                    Submission Details
                </h2>

                <div class="grid grid-cols-2 gap-x-8 gap-y-5">

                    <div>
                        <p class="field-label">Research Field</p>
                        <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                            🔬 {{ $submission->research_field ?? 'Not specified' }}
                        </span>
                    </div>

                    <div>
                        <p class="field-label">Submitted</p>
                        <p class="text-sm text-slate-700">{{ $submission->submitted_at->format('M d, Y') }}</p>
                        <p class="text-xs text-slate-400">{{ $submission->submitted_at->format('h:i A') }}</p>
                    </div>

                    <div class="col-span-2">
                        <p class="field-label">Abstract</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $submission->abstract }}</p>
                    </div>

                    <div class="col-span-2">
                        <p class="field-label">Keywords</p>
                        <div class="flex flex-wrap gap-1.5 mt-1">
                            @foreach (explode(',', $submission->keywords) as $keyword)
                                <span class="tag-pill">{{ trim($keyword) }}</span>
                            @endforeach
                        </div>
                    </div>

                    @if ($submission->file_name)
                        <div class="col-span-2">
                            <p class="field-label">Submission File</p>
                            <a href="{{ route('submissions.download-original', $submission) }}"
                               class="inline-flex items-center gap-2 mt-1 px-4 py-2 bg-slate-50 hover:bg-red-50 border border-slate-200 hover:border-red-200 text-slate-700 hover:text-red-700 rounded-lg text-sm font-medium transition-all">
                                📥 {{ $submission->original_file_name ?? $submission->file_name }}
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Initial Screening Card — compact strip --}}
            @if ($submission->isPendingInitialScreening())
                <div class="card px-5 py-3.5 flex items-center justify-between gap-4
                            border-l-4 border-l-amber-400">
                    <div class="flex items-center gap-3">
                        <span class="text-base leading-none">⏳</span>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">Initial Screening</p>
                            <p class="text-xs text-slate-400 mt-0.5">Not screened yet</p>
                        </div>
                    </div>
                    <a href="{{ route('chief-editor.initial-screening', $submission) }}"
                       class="flex-shrink-0 px-3.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg text-xs transition-colors whitespace-nowrap">
                        Perform Screening →
                    </a>
                </div>

            @elseif ($submission->hasPassedInitialScreening())
                <div class="card px-5 py-3.5 border-l-4 border-l-emerald-500">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <span class="text-base leading-none mt-0.5">✅</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-800 mb-2">Initial Screening — Passed</p>
                                <div class="flex flex-wrap gap-x-6 gap-y-1.5">
                                    <div>
                                        <span class="field-label">By</span>
                                        <span class="text-xs text-slate-700 font-medium ml-1">{{ $submission->initialScreeningBy?->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div>
                                        <span class="field-label">Date</span>
                                        <span class="text-xs text-slate-700 font-medium ml-1">{{ $submission->initial_screening_at?->format('M d, Y') }}</span>
                                    </div>
                                    @if ($submission->initial_screening_comments)
                                        <div class="w-full">
                                            <span class="field-label">Comments</span>
                                            <span class="text-xs text-slate-600 ml-1">{{ $submission->initial_screening_comments }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('chief-editor.initial-screening', $submission) }}"
                           class="flex-shrink-0 text-xs text-emerald-600 hover:text-emerald-800 font-semibold underline mt-0.5">Edit</a>
                    </div>
                </div>

            @else
                <div class="card px-5 py-3.5 border-l-4 border-l-red-500">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <span class="text-base leading-none mt-0.5">❌</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-800 mb-2">Initial Screening — Failed</p>
                                <div class="flex flex-wrap gap-x-6 gap-y-1.5">
                                    <div>
                                        <span class="field-label">By</span>
                                        <span class="text-xs text-slate-700 font-medium ml-1">{{ $submission->initialScreeningBy?->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div>
                                        <span class="field-label">Date</span>
                                        <span class="text-xs text-slate-700 font-medium ml-1">{{ $submission->initial_screening_at?->format('M d, Y') }}</span>
                                    </div>
                                    @if ($submission->initial_screening_comments)
                                        <div class="w-full">
                                            <span class="field-label">Comments</span>
                                            <span class="text-xs text-slate-600 ml-1">{{ $submission->initial_screening_comments }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('chief-editor.initial-screening', $submission) }}"
                           class="flex-shrink-0 text-xs text-red-600 hover:text-red-800 font-semibold underline mt-0.5">Override</a>
                    </div>
                </div>
            @endif

            {{-- Revision History --}}
            @if ($submission->revisionRequests()->count() > 0)
                <div class="card p-7">
                    <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                        <span class="w-5 h-5 rounded bg-violet-100 flex items-center justify-center text-xs text-violet-600">🔄</span>
                        Revision History
                        <span class="ml-auto text-xs text-slate-400 font-normal">{{ $submission->revisionRequests()->count() }} request(s)</span>
                    </h2>

                    <div class="space-y-3">
                        @foreach ($submission->revisionRequests()->with('requestedBy')->latest('requested_at')->get() as $revision)
                            <div class="revision-card {{ $revision->revised_at ? 'border-l-2 border-l-emerald-400' : 'border-l-2 border-l-amber-400' }}">
                                <div class="rev-header">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-800">
                                            {{ ucfirst($revision->revision_type) }} Revision
                                        </p>
                                        <p class="text-xs text-slate-400 mt-0.5 truncate">
                                            by {{ $revision->requestedBy?->name ?? 'Unknown' }} · {{ $revision->requested_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    @if ($revision->revised_at)
                                        <span class="status-badge px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">✓ Revised</span>
                                    @else
                                        <span class="status-badge px-2.5 py-1 rounded-full bg-amber-100 text-amber-700">⏳ Pending</span>
                                    @endif
                                </div>
                                <div class="rev-body space-y-3">
                                    <div>
                                        <p class="field-label mb-1">Reason</p>
                                        <p class="text-xs text-slate-700">{{ $revision->reason }}</p>
                                    </div>
                                    @if ($revision->revised_at)
                                        <div class="bg-emerald-50 rounded-lg p-3">
                                            <p class="field-label mb-1" style="color:#2d7a5c">
                                                Author's Notes
                                                <span class="font-normal normal-case text-emerald-500 ml-1">— {{ $revision->revised_at->format('M d, Y h:i A') }}</span>
                                            </p>
                                            <p class="text-xs text-emerald-900">{{ $revision->revision_notes }}</p>
                                            @if ($submission->file_name)
                                                <a href="{{ route('submissions.download', $submission) }}"
                                                   class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                                                    📥 Download Revised File
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- ── RIGHT COLUMN — Sticky Assignment Panel ── --}}
        <div class="col-span-4">
            <div class="sticky-panel space-y-4">

                {{-- Current Assignments --}}
                @php
                    $currentAssignments = $submission->assignments()
                        ->whereNull('rejected_at')
                        ->latest('assigned_at')
                        ->get();
                @endphp

                @if ($currentAssignments->count() > 0)
                    <div class="side-card p-5 border-t-4 border-t-emerald-500">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-slate-800">✓ Assigned Editors</h3>
                            <button type="button"
                                onclick="document.getElementById('reassign-form').style.display = 'block'; this.closest('.side-card').style.display='none'"
                                class="text-xs text-red-600 hover:text-red-800 font-semibold underline">
                                Change
                            </button>
                        </div>
                        <div class="space-y-2">
                            @foreach ($currentAssignments as $assignment)
                                <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-lg">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-semibold text-slate-900 truncate">{{ $assignment->assignedTo->name }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $assignment->expertise_field }}</p>
                                    </div>
                                    @if ($assignment->isAccepted())
                                        <span class="status-badge ml-2 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 flex-shrink-0">✓</span>
                                    @elseif ($assignment->isPending())
                                        <span class="status-badge ml-2 px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 flex-shrink-0">⏳</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Assign / Reassign Form --}}
                <div id="reassign-form" class="side-card p-5 border-t-4 border-t-red-500"
                    {{ $submission->assignedEditor ? 'style=display:none' : '' }}>

                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-slate-800">
                            {{ $submission->assignedEditor ? 'Reassign Editors' : 'Assign Editors' }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Matched to
                            <span class="font-semibold text-red-600">{{ $researchField }}</span>
                        </p>
                    </div>

                    <form method="POST"
                        action="{{ !$submission->assignedEditor ? route('chief-editor.assign', $submission) : route('chief-editor.reassign', $submission) }}">
                        @csrf

                        {{-- Editor list --}}
                        <div class="editor-scroll overflow-y-auto space-y-1 mb-4" style="max-height: 280px;">

                            {{-- Matched --}}
                            @if (!empty($editorsByField))
                                @foreach ($editorsByField as $field => $editors)
                                    <div class="mb-2">
                                        <p class="field-label px-1 mb-1 text-red-500">✅ {{ $field }} — Matched</p>
                                        @foreach ($editors as $editor)
                                            @php
                                                $activeCount = $editor->active_assignments_count ?? 0;
                                                $isAssignedHere = $submission->assignments()->whereNull('rejected_at')->where('assigned_to_user_id', $editor->id)->exists();
                                            @endphp
                                            <label class="editor-row">
                                                <input type="checkbox" name="editor_ids[]" value="{{ $editor->id }}"
                                                    class="editor-cb" {{ $isAssignedHere ? 'checked' : '' }}>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-xs font-semibold text-slate-900">
                                                        {{ $editor->name }}
                                                        @if ($isAssignedHere)
                                                            <span class="text-emerald-600 font-semibold">✓</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-slate-400 truncate">{{ $editor->email }}</p>
                                                    <p class="text-xs mt-0.5 font-medium
                                                        {{ $activeCount === 0 ? 'text-emerald-600' : ($activeCount <= 3 ? 'text-amber-600' : 'text-red-500') }}">
                                                        <span class="load-dot
                                                            {{ $activeCount === 0 ? 'bg-emerald-400' : ($activeCount <= 3 ? 'bg-amber-400' : 'bg-red-400') }}
                                                        " style="width:6px;height:6px;border-radius:50%;display:inline-block;margin-right:3px;vertical-align:middle;"></span>
                                                        {{ $activeCount === 0 ? 'Available' : $activeCount . ' active' }}
                                                    </p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <div class="p-3 bg-amber-50 border border-amber-100 rounded-lg text-xs text-amber-700">
                                    ⚠️ No editors matched for <strong>{{ $researchField }}</strong>.
                                </div>
                            @endif

                            {{-- Other editors --}}
                            @php $otherFields = array_diff_key($allEditorsByField, $editorsByField); @endphp
                            @if (!empty($otherFields))
                                <div class="section-divider"></div>
                                <button type="button" onclick="toggleOthers()"
                                    id="toggle-others-btn"
                                    class="text-xs text-slate-400 hover:text-slate-700 font-semibold w-full text-left px-1">
                                    + Show other editors
                                </button>
                                <div id="other-editors" class="hidden mt-2 space-y-1">
                                    <p class="text-xs text-slate-400 italic px-1 mb-2">Different expertise fields</p>
                                    @foreach ($otherFields as $field => $editors)
                                        <div class="mb-2">
                                            <p class="field-label px-1 mb-1">{{ $field }}</p>
                                            @foreach ($editors as $editor)
                                                @php
                                                    $activeCount = $editor->active_assignments_count ?? 0;
                                                    $isAssignedHere = $submission->assignments()->whereNull('rejected_at')->where('assigned_to_user_id', $editor->id)->exists();
                                                @endphp
                                                <label class="editor-row">
                                                    <input type="checkbox" name="editor_ids[]" value="{{ $editor->id }}"
                                                        class="editor-cb" {{ $isAssignedHere ? 'checked' : '' }}>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-xs font-semibold text-slate-900">
                                                            {{ $editor->name }}
                                                            @if ($isAssignedHere)
                                                                <span class="text-emerald-600">✓</span>
                                                            @endif
                                                        </p>
                                                        <p class="text-xs text-slate-400 truncate">{{ $editor->email }}</p>
                                                        <p class="text-xs mt-0.5 font-medium
                                                            {{ $activeCount === 0 ? 'text-emerald-600' : ($activeCount <= 3 ? 'text-amber-600' : 'text-red-500') }}">
                                                            <span style="width:6px;height:6px;border-radius:50%;display:inline-block;margin-right:3px;vertical-align:middle;
                                                                background:{{ $activeCount === 0 ? '#34d399' : ($activeCount <= 3 ? '#fbbf24' : '#f87171') }}"></span>
                                                            {{ $activeCount === 0 ? 'Available' : $activeCount . ' active' }}
                                                        </p>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Notes --}}
                        <div class="mb-4">
                            <label class="field-label block mb-1">Notes <span class="font-normal normal-case text-slate-400">(optional)</span></label>
                            <textarea name="notes" rows="2"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 text-xs text-slate-700 resize-none"
                                placeholder="Add assignment notes..."></textarea>
                        </div>

                        <button type="submit" id="assign-btn" disabled class="btn-primary">
                            {{ $submission->assignedEditor ? '✓ Reassign Editors' : '✓ Assign Editors' }}
                        </button>

                        @if ($submission->assignedEditor)
                            <button type="button"
                                onclick="document.getElementById('reassign-form').style.display = 'none'"
                                class="btn-secondary">
                                Cancel
                            </button>
                        @endif
                    </form>
                </div>

                {{-- Assignment History --}}
                @if ($submission->assignments()->count() > 0)
                    <div class="side-card p-5">
                        <h3 class="text-sm font-semibold text-slate-800 mb-3">Assignment History</h3>
                        <div class="space-y-2">
                            @foreach ($submission->assignments()->latest()->get() as $assignment)
                                <div class="hist-item">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $assignment->assignedTo->name }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $assignment->expertise_field }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="text-xs text-slate-400">{{ $assignment->assigned_at->format('M d') }}</p>
                                        @if ($assignment->isAccepted())
                                            <span class="status-badge text-emerald-600">✓ Accepted</span>
                                        @elseif ($assignment->isRejected())
                                            <span class="status-badge text-red-500">✗ Rejected</span>
                                        @else
                                            <span class="status-badge text-amber-600">⏳ Pending</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>{{-- end grid --}}

</div>{{-- end page-root --}}

<script>
    const checkboxes = document.querySelectorAll('.editor-cb');
    const assignBtn  = document.getElementById('assign-btn');

    function syncBtn() {
        if (assignBtn) assignBtn.disabled = ![...checkboxes].some(c => c.checked);
    }
    checkboxes.forEach(cb => cb.addEventListener('change', syncBtn));
    syncBtn();

    function toggleOthers() {
        const el  = document.getElementById('other-editors');
        const btn = document.getElementById('toggle-others-btn');
        const hidden = el.classList.toggle('hidden');
        btn.textContent = hidden ? '+ Show other editors' : '− Hide other editors';
    }
</script>
@endsection