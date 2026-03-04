@extends('layouts.app')

@section('title', 'Editor Dashboard')

@push('styles')
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --teal-lt: #e8f4f2;
            --gold: #c9a84c;
            --gold-lt: #e8d49a;
            --gold-dk: #8a6e28;
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
        }

        * {
            box-sizing: border-box;
        }

        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            font-size: 16px;
        }
        .serif {
            font-family: 'Libre Baskerville', serif;
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

        /* ── Hero Header ── */
        .hero-header {
            position: relative;
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 36px;
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
            font-weight: 400;
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

        /* ── Stat Grid ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        @media (max-width: 800px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }
        }
        .stat-cell {
            padding: 24px 22px 18px;
            border-right: 1px solid var(--border);
            position: relative;
            transition: background 0.18s;
            cursor: default;
        }
        .stat-cell:last-child {
            border-right: none;
        }
        .stat-cell:hover {
            background: #fff;
        }
        .stat-lbl {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 10px;
        }
        .stat-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.6rem;
            font-weight: 700;
            line-height: 1;
        }
        .stat-sub {
            font-size: 0.72rem;
            color: var(--ink-soft);
            margin-top: 8px;
        }
        .stat-cell .accent-line {
            position: absolute;
            bottom: 0;
            left: 22px;
            height: 2px;
            width: 0;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        .stat-cell:hover .accent-line {
            width: 36px;
        }

        .sv-teal {
            color: var(--teal);
        }
        .sv-blue {
            color: #2563eb;
        }
        .sv-amber {
            color: #a07830;
        }
        .sv-orange {
            color: #c2410c;
        }
        .al-teal {
            background: var(--teal);
        }
        .al-blue {
            background: #2563eb;
        }
        .al-amber {
            background: #a07830;
        }
        .al-orange {
            background: #c2410c;
        }

        /* ── Alert Strip ── */
        .alert-strip {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid;
            display: flex;
            align-items: stretch;
        }
        .alert-strip-accent {
            width: 5px;
            flex-shrink: 0;
        }
        .alert-strip-body {
            flex: 1;
            padding: 16px 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .alert-tag {
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .alert-desc {
            font-size: 0.9rem;
            font-weight: 400;
        }
        .btn-alert-action {
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 7px 16px;
            border-radius: 5px;
            text-decoration: none;
            border: 1.5px solid;
            transition: all 0.15s;
            white-space: nowrap;
        }

        /* ── Table ── */
        .ms-table-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
        }
        .ms-table-head {
            padding: 16px 28px 14px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ms-table-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ink);
        }
        .ms-table-head-count {
            font-size: 0.76rem;
            font-weight: 600;
            color: var(--ink-soft);
            background: var(--cream);
            border: 1px solid var(--border);
            padding: 4px 12px;
            border-radius: 20px;
        }
        .btn-view-all {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 7px 16px;
            border-radius: 6px;
            background: var(--ink);
            color: #fff;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s;
        }
        .btn-view-all:hover {
            background: var(--teal);
            transform: translateY(-1px);
        }

        table.mst {
            width: 100%;
            border-collapse: collapse;
        }
        table.mst thead tr {
            background: var(--parchment);
            border-bottom: 1.5px solid var(--border-dk);
        }
        table.mst th {
            padding: 12px 24px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-align: left;
        }
        table.mst th:last-child {
            text-align: right;
        }
        table.mst td {
            padding: 16px 24px;
            font-size: 0.92rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: middle;
        }
        table.mst tbody tr:last-child td {
            border-bottom: none;
        }
        table.mst tbody tr {
            transition: background 0.1s;
            cursor: pointer;
        }
        table.mst tbody tr:hover td {
            background: var(--teal-lt);
        }
        table.mst tbody tr:hover .ms-row-title {
            color: var(--teal);
        }

        .ms-row-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.95rem;
            font-weight: 700;
            font-style: italic;
            color: var(--ink);
            line-height: 1.4;
            transition: color 0.12s;
        }
        .ms-author {
            font-size: 0.78rem;
            color: var(--ink-soft);
            margin-top: 3px;
        }

        /* Status badges */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
            white-space: nowrap;
        }
        .sbadge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .sbadge.submitted {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.submitted .dot {
            background: var(--teal);
        }
        .sbadge.under_review {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.under_review .dot {
            background: var(--gold);
        }
        .sbadge.revision {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #9a3412;
        }
        .sbadge.revision .dot {
            background: #f97316;
        }
        .sbadge.accepted {
            background: #f0fdf4;
            border-color: #86efac;
            color: var(--teal-dk);
        }
        .sbadge.accepted .dot {
            background: var(--teal);
        }
        .sbadge.rejected {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }
        .sbadge.rejected .dot {
            background: #c0392b;
        }
        .sbadge.default {
            background: var(--parchment);
            border-color: var(--border);
            color: var(--ink-soft);
        }
        .sbadge.default .dot {
            background: var(--border-dk);
        }

        /* Manage button */
        .btn-manage {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--teal);
            color: #fff;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 3px 10px rgba(45, 129, 118, 0.22);
        }
        .btn-manage:hover {
            background: var(--teal-dk);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(45, 129, 118, 0.3);
        }

        /* Empty state */
        .empty-state {
            padding: 80px 24px;
            text-align: center;
        }
        .empty-state-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .empty-state-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }

        /* Table footer */
        .table-footer {
            padding: 12px 24px;
            background: var(--parchment);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .table-footer-brand {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }

        /* ── Animations ── */
        .fu {
            animation: fu 0.45s ease both;
        }
        .fu1 {
            animation: fu 0.45s 0.08s ease both;
        }
        .fu2 {
            animation: fu 0.45s 0.16s ease both;
        }
        .fu3 {
            animation: fu 0.45s 0.24s ease both;
        }
        .fu4 {
            animation: fu 0.45s 0.32s ease both;
        }
        @keyframes fu {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-6xl mx-auto px-4">
        {{-- ── Hero ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Editor Dashboard</p>
                    <h1 class="hero-title">
                        <em>Editorial</em>
                        Queue
                    </h1>
                    <p class="hero-sub">
                        Review and manage submissions assigned to you
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

        {{-- ── Stat Grid ── --}}
        <div class="stat-grid fu1 mb-10">
            <div class="stat-cell">
                <p class="stat-lbl">Total</p>
                <p class="stat-val sv-teal">
                    {{ sprintf('%02d', $stats['total']) }}
                </p>
                <p class="stat-sub">All submissions</p>
                <div class="accent-line al-teal"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">New</p>
                <p class="stat-val sv-blue">
                    {{ sprintf('%02d', $stats['submitted']) }}
                </p>
                <p class="stat-sub">Awaiting distribution</p>
                <div class="accent-line al-blue"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">Under Review</p>
                <p class="stat-val sv-amber">
                    {{ sprintf('%02d', $stats['under_review']) }}
                </p>
                <p class="stat-sub">With reviewers</p>
                <div class="accent-line al-amber"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">Revisions</p>
                <p class="stat-val sv-orange">
                    {{ sprintf('%02d', $stats['revision_under_review']) }}
                </p>
                <p class="stat-sub">Awaiting re-review</p>
                <div class="accent-line al-orange"></div>
            </div>
        </div>

        {{-- ── Revision Alert ── --}}
        @if ($stats['revision_under_review'] > 0)
            <div class="fu2 mb-4">
                <div
                    class="alert-strip"
                    style="border-color: #fed7aa; background: #fffdf9"
                >
                    <div
                        class="alert-strip-accent"
                        style="background: #f97316"
                    ></div>
                    <div class="alert-strip-body">
                        <div class="flex items-center gap-3">
                            <div
                                style="
                                    width: 38px;
                                    height: 38px;
                                    border-radius: 8px;
                                    background: #fff7ed;
                                    color: #ea580c;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                "
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="alert-tag" style="color: #9a3412">
                                    Revision Reviews Pending
                                </p>
                                <p class="alert-desc" style="color: #7c2d12">
                                    {{ $stats['revision_under_review'] }}
                                    {{ $stats['revision_under_review'] === 1 ? 'manuscript' : 'manuscripts' }}
                                    awaiting your final decision
                                </p>
                            </div>
                        </div>
                        @if ($submissions->first())
                            <a
                                href="{{ route('editor.submission.show', $submissions->first()) }}"
                                class="btn-alert-action"
                                style="color: #ea580c; border-color: #fed7aa"
                            >
                                Review Now →
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Table ── --}}
        <div class="ms-table-wrap fu3 mb-12">
            <div class="ms-table-head">
                <div>
                    <p
                        style="
                            font-size: 0.68rem;
                            font-weight: 700;
                            letter-spacing: 0.1em;
                            text-transform: uppercase;
                            color: var(--ink-soft);
                            margin-bottom: 2px;
                        "
                    >
                        Submissions
                    </p>
                    <span class="ms-table-head-title">Recent Submissions</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="ms-table-head-count">
                        {{ $submissions->total() ?? $submissions->count() }}
                        records
                    </span>
                    <a
                        href="{{ route('editor.submissions') }}"
                        class="btn-view-all"
                    >
                        View All →
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="mst">
                    <thead>
                        <tr>
                            <th style="width: 45%">Title &amp; Author</th>
                            <th>Status</th>
                            <th style="text-align: right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $s)
                            <tr
                                onclick="
                                    window.location =
                                        '{{ route('editor.submission.show', $s) }}'
                                "
                            >
                                <td>
                                    <p class="ms-row-title">
                                        {{ Str::limit($s->title, 60) }}
                                    </p>
                                    <p class="ms-author">
                                        {{ $s->author->name ?? '—' }}
                                    </p>
                                </td>
                                <td>
                                    @php
                                        $cls = match ($s->status) {
                                            'submitted' => 'submitted',
                                            'under_review' => 'under_review',
                                            'accepted' => 'accepted',
                                            'rejected' => 'rejected',
                                            'revision',
                                            'revisions_requested',
                                            'revision_under_review'
                                                => 'revision',
                                            default => 'default',
                                        };
                                    @endphp

                                    <span class="sbadge {{ $cls }}">
                                        <span class="dot"></span>
                                        {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                                    </span>
                                </td>
                                <td style="text-align: right">
                                    <a
                                        href="{{ route('editor.submission.show', $s) }}"
                                        onclick="event.stopPropagation()"
                                        class="btn-manage"
                                    >
                                        <svg
                                            class="w-3 h-3"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 5l7 7-7 7"
                                            />
                                        </svg>
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <svg
                                                class="w-8 h-8"
                                                fill="none"
                                                stroke="#c9b99a"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </div>
                                        <p class="empty-state-label">
                                            No submissions yet
                                        </p>
                                        <p
                                            style="
                                                font-size: 0.88rem;
                                                color: #b5a595;
                                                margin-top: 6px;
                                            "
                                        >
                                            Submissions will appear here once
                                            received.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="text-sm text-[#b0aaa0]">
                    {{ $submissions->links() }}
                </div>
                <span class="table-footer-brand">BatStateU · BIRJISE</span>
            </div>
        </div>
    </div>
@endsection
