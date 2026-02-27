@extends('layouts.app')

@section('title', 'Editor Dashboard')

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
            transition:
                border-color 0.2s,
                transform 0.15s,
                box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            border-radius: 0 20px 0 80px;
            opacity: 0.06;
            transition: opacity 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(13, 22, 40, 0.1);
        }
        .stat-card:hover::after {
            opacity: 0.1;
        }

        .stat-card.c-teal {
            border-color: #ede8e0;
        }
        .stat-card.c-teal:hover {
            border-color: var(--teal);
        }
        .stat-card.c-teal::after {
            background: var(--teal);
        }
        .stat-card.c-blue {
            border-color: #ede8e0;
        }
        .stat-card.c-blue:hover {
            border-color: #3b82f6;
        }
        .stat-card.c-blue::after {
            background: #3b82f6;
        }
        .stat-card.c-amber {
            border-color: #ede8e0;
        }
        .stat-card.c-amber:hover {
            border-color: #d97706;
        }
        .stat-card.c-amber::after {
            background: #d97706;
        }
        .stat-card.c-orange {
            border-color: #ede8e0;
        }
        .stat-card.c-orange:hover {
            border-color: #ea580c;
        }
        .stat-card.c-orange::after {
            background: #ea580c;
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
        .stat-icon.c-blue {
            background: #dbeafe;
        }
        .stat-icon.c-amber {
            background: #fef3c7;
        }
        .stat-icon.c-orange {
            background: #ffedd5;
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
        .stat-number.c-blue {
            color: #2563eb;
        }
        .stat-number.c-amber {
            color: #d97706;
        }
        .stat-number.c-orange {
            color: #ea580c;
        }

        /* Alert banner */
        .alert-banner {
            border-radius: 18px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            border: 1.5px solid #fed7aa;
            background: linear-gradient(135deg, #fff7ed 0%, #fffbeb 100%);
            box-shadow: 0 4px 20px rgba(234, 88, 12, 0.08);
        }

        /* Table card */
        .card {
            background: #fff;
            border: 1.5px solid #ede8e0;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(13, 22, 40, 0.06);
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 22px;
            border-bottom: 1px solid #ede8e0;
            background: linear-gradient(to right, #faf8f5, #f5f0e8);
        }

        /* Table */
        .ed-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ed-table thead tr {
            background: linear-gradient(to right, #faf8f5, #f5f0e8);
            border-bottom: 1.5px solid #ede8e0;
        }
        .ed-table thead th {
            padding: 13px 22px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: #b0aaa0;
            text-align: left;
        }
        .ed-table thead th:last-child {
            text-align: right;
        }
        .ed-table tbody tr {
            border-bottom: 1px solid #f0ece6;
            transition: background 0.15s;
        }
        .ed-table tbody tr:last-child {
            border-bottom: none;
        }
        .ed-table tbody tr:hover {
            background: #faf8f5;
        }
        .ed-table tbody tr:hover .ms-title {
            color: var(--teal);
        }
        .ed-table td {
            padding: 15px 22px;
            vertical-align: middle;
        }

        .ms-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--ink);
            transition: color 0.15s;
            line-height: 1.4;
        }
        .ms-author {
            font-size: 0.82rem;
            color: #6a7890;
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
        .s-badge.submitted {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }
        .s-badge.submitted .dot {
            background: #2563eb;
        }
        .s-badge.under_review {
            background: #fffbeb;
            border-color: #fde68a;
            color: #b45309;
        }
        .s-badge.under_review .dot {
            background: #d97706;
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
        .s-badge.revision {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #c2410c;
        }
        .s-badge.revision .dot {
            background: #ea580c;
        }
        .s-badge.default {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #475569;
        }
        .s-badge.default .dot {
            background: #94a3b8;
        }

        /* Buttons */
        .btn-manage {
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
        .btn-manage:hover {
            background: var(--teal-d);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(45, 129, 118, 0.3);
        }

        .btn-view-all {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 12px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
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

        .btn-review-now {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 12px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background: #ea580c;
            color: #fff;
            text-decoration: none;
            white-space: nowrap;
            transition:
                background 0.15s,
                transform 0.12s;
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);
        }
        .btn-review-now:hover {
            background: #c2410c;
            transform: translateY(-1px);
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 24px;
            text-align: center;
        }
        .empty-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: #f5f0e8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 12px;
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
        <div class="fixed top-0 left-0 right-0 h-[2px] shimmer-bar z-50"></div>

        <div class="max-w-6xl mx-auto py-10 px-4 space-y-6">
            {{-- ── Header ── --}}
            <div
                class="fade-up flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p
                        class="text-[10px] font-black uppercase tracking-[.2em] text-[var(--teal)] mb-1 flex items-center gap-2"
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-[var(--teal)] pulse-dot"
                        ></span>
                        Journal System · Editor Portal
                    </p>
                    <h1
                        class="font-['Libre_Baskerville'] text-4xl font-bold text-[var(--ink)] leading-tight"
                    >
                        Editor
                        <em
                            class="not-italic bg-gradient-to-r from-[var(--teal)] to-[#1a6b62] bg-clip-text text-transparent"
                        >
                            Dashboard
                        </em>
                    </h1>
                    <p class="text-sm text-[#8a96a8] mt-1">
                        Review and manage submissions
                    </p>
                </div>
                <span
                    class="px-4 py-2 bg-white/80 border border-[#ddd8ce] rounded-xl text-[11px] font-bold text-[#9ea8b8] uppercase tracking-widest backdrop-blur-sm hidden sm:inline-block"
                >
                    {{ now()->format('D, M j Y') }}
                </span>
            </div>

            {{-- ── Stats Grid ── --}}
            <div class="fade-up-1 grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="stat-card c-teal">
                    <div class="flex items-center justify-between">
                        <span
                            class="text-[9px] font-black uppercase tracking-[.15em] text-[#b0aaa0]"
                        >
                            Total
                        </span>
                        <div class="stat-icon c-teal">📊</div>
                    </div>
                    <p class="stat-number c-teal">{{ $stats['total'] }}</p>
                    <p class="text-[11px] text-[#b0aaa0] mt-1.5">
                        All submissions
                    </p>
                    <div
                        class="mt-3 h-[3px] rounded-full bg-[rgba(45,129,118,.1)]"
                    >
                        <div
                            class="h-full rounded-full bg-[var(--teal)]"
                            style="width: 100%"
                        ></div>
                    </div>
                </div>
                <div class="stat-card c-blue">
                    <div class="flex items-center justify-between">
                        <span
                            class="text-[9px] font-black uppercase tracking-[.15em] text-[#b0aaa0]"
                        >
                            New
                        </span>
                        <div class="stat-icon c-blue">📥</div>
                    </div>
                    <p class="stat-number c-blue">{{ $stats['submitted'] }}</p>
                    <p class="text-[11px] text-[#b0aaa0] mt-1.5">
                        Awaiting distribution
                    </p>
                    <div class="mt-3 h-[3px] rounded-full bg-blue-100">
                        <div
                            class="h-full rounded-full bg-blue-500"
                            style="
                                width: {{ $stats['total'] ? min(100, ($stats['submitted'] / $stats['total']) * 100) : 0 }}%;
                            "
                        ></div>
                    </div>
                </div>
                <div class="stat-card c-amber">
                    <div class="flex items-center justify-between">
                        <span
                            class="text-[9px] font-black uppercase tracking-[.15em] text-[#b0aaa0]"
                        >
                            Under Review
                        </span>
                        <div class="stat-icon c-amber">📋</div>
                    </div>
                    <p class="stat-number c-amber">
                        {{ $stats['under_review'] }}
                    </p>
                    <p class="text-[11px] text-[#b0aaa0] mt-1.5">
                        With reviewers
                    </p>
                    <div class="mt-3 h-[3px] rounded-full bg-amber-100">
                        <div
                            class="h-full rounded-full bg-amber-500"
                            style="
                                width: {{ $stats['total'] ? min(100, ($stats['under_review'] / $stats['total']) * 100) : 0 }}%;
                            "
                        ></div>
                    </div>
                </div>
                <div class="stat-card c-orange">
                    <div class="flex items-center justify-between">
                        <span
                            class="text-[9px] font-black uppercase tracking-[.15em] text-[#b0aaa0]"
                        >
                            Revisions
                        </span>
                        <div class="stat-icon c-orange">🔄</div>
                    </div>
                    <p class="stat-number c-orange">
                        {{ $stats['revision_under_review'] }}
                    </p>
                    <p class="text-[11px] text-[#b0aaa0] mt-1.5">
                        Awaiting re-review
                    </p>
                    <div class="mt-3 h-[3px] rounded-full bg-orange-100">
                        <div
                            class="h-full rounded-full bg-orange-500"
                            style="
                                width: {{ $stats['total'] ? min(100, ($stats['revision_under_review'] / $stats['total']) * 100) : 0 }}%;
                            "
                        ></div>
                    </div>
                </div>
            </div>

            {{-- ── Revision Alert ── --}}
            @if ($stats['revision_under_review'] > 0)
                <div class="fade-up-2 alert-banner">
                    <div class="flex items-center gap-4 min-w-0">
                        <div
                            class="w-11 h-11 rounded-xl bg-orange-100 border border-orange-200 flex items-center justify-center text-xl flex-shrink-0"
                        >
                            🔄
                        </div>
                        <div class="min-w-0">
                            <p
                                class="font-['Libre_Baskerville'] font-bold text-[#7c2d12] text-base"
                            >
                                Revision Reviews Pending
                            </p>
                            <p class="text-sm text-orange-700 mt-0.5">
                                {{ $stats['revision_under_review'] }}
                                {{ $stats['revision_under_review'] === 1 ? 'manuscript' : 'manuscripts' }}
                                awaiting your final decision
                            </p>
                        </div>
                    </div>
                    @if ($submissions->first())
                        <a
                            href="{{ route('editor.submission.show', $submissions->first()) }}"
                            class="btn-review-now flex-shrink-0"
                        >
                            Review Now →
                        </a>
                    @endif
                </div>
            @endif

            {{-- ── Table Card ── --}}
            <div class="fade-up-3 card">
                <div class="card-header">
                    <div>
                        <p
                            class="text-[9px] font-black uppercase tracking-[.18em] text-[#b0aaa0]"
                        >
                            Submissions
                        </p>
                        <h2
                            class="font-['Libre_Baskerville'] text-base font-bold text-[var(--ink)]"
                        >
                            Recent Submissions
                        </h2>
                    </div>
                    <a
                        href="{{ route('editor.submissions') }}"
                        class="btn-view-all"
                    >
                        View All →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="ed-table">
                        <thead>
                            <tr>
                                <th style="width: 45%">Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th style="text-align: right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($submissions as $s)
                                <tr class="group">
                                    <td>
                                        <p class="ms-title">
                                            {{ Str::limit($s->title, 48) }}
                                        </p>
                                    </td>
                                    <td>
                                        <span class="ms-author">
                                            {{ $s->author->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $cls = match ($s->status) {
                                                'submitted' => 'submitted',
                                                'under_review' => 'under_review',
                                                'accepted' => 'accepted',
                                                'rejected' => 'rejected',
                                                'revision' => 'revision',
                                                default => 'default',
                                            };
                                        @endphp

                                        <span class="s-badge {{ $cls }}">
                                            <span class="dot"></span>
                                            {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                                        </span>
                                    </td>
                                    <td style="text-align: right">
                                        <a
                                            href="{{ route('editor.submission.show', $s) }}"
                                            class="btn-manage"
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
                                            Manage
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <div class="empty-icon">📄</div>
                                            <p
                                                class="font-['Libre_Baskerville'] font-bold text-[var(--ink)] text-sm"
                                            >
                                                No submissions yet
                                            </p>
                                            <p
                                                class="text-[12px] text-[#b0aaa0] mt-1"
                                            >
                                                Submissions will appear here
                                                once received.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div
                    class="px-5 py-3 border-t border-[#ede8e0] bg-[#faf8f5] flex items-center justify-between"
                >
                    <div class="text-sm text-[#b0aaa0]">
                        {{ $submissions->links() }}
                    </div>
                    <p
                        class="text-[10px] text-[#c0b8b0] uppercase tracking-widest"
                    >
                        BatStateU · BIRJISE
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
