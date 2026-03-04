@extends('layouts.app')

@section('title', 'Manage Submissions')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #1e7a6e;
            --teal-dark: #0f4d45;
            --teal-light: #e8f5f3;
            --gold: #b8963e;
            --ink: #0d1628;
            --muted: #64748b;
            --border: #e2e8f0;
            --surface: #f8fafc;
            --white: #ffffff;
            --red: #dc2626;
            --amber: #d97706;
            --emerald: #059669;
            --blue: #2563eb;
            --orange: #ea580c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f1f5f9;
            color: var(--ink);
        }

        .font-display {
            font-family: 'Cormorant Garamond', serif;
        }
        .font-mono {
            font-family: 'DM Mono', monospace;
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

        /* ── Page shell ── */
        .page-shell {
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px 24px 60px;
        }

        /* ── Header ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        /* ── Stat strip ── */
        .stat-strip {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        @media (max-width: 900px) {
            .stat-strip {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 560px) {
            .stat-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
        }
        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .stat-num {
            font-size: 22px;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
            font-family: 'Cormorant Garamond', serif;
        }
        .stat-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* ── Toolbar ── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 220px;
        }
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--muted);
        }
        .search-input {
            width: 100%;
            padding: 9px 14px 9px 36px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            background: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
        }
        .search-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(30, 122, 110, 0.1);
        }
        .search-input::placeholder {
            color: #94a3b8;
        }

        .filter-select {
            padding: 9px 32px 9px 12px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            background: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 500;
            color: var(--ink);
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 11px center;
            transition: border-color 0.15s;
            min-width: 140px;
        }
        .filter-select:focus {
            border-color: var(--teal);
            outline: none;
        }

        /* ── Table card ── */
        .table-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl thead tr {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .tbl th {
            padding: 12px 18px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
            white-space: nowrap;
        }
        .tbl th:last-child {
            text-align: right;
        }

        .tbl tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.12s;
        }
        .tbl tbody tr:last-child {
            border-bottom: none;
        }
        .tbl tbody tr:hover {
            background: #fafcff;
        }

        .tbl td {
            padding: 14px 18px;
            vertical-align: middle;
        }
        .tbl td:last-child {
            text-align: right;
        }

        /* ── Title cell ── */
        .title-cell {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .title-index {
            font-size: 10px;
            font-weight: 600;
            color: #cbd5e1;
            font-family: 'DM Mono', monospace;
            margin-top: 2px;
            flex-shrink: 0;
            min-width: 24px;
        }
        .title-text {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.4;
            transition: color 0.15s;
        }
        tr:hover .title-text {
            color: var(--teal);
        }

        .title-field {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            color: #94a3b8;
            margin-top: 3px;
        }

        /* ── Author cell ── */
        .author-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .author-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--ink);
        }
        .author-date {
            font-size: 10px;
            color: var(--muted);
            margin-top: 1px;
            font-family: 'DM Mono', monospace;
        }

        /* ── Status pill ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border: 1px solid;
            white-space: nowrap;
        }
        .pill-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .s-submitted {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
        }
        .s-submitted .pill-dot {
            background: #2563eb;
        }
        .s-review {
            background: #fffbeb;
            border-color: #fde68a;
            color: #d97706;
        }
        .s-review .pill-dot {
            background: #d97706;
        }
        .s-accepted {
            background: #ecfdf5;
            border-color: #a7f3d0;
            color: #059669;
        }
        .s-accepted .pill-dot {
            background: #059669;
        }
        .s-rejected {
            background: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
        }
        .s-rejected .pill-dot {
            background: #dc2626;
        }
        .s-revisions {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #ea580c;
        }
        .s-revisions .pill-dot {
            background: #ea580c;
        }
        .s-default {
            background: var(--surface);
            border-color: var(--border);
            color: var(--muted);
        }
        .s-default .pill-dot {
            background: #94a3b8;
        }

        /* ── Review badges ── */
        .review-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        .rbadge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
        }
        .rb-accept {
            background: #ecfdf5;
            color: #059669;
        }
        .rb-reject {
            background: #fef2f2;
            color: #dc2626;
        }
        .rb-minor {
            background: #fffbeb;
            color: #d97706;
        }
        .rb-major {
            background: #fff7ed;
            color: #ea580c;
        }
        .rb-pending {
            background: var(--surface);
            color: var(--muted);
        }
        .rb-icon {
            width: 10px;
            height: 10px;
        }

        /* ── Manage button ── */
        .btn-manage {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
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
                filter 0.14s,
                box-shadow 0.14s;
            box-shadow: 0 2px 8px rgba(30, 122, 110, 0.2);
            white-space: nowrap;
        }
        .btn-manage:hover {
            transform: translateY(-1px);
            filter: brightness(1.08);
            box-shadow: 0 4px 14px rgba(30, 122, 110, 0.3);
        }

        /* ── Empty state ── */
        .empty-state {
            padding: 64px 24px;
            text-align: center;
        }
        .empty-icon {
            width: 56px;
            height: 56px;
            background: var(--surface);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            border: 1px solid var(--border);
        }

        /* ── Pagination footer ── */
        .table-footer {
            padding: 12px 18px;
            background: var(--surface);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .rows-label {
            font-size: 11px;
            color: var(--muted);
            font-weight: 500;
        }

        /* ── Legend ── */
        .legend-bar {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 18px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            margin-top: 14px;
        }
        .legend-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--muted);
            margin-right: 6px;
        }

        /* ── Date badge ── */
        .date-badge {
            font-size: 11px;
            font-weight: 500;
            color: var(--muted);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 5px 12px;
            font-family: 'DM Mono', monospace;
        }
    </style>
