@extends('layouts.app')

@section('title', 'Manage Submission')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap"
        rel="stylesheet"
    />
    <style>
        .font-serif {
            font-family: 'Instrument Serif', serif;
        }
        .font-body {
            font-family: 'DM Sans', sans-serif;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-up {
            animation: fadeUp 0.3s ease both;
        }
        .fade-up-1 {
            animation: fadeUp 0.3s 0.06s ease both;
        }
        .fade-up-2 {
            animation: fadeUp 0.3s 0.12s ease both;
        }
        .fade-up-3 {
            animation: fadeUp 0.3s 0.18s ease both;
        }
        .fade-up-4 {
            animation: fadeUp 0.3s 0.24s ease both;
        }

        /* Reviewer card */
        .reviewer-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition:
                border-color 0.18s,
                box-shadow 0.18s,
                transform 0.15s;
            position: relative;
        }
        .reviewer-card:hover {
            border-color: #fca5a5;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.1);
            transform: translateY(-1px);
        }
        .reviewer-card.selected {
            border-color: #dc2626;
            background: #fff5f5;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.15);
        }
        .reviewer-card input[type='checkbox'] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .reviewer-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .reviewer-check {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            flex-shrink: 0;
            transition:
                border-color 0.15s,
                background 0.15s;
        }
        .reviewer-card.selected .reviewer-check {
            background: #dc2626;
            border-color: #dc2626;
        }
        .reviewer-check svg {
            display: none;
        }
        .reviewer-card.selected .reviewer-check svg {
            display: block;
        }

        input[type='date']:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }
        .due-ok {
            color: #16a34a;
        }
        .due-soon {
            color: #d97706;
        }
        .due-overdue {
            color: #dc2626;
        }
    </style>
@endpush

