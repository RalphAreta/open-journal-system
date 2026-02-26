@extends('layouts.app')

@section('title', 'Author Dashboard')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap"
        rel="stylesheet"
    />
    <style>
        .author-wrap {
            font-family: 'DM Sans', sans-serif;
        }

        /* ── Page Header ── */
        .page-title {
            font-family: 'Instrument Serif', serif;
            font-size: 1.85rem;
            font-weight: 400;
            color: #0f172a;
            letter-spacing: -0.015em;
            line-height: 1.2;
        }
        .page-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 4px;
        }
        .page-date-badge {
            font-size: 0.72rem;
            font-weight: 500;
            color: #94a3b8;
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 5px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .btn-new-submission {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #dc2626;
            color: #fff;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 10px 22px;
            border-radius: 9px;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.1s,
                box-shadow 0.15s;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
            white-space: nowrap;
        }
        .btn-new-submission:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.28);
        }

        /* ── Stat Cards ── */
        .stat-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
            transition:
                box-shadow 0.2s,
                transform 0.2s,
                border-color 0.2s;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.2s;
            pointer-events: none;
        }
        .stat-card:hover {
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.09);
            transform: translateY(-2px);
        }
        .stat-card:hover::before {
            opacity: 1;
        }
        .stat-card.c-slate::before {
            background: linear-gradient(135deg, #f8fafc 0%, transparent 60%);
        }
        .stat-card.c-blue::before {
            background: linear-gradient(135deg, #eff6ff 0%, transparent 60%);
        }
        .stat-card.c-yellow::before {
            background: linear-gradient(135deg, #fefce8 0%, transparent 60%);
        }
        .stat-card.c-orange::before {
            background: linear-gradient(135deg, #fff7ed 0%, transparent 60%);
        }
        .stat-card.c-amber::before {
            background: linear-gradient(135deg, #fffbeb 0%, transparent 60%);
        }
        .stat-card.c-emerald::before {
            background: linear-gradient(135deg, #f0fdf4 0%, transparent 60%);
        }
        .stat-card.c-red::before {
            background: linear-gradient(135deg, #fff5f5 0%, transparent 60%);
        }
        .stat-card.c-slate:hover {
            border-color: #cbd5e1;
        }
        .stat-card.c-blue:hover {
            border-color: #bfdbfe;
        }
        .stat-card.c-yellow:hover {
            border-color: #fde68a;
        }
        .stat-card.c-orange:hover {
            border-color: #fdba74;
        }
        .stat-card.c-amber:hover {
            border-color: #fcd34d;
        }
        .stat-card.c-emerald:hover {
            border-color: #6ee7b7;
        }
        .stat-card.c-red:hover {
            border-color: #fecaca;
        }

        .stat-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 10px;
            display: block;
        }
        .stat-number {
            font-family: 'Instrument Serif', serif;
            font-size: 2.1rem;
            line-height: 1;
        }
        .stat-number.c-slate {
            color: #0f172a;
        }
        .stat-number.c-blue {
            color: #2563eb;
        }
        .stat-number.c-yellow {
            color: #d97706;
        }
        .stat-number.c-orange {
            color: #ea580c;
        }
        .stat-number.c-amber {
            color: #b45309;
        }
        .stat-number.c-emerald {
            color: #059669;
        }
        .stat-number.c-red {
            color: #dc2626;
        }

        /* ── Search Bar ── */
        .search-bar {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
        }
        .search-icon-wrap {
            position: relative;
            flex: 1;
        }
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .search-input {
            width: 100%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            padding: 9px 14px 9px 38px;
            font-size: 0.82rem;
            font-family: 'DM Sans', sans-serif;
            color: #0f172a;
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
        }
        .search-input:focus {
            border-color: #fecaca;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.07);
        }
        .search-input::placeholder {
            color: #94a3b8;
        }
        .live-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #94a3b8;
            white-space: nowrap;
        }

        /* ── Alert Banner ── */
        .alert-banner {
            border-radius: 14px;
            overflow: hidden;
            border: 1.5px solid #fed7aa;
            box-shadow: 0 4px 14px rgba(234, 88, 12, 0.1);
        }
        .alert-inner {
            background: #fffbf5;
            padding: 16px 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }
        .alert-icon-box {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #fef3c7;
            color: #d97706;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .alert-tag {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #9a3412;
        }
        .alert-desc {
            font-size: 0.78rem;
            font-weight: 500;
            color: #92400e;
            margin-top: 2px;
        }
        .btn-revise {
            background: #fff;
            border: 1.5px solid #fed7aa;
            padding: 7px 14px;
            border-radius: 7px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #ea580c;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.1s;
        }
        .btn-revise:hover {
            background: #ea580c;
            color: #fff;
            transform: translateY(-1px);
        }

        /* ── Table Card ── */
        .table-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
        }
        .tbl-author thead tr {
            background: #fafbfc;
        }
        .tbl-author th {
            padding: 11px 22px;
            text-align: left;
            font-size: 0.67rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #94a3b8;
            border-bottom: 1.5px solid #e2e8f0;
        }
        .tbl-author th:last-child {
            text-align: right;
        }
        .tbl-author td {
            padding: 14px 22px;
            font-size: 0.82rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .tbl-author tbody tr:last-child td {
            border-bottom: none;
        }
        .tbl-author tbody tr {
            transition: background 0.12s;
            cursor: pointer;
        }
        .tbl-author tbody tr:hover td {
            background: #f8fafc;
        }
        .tbl-author tbody tr:hover .ms-title {
            color: #dc2626;
        }

        .ms-ref {
            font-family: monospace;
            font-size: 0.72rem;
            color: #94a3b8;
            letter-spacing: 0.04em;
        }
        .ms-title {
            font-size: 0.83rem;
            font-weight: 600;
            color: #0f172a;
            transition: color 0.12s;
        }
        .ms-date {
            font-size: 0.72rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        /* ── Inline Chips ── */
        .chip-row {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid transparent;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 7px;
        }
        .chip-row .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .chip-row.emerald {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #15803d;
        }
        .chip-row.emerald .dot {
            background: #16a34a;
        }
        .chip-row.red {
            background: #fff5f5;
            border-color: #fecaca;
            color: #b91c1c;
        }
        .chip-row.red .dot {
            background: #dc2626;
        }

        .comment-chip {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            border-radius: 8px;
            padding: 8px 10px;
            margin-top: 6px;
            border: 1px solid transparent;
        }
        .comment-chip.purple {
            background: #faf5ff;
            border-color: #e9d5ff;
        }
        .comment-chip.blue {
            background: #eff6ff;
            border-color: #bfdbfe;
        }
        .comment-chip.emerald {
            background: #f0fdf4;
            border-color: #86efac;
        }
        .comment-chip.red {
            background: #fef2f2;
            border-color: #fecaca;
        }
        .comment-chip svg {
            flex-shrink: 0;
            margin-top: 1px;
        }
        .comment-tag {
            font-size: 0.62rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 2px;
        }
        .comment-tag.purple {
            color: #7c3aed;
        }
        .comment-tag.blue {
            color: #1d4ed8;
        }
        .comment-tag.emerald {
            color: #059669;
        }
        .comment-tag.red {
            color: #dc2626;
        }
        .comment-text {
            font-size: 0.75rem;
            color: #475569;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ── Status Badges ── */
        .s-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border: 1px solid transparent;
        }
        .s-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }
        .s-badge.accepted {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #15803d;
        }
        .s-badge.accepted .dot {
            background: #16a34a;
        }
        .s-badge.under_review {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }
        .s-badge.under_review .dot {
            background: #2563eb;
        }
        .s-badge.revisions_requested {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #c2410c;
        }
        .s-badge.revisions_requested .dot {
            background: #ea580c;
        }
        .s-badge.rejected {
            background: #fff5f5;
            border-color: #fecaca;
            color: #b91c1c;
        }
        .s-badge.rejected .dot {
            background: #dc2626;
        }
        .s-badge.submitted {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #475569;
        }
        .s-badge.submitted .dot {
            background: #64748b;
        }

        /* ── Empty State ── */
        .empty-state-wrap {
            padding: 64px 24px;
            text-align: center;
        }
        .empty-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }
        .empty-label {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #cbd5e1;
        }

        /* ── Activity Stream ── */
        .activity-title {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 14px;
        }
        .activity-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            transition:
                box-shadow 0.15s,
                transform 0.15s;
        }
        .activity-card:hover {
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }
        .activity-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 4px;
        }
        .activity-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: #0f172a;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        .activity-time {
            font-size: 0.7rem;
            color: #94a3b8;
            font-weight: 500;
        }

        /* ── Animations ── */
        .fade-up {
            animation: fadeUp 0.4s ease both;
        }
        .fade-up-1 {
            animation: fadeUp 0.4s 0.07s ease both;
        }
        .fade-up-2 {
            animation: fadeUp 0.4s 0.14s ease both;
        }
        .fade-up-3 {
            animation: fadeUp 0.4s 0.21s ease both;
        }
        .fade-up-4 {
            animation: fadeUp 0.4s 0.28s ease both;
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
    </style>
@endpush

@section('content')
    <div class="author-wrap max-w-7xl mx-auto space-y-6">
        {{-- ── Page Header ── --}}
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-up"
        >
            <div>
                <h1 class="page-title">Author Workspace</h1>
                <p class="page-subtitle">
                    Overview of your research and manuscript pipeline
                </p>
            </div>
            <div class="flex items-center gap-3 self-start md:self-auto">
                <span class="page-date-badge hidden sm:inline-block">
                    {{ now()->format('D, M j Y') }}
                </span>
                <a
                    href="{{ route('submissions.create') }}"
                    class="btn-new-submission"
                >
                    + New Submission
                </a>
            </div>
        </div>

        {{-- ── Stats Grid ── --}}
        <div
            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 fade-up-1"
        >
            @foreach ([
                    [
                        'label' => 'Submitted',
                        'value' => $stats['submitted'],
                        'cls' => 'c-blue'
                    ],
                    [
                        'label' => 'Under Review',
                        'value' => $stats['under_review'],
                        'cls' => 'c-yellow'
                    ],
                    [
                        'label' => 'Revisions Requested',
                        'value' => $stats['revisions_requested'],
                        'cls' => 'c-orange'
                    ],
                    [
                        'label' => 'Revision Under Review',
                        'value' => $stats['revision_under_review'],
                        'cls' => 'c-amber'
                    ],
                    [
                        'label' => 'Accepted',
                        'value' => $stats['accepted'],
                        'cls' => 'c-emerald'
                    ],
                    ['label' => 'Rejected', 'value' => $stats['rejected'], 'cls' => 'c-red']
                ]
                as $stat)
                <div class="stat-card {{ $stat['cls'] }}">
                    <span class="stat-label">{{ $stat['label'] }}</span>
                    <p class="stat-number {{ $stat['cls'] }}">
                        {{ sprintf('%02d', $stat['value']) }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- ── Search Bar ── --}}
        <div class="search-bar fade-up-2">
            <div class="search-icon-wrap">
                <span class="search-icon">
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            stroke-width="2.5"
                        />
                    </svg>
                </span>
                <input
                    type="text"
                    id="dashboardSearch"
                    placeholder="Filter manuscripts by title, ID, or status..."
                    class="search-input"
                    onkeyup="filterTable()"
                />
            </div>
            <div class="live-indicator hidden md:flex">
                <span
                    class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"
                ></span>
                System Live
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

            <div class="alert-banner fade-up-2">
                <div class="alert-inner">
                    <div class="flex items-center gap-3">
                        <div class="alert-icon-box">
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
                            <p class="alert-tag">Action Required</p>
                            <p class="alert-desc">
                                Reviewers submitted feedback on
                                {{ $stats['revisions_requested'] }} paper(s).
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        @foreach ($revisionsNeeded->take(2) as $rev)
                            <a
                                href="{{ route('submissions.show', $rev) }}"
                                class="btn-revise"
                            >
                                View #{{ $rev->id }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Revision Decision Alert ── --}}
        @php
            $revisionDecisions = auth()
                ->user()
                ->submissionsAsAuthor()
                ->whereIn('status', ['accepted', 'rejected'])
                ->where(function ($query) {
                    $query
                        ->where('decision_notes', '!=', null)
                        ->orWhere('editor_decision_at', '!=', null);
                })
                ->orderBy('updated_at', 'desc')
                ->get();
        @endphp

        @if ($revisionDecisions->count() > 0)
            @php
                $latestDecision = $revisionDecisions->first();
            @endphp

            <div
                class="alert-banner fade-up-2"
                style="
                    border-color: {{ $latestDecision->status === 'accepted' ? '#86efac' : '#fecaca' }};
                    background: {{ $latestDecision->status === 'accepted' ? '#f0fdf4' : '#fffbf5' }};
                "
            >
                <div
                    class="alert-inner"
                    style="
                        background: {{ $latestDecision->status === 'accepted' ? '#f0fdf4' : '#fffbf5' }};
                    "
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="alert-icon-box"
                            style="
                                background: {{ $latestDecision->status === 'accepted' ? '#dcfce7' : '#ffedd5' }};
                                color: {{ $latestDecision->status === 'accepted' ? '#22c55e' : '#ea580c' }};
                                border-radius: 10px;
                            "
                        >
                            {{ $latestDecision->status === 'accepted' ? '✓' : '!' }}
                        </div>
                        <div>
                            <p
                                class="alert-tag"
                                style="
                                    color: {{ $latestDecision->status === 'accepted' ? '#15803d' : '#ea580c' }};
                                    font-size: 0.68rem;
                                "
                            >
                                {{ $latestDecision->status === 'accepted' ? 'DECISION: ACCEPTED' : 'DECISION: REJECTED' }}
                            </p>
                            <p
                                class="alert-desc"
                                style="
                                    color: {{ $latestDecision->status === 'accepted' ? '#166534' : '#7c2d12' }};
                                "
                            >
                                The editor has made a final decision on your
                                revised manuscript.
                            </p>
                        </div>
                    </div>
                    <div>
                        <a
                            href="{{ route('submissions.show', $latestDecision) }}"
                            class="btn-revise"
                            style="
                                background: {{ $latestDecision->status === 'accepted' ? '#16a34a' : '#ea580c' }};
                                border-color: {{ $latestDecision->status === 'accepted' ? '#16a34a' : '#ea580c' }};
                                color: white !important;
                                text-decoration: none;
                            "
                        >
                            View Details →
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Submissions Table ── --}}
        <div class="table-card fade-up-3">
            <div class="overflow-x-auto">
                <table class="w-full tbl-author" id="submissionsTable">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th class="w-1/2">Manuscript Title</th>
                            <th>Status</th>
                            <th>Last Update</th>
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
                                    <p class="ms-title title-cell">
                                        {{ $s->title }}
                                    </p>

                                    @if ($s->initial_screening_comments || $s->editor_notes || $s->initial_screening_status !== 'pending')
                                        <div onclick="event.stopPropagation()">
                                            {{-- Screening Status Chip --}}
                                            @if ($s->initial_screening_status === 'passed')
                                                <div class="chip-row emerald">
                                                    <span class="dot"></span>
                                                    Passed Initial Screening
                                                </div>
                                            @elseif ($s->initial_screening_status === 'failed')
                                                <div class="chip-row red">
                                                    <span class="dot"></span>
                                                    Failed Initial Screening
                                                </div>
                                            @endif

                                            {{-- Acceptance / Rejection Chip --}}
                                            @if ($s->status === 'accepted')
                                                <div class="chip-row emerald">
                                                    <span class="dot"></span>
                                                    Manuscript Accepted
                                                </div>
                                            @elseif ($s->status === 'rejected')
                                                <div class="chip-row red">
                                                    <span class="dot"></span>
                                                    Manuscript Rejected
                                                </div>
                                            @endif

                                            {{-- Screening Comments --}}
                                            @if ($s->initial_screening_comments)
                                                <div
                                                    class="comment-chip purple"
                                                >
                                                    <svg
                                                        class="w-3 h-3 text-purple-400"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            d="M2 5a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2H6l-4 4V5z"
                                                        />
                                                    </svg>
                                                    <div>
                                                        <p
                                                            class="comment-tag purple"
                                                        >
                                                            Screening Comments
                                                        </p>
                                                        <p class="comment-text">
                                                            {{ $s->initial_screening_comments }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Editor Notes --}}
                                            @if ($s->editor_notes)
                                                <div class="comment-chip blue">
                                                    <svg
                                                        class="w-3 h-3 text-blue-400"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            d="M2 5a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2H6l-4 4V5z"
                                                        />
                                                    </svg>
                                                    <div>
                                                        <p
                                                            class="comment-tag blue"
                                                        >
                                                            Editor's Note
                                                        </p>
                                                        <p class="comment-text">
                                                            {{ $s->editor_notes }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Appeal Decision --}}
                                            @php
                                                $appeal = $s
                                                    ->appeals()
                                                    ->latest()
                                                    ->first();
                                            @endphp

                                            @if ($appeal)
                                                <div
                                                    class="comment-chip {{ $appeal->status === 'approved' ? 'emerald' : 'red' }}"
                                                >
                                                    <svg
                                                        class="w-3 h-3 {{ $appeal->status === 'approved' ? 'text-emerald-400' : 'text-red-400' }}"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            d="M2 5a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2H6l-4 4V5z"
                                                        />
                                                    </svg>
                                                    <div>
                                                        <p
                                                            class="comment-tag {{ $appeal->status === 'approved' ? 'emerald' : 'red' }}"
                                                        >
                                                            Appeal
                                                            {{ ucfirst($appeal->status) }}
                                                        </p>

                                                        @if ($appeal->editor_response)
                                                            <p
                                                                class="comment-text"
                                                            >
                                                                {{ $appeal->editor_response }}
                                                            </p>
                                                        @else
                                                            <p
                                                                class="comment-text text-gray-500"
                                                            >
                                                                Awaiting
                                                                editor-in-chief
                                                                review...
                                                            </p>
                                                        @endif
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
                                            'under_review' => 'under_review',
                                            'revision_under_review' => 'under_review',
                                            'revisions_requested' => 'revisions_requested',
                                            'rejected' => 'rejected',
                                            default => 'submitted',
                                        };
                                        $displayStatus = match ($s->status) {
                                            'revision_under_review' => 'Revision Under Review',
                                            default => str_replace('_', ' ', $s->status),
                                        };
                                    @endphp

                                    <span
                                        class="s-badge {{ $cls }} status-cell"
                                    >
                                        <span class="dot"></span>
                                        {{ ucfirst($displayStatus) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span class="ms-date">
                                        {{ $s->updated_at->format('d M Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state-wrap">
                                        <div class="empty-icon">
                                            <svg
                                                class="w-7 h-7 text-slate-200"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M12 4v16m8-8H4"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                        </div>
                                        <p class="empty-label">
                                            No active manuscripts found
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function filterTable() {
                const filter = document.getElementById("dashboardSearch").value.toUpperCase();
                document.querySelectorAll(".submission-row").forEach(row => {
                    const title  = row.querySelector(".title-cell").innerText.toUpperCase();
                    const id     = row.cells[0].innerText.toUpperCase();
                    const status = row.querySelector(".status-cell").innerText.toUpperCase();
                    row.style.display = (title.includes(filter) || id.includes(filter) || status.includes(filter)) ? "" : "none";
                });
            }

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-sm font-black uppercase tracking-widest">Confirmed</span>',
                    html: '<p class="text-xs font-medium text-slate-500">{{ session('success') }}</p>',
                    confirmButtonText: 'CLOSE',
                    confirmButtonColor: '#DC2626',
                    customClass: {
                        popup: 'rounded-[2rem] border-none shadow-2xl',
                        confirmButton: 'rounded-xl px-8 py-3 font-black text-[10px] uppercase tracking-[0.2em]'
                    },
                    buttonsStyling: false,
                });
            @endif
    </script>
@endpush
