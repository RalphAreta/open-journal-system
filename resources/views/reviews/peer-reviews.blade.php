@extends('layouts.app')

@section('title', 'Peer Review Results')

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
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-up {
            animation: fadeUp 0.35s ease both;
        }
        .fade-up-1 {
            animation: fadeUp 0.35s 0.07s ease both;
        }
        .fade-up-2 {
            animation: fadeUp 0.35s 0.14s ease both;
        }
        .fade-up-3 {
            animation: fadeUp 0.35s 0.21s ease both;
        }
        .fade-up-4 {
            animation: fadeUp 0.35s 0.28s ease both;
        }

        .avatar-ring-1 {
            background: linear-gradient(135deg, #dc2626, #f87171);
        }
        .avatar-ring-2 {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
        }
        .avatar-ring-3 {
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
        }
        .avatar-ring-4 {
            background: linear-gradient(135deg, #059669, #34d399);
        }
        .avatar-ring-5 {
            background: linear-gradient(135deg, #d97706, #fcd34d);
        }
        .avatar-ring-6 {
            background: linear-gradient(135deg, #0891b2, #67e8f9);
        }
        .avatar-ring-you {
            background: linear-gradient(135deg, #3b82f6, #93c5fd);
        }

        .you-badge {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background: #eff6ff;
            border: 1.5px solid #bfdbfe;
            color: #2563eb;
            padding: 1px 7px;
            border-radius: 999px;
        }

        .rec-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border: 1.5px solid;
        }
        .rec-accept {
            background: #f0fdf4;
            border-color: #86efac;
            color: #15803d;
        }
        .rec-minor {
            background: #fffbeb;
            border-color: #fde68a;
            color: #b45309;
        }
        .rec-major {
            background: #fff7ed;
            border-color: #fdba74;
            color: #c2410c;
        }
        .rec-reject {
            background: #fef2f2;
            border-color: #fca5a5;
            color: #dc2626;
        }
        .rec-default {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #64748b;
        }

        .star {
            color: #e2e8f0;
            font-size: 15px;
        }
        .star.filled {
            color: #f59e0b;
        }

        .lock-card {
            background: repeating-linear-gradient(
                -45deg,
                #f8fafc,
                #f8fafc 8px,
                #f1f5f9 8px,
                #f1f5f9 16px
            );
        }

        .pip {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            transition: all 0.25s ease;
        }
        .pip.done {
            background: #22c55e;
            border-color: #22c55e;
        }
        .pip.yours {
            background: #3b82f6;
            border-color: #3b82f6;
        }
        .pip.wait {
            background: transparent;
            border-color: #cbd5e1;
        }

        .section-rule {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }
        .section-rule::before,
        .section-rule::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* ── Modal ── */
        .review-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(10, 20, 40, 0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.22s ease;
        }
        .review-modal-backdrop.open {
            opacity: 1;
            pointer-events: all;
        }
        .review-modal {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            width: 100%;
            max-width: 560px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 60px rgba(10, 20, 40, 0.2);
            transform: translateY(16px) scale(0.97);
            transition: transform 0.26s cubic-bezier(0.34, 1.3, 0.64, 1);
        }
        .review-modal-backdrop.open .review-modal {
            transform: translateY(0) scale(1);
        }
        .review-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem 0.9rem;
            border-bottom: 1px solid #f1f5f9;
            flex-shrink: 0;
        }
        .review-modal-body {
            overflow-y: auto;
            padding: 1.1rem 1.25rem;
            flex: 1;
        }
        .review-modal-body::-webkit-scrollbar {
            width: 4px;
        }
        .review-modal-body::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 99px;
        }
        .review-modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        .view-comments-btn {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: #3b82f6;
            border: 1.5px solid #bfdbfe;
            background: #eff6ff;
            border-radius: 8px;
            padding: 4px 12px;
            cursor: pointer;
            transition:
                background 0.18s,
                color 0.18s;
            white-space: nowrap;
        }
        .view-comments-btn:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .view-comments-btn.no-comments {
            color: #94a3b8;
            border-color: #e2e8f0;
            background: #f8fafc;
            cursor: default;
        }
    </style>
@endpush

@section('content')
    <div class="font-body max-w-7xl mx-auto">
        {{-- ── Back nav ── --}}
        <div class="mb-5 fade-up">
            <a
                href="{{ route('dashboard.reviewer') }}"
                class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-[.07em] text-slate-400 hover:text-red-600 transition-colors"
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
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
                Back to Dashboard
            </a>
        </div>

        {{-- ── Page header ── --}}
        <div class="mb-6 fade-up">
            <p
                class="text-[10px] font-bold uppercase tracking-widest text-red-500 mb-1"
            >
                Peer Review Results
            </p>
            <h1
                class="font-serif text-[1.8rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight"
            >
                {{ $submission->title }}
            </h1>
            <p class="text-sm text-slate-500 mt-1.5">
                by
                <span class="font-semibold text-slate-700">
                    {{ $submission->author->name }}
                </span>
                @if ($submission->research_field)
                    &nbsp;·&nbsp;
                    <span
                        class="inline-flex items-center gap-1 text-blue-600 font-semibold"
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-blue-400 inline-block"
                        ></span>
                        {{ $submission->research_field }}
                    </span>
                @endif
            </p>
        </div>

        {{-- ── Review progress tracker ── --}}
        <div
            class="bg-white border border-slate-200 rounded-2xl p-5 mb-5 shadow-sm fade-up-1"
        >
            <div class="flex items-center justify-between mb-4">
                <h2
                    class="text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                >
                    Review Progress
                </h2>
                @if ($allReviewsIn)
                    <span
                        class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[.05em] bg-emerald-50 border border-emerald-200 text-emerald-700 px-2.5 py-1 rounded-full"
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
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                        All Reviews In
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[.05em] bg-amber-50 border border-amber-200 text-amber-700 px-2.5 py-1 rounded-full"
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse inline-block"
                        ></span>
                        Awaiting {{ $totalAssigned - $totalSubmitted }} more
                    </span>
                @endif
            </div>

            {{-- Reviewer pips --}}
            <div class="flex items-center gap-3 flex-wrap">
                @php
                    $peerNum = 1;
                @endphp

                @foreach ($assignments as $i => $a)
                    @php
                        $isYou = $a->reviewer_id === auth()->id();
                        $isDone = $a->status === \App\Models\ReviewAssignment::STATUS_COMPLETED;
                        $pipClass = $isDone ? ($isYou ? 'yours' : 'done') : 'wait';
                        // Label: own name for me, Reviewer N for others
                        $label = $isYou ? auth()->user()->name : 'Reviewer ' . $peerNum;
                        if (! $isYou) {
                            $peerNum++;
                        }
                    @endphp

                    <div class="flex items-center gap-2">
                        <span class="pip {{ $pipClass }}"></span>
                        <span
                            class="text-xs font-semibold {{ $isYou ? 'text-blue-700' : 'text-slate-500' }}"
                        >
                            {{ $label }}
                            @if ($isYou)
                                <span class="you-badge ml-1">You</span>
                            @endif
                        </span>
                        @if ($isDone)
                            <svg
                                class="w-3 h-3 text-emerald-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        @else
                            <span
                                class="text-[10px] text-slate-300 font-medium"
                            >
                                pending
                            </span>
                        @endif
                    </div>
                    @if (! $loop->last)
                        <span class="text-slate-200 text-xs select-none">
                            —
                        </span>
                    @endif
                @endforeach
            </div>

            {{-- Progress bar --}}
            <div class="mt-4 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div
                    class="h-full rounded-full transition-all duration-500 {{ $allReviewsIn ? 'bg-emerald-500' : 'bg-blue-500' }}"
                    style="
                        width: {{ $totalAssigned > 0 ? round(($totalSubmitted / $totalAssigned) * 100) : 0 }}%;
                    "
                ></div>
            </div>
            <p class="text-[10px] text-slate-400 mt-1.5 font-medium">
                {{ $totalSubmitted }} of {{ $totalAssigned }} reviewers have
                submitted
            </p>
        </div>

        {{-- ── Manuscript info card ── --}}
        <div
            class="bg-white border border-slate-200 rounded-2xl p-5 mb-5 shadow-sm fade-up-2"
        >
            <h2
                class="text-[10px] font-bold uppercase tracking-[.09em] text-slate-400 mb-4"
            >
                Manuscript Details
            </h2>
            <div class="grid grid-cols-2 gap-x-8 gap-y-3 text-sm mb-4">
                <div>
                    <p
                        class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-0.5"
                    >
                        Author
                    </p>
                    <p class="font-semibold text-slate-800">
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
                @if ($submission->submitted_at)
                    <div>
                        <p
                            class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-0.5"
                        >
                            Submitted
                        </p>
                        <p class="text-slate-700">
                            {{ $submission->submitted_at->format('M d, Y') }}
                        </p>
                    </div>
                @endif

                @if ($submission->file_name)
                    <div>
                        <p
                            class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-0.5"
                        >
                            File
                        </p>
                        <p class="text-sm text-slate-600 font-medium truncate">
                            {{ $submission->file_name }}
                        </p>
                    </div>
                @endif
            </div>
            @if ($submission->abstract)
                <div class="pt-4 border-t border-slate-100">
                    <p
                        class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-1.5"
                    >
                        Abstract
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $submission->abstract }}
                    </p>
                </div>
            @endif
        </div>

        {{-- ── Two-column layout ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-up-3">
            {{-- Left: Your submitted review --}}
            <div class="lg:col-span-2">
                <div class="section-rule mb-5">Your Submitted Review</div>
                @if ($myReview)
                    @php
                        $recMap = [
                            'accept' => ['label' => 'Accept', 'cls' => 'rec-accept'],
                            'minor_revisions' => ['label' => 'Minor Revisions', 'cls' => 'rec-minor'],
                            'major_revisions' => ['label' => 'Major Revisions', 'cls' => 'rec-major'],
                            'reject' => ['label' => 'Reject', 'cls' => 'rec-reject'],
                        ];
                        $myRec = $recMap[$myReview->recommendation] ?? ['label' => $myReview->recommendation ?? '—', 'cls' => 'rec-default'];
                    @endphp

                    <div
                        class="bg-blue-50 border border-blue-200 rounded-2xl p-5"
                    >
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p
                                    class="text-[10px] font-bold uppercase tracking-[.08em] text-blue-600 mb-0.5"
                                >
                                    Your Recommendation
                                </p>
                                <span class="rec-pill {{ $myRec['cls'] }}">
                                    {{ $myRec['label'] }}
                                </span>
                            </div>
                            @if ($myReview->rating)
                                <div class="text-right">
                                    <p
                                        class="text-[10px] font-bold uppercase tracking-[.07em] text-blue-500 mb-1"
                                    >
                                        Your Rating
                                    </p>
                                    <div class="flex gap-0.5 justify-end">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <span
                                                class="star {{ $s <= $myReview->rating ? 'filled' : '' }}"
                                            >
                                                ★
                                            </span>
                                        @endfor
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if ($myReview->comments_for_author)
                            <div class="mb-3 pt-3 border-t border-blue-200">
                                <p
                                    class="text-[10px] font-bold uppercase tracking-[.07em] text-blue-500 mb-1.5"
                                >
                                    Comments for Author
                                </p>
                                <p
                                    class="text-sm text-blue-900 leading-relaxed"
                                >
                                    {{ $myReview->comments_for_author }}
                                </p>
                            </div>
                        @endif

                        @if ($myReview->comments_for_editor)
                            <div class="pt-3 border-t border-blue-200">
                                <p
                                    class="text-[10px] font-bold uppercase tracking-[.07em] text-blue-500 mb-1.5"
                                >
                                    Comments for Editor (Internal)
                                </p>
                                <p
                                    class="text-sm text-blue-900 leading-relaxed italic"
                                >
                                    {{ $myReview->comments_for_editor }}
                                </p>
                            </div>
                        @endif

                        @if ($myReview->submitted_at)
                            <p class="text-[10px] text-blue-400 mt-3 font-mono">
                                Submitted
                                {{ $myReview->submitted_at->format('M d, Y \a\t g:i A') }}
                            </p>
                        @endif
                    </div>
                @else
                    <div
                        class="bg-slate-50 border border-slate-100 rounded-2xl p-5 text-slate-600"
                    >
                        You have not submitted a review yet.
                        <a
                            href="{{ route('reviews.create', ['assignment' => $assignments->firstWhere('reviewer_id', auth()->id())]) }}"
                            class="text-blue-600 hover:underline"
                        >
                            Open review form
                        </a>
                    </div>
                @endif
            </div>

            {{-- Right: Peer reviews --}}
            <div class="lg:col-span-1">
                <div class="section-rule mb-5">Peer Reviews</div>

                @if (! $allReviewsIn)
                    {{-- Locked state --}}
                    <div
                        class="lock-card border border-slate-200 rounded-2xl p-6 text-center mb-4"
                    >
                        <div
                            class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center mx-auto mb-3"
                        >
                            <svg
                                class="w-6 h-6 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-700 mb-1">
                            Reviews Are Hidden
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Peer reviews will be revealed once
                            <strong>all {{ $totalAssigned }} reviewers</strong>
                            have submitted.
                        </p>
                        <div
                            class="mt-4 inline-flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-500"
                        >
                            <span
                                class="w-2 h-2 rounded-full bg-amber-400 animate-pulse inline-block"
                            ></span>
                            Waiting for {{ $totalAssigned - $totalSubmitted }}
                            more
                        </div>
                    </div>

                    <div class="space-y-3">
                        @php
                            $peerNum2 = 1;
                        @endphp

                        @foreach ($assignments as $i => $a)
                            @php
                                $isYou = $a->reviewer_id === auth()->id();
                                $label = $isYou ? auth()->user()->name : 'Reviewer ' . $peerNum2;
                                if (! $isYou) {
                                    $peerNum2++;
                                }
                            @endphp

                            <div
                                class="bg-white border border-slate-100 rounded-xl p-4 opacity-60"
                            >
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full {{ $isYou ? 'avatar-ring-you' : 'avatar-ring-' . (($i % 6) + 1) }} flex items-center justify-center text-white text-xs font-bold"
                                    >
                                        {{ $isYou ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'R' . ($peerNum2 - 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <p
                                                class="text-sm font-bold {{ $isYou ? 'text-blue-700' : 'text-slate-800' }}"
                                            >
                                                {{ $label }}
                                            </p>
                                            @if ($isYou)
                                                <span class="you-badge">
                                                    You
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-400">
                                            @if ($a->status === \App\Models\ReviewAssignment::STATUS_COMPLETED)
                                                <span
                                                    class="text-emerald-600 font-semibold"
                                                >
                                                    ✓ Submitted
                                                </span>
                                            @else
                                                    Pending…
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- All reviews in — show cards with popup comments --}}
                    <div class="space-y-4">
                        @php
                            $peerNum3 = 1;
                        @endphp

                        @foreach ($reviews->values() as $i => $r)
                            @php
                                $isYou = $r->reviewer_id === auth()->id();
                                $ringIdx = ($i % 6) + 1;
                                $recMap = [
                                    'accept' => ['label' => 'Accept', 'cls' => 'rec-accept'],
                                    'minor_revisions' => ['label' => 'Minor Revisions', 'cls' => 'rec-minor'],
                                    'major_revisions' => ['label' => 'Major Revisions', 'cls' => 'rec-major'],
                                    'reject' => ['label' => 'Reject', 'cls' => 'rec-reject'],
                                ];
                                $rec = $recMap[$r->recommendation] ?? ['label' => $r->recommendation ?? '—', 'cls' => 'rec-default'];

                                // Name: own name for me, Reviewer N for others
                                $displayName = $isYou ? auth()->user()->name : 'Reviewer ' . $peerNum3;
                                $avatarLabel = $isYou ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'R' . $peerNum3;
                                if (! $isYou) {
                                    $peerNum3++;
                                }

                                $modalId = 'modal-review-' . $i;
                                $hasComments = $r->comments_for_author || ($isYou && $r->comments_for_editor);
                            @endphp

                            <div
                                class="bg-white border {{ $isYou ? 'border-blue-200' : 'border-slate-200' }} rounded-2xl p-4 shadow-sm {{ $isYou ? 'ring-1 ring-blue-100' : '' }}"
                            >
                                <div
                                    class="flex items-center justify-between mb-3"
                                >
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full {{ $isYou ? 'avatar-ring-you' : 'avatar-ring-' . $ringIdx }} flex items-center justify-center text-white text-xs font-bold"
                                        >
                                            {{ $avatarLabel }}
                                        </div>
                                        <div>
                                            <div
                                                class="flex items-center gap-2"
                                            >
                                                <p
                                                    class="text-sm font-bold {{ $isYou ? 'text-blue-700' : 'text-slate-800' }}"
                                                >
                                                    {{ $displayName }}
                                                </p>
                                                @if ($isYou)
                                                    <span class="you-badge">
                                                        You
                                                    </span>
                                                @endif
                                            </div>
                                            @if ($r->submitted_at)
                                                <p
                                                    class="text-[10px] text-slate-400 mt-0.5"
                                                >
                                                    {{ $r->submitted_at->format('M d, Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="rec-pill {{ $rec['cls'] }}">
                                        {{ $rec['label'] }}
                                    </span>
                                </div>

                                @if ($r->rating)
                                    <div
                                        class="flex items-center gap-2 mb-3 pb-3 border-b border-slate-100"
                                    >
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400"
                                        >
                                            Rating
                                        </span>
                                        <div class="flex gap-0.5">
                                            @for ($s = 1; $s <= 5; $s++)
                                                <span
                                                    class="star {{ $s <= $r->rating ? 'filled' : '' }}"
                                                >
                                                    ★
                                                </span>
                                            @endfor
                                        </div>
                                        <span
                                            class="text-xs font-bold text-slate-600 ml-1"
                                        >
                                            {{ $r->rating }}/5
                                        </span>
                                    </div>
                                @endif

                                {{-- View Comments button --}}

                                @if ($hasComments)
                                    <button
                                        onclick="
                                            openReviewModal('{{ $modalId }}')
                                        "
                                        class="view-comments-btn w-full mt-1"
                                    >
                                        View Comments →
                                    </button>
                                @else
                                    <span
                                        class="view-comments-btn no-comments w-full mt-1 block text-center"
                                    >
                                        No written comments
                                    </span>
                                @endif
                            </div>

                            {{-- Comments Modal for this review --}}
                            @if ($hasComments)
                                <div
                                    id="{{ $modalId }}"
                                    class="review-modal-backdrop"
                                    onclick="
                                        closeOnBackdrop(
                                            event,
                                            '{{ $modalId }}',
                                        )
                                    "
                                >
                                    <div class="review-modal">
                                        <div class="review-modal-header">
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <div
                                                    class="w-8 h-8 rounded-full {{ $isYou ? 'avatar-ring-you' : 'avatar-ring-' . $ringIdx }} flex items-center justify-center text-white text-xs font-bold"
                                                >
                                                    {{ $avatarLabel }}
                                                </div>
                                                <div>
                                                    <p
                                                        class="text-sm font-bold {{ $isYou ? 'text-blue-700' : 'text-slate-800' }}"
                                                    >
                                                        {{ $displayName }}
                                                        @if ($isYou)
                                                            <span
                                                                class="you-badge ml-1"
                                                            >
                                                                You
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <p
                                                        class="text-[10px] text-slate-400"
                                                    >
                                                        Review Comments
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                onclick="
                                                    closeReviewModal(
                                                        '{{ $modalId }}',
                                                    )
                                                "
                                                class="w-8 h-8 rounded-full border border-slate-200 text-slate-400 hover:bg-red-50 hover:border-red-200 hover:text-red-500 flex items-center justify-center transition-all"
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
                                        <div
                                            class="review-modal-body space-y-4"
                                        >
                                            @if ($r->comments_for_author)
                                                <div>
                                                    <p
                                                        class="text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 mb-2"
                                                    >
                                                        Comments for Author
                                                    </p>
                                                    <p
                                                        class="text-sm text-slate-700 leading-relaxed"
                                                    >
                                                        {{ $r->comments_for_author }}
                                                    </p>
                                                </div>
                                            @endif

                                            @if ($isYou && $r->comments_for_editor)
                                                <div
                                                    class="pt-4 border-t border-slate-100"
                                                >
                                                    <p
                                                        class="text-[10px] font-bold uppercase tracking-[.07em] text-blue-500 mb-2"
                                                    >
                                                        Your Comments for Editor
                                                        (Internal)
                                                    </p>
                                                    <p
                                                        class="text-sm text-slate-700 leading-relaxed italic"
                                                    >
                                                        {{ $r->comments_for_editor }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openReviewModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeReviewModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('open');
            document.body.style.overflow = '';
        }
        function closeOnBackdrop(event, id) {
            if (event.target === event.currentTarget) closeReviewModal(id);
        }
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document
                    .querySelectorAll('.review-modal-backdrop.open')
                    .forEach((el) => {
                        el.classList.remove('open');
                        document.body.style.overflow = '';
                    });
            }
        });
    </script>
@endpush
