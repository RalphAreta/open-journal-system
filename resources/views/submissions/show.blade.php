@extends('layouts.app')

@section('title', $submission->title)

@push('styles')
    <style>
        .fu {
            animation: fu 0.45s ease both;
        }
        .fu1 {
            animation: fu 0.45s 0.07s ease both;
        }
        .fu2 {
            animation: fu 0.45s 0.14s ease both;
        }
        .fu3 {
            animation: fu 0.45s 0.21s ease both;
        }
        @keyframes fu {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .abstract-block::before {
            content: '\201C';
            font-family: 'Libre Baskerville', serif;
            font-size: 7rem;
            line-height: 1;
            color: #e8d49a;
            position: absolute;
            top: 4px;
            left: 20px;
            pointer-events: none;
        }
        @media (max-width: 640px) {
            .abstract-block::before {
                font-size: 5rem;
                left: 12px;
            }
        }

        /* ── Page outer padding on small screens ── */
        @media (max-width: 640px) {
            .page-wrap {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
        }

        /* ── Page header ── */
        .page-header-row {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }
        @media (max-width: 640px) {
            .page-header-row {
                flex-direction: column;
                gap: 16px;
            }
        }

        /* ── Header action buttons ── */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            align-self: flex-start;
            margin-top: 4px;
        }
        @media (max-width: 640px) {
            .header-actions {
                align-self: stretch;
                width: 100%;
            }
            .header-actions a {
                flex: 1;
                justify-content: center;
            }
        }

        /* ── Page title ── */
        .page-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #1a1209;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }
        @media (max-width: 640px) {
            .page-title {
                font-size: 1.55rem;
            }
        }
        @media (max-width: 400px) {
            .page-title {
                font-size: 1.35rem;
            }
        }

        /* ── Pending revision banner ── */
        .rev-banner-inner {
            flex: 1;
            padding: 16px 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        @media (max-width: 500px) {
            .rev-banner-inner {
                flex-direction: column;
                align-items: flex-start;
            }
            .rev-banner-inner a {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }

        /* ── Feedback trigger buttons ── */
        .feedback-btn-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        @media (max-width: 500px) {
            .feedback-btn-grid {
                flex-direction: column;
            }
            .feedback-btn-grid > button {
                width: 100%;
            }
        }

        /* ── Abstract block ── */
        .abstract-text {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.08rem;
            font-weight: 400;
            color: #3d2f1a;
            line-height: 1.8;
            position: relative;
            z-index: 10;
            padding-top: 12px;
            text-align: justify;
        }
        @media (max-width: 640px) {
            .abstract-text {
                font-size: 0.95rem;
                line-height: 1.75;
            }
        }

        /* ── Sidebar sticky ── */
        @media (max-width: 1023px) {
            .sidebar-sticky {
                position: static !important;
            }
        }

        /* ── Modal ── */
        .feedback-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(10, 20, 18, 0.55);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }
        @media (max-width: 640px) {
            .feedback-modal-backdrop {
                padding: 0;
                align-items: flex-end;
            }
        }
        .feedback-modal-backdrop.open {
            opacity: 1;
            pointer-events: all;
        }
        .feedback-modal {
            background: #faf6ef;
            border: 1px solid #c9b99a;
            border-radius: 18px;
            width: 100%;
            max-width: 680px;
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 60px rgba(10, 20, 18, 0.28);
            transform: translateY(18px) scale(0.97);
            transition: transform 0.28s cubic-bezier(0.34, 1.3, 0.64, 1);
        }
        @media (max-width: 640px) {
            .feedback-modal {
                max-width: 100%;
                max-height: 92vh;
                border-radius: 18px 18px 0 0;
                transform: translateY(100%);
            }
            .feedback-modal-backdrop.open .feedback-modal {
                transform: translateY(0) !important;
            }
        }
        .feedback-modal-backdrop.open .feedback-modal {
            transform: translateY(0) scale(1);
        }
        .feedback-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.4rem 1rem;
            border-bottom: 1px solid #e8dfd0;
            background: #f3ece0;
            border-radius: 18px 18px 0 0;
            flex-shrink: 0;
        }
        @media (max-width: 640px) {
            .feedback-modal-header {
                padding: 1rem 1rem 0.9rem;
            }
        }
        .feedback-modal-body {
            overflow-y: auto;
            padding: 1.25rem 1.4rem;
            flex: 1;
        }
        @media (max-width: 640px) {
            .feedback-modal-body {
                padding: 1rem 1rem;
            }
        }
        .feedback-modal-body::-webkit-scrollbar {
            width: 5px;
        }
        .feedback-modal-body::-webkit-scrollbar-track {
            background: #f3ece0;
            border-radius: 99px;
        }
        .feedback-modal-body::-webkit-scrollbar-thumb {
            background: #c9b99a;
            border-radius: 99px;
        }

        .open-modal-btn:hover {
            box-shadow: 0 4px 18px rgba(45, 129, 118, 0.22);
        }

        /* ── Manuscript file card truncation ── */
        .file-name-text {
            font-size: 0.78rem;
            font-weight: 600;
            color: #1a1209;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 100%;
            word-break: break-all;
        }

        /* ── Layout confirmation forms ── */
        @media (max-width: 640px) {
            .layout-confirm-form textarea {
                font-size: 1rem; /* prevent iOS auto-zoom */
            }
        }

        /* ── Keyword chips ── */
        .kw-chip {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            background: #f3ece0;
            border: 1px solid #e8dfd0;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: #6b5740;
            text-transform: capitalize;
        }

        /* ── Review card header ── */
        .review-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 14px 20px;
            background: #f3ece0;
            border-bottom: 1px solid #e8dfd0;
        }
        @media (max-width: 480px) {
            .review-card-header {
                padding: 12px 14px;
            }
        }
    </style>
@endpush

