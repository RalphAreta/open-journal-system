@extends('layouts.app')

@section('title', $submission->title)

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --gold: #c9a84c;
            --gold-lt: #e8d49a;
            --gold-dk: #8a6e28;
            --red: #c0392b;
            --teal: #2d8176;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
        }
        * {
            box-sizing: border-box;
        }
        .sw {
            font-family: 'Outfit', sans-serif;
            color: var(--ink);
        }
        .serif {
            font-family: 'Cormorant Garamond', serif;
        }

        .sw-bg {
            background-color: var(--cream);
            background-image:
                radial-gradient(
                    ellipse 80% 40% at 50% -5%,
                    rgba(201, 168, 76, 0.09) 0%,
                    transparent 65%
                ),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.45'/%3E%3C/svg%3E");
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 20px;
        }
        .breadcrumb a {
            color: var(--gold-dk);
            text-decoration: none;
            transition: color 0.12s;
        }
        .breadcrumb a:hover {
            color: var(--red);
        }
        .breadcrumb svg {
            width: 10px;
            height: 10px;
            color: var(--border-dk);
        }

        /* ── Page title ── */
        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.7rem, 3vw, 2.5rem);
            font-weight: 300;
            color: var(--ink);
            line-height: 1.15;
            letter-spacing: -0.02em;
        }
        .page-title-border {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), transparent);
            margin-top: 14px;
        }

        /* ── Buttons ── */
        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: #fff;
            border: 1.5px solid var(--border-dk);
            border-radius: 7px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-ghost:hover {
            background: var(--parchment);
            border-color: var(--gold);
            color: var(--ink);
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: var(--ink);
            border: 1.5px solid var(--ink);
            border-radius: 7px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #fff;
            text-decoration: none;
            transition: all 0.15s;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(201, 168, 76, 0.15) 0%,
                transparent 60%
            );
        }
        .btn-primary:hover {
            background: var(--ink-mid);
            transform: translateY(-1px);
        }

        /* ── Section headers ── */
        .sec-head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }
        .sec-head-label {
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--gold-dk);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sec-head-label::before {
            content: '';
            width: 18px;
            height: 1px;
            background: var(--gold);
        }
        .sec-head-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--border), transparent);
        }

        /* ── Action banner ── */
        .action-banner {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid;
            display: flex;
            align-items: stretch;
            box-shadow: 0 4px 20px rgba(26, 18, 9, 0.09);
        }
        .action-banner-accent {
            width: 5px;
            flex-shrink: 0;
        }
        .action-banner-body {
            flex: 1;
            padding: 18px 22px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }
        .action-banner-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
            font-weight: 700;
        }
        .action-banner-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--ink);
        }
        .action-banner-sub {
            font-size: 0.74rem;
            color: var(--ink-soft);
            margin-top: 2px;
        }

        .btn-banner-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border-radius: 7px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            border: 1.5px solid;
            transition: all 0.15s;
            white-space: nowrap;
        }

        /* ── Abstract ── */
        .abstract-block {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 32px 36px;
            position: relative;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
        }
        .abstract-block::before {
            content: '\201C';
            font-family: 'Cormorant Garamond', serif;
            font-size: 7rem;
            line-height: 1;
            color: var(--gold-lt);
            position: absolute;
            top: 8px;
            left: 24px;
            pointer-events: none;
        }
        .abstract-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.13rem;
            font-weight: 400;
            font-style: italic;
            color: var(--ink-mid);
            line-height: 1.8;
            position: relative;
            z-index: 1;
            padding-top: 10px;
        }

        /* ── Review card ── */
        .review-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(26, 18, 9, 0.05);
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
        }
        .review-card:hover {
            border-color: var(--border-dk);
            box-shadow: 0 4px 16px rgba(26, 18, 9, 0.09);
        }
        .review-card-head {
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .reviewer-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        .reviewer-name {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--ink);
        }
        .reviewer-date {
            font-size: 0.62rem;
            font-weight: 500;
            color: var(--ink-soft);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-top: 1px;
        }
        .rec-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 0.58rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .review-card-body {
            padding: 20px 22px;
        }
        .review-body-text {
            font-size: 0.84rem;
            color: var(--ink-soft);
            line-height: 1.75;
        }
        .rating-row {
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--ink-soft);
        }

        /* ── Feedback block (editorial) ── */
        .feedback-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(26, 18, 9, 0.05);
        }
        .feedback-card-head {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
        }
        .feedback-avatar {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .feedback-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: 0.03em;
        }
        .feedback-sub {
            font-size: 0.62rem;
            color: var(--ink-soft);
            margin-top: 1px;
        }
        .feedback-body {
            padding: 16px 20px;
        }
        .feedback-note-label {
            font-size: 0.58rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 6px;
        }
        .feedback-note-text {
            font-size: 0.81rem;
            color: var(--ink-mid);
            line-height: 1.7;
        }

        /* status badge variants */
        .sbadge-sm {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.58rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .sbadge-sm .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }
        .sb-accepted {
            background: #f0fdf4;
            border-color: #86efac;
            color: #065f46;
        }
        .sb-accepted .dot {
            background: #10b981;
        }
        .sb-rejected {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }
        .sb-rejected .dot {
            background: var(--red);
        }
        .sb-pending {
            background: #fffbeb;
            border-color: #fde68a;
            color: #92400e;
        }
        .sb-pending .dot {
            background: #f59e0b;
        }
        .sb-approved {
            background: #f0fdf4;
            border-color: #86efac;
            color: #065f46;
        }
        .sb-approved .dot {
            background: #10b981;
        }

        /* ── Sidebar ── */
        .sidebar-card {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 14px rgba(26, 18, 9, 0.07);
        }
        .sidebar-card-head {
            padding: 14px 20px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--gold-dk);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sidebar-card-head::before {
            content: '';
            width: 16px;
            height: 1px;
            background: var(--gold);
        }
        .sidebar-body {
            padding: 20px;
        }
        .meta-row {
            padding: 12px 0;
            border-bottom: 1px solid var(--parchment);
        }
        .meta-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .meta-label {
            font-size: 0.58rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 5px;
        }

        .status-main-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 14px;
            border-radius: 7px;
            background: var(--ink);
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #fff;
        }

        .keyword-chip {
            display: inline-block;
            padding: 3px 10px;
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: var(--ink-soft);
            text-transform: capitalize;
        }
        .file-block {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 9px;
            margin-top: 8px;
        }
        .file-icon-box {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--red);
            flex-shrink: 0;
        }
        .file-name {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--ink);
            truncate: true;
        }
        .file-sub {
            font-size: 0.6rem;
            color: var(--ink-soft);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 1px;
        }

        /* ── Fade-in ── */
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
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="sw sw-bg max-w-6xl mx-auto px-1 py-2">
        {{-- ── Breadcrumb ── --}}
        <nav class="breadcrumb fu">
            <a href="{{ route('submissions.index') }}">Board</a>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 5l7 7-7 7" stroke-width="2.5" />
            </svg>
            <span style="color: var(--ink)">
                Manuscript
                #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
            </span>
        </nav>

        {{-- ── Page Header ── --}}
        <div
            class="fu flex flex-col md:flex-row justify-between items-start gap-6 mb-10"
        >
            <div class="flex-1">
                <p
                    style="
                        font-size: 0.6rem;
                        font-weight: 700;
                        letter-spacing: 0.16em;
                        text-transform: uppercase;
                        color: var(--gold-dk);
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        margin-bottom: 10px;
                    "
                >
                    <span
                        style="
                            width: 18px;
                            height: 1px;
                            background: var(--gold);
                            display: inline-block;
                        "
                    ></span>
                    Author Submission
                </p>
                <h1 class="page-title">{{ $submission->title }}</h1>
                <div class="page-title-border"></div>
            </div>
            <div class="flex items-center gap-3 shrink-0 self-start mt-2">
                @if ($submission->isEditableByAuthor() && auth()->user()->id === $submission->author_id && $submission->status === 'submitted')
                    <a
                        href="{{ route('submissions.edit', $submission) }}"
                        class="btn-ghost"
                    >
                        <svg
                            class="w-3 h-3"
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

                <a href="{{ route('submissions.index') }}" class="btn-primary">
                    ← Back to Board
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            {{-- ── Left Column ── --}}
            <div class="lg:col-span-8 space-y-10">
                {{-- Pending Revision Banner --}}
                @php
                    $pendingRevisions = $submission
                        ->revisionRequests()
                        ->whereNull('revised_at')
                        ->count();
                @endphp

                @if ($pendingRevisions > 0 && auth()->user()->id === $submission->author_id)
                    <div
                        class="action-banner fu1"
                        style="border-color: #fed7aa"
                    >
                        <div
                            class="action-banner-accent"
                            style="background: #f97316"
                        ></div>
                        <div class="action-banner-body">
                            <div class="flex items-center gap-12">
                                <div
                                    class="action-banner-icon"
                                    style="background: #fff7ed; color: #ea580c"
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
                                    <p class="action-banner-title">
                                        Revision Required
                                    </p>
                                    <p class="action-banner-sub">
                                        {{ $pendingRevisions }} request(s)
                                        awaiting your response
                                    </p>
                                </div>
                            </div>
                            <a
                                href="{{ route('submissions.revisions', $submission) }}"
                                class="btn-banner-action"
                                style="
                                    background: #ea580c;
                                    border-color: #ea580c;
                                    color: #fff;
                                "
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
                        class="action-banner fu1"
                        style="
                            border-color: {{ $isAcc ? '#86efac' : '#fecaca' }};
                        "
                    >
                        <div
                            class="action-banner-accent"
                            style="
                                background: {{ $isAcc ? '#10b981' : '#dc2626' }};
                            "
                        ></div>
                        <div class="action-banner-body">
                            <div class="flex items-center gap-12">
                                <div
                                    class="action-banner-icon"
                                    style="
                                        background: {{ $isAcc ? '#f0fdf4' : '#fef2f2' }};
                                        color: {{ $isAcc ? '#10b981' : '#dc2626' }};
                                        font-size: 1.1rem;
                                        font-weight: 700;
                                    "
                                >
                                    {{ $isAcc ? '✓' : '✕' }}
                                </div>
                                <div>
                                    <p class="action-banner-title">
                                        Editorial Decision:
                                        {{ $isAcc ? 'Accepted' : 'Rejected' }}
                                    </p>
                                    <p class="action-banner-sub">
                                        Decided on
                                        {{ $submission->editor_decision_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            @if ($submission->editor_notes)
                                <span
                                    style="
                                        font-size: 0.72rem;
                                        color: var(--ink-soft);
                                    "
                                >
                                    See editorial feedback below
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Abstract --}}
                <section class="fu1">
                    <div class="sec-head">
                        <span class="sec-head-label">Abstract</span>
                        <div class="sec-head-line"></div>
                    </div>
                    <div class="abstract-block">
                        <p class="abstract-text">
                            {{ $submission->abstract }}
                        </p>
                    </div>
                </section>

                {{-- Appeal Section --}}
                @include('submissions.partials.appeal-section')

                {{-- Peer Review Logs --}}
                @if ($submission->reviews->isNotEmpty() &&(auth()->user()->id === $submission->author_id ||auth()->user()->isEditor() ||auth()->user()->isAdmin()))
                    <section class="fu2">
                        <div class="sec-head">
                            <span class="sec-head-label">Peer Review Logs</span>
                            <div class="sec-head-line"></div>
                            <span
                                style="
                                    font-size: 0.62rem;
                                    font-weight: 600;
                                    color: var(--ink-soft);
                                    white-space: nowrap;
                                "
                            >
                                {{ $submission->reviews->count() }}
                                {{ Str::plural('review', $submission->reviews->count()) }}
                            </span>
                        </div>
                        <div class="space-y-4">
                            @foreach ($submission->reviews as $i => $r)
                                <div class="review-card">
                                    <div class="review-card-head">
                                        <div class="flex items-center gap-10">
                                            <div
                                                class="reviewer-avatar"
                                                style="
                                                    background: var(
                                                        --parchment
                                                    );
                                                    border: 1.5px solid
                                                        var(--border-dk);
                                                    color: var(--gold-dk);
                                                "
                                            >
                                                @if (auth()->user()->id === $submission->author_id)
                                                    R{{ $i + 1 }}
                                                @else
                                                    {{ substr($r->reviewer->name, 0, 2) }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="reviewer-name">
                                                    @if (auth()->user()->id === $submission->author_id)
                                                        Reviewer {{ $i + 1 }}
                                                    @else
                                                        {{ $r->reviewer->name }}
                                                    @endif
                                                </p>
                                                <p class="reviewer-date">
                                                    {{ $r->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        @if (auth()->user()->id !== $submission->author_id && $r->recommendation)
                                            @php
                                                $recColors = [
                                                    'accept' => 'background:#f0fdf4;border-color:#86efac;color:#065f46;',
                                                    'minor_revisions' => 'background:#fffbeb;border-color:#fde68a;color:#92400e;',
                                                    'major_revisions' => 'background:#fff7ed;border-color:#fed7aa;color:#9a3412;',
                                                    'reject' => 'background:#fef2f2;border-color:#fecaca;color:#991b1b;',
                                                ];
                                                $recStyle = $recColors[$r->recommendation] ?? 'background:var(--parchment);border-color:var(--border);color:var(--ink-soft);';
                                            @endphp

                                            <span
                                                class="rec-pill"
                                                style="{{ $recStyle }}"
                                            >
                                                {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}
                                            </span>
                                        @endif
                                    </div>
                                    @if ($r->comments_for_author)
                                        <div class="review-card-body">
                                            <p class="review-body-text">
                                                {{ $r->comments_for_author }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Revision Review Feedback --}}
                @php
                    $allRevisionReviews = [];
                    foreach ($submission->revisionRequests as $rev) {
                        foreach ($rev->revisionReviews as $revRev) {
                            if ($revRev->comments_for_author) {
                                $allRevisionReviews[] = $revRev;
                            }
                        }
                    }
                @endphp

                @if (! empty($allRevisionReviews) &&(auth()->user()->id === $submission->author_id ||auth()->user()->isEditor() ||auth()->user()->isAdmin()))
                    <section class="fu2">
                        <div class="sec-head">
                            <span class="sec-head-label">
                                Revision Review Feedback
                            </span>
                            <div class="sec-head-line"></div>
                        </div>
                        <div class="space-y-4">
                            @foreach ($allRevisionReviews as $i => $rr)
                                <div class="review-card">
                                    <div class="review-card-head">
                                        <div class="flex items-center gap-10">
                                            <div
                                                class="reviewer-avatar"
                                                style="
                                                    background: #eff6ff;
                                                    border: 1.5px solid #bfdbfe;
                                                    color: #1e40af;
                                                "
                                            >
                                                @if (auth()->user()->id === $submission->author_id)
                                                    R{{ $i + 1 }}
                                                @else
                                                    {{ substr($rr->reviewer->name, 0, 2) }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="reviewer-name">
                                                    @if (auth()->user()->id === $submission->author_id)
                                                        Reviewer {{ $i + 1 }}
                                                    @else
                                                        {{ $rr->reviewer->name }}
                                                    @endif
                                                </p>
                                                <p class="reviewer-date">
                                                    {{ $rr->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        @if ($rr->recommendation && auth()->user()->id !== $submission->author_id)
                                            <span
                                                class="rec-pill"
                                                style="
                                                    background: #eff6ff;
                                                    border-color: #bfdbfe;
                                                    color: #1e40af;
                                                "
                                            >
                                                {{ \App\Models\RevisionReview::recommendationOptions()[$rr->recommendation] ?? $rr->recommendation }}
                                            </span>
                                        @endif
                                    </div>
                                    @if ($rr->comments_for_author)
                                        <div class="review-card-body">
                                            <p class="review-body-text">
                                                {{ $rr->comments_for_author }}
                                            </p>
                                            @if ($rr->rating)
                                                <div class="rating-row">
                                                    Rating:
                                                    <span
                                                        style="
                                                            color: #1e40af;
                                                            font-weight: 700;
                                                        "
                                                    >
                                                        {{ $rr->rating }}/5.0
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Editorial Feedback --}}
                @if ($submission->initial_screening_status !== 'pending' || $submission->initial_screening_comments || $submission->editor_notes)
                    <section class="fu3">
                        <div class="sec-head">
                            <span class="sec-head-label">
                                Editorial Feedback
                            </span>
                            <div class="sec-head-line"></div>
                        </div>
                        <div class="space-y-4">
                            {{-- Chief Editor / Screening --}}
                            @if ($submission->initial_screening_status !== 'pending' || $submission->initial_screening_comments)
                                <div class="feedback-card">
                                    <div class="feedback-card-head">
                                        <div
                                            class="feedback-avatar"
                                            style="
                                                background: #f5f3ff;
                                                color: #7c3aed;
                                            "
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
                                            <p class="feedback-label">
                                                Editor-in-Chief
                                            </p>
                                            <p class="feedback-sub">
                                                Initial Screening Decision
                                            </p>
                                        </div>
                                        @if ($submission->initial_screening_status === 'passed')
                                            <span class="sbadge-sm sb-accepted">
                                                <span class="dot"></span>
                                                Passed
                                            </span>
                                        @elseif ($submission->initial_screening_status === 'failed')
                                            <span class="sbadge-sm sb-rejected">
                                                <span class="dot"></span>
                                                Failed
                                            </span>
                                        @endif
                                    </div>
                                    @if ($submission->initial_screening_comments)
                                        <div class="feedback-body">
                                            <p class="feedback-note-label">
                                                Screening Comments
                                            </p>
                                            <p class="feedback-note-text">
                                                {{ $submission->initial_screening_comments }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Editor Notes --}}
                            @if ($submission->editor_notes)
                                <div class="feedback-card">
                                    <div class="feedback-card-head">
                                        <div
                                            class="feedback-avatar"
                                            style="
                                                background: #eff6ff;
                                                color: #1d4ed8;
                                            "
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
                                            <p class="feedback-label">Editor</p>
                                            <p class="feedback-sub">
                                                Official Editorial Notes
                                            </p>
                                        </div>
                                        @if ($submission->status === 'accepted')
                                            <span class="sbadge-sm sb-accepted">
                                                <span class="dot"></span>
                                                Accepted
                                            </span>
                                        @elseif ($submission->status === 'rejected')
                                            <span class="sbadge-sm sb-rejected">
                                                <span class="dot"></span>
                                                Rejected
                                            </span>
                                        @endif
                                    </div>
                                    <div class="feedback-body">
                                        <p class="feedback-note-label">Notes</p>
                                        <p class="feedback-note-text">
                                            {{ $submission->editor_notes }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Appeal Block --}}
                            @php
                                $appeal = $submission
                                    ->appeals()
                                    ->latest()
                                    ->first();
                            @endphp

                            @if ($appeal)
                                <div class="feedback-card">
                                    <div class="feedback-card-head">
                                        <div
                                            class="feedback-avatar"
                                            style="
                                                background: {{ $appeal->status === 'approved' ? '#f0fdf4' : ($appeal->isPending() ? '#fffbeb' : '#fef2f2') }};
                                                color: {{ $appeal->status === 'approved' ? '#10b981' : ($appeal->isPending() ? '#d97706' : '#dc2626') }};
                                            "
                                        >
                                            <svg
                                                class="w-4 h-4"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                @if ($appeal->status === 'approved')
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
                                            <p class="feedback-label">
                                                Editor-in-Chief
                                            </p>
                                            <p class="feedback-sub">
                                                Appeal Decision
                                            </p>
                                        </div>
                                        @if ($appeal->status === 'approved')
                                            <span class="sbadge-sm sb-approved">
                                                <span class="dot"></span>
                                                Approved
                                            </span>
                                        @elseif ($appeal->status === 'rejected')
                                            <span class="sbadge-sm sb-rejected">
                                                <span class="dot"></span>
                                                Rejected
                                            </span>
                                        @else
                                            <span class="sbadge-sm sb-pending">
                                                <span class="dot"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                    <div class="feedback-body">
                                        @if ($appeal->editor_response)
                                            <p class="feedback-note-label">
                                                Editor's Response
                                            </p>
                                            <p class="feedback-note-text">
                                                {{ $appeal->editor_response }}
                                            </p>
                                        @elseif ($appeal->isPending())
                                            <p
                                                class="feedback-note-text"
                                                style="
                                                    color: #92400e;
                                                    font-style: italic;
                                                "
                                            >
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

            {{-- ── Right Sidebar ── --}}
            <div class="lg:col-span-4">
                <div class="sidebar-card sticky top-8 fu1">
                    <div class="sidebar-card-head">Manuscript Details</div>
                    <div class="sidebar-body space-y-0">
                        <div class="meta-row">
                            <p class="meta-label">Current Status</p>
                            <span class="status-main-badge">
                                <span
                                    style="
                                        width: 6px;
                                        height: 6px;
                                        border-radius: 50%;
                                        background: var(--gold);
                                        animation: pulse 2s infinite;
                                    "
                                ></span>
                                {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                            </span>
                        </div>

                        <div class="meta-row">
                            <p class="meta-label">Corresponding Author</p>
                            <p
                                style="
                                    font-family: 'Cormorant Garamond', serif;
                                    font-size: 1rem;
                                    font-weight: 400;
                                    color: var(--ink);
                                "
                            >
                                {{ $submission->author->name }}
                            </p>
                        </div>

                        <div class="meta-row">
                            <p class="meta-label">Submission Date</p>
                            <p
                                style="
                                    font-size: 0.82rem;
                                    font-weight: 500;
                                    color: var(--ink);
                                "
                            >
                                {{ $submission->submitted_at?->format('M d, Y') ?? '—' }}
                            </p>
                        </div>

                        @if ($submission->research_field)
                            <div class="meta-row">
                                <p class="meta-label">Research Field</p>
                                <p
                                    style="
                                        font-size: 0.82rem;
                                        font-weight: 500;
                                        color: var(--ink);
                                    "
                                >
                                    {{ $submission->research_field }}
                                </p>
                            </div>
                        @endif

                        @if ($submission->keywords)
                            <div class="meta-row">
                                <p class="meta-label">Keywords</p>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    @foreach (explode(',', $submission->keywords) as $kw)
                                        <span class="keyword-chip">
                                            {{ trim($kw) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($submission->file_name)
                            <div class="meta-row">
                                <p class="meta-label">Manuscript File</p>
                                <div class="file-block">
                                    <div class="file-icon-box">
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
                                    <div class="overflow-hidden">
                                        <p class="file-name truncate">
                                            {{ $submission->file_name }}
                                        </p>
                                        <p class="file-sub">Document</p>
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
