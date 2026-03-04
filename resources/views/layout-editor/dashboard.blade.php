@extends('layouts.app')

@section('title', 'Layout Editor Dashboard')

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

        /* ── Hero ── */
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
        .sv-gold {
            color: var(--gold-dk);
        }
        .sv-ink {
            color: var(--ink-mid);
        }
        .al-teal {
            background: var(--teal);
        }
        .al-gold {
            background: var(--gold);
        }
        .al-ink {
            background: var(--ink-mid);
        }

        /* ── Section label ── */
        .section-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Two-column layout ── */
        .main-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        @media (max-width: 800px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── Quick Actions card ── */
        .action-card {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 8px 6px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        .action-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 14px;
            border-radius: 9px;
            text-decoration: none;
            transition: background 0.13s;
            margin: 2px 0;
        }
        .action-row:hover {
            background: var(--teal-lt);
        }
        .action-row:hover .action-name {
            color: var(--teal);
        }
        .action-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .action-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--ink);
            transition: color 0.13s;
        }
        .action-sub {
            font-size: 0.72rem;
            color: var(--ink-soft);
            margin-top: 2px;
        }

        /* ── Table card ── */
        .ms-table-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
        }
        .ms-table-head {
            padding: 16px 24px 14px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ms-table-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
        }
        .ms-table-head-eyebrow {
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 2px;
        }
        .ms-table-head-badge {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 20px;
            background: var(--teal-lt);
            border: 1px solid rgba(45, 129, 118, 0.3);
            color: var(--teal-dk);
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
            padding: 11px 22px;
            font-size: 0.66rem;
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
            padding: 15px 22px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: middle;
        }
        table.mst tbody tr:last-child td {
            border-bottom: none;
        }
        table.mst tbody tr {
            transition: background 0.1s;
        }
        table.mst tbody tr:hover td {
            background: var(--teal-lt);
        }
        table.mst tbody tr:hover .ms-row-title {
            color: var(--teal);
        }

        .ms-row-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.92rem;
            font-weight: 700;
            font-style: italic;
            color: var(--ink);
            transition: color 0.12s;
            line-height: 1.4;
        }
        .ms-author {
            font-size: 0.78rem;
            color: var(--ink-soft);
            margin-top: 2px;
        }

        /* Status badges */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 0.68rem;
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
        .sbadge.for_layout {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.3);
            color: var(--teal-dk);
        }
        .sbadge.for_layout .dot {
            background: var(--teal);
        }
        .sbadge.in_progress {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.in_progress .dot {
            background: var(--gold);
        }
        .sbadge.for_review {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #9a3412;
        }
        .sbadge.for_review .dot {
            background: #f97316;
        }
        .sbadge.published {
            background: #f0fdf4;
            border-color: #86efac;
            color: var(--teal-dk);
        }
        .sbadge.published .dot {
            background: var(--teal);
        }
        .sbadge.default {
            background: var(--parchment);
            border-color: var(--border);
            color: var(--ink-soft);
        }
        .sbadge.default .dot {
            background: var(--border-dk);
        }

        /* Buttons */
        .btn-open {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 13px;
            border-radius: 5px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--teal);
            text-decoration: none;
            border: 1.5px solid rgba(45, 129, 118, 0.3);
            background: var(--teal-lt);
            transition: all 0.15s;
        }
        .btn-open:hover {
            background: rgba(45, 129, 118, 0.2);
            border-color: var(--teal);
        }

        /* Empty state */
        .empty-state {
            padding: 70px 24px;
            text-align: center;
        }
        .empty-state-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }
        .empty-state-label {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--ink);
        }
        .empty-state-sub {
            font-size: 0.8rem;
            color: #b5a595;
            margin-top: 5px;
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

        /* Animations */
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
                    <p class="hero-eyebrow">Layout Editor Dashboard</p>
                    <h1 class="hero-title">
                        Welcome,
                        <em>{{ auth()->user()->name }}</em>
                    </h1>
                    <p class="hero-sub">
                        Manage layouts, format submissions, and prepare
                        publications
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

        {{-- ── Stats ── --}}
        <div class="stat-grid fu1 mb-10">
            <div class="stat-cell">
                <p class="stat-lbl">For Layout</p>
                <p class="stat-val sv-teal">—</p>
                <p class="stat-sub">Pending formatting</p>
                <div class="accent-line al-teal"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">In Progress</p>
                <p class="stat-val sv-gold">—</p>
                <p class="stat-sub">Currently editing</p>
                <div class="accent-line al-gold"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">For Review</p>
                <p class="stat-val sv-ink">—</p>
                <p class="stat-sub">Awaiting approval</p>
                <div class="accent-line al-ink"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">Published</p>
                <p class="stat-val sv-teal">—</p>
                <p class="stat-sub">Completed papers</p>
                <div class="accent-line al-teal"></div>
            </div>
        </div>

        {{-- ── Main Two-Column Grid ── --}}
        <div class="main-grid fu2">
            {{-- Quick Actions --}}
            <div>
                <div class="section-label">Quick Actions</div>
                <div class="action-card">
                    <a href="#" class="action-row">
                        <div class="flex items-center gap-3">
                            <div
                                class="action-icon"
                                style="background: var(--teal-lt)"
                            >
                                <svg
                                    width="18"
                                    height="18"
                                    fill="none"
                                    stroke="var(--teal)"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 6h16M4 10h16M4 14h10"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="action-name">Assigned Papers</p>
                                <p class="action-sub">Papers pending layout</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="action-row">
                        <div class="flex items-center gap-3">
                            <div
                                class="action-icon"
                                style="background: #fdf8ec"
                            >
                                <svg
                                    width="18"
                                    height="18"
                                    fill="none"
                                    stroke="var(--gold-dk)"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="action-name">Submit Layout</p>
                                <p class="action-sub">Upload formatted file</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="action-row">
                        <div class="flex items-center gap-3">
                            <div
                                class="action-icon"
                                style="background: var(--parchment)"
                            >
                                <svg
                                    width="18"
                                    height="18"
                                    fill="none"
                                    stroke="var(--ink-soft)"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="action-name">Layout History</p>
                                <p class="action-sub">Previously completed</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Assigned Papers Table --}}
            <div>
                <div class="section-label">Assigned Papers</div>
                <div class="ms-table-wrap">
                    <div class="ms-table-head">
                        <div>
                            <p class="ms-table-head-eyebrow">Your Workload</p>
                            <span class="ms-table-head-title">
                                Papers Requiring Layout
                            </span>
                        </div>
                        <span class="ms-table-head-badge">Active</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="mst">
                            <thead>
                                <tr>
                                    <th>Title &amp; Author</th>
                                    <th>Status</th>
                                    <th style="text-align: right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @forelse ($papers as $paper) --}}
                                {{-- <tr> --}}
                                {{-- <td> --}}
                                {{-- <p class="ms-row-title">{{ $paper->title }}</p> --}}
                                {{-- <p class="ms-author">{{ $paper->author }}</p> --}}
                                {{-- </td> --}}
                                {{-- <td> --}}
                                {{-- <span class="sbadge {{ $paper->layout_status ?? 'default' }}"> --}}
                                {{-- <span class="dot"></span> --}}
                                {{-- {{ ucfirst(str_replace('_', ' ', $paper->layout_status ?? 'N/A')) }} --}}
                                {{-- </span> --}}
                                {{-- </td> --}}
                                {{-- <td style="text-align:right"> --}}
                                {{-- <a href="#" class="btn-open"> --}}
                                {{-- Open → --}}
                                {{-- </a> --}}
                                {{-- </td> --}}
                                {{-- </tr> --}}
                                {{-- @empty --}}
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <svg
                                                    class="w-7 h-7"
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
                                                No papers assigned yet
                                            </p>
                                            <p class="empty-state-sub">
                                                Papers assigned to you will
                                                appear here.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                {{-- @endforelse --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer">
                        <span
                            style="font-size: 0.76rem; color: var(--ink-soft)"
                        >
                            0 records
                        </span>
                        <span class="table-footer-brand">
                            BatStateU · BIRJISE
                        </span>
                    </div>
                </div>
            </div>
        </div>
        {{-- /main grid --}}
    </div>
@endsection