@section('content')
    <div
        class="page-wrap font-['Source_Sans_3',sans-serif] text-[#1a1209] max-w-7xl mx-auto px-1"
        style="
            background-color: #faf6ef;
            background-image: radial-gradient(
                ellipse 80% 50% at 50% -10%,
                rgba(45, 129, 118, 0.08) 0%,
                transparent 70%
            );
        "
    >
        {{-- ── Page Header ── --}}
        <div class="relative pt-10 pb-7 mb-9 border-b border-[#e8dfd0] fu">
            <div
                class="absolute bottom-px left-0 w-20 h-0.5"
                style="background: linear-gradient(90deg, #2d8176, transparent)"
            ></div>
            <div class="page-header-row">
                <div class="flex-1 min-w-0">
                    <nav
                        class="flex items-center gap-2 mb-3 text-[11px] font-bold tracking-[.18em] uppercase text-[#6b5740]"
                    >
                        <a
                            href="{{ route('submissions.index') }}"
                            class="hover:text-[#2d8176] transition-colors"
                        >
                            Dashboard
                        </a>
                        <svg
                            class="w-3 h-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M9 5l7 7-7 7" stroke-width="2.5" />
                        </svg>
                        <span class="text-[#1a1209]">
                            Manuscript
                            #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </nav>
                    <p
                        class="flex items-center gap-2 mb-2 text-[11px] font-bold tracking-[.2em] uppercase text-[#2d8176]"
                    >
                        <span class="inline-block w-6 h-px bg-[#2d8176]"></span>
                        Author Submissions
                    </p>
                    <h1 class="page-title">
                        {{ $submission->title }}
                    </h1>
                    <div
                        class="mt-3 w-14 h-0.5"
                        style="
                            background: linear-gradient(
                                90deg,
                                #2d8176,
                                transparent
                            );
                        "
                    ></div>
                </div>
                <div class="header-actions">
                    @if ($submission->isEditableByAuthor() && auth()->user()->id === $submission->author_id && $submission->status === 'submitted')
                        <a
                            href="{{ route('submissions.edit', $submission) }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-white border border-[#c9b99a] text-[.72rem] font-bold tracking-[.08em] uppercase text-[#6b5740] shadow-[0_2px_8px_rgba(26,18,9,.06)] hover:border-[#2d8176] hover:text-[#2d8176] hover:bg-[#e8f4f2] transition-all"
                        >
                            <svg
                                class="w-3.5 h-3.5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                />
                            </svg>
                            Edit
                        </a>
                    @endif

                    <a
                        href="{{ route('submissions.index') }}"
                        class="relative overflow-hidden inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#2d8176] hover:bg-[#1a4d46] text-white text-[.72rem] font-bold tracking-[.08em] uppercase transition-all shadow-[0_4px_14px_rgba(45,129,118,.28)] hover:-translate-y-0.5"
                    >
                        <span
                            class="absolute inset-0 pointer-events-none"
                            style="
                                background: linear-gradient(
                                    135deg,
                                    rgba(201, 168, 76, 0.18) 0%,
                                    transparent 60%
                                );
                            "
                        ></span>
                        <svg
                            class="w-3.5 h-3.5 relative z-10"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M15 19l-7-7 7-7"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <span class="relative z-10">Back to Board</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Main Layout ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-9">
            {{-- ════ LEFT COLUMN ════ --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Pending Revision Banner --}}
                @php
                    $pendingRevisions = $submission
                        ->revisionRequests()
                        ->whereNull('revised_at')
                        ->count();
                @endphp

                @if ($pendingRevisions > 0 && auth()->user()->id === $submission->author_id)
                    <div
                        class="fu1 flex overflow-hidden border border-[#fed7aa] rounded-[14px] shadow-[0_4px_20px_rgba(26,18,9,.09)]"
                        style="background: #fffdf9"
                    >
                        <div class="w-1.5 shrink-0 bg-[#f97316]"></div>
                        <div class="rev-banner-inner">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-[10px] shrink-0 bg-[#fff7ed] text-[#ea580c] flex items-center justify-center"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <p
                                        class="font-['Libre_Baskerville',serif] text-[1.05rem] font-bold text-[#1a1209]"
                                    >
                                        Revision Required
                                    </p>
                                    <p
                                        class="text-[.78rem] text-[#6b5740] mt-0.5"
                                    >
                                        {{ $pendingRevisions }} request(s)
                                        awaiting your response
                                    </p>
                                </div>
                            </div>
                            <a
                                href="{{ route('submissions.revisions', $submission) }}"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-[#ea580c] text-white text-[.68rem] font-bold tracking-[.08em] uppercase transition-all hover:bg-[#c2410c] hover:-translate-y-0.5 whitespace-nowrap"
                            >
                                Submit Revisions →
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Final Decision Banner --}}
                @if (in_array($submission->status, ['accepted', 'rejected']) && $submission->editor_decision_at)
                    @php
                        $isAcc = $submission->status === 'accepted';
                    @endphp

                    <div
                        class="fu1 flex overflow-hidden rounded-[14px] shadow-[0_4px_20px_rgba(26,18,9,.09)] border {{ $isAcc ? 'border-[rgba(45,129,118,.35)]' : 'border-[#fecaca]' }}"
                        style="
                            background: {{ $isAcc ? '#f5fdfb' : '#fffafa' }};
                        "
                    >
                        <div
                            class="w-1.5 shrink-0 {{ $isAcc ? 'bg-[#2d8176]' : 'bg-[#dc2626]' }}"
                        ></div>
                        <div
                            class="flex-1 px-5 py-4 flex flex-wrap items-center justify-between gap-4"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-[10px] shrink-0 flex items-center justify-center font-['Libre_Baskerville',serif] text-[1.1rem] font-bold {{ $isAcc ? 'bg-[#e8f4f2] text-[#2d8176]' : 'bg-[#fef2f2] text-[#dc2626]' }}"
                                >
                                    {{ $isAcc ? '✓' : '✕' }}
                                </div>
                                <div>
                                    <p
                                        class="font-['Libre_Baskerville',serif] text-[1.05rem] font-bold text-[#1a1209]"
                                    >
                                        Editorial Decision:
                                        {{ $isAcc ? 'Accepted' : 'Rejected' }}
                                    </p>
                                    <p
                                        class="text-[.78rem] text-[#6b5740] mt-0.5"
                                    >
                                        Decided on
                                        {{ $submission->editor_decision_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            @if ($submission->editor_notes)
                                <span
                                    class="text-[.74rem] italic text-[#6b5740]"
                                >
                                    See editorial feedback below ↓
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Abstract --}}
                <section class="fu1">
                    <div class="flex items-center gap-3 mb-5">
                        <span
                            class="text-[.6rem] font-extrabold tracking-[.16em] uppercase text-[#8a6e28] flex items-center gap-2"
                        >
                            <span
                                class="inline-block w-4 h-px bg-[#c9a84c]"
                            ></span>
                            Abstract
                        </span>
                        <div
                            class="flex-1 h-px"
                            style="
                                background: linear-gradient(
                                    90deg,
                                    #e8dfd0,
                                    transparent
                                );
                            "
                        ></div>
                    </div>
                    <div
                        class="abstract-block relative bg-white border border-[#c9b99a] rounded-[14px] px-9 pt-8 pb-7 shadow-[0_2px_12px_rgba(26,18,9,.06)]"
                        style="
                            padding-left: clamp(20px, 6vw, 36px);
                            padding-right: clamp(16px, 4vw, 28px);
                        "
                    >
                        <p class="abstract-text">
                            {{ $submission->abstract }}
                        </p>
                    </div>
                </section>

                {{-- Appeal Section --}}
                @include('submissions.partials.appeal-section')

                {{-- ── Feedback Trigger Buttons ── --}}
                @php
                    $showPeerReviews =
                        $submission->reviews->isNotEmpty() &&
                        (auth()->user()->id === $submission->author_id ||
                            auth()
                                ->user()
                                ->isEditor() ||
                            auth()
                                ->user()
                                ->isAdmin());

                    $allRevisionReviews = [];
                    foreach ($submission->revisionRequests as $rev) {
                        foreach ($rev->revisionReviews as $revRev) {
                            if ($revRev->comments_for_author) {
                                $allRevisionReviews[] = $revRev;
                            }
                        }
                    }
                    $showRevisionFeedback =
                        ! empty($allRevisionReviews) &&
                        (auth()->user()->id === $submission->author_id ||
                            auth()
                                ->user()
                                ->isEditor() ||
                            auth()
                                ->user()
                                ->isAdmin());

                    $showEditorialFeedback = $submission->initial_screening_status !== 'pending' || $submission->initial_screening_comments || $submission->editor_notes;
                @endphp

                @if ($showPeerReviews || $showRevisionFeedback || $showEditorialFeedback)
                    <section class="fu2">
                        <div class="flex items-center gap-3 mb-5">
                            <span
                                class="text-[.6rem] font-extrabold tracking-[.16em] uppercase text-[#8a6e28] flex items-center gap-2"
                            >
                                <span
                                    class="inline-block w-4 h-px bg-[#c9a84c]"
                                ></span>
                                Feedback & Reviews
                            </span>
                            <div
                                class="flex-1 h-px"
                                style="
                                    background: linear-gradient(
                                        90deg,
                                        #e8dfd0,
                                        transparent
                                    );
                                "
                            ></div>
                        </div>

                        <div class="feedback-btn-grid">
                            @if ($showPeerReviews)
                                <button
                                    onclick="openModal('modal-peer-reviews')"
                                    class="open-modal-btn inline-flex items-center gap-3 px-5 py-3.5 rounded-[14px] bg-white border border-[#e8dfd0] hover:border-[#c9b99a] text-left transition-all group cursor-pointer"
                                >
                                    <div
                                        class="w-9 h-9 rounded-[10px] bg-[#fdf8ec] border border-[#e8dfd0] text-[#8a6e28] flex items-center justify-center shrink-0 group-hover:bg-[#f3ece0] transition-colors"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <p
                                            class="text-[.82rem] font-bold text-[#1a1209] group-hover:text-[#2d8176] transition-colors"
                                        >
                                            Peer Review Logs
                                        </p>
                                        <p
                                            class="text-[.68rem] text-[#6b5740] mt-0.5"
                                        >
                                            {{ $submission->reviews->count() }}
                                            {{ Str::plural('review', $submission->reviews->count()) }}
                                        </p>
                                    </div>
                                    <svg
                                        class="w-3.5 h-3.5 text-[#c9b99a] group-hover:text-[#2d8176] ml-1 transition-colors shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M9 5l7 7-7 7"
                                            stroke-width="2.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </button>
                            @endif

                            @if ($showRevisionFeedback)
                                <button
                                    onclick="
                                        openModal('modal-revision-feedback')
                                    "
                                    class="open-modal-btn inline-flex items-center gap-3 px-5 py-3.5 rounded-[14px] bg-white border border-[#e8dfd0] hover:border-[#c9b99a] text-left transition-all group cursor-pointer"
                                >
                                    <div
                                        class="w-9 h-9 rounded-[10px] bg-[#e8f4f2] border border-[rgba(45,129,118,.2)] text-[#2d8176] flex items-center justify-center shrink-0 group-hover:bg-[#d1ede9] transition-colors"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <p
                                            class="text-[.82rem] font-bold text-[#1a1209] group-hover:text-[#2d8176] transition-colors"
                                        >
                                            Revision Feedback
                                        </p>
                                        <p
                                            class="text-[.68rem] text-[#6b5740] mt-0.5"
                                        >
                                            {{ count($allRevisionReviews) }}
                                            {{ Str::plural('entry', count($allRevisionReviews)) }}
                                        </p>
                                    </div>
                                    <svg
                                        class="w-3.5 h-3.5 text-[#c9b99a] group-hover:text-[#2d8176] ml-1 transition-colors shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M9 5l7 7-7 7"
                                            stroke-width="2.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </button>
                            @endif

                            @if ($showEditorialFeedback)
                                <button
                                    onclick="
                                        openModal('modal-editorial-feedback')
                                    "
                                    class="open-modal-btn inline-flex items-center gap-3 px-5 py-3.5 rounded-[14px] bg-white border border-[#e8dfd0] hover:border-[#c9b99a] text-left transition-all group cursor-pointer"
                                >
                                    <div
                                        class="w-9 h-9 rounded-[10px] bg-[#fdf8ec] border border-[#e8dfd0] text-[#8a6e28] flex items-center justify-center shrink-0 group-hover:bg-[#f3ece0] transition-colors"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9v-2h2v2zm0-4H9V5h2v4z"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <p
                                            class="text-[.82rem] font-bold text-[#1a1209] group-hover:text-[#2d8176] transition-colors"
                                        >
                                            Editorial Feedback
                                        </p>
                                        <p
                                            class="text-[.68rem] text-[#6b5740] mt-0.5"
                                        >
                                            Screening · Editor notes · Appeals
                                        </p>
                                    </div>
                                    <svg
                                        class="w-3.5 h-3.5 text-[#c9b99a] group-hover:text-[#2d8176] ml-1 transition-colors shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M9 5l7 7-7 7"
                                            stroke-width="2.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </section>
                @endif
            </div>

            {{-- ════ RIGHT SIDEBAR ════ --}}
            <div class="lg:col-span-4">
                <div
                    class="sidebar-sticky bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden shadow-[0_2px_14px_rgba(26,18,9,.07)] sticky top-8 fu1"
                >
                    <div
                        class="flex items-center gap-2 px-5 py-4 bg-[#f3ece0] border-b border-[#e8dfd0] text-[.6rem] font-extrabold tracking-[.14em] uppercase text-[#8a6e28]"
                    >
                        <span class="inline-block w-4 h-px bg-[#c9a84c]"></span>
                        Manuscript Details
                    </div>
                    <div class="px-5 py-2 divide-y divide-[#f3ece0]">
                        <div class="py-4">
                            <p
                                class="text-[.6rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-2"
                            >
                                Current Status
                            </p>
                            @php
                                $screeningFailed = $submission->initial_screening_status === 'failed';

                                $sCls = $screeningFailed
                                    ? 'bg-[#fef2f2] border-[#fecaca] text-[#991b1b]'
                                    : match ($submission->status) {
                                        'accepted' => 'bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]',
                                        'under_review', 'revision_under_review' => 'bg-[#fdf8ec] border-[rgba(201,168,76,.4)] text-[#8a6e28]',
                                        'revisions_requested' => 'bg-[#fff7ed] border-[#fed7aa] text-[#9a3412]',
                                        'rejected' => 'bg-[#fef2f2] border-[#fecaca] text-[#991b1b]',
                                        default => 'bg-[#e8f4f2] border-[rgba(45,129,118,.3)] text-[#1a4d46]',
                                    };
                                $sDot = $screeningFailed
                                    ? 'bg-[#c0392b]'
                                    : match ($submission->status) {
                                        'accepted', 'under_review', 'revision_under_review' => 'bg-[#2d8176]',
                                        'revisions_requested' => 'bg-[#f97316]',
                                        'rejected' => 'bg-[#c0392b]',
                                        default => 'bg-[#2d8176]',
                                    };
                                $sLabel = $screeningFailed
                                    ? 'Failed Initial Screening'
                                    : match ($submission->status) {
                                        'revision_under_review' => 'Revision Review',
                                        default => ucfirst(str_replace('_', ' ', $submission->status)),
                                    };
                            @endphp

                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border text-[.72rem] font-bold tracking-[.06em] uppercase {{ $sCls }}"
                            >
                                <span
                                    class="w-1.5 h-1.5 rounded-full animate-pulse {{ $sDot }}"
                                ></span>
                                {{ $sLabel }}
                            </span>
                        </div>
                        <div class="py-4">
                            <p
                                class="text-[.6rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-1"
                            >
                                Corresponding Author
                            </p>
                            <p
                                class="font-['Libre_Baskerville',serif] text-[1rem] font-normal text-[#1a1209]"
                            >
                                {{ $submission->author->name }}
                            </p>
                        </div>
                        <div class="py-4">
                            <p
                                class="text-[.6rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-1"
                            >
                                Submission Date
                            </p>
                            <p
                                class="font-['Libre_Baskerville',serif] text-[1.3rem] font-bold text-[#1a1209] leading-none"
                            >
                                {{ $submission->submitted_at?->format('d M') ?? '—' }}
                            </p>
                            @if ($submission->submitted_at)
                                <p class="text-[.78rem] text-[#6b5740] mt-0.5">
                                    {{ $submission->submitted_at->format('Y') }}
                                </p>
                            @endif
                        </div>
                        @if ($submission->research_field)
                            <div class="py-4">
                                <p
                                    class="text-[.6rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-1"
                                >
                                    Research Field
                                </p>
                                <p
                                    class="text-[.9rem] font-medium text-[#1a1209]"
                                >
                                    {{ $submission->research_field }}
                                </p>
                            </div>
                        @endif

                        @if ($submission->keywords)
                            <div class="py-4">
                                <p
                                    class="text-[.6rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-2"
                                >
                                    Keywords
                                </p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach (explode(',', $submission->keywords) as $kw)
                                        <span class="kw-chip">
                                            {{ trim($kw) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($submission->file_name)
                            <div class="py-4 last:pb-0">
                                <p
                                    class="text-[.6rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-2"
                                >
                                    Manuscript File
                                </p>
                                <div
                                    class="flex items-center gap-3 px-4 py-3 bg-[#f3ece0] border border-[#e8dfd0] rounded-xl"
                                >
                                    <div
                                        class="w-10 h-10 rounded-lg shrink-0 bg-white border border-[#e8dfd0] flex items-center justify-center text-[#2d8176]"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </div>
                                    <div class="overflow-hidden min-w-0 flex-1">
                                        <p class="file-name-text">
                                            {{ $submission->file_name }}
                                        </p>
                                        <p
                                            class="text-[.62rem] text-[#6b5740] tracking-[.06em] uppercase mt-0.5"
                                        >
                                            Document
                                        </p>
                                    </div>
                                </div>
                                {{-- Layout File for Author --}}
                                @if (

                                    auth()->user()->id === $submission->author_id &&
                                    in_array($submission->status, ['author_confirmation', 'layout_review']) &&
                                    $submission
                                        ->layoutEditorAssignments()
                                        ->where('status', 'completed')
                                        ->exists()                                )
                                    @php
                                        $latestLayout = $submission
                                            ->layoutEditorAssignments()
                                            ->where('status', 'completed')
                                            ->latest('completed_at')
                                            ->first();
                                    @endphp

                                    @if ($latestLayout)
                                        <div class="py-4 last:pb-0">
                                            <p
                                                class="text-[.6rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-2"
                                            >
                                                🎨 Layout File
                                            </p>
                                            <div
                                                class="flex items-center gap-3 px-4 py-3 bg-[#e8f4f2] border border-[rgba(45,129,118,.3)] rounded-xl mb-3"
                                            >
                                                <div
                                                    class="w-10 h-10 rounded-lg shrink-0 bg-white border border-[rgba(45,129,118,.2)] flex items-center justify-center text-[#2d8176]"
                                                >
                                                    <svg
                                                        class="w-5 h-5"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        />
                                                    </svg>
                                                </div>
                                                <div
                                                    class="overflow-hidden flex-1 min-w-0"
                                                >
                                                    <p class="file-name-text">
                                                        {{ $latestLayout->layout_file_name ?? 'layout-file.pdf' }}
                                                    </p>
                                                    <p
                                                        class="text-[.62rem] text-[#2d8176] tracking-[.06em] uppercase mt-0.5 font-bold"
                                                    >
                                                        Ready for Review
                                                    </p>
                                                </div>
                                            </div>

                                            <a
                                                href="{{ route('author.layout.download', $submission) }}"
                                                class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg bg-[#2d8176] hover:bg-[#1a4d46] text-white text-[.7rem] font-bold tracking-[.08em] uppercase transition-all"
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
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                    />
                                                </svg>
                                                Download Layout File
                                            </a>

                                            @if ($latestLayout->notes)
                                                <div
                                                    class="mt-3 px-3 py-3 bg-[#fffdf9] border border-[rgba(201,168,76,.3)] border-l-4 border-l-[#c9a84c] rounded-lg"
                                                >
                                                    <p
                                                        class="text-[.58rem] font-extrabold tracking-widest uppercase text-[#8a6e28] mb-1"
                                                    >
                                                        Layout Notes
                                                    </p>
                                                    <p
                                                        class="text-[.78rem] italic text-[#3d2f1a] leading-[1.6]"
                                                    >
                                                        {{ $latestLayout->notes }}
                                                    </p>
                                                </div>
                                            @endif

                                            {{-- Author Confirmation --}}
                                            @if ($submission->status === 'author_confirmation')
                                                @php
                                                    $latestLayoutForFeedback = $submission
                                                        ->layoutEditorAssignments()
                                                        ->where('status', 'completed')
                                                        ->whereNull('author_status')
                                                        ->latest('completed_at')
                                                        ->first();
                                                @endphp

                                                @if ($latestLayoutForFeedback)
                                                    <div
                                                        class="mt-4 p-4 bg-[#e8f4f2] border border-[rgba(45,129,118,.3)] rounded-lg"
                                                    >
                                                        <p
                                                            class="text-[.75rem] font-semibold text-[#2d8176] mb-4"
                                                        >
                                                            Please review the
                                                            layout above. You
                                                            may confirm it or
                                                            request revisions.
                                                        </p>

                                                        {{-- Confirm button --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route('submissions.author-confirm', $submission) }}"
                                                        >
                                                            @csrf
                                                            <input
                                                                type="hidden"
                                                                name="assignment_id"
                                                                value="{{ $latestLayoutForFeedback->id }}"
                                                            />
                                                            <button
                                                                type="submit"
                                                                class="w-full px-4 py-3 rounded-lg bg-[#2d8176] hover:bg-[#1a4d46] text-white text-[.7rem] font-bold tracking-[.08em] uppercase transition-all mb-3"
                                                            >
                                                                <svg
                                                                    class="w-4 h-4 inline-block mr-2"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                >
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M5 13l4 4L19 7"
                                                                    />
                                                                </svg>
                                                                Confirm Layout
                                                            </button>
                                                        </form>

                                                        {{-- Request revision --}}
                                                        <div
                                                            x-data="{ open: false }"
                                                            class="layout-confirm-form"
                                                        >
                                                            <button
                                                                @click="open = !open"
                                                                class="w-full px-4 py-3 rounded-lg bg-white border border-[#c9b99a] hover:border-[#f97316] text-[#6b5740] hover:text-[#f97316] text-[.7rem] font-bold tracking-[.08em] uppercase transition-all"
                                                            >
                                                                <svg
                                                                    class="w-4 h-4 inline-block mr-2"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                >
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                                    />
                                                                </svg>
                                                                Request Layout
                                                                Revision
                                                            </button>

                                                            <form
                                                                x-show="open"
                                                                x-transition
                                                                method="POST"
                                                                action="{{ route('submissions.author-request-revision', $submission) }}"
                                                                class="mt-3"
                                                            >
                                                                @csrf
                                                                <input
                                                                    type="hidden"
                                                                    name="assignment_id"
                                                                    value="{{ $latestLayoutForFeedback->id }}"
                                                                />
                                                                <textarea
                                                                    name="author_feedback"
                                                                    required
                                                                    rows="3"
                                                                    placeholder="Describe what needs to be revised in the layout…"
                                                                    class="w-full px-3 py-2.5 rounded-lg border border-[#e8dfd0] bg-white text-[.85rem] text-[#1a1209] outline-none focus:border-[#f97316] focus:ring-2 focus:ring-[#f97316]/10 resize-none mb-2"
                                                                    style="
                                                                        font-size: 1rem;
                                                                    "
                                                                ></textarea>
                                                                <button
                                                                    type="submit"
                                                                    class="w-full px-4 py-2.5 rounded-lg bg-[#f97316] hover:bg-[#ea580c] text-white text-[.7rem] font-bold tracking-[.08em] uppercase transition-all"
                                                                >
                                                                    Send
                                                                    Revision
                                                                    Request
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif

                        {{-- ── Revision Files ── --}}
                        @php
                            $revisionFilesWithFile = $submission->revisionRequests
                                ->filter(fn ($r) => ! empty($r->revised_file_path))
                                ->sortBy('created_at')
                                ->values();
                        @endphp

                        @if ($revisionFilesWithFile->isNotEmpty())
                            <div class="py-4 last:pb-0">
                                <p
                                    class="text-[.6rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-2"
                                >
                                    Revision Files
                                </p>
                                <div class="space-y-2">
                                    @foreach ($revisionFilesWithFile as $i => $rev)
                                        <div
                                            class="flex items-center gap-3 px-4 py-3 bg-[#f3ece0] border border-[#e8dfd0] rounded-xl"
                                        >
                                            <div
                                                class="w-10 h-10 rounded-lg shrink-0 bg-white border border-[#e8dfd0] flex items-center justify-center text-[#8a6e28]"
                                            >
                                                <svg
                                                    class="w-5 h-5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                            <div
                                                class="overflow-hidden flex-1 min-w-0"
                                            >
                                                <p class="file-name-text">
                                                    {{ $rev->revised_file_name ?? 'revision-' . ($i + 1) . '.pdf' }}
                                                </p>
                                                <p
                                                    class="text-[.62rem] text-[#6b5740] tracking-[.06em] uppercase mt-0.5"
                                                >
                                                    Revision {{ $i + 1 }} ·
                                                    {{ $rev->revised_at ? $rev->revised_at->format('d M Y') : $rev->updated_at->format('d M Y') }}
                                                </p>
                                            </div>
                                            <a
                                                href="{{ route('submissions.revision-file.download', [$submission, $rev]) }}"
                                                class="shrink-0 w-8 h-8 rounded-lg bg-[#2d8176] hover:bg-[#1a4d46] text-white flex items-center justify-center transition-all"
                                                title="Download Revision {{ $i + 1 }}"
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
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                                    />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
        ══════════════════════════════════════
        MODALS — rendered outside main layout
        ══════════════════════════════════════
    --}}

    {{-- ── Modal: Peer Review Logs ── --}}
    @if ($showPeerReviews)
        <div
            id="modal-peer-reviews"
            class="feedback-modal-backdrop"
            onclick="closeOnBackdrop(event, 'modal-peer-reviews')"
        >
            <div class="feedback-modal">
                <div class="feedback-modal-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-[#fdf8ec] border border-[#e8dfd0] text-[#8a6e28] flex items-center justify-center"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <div>
                            <p
                                class="font-['Libre_Baskerville',serif] text-[1rem] font-bold text-[#1a1209]"
                            >
                                Peer Review Logs
                            </p>
                            <p class="text-[.65rem] text-[#6b5740]">
                                {{ $submission->reviews->count() }}
                                {{ Str::plural('review', $submission->reviews->count()) }}
                            </p>
                        </div>
                    </div>
                    <button
                        onclick="closeModal('modal-peer-reviews')"
                        class="w-8 h-8 rounded-full bg-white border border-[#e8dfd0] text-[#6b5740] hover:bg-[#fef2f2] hover:border-[#fecaca] hover:text-[#dc2626] flex items-center justify-center transition-all"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M6 18L18 6M6 6l12 12"
                                stroke-width="2"
                                stroke-linecap="round"
                            />
                        </svg>
                    </button>
                </div>
                <div class="feedback-modal-body space-y-4">
                    @foreach ($submission->reviews as $i => $r)
                        <div
                            class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden shadow-[0_1px_6px_rgba(26,18,9,.05)]"
                        >
                            <div class="review-card-header">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full shrink-0 bg-[#f3ece0] border-[1.5px] border-[#c9b99a] text-[#8a6e28] text-[.68rem] font-bold flex items-center justify-center"
                                    >
                                        @if (auth()->user()->id === $submission->author_id)
                                            R{{ $i + 1 }}
                                        @else
                                            {{ substr($r->reviewer->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p
                                            class="text-[.82rem] font-semibold text-[#1a1209]"
                                        >
                                            @if (auth()->user()->id === $submission->author_id)
                                                Reviewer {{ $i + 1 }}
                                            @else
                                                {{ $r->reviewer->name }}
                                            @endif
                                        </p>
                                        <p
                                            class="text-[.65rem] font-medium text-[#6b5740] tracking-[.04em] uppercase mt-0.5"
                                        >
                                            {{ $r->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                @if (auth()->user()->id !== $submission->author_id && $r->recommendation)
                                    @php
                                        $recCls = match ($r->recommendation) {
                                            'accept' => 'bg-[#f0fdf4] border-[#86efac] text-[#065f46]',
                                            'minor_revisions' => 'bg-[#fffbeb] border-[#fde68a] text-[#92400e]',
                                            'major_revisions' => 'bg-[#fff7ed] border-[#fed7aa] text-[#9a3412]',
                                            'reject' => 'bg-[#fef2f2] border-[#fecaca] text-[#991b1b]',
                                            default => 'bg-[#f3ece0] border-[#e8dfd0] text-[#6b5740]',
                                        };
                                    @endphp

                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[.58rem] font-extrabold tracking-[.08em] uppercase {{ $recCls }}"
                                    >
                                        {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}
                                    </span>
                                @endif
                            </div>
                            @if ($r->comments_for_author)
                                <div class="px-5 py-5">
                                    <p
                                        class="text-[.88rem] text-[#6b5740] leading-[1.75]"
                                    >
                                        {{ $r->comments_for_author }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ── Modal: Revision Review Feedback ── --}}
    @if ($showRevisionFeedback)
        <div
            id="modal-revision-feedback"
            class="feedback-modal-backdrop"
            onclick="closeOnBackdrop(event, 'modal-revision-feedback')"
        >
            <div class="feedback-modal">
                <div class="feedback-modal-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-[#e8f4f2] border border-[rgba(45,129,118,.2)] text-[#2d8176] flex items-center justify-center"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <div>
                            <p
                                class="font-['Libre_Baskerville',serif] text-[1rem] font-bold text-[#1a1209]"
                            >
                                Revision Review Feedback
                            </p>
                            <p class="text-[.65rem] text-[#6b5740]">
                                {{ count($allRevisionReviews) }}
                                {{ Str::plural('entry', count($allRevisionReviews)) }}
                            </p>
                        </div>
                    </div>
                    <button
                        onclick="closeModal('modal-revision-feedback')"
                        class="w-8 h-8 rounded-full bg-white border border-[#e8dfd0] text-[#6b5740] hover:bg-[#fef2f2] hover:border-[#fecaca] hover:text-[#dc2626] flex items-center justify-center transition-all"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M6 18L18 6M6 6l12 12"
                                stroke-width="2"
                                stroke-linecap="round"
                            />
                        </svg>
                    </button>
                </div>
                <div class="feedback-modal-body space-y-4">
                    @foreach ($allRevisionReviews as $i => $rr)
                        <div
                            class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden shadow-[0_1px_6px_rgba(26,18,9,.05)]"
                        >
                            <div class="review-card-header">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full shrink-0 bg-[#e8f4f2] border-[1.5px] border-[rgba(45,129,118,.3)] text-[#2d8176] text-[.68rem] font-bold flex items-center justify-center"
                                    >
                                        @if (auth()->user()->id === $submission->author_id)
                                            R{{ $i + 1 }}
                                        @else
                                            {{ substr($rr->reviewer->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p
                                            class="text-[.82rem] font-semibold text-[#1a1209]"
                                        >
                                            @if (auth()->user()->id === $submission->author_id)
                                                Reviewer {{ $i + 1 }}
                                            @else
                                                {{ $rr->reviewer->name }}
                                            @endif
                                        </p>
                                        <p
                                            class="text-[.65rem] font-medium text-[#6b5740] tracking-[.04em] uppercase mt-0.5"
                                        >
                                            {{ $rr->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                @if ($rr->recommendation && auth()->user()->id !== $submission->author_id)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[.58rem] font-extrabold tracking-[.08em] uppercase bg-[#e8f4f2] border-[rgba(45,129,118,.3)] text-[#1a4d46]"
                                    >
                                        {{ \App\Models\RevisionReview::recommendationOptions()[$rr->recommendation] ?? $rr->recommendation }}
                                    </span>
                                @endif
                            </div>
                            @if ($rr->comments_for_author)
                                <div class="px-5 py-5">
                                    <p
                                        class="text-[.88rem] text-[#6b5740] leading-[1.75]"
                                    >
                                        {{ $rr->comments_for_author }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ── Modal: Editorial Feedback ── --}}
    @if ($showEditorialFeedback)
        <div
            id="modal-editorial-feedback"
            class="feedback-modal-backdrop"
            onclick="closeOnBackdrop(event, 'modal-editorial-feedback')"
        >
            <div class="feedback-modal">
                <div class="feedback-modal-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-[#fdf8ec] border border-[#e8dfd0] text-[#8a6e28] flex items-center justify-center"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9v-2h2v2zm0-4H9V5h2v4z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p
                                class="font-['Libre_Baskerville',serif] text-[1rem] font-bold text-[#1a1209]"
                            >
                                Editorial Feedback
                            </p>
                            <p class="text-[.65rem] text-[#6b5740]">
                                Screening · Editor notes · Appeals
                            </p>
                        </div>
                    </div>
                    <button
                        onclick="closeModal('modal-editorial-feedback')"
                        class="w-8 h-8 rounded-full bg-white border border-[#e8dfd0] text-[#6b5740] hover:bg-[#fef2f2] hover:border-[#fecaca] hover:text-[#dc2626] flex items-center justify-center transition-all"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M6 18L18 6M6 6l12 12"
                                stroke-width="2"
                                stroke-linecap="round"
                            />
                        </svg>
                    </button>
                </div>
                <div class="feedback-modal-body space-y-4">
                    {{-- Screening --}}
                    @if ($submission->initial_screening_status !== 'pending' || $submission->initial_screening_comments)
                        <div
                            class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden shadow-[0_1px_6px_rgba(26,18,9,.05)]"
                        >
                            <div
                                class="flex items-center gap-3 px-5 py-3.5 bg-[#f3ece0] border-b border-[#e8dfd0]"
                            >
                                <div
                                    class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center bg-[#fdf8ec] text-[#8a6e28]"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9v-2h2v2zm0-4H9V5h2v4z"
                                        />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p
                                        class="text-[.8rem] font-bold text-[#1a1209]"
                                    >
                                        Editor-in-Chief
                                    </p>
                                    <p
                                        class="text-[.65rem] text-[#6b5740] mt-0.5"
                                    >
                                        Initial Screening Decision
                                    </p>
                                </div>
                            </div>
                            @if ($submission->initial_screening_comments)
                                <div class="px-5 py-5">
                                    <p
                                        class="text-[.62rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-2"
                                    >
                                        Screening Comments
                                    </p>
                                    <p
                                        class="text-[.88rem] text-[#3d2f1a] leading-[1.7]"
                                    >
                                        {{ $submission->initial_screening_comments }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Editor Notes --}}
                    @if ($submission->editor_notes)
                        <div
                            class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden shadow-[0_1px_6px_rgba(26,18,9,.05)]"
                        >
                            <div
                                class="flex items-center gap-3 px-5 py-3.5 bg-[#f3ece0] border-b border-[#e8dfd0]"
                            >
                                <div
                                    class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center bg-[#e8f4f2] text-[#2d8176]"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                        />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p
                                        class="text-[.8rem] font-bold text-[#1a1209]"
                                    >
                                        Editor
                                    </p>
                                    <p
                                        class="text-[.65rem] text-[#6b5740] mt-0.5"
                                    >
                                        Official Editorial Notes
                                    </p>
                                </div>
                                @if ($submission->status === 'accepted')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[.58rem] font-extrabold tracking-[.08em] uppercase bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]"
                                    >
                                        <span
                                            class="w-1.5 h-1.5 rounded-full bg-[#2d8176]"
                                        ></span>
                                        Accepted
                                    </span>
                                @elseif ($submission->status === 'rejected')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[.58rem] font-extrabold tracking-[.08em] uppercase bg-[#fef2f2] border-[#fecaca] text-[#991b1b]"
                                    >
                                        <span
                                            class="w-1.5 h-1.5 rounded-full bg-[#c0392b]"
                                        ></span>
                                        Rejected
                                    </span>
                                @endif
                            </div>
                            <div class="px-5 py-5">
                                <p
                                    class="text-[.62rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-2"
                                >
                                    Notes
                                </p>
                                <p
                                    class="text-[.88rem] text-[#3d2f1a] leading-[1.7]"
                                >
                                    {{ $submission->editor_notes }}
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Appeal --}}
                    @php
                        $appeal = $submission
                            ->appeals()
                            ->latest()
                            ->first();
                    @endphp

                    @if ($appeal)
                        @php
                            $appealIsApproved = $appeal->status === 'approved';
                            $appealIsPending = $appeal->isPending();
                            $iconBg = $appealIsApproved ? '#e8f4f2' : ($appealIsPending ? '#fffbeb' : '#fef2f2');
                            $iconClr = $appealIsApproved ? '#2d8176' : ($appealIsPending ? '#d97706' : '#dc2626');
                        @endphp

                        <div
                            class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden shadow-[0_1px_6px_rgba(26,18,9,.05)]"
                        >
                            <div
                                class="flex items-center gap-3 px-5 py-3.5 bg-[#f3ece0] border-b border-[#e8dfd0]"
                            >
                                <div
                                    class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center"
                                    style="
                                        background: {{ $iconBg }};
                                        color: {{ $iconClr }};
                                    "
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        @if ($appealIsApproved)
                                            <path
                                                fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"
                                            />
                                        @else
                                            <path
                                                fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        @endif
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p
                                        class="text-[.8rem] font-bold text-[#1a1209]"
                                    >
                                        Editor-in-Chief
                                    </p>
                                    <p
                                        class="text-[.65rem] text-[#6b5740] mt-0.5"
                                    >
                                        Appeal Decision
                                    </p>
                                </div>
                                @if ($appealIsApproved)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[.58rem] font-extrabold tracking-[.08em] uppercase bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]"
                                    >
                                        <span
                                            class="w-1.5 h-1.5 rounded-full bg-[#2d8176]"
                                        ></span>
                                        Approved
                                    </span>
                                @elseif ($appeal->status === 'rejected')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[.58rem] font-extrabold tracking-[.08em] uppercase bg-[#fef2f2] border-[#fecaca] text-[#991b1b]"
                                    >
                                        <span
                                            class="w-1.5 h-1.5 rounded-full bg-[#c0392b]"
                                        ></span>
                                        Failed at Initial Screening
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[.58rem] font-extrabold tracking-[.08em] uppercase bg-[#fffbeb] border-[#fde68a] text-[#92400e]"
                                    >
                                        <span
                                            class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"
                                        ></span>
                                        Pending
                                    </span>
                                @endif
                            </div>
                            <div class="px-5 py-5">
                                @if ($appeal->editor_response)
                                    <p
                                        class="text-[.62rem] font-extrabold tracking-[.12em] uppercase text-[#6b5740] mb-2"
                                    >
                                        Editor's Response
                                    </p>
                                    <p
                                        class="text-[.88rem] text-[#3d2f1a] leading-[1.7]"
                                    >
                                        {{ $appeal->editor_response }}
                                    </p>
                                @elseif ($appealIsPending)
                                    <p
                                        class="text-[.88rem] italic text-[#92400e] leading-[1.7]"
                                    >
                                        Awaiting editor-in-chief review…
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('open');
            document.body.style.overflow = '';
        }
        function closeOnBackdrop(event, id) {
            if (event.target === event.currentTarget) closeModal(id);
        }
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                [
                    'modal-peer-reviews',
                    'modal-revision-feedback',
                    'modal-editorial-feedback',
                ].forEach(closeModal);
            }
        });
    </script>
@endpush
