@extends('layouts.app')

@section('title', 'Manage Appeals')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-dark: #1a4d46;
            --teal-light: #e8f4f2;
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
            --muted: #64748b;
            --white: #ffffff;
            --red: #dc2626;
            --red-light: #fef2f2;
            --amber: #d97706;
            --amber-light: #fffbeb;
            --emerald: #059669;
            --emerald-light: #ecfdf5;
        }

        * {
            box-sizing: border-box;
        }

        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
        }
        .aw-bg {
            background-color: var(--cream);
            background-image:
                radial-gradient(
                    ellipse 80% 50% at 50% -10%,
                    rgba(45, 129, 118, 0.08) 0%,
                    transparent 70%
                ),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.5'/%3E%3C/svg%3E");
        }
        .font-mono {
            font-family: 'DM Mono', monospace;
        }

        /* ── Hero Header ── */
        .hero-header {
            position: relative;
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 32px;
        }
        .hero-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .hero-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .hero-eyebrow::before {
            content: '';
            width: 24px;
            height: 1px;
            background: var(--teal);
        }
        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.15;
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-size: 0.98rem;
            color: var(--ink-soft);
            margin-top: 8px;
        }
        .date-pill {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--ink-soft);
            background: var(--parchment);
            border: 1px solid var(--border);
            padding: 6px 16px;
            border-radius: 20px;
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
        .fu {
            animation: fadeUp 0.4s ease both;
        }
        .fu1 {
            animation: fadeUp 0.4s 0.07s ease both;
        }
        .fu2 {
            animation: fadeUp 0.4s 0.14s ease both;
        }

        /* ── Section label ── */
        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Appeal card ── */
        .appeal-card {
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
            transition:
                border-color 0.18s,
                box-shadow 0.18s,
                transform 0.15s;
            position: relative;
            overflow: hidden;
        }
        .appeal-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            border-radius: 14px 0 0 14px;
        }
        .appeal-card.pending::before {
            background: var(--amber);
        }
        .appeal-card.approved::before {
            background: var(--emerald);
        }
        .appeal-card.rejected::before {
            background: var(--red);
        }

        .appeal-card:hover {
            border-color: var(--teal);
            box-shadow: 0 6px 24px rgba(45, 129, 118, 0.12);
            transform: translateY(-2px);
        }

        /* ── Status badge ── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .status-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .s-pending {
            background: var(--amber-light);
            border-color: #fde68a;
            color: #92400e;
        }
        .s-pending .status-dot {
            background: var(--amber);
        }
        .s-approved {
            background: var(--emerald-light);
            border-color: #a7f3d0;
            color: #065f46;
        }
        .s-approved .status-dot {
            background: var(--emerald);
        }
        .s-rejected {
            background: var(--red-light);
            border-color: #fecaca;
            color: #991b1b;
        }
        .s-rejected .status-dot {
            background: var(--red);
        }

        /* ── Submission title ── */
        .ms-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            font-style: italic;
            color: var(--ink);
            line-height: 1.4;
        }

        /* ── Reason preview ── */
        .reason-preview {
            background: var(--parchment);
            border: 1px solid var(--border);
            border-left: 3px solid var(--amber);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 12px;
            color: var(--ink-soft);
            line-height: 1.65;
            /* overflow fix */
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* ── Review button ── */
        .btn-review {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: var(--teal);
            color: #fff;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-decoration: none;
            transition:
                transform 0.14s,
                box-shadow 0.14s,
                filter 0.14s;
            box-shadow: 0 2px 8px rgba(45, 129, 118, 0.25);
            white-space: nowrap;
        }
        .btn-review:hover {
            transform: translateY(-1px);
            filter: brightness(1.08);
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.3);
        }

        /* ── Empty state ── */
        .empty-state {
            padding: 80px 24px;
            text-align: center;
        }
        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .empty-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }

        /* ── Meta label ── */
        .meta-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 3px;
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-6xl mx-auto px-6 pb-16">
        {{-- ── Hero Header ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Editor-in-Chief</p>
                    <h1 class="hero-title">
                        Manuscript
                        <em>Appeals</em>
                    </h1>
                    <p class="hero-sub">
                        Review and respond to author appeals on rejected
                        manuscripts
                    </p>
                </div>
                <div
                    class="flex items-center gap-3 self-start md:self-auto shrink-0"
                >
                    <span class="date-pill hidden sm:inline-block">
                        {{ now()->format('D, M j Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Appeals List ── --}}
        <div
            class="fu1"
            style="display: flex; flex-direction: column; gap: 14px"
        >
            @forelse ($appeals as $appeal)
                @php
                    $cardClass = $appeal->isPending() ? 'pending' : ($appeal->isApproved() ? 'approved' : 'rejected');
                    $sc = $appeal->isPending() ? 's-pending' : ($appeal->isApproved() ? 's-approved' : 's-rejected');
                    $sl = $appeal->isPending() ? 'Pending Review' : ($appeal->isApproved() ? 'Approved' : 'Rejected');
                @endphp

                <div class="appeal-card {{ $cardClass }}">
                    <div
                        style="display: flex; flex-direction: column; gap: 14px"
                    >
                        {{-- Top row: title + badge + button --}}
                        <div
                            style="
                                display: flex;
                                align-items: flex-start;
                                justify-content: space-between;
                                gap: 16px;
                                flex-wrap: wrap;
                            "
                        >
                            <div style="flex: 1; min-width: 0">
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 10px;
                                        flex-wrap: wrap;
                                        margin-bottom: 6px;
                                    "
                                >
                                    <p class="ms-title">
                                        {{ $appeal->submission->title }}
                                    </p>
                                    <span class="status-badge {{ $sc }}">
                                        <span class="status-dot"></span>
                                        {{ $sl }}
                                    </span>
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        flex-wrap: wrap;
                                        gap: 16px;
                                        font-size: 12px;
                                        color: var(--ink-soft);
                                    "
                                >
                                    <span>
                                        By
                                        <strong style="color: var(--ink)">
                                            {{ $appeal->author->name }}
                                        </strong>
                                    </span>
                                    <span
                                        class="font-mono"
                                        style="color: var(--teal)"
                                    >
                                        #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="font-mono">
                                        {{ $appeal->created_at->format('M d, Y · g:i A') }}
                                    </span>
                                </div>
                            </div>
                            <a
                                href="{{ route('appeals.show', $appeal) }}"
                                class="btn-review"
                            >
                                {{ $appeal->isPending() ? 'Review' : 'View' }}
                                <svg
                                    width="11"
                                    height="11"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </a>
                        </div>

                        {{-- Reason preview --}}
                        <div>
                            <p class="meta-label" style="margin-bottom: 6px">
                                Appeal Reason
                            </p>
                            <div class="reason-preview">
                                {{ $appeal->reason }}
                            </div>
                        </div>

                        {{-- Reviewed info --}}
                        @if ($appeal->reviewed_at)
                            <div
                                style="
                                    padding-top: 12px;
                                    border-top: 1px solid var(--border);
                                    font-size: 11px;
                                    color: var(--muted);
                                "
                                class="font-mono"
                            >
                                Reviewed on
                                {{ $appeal->reviewed_at->format('M d, Y') }}
                                @if ($appeal->reviewedBy)
                                    · by
                                    <strong style="color: var(--ink)">
                                        {{ $appeal->reviewedBy->name }}
                                    </strong>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div
                    style="
                        background: var(--white);
                        border: 1px solid var(--border-dk);
                        border-radius: 14px;
                        box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
                    "
                >
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg
                                width="28"
                                height="28"
                                fill="none"
                                stroke="#c9b99a"
                                stroke-width="1.5"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <p class="empty-label">No appeals to review</p>
                        <p
                            style="
                                font-size: 0.88rem;
                                color: #b5a595;
                                margin-top: 6px;
                            "
                        >
                            Author appeals will appear here once submitted.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($appeals->hasPages())
            <div class="fu2 mt-6">{{ $appeals->links() }}</div>
        @endif
    </div>
@endsection
