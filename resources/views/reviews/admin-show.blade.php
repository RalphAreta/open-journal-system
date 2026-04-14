@extends('layouts.app')

@section('title', 'Submission Details')

@push('styles')
    <style>
        /* ── MOBILE RESPONSIVE for Submission Details ── */
        @media (max-width: 640px) {
            /* Hero header: tighter top padding */
            .sub-hero {
                padding-top: 1.5rem !important;
                padding-bottom: 1.25rem !important;
                margin-bottom: 1.25rem !important;
            }

            /* Title: smaller on mobile */
            .sub-title {
                font-size: 1.4rem !important;
            }

            /* Header row: always stacked on mobile */
            .sub-header-row {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px !important;
            }

            /* Status + back button: side by side */
            .sub-header-actions {
                display: flex;
                flex-direction: row !important;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
            }

            /* Main card: tighter padding */
            .sub-main-card .sub-card-body {
                padding: 1.25rem !important;
            }

            /* Author + date grid: single column */
            .sub-info-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
                margin-bottom: 1.25rem !important;
            }

            /* Abstract: tighter padding */
            .sub-abstract-box {
                padding: 1rem !important;
            }

            /* File card: already has sm:flex-row, just ensure button is full-width on xs */
            .sub-file-download {
                width: 100%;
                justify-content: center;
            }

            /* Reviewer feedback header: wrap badge */
            .sub-review-header {
                flex-wrap: wrap;
                gap: 8px;
            }

            /* Reviewer card header: stack name + recommendation badge */
            .sub-reviewer-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 8px !important;
            }

            /* Reviewer feedback panel: tighter padding */
            .sub-review-panel {
                padding: 1rem !important;
            }

            /* Review section inner padding */
            .sub-review-list {
                padding: 1rem !important;
            }

            /* Breadcrumb: allow wrap */
            .sub-breadcrumb {
                flex-wrap: wrap;
                row-gap: 4px;
            }
        }

        @media (max-width: 400px) {
            .sub-title {
                font-size: 1.2rem !important;
            }

            .sub-main-card .sub-card-body {
                padding: 1rem !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-[#faf6ef] font-sans text-[#1a1209]">
        <div class="max-w-4xl mx-auto px-4">
            {{-- ── Hero Header ── --}}
            <div
                class="sub-hero relative pt-11 pb-8 mb-9 border-b border-[#e8dfd0]"
            >
                <div
                    class="absolute bottom-[-1px] left-0 w-20 h-[3px] bg-gradient-to-r from-[#2d8176] to-transparent"
                ></div>

                <div
                    class="sub-header-row flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
                >
                    <div>
                        {{-- Breadcrumb --}}
                        <nav
                            class="sub-breadcrumb flex items-center gap-2 mb-3.5"
                        >
                            <a
                                href="{{ route('dashboard.admin') }}"
                                class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#2d8176] hover:opacity-70 transition-opacity"
                            >
                                Admin
                            </a>
                            <svg
                                class="w-2.5 h-2.5 text-[#c9b99a] shrink-0"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="3"
                                viewBox="0 0 24 24"
                            >
                                <path d="M9 5l7 7-7 7" />
                            </svg>
                            <a
                                href="{{ route('admin.submissions') }}"
                                class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#2d8176] hover:opacity-70 transition-opacity"
                            >
                                Submissions
                            </a>
                            <svg
                                class="w-2.5 h-2.5 text-[#c9b99a] shrink-0"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="3"
                                viewBox="0 0 24 24"
                            >
                                <path d="M9 5l7 7-7 7" />
                            </svg>
                            <span
                                class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#1a1209]"
                            >
                                Details
                            </span>
                        </nav>

                        {{-- Eyebrow --}}
                        <div class="flex items-center gap-2.5 mb-2.5">
                            <div class="w-6 h-px bg-[#2d8176]"></div>
                            <p
                                class="text-[11px] font-bold tracking-[0.2em] uppercase text-[#2d8176]"
                            >
                                Submission Details
                            </p>
                        </div>

                        <h1
                            class="sub-title font-serif text-[2rem] font-bold text-[#1a1209] tracking-[-0.01em] leading-[1.2] max-w-xl"
                        >
                            <em class="italic text-[#2d8176] not-italic">
                                {{ $submission->title }}
                            </em>
                        </h1>
                    </div>

                    <div
                        class="sub-header-actions flex items-center gap-3 self-start md:self-auto shrink-0"
                    >
                        {{-- Status Badge --}}
                        @php
                            $statusMap = match (strtolower($submission->status)) {
                                'accepted' => 'bg-[#e8f4f2] text-[#2d8176] border-[#b8ddd9] dot:bg-[#2d8176]',
                                'submitted' => 'bg-[#e8f4f2] text-[#2d8176] border-[#b8ddd9]',
                                'under_review' => 'bg-[#fef9ec] text-[#8a6e28] border-[#e8d49a]',
                                'revisions_requested' => 'bg-[#fff7ed] text-[#9a5a1a] border-[#fdd9aa]',
                                'rejected' => 'bg-[#fef2f2] text-[#b91c1c] border-[#fecaca]',
                                default => 'bg-[#f3ece0] text-[#6b5740] border-[#e8dfd0]',
                            };
                            $dotColor = match (strtolower($submission->status)) {
                                'accepted', 'submitted' => 'bg-[#2d8176]',
                                'under_review' => 'bg-[#c9a84c]',
                                'revisions_requested' => 'bg-[#f97316]',
                                'rejected' => 'bg-[#b91c1c]',
                                default => 'bg-[#c9b99a]',
                            };
                        @endphp

                        <span
                            class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full border text-[0.62rem] font-bold tracking-[0.08em] uppercase {{ $statusMap }}"
                        >
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"
                            ></span>
                            {{ str_replace('_', ' ', $submission->status) }}
                        </span>

                        <a
                            href="{{ route('admin.submissions') }}"
                            class="inline-flex items-center gap-2 bg-[#f3ece0] border border-[#c9b99a] text-[#6b5740] text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-md hover:bg-white hover:text-[#1a1209] transition-all whitespace-nowrap"
                        >
                            <svg
                                class="w-3 h-3"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M15 19l-7-7 7-7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Main Card ── --}}
            <div
                class="sub-main-card bg-white border border-[#e8dfd0] rounded-2xl shadow-[0_1px_6px_rgba(26,18,9,0.05)] overflow-hidden mb-6"
            >
                <div
                    class="h-[3px] bg-gradient-to-r from-[#2d8176] to-[#c9a84c]"
                ></div>

                <div class="sub-card-body p-8">
                    {{-- Author + Date --}}
                    <div class="flex items-center gap-3 mb-2">
                        <span
                            class="text-[0.68rem] font-bold tracking-[0.18em] uppercase text-[#6b5740] whitespace-nowrap"
                        >
                            Submission Info
                        </span>
                        <div class="flex-1 h-px bg-[#e8dfd0]"></div>
                    </div>

                    <div
                        class="sub-info-grid grid grid-cols-1 md:grid-cols-2 gap-6 mt-5 mb-8"
                    >
                        {{-- Author --}}
                        <div>
                            <label
                                class="block text-[0.62rem] font-bold tracking-[0.14em] uppercase text-[#6b5740] mb-2"
                            >
                                Author
                            </label>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-[#1a4d46] text-white rounded-lg flex items-center justify-center font-serif text-sm font-bold uppercase shrink-0"
                                >
                                    {{ strtoupper(substr($submission->author->name ?? 'U', 0, 1)) }}
                                </div>
                                <p
                                    class="text-[0.95rem] font-bold text-[#1a1209]"
                                >
                                    {{ $submission->author->name }}
                                </p>
                            </div>
                        </div>

                        {{-- Date --}}
                        <div>
                            <label
                                class="block text-[0.62rem] font-bold tracking-[0.14em] uppercase text-[#6b5740] mb-2"
                            >
                                Submission Date
                            </label>
                            <div class="flex items-center gap-2 mt-1">
                                <svg
                                    class="w-4 h-4 text-[#c9b99a]"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                                <p
                                    class="text-[0.95rem] font-bold text-[#1a1209]"
                                >
                                    {{ $submission->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Abstract --}}
                    <div class="border-t border-[#e8dfd0] pt-7 mb-7">
                        <div class="flex items-center gap-3 mb-5">
                            <span
                                class="text-[0.68rem] font-bold tracking-[0.18em] uppercase text-[#6b5740] whitespace-nowrap"
                            >
                                Abstract
                            </span>
                            <div class="flex-1 h-px bg-[#e8dfd0]"></div>
                        </div>
                        <div
                            class="sub-abstract-box bg-[#f3ece0] border border-[#e8dfd0] rounded-xl p-6"
                        >
                            <p
                                class="text-[0.92rem] text-[#3d2f1a] leading-relaxed italic font-medium"
                            >
                                "{{ $submission->abstract }}"
                            </p>
                        </div>
                    </div>

                    {{-- File --}}
                    <div class="border-t border-[#e8dfd0] pt-7">
                        <div class="flex items-center gap-3 mb-5">
                            <span
                                class="text-[0.68rem] font-bold tracking-[0.18em] uppercase text-[#6b5740] whitespace-nowrap"
                            >
                                Submission File
                            </span>
                            <div class="flex-1 h-px bg-[#e8dfd0]"></div>
                        </div>

                        @if ($submission->file_path)
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#faf6ef] border border-[#e8dfd0] rounded-xl p-4 hover:border-[#c9b99a] transition-all"
                            >
                                <div
                                    class="flex items-center gap-3 overflow-hidden"
                                >
                                    <div
                                        class="w-11 h-11 bg-[#e8f4f2] border border-[#b8ddd9] rounded-lg flex items-center justify-center shrink-0"
                                    >
                                        <svg
                                            class="w-5 h-5 text-[#2d8176]"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </div>
                     <div class="overflow-hidden">
                                        <p
                                            class="text-[0.88rem] font-bold text-[#1a1209] truncate"
                                        >
                                            {{ $submission->file_name }}
                                        </p>
                                        <p
                                            class="text-[0.68rem] font-bold tracking-[0.08em] uppercase text-[#6b5740] mt-0.5"
                                        >
                                            Research Manuscript
                                        </p>
                                    </div>
                                </div>
                                <a
                                    href="{{ route('submissions.download', ['submission' => $submission]) }}"
                                    class="sub-file-download relative overflow-hidden inline-flex items-center gap-2 bg-[#2d8176] text-white text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-md shadow-[0_4px_14px_rgba(45,129,118,0.25)] hover:bg-[#1a4d46] hover:-translate-y-0.5 transition-all whitespace-nowrap shrink-0"
                                >
                                    <span
                                        class="absolute inset-0 bg-gradient-to-br from-[rgba(201,168,76,0.15)] to-transparent pointer-events-none"
                                    ></span>
                                    <svg
                                        class="w-3.5 h-3.5 relative z-10"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                    <span class="relative z-10">
                                        Download File
                                    </span>
                                </a>
                            </div>
                        @else
                            <div
                                class="bg-[#f3ece0] border border-[#e8dfd0] rounded-xl p-6 text-center"
                            >
                                <p
                                    class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#c9b99a]"
                                >
                                    No file submitted
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Reviewer Feedback ── --}}
            @if ($submission->reviews->isNotEmpty())
                <div
                    class="bg-white border border-[#e8dfd0] rounded-2xl shadow-[0_1px_6px_rgba(26,18,9,0.05)] overflow-hidden mb-12"
                >
                    <div
                        class="h-[3px] bg-gradient-to-r from-[#c9a84c] to-[#2d8176]"
                    ></div>

                    <div
                        class="sub-review-header px-6 md:px-8 py-5 border-b border-[#e8dfd0] bg-[#faf6ef] flex items-center justify-between"
                    >
                        <div class="flex items-center gap-3">
                            <span
                                class="text-[0.68rem] font-bold tracking-[0.18em] uppercase text-[#6b5740]"
                            >
                                Reviewer Feedback
                            </span>
                            <div class="w-8 h-px bg-[#e8dfd0]"></div>
                        </div>
                        <span
                            class="text-[0.64rem] font-bold bg-[#f3ece0] border border-[#e8dfd0] text-[#6b5740] px-3 py-1 rounded-full tracking-[0.08em] uppercase whitespace-nowrap"
                        >
                            {{ $submission->reviews->count() }}
                            {{ Str::plural('review', $submission->reviews->count()) }}
                        </span>
                    </div>

                    <div class="sub-review-list p-6 space-y-4">
                        @foreach ($submission->reviews as $r)
                            <div
                                class="sub-review-panel bg-[#faf6ef] border border-[#e8dfd0] rounded-xl p-5 hover:border-[#c9b99a] transition-all"
                            >
                                {{-- Reviewer header --}}
                                <div
                                    class="sub-reviewer-header flex items-center justify-between mb-4"
                                >
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 bg-[#1a4d46] text-white rounded-md flex items-center justify-center font-serif text-xs font-bold uppercase shrink-0"
                                        >
                                            {{ substr($r->reviewer->name, 0, 1) }}
                                        </div>
                                        <span
                                            class="text-[0.88rem] font-bold text-[#1a1209]"
                                        >
                                            {{ $r->reviewer->name }}
                                        </span>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-[0.62rem] font-bold tracking-[0.08em] uppercase bg-[#f3ece0] border border-[#e8dfd0] text-[#6b5740] rounded-full whitespace-nowrap"
                                    >
                                        {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}
                                    </span>
                                </div>

                                {{-- Editor Notes --}}
                                @if ($r->comments_for_editor)
                                    <div class="mb-3">
                                        <p
                                            class="text-[0.62rem] font-bold tracking-[0.12em] uppercase text-[#6b5740] mb-1.5"
                                        >
                                            Editor Notes
                                        </p>
                                        <p
                                            class="text-[0.84rem] text-[#3d2f1a] italic leading-relaxed"
                                        >
                                            {{ $r->comments_for_editor }}
                                        </p>
                                    </div>
                                @endif

                                {{-- Author Feedback --}}
                                @if ($r->comments_for_author)
                                    <div
                                        class="{{ $r->comments_for_editor ? 'border-t border-[#e8dfd0] pt-3' : '' }}"
                                    >
                                        <p
                                            class="text-[0.62rem] font-bold tracking-[0.12em] uppercase text-[#6b5740] mb-1.5"
                                        >
                                            Author Feedback
                                        </p>
                                        <p
                                            class="text-[0.84rem] text-[#6b5740] leading-relaxed"
                                        >
                                            {{ Str::limit($r->comments_for_author, 150) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
