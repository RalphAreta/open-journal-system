@extends('layouts.app')

@section('title', 'Author Dashboard')

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
            --red-lt: #fdf0ee;
            --teal: #2d8176;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
        }

        * {
            box-sizing: border-box;
        }

        .aw {
            font-family: 'Outfit', sans-serif;
            color: var(--ink);
        }
        .serif {
            font-family: 'Cormorant Garamond', serif;
        }

        /* ── Background texture ── */
        .aw-bg {
            background-color: var(--cream);
            background-image:
                radial-gradient(
                    ellipse 80% 50% at 50% -10%,
                    rgba(201, 168, 76, 0.1) 0%,
                    transparent 70%
                ),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.5'/%3E%3C/svg%3E");
        }

        /* ── Header ── */
        .hero-header {
            position: relative;
            padding: 36px 0 28px;
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
            background: linear-gradient(90deg, var(--gold), transparent);
        }
        .hero-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold-dk);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .hero-eyebrow::before {
            content: '';
            width: 22px;
            height: 1px;
            background: var(--gold);
        }
        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.6rem;
            font-weight: 300;
            color: var(--ink);
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        .hero-title em {
            font-style: italic;
            color: var(--gold-dk);
        }
        .hero-sub {
            font-size: 0.82rem;
            font-weight: 400;
            color: var(--ink-soft);
            margin-top: 6px;
            letter-spacing: 0.01em;
        }
        .date-pill {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--ink-soft);
            background: var(--parchment);
            border: 1px solid var(--border);
            padding: 5px 14px;
            border-radius: 20px;
        }
        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--ink);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 11px 24px;
            border-radius: 6px;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(26, 18, 9, 0.18);
            position: relative;
            overflow: hidden;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(201, 168, 76, 0.15) 0%,
                transparent 60%
            );
        }
        .btn-submit:hover {
            background: var(--ink-mid);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(26, 18, 9, 0.22);
        }

        /* ── Stat Grid ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0;
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        @media (max-width: 900px) {
            .stat-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 560px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-cell {
            padding: 20px 18px 16px;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            position: relative;
            transition: background 0.18s;
            cursor: default;
        }
        .stat-cell:hover {
            background: #fff;
        }
        .stat-cell:last-child,
        .stat-cell:nth-child(6) {
            border-right: none;
        }
        .stat-cell:nth-child(n + 5) {
            border-bottom: none;
        }
        @media (max-width: 900px) {
            .stat-cell:nth-child(3n) {
                border-right: none;
            }
            .stat-cell:nth-child(n + 4) {
                border-bottom: none;
            }
            .stat-cell:nth-child(-n + 3) {
                border-bottom: 1px solid var(--border);
            }
        }

        .stat-lbl {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 8px;
        }
        .stat-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 300;
            line-height: 1;
        }
        .stat-cell .accent-line {
            position: absolute;
            bottom: 0;
            left: 18px;
            height: 2px;
            width: 0;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        .stat-cell:hover .accent-line {
            width: 32px;
        }

        .sv-blue {
            color: #1e4db7;
        }
        .sv-amber {
            color: #92400e;
        }
        .sv-orange {
            color: #c2410c;
        }
        .sv-yellow {
            color: #b45309;
        }
        .sv-emerald {
            color: #065f46;
        }
        .sv-red {
            color: var(--red);
        }
        .al-blue {
            background: #3b82f6;
        }
        .al-amber {
            background: #d97706;
        }
        .al-orange {
            background: #ea580c;
        }
        .al-yellow {
            background: #f59e0b;
        }
        .al-emerald {
            background: #10b981;
        }
        .al-red {
            background: var(--red);
        }

        /* ── Search ── */
        .search-wrap {
            position: relative;
        }
        .search-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-soft);
            pointer-events: none;
            width: 16px;
            height: 16px;
        }
        .search-inp {
            width: 100%;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 11px 16px 11px 42px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.82rem;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            box-shadow: 0 1px 4px rgba(26, 18, 9, 0.05);
        }
        .search-inp:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.12);
        }
        .search-inp::placeholder {
            color: #b5a595;
        }

        /* ── Alert Banner ── */
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
            padding: 14px 18px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .alert-tag {
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .alert-desc {
            font-size: 0.78rem;
            font-weight: 400;
        }
        .btn-alert-action {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 6px 14px;
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
            padding: 14px 24px 12px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ms-table-head-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            font-weight: 400;
            color: var(--ink);
            letter-spacing: 0.01em;
        }
        .ms-table-head-count {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--ink-soft);
            background: var(--cream);
            border: 1px solid var(--border);
            padding: 3px 10px;
            border-radius: 20px;
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
            padding: 10px 20px;
            font-size: 0.6rem;
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
            padding: 16px 20px;
            font-size: 0.81rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: top;
        }
        table.mst tbody tr:last-child td {
            border-bottom: none;
        }
        table.mst tbody tr {
            transition: background 0.1s;
            cursor: pointer;
        }
        table.mst tbody tr:hover td {
            background: var(--cream);
        }
        table.mst tbody tr:hover .ms-row-title {
            color: var(--red);
        }

        .ms-ref {
            font-family: 'Outfit', sans-serif;
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--gold-dk);
            letter-spacing: 0.06em;
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.25);
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        .ms-row-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            font-weight: 400;
            color: var(--ink);
            line-height: 1.3;
            margin-top: 4px;
            transition: color 0.12s;
        }

        /* Status badge */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
            white-space: nowrap;
        }
        .sbadge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .sbadge.accepted {
            background: #f0fdf4;
            border-color: #86efac;
            color: #065f46;
        }
        .sbadge.accepted .dot {
            background: #10b981;
        }
        .sbadge.under_review {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1e40af;
        }
        .sbadge.under_review .dot {
            background: #3b82f6;
        }
        .sbadge.revisions_requested {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #9a3412;
        }
        .sbadge.revisions_requested .dot {
            background: #f97316;
        }
        .sbadge.rejected {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }
        .sbadge.rejected .dot {
            background: var(--red);
        }
        .sbadge.submitted {
            background: var(--parchment);
            border-color: var(--border);
            color: var(--ink-soft);
        }
        .sbadge.submitted .dot {
            background: #a8906e;
        }

        /* inline note chips */
        .note-chip {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            margin-top: 7px;
            padding: 7px 10px;
            border-radius: 7px;
            border-left: 3px solid;
        }
        .note-chip.purple {
            background: #faf5ff;
            border-color: #a855f7;
        }
        .note-chip.blue {
            background: #eff6ff;
            border-color: #3b82f6;
        }
        .note-chip.emerald {
            background: #f0fdf4;
            border-color: #10b981;
        }
        .note-chip.red {
            background: #fef2f2;
            border-color: var(--red);
        }
        .note-chip-tag {
            font-size: 0.58rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .note-chip.purple .note-chip-tag {
            color: #7c3aed;
        }
        .note-chip.blue .note-chip-tag {
            color: #1d4ed8;
        }
        .note-chip.emerald .note-chip-tag {
            color: #065f46;
        }
        .note-chip.red .note-chip-tag {
            color: #991b1b;
        }
        .note-chip-text {
            font-size: 0.72rem;
            color: var(--ink-soft);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ms-date {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--ink-soft);
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        /* empty */
        .empty-state {
            padding: 72px 24px;
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
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }

        /* ── Fade animations ── */
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
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* divider ornament */
        .ornament-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--gold);
            margin: 4px 0 8px;
        }
        .ornament-divider::before,
        .ornament-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(
                90deg,
                transparent,
                var(--gold-lt),
                transparent
            );
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-7xl mx-auto px-1">
        {{-- ── Hero Header ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Author Workspace</p>
                    <h1 class="hero-title">
                        Your
                        <em>Manuscript</em>
                        Pipeline
                    </h1>
                    <p class="hero-sub">
                        Track submissions, revisions, and editorial decisions in
                        one place
                    </p>
                </div>
                <div
                    class="flex items-center gap-3 self-start md:self-auto shrink-0"
                >
                    <span class="date-pill hidden sm:inline-block">
                        {{ now()->format('D, M j Y') }}
                    </span>
                    <a
                        href="{{ route('submissions.create') }}"
                        class="btn-submit"
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
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        New Submission
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Stats Grid ── --}}
        <div class="stat-grid fu1 mb-8">
            @foreach ([
                    ['Submitted', $stats['submitted'], 'sv-blue', 'al-blue'],
                    ['Under Review', $stats['under_review'], 'sv-amber', 'al-amber'],
                    [
                        'Revisions Requested',
                        $stats['revisions_requested'],
                        'sv-orange',
                        'al-orange'
                    ],
                    [
                        'Revision Under Review',
                        $stats['revision_under_review'],
                        'sv-yellow',
                        'al-yellow'
                    ],
                    ['Accepted', $stats['accepted'], 'sv-emerald', 'al-emerald'],
                    ['Rejected', $stats['rejected'], 'sv-red', 'al-red']
                ]
                as [$lbl, $val, $vc, $ac])
                <div class="stat-cell">
                    <p class="stat-lbl">{{ $lbl }}</p>
                    <p class="stat-val {{ $vc }}">
                        {{ sprintf('%02d', $val) }}
                    </p>
                    <div class="accent-line {{ $ac }}"></div>
                </div>
            @endforeach
        </div>

        {{-- ── Search ── --}}
        <div class="fu2 mb-6">
            <div class="search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        stroke-width="2.5"
                    />
                </svg>
                <input
                    type="text"
                    id="dashboardSearch"
                    class="search-inp"
                    placeholder="Filter by title, reference number, or status…"
                    onkeyup="filterTable()"
                />
            </div>
        </div>

        {{-- ── Revision Alert ── --}}
        @if ($stats['revisions_requested'] > 0)
            @php
                $revisionsNeeded = auth()
                    ->user()
                    ->submissionsAsAuthor()
                    ->where('status', 'revisions_requested')
                    ->orderBy('updated_at', 'desc')
                    ->get();
            @endphp

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
                                    width: 34px;
                                    height: 34px;
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
                                    class="w-4 h-4"
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
                                    Action Required
                                </p>
                                <p class="alert-desc" style="color: #7c2d12">
                                    {{ $stats['revisions_requested'] }}
                                    manuscript{{ $stats['revisions_requested'] > 1 ? 's require' : ' requires' }}
                                    your attention
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($revisionsNeeded->take(2) as $rev)
                                <a
                                    href="{{ route('submissions.show', $rev) }}"
                                    class="btn-alert-action"
                                    style="
                                        color: #ea580c;
                                        border-color: #fed7aa;
                                    "
                                >
                                    Revise
                                    #{{ str_pad($rev->id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Final Decision Alert ── --}}
        @php
            $revisionDecisions = auth()
                ->user()
                ->submissionsAsAuthor()
                ->whereIn('status', ['accepted', 'rejected'])
                ->where(function ($q) {
                    $q->where('decision_notes', '!=', null)->orWhere('editor_decision_at', '!=', null);
                })
                ->orderBy('updated_at', 'desc')
                ->get();
        @endphp

        @if ($revisionDecisions->count() > 0)
            @php
                $ld = $revisionDecisions->first();
                $isAcc = $ld->status === 'accepted';
            @endphp

            <div class="fu2 mb-4">
                <div
                    class="alert-strip"
                    style="
                        border-color: {{ $isAcc ? '#86efac' : '#fecaca' }};
                        background: {{ $isAcc ? '#fafffe' : '#fffafa' }};
                    "
                >
                    <div
                        class="alert-strip-accent"
                        style="
                            background: {{ $isAcc ? '#10b981' : '#dc2626' }};
                        "
                    ></div>
                    <div class="alert-strip-body">
                        <div class="flex items-center gap-3">
                            <div
                                style="
                                    width: 34px;
                                    height: 34px;
                                    border-radius: 8px;
                                    background: {{ $isAcc ? '#f0fdf4' : '#fef2f2' }};
                                    color: {{ $isAcc ? '#10b981' : '#dc2626' }};
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 1rem;
                                    flex-shrink: 0;
                                "
                            >
                                {{ $isAcc ? '✓' : '✕' }}
                            </div>
                            <div>
                                <p
                                    class="alert-tag"
                                    style="
                                        color: {{ $isAcc ? '#065f46' : '#991b1b' }};
                                    "
                                >
                                    Final Decision:
                                    {{ $isAcc ? 'Accepted' : 'Rejected' }}
                                </p>
                                <p
                                    class="alert-desc"
                                    style="
                                        color: {{ $isAcc ? '#166534' : '#7f1d1d' }};
                                    "
                                >
                                    The editor has issued a final decision on
                                    your revised manuscript
                                </p>
                            </div>
                        </div>
                        <a
                            href="{{ route('submissions.show', $ld) }}"
                            class="btn-alert-action"
                            style="
                                color: {{ $isAcc ? '#065f46' : '#991b1b' }};
                                border-color: {{ $isAcc ? '#86efac' : '#fecaca' }};
                            "
                        >
                            View Details →
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Manuscripts Table ── --}}
        <div class="ms-table-wrap fu3">
            <div class="ms-table-head">
                <span class="ms-table-head-title">Manuscripts</span>
                <span class="ms-table-head-count">
                    {{ $submissions->total() ?? $submissions->count() }}
                    records
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="mst" id="submissionsTable">
                    <thead>
                        <tr>
                            <th style="width: 100px">Ref No.</th>
                            <th>Manuscript Title &amp; Notes</th>
                            <th style="width: 160px">Status</th>
                            <th style="width: 110px; text-align: right">
                                Updated
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $s)
                            <tr
                                class="submission-row"
                                onclick="
                                    window.location =
                                        '{{ route('submissions.show', $s) }}'
                                "
                            >
                                <td>
                                    <span class="ms-ref">
                                        #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>
                                    <p class="ms-row-title title-cell">
                                        {{ $s->title }}
                                    </p>

                                    @if ($s->initial_screening_comments || $s->editor_notes || $s->initial_screening_status !== 'pending')
                                        <div
                                            onclick="event.stopPropagation()"
                                            class="mt-2 space-y-1"
                                        >
                                            @if ($s->initial_screening_comments)
                                                <div class="note-chip purple">
                                                    <div
                                                        style="margin-top: 1px"
                                                    >
                                                        <p
                                                            class="note-chip-tag"
                                                        >
                                                            Screening Note
                                                        </p>
                                                        <p
                                                            class="note-chip-text"
                                                        >
                                                            {{ $s->initial_screening_comments }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($s->editor_notes)
                                                <div class="note-chip blue">
                                                    <div
                                                        style="margin-top: 1px"
                                                    >
                                                        <p
                                                            class="note-chip-tag"
                                                        >
                                                            Editor's Note
                                                        </p>
                                                        <p
                                                            class="note-chip-text"
                                                        >
                                                            {{ $s->editor_notes }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            @php
                                                $appeal = $s
                                                    ->appeals()
                                                    ->latest()
                                                    ->first();
                                            @endphp

                                            @if ($appeal)
                                                <div
                                                    class="note-chip {{ $appeal->status === 'approved' ? 'emerald' : 'red' }}"
                                                >
                                                    <div
                                                        style="margin-top: 1px"
                                                    >
                                                        <p
                                                            class="note-chip-tag"
                                                        >
                                                            Appeal
                                                            {{ ucfirst($appeal->status) }}
                                                        </p>
                                                        <p
                                                            class="note-chip-text"
                                                        >
                                                            {{ $appeal->editor_response ?? 'Awaiting editor-in-chief review…' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $cls = match ($s->status) {
                                            'accepted' => 'accepted',
                                            'under_review', 'revision_under_review' => 'under_review',
                                            'revisions_requested' => 'revisions_requested',
                                            'rejected' => 'rejected',
                                            default => 'submitted',
                                        };
                                        $label = match ($s->status) {
                                            'revision_under_review' => 'Revision Review',
                                            default => ucfirst(str_replace('_', ' ', $s->status)),
                                        };
                                    @endphp

                                    <span
                                        class="sbadge {{ $cls }} status-cell"
                                    >
                                        <span class="dot"></span>
                                        {{ $label }}
                                    </span>
                                </td>
                                <td style="text-align: right">
                                    <span class="ms-date">
                                        {{ $s->updated_at->format('d M Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
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
                                            No manuscripts found
                                        </p>
                                        <p
                                            style="
                                                font-size: 0.75rem;
                                                color: #b5a595;
                                                margin-top: 6px;
                                            "
                                        >
                                            Submit your first manuscript to get
                                            started
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if (method_exists($submissions, 'hasPages') && $submissions->hasPages())
            <div class="fu4 mt-4">{{ $submissions->links() }}</div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function filterTable() {
                const f = document.getElementById('dashboardSearch').value.toUpperCase();
                document.querySelectorAll('.submission-row').forEach(row => {
                    const title  = row.querySelector('.title-cell')?.innerText.toUpperCase() ?? '';
                    const ref    = row.cells[0]?.innerText.toUpperCase() ?? '';
                    const status = row.querySelector('.status-cell')?.innerText.toUpperCase() ?? '';
                    row.style.display = (title.includes(f) || ref.includes(f) || status.includes(f)) ? '' : 'none';
                });
            }

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '<span style="font-family:\'Cormorant Garamond\',serif;font-size:1.3rem;font-weight:400;">Confirmed</span>',
                    html: '<p style="font-size:.82rem;color:#6b5740;">{{ session('success') }}</p>',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#1a1209',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'
                    },
                    buttonsStyling: false,
                });
            @endif
    </script>
@endpush