@section('content')
    <div class="font-body max-w-4xl">

        {{-- Page title --}}
        <div class="mb-6 fade-up">
            <a
                href="{{ route('editor.submissions') }}"
                class="text-[11px] font-bold uppercase tracking-[.07em] text-slate-400 hover:text-red-600 transition-colors"
            >
                ← Back to Submissions
            </a>
            <h1
                class="font-serif text-[1.7rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight mt-2"
            >
                {{ $submission->title }}
            </h1>
        </div>

        {{-- ── Submission Details ── --}}
        <div
            class="bg-white border border-slate-200 rounded-2xl p-6 mb-5 shadow-sm fade-up-1"
        >
            <h2
                class="text-[11px] font-bold uppercase tracking-[.08em] text-slate-400 mb-4"
            >
                Submission Details
            </h2>
            <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <p
                        class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-0.5"
                    >
                        Author
                    </p>
                    <p class="text-sm font-semibold text-slate-800">
                        {{ $submission->author->name }}
                    </p>
                </div>
                <div>
                    <p
                        class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-0.5"
                    >
                        Status
                    </p>
                    @php
                        $sc = match ($submission->status) {
                            'accepted' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                            'rejected' => 'bg-red-50 border-red-200 text-red-700',
                            'under_review' => 'bg-blue-50 border-blue-200 text-blue-700',
                            'revisions_requested' => 'bg-amber-50 border-amber-200 text-amber-700',
                            default => 'bg-slate-50 border-slate-200 text-slate-600',
                        };
                    @endphp

                    <span
                        class="inline-flex px-2.5 py-0.5 rounded-full border text-[10px] font-bold uppercase tracking-[.04em] {{ $sc }}"
                    >
                        {{ \App\Models\Submission::statusOptions()[$submission->status] ?? $submission->status }}
                    </span>
                </div>
                <div>
                    <p
                        class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-0.5"
                    >
                        Research Field
                    </p>
                    <span
                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-50 border border-blue-100 text-[10px] font-bold uppercase tracking-[.04em] text-blue-700"
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-blue-400"
                        ></span>
                        {{ $submission->research_field ?? 'Not specified' }}
                    </span>
                </div>
                @if ($submission->file_path)
                    <div>
                        <p
                            class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-0.5"
                        >
                            File
                        </p>
                        <a
                            href="{{ route('submissions.download', ['submission' => $submission]) }}"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
                                />
                            </svg>
                            {{ $submission->file_name }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p
                    class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-1"
                >
                    Abstract
                </p>
                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $submission->abstract }}
                </p>
            </div>
        </div>

        {{-- ── Revision Re-Review Section ── --}}
        @if ($submission->status === 'revision_under_review' && $submission->revisionRequests->isNotEmpty())
            <div class="bg-white border border-slate-200 rounded-2xl p-6 mb-5 shadow-sm fade-up-1">
                <h2 class="text-[11px] font-bold uppercase tracking-[.08em] text-slate-400 mb-4">
                    Revision Files
                </h2>

                @php
                    $latestRevision = $submission->revisionRequests->last();
                @endphp

                {{-- Original vs Revised Files --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    {{-- Original Manuscript --}}
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[.06em] text-slate-600 mb-3">Original Manuscript</p>
                        @if ($submission->original_file_path)
                            <p class="text-sm text-slate-700 mb-3 truncate" title="{{ $submission->original_file_name }}">{{ $submission->original_file_name }}</p>
                            <a href="{{ route('submissions.download-original', ['submission' => $submission]) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download
                            </a>
                        @else
                            <p class="text-sm text-slate-500 italic">No original file</p>
                        @endif
                    </div>

                    {{-- Revised Manuscript --}}
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[.06em] text-slate-600 mb-3">Revised Manuscript</p>
                        @if ($latestRevision && $latestRevision->revised_at && $submission->file_path)
                            <p class="text-sm text-slate-700 mb-3 truncate" title="{{ $submission->file_name }}">{{ $submission->file_name }}</p>
                            <a href="{{ route('submissions.download', ['submission' => $submission]) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download
                            </a>
                        @else
                            <p class="text-sm text-slate-500 italic">No revised manuscript yet</p>
                        @endif
                    </div>
                </div>

                {{-- Author's Revision Notes --}}
                @if ($latestRevision && $latestRevision->revision_notes)
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                        <p class="text-[10px] font-bold uppercase tracking-[.06em] text-blue-700 mb-1">Author's Revision Notes</p>
                        <p class="text-sm text-blue-900">{{ $latestRevision->revision_notes }}</p>
                    </div>
                @endif

                @if ($latestRevision && $latestRevision->revisionReviews->isNotEmpty())
                    <div class="space-y-3">
                        <p class="text-[10px] font-bold uppercase tracking-[.06em] text-slate-500">Reviewer Feedback on Revised Manuscript</p>
                        @foreach ($latestRevision->revisionReviews as $rr)
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">
                                            Reviewer: {{ $rr->reviewer->name ?? 'Anonymous' }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">
                                            {{ $rr->created_at?->format('M d, Y \a\t h:i A') }}
                                        </p>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-[.05em] px-2.5 py-0.5 rounded-full bg-white border border-slate-200 text-slate-600">
                                        {{ \App\Models\Review::recommendationOptions()[$rr->recommendation] ?? $rr->recommendation }}
                                    </span>
                                </div>

                                @if ($rr->rating)
                                    <p class="text-xs text-slate-500 mb-2">
                                        Rating: <span class="font-bold text-slate-700">{{ $rr->rating }}/5.0</span>
                                    </p>
                                @endif

                                @if ($rr->comments_for_author)
                                    <div class="mb-2">
                                        <p class="text-xs font-semibold text-slate-600 mb-0.5">Comments for Author:</p>
                                        <p class="text-sm text-slate-600">{{ $rr->comments_for_author }}</p>
                                    </div>
                                @endif

                                @if ($rr->comments_for_editor)
                                    <div class="mb-2">
                                        <p class="text-xs font-semibold text-slate-600 mb-0.5 italic">Comments for Editor (Internal):</p>
                                        <p class="text-sm text-slate-600 italic">{{ $rr->comments_for_editor }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        {{-- ── Reviews ── --}}
        @if ($submission->reviews->isNotEmpty())
            <div
                class="bg-white border border-slate-200 rounded-2xl p-6 mb-5 shadow-sm fade-up-1"
            >
                <h2
                    class="text-[11px] font-bold uppercase tracking-[.08em] text-slate-400 mb-4"
                >
                    Reviewer Feedback
                </h2>
                <div class="space-y-3">
                    @foreach ($submission->reviews as $r)
                        <div
                            class="p-4 bg-slate-50 border border-slate-100 rounded-xl"
                        >
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-bold text-slate-800">
                                    {{ $r->reviewer->name }}
                                </p>
                                <span
                                    class="text-[10px] font-bold uppercase tracking-[.05em] px-2.5 py-0.5 rounded-full bg-white border border-slate-200 text-slate-600"
                                >
                                    {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}
                                </span>
                            </div>
                            @if ($r->comments_for_editor)
                                <p
                                    class="text-sm text-slate-600 leading-relaxed"
                                >
                                    {{ $r->comments_for_editor }}
                                </p>
                            @endif

                            @if ($r->comments_for_author)
                                <p class="text-sm text-slate-500 mt-1 italic">
                                    For author:
                                    {{ Str::limit($r->comments_for_author, 120) }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Initial Screening ── --}}
        <div
            class="bg-white border border-slate-200 rounded-2xl p-6 mb-5 shadow-sm fade-up-2"
        >
            <h2
                class="text-[11px] font-bold uppercase tracking-[.08em] text-slate-400 mb-4"
            >
                Initial Screening
            </h2>

            @if ($submission->isPendingInitialScreening())
                <div
                    class="bg-amber-50 border border-amber-200 rounded-xl p-5 text-center"
                >
                    <p class="text-sm font-bold text-amber-800 mb-1">
                        ⏳ Pending Initial Screening
                    </p>
                    <p class="text-xs text-amber-700 mb-4">
                        Perform initial screening before assigning reviewers.
                    </p>
                    <a
                        href="{{ route('editor.initial-screening', $submission) }}"
                        class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white px-5 py-2 rounded-lg text-sm font-bold transition-all hover:-translate-y-0.5"
                    >
                        Perform Screening
                    </a>
                </div>
            @elseif ($submission->hasPassedInitialScreening())
                <div
                    class="bg-emerald-50 border border-emerald-200 rounded-xl p-5"
                >
                    <p class="text-sm font-bold text-emerald-800 mb-3">
                        ✓ Passed Initial Screening
                    </p>
                    <div class="grid grid-cols-2 gap-3 text-sm mb-3">
                        <div>
                            <p
                                class="text-[10px] font-bold uppercase tracking-[.06em] text-emerald-700 mb-0.5"
                            >
                                Screened By
                            </p>
                            <p class="text-emerald-900">
                                {{ $submission->initialScreeningBy?->name ?? 'Unknown' }}
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold uppercase tracking-[.06em] text-emerald-700 mb-0.5"
                            >
                                Date
                            </p>
                            <p class="text-emerald-900">
                                {{ $submission->initial_screening_at?->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <p class="text-xs text-emerald-800">
                        {{ $submission->initial_screening_comments }}
                    </p>
                    <a
                        href="{{ route('editor.initial-screening', $submission) }}"
                        class="text-xs font-bold text-emerald-700 hover:text-emerald-900 mt-3 inline-block"
                    >
                        Edit Decision →
                    </a>
                </div>
            @else
                <div class="bg-red-50 border border-red-200 rounded-xl p-5">
                    <p class="text-sm font-bold text-red-800 mb-3">
                        ✗ Failed Initial Screening
                    </p>
                    <div class="grid grid-cols-2 gap-3 text-sm mb-3">
                        <div>
                            <p
                                class="text-[10px] font-bold uppercase tracking-[.06em] text-red-700 mb-0.5"
                            >
                                Screened By
                            </p>
                            <p class="text-red-900">
                                {{ $submission->initialScreeningBy?->name ?? 'Unknown' }}
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold uppercase tracking-[.06em] text-red-700 mb-0.5"
                            >
                                Date
                            </p>
                            <p class="text-red-900">
                                {{ $submission->initial_screening_at?->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <p class="text-xs text-red-800">
                        {{ $submission->initial_screening_comments }}
                    </p>
                    <a
                        href="{{ route('editor.initial-screening', $submission) }}"
                        class="text-xs font-bold text-red-700 hover:text-red-900 mt-3 inline-block"
                    >
                        Override Decision →
                    </a>
                </div>
            @endif
        </div>

        {{-- ── Editor Decision ── --}}
        @if ($submission->reviews->isNotEmpty())
            <div
                class="bg-white border border-slate-200 rounded-2xl p-6 mb-5 shadow-sm fade-up-3"
            >
                <h2
                    class="text-[11px] font-bold uppercase tracking-[.08em] text-slate-400 mb-4"
                >
                    Editor Decision
                </h2>

                @if (in_array($submission->status, ['accepted', 'rejected', 'revisions_requested']))
                    <div
                        class="bg-blue-50 border border-blue-200 rounded-xl p-5"
                    >
                        <p class="text-sm font-bold text-blue-800 mb-3">
                            ✓ Decision Already Recorded
                        </p>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p
                                    class="text-[10px] font-bold uppercase tracking-[.06em] text-blue-700 mb-0.5"
                                >
                                    Status
                                </p>
                                <p class="text-blue-900 font-bold">
                                    {{ \App\Models\Submission::statusOptions()[$submission->status] }}
                                </p>
                            </div>
                            @if ($submission->editor_decision_at)
                                <div>
                                    <p
                                        class="text-[10px] font-bold uppercase tracking-[.06em] text-blue-700 mb-0.5"
                                    >
                                        Decision Date
                                    </p>
                                    <p class="text-blue-900">
                                        {{ $submission->editor_decision_at->format('M d, Y') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                        @if ($submission->editor_notes)
                            <p class="text-xs text-blue-800 mt-3">
                                {{ $submission->editor_notes }}
                            </p>
                        @endif
                    </div>
                @else
                    <form
                        id="decision-form"
                        method="POST"
                        action="{{ route('editor.decision', $submission) }}"
                        class="space-y-5"
                    >
                        @csrf
                        <div>
                            <p class="text-sm font-bold text-slate-800 mb-3">
                                Decision
                                <span class="text-red-600">*</span>
                            </p>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="relative block cursor-pointer">
                                    <input
                                        type="radio"
                                        name="status"
                                        value="accepted"
                                        id="dec_accepted"
                                        class="peer sr-only"
                                        required
                                    />
                                    <div
                                        class="border-2 border-slate-200 rounded-xl p-4 transition-all hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:shadow-sm"
                                    >
                                        <p
                                            class="text-sm font-bold text-slate-800"
                                        >
                                            ✓ Accept
                                        </p>
                                        <p
                                            class="text-xs text-slate-500 mt-0.5"
                                        >
                                            Accepted for publication
                                        </p>
                                    </div>
                                </label>
                                <label class="relative block cursor-pointer">
                                    <input
                                        type="radio"
                                        name="status"
                                        value="rejected"
                                        id="dec_rejected"
                                        class="peer sr-only"
                                    />
                                    <div
                                        class="border-2 border-slate-200 rounded-xl p-4 transition-all hover:border-red-400 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm"
                                    >
                                        <p
                                            class="text-sm font-bold text-slate-800"
                                        >
                                            ✗ Reject
                                        </p>
                                        <p
                                            class="text-xs text-slate-500 mt-0.5"
                                        >
                                            Manuscript rejected
                                        </p>
                                    </div>
                                </label>
                                <label class="relative block cursor-pointer">
                                    <input
                                        type="radio"
                                        name="status"
                                        value="revisions_requested"
                                        id="dec_revisions"
                                        class="peer sr-only revision-option"
                                    />
                                    <div
                                        class="border-2 border-slate-200 rounded-xl p-4 transition-all hover:border-amber-400 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:shadow-sm"
                                    >
                                        <p
                                            class="text-sm font-bold text-slate-800"
                                        >
                                            ⚡ Revisions
                                        </p>
                                        <p
                                            class="text-xs text-slate-500 mt-0.5"
                                        >
                                            Changes required
                                        </p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div
                            id="revision-fields"
                            class="hidden border-t border-slate-100 pt-5 space-y-4"
                        >
                            <div>
                                <label
                                    class="text-sm font-bold text-slate-800 block mb-1.5"
                                >
                                    Revision Type
                                    <span class="text-red-600">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label
                                        class="relative block cursor-pointer"
                                    >
                                        <input
                                            type="radio"
                                            name="revision_type"
                                            value="minor"
                                            id="rt_minor"
                                            class="peer sr-only"
                                        />
                                        <div
                                            class="border-2 border-slate-200 rounded-xl p-3 transition-all hover:border-amber-400 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:shadow-sm"
                                        >
                                            <p
                                                class="text-sm font-bold text-slate-800"
                                            >
                                                ⚡ Minor
                                            </p>
                                            <p
                                                class="text-xs text-slate-500 mt-0.5"
                                            >
                                                Small changes needed
                                            </p>
                                        </div>
                                    </label>
                                    <label
                                        class="relative block cursor-pointer"
                                    >
                                        <input
                                            type="radio"
                                            name="revision_type"
                                            value="major"
                                            id="rt_major"
                                            class="peer sr-only"
                                        />
                                        <div
                                            class="border-2 border-slate-200 rounded-xl p-3 transition-all hover:border-orange-400 peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:shadow-sm"
                                        >
                                            <p
                                                class="text-sm font-bold text-slate-800"
                                            >
                                                ⚠️ Major
                                            </p>
                                            <p
                                                class="text-xs text-slate-500 mt-0.5"
                                            >
                                                Significant changes required
                                            </p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-bold text-slate-800 block mb-1.5"
                                >
                                    Revision Reason
                                    <span class="text-red-600">*</span>
                                </label>
                                <textarea
                                    id="revision_reason"
                                    name="revision_reason"
                                    rows="3"
                                    placeholder="Explain what revisions are needed…"
                                    class="block w-full rounded-xl border border-slate-200 text-sm px-3 py-2.5 bg-slate-50 focus:outline-none focus:border-red-400 transition-colors resize-none"
                                ></textarea>
                            </div>
                        </div>

                        <div>
                            <label
                                class="text-sm font-bold text-slate-800 block mb-1.5"
                            >
                                Editor Notes
                                <span class="text-slate-400 font-normal">
                                    (optional)
                                </span>
                            </label>
                            <textarea
                                id="editor_notes"
                                name="editor_notes"
                                rows="3"
                                maxlength="2000"
                                placeholder="Additional notes for the author…"
                                class="block w-full rounded-xl border border-slate-200 text-sm px-3 py-2.5 bg-slate-50 focus:outline-none focus:border-red-400 transition-colors resize-none"
                            ></textarea>
                        </div>

                        <div
                            class="pt-4 border-t border-slate-100 flex justify-end"
                        >
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all hover:-translate-y-0.5"
                            >
                                Record Decision
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        @endif

        {{-- ── ASSIGN REVIEWER ── --}}
        @if (in_array($submission->status, ['submitted', 'under_review', 'revisions_requested']))
            <div
                class="bg-white border border-slate-200 rounded-2xl p-6 mb-5 shadow-sm fade-up-4"
            >
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2
                            class="text-[11px] font-bold uppercase tracking-[.08em] text-slate-400"
                        >
                            Assign Reviewer
                        </h2>
                        <p class="text-sm font-semibold text-slate-800 mt-0.5">
                            Select a reviewer and set a review deadline
                        </p>
                    </div>

                    @if ($matchedReviewers->count() > 0)
                        <span
                            class="text-[10px] font-bold uppercase tracking-[.05em] bg-emerald-50 border border-emerald-200 text-emerald-700 px-2.5 py-1 rounded-full"
                        >
                            ✅ {{ $matchedReviewers->count() }} matched
                        </span>
                    @else
                        <span
                            class="text-[10px] font-bold uppercase tracking-[.05em] bg-amber-50 border border-amber-200 text-amber-700 px-2.5 py-1 rounded-full"
                        >
                            ⚠️ No field match
                        </span>
                    @endif
                </div>

                <form
                    method="POST"
                    action="{{ route('editor.assign-reviewer', $submission) }}"
                    class="space-y-5"
                >
                    @csrf

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <p
                                class="text-xs font-bold uppercase tracking-[.07em] text-slate-500"
                            >
                                @if ($matchedReviewers->count() > 0)
                                    Matched for
                                    <span class="text-blue-600">
                                        {{ $submission->research_field }}
                                    </span>
                                @else
                                        All Reviewers
                                @endif
                            </p>
                            <span
                                id="selected-count"
                                class="hidden text-[10px] font-bold uppercase tracking-[.05em] bg-red-50 border border-red-200 text-red-600 px-2.5 py-1 rounded-full"
                            >
                                <span id="selected-num">0</span>
                                selected
                            </span>
                        </div>

                        @if ($matchedReviewers->count() > 0)
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-4"
                            >
                                @foreach ($matchedReviewers as $u)
                                    @php
                                        $colors = ['bg-red-500', 'bg-blue-500', 'bg-violet-500', 'bg-emerald-500', 'bg-amber-500', 'bg-pink-500'];
                                        $bg = $colors[$loop->index % count($colors)];
                                    @endphp

                                    <label
                                        class="reviewer-card"
                                        onclick="toggleReviewer(this)"
                                    >
                                        <input
                                            type="checkbox"
                                            name="reviewer_ids[]"
                                            value="{{ $u->id }}"
                                            class="reviewer-checkbox absolute opacity-0 pointer-events-none"
                                        />
                                        <div class="reviewer-avatar {{ $bg }}">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p
                                                class="text-sm font-bold text-slate-800 truncate"
                                            >
                                                {{ $u->name }}
                                            </p>
                                            <p
                                                class="text-xs text-slate-400 truncate"
                                            >
                                                {{ $u->email }}
                                            </p>
                                            <p
                                                class="text-[10px] font-bold text-slate-400 mt-0.5"
                                            >
                                                {{ $u->active_reviews_count }}
                                                {{ $u->active_reviews_count == 1 ? 'active review' : 'active reviews' }}
                                            </p>
                                        </div>
                                        <div class="reviewer-check">
                                            <svg
                                                class="w-3 h-3 text-white"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="3"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        @if ($otherReviewers->count() > 0)
                            @if ($matchedReviewers->count() > 0)
                                <p
                                    class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-2"
                                >
                                    Other Reviewers
                                </p>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach ($otherReviewers as $u)
                                    @php
                                        $colors = ['bg-slate-500', 'bg-cyan-500', 'bg-teal-500', 'bg-indigo-500', 'bg-rose-500', 'bg-lime-500'];
                                        $bg = $colors[$loop->index % count($colors)];
                                    @endphp

                                    <label
                                        class="reviewer-card"
                                        onclick="toggleReviewer(this)"
                                    >
                                        <input
                                            type="checkbox"
                                            name="reviewer_ids[]"
                                            value="{{ $u->id }}"
                                            class="reviewer-checkbox absolute opacity-0 pointer-events-none"
                                        />
                                        <div class="reviewer-avatar {{ $bg }}">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p
                                                class="text-sm font-bold text-slate-800 truncate"
                                            >
                                                {{ $u->name }}
                                            </p>
                                            <p
                                                class="text-xs text-slate-400 truncate"
                                            >
                                                {{ $u->email }}
                                            </p>
                                            <p
                                                class="text-[10px] font-bold text-slate-400 mt-0.5"
                                            >
                                                {{ $u->active_reviews_count }}
                                                {{ $u->active_reviews_count == 1 ? 'active review' : 'active reviews' }}
                                            </p>
                                        </div>
                                        <div class="reviewer-check">
                                            <svg
                                                class="w-3 h-3 text-white"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="3"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div
                        class="border-t border-slate-100 pt-5 flex flex-col sm:flex-row sm:items-end gap-4"
                    >
                        <div class="flex-1">
                            <label
                                for="due_at"
                                class="block text-xs font-bold uppercase tracking-[.07em] text-slate-500 mb-2"
                            >
                                Review Deadline
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="relative">
                                <svg
                                    class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <rect
                                        x="3"
                                        y="4"
                                        width="18"
                                        height="18"
                                        rx="2"
                                        stroke-width="2"
                                    />
                                    <path
                                        d="M16 2v4M8 2v4M3 10h18"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                    />
                                </svg>
                                <input
                                    type="date"
                                    name="due_at"
                                    id="due_at"
                                    required
                                    min="{{ now()->addDay()->format('Y-m-d') }}"
                                    class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:border-red-400 transition-colors"
                                    onchange="updateDueDateHint(this)"
                                />
                            </div>
                            <p
                                id="due-hint"
                                class="text-xs mt-1.5 text-slate-400 hidden"
                            >
                                Reviewer will have
                                <span id="due-days" class="font-bold"></span>
                                days to complete the review.
                                <br>
                                <span id="due-date" class="text-slate-500 font-mono mt-1 inline-block">Deadline: </span>
                            </p>
                        </div>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all hover:-translate-y-0.5 whitespace-nowrap"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            Send Assignment
                        </button>
                    </div>

                    <div
                        class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-xl p-4"
                    >
                        <svg
                            class="w-4 h-4 text-blue-500 mt-0.5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            The selected reviewer will receive an
                            <strong>invitation notification</strong>
                            with the deadline. They can
                            <strong>accept</strong>
                            or
                            <strong>decline</strong>
                            the assignment before proceeding with the review.
                        </p>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function toggleReviewer(card) {
            const checkbox = card.querySelector('.reviewer-checkbox');
            if (!checkbox) return;

            // Toggle checkbox state
            checkbox.checked = !checkbox.checked;

            // Visual toggle
            card.classList.toggle('selected', checkbox.checked);

            // Update selected count badge
            const total = document.querySelectorAll('.reviewer-checkbox:checked').length;
            const badge = document.getElementById('selected-count');
            const num = document.getElementById('selected-num');

            if (badge && num) {
                num.textContent = total;
                badge.classList.toggle('hidden', total === 0);
            }
        }

        function updateDueDateHint(input) {
            const hint = document.getElementById('due-hint');
            const daysSpan = document.getElementById('due-days');
            const dateSpan = document.getElementById('due-date');
            if (!input.value || !hint) {
                if(hint) hint.classList.add('hidden');
                return;
            }
            const diff = Math.ceil(
                (new Date(input.value) - new Date()) / (1000 * 60 * 60 * 24),
            );
            daysSpan.textContent = diff;
            daysSpan.className =
                diff <= 7
                    ? 'font-bold text-amber-600'
                    : diff < 0
                      ? 'font-bold text-red-600'
                      : 'font-bold text-emerald-600';

            // Format the deadline date with time
            const dueDate = new Date(input.value);
            const options = { month: 'short', day: 'numeric', year: 'numeric' };
            const formattedDate = dueDate.toLocaleDateString('en-US', options);
            dateSpan.textContent = 'Deadline: ' + formattedDate + ' • 11:59 PM';
            dateSpan.className = 'text-slate-500 font-mono mt-1 inline-block';

            hint.classList.remove('hidden');
        }

        const decisionForm = document.getElementById('decision-form');
        const revisionFields = document.getElementById('revision-fields');
        const revisionReason = document.getElementById('revision_reason');

        if (decisionForm && revisionFields) {
            const statusRadios = decisionForm.querySelectorAll('input[name="status"]');
            const revTypeRadios = decisionForm.querySelectorAll('input[name="revision_type"]');

            function toggleRevision() {
                const selected = decisionForm.querySelector('input[name="status"]:checked');
                const isRev = selected?.value === 'revisions_requested';
                revisionFields.classList.toggle('hidden', !isRev);

                revTypeRadios.forEach((r) =>
                    isRev ? r.setAttribute('required', '') : r.removeAttribute('required')
                );

                if (revisionReason) {
                    isRev ? revisionReason.setAttribute('required', '') : revisionReason.removeAttribute('required');
                }
            }

            statusRadios.forEach((r) => r.addEventListener('change', toggleRevision));

            decisionForm.addEventListener('submit', () => {
                const selected = decisionForm.querySelector('input[name="status"]:checked');
                if (selected?.value !== 'revisions_requested') {
                    revTypeRadios.forEach((r) => (r.disabled = true));
                    if (revisionReason) revisionReason.disabled = true;
                }
            });

            toggleRevision();
        }
    </script>
@endpush
