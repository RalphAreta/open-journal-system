@php
    use App\Models\Submission;
@endphp

@extends('layouts.app')

@section('title', 'Chief Editor Dashboard')

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
            --red: #c0392b;
            --red-lt: #fef2f2;
            --blue: #2563eb;
            --blue-lt: #eff6ff;
            --emerald: #1a4d46;
            --emerald-lt: #f0fdf4;
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
            padding: 32px 0 24px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 28px;
        }
        @media (min-width: 640px) {
            .hero-header {
                padding: 44px 0 32px;
                margin-bottom: 36px;
            }
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
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.15;
        }
        @media (min-width: 640px) {
            .hero-title {
                font-size: 2.8rem;
            }
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-size: 0.88rem;
            font-weight: 400;
            color: var(--ink-soft);
            margin-top: 8px;
        }
        @media (min-width: 640px) {
            .hero-sub {
                font-size: 0.98rem;
            }
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
            grid-template-columns: repeat(2, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        @media (min-width: 800px) {
            .stat-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .stat-cell {
            padding: 18px 16px 14px;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            position: relative;
            transition: background 0.18s;
            cursor: default;
        }
        @media (min-width: 640px) {
            .stat-cell {
                padding: 24px 22px 18px;
            }
        }
        /* Remove right border on every 2nd cell in 2-col layout */
        .stat-cell:nth-child(2n) {
            border-right: none;
        }
        /* Remove bottom border on last row in 2-col */
        .stat-cell:nth-child(3),
        .stat-cell:nth-child(4) {
            border-bottom: none;
        }
        @media (min-width: 800px) {
            /* Reset for 4-col layout */
            .stat-cell {
                border-bottom: none;
            }
            .stat-cell:nth-child(2n) {
                border-right: 1px solid var(--border);
            }
            .stat-cell:last-child {
                border-right: none;
            }
        }
        .stat-cell:hover {
            background: #fff;
        }

        .stat-lbl {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 8px;
        }
        @media (min-width: 640px) {
            .stat-lbl {
                font-size: 0.68rem;
                margin-bottom: 10px;
            }
        }
        .stat-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }
        @media (min-width: 640px) {
            .stat-val {
                font-size: 2.6rem;
            }
        }
        .stat-sub {
            font-size: 0.68rem;
            color: var(--ink-soft);
            margin-top: 6px;
        }
        @media (min-width: 640px) {
            .stat-sub {
                font-size: 0.72rem;
                margin-top: 8px;
            }
        }
        .stat-cell .accent-line {
            position: absolute;
            bottom: 0;
            left: 16px;
            height: 2px;
            width: 0;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        @media (min-width: 640px) {
            .stat-cell .accent-line {
                left: 22px;
            }
        }
        .stat-cell:hover .accent-line {
            width: 36px;
        }
        .sv-teal {
            color: var(--teal);
        }
        .sv-red {
            color: var(--red);
        }
        .sv-blue {
            color: var(--blue);
        }
        .sv-emerald {
            color: var(--emerald);
        }
        .al-teal {
            background: var(--teal);
        }
        .al-red {
            background: var(--red);
        }
        .al-blue {
            background: var(--blue);
        }
        .al-emerald {
            background: var(--emerald);
        }

        /* ── Tab Bar ── */
        .tab-bar {
            display: flex;
            align-items: flex-end;
            gap: 0;
            border-bottom: 1.5px solid var(--border-dk);
            margin-bottom: 20px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .tab-bar::-webkit-scrollbar {
            display: none;
        }
        .tab-btn {
            position: relative;
            padding: 10px 14px 12px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.62rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--ink-soft);
            background: none;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
            transition: color 0.18s;
        }
        @media (min-width: 640px) {
            .tab-btn {
                padding: 12px 20px 14px;
                font-size: 0.68rem;
                letter-spacing: 0.12em;
            }
        }
        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: -1.5px;
            left: 0;
            right: 0;
            height: 2.5px;
            border-radius: 2px;
            background: var(--teal);
            transform: scaleX(0);
            transition: transform 0.22s ease;
        }
        .tab-btn.active {
            color: var(--ink);
        }
        .tab-btn.active::after {
            transform: scaleX(1);
        }
        .tab-btn:hover:not(.active) {
            color: var(--ink-mid);
        }

        .tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            font-size: 0.58rem;
            font-weight: 800;
            margin-left: 5px;
            vertical-align: middle;
        }
        .tab-count.red {
            background: var(--red-lt);
            color: var(--red);
        }
        .tab-count.slate {
            background: var(--parchment);
            color: var(--ink-soft);
        }
        .tab-count.amber {
            background: #fdf8ec;
            color: var(--gold-dk);
        }

        .tab-panel {
            display: none;
        }
        .tab-panel.active {
            display: block;
        }

        /* ── Search & Filter ── */
        .search-wrap {
            position: relative;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 0 14px;
            transition:
                border-color 0.18s,
                box-shadow 0.18s;
            box-shadow: 0 1px 4px rgba(26, 18, 9, 0.05);
        }
        .search-wrap:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
        }
        .search-wrap svg {
            color: var(--ink-soft);
            flex-shrink: 0;
        }
        .search-wrap input {
            flex: 1;
            padding: 10px 10px;
            border: none;
            background: transparent;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.88rem;
            color: var(--ink);
            outline: none;
        }
        @media (min-width: 640px) {
            .search-wrap input {
                padding: 12px 10px;
                font-size: 0.92rem;
            }
        }
        .search-wrap input::placeholder {
            color: #b5a595;
        }

        .filter-select {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ink-soft);
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            outline: none;
            transition: border-color 0.18s;
            box-shadow: 0 1px 4px rgba(26, 18, 9, 0.05);
            width: 100%;
        }
        @media (min-width: 640px) {
            .filter-select {
                padding: 12px 14px;
                width: auto;
            }
        }
        .filter-select:focus {
            border-color: var(--teal);
        }

        /* ── Tables ── */
        .ms-table-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
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
            padding: 10px 14px;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-align: left;
            white-space: nowrap;
        }
        @media (min-width: 640px) {
            table.mst th {
                padding: 12px 20px;
                font-size: 0.66rem;
            }
        }
        table.mst th.sortable {
            cursor: pointer;
        }
        table.mst th.sortable:hover {
            color: var(--teal);
        }
        table.mst th:last-child {
            text-align: right;
        }
        .sort-icon {
            opacity: 0.4;
            margin-left: 3px;
            font-size: 10px;
            transition: opacity 0.15s;
        }
        table.mst th.sortable:hover .sort-icon {
            opacity: 1;
        }

        table.mst td {
            padding: 12px 14px;
            font-size: 0.85rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: middle;
        }
        @media (min-width: 640px) {
            table.mst td {
                padding: 15px 20px;
                font-size: 0.9rem;
            }
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
        table.mst tbody tr:hover .row-title {
            color: var(--teal);
        }

        /* Hide less-critical columns on small screens */
        @media (max-width: 639px) {
            .col-hide-sm {
                display: none;
            }
        }

        .row-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.82rem;
            font-weight: 700;
            font-style: italic;
            color: var(--ink);
            transition: color 0.12s;
            line-height: 1.4;
        }
        @media (min-width: 640px) {
            .row-title {
                font-size: 0.88rem;
            }
        }
        .row-ref {
            font-size: 0.68rem;
            font-weight: 700;
            color: #c9b99a;
            letter-spacing: 0.06em;
            font-family: 'Source Sans 3', monospace;
        }
        .row-author {
            font-size: 0.78rem;
            color: var(--ink-soft);
        }
        .row-email {
            font-size: 0.7rem;
            color: #c9b99a;
            margin-top: 1px;
        }

        .field-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 8px;
            border-radius: 20px;
            background: var(--teal-lt);
            border: 1px solid rgba(45, 129, 118, 0.25);
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--teal-dk);
        }
        @media (min-width: 640px) {
            .field-badge {
                padding: 3px 10px;
                font-size: 0.68rem;
            }
        }
        .field-badge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--teal);
            flex-shrink: 0;
        }

        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
            white-space: nowrap;
        }
        @media (min-width: 640px) {
            .sbadge {
                gap: 6px;
                padding: 4px 11px;
                font-size: 0.68rem;
            }
        }
        .sbadge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .sbadge.accepted {
            background: var(--emerald-lt);
            border-color: #86efac;
            color: var(--emerald);
        }
        .sbadge.accepted .dot {
            background: var(--teal);
        }
        .sbadge.rejected {
            background: var(--red-lt);
            border-color: #fecaca;
            color: var(--red);
        }
        .sbadge.rejected .dot {
            background: var(--red);
        }
        .sbadge.under_review {
            background: var(--blue-lt);
            border-color: #bfdbfe;
            color: var(--blue);
        }
        .sbadge.under_review .dot {
            background: var(--blue);
        }
        .sbadge.revisions {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.revisions .dot {
            background: var(--gold);
        }
        .sbadge.pending {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.pending .dot {
            background: var(--gold);
        }
        .sbadge.approved {
            background: var(--emerald-lt);
            border-color: #86efac;
            color: var(--emerald);
        }
        .sbadge.approved .dot {
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

        .btn-assign {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background: var(--teal);
            color: #fff;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 3px 10px rgba(45, 129, 118, 0.22);
            white-space: nowrap;
        }
        @media (min-width: 640px) {
            .btn-assign {
                padding: 7px 14px;
                font-size: 0.72rem;
                letter-spacing: 0.08em;
                gap: 5px;
            }
        }
        .btn-assign:hover {
            background: var(--teal-dk);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(45, 129, 118, 0.3);
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--teal);
            text-decoration: none;
            transition: color 0.15s;
        }
        .btn-view:hover {
            color: var(--teal-dk);
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--teal-lt);
            color: var(--teal);
            transition: background 0.15s;
            text-decoration: none;
        }
        .btn-icon:hover {
            background: rgba(45, 129, 118, 0.2);
        }
        .btn-icon.slate {
            background: var(--parchment);
            color: var(--ink-soft);
        }
        .btn-icon.slate:hover {
            background: var(--border);
        }

        .table-footer {
            padding: 10px 14px;
            background: var(--parchment);
            border-top: 1px solid var(--border);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            font-size: 0.74rem;
            color: var(--ink-soft);
        }
        @media (min-width: 640px) {
            .table-footer {
                padding: 12px 20px;
            }
        }

        .section-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            margin-top: 24px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .empty-state {
            padding: 50px 20px;
            text-align: center;
        }
        @media (min-width: 640px) {
            .empty-state {
                padding: 70px 24px;
            }
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
    <div class="aw aw-bg max-w-7xl mx-auto px-4 sm:px-6">
        {{-- ── Hero ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Chief Editor Dashboard</p>
                    <h1 class="hero-title">
                        <em>Editorial</em>
                        Command
                    </h1>
                    <p class="hero-sub">
                        Manage submissions, assign editors, and review appeals
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
        <div class="stat-grid fu1 mb-8 sm:mb-10">
            <div class="stat-cell">
                <p class="stat-lbl">Total Submissions</p>
                <p class="stat-val sv-teal">
                    {{ sprintf('%02d', $stats['total_submissions']) }}
                </p>
                <p class="stat-sub">All manuscripts</p>
                <div class="accent-line al-teal"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">Pending Assignment</p>
                <p class="stat-val sv-red">
                    {{ sprintf('%02d', $stats['pending_assignments']) }}
                </p>
                <p class="stat-sub">Awaiting editor</p>
                <div class="accent-line al-red"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">Under Review</p>
                <p class="stat-val sv-blue">
                    {{ sprintf('%02d', $stats['under_review']) }}
                </p>
                <p class="stat-sub">With reviewers</p>
                <div class="accent-line al-blue"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">Completed</p>
                <p class="stat-val sv-emerald">
                    {{ sprintf('%02d', $stats['completed']) }}
                </p>
                <p class="stat-sub">Accepted or rejected</p>
                <div class="accent-line al-emerald"></div>
            </div>
        </div>

        {{-- ── Tabbed Section ── --}}
        <div class="fu2 mb-12">
            {{-- Tab Bar --}}
            <div class="tab-bar">
                <button
                    class="tab-btn active"
                    onclick="switchTab('pending', this)"
                >
                    Pending Assignment
                    <span class="tab-count red">
                        {{ $stats['pending_assignments'] }}
                    </span>
                </button>
                <button class="tab-btn" onclick="switchTab('assigned', this)">
                    Assigned
                    <span class="tab-count slate">
                        {{ $assignedSubmissions->total() }}
                    </span>
                </button>
                <button class="tab-btn" onclick="switchTab('appeals', this)">
                    Appeals
                    <span class="tab-count amber">
                        {{ $stats['pending_appeals'] }}
                    </span>
                </button>
            </div>

            {{-- ── PENDING TAB ── --}}
            <div id="tab-pending" class="tab-panel active">
                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                    <div class="search-wrap flex-1">
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" />
                        </svg>
                        <input
                            type="text"
                            id="pending-search"
                            placeholder="Search by title or author…"
                            oninput="filterTable('pending-tbody', this.value)"
                        />
                    </div>
                    <select
                        id="pending-field-filter"
                        class="filter-select"
                        onchange="
                            filterTable(
                                'pending-tbody',
                                document.getElementById('pending-search').value,
                            )
                        "
                    >
                        <option value="">All Research Fields</option>
                        @foreach ($pendingSubmissions->unique('research_field')->pluck('research_field')->filter() as $field)
                            <option value="{{ $field }}">{{ $field }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($pendingSubmissions->count() > 0)
                    <div class="ms-table-wrap">
                        <div class="overflow-x-auto">
                            <table class="mst">
                                <thead>
                                    <tr>
                                        <th
                                            class="sortable"
                                            onclick="
                                                sortTable(
                                                    'pending-tbody',
                                                    0,
                                                    this,
                                                )
                                            "
                                        >
                                            Title
                                            <span class="sort-icon">↕</span>
                                        </th>
                                        <th
                                            class="sortable col-hide-sm"
                                            onclick="
                                                sortTable(
                                                    'pending-tbody',
                                                    1,
                                                    this,
                                                )
                                            "
                                        >
                                            Author
                                            <span class="sort-icon">↕</span>
                                        </th>
                                        <th
                                            class="sortable col-hide-sm"
                                            onclick="
                                                sortTable(
                                                    'pending-tbody',
                                                    2,
                                                    this,
                                                )
                                            "
                                        >
                                            Research Field
                                            <span class="sort-icon">↕</span>
                                        </th>
                                        <th
                                            class="sortable col-hide-sm"
                                            onclick="
                                                sortTable(
                                                    'pending-tbody',
                                                    3,
                                                    this,
                                                )
                                            "
                                        >
                                            Submitted
                                            <span class="sort-icon">↕</span>
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="pending-tbody">
                                    @foreach ($pendingSubmissions as $s)
                                        <tr
                                            data-title="{{ strtolower($s->title) }}"
                                            data-author="{{ strtolower($s->author->name) }}"
                                            data-field="{{ strtolower($s->research_field ?? '') }}"
                                        >
                                            <td>
                                                <p class="row-title">
                                                    {{ Str::limit($s->title, 52) }}
                                                </p>
                                                {{-- Show author & date inline on mobile --}}
                                                <p class="row-author sm:hidden">
                                                    {{ $s->author->name }}
                                                </p>
                                                <p class="row-email sm:hidden">
                                                    {{ $s->submitted_at->format('M d, Y') }}
                                                </p>
                                            </td>
                                            <td class="col-hide-sm">
                                                <span class="row-author">
                                                    {{ $s->author->name }}
                                                </span>
                                            </td>
                                            <td class="col-hide-sm">
                                                <span class="field-badge">
                                                    <span class="dot"></span>
                                                    {{ $s->research_field ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="col-hide-sm">
                                                <span
                                                    style="
                                                        font-size: 0.76rem;
                                                        color: var(--ink-soft);
                                                    "
                                                >
                                                    {{ $s->submitted_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td style="text-align: right">
                                                <a
                                                    href="{{ route('chief-editor.submission.show', $s) }}"
                                                    class="btn-assign"
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
                                                    <span
                                                        class="hidden sm:inline"
                                                    >
                                                        Review &amp;
                                                    </span>
                                                    Assign
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-footer">
                            <span>
                                Showing
                                {{ $pendingSubmissions->firstItem() }}–{{ $pendingSubmissions->lastItem() }}
                                of {{ $pendingSubmissions->total() }}
                            </span>
                            <div>{{ $pendingSubmissions->links() }}</div>
                        </div>
                    </div>
                @else
                    <div class="ms-table-wrap">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg
                                    class="w-7 h-7"
                                    fill="none"
                                    stroke="#c9b99a"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M5 13l4 4L19 7"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </div>
                            <p class="empty-state-label">
                                All submissions assigned!
                            </p>
                            <p class="empty-state-sub">
                                No pending submissions at this time.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ── ASSIGNED TAB ── --}}
            <div id="tab-assigned" class="tab-panel">
                <form
                    method="GET"
                    action="{{ route('chief-editor.dashboard') }}"
                    class="flex flex-col sm:flex-row gap-3 mb-4"
                    id="assigned-search-form"
                >
                    <div class="search-wrap flex-1">
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" />
                        </svg>
                        <input
                            type="text"
                            name="search"
                            id="assigned-search"
                            placeholder="Search by title, abstract, or editor…"
                            value="{{ $searchTerm ?? '' }}"
                            onchange="
                                document
                                    .getElementById('assigned-search-form')
                                    .submit()
                            "
                        />
                    </div>
                    <select
                        id="assigned-status-filter"
                        class="filter-select"
                        onchange="
                            filterTable(
                                'assigned-tbody',
                                document.getElementById('assigned-search')
                                    .value,
                            )
                        "
                    >
                        <option value="">All Statuses</option>
                        @foreach (Submission::statusOptions() as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </form>

                @if ($assignedSubmissions->count() > 0)
                    <div class="ms-table-wrap">
                        <div class="overflow-x-auto">
                            <table class="mst">
                                <thead>
                                    <tr>
                                        <th
                                            class="sortable"
                                            onclick="
                                                sortTable(
                                                    'assigned-tbody',
                                                    0,
                                                    this,
                                                )
                                            "
                                        >
                                            Title
                                            <span class="sort-icon">↕</span>
                                        </th>
                                        <th
                                            class="sortable col-hide-sm"
                                            onclick="
                                                sortTable(
                                                    'assigned-tbody',
                                                    1,
                                                    this,
                                                )
                                            "
                                        >
                                            Assigned Editor
                                            <span class="sort-icon">↕</span>
                                        </th>
                                        <th
                                            class="sortable"
                                            onclick="
                                                sortTable(
                                                    'assigned-tbody',
                                                    2,
                                                    this,
                                                )
                                            "
                                        >
                                            Status
                                            <span class="sort-icon">↕</span>
                                        </th>
                                        <th
                                            class="sortable col-hide-sm"
                                            onclick="
                                                sortTable(
                                                    'assigned-tbody',
                                                    3,
                                                    this,
                                                )
                                            "
                                        >
                                            Assigned Date
                                            <span class="sort-icon">↕</span>
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="assigned-tbody">
                                    @foreach ($assignedSubmissions as $s)
                                        @php
                                            $sc = match ($s->status) {
                                                'accepted' => 'accepted',
                                                'rejected' => 'rejected',
                                                'under_review' => 'under_review',
                                                'revisions_requested' => 'revisions',
                                                default => 'default',
                                            };
                                        @endphp

                                        <tr
                                            data-title="{{ strtolower($s->title) }}"
                                            data-editor="{{ strtolower($s->assignedEditor->name ?? '') }}"
                                            data-status="{{ $s->status }}"
                                        >
                                            <td>
                                                <p class="row-title">
                                                    {{ Str::limit($s->title, 52) }}
                                                </p>
                                                {{-- Show editor inline on mobile --}}
                                                <p class="row-author sm:hidden">
                                                    {{ $s->assignedEditor->name ?? '—' }}
                                                </p>
                                            </td>
                                            <td class="col-hide-sm">
                                                <span class="row-author">
                                                    {{ $s->assignedEditor->name ?? '—' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="sbadge {{ $sc }}">
                                                    <span class="dot"></span>
                                                    {{ Submission::statusOptions()[$s->status] ?? $s->status }}
                                                </span>
                                            </td>
                                            <td class="col-hide-sm">
                                                <span
                                                    style="
                                                        font-size: 0.76rem;
                                                        color: var(--ink-soft);
                                                    "
                                                >
                                                    {{ $s->chief_editor_review_at?->format('M d, Y') ?? '—' }}
                                                </span>
                                            </td>
                                            <td style="text-align: right">
                                                <a
                                                    href="{{ route('chief-editor.submission.show', $s) }}"
                                                    class="btn-view"
                                                >
                                                    View
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
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-footer">
                            <span>
                                Showing
                                {{ $assignedSubmissions->firstItem() }}–{{ $assignedSubmissions->lastItem() }}
                                of {{ $assignedSubmissions->total() }}
                            </span>
                            <div>
                                {{ $assignedSubmissions->appends(request()->query())->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="ms-table-wrap">
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
                                No assigned submissions yet
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ── APPEALS TAB ── --}}
            <div id="tab-appeals" class="tab-panel">
                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                    <div class="search-wrap flex-1">
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" />
                        </svg>
                        <input
                            type="text"
                            id="appeals-search"
                            placeholder="Search by title or author…"
                            oninput="filterTable('appeals-tbody', this.value)"
                        />
                    </div>
                </div>

                @if ($pendingAppeals->count() > 0)
                    <div class="ms-table-wrap mb-6">
                        <div class="overflow-x-auto">
                            <table class="mst">
                                <thead>
                                    <tr>
                                        <th>Manuscript</th>
                                        <th class="col-hide-sm">Author</th>
                                        <th class="col-hide-sm">Submitted</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="appeals-tbody">
                                    @foreach ($pendingAppeals as $appeal)
                                        <tr
                                            data-title="{{ strtolower($appeal->submission->title) }}"
                                            data-author="{{ strtolower($appeal->author->name) }}"
                                        >
                                            <td>
                                                <p class="row-title">
                                                    {{ Str::limit($appeal->submission->title, 50) }}
                                                </p>
                                                <p class="row-ref">
                                                    #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}
                                                </p>
                                                {{-- Show author inline on mobile --}}
                                                <p class="row-author sm:hidden">
                                                    {{ $appeal->author->name }}
                                                </p>
                                            </td>
                                            <td class="col-hide-sm">
                                                <p class="row-author">
                                                    {{ $appeal->author->name }}
                                                </p>
                                                <p class="row-email">
                                                    {{ $appeal->author->email }}
                                                </p>
                                            </td>
                                            <td class="col-hide-sm">
                                                <span
                                                    style="
                                                        font-size: 0.78rem;
                                                        color: var(--ink-soft);
                                                    "
                                                >
                                                    {{ $appeal->created_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="sbadge pending">
                                                    <span class="dot"></span>
                                                    Pending
                                                </span>
                                            </td>
                                            <td style="text-align: right">
                                                <a
                                                    href="{{ route('appeals.show', $appeal) }}"
                                                    class="btn-icon"
                                                >
                                                    <svg
                                                        class="w-4 h-4"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M9 5l7 7-7 7"
                                                            stroke-linecap="round"
                                                        />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-footer">
                            <span>
                                Showing
                                {{ $pendingAppeals->firstItem() }}–{{ $pendingAppeals->lastItem() }}
                                of {{ $pendingAppeals->total() }}
                            </span>
                            <div>
                                {{ $pendingAppeals->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="ms-table-wrap mb-6">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg
                                    class="w-7 h-7"
                                    fill="none"
                                    stroke="#c9b99a"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M5 13l4 4L19 7"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </div>
                            <p class="empty-state-label">No pending appeals!</p>
                            <p class="empty-state-sub">
                                All appeals have been reviewed.
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Completed Appeals --}}
                @if ($completedAppeals->count() > 0)
                    <div class="section-label">Completed Appeals</div>
                    <div class="ms-table-wrap">
                        <div class="overflow-x-auto">
                            <table class="mst">
                                <thead>
                                    <tr>
                                        <th>Manuscript</th>
                                        <th class="col-hide-sm">Author</th>
                                        <th>Decision</th>
                                        <th class="col-hide-sm">Reviewed</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="completed-appeals-tbody">
                                    @foreach ($completedAppeals as $appeal)
                                        <tr
                                            data-title="{{ strtolower($appeal->submission->title) }}"
                                            data-author="{{ strtolower($appeal->author->name) }}"
                                        >
                                            <td>
                                                <p class="row-title">
                                                    {{ Str::limit($appeal->submission->title, 50) }}
                                                </p>
                                                <p class="row-ref">
                                                    #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}
                                                </p>
                                                <p class="row-author sm:hidden">
                                                    {{ $appeal->author->name }}
                                                </p>
                                            </td>
                                            <td class="col-hide-sm">
                                                <p class="row-author">
                                                    {{ $appeal->author->name }}
                                                </p>
                                                <p class="row-email">
                                                    {{ $appeal->author->email }}
                                                </p>
                                            </td>
                                            <td>
                                                @if ($appeal->status === 'approved')
                                                    <span
                                                        class="sbadge approved"
                                                    >
                                                        <span
                                                            class="dot"
                                                        ></span>
                                                        Approved
                                                    </span>
                                                @else
                                                    <span
                                                        class="sbadge rejected"
                                                    >
                                                        <span
                                                            class="dot"
                                                        ></span>
                                                        Rejected
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="col-hide-sm">
                                                <span
                                                    style="
                                                        font-size: 0.78rem;
                                                        color: var(--ink-soft);
                                                    "
                                                >
                                                    {{ $appeal->reviewed_at->format('M d, Y') }}
                                                </span>
                                                <p class="row-email">
                                                    by
                                                    {{ $appeal->reviewedBy->name ?? 'System' }}
                                                </p>
                                            </td>
                                            <td style="text-align: right">
                                                <a
                                                    href="{{ route('appeals.show', $appeal) }}"
                                                    class="btn-icon slate"
                                                >
                                                    <svg
                                                        class="w-4 h-4"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M9 5l7 7-7 7"
                                                            stroke-linecap="round"
                                                        />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-footer">
                            <span>
                                Showing
                                {{ $completedAppeals->firstItem() }}–{{ $completedAppeals->lastItem() }}
                                of {{ $completedAppeals->total() }}
                            </span>
                            <div>
                                {{ $completedAppeals->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {{-- /tabbed section --}}

        <p
            class="text-center fu3 mb-10"
            style="
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: #c9b99a;
            "
        >
            BatStateU · BIRJISE Journal System
        </p>
    </div>
@endsection

@push('scripts')
    <script>
        function switchTab(name, btn) {
            document
                .querySelectorAll('.tab-btn')
                .forEach((b) => b.classList.remove('active'));
            document
                .querySelectorAll('.tab-panel')
                .forEach((p) => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + name).classList.add('active');
        }

        function filterTable(tbodyId, searchVal) {
            const tbody = document.getElementById(tbodyId);
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr');
            const search = searchVal.toLowerCase().trim();

            let extraFilter = '';
            if (tbodyId === 'pending-tbody')
                extraFilter =
                    document
                        .getElementById('pending-field-filter')
                        ?.value.toLowerCase() ?? '';
            if (tbodyId === 'assigned-tbody')
                extraFilter =
                    document
                        .getElementById('assigned-status-filter')
                        ?.value.toLowerCase() ?? '';

            rows.forEach((row) => {
                const title = row.dataset.title ?? '';
                const author = row.dataset.author ?? '';
                const editor = row.dataset.editor ?? '';
                const field = row.dataset.field ?? '';
                const status = row.dataset.status ?? '';

                const matchSearch =
                    !search ||
                    title.includes(search) ||
                    author.includes(search) ||
                    editor.includes(search) ||
                    field.includes(search);
                const matchExtra =
                    !extraFilter ||
                    field.includes(extraFilter) ||
                    status === extraFilter;

                row.style.display = matchSearch && matchExtra ? '' : 'none';
            });
        }

        const sortState = {};
        function sortTable(tbodyId, colIndex, th) {
            const tbody = document.getElementById(tbodyId);
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const key = tbodyId + '-' + colIndex;

            sortState[key] = sortState[key] === 'asc' ? 'desc' : 'asc';
            const asc = sortState[key] === 'asc';

            th.closest('thead')
                .querySelectorAll('.sort-icon')
                .forEach((el) => (el.textContent = '↕'));
            th.querySelector('.sort-icon').textContent = asc ? '↑' : '↓';

            rows.sort((a, b) => {
                const aText =
                    a.cells[colIndex]?.innerText.trim().toLowerCase() ?? '';
                const bText =
                    b.cells[colIndex]?.innerText.trim().toLowerCase() ?? '';
                return asc
                    ? aText.localeCompare(bText)
                    : bText.localeCompare(aText);
            });
            rows.forEach((r) => tbody.appendChild(r));
        }
    </script>
@endpush
