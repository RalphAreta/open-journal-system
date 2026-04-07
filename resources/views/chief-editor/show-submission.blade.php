@php
    use App\Models\Submission;
@endphp

@extends('layouts.app')

@section('title', 'Review & Assign Submission')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-d: #236860;
            --gold: #c9a84c;
            --gold-l: #f0d678;
            --ink: #0d1628;
            --mist: #f5f0e8;
            --red: #dc2626;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        .fade-up {
            opacity: 0;
            animation: fadeUp 0.5s cubic-bezier(0.22, 0.68, 0, 1.2) forwards;
        }
        .fade-up-1 {
            opacity: 0;
            animation: fadeUp 0.5s 0.08s cubic-bezier(0.22, 0.68, 0, 1.2)
                forwards;
        }
        .fade-up-2 {
            opacity: 0;
            animation: fadeUp 0.5s 0.16s cubic-bezier(0.22, 0.68, 0, 1.2)
                forwards;
        }

        .shimmer-bar {
            background: linear-gradient(
                90deg,
                transparent,
                var(--gold),
                var(--gold-l),
                var(--gold),
                transparent
            );
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        /* Cards */
        .card {
            background: #fff;
            border: 1.5px solid #ede8e0;
            border-radius: 18px;
            overflow: hidden;
        }
        .card-header {
            padding: 12px 16px;
            border-bottom: 1px solid #ede8e0;
            background: linear-gradient(to right, #faf8f5, #f5f0e8);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }
        @media (min-width: 640px) {
            .card-header {
                padding: 14px 20px;
            }
        }
        .card-body {
            padding: 14px;
        }
        @media (min-width: 640px) {
            .card-body {
                padding: 20px;
            }
        }

        .field-label {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: #b0aaa0;
            margin-bottom: 4px;
        }
        .field-value {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
        }

        /* Status badge */
        .s-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 100px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border: 1px solid transparent;
            white-space: nowrap;
        }
        .s-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .s-badge.submitted {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }
        .s-badge.submitted .dot {
            background: #2563eb;
        }
        .s-badge.under_review {
            background: #fffbeb;
            border-color: #fde68a;
            color: #b45309;
        }
        .s-badge.under_review .dot {
            background: #d97706;
        }
        .s-badge.accepted {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #15803d;
        }
        .s-badge.accepted .dot {
            background: #16a34a;
        }
        .s-badge.rejected {
            background: #fff5f5;
            border-color: #fecaca;
            color: #b91c1c;
        }
        .s-badge.rejected .dot {
            background: #dc2626;
        }
        .s-badge.default {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #475569;
        }
        .s-badge.default .dot {
            background: #94a3b8;
        }

        /* Keyword chip */
        .kw-chip {
            display: inline-flex;
            padding: 3px 10px;
            border-radius: 100px;
            background: rgba(45, 129, 118, 0.07);
            border: 1px solid rgba(45, 129, 118, 0.15);
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: var(--teal);
        }

        /* Field badge */
        .field-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 100px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--red);
        }

        /* Screening states */
        .screen-pass {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-radius: 14px;
            padding: 14px;
        }
        .screen-fail {
            background: #fff5f5;
            border: 1.5px solid #fecaca;
            border-radius: 14px;
            padding: 14px;
        }
        .screen-pending {
            background: #fffbeb;
            border: 1.5px solid #fde68a;
            border-radius: 14px;
            padding: 14px;
            text-align: center;
        }
        @media (min-width: 640px) {
            .screen-pass,
            .screen-fail,
            .screen-pending {
                padding: 16px;
            }
        }

        /* Revision item */
        .revision-item {
            border: 1px solid #ede8e0;
            border-radius: 12px;
            overflow: hidden;
        }
        .revision-item.revised {
            border-left: 3px solid #16a34a;
        }
        .revision-item.pending {
            border-left: 3px solid #d97706;
        }

        /* Editor checkbox card */
        .editor-option {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1.5px solid #ede8e0;
            background: #fff;
            cursor: pointer;
            transition:
                border-color 0.15s,
                background 0.15s;
        }
        .editor-option:has(input:checked) {
            border-color: var(--teal);
            background: rgba(45, 129, 118, 0.04);
        }
        .editor-option input[type='checkbox'],
        .editor-option input[type='radio'] {
            width: 15px;
            height: 15px;
            accent-color: var(--teal);
            margin-top: 2px;
            flex-shrink: 0;
            cursor: pointer;
        }

        /* Assignment history item */
        .hist-item {
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #ede8e0;
            border-left-width: 3px;
            background: #fff;
        }
        .hist-item.accepted {
            border-left-color: #16a34a;
        }
        .hist-item.rejected {
            border-left-color: var(--red);
        }
        .hist-item.pending {
            border-left-color: #d97706;
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 11px 20px;
            border-radius: 12px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            background: var(--teal);
            color: #fff;
            border: none;
            cursor: pointer;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 12px rgba(45, 129, 118, 0.25);
        }
        .btn-primary:hover:not(:disabled) {
            background: var(--teal-d);
            transform: translateY(-1px);
        }
        .btn-primary:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px 20px;
            border-radius: 12px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            background: #f5f0e8;
            color: #9ea8b8;
            border: 1.5px solid #e2ddd4;
            cursor: pointer;
            transition:
                background 0.15s,
                color 0.15s;
            margin-top: 8px;
        }
        .btn-secondary:hover {
            background: #ede8e0;
            color: #6a7890;
        }

        .btn-screen {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            text-decoration: none;
            transition: all 0.15s;
        }
        @media (min-width: 640px) {
            .btn-screen {
                padding: 9px 18px;
            }
        }
        .btn-screen-amber {
            background: #d97706;
            color: #fff;
        }
        .btn-screen-amber:hover {
            background: #b45309;
        }
        .btn-screen-green {
            color: #15803d;
            font-size: 11px;
        }
        .btn-screen-green:hover {
            color: #166534;
        }
        .btn-screen-red {
            color: #b91c1c;
            font-size: 11px;
        }
        .btn-screen-red:hover {
            color: #991b1b;
        }

        /* Workflow steps */
        .workflow-step {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px 0;
        }
        .step-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--teal);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 900;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .assigned-editor-card {
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
        }

        /* Screen pass/fail inner grid — 1-col on mobile, 2-col on sm+ */
        .screen-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }
        @media (min-width: 480px) {
            .screen-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen font-['Source_Sans_3']"
        style="
            background: linear-gradient(
                135deg,
                #f5f0e8 0%,
                #ede5d5 50%,
                #e8e0f0 100%
            );
        "
    >
        <div class="fixed top-0 left-0 right-0 h-0.5 shimmer-bar z-50"></div>

        <div class="max-w-6xl mx-auto py-6 sm:py-8 px-4 sm:px-6">
            {{-- Back + Header --}}
            <div class="fade-up mb-5 sm:mb-6">
                <a
                    href="{{ route('chief-editor.dashboard') }}"
                    class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-[#b0aaa0] hover:text-[color:var(--teal)] transition-colors mb-3"
                >
                    <svg
                        class="w-3 h-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2.5"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                    Back to Dashboard
                </a>
                <div class="flex items-start justify-between gap-3 flex-wrap">
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-[9px] font-black uppercase tracking-[.2em] text-[color:var(--teal)] mb-1"
                        >
                            Chief Editor · Review & Assign
                        </p>
                        <h1
                            class="font-['Libre_Baskerville'] text-xl sm:text-2xl font-bold text-[color:var(--ink)] leading-snug"
                        >
                            {{ $submission->title }}
                        </h1>
                        <p class="text-sm text-[#8a96a8] mt-1">
                            by
                            <span class="font-semibold text-[#6a7890]">
                                {{ $submission->author->name }}
                            </span>
                        </p>
                    </div>
                    @php
                        $sc = match ($submission->status) {
                            'submitted' => 'submitted',
                            'under_review' => 'under_review',
                            'accepted' => 'accepted',
                            'rejected' => 'rejected',
                            default => 'default',
                        };
                    @endphp

                    <span class="s-badge {{ $sc }} mt-1 shrink-0">
                        <span class="dot"></span>
                        {{ Submission::statusOptions()[$submission->status] ?? $submission->status }}
                    </span>
                </div>
            </div>

            <div
                class="@if ($submission->hasPassedInitialScreening()) grid grid-cols-1 lg:grid-cols-3 gap-5 @else space-y-4 @endif"
            >
                {{-- ── LEFT: Main Details ── --}}
                <div
                    class="@if ($submission->hasPassedInitialScreening()) lg:col-span-2 @endif space-y-4 fade-up-1"
                >
                    {{-- Submission Details --}}
                    <div class="card">
                        <div class="card-header">
                            <h2
                                class="font-['Libre_Baskerville'] text-sm font-bold text-[color:var(--ink)]"
                            >
                                Submission Details
                            </h2>
                            @if ($originalFileExists)
                                <a
                                    href="{{ route('submissions.download-original', $submission) }}"
                                    class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider text-[color:var(--teal)] hover:text-[color:var(--teal-d)] transition-colors"
                                >
                                    <svg
                                        class="w-3.5 h-3.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2.5"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                        />
                                    </svg>
                                    Download File
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            {{-- 1-col mobile, 2-col sm+ --}}
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-4"
                            >
                                <div>
                                    <p class="field-label">Research Field</p>
                                    <span class="field-badge">
                                        {{ $submission->research_field ?? 'Not specified' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="field-label">Submitted</p>
                                    <p class="field-value text-sm">
                                        {{ $submission->submitted_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-[10px] text-[#b0aaa0]">
                                        {{ $submission->submitted_at->format('h:i A') }}
                                    </p>
                                </div>
                            </div>

                            @if ($submission->keywords)
                                <div class="mb-4">
                                    <p class="field-label mb-2">Keywords</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach (explode(',', $submission->keywords) as $kw)
                                            <span class="kw-chip">
                                                {{ trim($kw) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div>
                                <p class="field-label mb-1">Abstract</p>
                                <p
                                    class="text-sm text-[#4a5568] leading-relaxed text-justify"
                                >
                                    {{ $submission->abstract }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Initial Screening --}}
                    <div class="card">
                        <div class="card-header">
                            <h2
                                class="font-['Libre_Baskerville'] text-sm font-bold text-[color:var(--ink)]"
                            >
                                Initial Screening
                            </h2>
                        </div>
                        <div class="card-body">
                            @if ($submission->isPendingInitialScreening())
                                <div class="screen-pending">
                                    <p
                                        class="font-['Libre_Baskerville'] font-bold text-amber-800 mb-2"
                                    >
                                        ⏳ Pending Initial Screening
                                    </p>
                                    <p class="text-xs text-amber-700 mb-3">
                                        This manuscript has not been screened
                                        yet.
                                    </p>
                                    <a
                                        href="{{ route('chief-editor.initial-screening', $submission) }}"
                                        class="btn-screen btn-screen-amber"
                                    >
                                        Perform Initial Screening →
                                    </a>
                                </div>
                            @elseif ($submission->hasPassedInitialScreening())
                                <div class="screen-pass">
                                    <div
                                        class="flex items-start sm:items-center justify-between gap-2 mb-3 flex-wrap"
                                    >
                                        <p
                                            class="font-['Libre_Baskerville'] font-bold text-emerald-800"
                                        >
                                            ✓ Passed Initial Screening
                                        </p>
                                        <a
                                            href="{{ route('chief-editor.initial-screening', $submission) }}"
                                            class="btn-screen btn-screen-green"
                                        >
                                            Edit Decision
                                        </a>
                                    </div>
                                    <div class="screen-grid">
                                        <div>
                                            <p
                                                class="field-label"
                                                style="color: #166534"
                                            >
                                                Screened By
                                            </p>
                                            <p
                                                class="text-sm font-semibold text-emerald-900"
                                            >
                                                {{ $submission->initialScreeningBy?->name ?? 'Unknown' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p
                                                class="field-label"
                                                style="color: #166534"
                                            >
                                                Date
                                            </p>
                                            <p
                                                class="text-sm font-semibold text-emerald-900"
                                            >
                                                {{ $submission->initial_screening_at?->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            class="field-label mb-1"
                                            style="color: #166534"
                                        >
                                            Comments
                                        </p>
                                        <p class="text-sm text-emerald-900">
                                            {{ $submission->initial_screening_comments }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="screen-fail">
                                    <div
                                        class="flex items-start sm:items-center justify-between gap-2 mb-3 flex-wrap"
                                    >
                                        <p
                                            class="font-['Libre_Baskerville'] font-bold text-red-800"
                                        >
                                            ✗ Failed Initial Screening
                                        </p>
                                        <a
                                            href="{{ route('chief-editor.initial-screening', $submission) }}"
                                            class="btn-screen btn-screen-red"
                                        >
                                            Override Decision
                                        </a>
                                    </div>
                                    <div class="screen-grid">
                                        <div>
                                            <p
                                                class="field-label"
                                                style="color: #991b1b"
                                            >
                                                Screened By
                                            </p>
                                            <p
                                                class="text-sm font-semibold text-red-900"
                                            >
                                                {{ $submission->initialScreeningBy?->name ?? 'Unknown' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p
                                                class="field-label"
                                                style="color: #991b1b"
                                            >
                                                Date
                                            </p>
                                            <p
                                                class="text-sm font-semibold text-red-900"
                                            >
                                                {{ $submission->initial_screening_at?->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            class="field-label mb-1"
                                            style="color: #991b1b"
                                        >
                                            Comments
                                        </p>
                                        <p class="text-sm text-red-900">
                                            {{ $submission->initial_screening_comments }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Revision History --}}
                    @if ($submission->revisionRequests()->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h2
                                    class="font-['Libre_Baskerville'] text-sm font-bold text-[color:var(--ink)]"
                                >
                                    Revision History
                                </h2>
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest text-[#b0aaa0]"
                                >
                                    {{ $submission->revisionRequests()->count() }}
                                    request(s)
                                </span>
                            </div>
                            <div class="card-body space-y-3">
                                @foreach ($submission->revisionRequests()->with('requestedBy')->latest('requested_at')->get() as $rev)
                                    <div
                                        class="revision-item {{ $rev->revised_at ? 'revised' : 'pending' }}"
                                    >
                                        <div class="p-3">
                                            <div
                                                class="flex items-start justify-between gap-2 mb-2"
                                            >
                                                <div>
                                                    <span
                                                        class="text-sm font-bold text-[color:var(--ink)]"
                                                    >
                                                        {{ ucfirst($rev->revision_type) }}
                                                        Revision
                                                    </span>
                                                    <p
                                                        class="text-[10px] text-[#b0aaa0] mt-0.5"
                                                    >
                                                        by
                                                        {{ $rev->requestedBy?->name ?? 'Unknown' }}
                                                        ·
                                                        {{ $rev->requested_at->format('M d, Y') }}
                                                    </p>
                                                </div>
                                                @if ($rev->revised_at)
                                                    <span
                                                        class="s-badge accepted shrink-0"
                                                    >
                                                        <span
                                                            class="dot"
                                                        ></span>
                                                        Revised
                                                    </span>
                                                @else
                                                    <span
                                                        class="s-badge under_review shrink-0"
                                                    >
                                                        <span
                                                            class="dot"
                                                        ></span>
                                                        Pending
                                                    </span>
                                                @endif
                                            </div>
                                            <div
                                                class="bg-[#faf8f5] rounded-lg p-3 mb-2"
                                            >
                                                <p class="field-label mb-1">
                                                    Reason
                                                </p>
                                                <p
                                                    class="text-sm text-[#4a5568]"
                                                >
                                                    {{ $rev->reason }}
                                                </p>
                                            </div>
                                            @if ($rev->revised_at)
                                                <div
                                                    class="bg-emerald-50 rounded-lg p-3"
                                                >
                                                    <p
                                                        class="field-label mb-1"
                                                        style="color: #166534"
                                                    >
                                                        Author's Notes ·
                                                        <span
                                                            class="normal-case font-normal"
                                                        >
                                                            {{ $rev->revised_at->format('M d, Y') }}
                                                        </span>
                                                    </p>
                                                    <p
                                                        class="text-sm text-emerald-900"
                                                    >
                                                        {{ $rev->revision_notes }}
                                                    </p>
                                                    @if ($submission->file_name)
                                                        <div
                                                            class="mt-2 pt-2 border-t border-emerald-200"
                                                        >
                                                            <a
                                                                href="{{ route('submissions.download', $submission) }}"
                                                                class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-900"
                                                            >
                                                                📥 Download
                                                                Revised File
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Appeal Decision --}}
                    @if ($latestAppeal)
                        <div class="card">
                            <div class="card-header">
                                <h2
                                    class="font-['Libre_Baskerville'] text-sm font-bold text-[color:var(--ink)]"
                                >
                                    Appeal Decision
                                </h2>
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest text-[#b0aaa0]"
                                >
                                    {{ ucfirst($latestAppeal->status) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <p class="field-label mb-2">
                                        Appeal Reason
                                    </p>
                                    <div class="bg-[#faf8f5] rounded-lg p-3">
                                        <p class="text-sm text-[#4a5568]">
                                            {{ $latestAppeal->reason }}
                                        </p>
                                    </div>
                                </div>

                                @if (! $latestAppeal->isPending())
                                    <div class="border-t border-[#e8dfd0] pt-4">
                                        <div
                                            style="
                                                border-radius: 12px;
                                                padding: 16px;
                                                background: {{ $latestAppeal->isApproved() ? '#f0fdf4' : '#fef2f2' }};
                                                border: 1.5px solid
                                                    {{ $latestAppeal->isApproved() ? '#a7f3d0' : '#fecaca' }};
                                                margin-bottom: 16px;
                                            "
                                        >
                                            <div
                                                style="
                                                    display: flex;
                                                    align-items: flex-start;
                                                    gap: 12px;
                                                    flex-wrap: wrap;
                                                "
                                            >
                                                <div
                                                    style="
                                                        width: 44px;
                                                        height: 44px;
                                                        border-radius: 10px;
                                                        background: {{ $latestAppeal->isApproved() ? 'rgba(5,150,105,.15)' : 'rgba(220,38,38,.15)' }};
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                        flex-shrink: 0;
                                                    "
                                                >
                                                    @if ($latestAppeal->isApproved())
                                                        <svg
                                                            width="20"
                                                            height="20"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="#059669"
                                                            stroke-width="2.5"
                                                        >
                                                            <path
                                                                d="M5 13l4 4L19 7"
                                                            />
                                                        </svg>
                                                    @else
                                                        <svg
                                                            width="20"
                                                            height="20"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="#dc2626"
                                                            stroke-width="2.5"
                                                        >
                                                            <path
                                                                d="M6 18L18 6M6 6l12 12"
                                                            />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div
                                                    style="
                                                        flex: 1;
                                                        min-width: 0;
                                                    "
                                                >
                                                    <h4
                                                        style="
                                                            font-family:
                                                                'Libre Baskerville',
                                                                serif;
                                                            font-size: 1rem;
                                                            font-weight: 700;
                                                            color: {{ $latestAppeal->isApproved() ? '#065f46' : '#991b1b' }};
                                                        "
                                                    >
                                                        Appeal
                                                        {{ $latestAppeal->isApproved() ? 'Approved' : 'Rejected' }}
                                                    </h4>
                                                    <p
                                                        style="
                                                            font-size: 11px;
                                                            color: {{ $latestAppeal->isApproved() ? '#059669' : '#dc2626' }};
                                                            margin-top: 4px;
                                                            font-family:
                                                                'Courier New',
                                                                monospace;
                                                            word-break: break-word;
                                                        "
                                                    >
                                                        Reviewed on
                                                        {{ $latestAppeal->reviewed_at->format('M d, Y \a\t g:i A') }}
                                                        @if ($latestAppeal->reviewedBy)
                                                            · by
                                                            <strong>
                                                                {{ $latestAppeal->reviewedBy->name }}
                                                            </strong>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            @if ($latestAppeal->editor_response)
                                                <div
                                                    style="
                                                        padding-top: 14px;
                                                        border-top: 1px solid
                                                            {{ $latestAppeal->isApproved() ? '#a7f3d0' : '#fecaca' }};
                                                        margin-top: 14px;
                                                    "
                                                >
                                                    <p
                                                        class="field-label"
                                                        style="
                                                            color: {{ $latestAppeal->isApproved() ? '#059669' : '#dc2626' }};
                                                            margin-bottom: 8px;
                                                        "
                                                    >
                                                        Editor's Response
                                                    </p>
                                                    <p
                                                        style="
                                                            font-size: 13px;
                                                            color: {{ $latestAppeal->isApproved() ? '#065f46' : '#7f1d1d' }};
                                                            line-height: 1.75;
                                                            word-break: break-word;
                                                            overflow-wrap: break-word;
                                                        "
                                                    >
                                                        {{ $latestAppeal->editor_response }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div
                                        style="
                                            padding: 12px;
                                            background: #fef3c7;
                                            border: 1px solid #fbbf24;
                                            border-radius: 8px;
                                            display: flex;
                                            gap: 10px;
                                            align-items: center;
                                            margin-top: 16px;
                                        "
                                    >
                                        <svg
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#d97706"
                                            stroke-width="2"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="10"
                                            ></circle>
                                            <line
                                                x1="12"
                                                y1="8"
                                                x2="12"
                                                y2="12"
                                            ></line>
                                            <line
                                                x1="12"
                                                y1="16"
                                                x2="12.01"
                                                y2="16"
                                            ></line>
                                        </svg>
                                        <p
                                            style="
                                                font-size: 13px;
                                                color: #b45309;
                                            "
                                        >
                                            This appeal is still pending review.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ── RIGHT: Assignment Panel ── --}}
                @if ($submission->hasPassedInitialScreening())
                    <div class="lg:col-span-1 space-y-4 fade-up-2">
                        {{-- Currently Assigned --}}
                        @php
                            $currentAssignments = $submission
                                ->assignments()
                                ->whereNull('rejected_at')
                                ->latest('assigned_at')
                                ->get();
                        @endphp

                        @if ($currentAssignments->count() > 0)
                            <div class="card" id="assignments-card">
                                <div class="card-header">
                                    <h3
                                        class="font-['Libre_Baskerville'] text-sm font-bold text-emerald-700"
                                    >
                                        ✓ Currently Assigned
                                    </h3>
                                </div>
                                <div class="card-body space-y-2">
                                    @foreach ($currentAssignments as $ca)
                                        <div class="assigned-editor-card">
                                            <p
                                                class="text-sm font-bold text-[color:var(--ink)]"
                                            >
                                                {{ $ca->assignedTo->name }}
                                            </p>
                                            <p
                                                class="text-[10px] text-[#b0aaa0]"
                                            >
                                                {{ $ca->expertise_field }}
                                            </p>
                                            @if ($ca->isAccepted())
                                                <span
                                                    class="text-[10px] font-black text-emerald-600 uppercase tracking-wider"
                                                >
                                                    ✓ Accepted
                                                </span>
                                            @elseif ($ca->isPending())
                                                <span
                                                    class="text-[10px] font-black text-amber-600 uppercase tracking-wider"
                                                >
                                                    ⏳ Pending
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach

                                    <button
                                        type="button"
                                        onclick="
                                            document.getElementById(
                                                'reassign-form',
                                            ).style.display = 'block';
                                            document.getElementById(
                                                'assignments-card',
                                            ).style.display = 'none';
                                        "
                                        class="w-full text-[10px] font-black uppercase tracking-widest text-[color:var(--teal)] hover:text-[color:var(--teal-d)] transition-colors pt-1"
                                    >
                                        Change Assignments →
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Assign / Reassign Form --}}
                        <div
                            class="card"
                            id="reassign-form"
                            {{ $submission->assignedEditor ? 'style=display:none' : '' }}
                        >
                            <div class="card-header">
                                <h3
                                    class="font-['Libre_Baskerville'] text-sm font-bold text-[color:var(--ink)]"
                                >
                                    {{ $submission->assignedEditor ? 'Reassign Editors' : 'Assign Editors' }}
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-[11px] text-[#8a96a8] mb-3">
                                    Matched to
                                    <span
                                        class="font-black text-[color:var(--red)]"
                                    >
                                        {{ $researchField }}
                                    </span>
                                </p>

                                <form
                                    method="POST"
                                    action="{{ ! $submission->assignedEditor ? route('chief-editor.assign', $submission) : route('chief-editor.reassign', $submission) }}"
                                >
                                    @csrf

                                    <div
                                        class="space-y-2 mb-4 max-h-64 overflow-y-auto pr-1"
                                    >
                                        @if (! empty($editorsByField))
                                            @foreach ($editorsByField as $field => $editors)
                                                <div class="mb-2">
                                                    <p
                                                        class="text-[9px] font-black uppercase tracking-[.15em] text-[color:var(--teal)] mb-1.5 flex items-center gap-1"
                                                    >
                                                        <span
                                                            class="w-1.5 h-1.5 rounded-full bg-[color:var(--teal)]"
                                                        ></span>
                                                        {{ $field }} · Matched
                                                    </p>
                                                    <div class="space-y-1.5">
                                                        @foreach ($editors as $editor)
                                                            @php
                                                                $activeCount = $editor->active_assignments_count ?? 0;
                                                                $isAssignedHere = $submission
                                                                    ->assignments()
                                                                    ->whereNull('rejected_at')
                                                                    ->where('assigned_to_user_id', $editor->id)
                                                                    ->exists();
                                                            @endphp

                                                            <label
                                                                class="editor-option"
                                                            >
                                                                <input
                                                                    type="radio"
                                                                    name="editor_id"
                                                                    value="{{ $editor->id }}"
                                                                    class="editor-cb"
                                                                    {{ $isAssignedHere ? 'checked' : '' }}
                                                                />
                                                                <div
                                                                    class="min-w-0 flex-1"
                                                                >
                                                                    <p
                                                                        class="text-sm font-bold text-[color:var(--ink)] truncate"
                                                                    >
                                                                        {{ $editor->name }}
                                                                        @if ($isAssignedHere)
                                                                            <span
                                                                                class="text-[9px] font-black text-emerald-600 ml-1"
                                                                            >
                                                                                ✓
                                                                            </span>
                                                                        @endif
                                                                    </p>
                                                                    <p
                                                                        class="text-[10px] text-[#b0aaa0] truncate"
                                                                    >
                                                                        {{ $editor->email }}
                                                                    </p>
                                                                    <p
                                                                        class="text-[10px] font-bold mt-0.5 {{ $activeCount === 0 ? 'text-emerald-600' : ($activeCount <= 3 ? 'text-amber-600' : 'text-red-500') }}"
                                                                    >
                                                                        {{ $activeCount === 0 ? '✓ Available' : $activeCount . ' active' }}
                                                                    </p>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div
                                                class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 font-medium"
                                            >
                                                ⚠️ No editors matched for
                                                <strong>
                                                    {{ $researchField }}
                                                </strong>
                                            </div>
                                        @endif

                                        @php
                                            $otherFields = array_diff_key($allEditorsByField, $editorsByField);
                                        @endphp

                                        @if (! empty($otherFields))
                                            <div>
                                                <button
                                                    type="button"
                                                    onclick="toggleOthers()"
                                                    id="toggle-others-btn"
                                                    class="text-[10px] font-black uppercase tracking-wider text-[#b0aaa0] hover:text-[color:var(--teal)] transition-colors mt-1"
                                                >
                                                    + Show other editors
                                                </button>
                                                <div
                                                    id="other-editors"
                                                    class="hidden mt-2 space-y-1.5"
                                                >
                                                    <p
                                                        class="text-[9px] text-[#c0b8b0] italic mb-1"
                                                    >
                                                        Different expertise
                                                        fields
                                                    </p>
                                                    @foreach ($otherFields as $field => $editors)
                                                        <div class="mb-2">
                                                            <p
                                                                class="text-[9px] font-black uppercase tracking-[.15em] text-[#b0aaa0] mb-1.5"
                                                            >
                                                                {{ $field }}
                                                            </p>
                                                            <div
                                                                class="space-y-1.5"
                                                            >
                                                                @foreach ($editors as $editor)
                                                                    @php
                                                                        $activeCount = $editor->active_assignments_count ?? 0;
                                                                        $isAssignedHere = $submission
                                                                            ->assignments()
                                                                            ->whereNull('rejected_at')
                                                                            ->where('assigned_to_user_id', $editor->id)
                                                                            ->exists();
                                                                    @endphp

                                                                    <label
                                                                        class="editor-option"
                                                                    >
                                                                        <input
                                                                            type="radio"
                                                                            name="editor_id"
                                                                            value="{{ $editor->id }}"
                                                                            class="editor-cb"
                                                                            {{ $isAssignedHere ? 'checked' : '' }}
                                                                        />
                                                                        <div
                                                                            class="min-w-0 flex-1"
                                                                        >
                                                                            <p
                                                                                class="text-sm font-bold text-[color:var(--ink)] truncate"
                                                                            >
                                                                                {{ $editor->name }}
                                                                            </p>
                                                                            <p
                                                                                class="text-[10px] text-[#b0aaa0] truncate"
                                                                            >
                                                                                {{ $editor->email }}
                                                                            </p>
                                                                            <p
                                                                                class="text-[10px] font-bold mt-0.5 {{ $activeCount === 0 ? 'text-emerald-600' : ($activeCount <= 3 ? 'text-amber-600' : 'text-red-500') }}"
                                                                            >
                                                                                {{ $activeCount === 0 ? '✓ Available' : $activeCount . ' active' }}
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
                                        <p class="field-label mb-1.5">
                                            Notes (Optional)
                                        </p>
                                        <textarea
                                            name="notes"
                                            rows="3"
                                            placeholder="Add assignment notes..."
                                            class="w-full px-3 py-2.5 text-sm border border-[#e2ddd4] rounded-xl focus:border-[color:var(--teal)] focus:ring-2 focus:ring-[rgba(45,129,118,.1)] outline-none font-['Source_Sans_3'] resize-none transition-all"
                                        ></textarea>
                                    </div>

                                    <button
                                        type="submit"
                                        id="assign-btn"
                                        disabled
                                        class="btn-primary"
                                    >
                                        {{ $submission->assignedEditor ? '✓ Reassign' : '✓ Assign Editors' }}
                                    </button>

                                    @if ($submission->assignedEditor)
                                        <button
                                            type="button"
                                            onclick="
                                                document.getElementById(
                                                    'reassign-form',
                                                ).style.display = 'none';
                                                document.getElementById(
                                                    'assignments-card',
                                                ).style.display = 'block';
                                            "
                                            class="btn-secondary"
                                        >
                                            Cancel
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>

                        {{-- Assignment History --}}
                        @if ($submission->assignments()->count() > 0)
                            <div class="card">
                                <div class="card-header">
                                    <h3
                                        class="font-['Libre_Baskerville'] text-sm font-bold text-[color:var(--ink)]"
                                    >
                                        Assignment History
                                    </h3>
                                    <span
                                        class="text-[9px] font-black uppercase tracking-widest text-[#b0aaa0]"
                                    >
                                        {{ $submission->assignments()->count() }}
                                    </span>
                                </div>
                                <div class="card-body space-y-2">
                                    @foreach ($submission->assignments()->latest()->get() as $ha)
                                        <div
                                            class="hist-item {{ $ha->isAccepted() ? 'accepted' : ($ha->isRejected() ? 'rejected' : 'pending') }}"
                                        >
                                            <p
                                                class="text-sm font-bold text-[color:var(--ink)]"
                                            >
                                                {{ $ha->assignedTo->name }}
                                            </p>
                                            <p
                                                class="text-[10px] text-[#b0aaa0]"
                                            >
                                                {{ $ha->expertise_field }}
                                            </p>
                                            <div
                                                class="flex items-center justify-between mt-1"
                                            >
                                                <span
                                                    class="text-[10px] text-[#c0b8b0] font-mono"
                                                >
                                                    {{ $ha->assigned_at->format('M d, Y') }}
                                                </span>
                                                @if ($ha->isAccepted())
                                                    <span
                                                        class="text-[9px] font-black uppercase tracking-wider text-emerald-600"
                                                    >
                                                        ✓ Accepted
                                                    </span>
                                                @elseif ($ha->isRejected())
                                                    <span
                                                        class="text-[9px] font-black uppercase tracking-wider text-red-600"
                                                    >
                                                        ✗ Rejected
                                                    </span>
                                                @else
                                                    <span
                                                        class="text-[9px] font-black uppercase tracking-wider text-amber-600"
                                                    >
                                                        ⏳ Pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Workflow Info --}}
                        <div class="card">
                            <div class="card-header">
                                <h3
                                    class="font-['Libre_Baskerville'] text-sm font-bold text-[color:var(--ink)]"
                                >
                                    📋 Workflow
                                </h3>
                            </div>
                            <div class="card-body space-y-1">
                                @foreach ([
                                        'Screen the manuscript for eligibility',
                                        'Assign to a matched editor',
                                        'Editor distributes to reviewers',
                                        'Reviews collected & decision made',
                                        'Author notified of outcome'
                                    ]
                                    as $i => $step)
                                    <div class="workflow-step">
                                        <div class="step-num">
                                            {{ $i + 1 }}
                                        </div>
                                        <p
                                            class="text-xs text-[#6a7890] leading-relaxed pt-0.5"
                                        >
                                            {{ $step }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const checkboxes = document.querySelectorAll('.editor-cb');
        const assignBtn = document.getElementById('assign-btn');

        checkboxes.forEach((cb) => {
            cb.addEventListener('change', () => {
                if (assignBtn)
                    assignBtn.disabled = ![...checkboxes].some(
                        (c) => c.checked,
                    );
            });
        });
        if (assignBtn)
            assignBtn.disabled = ![...checkboxes].some((c) => c.checked);

        function toggleOthers() {
            const el = document.getElementById('other-editors');
            const btn = document.getElementById('toggle-others-btn');
            const hidden = el.classList.toggle('hidden');
            btn.textContent = hidden
                ? '+ Show other editors'
                : '− Hide other editors';
        }
    </script>
@endsection