@endpush

@section('content')
    <div class="page-shell">
        {{-- Validation errors --}}
        <x-validation-errors />

        {{-- ── Page Header ── --}}
        <div class="page-header fade-up">
            <div>
                <h1
                    class="font-display"
                    style="
                        font-size: 30px;
                        font-weight: 600;
                        color: var(--teal-dark);
                        line-height: 1.1;
                        letter-spacing: -0.01em;
                    "
                >
                    Manage Submissions
                </h1>
                <p
                    style="
                        font-size: 13px;
                        color: var(--muted);
                        margin-top: 5px;
                    "
                >
                    Review, assign, and track manuscript progress
                </p>
            </div>
            <span class="date-badge">{{ now()->format('D, M j Y') }}</span>
        </div>

        {{-- ── Stats Strip ── --}}
        @php
            $total = $submissions->total() ?? $submissions->count();
            $submitted = $submissions
                ->getCollection()
                ->where('status', 'submitted')
                ->count();
            $underReview = $submissions
                ->getCollection()
                ->where('status', 'under_review')
                ->count();
            $accepted = $submissions
                ->getCollection()
                ->where('status', 'accepted')
                ->count();
            $rejected = $submissions
                ->getCollection()
                ->where('status', 'rejected')
                ->count();
        @endphp

        <div class="stat-strip fade-up-1">
            <div class="stat-card">
                <div class="stat-icon" style="background: #f0fdf4">
                    <svg
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="var(--emerald)"
                        stroke-width="1.8"
                    >
                        <path
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
                <div>
                    <div class="stat-num">{{ $total }}</div>
                    <div class="stat-label">Total</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #eff6ff">
                    <svg
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="var(--blue)"
                        stroke-width="1.8"
                    >
                        <path
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                        />
                    </svg>
                </div>
                <div>
                    <div class="stat-num">
                        {{ $submissions->getCollection()->where('status', 'submitted')->count() }}
                    </div>
                    <div class="stat-label">Submitted</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fffbeb">
                    <svg
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="var(--amber)"
                        stroke-width="1.8"
                    >
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="stat-num">
                        {{ $submissions->getCollection()->where('status', 'under_review')->count() }}
                    </div>
                    <div class="stat-label">In Review</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #ecfdf5">
                    <svg
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="var(--emerald)"
                        stroke-width="1.8"
                    >
                        <path
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
                <div>
                    <div class="stat-num">
                        {{ $submissions->getCollection()->where('status', 'accepted')->count() }}
                    </div>
                    <div class="stat-label">Accepted</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef2f2">
                    <svg
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="var(--red)"
                        stroke-width="1.8"
                    >
                        <path
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
                <div>
                    <div class="stat-num">
                        {{ $submissions->getCollection()->where('status', 'rejected')->count() }}
                    </div>
                    <div class="stat-label">Rejected</div>
                </div>
            </div>
        </div>

        {{-- ── Toolbar ── --}}
        <div class="toolbar fade-up-1">
            <div class="search-wrap">
                <svg
                    class="search-icon"
                    width="14"
                    height="14"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input
                    type="text"
                    id="search-input"
                    class="search-input"
                    placeholder="Search by title or author…"
                />
            </div>
            <select id="status-filter" class="filter-select">
                <option value="">All Statuses</option>
                <option value="submitted">Submitted</option>
                <option value="under_review">Under Review</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
                <option value="revisions_requested">Revisions Requested</option>
            </select>
            <select
                id="sort-select"
                class="filter-select"
                style="min-width: 130px"
            >
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="title">Title A–Z</option>
            </select>
        </div>

        {{-- ── Table Card ── --}}
        <div class="table-card fade-up-2">
            <div style="overflow-x: auto">
                <table class="tbl" id="submissions-table">
                    <thead>
                        <tr>
                            <th style="width: 36%">Title</th>
                            <th style="width: 16%">Author</th>
                            <th style="width: 14%">Status</th>
                            <th style="width: 22%">Reviews</th>
                            <th style="width: 12%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @forelse ($submissions as $i => $s)
                            @php
                                $reviews = $s->reviews;
                                $assignments = $s->reviewAssignments;
                                $completed = $reviews->count();
                                $pending = $assignments->where('status', 'assigned')->count();
                                $accepts = $reviews->where('recommendation', 'accept')->count();
                                $rejects = $reviews->where('recommendation', 'reject')->count();
                                $minorRev = $reviews->where('recommendation', 'minor_revisions')->count();
                                $majorRev = $reviews->where('recommendation', 'major_revisions')->count();

                                $statusClass = match ($s->status) {
                                    'submitted' => 's-submitted',
                                    'under_review' => 's-review',
                                    'accepted' => 's-accepted',
                                    'rejected' => 's-rejected',
                                    'revisions_requested' => 's-revisions',
                                    default => 's-default',
                                };

                                $avatarColors = ['#0f4d45', '#1e7a6e', '#b8963e', '#2563eb', '#7c3aed', '#db2777'];
                                $avatarBg = $avatarColors[$loop->index % count($avatarColors)];
                                $initial = strtoupper(substr($s->author->name ?? '?', 0, 1));
                            @endphp

                            <tr
                                data-status="{{ $s->status }}"
                                data-title="{{ strtolower($s->title) }}"
                                data-author="{{ strtolower($s->author->name ?? '') }}"
                            >
                                <td>
                                    <div class="title-cell">
                                        <span class="title-index">
                                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <div>
                                            <div class="title-text">
                                                {{ Str::limit($s->title, 52) }}
                                            </div>
                                            @if ($s->research_field)
                                                <div class="title-field">
                                                    <svg
                                                        width="9"
                                                        height="9"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <circle
                                                            cx="12"
                                                            cy="12"
                                                            r="9"
                                                        />
                                                        <path
                                                            d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"
                                                        />
                                                    </svg>
                                                    {{ $s->research_field }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 9px;
                                        "
                                    >
                                        <div
                                            class="author-avatar"
                                            style="background: {{ $avatarBg }}"
                                        >
                                            {{ $initial }}
                                        </div>
                                        <div>
                                            <div class="author-name">
                                                {{ $s->author->name ?? '—' }}
                                            </div>
                                            @if ($s->created_at)
                                                <div class="author-date">
                                                    {{ $s->created_at->format('M d, Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="pill {{ $statusClass }}">
                                        <span class="pill-dot"></span>
                                        {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($completed > 0 || $pending > 0)
                                        <div class="review-badges">
                                            @if ($accepts > 0)
                                                <span class="rbadge rb-accept">
                                                    <svg
                                                        class="rb-icon"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2.5"
                                                    >
                                                        <path
                                                            d="M5 13l4 4L19 7"
                                                        />
                                                    </svg>
                                                    {{ $accepts }}
                                                </span>
                                            @endif

                                            @if ($rejects > 0)
                                                <span class="rbadge rb-reject">
                                                    <svg
                                                        class="rb-icon"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2.5"
                                                    >
                                                        <path
                                                            d="M6 18L18 6M6 6l12 12"
                                                        />
                                                    </svg>
                                                    {{ $rejects }}
                                                </span>
                                            @endif

                                            @if ($minorRev > 0)
                                                <span class="rbadge rb-minor">
                                                    <svg
                                                        class="rb-icon"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <path
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                        />
                                                    </svg>
                                                    {{ $minorRev }} minor
                                                </span>
                                            @endif

                                            @if ($majorRev > 0)
                                                <span class="rbadge rb-major">
                                                    <svg
                                                        class="rb-icon"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <path
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                                        />
                                                    </svg>
                                                    {{ $majorRev }} major
                                                </span>
                                            @endif

                                            @if ($pending > 0)
                                                <span class="rbadge rb-pending">
                                                    <svg
                                                        class="rb-icon"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <path
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                        />
                                                    </svg>
                                                    {{ $pending }} pending
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span
                                            style="
                                                font-size: 11px;
                                                color: #cbd5e1;
                                                font-weight: 500;
                                            "
                                        >
                                            No reviews yet
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a
                                        href="{{ route('editor.submission.show', $s) }}"
                                        class="btn-manage"
                                    >
                                        Manage
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <svg
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="#cbd5e1"
                                                stroke-width="1.5"
                                            >
                                                <path
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                />
                                            </svg>
                                        </div>
                                        <p
                                            style="
                                                font-size: 14px;
                                                font-weight: 600;
                                                color: #94a3b8;
                                                margin-bottom: 4px;
                                            "
                                        >
                                            No submissions found
                                        </p>
                                        <p
                                            style="
                                                font-size: 12px;
                                                color: #cbd5e1;
                                            "
                                        >
                                            Submissions will appear here once
                                            authors start uploading manuscripts.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- No results (filtered) --}}
            <div
                id="no-results"
                class="hidden"
                style="padding: 48px 24px; text-align: center"
            >
                <div class="empty-icon" style="margin: 0 auto 12px">
                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#cbd5e1"
                        stroke-width="1.5"
                    >
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                </div>
                <p style="font-size: 13px; font-weight: 600; color: #94a3b8">
                    No submissions match your search
                </p>
                <button
                    onclick="clearFilters()"
                    style="
                        margin-top: 10px;
                        font-size: 11px;
                        font-weight: 700;
                        color: var(--teal);
                        background: none;
                        border: none;
                        cursor: pointer;
                        text-decoration: underline;
                        text-underline-offset: 2px;
                    "
                >
                    Clear filters
                </button>
            </div>

            <div class="table-footer">
                <span class="rows-label" id="rows-count">
                    Showing
                    {{ $submissions->firstItem() }}–{{ $submissions->lastItem() }}
                    of {{ $submissions->total() }} submissions
                </span>
                <div>{{ $submissions->links() }}</div>
            </div>
        </div>

        {{-- ── Legend ── --}}
        <div class="legend-bar fade-up-3">
            <span class="legend-label">Reviews</span>
            <span class="rbadge rb-accept">
                <svg
                    class="rb-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path d="M5 13l4 4L19 7" />
                </svg>
                Accept
            </span>
            <span class="rbadge rb-reject">
                <svg
                    class="rb-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
                Reject
            </span>
            <span class="rbadge rb-minor">
                <svg
                    class="rb-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                    />
                </svg>
                Minor Rev.
            </span>
            <span class="rbadge rb-major">
                <svg
                    class="rb-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                    />
                </svg>
                Major Rev.
            </span>
            <span class="rbadge rb-pending">
                <svg
                    class="rb-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pending
            </span>

            <span style="margin-left: auto" class="legend-label">Status</span>
            <span
                class="pill s-submitted"
                style="font-size: 9px; padding: 3px 8px"
            >
                <span class="pill-dot"></span>
                Submitted
            </span>
            <span
                class="pill s-review"
                style="font-size: 9px; padding: 3px 8px"
            >
                <span class="pill-dot"></span>
                Under Review
            </span>
            <span
                class="pill s-accepted"
                style="font-size: 9px; padding: 3px 8px"
            >
                <span class="pill-dot"></span>
                Accepted
            </span>
            <span
                class="pill s-rejected"
                style="font-size: 9px; padding: 3px 8px"
            >
                <span class="pill-dot"></span>
                Rejected
            </span>
            <span
                class="pill s-revisions"
                style="font-size: 9px; padding: 3px 8px"
            >
                <span class="pill-dot"></span>
                Revisions
            </span>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const searchInput = document.getElementById('search-input');
        const statusFilter = document.getElementById('status-filter');
        const sortSelect = document.getElementById('sort-select');
        const tableBody = document.getElementById('table-body');
        const noResults = document.getElementById('no-results');
        const rowsCount = document.getElementById('rows-count');

        function getRows() {
            return Array.from(tableBody.querySelectorAll('tr[data-status]'));
        }

        function filterAndSort() {
            const query = searchInput.value.toLowerCase().trim();
            const status = statusFilter.value;
            const sort = sortSelect.value;

            let rows = getRows();

            // Filter
            let visible = rows.filter((row) => {
                const matchSearch =
                    !query ||
                    row.dataset.title.includes(query) ||
                    row.dataset.author.includes(query);
                const matchStatus = !status || row.dataset.status === status;
                return matchSearch && matchStatus;
            });

            // Sort
            if (sort === 'title') {
                visible.sort((a, b) =>
                    a.dataset.title.localeCompare(b.dataset.title),
                );
            } else if (sort === 'oldest') {
                visible.sort((a, b) => a.rowIndex - b.rowIndex);
            }
            // newest = default DOM order

            // Hide all, show matching
            rows.forEach((r) => (r.style.display = 'none'));
            visible.forEach((r) => (r.style.display = ''));

            // Reorder
            visible.forEach((r) => tableBody.appendChild(r));

            // Update row indices
            visible.forEach((r, i) => {
                const idx = r.querySelector('.title-index');
                if (idx) idx.textContent = String(i + 1).padStart(2, '0');
            });

            // No-results
            noResults.classList.toggle('hidden', visible.length > 0);
            if (rowsCount)
                rowsCount.textContent = `Showing ${visible.length} of ${rows.length} submissions`;
        }

        function clearFilters() {
            searchInput.value = '';
            statusFilter.value = '';
            sortSelect.value = 'newest';
            filterAndSort();
        }

        searchInput.addEventListener('input', filterAndSort);
        statusFilter.addEventListener('change', filterAndSort);
        sortSelect.addEventListener('change', filterAndSort);
    </script>
@endpush
