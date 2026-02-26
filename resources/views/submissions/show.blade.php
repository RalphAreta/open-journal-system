@extends('layouts.app')

@section('title', $submission->title)

@push('styles')
    <style>
        .fu  { animation: fu .45s ease both; }
        .fu1 { animation: fu .45s .07s ease both; }
        .fu2 { animation: fu .45s .14s ease both; }
        .fu3 { animation: fu .45s .21s ease both; }
        @keyframes fu {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Abstract decorative quote mark */
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
    </style>
@endpush

@section('content')
<div class="font-['Source_Sans_3',sans-serif] text-[#1a1209] max-w-7xl mx-auto px-1"
     style="background-color:#faf6ef;background-image:radial-gradient(ellipse 80% 50% at 50% -10%,rgba(45,129,118,.08) 0%,transparent 70%)">

    {{-- ── Page Header ── --}}
    <div class="relative pt-10 pb-7 mb-9 border-b border-[#e8dfd0] fu">
        <div class="absolute bottom-[-1px] left-0 w-20 h-[3px]"
             style="background:linear-gradient(90deg,#2d8176,transparent)"></div>

        <div class="flex flex-col md:flex-row justify-between items-start gap-5">
            <div class="flex-1 min-w-0">
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 mb-3
                            text-[11px] font-bold tracking-[.18em] uppercase text-[#6b5740]">
                    <a href="{{ route('submissions.index') }}"
                       class="hover:text-[#2d8176] transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" stroke-width="2.5"/>
                    </svg>
                    <span class="text-[#1a1209]">
                        Manuscript #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </nav>

                {{-- Eyebrow --}}
                <p class="flex items-center gap-2 mb-2
                           text-[11px] font-bold tracking-[.2em] uppercase text-[#2d8176]">
                    <span class="inline-block w-6 h-px bg-[#2d8176]"></span>
                    Author Submission
                </p>

                <h1 class="font-['Libre_Baskerville',serif] text-[2rem] font-bold
                           text-[#1a1209] leading-snug tracking-tight">
                    {{ $submission->title }}
                </h1>
                <div class="mt-3 w-14 h-[2px]"
                     style="background:linear-gradient(90deg,#2d8176,transparent)"></div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 shrink-0 self-start mt-1">
                @if ($submission->isEditableByAuthor() && auth()->user()->id === $submission->author_id && $submission->status === 'submitted')
                    <a href="{{ route('submissions.edit', $submission) }}"
                       class="inline-flex items-center gap-2
                              px-5 py-[9px] rounded-lg
                              bg-white border border-[#c9b99a]
                              text-[.72rem] font-bold tracking-[.08em] uppercase text-[#6b5740]
                              shadow-[0_2px_8px_rgba(26,18,9,.06)]
                              hover:border-[#2d8176] hover:text-[#2d8176] hover:bg-[#e8f4f2]
                              transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                  stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Edit
                    </a>
                @endif

                <a href="{{ route('submissions.index') }}"
                   class="relative overflow-hidden inline-flex items-center gap-2
                          px-5 py-[9px] rounded-lg
                          bg-[#2d8176] hover:bg-[#1a4d46] text-white
                          text-[.72rem] font-bold tracking-[.08em] uppercase
                          transition-all shadow-[0_4px_14px_rgba(45,129,118,.28)]
                          hover:-translate-y-0.5">
                    <span class="absolute inset-0 pointer-events-none"
                          style="background:linear-gradient(135deg,rgba(201,168,76,.18) 0%,transparent 60%)"></span>
                    <svg class="w-3.5 h-3.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="relative z-10">Back to Board</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Main Layout ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-9">

        {{-- ════════════════════ LEFT COLUMN ════════════════════ --}}
        <div class="lg:col-span-8 space-y-8">

            {{-- ── Pending Revision Banner ── --}}
            @php
                $pendingRevisions = $submission->revisionRequests()->whereNull('revised_at')->count();
            @endphp
            @if ($pendingRevisions > 0 && auth()->user()->id === $submission->author_id)
                <div class="fu1 flex overflow-hidden
                            border border-[#fed7aa] rounded-[14px]
                            shadow-[0_4px_20px_rgba(26,18,9,.09)]"
                     style="background:#fffdf9">
                    <div class="w-[5px] shrink-0 bg-[#f97316]"></div>
                    <div class="flex-1 px-5 py-4 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-[38px] h-[38px] rounded-[10px] shrink-0
                                        bg-[#fff7ed] text-[#ea580c]
                                        flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-['Libre_Baskerville',serif] text-[1.05rem] font-bold text-[#1a1209]">
                                    Revision Required
                                </p>
                                <p class="text-[.78rem] text-[#6b5740] mt-0.5">
                                    {{ $pendingRevisions }} request(s) awaiting your response
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('submissions.revisions', $submission) }}"
                           class="inline-flex items-center gap-2 px-5 py-2 rounded-lg
                                  bg-[#ea580c] text-white border border-[#ea580c]
                                  text-[.68rem] font-bold tracking-[.08em] uppercase
                                  transition-all hover:bg-[#c2410c] hover:-translate-y-0.5
                                  whitespace-nowrap">
                            Submit Revisions →
                        </a>
                    </div>
                </div>
            @endif

            {{-- ── Final Decision Banner ── --}}
            @if (in_array($submission->status, ['accepted', 'rejected']) && $submission->editor_decision_at)
                @php $isAcc = $submission->status === 'accepted'; @endphp
                <div class="fu1 flex overflow-hidden rounded-[14px]
                            shadow-[0_4px_20px_rgba(26,18,9,.09)]
                            border {{ $isAcc ? 'border-[rgba(45,129,118,.35)]' : 'border-[#fecaca]' }}"
                     style="background:{{ $isAcc ? '#f5fdfb' : '#fffafa' }}">
                    <div class="w-[5px] shrink-0 {{ $isAcc ? 'bg-[#2d8176]' : 'bg-[#dc2626]' }}"></div>
                    <div class="flex-1 px-5 py-4 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-[38px] h-[38px] rounded-[10px] shrink-0
                                        flex items-center justify-center
                                        font-['Libre_Baskerville',serif] text-[1.1rem] font-bold
                                        {{ $isAcc ? 'bg-[#e8f4f2] text-[#2d8176]' : 'bg-[#fef2f2] text-[#dc2626]' }}">
                                {{ $isAcc ? '✓' : '✕' }}
                            </div>
                            <div>
                                <p class="font-['Libre_Baskerville',serif] text-[1.05rem] font-bold text-[#1a1209]">
                                    Editorial Decision: {{ $isAcc ? 'Accepted' : 'Rejected' }}
                                </p>
                                <p class="text-[.78rem] text-[#6b5740] mt-0.5">
                                    Decided on {{ $submission->editor_decision_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        @if ($submission->editor_notes)
                            <span class="text-[.74rem] italic text-[#6b5740]">
                                See editorial feedback below ↓
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ── Abstract ── --}}
            <section class="fu1">
                {{-- Section Header --}}
                <div class="flex items-center gap-3 mb-5">
                    <span class="text-[.6rem] font-extrabold tracking-[.16em] uppercase
                                 text-[#8a6e28] flex items-center gap-2">
                        <span class="inline-block w-4 h-px bg-[#c9a84c]"></span>
                        Abstract
                    </span>
                    <div class="flex-1 h-px" style="background:linear-gradient(90deg,#e8dfd0,transparent)"></div>
                </div>

                <div class="abstract-block relative bg-white
                            border border-[#c9b99a] rounded-[14px] px-9 pt-8 pb-7
                            shadow-[0_2px_12px_rgba(26,18,9,.06)]">
                    <p class="font-['Libre_Baskerville',serif] text-[1.08rem] font-normal
                               italic text-[#3d2f1a] leading-[1.8] relative z-10 pt-3">
                        {{ $submission->abstract }}
                    </p>
                </div>
            </section>

            {{-- ── Appeal Section ── --}}
            @include('submissions.partials.appeal-section')

            {{-- ── Peer Review Logs ── --}}
            @if ($submission->reviews->isNotEmpty() &&
                (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
                <section class="fu2">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="text-[.6rem] font-extrabold tracking-[.16em] uppercase
                                     text-[#8a6e28] flex items-center gap-2">
                            <span class="inline-block w-4 h-px bg-[#c9a84c]"></span>
                            Peer Review Logs
                        </span>
                        <div class="flex-1 h-px" style="background:linear-gradient(90deg,#e8dfd0,transparent)"></div>
                        <span class="text-[.68rem] font-semibold text-[#6b5740] whitespace-nowrap">
                            {{ $submission->reviews->count() }} {{ Str::plural('review', $submission->reviews->count()) }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        @foreach ($submission->reviews as $i => $r)
                            {{-- Review Card --}}
                            <div class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden
                                        shadow-[0_1px_6px_rgba(26,18,9,.05)]
                                        hover:border-[#c9b99a] hover:shadow-[0_4px_16px_rgba(26,18,9,.09)]
                                        transition-all">

                                {{-- Card Head --}}
                                <div class="flex items-center justify-between flex-wrap gap-3
                                            px-5 py-3.5 bg-[#f3ece0] border-b border-[#e8dfd0]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full shrink-0
                                                    bg-[#f3ece0] border-[1.5px] border-[#c9b99a]
                                                    text-[#8a6e28] text-[.68rem] font-bold
                                                    flex items-center justify-center">
                                            @if (auth()->user()->id === $submission->author_id)
                                                R{{ $i + 1 }}
                                            @else
                                                {{ substr($r->reviewer->name, 0, 2) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-[.82rem] font-semibold text-[#1a1209]">
                                                @if (auth()->user()->id === $submission->author_id)
                                                    Reviewer {{ $i + 1 }}
                                                @else
                                                    {{ $r->reviewer->name }}
                                                @endif
                                            </p>
                                            <p class="text-[.65rem] font-medium text-[#6b5740]
                                                       tracking-[.04em] uppercase mt-0.5">
                                                {{ $r->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    @if (auth()->user()->id !== $submission->author_id && $r->recommendation)
                                        @php
                                            $recCls = match($r->recommendation) {
                                                'accept'           => 'bg-[#f0fdf4] border-[#86efac] text-[#065f46]',
                                                'minor_revisions'  => 'bg-[#fffbeb] border-[#fde68a] text-[#92400e]',
                                                'major_revisions'  => 'bg-[#fff7ed] border-[#fed7aa] text-[#9a3412]',
                                                'reject'           => 'bg-[#fef2f2] border-[#fecaca] text-[#991b1b]',
                                                default            => 'bg-[#f3ece0] border-[#e8dfd0] text-[#6b5740]',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em]
                                                     uppercase {{ $recCls }}">
                                            {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}
                                        </span>
                                    @endif
                                </div>

                                @if ($r->comments_for_author)
                                    <div class="px-5 py-5">
                                        <p class="text-[.88rem] text-[#6b5740] leading-[1.75]">
                                            {{ $r->comments_for_author }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- ── Revision Review Feedback ── --}}
            @php
                $allRevisionReviews = [];
                foreach ($submission->revisionRequests as $rev) {
                    foreach ($rev->revisionReviews as $revRev) {
                        if ($revRev->comments_for_author) $allRevisionReviews[] = $revRev;
                    }
                }
            @endphp

            @if (!empty($allRevisionReviews) &&
                (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
                <section class="fu2">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="text-[.6rem] font-extrabold tracking-[.16em] uppercase
                                     text-[#8a6e28] flex items-center gap-2">
                            <span class="inline-block w-4 h-px bg-[#c9a84c]"></span>
                            Revision Review Feedback
                        </span>
                        <div class="flex-1 h-px" style="background:linear-gradient(90deg,#e8dfd0,transparent)"></div>
                    </div>

                    <div class="space-y-4">
                        @foreach ($allRevisionReviews as $i => $rr)
                            <div class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden
                                        shadow-[0_1px_6px_rgba(26,18,9,.05)]
                                        hover:border-[#c9b99a] hover:shadow-[0_4px_16px_rgba(26,18,9,.09)]
                                        transition-all">

                                <div class="flex items-center justify-between flex-wrap gap-3
                                            px-5 py-3.5 bg-[#f3ece0] border-b border-[#e8dfd0]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full shrink-0
                                                    bg-[#e8f4f2] border-[1.5px] border-[rgba(45,129,118,.3)]
                                                    text-[#2d8176] text-[.68rem] font-bold
                                                    flex items-center justify-center">
                                            @if (auth()->user()->id === $submission->author_id)
                                                R{{ $i + 1 }}
                                            @else
                                                {{ substr($rr->reviewer->name, 0, 2) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-[.82rem] font-semibold text-[#1a1209]">
                                                @if (auth()->user()->id === $submission->author_id)
                                                    Reviewer {{ $i + 1 }}
                                                @else
                                                    {{ $rr->reviewer->name }}
                                                @endif
                                            </p>
                                            <p class="text-[.65rem] font-medium text-[#6b5740]
                                                       tracking-[.04em] uppercase mt-0.5">
                                                {{ $rr->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    @if ($rr->recommendation && auth()->user()->id !== $submission->author_id)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em] uppercase
                                                     bg-[#e8f4f2] border-[rgba(45,129,118,.3)] text-[#1a4d46]">
                                            {{ \App\Models\RevisionReview::recommendationOptions()[$rr->recommendation] ?? $rr->recommendation }}
                                        </span>
                                    @endif
                                </div>

                                @if ($rr->comments_for_author)
                                    <div class="px-5 py-5">
                                        <p class="text-[.88rem] text-[#6b5740] leading-[1.75]">
                                            {{ $rr->comments_for_author }}
                                        </p>
                                        @if ($rr->rating)
                                            <div class="mt-4 pt-4 border-t border-[#f5f0e8]
                                                        text-[.72rem] font-semibold text-[#6b5740]">
                                                Rating:
                                                <span class="text-[#2d8176] font-bold ml-1">{{ $rr->rating }}/5.0</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- ── Editorial Feedback ── --}}
            @if ($submission->initial_screening_status !== 'pending' || $submission->initial_screening_comments || $submission->editor_notes)
                <section class="fu3">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="text-[.6rem] font-extrabold tracking-[.16em] uppercase
                                     text-[#8a6e28] flex items-center gap-2">
                            <span class="inline-block w-4 h-px bg-[#c9a84c]"></span>
                            Editorial Feedback
                        </span>
                        <div class="flex-1 h-px" style="background:linear-gradient(90deg,#e8dfd0,transparent)"></div>
                    </div>

                    <div class="space-y-4">

                        {{-- Chief Editor / Screening --}}
                        @if ($submission->initial_screening_status !== 'pending' || $submission->initial_screening_comments)
                            <div class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden
                                        shadow-[0_1px_6px_rgba(26,18,9,.05)]">
                                <div class="flex items-center gap-3 px-5 py-3.5
                                            bg-[#f3ece0] border-b border-[#e8dfd0]">
                                    <div class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center
                                                bg-[#fdf8ec] text-[#8a6e28]">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9v-2h2v2zm0-4H9V5h2v4z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[.8rem] font-bold text-[#1a1209]">Editor-in-Chief</p>
                                        <p class="text-[.65rem] text-[#6b5740] mt-0.5">Initial Screening Decision</p>
                                    </div>
                                    @if ($submission->initial_screening_status === 'passed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em] uppercase
                                                     bg-[#f0fdf4] border-[#86efac] text-[#065f46]">
                                            <span class="w-[5px] h-[5px] rounded-full bg-[#2d8176]"></span>
                                            Passed
                                        </span>
                                    @elseif ($submission->initial_screening_status === 'failed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em] uppercase
                                                     bg-[#fef2f2] border-[#fecaca] text-[#991b1b]">
                                            <span class="w-[5px] h-[5px] rounded-full bg-[#c0392b]"></span>
                                            Failed
                                        </span>
                                    @endif
                                </div>
                                @if ($submission->initial_screening_comments)
                                    <div class="px-5 py-5">
                                        <p class="text-[.62rem] font-extrabold tracking-[.12em] uppercase
                                                   text-[#6b5740] mb-2">Screening Comments</p>
                                        <p class="text-[.88rem] text-[#3d2f1a] leading-[1.7]">
                                            {{ $submission->initial_screening_comments }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Editor Notes --}}
                        @if ($submission->editor_notes)
                            <div class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden
                                        shadow-[0_1px_6px_rgba(26,18,9,.05)]">
                                <div class="flex items-center gap-3 px-5 py-3.5
                                            bg-[#f3ece0] border-b border-[#e8dfd0]">
                                    <div class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center
                                                bg-[#e8f4f2] text-[#2d8176]">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[.8rem] font-bold text-[#1a1209]">Editor</p>
                                        <p class="text-[.65rem] text-[#6b5740] mt-0.5">Official Editorial Notes</p>
                                    </div>
                                    @if ($submission->status === 'accepted')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em] uppercase
                                                     bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]">
                                            <span class="w-[5px] h-[5px] rounded-full bg-[#2d8176]"></span>
                                            Accepted
                                        </span>
                                    @elseif ($submission->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em] uppercase
                                                     bg-[#fef2f2] border-[#fecaca] text-[#991b1b]">
                                            <span class="w-[5px] h-[5px] rounded-full bg-[#c0392b]"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </div>
                                <div class="px-5 py-5">
                                    <p class="text-[.62rem] font-extrabold tracking-[.12em] uppercase
                                               text-[#6b5740] mb-2">Notes</p>
                                    <p class="text-[.88rem] text-[#3d2f1a] leading-[1.7]">
                                        {{ $submission->editor_notes }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Appeal Block --}}
                        @php $appeal = $submission->appeals()->latest()->first(); @endphp
                        @if ($appeal)
                            @php
                                $appealIsApproved = $appeal->status === 'approved';
                                $appealIsPending  = $appeal->isPending();
                                $iconBg  = $appealIsApproved ? '#e8f4f2' : ($appealIsPending ? '#fffbeb' : '#fef2f2');
                                $iconClr = $appealIsApproved ? '#2d8176' : ($appealIsPending ? '#d97706' : '#dc2626');
                            @endphp
                            <div class="bg-white border border-[#e8dfd0] rounded-[14px] overflow-hidden
                                        shadow-[0_1px_6px_rgba(26,18,9,.05)]">
                                <div class="flex items-center gap-3 px-5 py-3.5
                                            bg-[#f3ece0] border-b border-[#e8dfd0]">
                                    <div class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center"
                                         style="background:{{ $iconBg }};color:{{ $iconClr }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            @if ($appealIsApproved)
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            @else
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[.8rem] font-bold text-[#1a1209]">Editor-in-Chief</p>
                                        <p class="text-[.65rem] text-[#6b5740] mt-0.5">Appeal Decision</p>
                                    </div>
                                    @if ($appealIsApproved)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em] uppercase
                                                     bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]">
                                            <span class="w-[5px] h-[5px] rounded-full bg-[#2d8176]"></span>Approved
                                        </span>
                                    @elseif ($appeal->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em] uppercase
                                                     bg-[#fef2f2] border-[#fecaca] text-[#991b1b]">
                                            <span class="w-[5px] h-[5px] rounded-full bg-[#c0392b]"></span>Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                                     border text-[.58rem] font-extrabold tracking-[.08em] uppercase
                                                     bg-[#fffbeb] border-[#fde68a] text-[#92400e]">
                                            <span class="w-[5px] h-[5px] rounded-full bg-[#f59e0b]"></span>Pending
                                        </span>
                                    @endif
                                </div>
                                <div class="px-5 py-5">
                                    @if ($appeal->editor_response)
                                        <p class="text-[.62rem] font-extrabold tracking-[.12em] uppercase
                                                   text-[#6b5740] mb-2">Editor's Response</p>
                                        <p class="text-[.88rem] text-[#3d2f1a] leading-[1.7]">
                                            {{ $appeal->editor_response }}
                                        </p>
                                    @elseif ($appealIsPending)
                                        <p class="text-[.88rem] italic text-[#92400e] leading-[1.7]">
                                            Awaiting editor-in-chief review…
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </section>
            @endif

        </div>

        {{-- ════════════════════ RIGHT SIDEBAR ════════════════════ --}}
        <div class="lg:col-span-4">
            <div class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden
                        shadow-[0_2px_14px_rgba(26,18,9,.07)] sticky top-8 fu1">

                {{-- Sidebar Header --}}
                <div class="flex items-center gap-2 px-5 py-4
                            bg-[#f3ece0] border-b border-[#e8dfd0]
                            text-[.6rem] font-extrabold tracking-[.14em] uppercase text-[#8a6e28]">
                    <span class="inline-block w-4 h-px bg-[#c9a84c]"></span>
                    Manuscript Details
                </div>

                <div class="px-5 py-2 divide-y divide-[#f3ece0]">

                    {{-- Current Status --}}
                    <div class="py-4">
                        <p class="text-[.6rem] font-extrabold tracking-[.12em] uppercase
                                   text-[#6b5740] mb-2">Current Status</p>
                        @php
                            $sCls = match ($submission->status) {
                                'accepted'              => 'bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]',
                                'under_review',
                                'revision_under_review' => 'bg-[#fdf8ec] border-[rgba(201,168,76,.4)] text-[#8a6e28]',
                                'revisions_requested'   => 'bg-[#fff7ed] border-[#fed7aa] text-[#9a3412]',
                                'rejected'              => 'bg-[#fef2f2] border-[#fecaca] text-[#991b1b]',
                                default                 => 'bg-[#e8f4f2] border-[rgba(45,129,118,.3)] text-[#1a4d46]',
                            };
                            $sDot = match ($submission->status) {
                                'accepted','under_review','revision_under_review' => 'bg-[#2d8176]',
                                'revisions_requested' => 'bg-[#f97316]',
                                'rejected'            => 'bg-[#c0392b]',
                                default               => 'bg-[#2d8176]',
                            };
                            $sLabel = match ($submission->status) {
                                'revision_under_review' => 'Revision Review',
                                default => ucfirst(str_replace('_', ' ', $submission->status)),
                            };
                        @endphp
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border
                                     text-[.72rem] font-bold tracking-[.06em] uppercase {{ $sCls }}">
                            <span class="w-[7px] h-[7px] rounded-full animate-pulse {{ $sDot }}"></span>
                            {{ $sLabel }}
                        </span>
                    </div>

                    {{-- Author --}}
                    <div class="py-4">
                        <p class="text-[.6rem] font-extrabold tracking-[.12em] uppercase
                                   text-[#6b5740] mb-1">Corresponding Author</p>
                        <p class="font-['Libre_Baskerville',serif] text-[1rem] font-normal text-[#1a1209]">
                            {{ $submission->author->name }}
                        </p>
                    </div>

                    {{-- Submission Date --}}
                    <div class="py-4">
                        <p class="text-[.6rem] font-extrabold tracking-[.12em] uppercase
                                   text-[#6b5740] mb-1">Submission Date</p>
                        <p class="font-['Libre_Baskerville',serif] text-[1.3rem] font-bold
                                   text-[#1a1209] leading-none">
                            {{ $submission->submitted_at?->format('d M') ?? '—' }}
                        </p>
                        @if ($submission->submitted_at)
                            <p class="text-[.78rem] text-[#6b5740] mt-0.5">
                                {{ $submission->submitted_at->format('Y') }}
                            </p>
                        @endif
                    </div>

                    {{-- Research Field --}}
                    @if ($submission->research_field)
                        <div class="py-4">
                            <p class="text-[.6rem] font-extrabold tracking-[.12em] uppercase
                                       text-[#6b5740] mb-1">Research Field</p>
                            <p class="text-[.9rem] font-medium text-[#1a1209]">
                                {{ $submission->research_field }}
                            </p>
                        </div>
                    @endif

                    {{-- Keywords --}}
                    @if ($submission->keywords)
                        <div class="py-4">
                            <p class="text-[.6rem] font-extrabold tracking-[.12em] uppercase
                                       text-[#6b5740] mb-2">Keywords</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach (explode(',', $submission->keywords) as $kw)
                                    <span class="inline-block px-2.5 py-1 rounded
                                                 bg-[#f3ece0] border border-[#e8dfd0]
                                                 text-[.68rem] font-semibold tracking-[.04em]
                                                 text-[#6b5740] capitalize">
                                        {{ trim($kw) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Manuscript File --}}
                    @if ($submission->file_name)
                        <div class="py-4 last:pb-0">
                            <p class="text-[.6rem] font-extrabold tracking-[.12em] uppercase
                                       text-[#6b5740] mb-2">Manuscript File</p>
                            <div class="flex items-center gap-3 px-4 py-3
                                        bg-[#f3ece0] border border-[#e8dfd0] rounded-xl">
                                <div class="w-[38px] h-[38px] rounded-lg shrink-0
                                            bg-white border border-[#e8dfd0]
                                            flex items-center justify-center text-[#2d8176]
                                            shadow-[0_1px_4px_rgba(26,18,9,.06)]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[.78rem] font-semibold text-[#1a1209] truncate">
                                        {{ $submission->file_name }}
                                    </p>
                                    <p class="text-[.62rem] text-[#6b5740] tracking-[.06em] uppercase mt-0.5">
                                        Document
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>
@endsection