@php
    use App\Models\Submission;
@endphp

@extends('layouts.app')

@section('title', 'Chief Editor Dashboard')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-d: #236860;
            --gold: #c9a84c;
            --gold-l: #f0d678;
            --ink: #0d1628;
            --mist: #f5f0e8;
            --red: #dc2626;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }
        @keyframes pulse-teal {
            0% {
                box-shadow: 0 0 0 0 rgba(45, 129, 118, 0.5);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(45, 129, 118, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(45, 129, 118, 0);
            }
        }

        .fade-up {
            opacity: 0;
            animation: fadeUp 0.5s cubic-bezier(0.22, 0.68, 0, 1.2) forwards;
        }
        .fade-up-1 {
            opacity: 0;
            animation: fadeUp 0.5s 0.08s cubic-bezier(0.22, 0.68, 0, 1.2)
                forwards;
        }
        .fade-up-2 {
            opacity: 0;
            animation: fadeUp 0.5s 0.16s cubic-bezier(0.22, 0.68, 0, 1.2)
                forwards;
        }
        .fade-up-3 {
            opacity: 0;
            animation: fadeUp 0.5s 0.24s cubic-bezier(0.22, 0.68, 0, 1.2)
                forwards;
        }

        .shimmer-bar {
            background: linear-gradient(
                90deg,
                transparent,
                var(--gold),
                var(--gold-l),
                var(--gold),
                transparent
            );
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }
        .pulse-dot {
            animation: pulse-teal 2s infinite;
        }

        /* Stat cards */
        .stat-card {
            background: #fff;
            border: 1.5px solid #ede8e0;
            border-radius: 20px;
            padding: 22px 24px;
            position: relative;
            overflow: hidden;
            transition:
                border-color 0.2s,
                transform 0.15s,
                box-shadow 0.2s;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 72px;
            height: 72px;
            border-radius: 0 20px 0 72px;
            opacity: 0.07;
            transition: opacity 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(13, 22, 40, 0.1);
        }
        .stat-card:hover::after {
            opacity: 0.13;
        }

        .stat-card.c-teal {
        }
        .stat-card.c-teal:hover {
            border-color: var(--teal);
        }
        .stat-card.c-teal::after {
            background: var(--teal);
        }
        .stat-card.c-red {
        }
        .stat-card.c-red:hover {
            border-color: var(--red);
        }
        .stat-card.c-red::after {
            background: var(--red);
        }
        .stat-card.c-blue {
        }
        .stat-card.c-blue:hover {
            border-color: #3b82f6;
        }
        .stat-card.c-blue::after {
            background: #3b82f6;
        }
        .stat-card.c-emerald {
        }
        .stat-card.c-emerald:hover {
            border-color: #10b981;
        }
        .stat-card.c-emerald::after {
            background: #10b981;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .stat-icon.c-teal {
            background: rgba(45, 129, 118, 0.1);
        }
        .stat-icon.c-red {
            background: #fee2e2;
        }
        .stat-icon.c-blue {
            background: #dbeafe;
        }
        .stat-icon.c-emerald {
            background: #d1fae5;
        }

        .stat-number {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.6rem;
            line-height: 1;
            font-weight: 700;
            margin-top: 14px;
        }
        .stat-number.c-teal {
            color: var(--teal);
        }
        .stat-number.c-red {
            color: var(--red);
        }
        .stat-number.c-blue {
            color: #2563eb;
        }
        .stat-number.c-emerald {
            color: #059669;
        }

        /* Tab bar */
        .tab-bar {
            display: flex;
            align-items: flex-end;
            gap: 0;
            border-bottom: 1.5px solid #ede8e0;
            margin-bottom: 20px;
        }
        .tab-btn {
            position: relative;
            padding: 12px 20px 14px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #b0aaa0;
            background: none;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: color 0.2s;
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
            color: #6a7890;
        }

        .tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 9px;
            font-weight: 900;
            margin-left: 6px;
            vertical-align: middle;
        }
        .tab-count.red {
            background: #fee2e2;
            color: var(--red);
        }
        .tab-count.slate {
            background: #f1f5f9;
            color: #64748b;
        }
        .tab-count.amber {
            background: #fef3c7;
            color: #d97706;
        }

        .tab-panel {
            display: none;
        }
        .tab-panel.active {
            display: block;
        }

        /* Search + filter */
        .search-wrap {
            position: relative;
            background: #fff;
            border: 1.5px solid #e2ddd4;
            border-radius: 14px;
            display: flex;
            align-items: center;
            padding: 0 14px;
            transition:
                border-color 0.2s,
                box-shadow 0.2s;
        }
        .search-wrap:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(45, 129, 118, 0.1);
        }
        .search-wrap input {
            flex: 1;
            padding: 11px 10px;
            border: none;
            background: transparent;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink);
            outline: none;
        }
        .search-wrap input::placeholder {
            color: #b8b0a4;
        }

        .filter-select {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: #6a7890;
            background: #fff;
            border: 1.5px solid #e2ddd4;
            border-radius: 14px;
            padding: 11px 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .filter-select:focus {
            border-color: var(--teal);
        }

        /* Table card */
        .card {
            background: #fff;
            border: 1.5px solid #ede8e0;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(13, 22, 40, 0.06);
        }

        /* Tables */
        .ce-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ce-table thead tr {
            background: linear-gradient(to right, #faf8f5, #f5f0e8);
            border-bottom: 1.5px solid #ede8e0;
        }
        .ce-table thead th {
            padding: 13px 20px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: #b0aaa0;
            text-align: left;
            white-space: nowrap;
        }
        .ce-table thead th.sortable {
            cursor: pointer;
        }
        .ce-table thead th.sortable:hover {
            color: var(--teal);
        }
        .ce-table thead th:last-child {
            text-align: right;
        }
        .sort-icon {
            opacity: 0.35;
            margin-left: 3px;
            font-size: 10px;
            transition: opacity 0.15s;
        }
        .ce-table thead th.sortable:hover .sort-icon {
            opacity: 1;
        }

        .ce-table tbody tr {
            border-bottom: 1px solid #f0ece6;
            transition: background 0.15s;
        }
        .ce-table tbody tr:last-child {
            border-bottom: none;
        }
        .ce-table tbody tr:hover {
            background: #faf8f5;
        }
        .ce-table tbody tr:hover .row-title {
            color: var(--teal);
        }
        .ce-table td {
            padding: 15px 20px;
            vertical-align: middle;
        }

        .row-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--ink);
            transition: color 0.15s;
            line-height: 1.4;
        }

        /* Status badges */
        .s-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 100px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border: 1px solid transparent;
        }
        .s-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .s-badge.accepted {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #15803d;
        }
        .s-badge.accepted .dot {
            background: #16a34a;
        }
        .s-badge.rejected {
            background: #fff5f5;
            border-color: #fecaca;
            color: #b91c1c;
        }
        .s-badge.rejected .dot {
            background: #dc2626;
        }
        .s-badge.under_review {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }
        .s-badge.under_review .dot {
            background: #2563eb;
        }
        .s-badge.revisions {
            background: #fffbeb;
            border-color: #fde68a;
            color: #b45309;
        }
        .s-badge.revisions .dot {
            background: #d97706;
        }
        .s-badge.pending {
            background: #fef3c7;
            border-color: #fde68a;
            color: #d97706;
        }
        .s-badge.pending .dot {
            background: #f59e0b;
        }
        .s-badge.approved {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #15803d;
        }
        .s-badge.approved .dot {
            background: #16a34a;
        }
        .s-badge.default {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #475569;
        }
        .s-badge.default .dot {
            background: #94a3b8;
        }

        /* Field badge */
        .field-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 100px;
            background: rgba(45, 129, 118, 0.08);
            border: 1px solid rgba(45, 129, 118, 0.15);
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--teal);
        }

        /* Buttons */
        .btn-assign {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 16px;
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background: var(--teal);
            color: #fff;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 12px rgba(45, 129, 118, 0.2);
        }
        .btn-assign:hover {
            background: var(--teal-d);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(45, 129, 118, 0.3);
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--teal);
            text-decoration: none;
            transition: color 0.15s;
        }
        .btn-view:hover {
            color: var(--teal-d);
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: rgba(45, 129, 118, 0.08);
            color: var(--teal);
            transition: background 0.15s;
            text-decoration: none;
        }
        .btn-icon:hover {
            background: rgba(45, 129, 118, 0.18);
        }
        .btn-icon.slate {
            background: #f1f5f9;
            color: #64748b;
        }
        .btn-icon.slate:hover {
            background: #e2e8f0;
        }

        /* Empty / success states */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 56px 24px;
            text-align: center;
        }
        .empty-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 12px;
        }

        /* Pagination area */
        .table-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            border-top: 1px solid #ede8e0;
            background: #faf8f5;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px;
            color: #b0aaa0;
        }

        /* Section sub-heading */
        .sub-heading {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #b0aaa0;
            margin-bottom: 14px;
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen font-['Source_Sans_3']"
        style="
            background: linear-gradient(
                135deg,
                #f5f0e8 0%,
                #ede5d5 50%,
                #e8e0f0 100%
            );
        "
    >
        <div class="fixed top-0 left-0 right-0 h-0.5 shimmer-bar z-50"></div>

        <div class="max-w-6xl mx-auto py-10 px-4 space-y-6">
            {{-- ── Header ── --}}
            <div
                class="fade-up flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4"
            >
                <div>
                    <p
                        class="text-[10px] font-black uppercase tracking-[.2em] text-(--teal) mb-1 flex items-center gap-2"
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-(--teal) pulse-dot"
                        ></span>
                        Journal System · Chief Editor Portal
                    </p>
                    <h1
                        class="font-['Libre_Baskerville'] text-4xl font-bold text-(--ink) leading-tight"
                    >
                        Chief Editor
                        <em
                            class="not-italic bg-linear-to-r from-(--teal) to-[#1a6b62] bg-clip-text text-transparent"
                        >
                            Dashboard
                        </em>
                    </h1>
                    <p class="text-sm text-[#8a96a8] mt-1">
                        Manage submissions and assign editors
                    </p>
                </div>
                <span
                    class="px-4 py-2 bg-white/80 border border-[#ddd8ce] rounded-xl text-[11px] font-bold text-[#9ea8b8] uppercase tracking-widest backdrop-blur-sm hidden sm:block"
                >
                    {{ now()->format('D, M j Y') }}
                </span>
            </div>

            {{-- ── Stats Grid ── --}}
            <div class="fade-up-1 grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $cards = [
                        ['label' => 'Total Submissions', 'value' => $stats['total_submissions'], 'icon' => '📄', 'c' => 'c-teal'],
                        ['label' => 'Pending Assignment', 'value' => $stats['pending_assignments'], 'icon' => '⏳', 'c' => 'c-red'],
                        ['label' => 'Under Review', 'value' => $stats['under_review'], 'icon' => '👁️', 'c' => 'c-blue'],
                        ['label' => 'Completed', 'value' => $stats['completed'], 'icon' => '✓', 'c' => 'c-emerald'],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="stat-card {{ $card['c'] }}">
                        <div class="flex items-center justify-between">
                            <span
                                class="text-[9px] font-black uppercase tracking-[.15em] text-[#b0aaa0]"
                            >
                                {{ $card['label'] }}
                            </span>
                            <div class="stat-icon {{ $card['c'] }}">
                                {{ $card['icon'] }}
                            </div>
                        </div>
                        <p class="stat-number {{ $card['c'] }}">
                            {{ $card['value'] }}
                        </p>
                        <div class="mt-3 h-0.75 rounded-full bg-[#f0ece6]">
                            <div
                                class="h-full rounded-full {{ $card['c'] === 'c-teal' ? 'bg-(--teal)' : ($card['c'] === 'c-red' ? 'bg-(--red)' : ($card['c'] === 'c-blue' ? 'bg-blue-500' : 'bg-emerald-500')) }}"
                                style="
                                    width: {{ $stats['total_submissions'] ? min(100, ($card['value'] / $stats['total_submissions']) * 100) : 0 }}%;
                                "
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ── Tabbed Section ── --}}
            <div class="fade-up-2">
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
                    <button
                        class="tab-btn"
                        onclick="switchTab('assigned', this)"
                    >
                        Assigned
                        <span class="tab-count slate">
                            {{ $assignedSubmissions->total() }}
                        </span>
                    </button>
                    <button
                        class="tab-btn"
                        onclick="switchTab('appeals', this)"
                    >
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
                                class="w-4 h-4 text-[#c0b8b0] shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <circle cx="11" cy="11" r="8" />
                                <path
                                    d="m21 21-4.35-4.35"
                                    stroke-linecap="round"
                                />
                            </svg>
                            <input
                                type="text"
                                id="pending-search"
                                placeholder="Search by title or author…"
                                oninput="
                                    filterTable('pending-tbody', this.value)
                                "
                            />
                        </div>
                        <select
                            id="pending-field-filter"
                            class="filter-select"
                            onchange="
                                filterTable(
                                    'pending-tbody',
                                    document.getElementById('pending-search')
                                        .value,
                                )
                            "
                        >
                            <option value="">All Research Fields</option>
                            @foreach ($pendingSubmissions->unique('research_field')->pluck('research_field')->filter() as $field)
                                <option value="{{ $field }}">
                                    {{ $field }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if ($pendingSubmissions->count() > 0)
                        <div class="card">
                            <div class="overflow-x-auto">
                                <table class="ce-table">
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
                                                class="sortable"
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
                                                class="sortable"
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
                                                class="sortable"
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
                                                        {{ Str::limit($s->title, 48) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-sm text-[#6a7890]"
                                                    >
                                                        {{ $s->author->name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="field-badge">
                                                        <span
                                                            class="w-1.5 h-1.5 rounded-full bg-(--teal)"
                                                        ></span>
                                                        {{ $s->research_field ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-[11px] text-[#b0aaa0] font-mono"
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
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2.5"
                                                                d="M9 5l7 7-7 7"
                                                            />
                                                        </svg>
                                                        Review & Assign
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-foot">
                                <span>
                                    Showing
                                    {{ $pendingSubmissions->firstItem() }}–{{ $pendingSubmissions->lastItem() }}
                                    of {{ $pendingSubmissions->total() }}
                                </span>
                                <div>{{ $pendingSubmissions->links() }}</div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="empty-state">
                                <div class="empty-icon bg-emerald-50">✅</div>
                                <p
                                    class="font-['Libre_Baskerville'] font-bold text-(--ink) text-sm"
                                >
                                    All submissions assigned!
                                </p>
                                <p class="text-[12px] text-[#b0aaa0] mt-1">
                                    No pending submissions at this time.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ── ASSIGNED TAB ── --}}
                <div id="tab-assigned" class="tab-panel">
                    <div class="flex flex-col sm:flex-row gap-3 mb-4">
                        <div class="search-wrap flex-1">
                            <svg
                                class="w-4 h-4 text-[#c0b8b0] shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <circle cx="11" cy="11" r="8" />
                                <path
                                    d="m21 21-4.35-4.35"
                                    stroke-linecap="round"
                                />
                            </svg>
                            <input
                                type="text"
                                id="assigned-search"
                                placeholder="Search by title or editor…"
                                oninput="
                                    filterTable('assigned-tbody', this.value)
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
                                <option value="{{ $key }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if ($assignedSubmissions->count() > 0)
                        <div class="card">
                            <div class="overflow-x-auto">
                                <table class="ce-table">
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
                                                class="sortable"
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
                                                class="sortable"
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
                                                        {{ Str::limit($s->title, 48) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-sm text-[#6a7890]"
                                                    >
                                                        {{ $s->assignedEditor->name ?? '—' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="s-badge {{ $sc }}"
                                                    >
                                                        <span
                                                            class="dot"
                                                        ></span>
                                                        {{ Submission::statusOptions()[$s->status] ?? $s->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-[11px] text-[#b0aaa0] font-mono"
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
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2.5"
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
                            <div class="table-foot">
                                <span>
                                    Showing
                                    {{ $assignedSubmissions->firstItem() }}–{{ $assignedSubmissions->lastItem() }}
                                    of {{ $assignedSubmissions->total() }}
                                </span>
                                <div>
                                    {{ $assignedSubmissions->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="empty-state">
                                <div class="empty-icon bg-[#f5f0e8]">📄</div>
                                <p
                                    class="font-['Libre_Baskerville'] font-bold text-(--ink) text-sm"
                                >
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
                                class="w-4 h-4 text-[#c0b8b0] shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <circle cx="11" cy="11" r="8" />
                                <path
                                    d="m21 21-4.35-4.35"
                                    stroke-linecap="round"
                                />
                            </svg>
                            <input
                                type="text"
                                id="appeals-search"
                                placeholder="Search by title or author…"
                                oninput="
                                    filterTable('appeals-tbody', this.value)
                                "
                            />
                        </div>
                    </div>

                    @if ($pendingAppeals->count() > 0)
                        <div class="card mb-6">
                            <div class="overflow-x-auto">
                                <table class="ce-table">
                                    <thead>
                                        <tr>
                                            <th>Manuscript</th>
                                            <th>Author</th>
                                            <th>Submitted</th>
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
                                                        {{ Str::limit($appeal->submission->title, 48) }}
                                                    </p>
                                                    <p
                                                        class="text-[10px] text-[#b0aaa0] mt-0.5 font-mono"
                                                    >
                                                        #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p
                                                        class="text-sm font-semibold text-[#6a7890]"
                                                    >
                                                        {{ $appeal->author->name }}
                                                    </p>
                                                    <p
                                                        class="text-[10px] text-[#b0aaa0]"
                                                    >
                                                        {{ $appeal->author->email }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-sm text-[#6a7890]"
                                                    >
                                                        {{ $appeal->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="s-badge pending"
                                                    >
                                                        <span
                                                            class="dot"
                                                        ></span>
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
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                d="M9 5l7 7-7 7"
                                                                stroke-width="2"
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
                            <div class="table-foot">
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
                        <div class="card mb-6">
                            <div class="empty-state">
                                <div class="empty-icon bg-emerald-50">✅</div>
                                <p
                                    class="font-['Libre_Baskerville'] font-bold text-(--ink) text-sm"
                                >
                                    No pending appeals!
                                </p>
                                <p class="text-[12px] text-[#b0aaa0] mt-1">
                                    All appeals have been reviewed.
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Completed Appeals --}}
                    @if ($completedAppeals->count() > 0)
                        <div class="mt-2">
                            <p class="sub-heading">Completed Appeals</p>
                            <div class="card">
                                <div class="overflow-x-auto">
                                    <table class="ce-table">
                                        <thead>
                                            <tr>
                                                <th>Manuscript</th>
                                                <th>Author</th>
                                                <th>Decision</th>
                                                <th>Reviewed</th>
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
                                                            {{ Str::limit($appeal->submission->title, 48) }}
                                                        </p>
                                                        <p
                                                            class="text-[10px] text-[#b0aaa0] mt-0.5 font-mono"
                                                        >
                                                            #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p
                                                            class="text-sm font-semibold text-[#6a7890]"
                                                        >
                                                            {{ $appeal->author->name }}
                                                        </p>
                                                        <p
                                                            class="text-[10px] text-[#b0aaa0]"
                                                        >
                                                            {{ $appeal->author->email }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        @if ($appeal->status === 'approved')
                                                            <span
                                                                class="s-badge approved"
                                                            >
                                                                <span
                                                                    class="dot"
                                                                ></span>
                                                                Approved
                                                            </span>
                                                        @else
                                                            <span
                                                                class="s-badge rejected"
                                                            >
                                                                <span
                                                                    class="dot"
                                                                ></span>
                                                                Rejected
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p
                                                            class="text-sm text-[#6a7890]"
                                                        >
                                                            {{ $appeal->reviewed_at->format('M d, Y') }}
                                                        </p>
                                                        <p
                                                            class="text-[10px] text-[#b0aaa0]"
                                                        >
                                                            by
                                                            {{ $appeal->reviewedBy->name ?? 'System' }}
                                                        </p>
                                                    </td>
                                                    <td
                                                        style="
                                                            text-align: right;
                                                        "
                                                    >
                                                        <a
                                                            href="{{ route('appeals.show', $appeal) }}"
                                                            class="btn-icon slate"
                                                        >
                                                            <svg
                                                                class="w-4 h-4"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    d="M9 5l7 7-7 7"
                                                                    stroke-width="2"
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
                                <div class="table-foot">
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
                        </div>
                    @endif
                </div>
            </div>
            {{-- /tabbed section --}}

            <p
                class="text-center text-[10px] text-[#c0b8b0] uppercase tracking-widest fade-up-3"
            >
                BatStateU · BIRJISE Journal System
            </p>
        </div>
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
