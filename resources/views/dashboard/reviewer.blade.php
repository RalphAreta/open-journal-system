@extends('layouts.app')

@section('title', 'Reviewer Dashboard')

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
            grid-template-columns: repeat(2, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
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
        .sv-red {
            color: var(--red);
        }
        .sv-emerald {
            color: var(--teal-dk);
        }
        .al-red {
            background: var(--red);
        }
        .al-emerald {
            background: var(--teal-dk);
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
        .section-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--red);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 800;
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

        /* ── Invitation cards ── */
        .invite-card {
            background: #fff;
            border: 1.5px solid #fecaca;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(192, 57, 43, 0.06);
            transition:
                transform 0.18s,
                box-shadow 0.18s;
        }
        .invite-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(192, 57, 43, 0.1);
        }
        .invite-tag {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--red);
            background: var(--red-lt);
            border: 1px solid #fecaca;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .invite-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.4;
            margin-bottom: 4px;
        }
        .invite-meta {
            font-size: 0.78rem;
            color: var(--ink-soft);
        }
        .invite-meta strong {
            color: var(--ink-mid);
            font-weight: 600;
        }
        .invite-meta .field {
            color: var(--teal);
            font-weight: 600;
        }

        /* Deadline bar */
        .due-bar-wrap {
            height: 3px;
            background: var(--border);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 6px;
        }
        .due-bar {
            height: 100%;
            border-radius: 3px;
        }
        .due-ok {
            background: var(--teal);
        }
        .due-soon {
            background: var(--gold);
        }
        .due-overdue {
            background: var(--red);
        }

        /* Invite action buttons */
        .btn-accept {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--teal);
            color: #fff;
            border: none;
            cursor: pointer;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 12px rgba(45, 129, 118, 0.25);
        }
        .btn-accept:hover {
            background: var(--teal-dk);
            transform: translateY(-1px);
        }
        .btn-decline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: #fff;
            color: var(--ink-soft);
            border: 1.5px solid var(--border-dk);
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-decline:hover {
            background: var(--red-lt);
            color: var(--red);
            border-color: #fecaca;
        }

        /* ── Notifications ── */
        .notif-card {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        .notif-head {
            padding: 14px 22px 12px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 22px;
            border-bottom: 1px solid #f5f0e8;
            transition: background 0.12s;
        }
        .notif-item:last-child {
            border-bottom: none;
        }
        .notif-item:hover {
            background: var(--teal-lt);
        }
        .notif-item.unread {
            background: #fff8f8;
        }
        .notif-item.unread:hover {
            background: var(--teal-lt);
        }
        .notif-unread-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--red);
            flex-shrink: 0;
            margin-top: 6px;
        }
        .notif-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--ink);
        }
        .notif-msg {
            font-size: 0.78rem;
            color: var(--ink-soft);
            line-height: 1.5;
            margin-top: 2px;
        }
        .notif-time {
            font-size: 0.68rem;
            color: #c9b99a;
            white-space: nowrap;
        }
        .notif-link {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--teal);
            text-decoration: none;
            margin-top: 4px;
            display: inline-block;
        }
        .notif-link:hover {
            color: var(--teal-dk);
        }
        .btn-toggle-notif {
            width: 100%;
            padding: 11px;
            background: var(--parchment);
            border-top: 1px solid var(--border);
            border: none;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
            cursor: pointer;
            transition:
                background 0.15s,
                color 0.15s;
        }
        .btn-toggle-notif:hover {
            background: var(--teal-lt);
            color: var(--teal);
        }

        /* ── Tables ── */
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
            cursor: default;
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
            line-height: 1.4;
            transition: color 0.12s;
        }
        .ms-author {
            font-size: 0.76rem;
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
        .sbadge.completed {
            background: #f0fdf4;
            border-color: #86efac;
            color: var(--teal-dk);
        }
        .sbadge.completed .dot {
            background: var(--teal);
        }
        .sbadge.accepted,
        .sbadge.assigned {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.accepted .dot,
        .sbadge.assigned .dot {
            background: var(--teal);
        }
        .sbadge.amber {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.amber .dot {
            background: var(--gold);
        }
        .sbadge.orange {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #9a3412;
        }
        .sbadge.orange .dot {
            background: #f97316;
        }
        .sbadge.default {
            background: var(--parchment);
            border-color: var(--border);
            color: var(--ink-soft);
        }
        .sbadge.default .dot {
            background: var(--border-dk);
        }

        /* Deadline text */
        .due-overdue-text {
            color: var(--red);
            font-weight: 700;
        }
        .due-soon-text {
            color: var(--gold-dk);
            font-weight: 700;
        }
        .due-ok-text {
            color: var(--teal-dk);
            font-weight: 700;
        }
        .due-sub {
            font-size: 0.72rem;
            color: var(--ink-soft);
            margin-top: 2px;
        }

        /* Action buttons */
        .btn-submit-review {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--red);
            color: #fff;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 3px 10px rgba(192, 57, 43, 0.2);
        }
        .btn-submit-review:hover {
            background: #a93226;
            transform: translateY(-1px);
        }
        .btn-revision-review {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--gold-dk);
            color: #fff;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s;
            box-shadow: 0 3px 10px rgba(138, 110, 40, 0.2);
        }
        .btn-revision-review:hover {
            background: #6e5820;
            transform: translateY(-1px);
        }
        .btn-peer-reviews {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 6px 12px;
            border-radius: 5px;
            background: #fff;
            color: var(--ink-soft);
            border: 1.5px solid var(--border-dk);
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-peer-reviews:hover {
            background: var(--teal-lt);
            color: var(--teal);
            border-color: var(--teal);
        }
        .btn-all-pending {
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
        .btn-all-pending:hover {
            background: var(--teal);
            transform: translateY(-1px);
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
            font-size: 0.78rem;
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
    <div class="aw aw-bg max-w-7xl mx-auto px-4">
        {{-- ── Hero ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Reviewer Dashboard</p>
                    <h1 class="hero-title">
                        <em>Review</em>
                        Assignments
                    </h1>
                    <p class="hero-sub">
                        Track and complete your peer review responsibilities
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
                <p class="stat-lbl">Pending Reviews</p>
                <p class="stat-val sv-red">
                    {{ sprintf('%02d', $stats['pending']) }}
                </p>
                <p class="stat-sub">Awaiting your submission</p>
                <div class="accent-line al-red"></div>
            </div>
            <div class="stat-cell">
                <p class="stat-lbl">Completed</p>
                <p class="stat-val sv-emerald">
                    {{ sprintf('%02d', $stats['completed']) }}
                </p>
                <p class="stat-sub">Successfully submitted</p>
                <div class="accent-line al-emerald"></div>
            </div>
        </div>

        {{-- ── Pending Invitations ── --}}
        @if ($pendingInvitations->count() > 0)
            <div class="fu2 mb-8">
                <div class="section-label">
                    Review Invitations
                    <span class="section-count">
                        {{ $pendingInvitations->count() }}
                    </span>
                </div>

                <div class="flex flex-col gap-4">
                    @foreach ($pendingInvitations as $a)
                        @php
                            $dueDate = $a->due_at ? \Carbon\Carbon::parse($a->due_at) : null;
                            $daysLeft = $dueDate ? (int) now()->diffInDays($dueDate, false) : null;
                            $dueCls = $daysLeft === null ? '' : ($daysLeft < 0 ? 'due-overdue' : ($daysLeft <= 7 ? 'due-soon' : 'due-ok'));
                            $barPct = $dueDate ? max(0, min(100, ($daysLeft / 30) * 100)) : 0;
                        @endphp

                        <div class="invite-card">
                            <div
                                class="flex flex-col sm:flex-row sm:items-start gap-5"
                            >
                                <div class="flex-1 min-w-0">
                                    <span class="invite-tag">
                                        New Invitation
                                    </span>
                                    <p class="invite-title">
                                        {{ Str::limit($a->submission->title ?? 'Untitled', 70) }}
                                    </p>
                                    <p class="invite-meta">
                                        by
                                        <strong>
                                            {{ $a->submission->author->name ?? '—' }}
                                        </strong>
                                        @if ($a->submission->research_field)
                                            ·
                                            <span class="field">
                                                {{ $a->submission->research_field }}
                                            </span>
                                        @endif
                                    </p>

                                    @if ($dueDate)
                                        <div class="mt-4">
                                            <div
                                                class="flex items-center justify-between mb-1"
                                            >
                                                <span
                                                    style="
                                                        font-size: 0.66rem;
                                                        font-weight: 700;
                                                        letter-spacing: 0.1em;
                                                        text-transform: uppercase;
                                                        color: var(--ink-soft);
                                                    "
                                                >
                                                    Review Deadline
                                                </span>
                                                <span
                                                    style="
                                                        font-size: 0.74rem;
                                                        font-weight: 700;
                                                        color: var(--ink-soft);
                                                    "
                                                >
                                                    @if ($daysLeft < 0)
                                                        <span
                                                            style="
                                                                color: var(
                                                                    --red
                                                                );
                                                            "
                                                        >
                                                            Overdue
                                                        </span>
                                                        ·
                                                        {{ $dueDate->format('M d, Y') }}
                                                    @elseif ($daysLeft === 0)
                                                        <span
                                                            style="
                                                                color: var(
                                                                    --red
                                                                );
                                                            "
                                                        >
                                                            Due Today
                                                        </span>
                                                        ·
                                                        {{ $dueDate->format('g:i A') }}
                                                    @else
                                                        {{ $dueDate->format('M d, Y') }}
                                                        ·
                                                        <span
                                                            style="
                                                                color: var(
                                                                    --red
                                                                );
                                                            "
                                                        >
                                                            {{ $daysLeft }}d
                                                            left
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="due-bar-wrap">
                                                <div
                                                    class="due-bar {{ $dueCls }}"
                                                    style="
                                                        width: {{ $barPct }}%;
                                                    "
                                                ></div>
                                            </div>
                                        </div>
                                    @else
                                        <p
                                            style="
                                                font-size: 0.76rem;
                                                color: var(--ink-soft);
                                                margin-top: 8px;
                                            "
                                        >
                                            No deadline set
                                        </p>
                                    @endif
                                </div>

                                <div class="flex sm:flex-col gap-2 sm:w-36">
                                    <form
                                        method="POST"
                                        action="{{ route('reviewer.invitation.accept', $a) }}"
                                        class="w-full"
                                    >
                                        @csrf
                                        <button
                                            type="submit"
                                            class="btn-accept"
                                        >
                                            <svg
                                                class="w-3.5 h-3.5"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                            Accept
                                        </button>
                                    </form>
                                    <form
                                        id="decline-form-{{ $a->id }}"
                                        method="POST"
                                        action="{{ route('reviewer.invitation.decline', $a) }}"
                                        style="display: none"
                                    >
                                        @csrf
                                        <textarea
                                            name="decline_reason"
                                            id="decline-reason-{{ $a->id }}"
                                            style="display: none"
                                        ></textarea>
                                    </form>
                                    <button
                                        type="button"
                                        class="btn-decline"
                                        onclick="
                                            declineInvitation(
                                                event,
                                                {{ $a->id }},
                                                '{{ addslashes($a->submission->title ?? 'this invitation') }}',
                                            )
                                        "
                                    >
                                        <svg
                                            class="w-3.5 h-3.5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                        Decline
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Revised Manuscripts ── --}}
        @if ($revisionReviews->count() > 0)
            <div class="fu2 ms-table-wrap mb-8">
                <div class="ms-table-head">
                    <div>
                        <p class="ms-table-head-eyebrow">Needs Attention</p>
                        <span class="ms-table-head-title">
                            Revised Manuscripts
                        </span>
                    </div>
                    <span
                        style="
                            width: 28px;
                            height: 28px;
                            border-radius: 50%;
                            background: var(--gold-dk);
                            color: #fff;
                            font-size: 0.72rem;
                            font-weight: 800;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        "
                    >
                        {{ $revisionReviews->count() }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="mst">
                        <thead>
                            <tr>
                                <th style="width: 35%">Manuscript</th>
                                <th>Author</th>
                                <th>Type</th>
                                <th>Deadline</th>
                                <th style="text-align: right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($revisionReviews as $rr)
                                @php
                                    $daysLeft = $rr->due_at ? (int) now()->diffInDays($rr->due_at, false) : null;
                                @endphp

                                <tr>
                                    <td>
                                        <p class="ms-row-title">
                                            {{ Str::limit($rr->revisionRequest->submission->title, 50) }}
                                        </p>
                                        <p class="ms-author">
                                            {{ $rr->revisionRequest->submission->author->name ?? '—' }}
                                        </p>
                                    </td>
                                    <td>
                                        <span
                                            style="
                                                font-size: 0.8rem;
                                                color: var(--ink-soft);
                                            "
                                        >
                                            {{ $rr->revisionRequest->submission->author->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($rr->revisionRequest->revision_type === 'minor')
                                            <span class="sbadge amber">
                                                <span class="dot"></span>
                                                Minor
                                            </span>
                                        @else
                                            <span class="sbadge orange">
                                                <span class="dot"></span>
                                                Major
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($rr->status === 'completed')
                                            <p
                                                class="due-ok-text"
                                                style="font-size: 0.78rem"
                                            >
                                                Submitted
                                            </p>
                                            <p class="due-sub">
                                                {{ $rr->completed_at?->format('M d, Y') ?? 'N/A' }}
                                            </p>
                                        @elseif ($rr->due_at)
                                            @if ($daysLeft < 0)
                                                <p
                                                    class="due-overdue-text"
                                                    style="font-size: 0.78rem"
                                                >
                                                    Overdue
                                                </p>
                                                <p class="due-sub">
                                                    {{ $rr->due_at->format('M d, Y') }}
                                                </p>
                                            @elseif ($daysLeft === 0)
                                                <p
                                                    class="due-soon-text"
                                                    style="font-size: 0.78rem"
                                                >
                                                    Due Today
                                                </p>
                                            @else
                                                <p
                                                    class="due-ok-text"
                                                    style="font-size: 0.78rem"
                                                >
                                                    {{ $rr->due_at->format('M d, Y') }}
                                                </p>
                                                <p class="due-sub">
                                                    {{ $daysLeft }}d remaining
                                                </p>
                                            @endif
                                        @else
                                            <span
                                                style="color: var(--border-dk)"
                                            >
                                                —
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: right">
                                        <a
                                            href="{{ route('reviews.revision-review-create', $rr) }}"
                                            class="btn-revision-review"
                                        >
                                            <svg
                                                class="w-3.5 h-3.5"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- ── Active Assignments ── --}}
        <div class="fu3 ms-table-wrap mb-12">
            <div class="ms-table-head">
                <div>
                    <p class="ms-table-head-eyebrow">Your Workload</p>
                    <span class="ms-table-head-title">
                        My Review Assignments
                    </span>
                </div>
                <a
                    href="{{ route('reviewer.pending-assignments') }}"
                    class="btn-all-pending"
                >
                    All Pending →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="mst">
                    <thead>
                        <tr>
                            <th style="width: 35%">Submission</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assignments as $a)
                            @php
                                $dueDate = $a->due_at ? \Carbon\Carbon::parse($a->due_at) : null;
                                $daysLeft = $dueDate ? (int) now()->diffInDays($dueDate, false) : null;
                            @endphp

                            <tr>
                                <td>
                                    <p class="ms-row-title">
                                        {{ Str::limit($a->submission->title ?? '', 50) }}
                                    </p>
                                    <p class="ms-author">
                                        {{ $a->submission->author->name ?? '—' }}
                                    </p>
                                </td>
                                <td>
                                    @if ($a->status === 'completed')
                                        <p
                                            class="due-ok-text"
                                            style="font-size: 0.78rem"
                                        >
                                            Submitted
                                        </p>
                                        <p class="due-sub">
                                            {{ $a->completed_at?->format('M d, Y') ?? 'N/A' }}
                                        </p>
                                    @elseif ($dueDate)
                                        @if ($daysLeft < 0)
                                            <p
                                                class="due-overdue-text"
                                                style="font-size: 0.78rem"
                                            >
                                                Overdue ·
                                                {{ $dueDate->format('M d') }}
                                            </p>
                                            <p class="due-sub">
                                                {{ abs($daysLeft) }}d overdue
                                            </p>
                                        @elseif ($daysLeft === 0)
                                            <p
                                                class="due-soon-text"
                                                style="font-size: 0.78rem"
                                            >
                                                Due Today ·
                                                {{ $dueDate->format('g:i A') }}
                                            </p>
                                        @else
                                            <p
                                                class="due-ok-text"
                                                style="font-size: 0.78rem"
                                            >
                                                {{ $dueDate->format('M d, Y') }}
                                            </p>
                                            <p class="due-sub">
                                                {{ $daysLeft }}d remaining
                                            </p>
                                        @endif
                                    @else
                                        <span
                                            style="
                                                font-size: 0.78rem;
                                                color: var(--border-dk);
                                            "
                                        >
                                            No deadline
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeCls = match ($a->status) {
                                            'completed' => 'completed',
                                            'assigned', 'accepted' => 'accepted',
                                            default => 'default',
                                        };
                                        $badgeLbl = match ($a->status) {
                                            'assigned' => 'Accepted',
                                            default => ucfirst($a->status),
                                        };
                                    @endphp

                                    <span class="sbadge {{ $badgeCls }}">
                                        <span class="dot"></span>
                                        {{ $badgeLbl }}
                                    </span>
                                </td>
                                <td style="text-align: right">
                                    @if (in_array($a->status, ['assigned', 'accepted']))
                                        <a
                                            href="{{ route('reviews.create', ['assignment' => $a]) }}"
                                            class="btn-submit-review"
                                        >
                                            <svg
                                                class="w-3.5 h-3.5"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                            Submit Review
                                        </a>
                                    @else
                                        <div
                                            class="flex flex-col items-end gap-2"
                                        >
                                            <span
                                                style="
                                                    font-size: 0.72rem;
                                                    font-weight: 800;
                                                    color: var(--teal-dk);
                                                "
                                            >
                                                ✓ Done
                                            </span>
                                            <a
                                                href="{{ route('reviews.peer-reviews', $a->submission) }}"
                                                class="btn-peer-reviews"
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
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />
                                                </svg>
                                                Peer Reviews
                                            </a>
                                        </div>
                                    @endif
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
                                            No active assignments
                                        </p>
                                        <p
                                            style="
                                                font-size: 0.84rem;
                                                color: #b5a595;
                                                margin-top: 6px;
                                            "
                                        >
                                            New assignments will appear here.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="text-sm">{{ $assignments->links() }}</div>
                <span class="table-footer-brand">BatStateU · BIRJISE</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function markRead(id) {
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
            });
        }

        function toggleMoreNotifications() {
            const more = document.getElementById('moreNotifications');
            const moreText = document.getElementById('seeMoreText');
            const lessText = document.getElementById('seeLessText');
            const hidden = more.classList.toggle('hidden');
            moreText.classList.toggle('hidden', !hidden);
            lessText.classList.toggle('hidden', hidden);
        }

        /* ── Enhanced styles injected once ── */
        (function injectSwalStyles() {
            if (document.getElementById('swal-custom-styles')) return;
            const s = document.createElement('style');
            s.id = 'swal-custom-styles';
            s.textContent = `
            /* Popup shell */
            .swal-decline-popup {
                border-radius: 20px !important;
                padding: 0 !important;
                overflow: hidden !important;
                box-shadow: 0 32px 80px rgba(26,18,9,.22) !important;
                border: 1.5px solid #e8dfd0 !important;
                font-family: 'Source Sans 3', sans-serif !important;
                max-width: 520px !important;
            }

            /* Teal accent bar at top */
            .swal-decline-popup::before {
                content: '';
                display: block;
                height: 4px;
                background: linear-gradient(90deg, #2d8176, #c9a84c, #2d8176);
                background-size: 200% 100%;
                animation: swalShimmer 3s linear infinite;
            }
            @keyframes swalShimmer {
                0%   { background-position: 0% 0; }
                100% { background-position: 200% 0; }
            }

            /* Icon area */
            .swal-decline-popup .swal2-icon {
                border-color: #fecaca !important;
                color: #c0392b !important;
                margin: 28px auto 0 !important;
                width: 52px !important;
                height: 52px !important;
            }
            .swal-decline-popup .swal2-icon .swal2-icon-content {
                font-size: 28px !important;
            }

            /* Title */
            .swal-decline-popup .swal2-title {
                font-family: 'Libre Baskerville', serif !important;
                font-size: 1.4rem !important;
                font-weight: 700 !important;
                color: #1a1209 !important;
                padding: 10px 32px 0 !important;
                letter-spacing: -.01em !important;
            }

            /* HTML content area */
            .swal-decline-popup .swal2-html-container {
                margin: 0 !important;
                padding: 0 32px 4px !important;
                font-size: .92rem !important;
                color: #6b5740 !important;
                line-height: 1.6 !important;
            }

            /* Reason list container */
            .swal-reasons-wrap {
                background: #faf6ef;
                border: 1px solid #e8dfd0;
                border-radius: 12px;
                padding: 6px 4px;
                margin: 12px 0 0;
            }

            /* Each reason row */
            .swal-reason-row {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 14px;
                border-radius: 8px;
                cursor: pointer;
                transition: background .13s;
                margin: 2px 0;
            }
            .swal-reason-row:hover {
                background: #e8f4f2;
            }
            .swal-reason-row.selected {
                background: #e8f4f2;
                outline: 1.5px solid rgba(45,129,118,.35);
            }

            /* Custom radio dot */
            .swal-radio-dot {
                width: 18px;
                height: 18px;
                border-radius: 50%;
                border: 2px solid #c9b99a;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: border-color .13s;
            }
            .swal-reason-row.selected .swal-radio-dot {
                border-color: #2d8176;
            }
            .swal-radio-dot::after {
                content: '';
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #2d8176;
                opacity: 0;
                transition: opacity .13s;
            }
            .swal-reason-row.selected .swal-radio-dot::after {
                opacity: 1;
            }

            /* Reason label text */
            .swal-reason-label {
                font-size: .88rem;
                font-weight: 600;
                color: #3d2f1a;
                cursor: pointer;
            }
            .swal-reason-row.selected .swal-reason-label {
                color: #1a4d46;
            }

            /* Other textarea */
            .swal-other-wrap {
                margin: 8px 0 4px;
                display: none;
            }
            .swal-other-wrap.open { display: block; }
            .swal-other-textarea {
                width: 100%;
                padding: 10px 14px;
                border: 1.5px solid #c9b99a;
                border-radius: 8px;
                font-family: 'Source Sans 3', sans-serif;
                font-size: .88rem;
                color: #1a1209;
                background: #fff;
                resize: none;
                height: 72px;
                outline: none;
                transition: border-color .15s, box-shadow .15s;
            }
            .swal-other-textarea:focus {
                border-color: #2d8176;
                box-shadow: 0 0 0 3px rgba(45,129,118,.12);
            }
            .swal-other-textarea::placeholder { color: #b5a595; }

            /* Fallback textarea (no reasons configured) */
            .swal-fallback-textarea {
                width: 100%;
                padding: 10px 14px;
                border: 1.5px solid #c9b99a;
                border-radius: 8px;
                font-family: 'Source Sans 3', sans-serif;
                font-size: .88rem;
                color: #1a1209;
                background: #faf6ef;
                resize: none;
                height: 80px;
                outline: none;
                margin-top: 12px;
                transition: border-color .15s, box-shadow .15s;
            }
            .swal-fallback-textarea:focus {
                border-color: #2d8176;
                box-shadow: 0 0 0 3px rgba(45,129,118,.12);
                background: #fff;
            }
            .swal-fallback-textarea::placeholder { color: #b5a595; }

            /* Actions area */
            .swal-decline-popup .swal2-actions {
                padding: 16px 32px 28px !important;
                gap: 10px !important;
                margin: 0 !important;
            }

            /* Decline (confirm) button */
            .swal-decline-popup .swal2-confirm {
                background: #c0392b !important;
                border-radius: 8px !important;
                font-family: 'Source Sans 3', sans-serif !important;
                font-size: .74rem !important;
                font-weight: 800 !important;
                letter-spacing: .1em !important;
                text-transform: uppercase !important;
                padding: 11px 24px !important;
                box-shadow: 0 4px 14px rgba(192,57,43,.25) !important;
                transition: background .15s, transform .12s, box-shadow .15s !important;
            }
            .swal-decline-popup .swal2-confirm:hover {
                background: #a93226 !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 8px 20px rgba(192,57,43,.3) !important;
            }

            /* Cancel button */
            .swal-decline-popup .swal2-cancel {
                background: #fff !important;
                color: #6b5740 !important;
                border: 1.5px solid #c9b99a !important;
                border-radius: 8px !important;
                font-family: 'Source Sans 3', sans-serif !important;
                font-size: .74rem !important;
                font-weight: 800 !important;
                letter-spacing: .1em !important;
                text-transform: uppercase !important;
                padding: 11px 24px !important;
                box-shadow: none !important;
                transition: all .15s !important;
            }
            .swal-decline-popup .swal2-cancel:hover {
                background: #e8f4f2 !important;
                color: #2d8176 !important;
                border-color: #2d8176 !important;
            }

            /* Accept popup */
            .swal-accept-popup {
                border-radius: 20px !important;
                overflow: hidden !important;
                padding: 0 !important;
                box-shadow: 0 32px 80px rgba(26,18,9,.18) !important;
                border: 1.5px solid #e8dfd0 !important;
                font-family: 'Source Sans 3', sans-serif !important;
                max-width: 420px !important;
            }
            .swal-accept-popup::before {
                content: '';
                display: block;
                height: 4px;
                background: linear-gradient(90deg, #2d8176, #c9a84c);
            }
            .swal-accept-popup .swal2-icon {
                border-color: rgba(45,129,118,.4) !important;
                color: #2d8176 !important;
                margin: 28px auto 0 !important;
                width: 52px !important; height: 52px !important;
            }
            .swal-accept-popup .swal2-title {
                font-family: 'Libre Baskerville', serif !important;
                font-size: 1.3rem !important;
                font-weight: 700 !important;
                color: #1a1209 !important;
                padding: 10px 32px 0 !important;
            }
            .swal-accept-popup .swal2-html-container {
                margin: 0 !important;
                padding: 4px 32px 4px !important;
                font-size: .9rem !important;
                color: #6b5740 !important;
            }
            .swal-accept-popup .swal2-actions {
                padding: 16px 32px 28px !important;
                gap: 10px !important;
                margin: 0 !important;
            }
            .swal-accept-popup .swal2-confirm {
                background: #2d8176 !important;
                border-radius: 8px !important;
                font-family: 'Source Sans 3', sans-serif !important;
                font-size: .74rem !important;
                font-weight: 800 !important;
                letter-spacing: .1em !important;
                text-transform: uppercase !important;
                padding: 11px 24px !important;
                box-shadow: 0 4px 14px rgba(45,129,118,.25) !important;
                transition: background .15s, transform .12s !important;
            }
            .swal-accept-popup .swal2-confirm:hover {
                background: #1a4d46 !important;
                transform: translateY(-1px) !important;
            }
            .swal-accept-popup .swal2-cancel {
                background: #fff !important;
                color: #6b5740 !important;
                border: 1.5px solid #c9b99a !important;
                border-radius: 8px !important;
                font-family: 'Source Sans 3', sans-serif !important;
                font-size: .74rem !important;
                font-weight: 800 !important;
                letter-spacing: .1em !important;
                text-transform: uppercase !important;
                padding: 11px 24px !important;
                box-shadow: none !important;
                transition: all .15s !important;
            }
            .swal-accept-popup .swal2-cancel:hover {
                background: #fef2f2 !important;
                color: #c0392b !important;
                border-color: #fecaca !important;
            }
        `;
            document.head.appendChild(s);
        })();

        /* ── Decline Invitation ── */
        async function declineInvitation(event, assignmentId, title) {
            event.preventDefault();

            if (typeof Swal === 'undefined') {
                if (confirm('Decline this review invitation?')) {
                    const reason =
                        prompt('Why are you declining? (Optional)', '') || '';
                    document.getElementById(
                        `decline-reason-${assignmentId}`,
                    ).value = reason;
                    document
                        .getElementById(`decline-form-${assignmentId}`)
                        .submit();
                }
                return;
            }

            // Fetch reasons from API
            let reasons = [];
            try {
                const res = await fetch('{{ route('api.decline-reasons') }}', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                });
                reasons = await res.json();
            } catch (e) {
                reasons = [];
            }

            const CUSTOM_LABEL = 'Other (please specify)';

            // Build HTML
            let bodyHtml = `<p style="margin-bottom:4px;">You are declining the review invitation for:</p>
            <p style="font-family:'Libre Baskerville',serif; font-weight:700; color:#1a1209; font-size:1rem; margin-bottom:14px; line-height:1.4;">"${title}"</p>`;

            if (reasons.length > 0) {
                bodyHtml += `<p style="font-size:.74rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b5740; margin-bottom:6px;">Select a reason</p>
            <div class="swal-reasons-wrap" id="swal-reasons-wrap">
                ${reasons
                    .map(
                        (reason, i) => `
                    <div class="swal-reason-row" data-value="${reason}" onclick="selectReason(this, '${reason}', '${CUSTOM_LABEL}')">
                        <span class="swal-radio-dot"></span>
                        <span class="swal-reason-label">${reason}</span>
                    </div>
                `,
                    )
                    .join('')}
            </div>
            <div class="swal-other-wrap" id="swal-other-wrap">
                <textarea class="swal-other-textarea" id="swal-other-textarea" placeholder="Please specify your reason..."></textarea>
            </div>`;
            } else {
                bodyHtml += `<p style="font-size:.74rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b5740; margin-bottom:6px;">Reason (optional)</p>
            <textarea class="swal-fallback-textarea" id="swal-fallback-textarea" placeholder="State your reason for declining..."></textarea>`;
            }

            Swal.fire({
                title: 'Decline Invitation?',
                html: bodyHtml,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Decline',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: { popup: 'swal-decline-popup' },
                focusConfirm: false,
            }).then((r) => {
                if (!r.isConfirmed) return;

                let finalReason = '';
                if (reasons.length > 0) {
                    const selected =
                        document.querySelector('.swal-reason-row.selected')
                            ?.dataset.value || '';
                    if (selected === CUSTOM_LABEL) {
                        const other =
                            document
                                .getElementById('swal-other-textarea')
                                ?.value?.trim() || '';
                        finalReason = other ? 'Other: ' + other : selected;
                    } else {
                        finalReason = selected;
                    }
                } else {
                    finalReason =
                        document
                            .getElementById('swal-fallback-textarea')
                            ?.value?.trim() || '';
                }

                document.getElementById(
                    `decline-reason-${assignmentId}`,
                ).value = finalReason;
                document
                    .getElementById(`decline-form-${assignmentId}`)
                    .submit();
            });
        }

        function selectReason(el, value, customLabel) {
            document
                .querySelectorAll('.swal-reason-row')
                .forEach((r) => r.classList.remove('selected'));
            el.classList.add('selected');
            const otherWrap = document.getElementById('swal-other-wrap');
            if (otherWrap) {
                otherWrap.classList.toggle('open', value === customLabel);
                if (value === customLabel) {
                    setTimeout(
                        () =>
                            document
                                .getElementById('swal-other-textarea')
                                ?.focus(),
                        50,
                    );
                }
            }
        }
    </script>
@endpush
