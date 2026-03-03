@extends('layouts.app')

@section('title', 'Reviewer Dashboard')

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
        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(220, 38, 38, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
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
        @keyframes barGrow {
            from {
                width: 0;
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
        .pulse-badge {
            animation: pulse-ring 2s infinite;
        }
        .pulse-dot {
            animation: pulse-teal 2s infinite;
        }

        /* Due bar */
        .due-bar-wrap {
            height: 4px;
            background: #e8e0d8;
            border-radius: 4px;
            overflow: hidden;
        }
        .due-bar {
            height: 100%;
            border-radius: 4px;
            animation: barGrow 0.6s ease forwards;
        }
        .due-ok {
            background: #16a34a;
        }
        .due-soon {
            background: #d97706;
        }
        .due-overdue {
            background: var(--red);
        }

        /* Stat card */
        .stat-card {
            background: #fff;
            border: 1.5px solid #ede8e0;
            border-radius: 20px;
            padding: 22px 24px;
            transition:
                border-color 0.2s,
                transform 0.15s,
                box-shadow 0.2s;
        }
        .stat-card:hover {
            border-color: var(--teal);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(45, 129, 118, 0.12);
        }

        /* Invite card */
        .invite-card {
            border: 2px solid #fecaca;
            border-radius: 18px;
            background: linear-gradient(135deg, #fff5f5 0%, #fff 70%);
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.07);
            transition:
                box-shadow 0.2s,
                transform 0.15s;
        }
        .invite-card:hover {
            box-shadow: 0 8px 32px rgba(220, 38, 38, 0.12);
            transform: translateY(-1px);
        }

        /* Notification item */
        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1.5px solid #ede8e0;
            background: #faf8f5;
            transition:
                border-color 0.15s,
                background 0.15s;
        }
        .notif-item.unread {
            background: #fff5f5;
            border-color: #fecaca;
        }
        .notif-item:hover {
            border-color: var(--teal);
            background: #f5faf9;
        }

        /* Table */
        .rd-table {
            width: 100%;
            border-collapse: collapse;
        }
        .rd-table thead tr {
            background: linear-gradient(to right, #faf8f5, #f5f0e8);
            border-bottom: 1.5px solid #ede8e0;
        }
        .rd-table thead th {
            padding: 13px 20px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: #b0aaa0;
        }
        .rd-table tbody tr {
            border-bottom: 1px solid #f0ece6;
            transition: background 0.15s;
        }
        .rd-table tbody tr:last-child {
            border-bottom: none;
        }
        .rd-table tbody tr:hover {
            background: #faf8f5;
        }
        .rd-table td {
            padding: 15px 20px;
            vertical-align: middle;
        }

        /* Status badges */
        .badge {
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
        }
        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .badge-green {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }
        .badge-blue {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #2563eb;
        }
        .badge-amber {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #d97706;
        }
        .badge-purple {
            background: #faf5ff;
            border: 1px solid #e9d5ff;
            color: #7c3aed;
        }
        .badge-slate {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }

        /* Action buttons */
        .btn-review {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background: var(--red);
            color: #fff;
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
        }
        .btn-review:hover {
            background: #b91c1c;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.3);
        }

        .btn-purple {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background: #7c3aed;
            color: #fff;
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition:
                background 0.15s,
                transform 0.12s;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
        }
        .btn-purple:hover {
            background: #6d28d9;
            transform: translateY(-1px);
        }

        .btn-accept {
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
            background: #16a34a;
            color: #fff;
            border: none;
            text-decoration: none;
            cursor: pointer;
            width: 100%;
            justify-content: center;
            transition:
                background 0.15s,
                transform 0.12s;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
        }
        .btn-accept:hover {
            background: #15803d;
            transform: translateY(-1px);
        }

        .btn-decline {
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
            background: #fff;
            color: #6a7890;
            border: 1.5px solid #e2ddd4;
            cursor: pointer;
            width: 100%;
            justify-content: center;
            transition: all 0.15s;
        }
        .btn-decline:hover {
            background: #fff5f5;
            color: var(--red);
            border-color: #fecaca;
        }

        /* Section heading */
        .section-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }
        .section-heading h2 {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ink);
        }

        /* Card shell */
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

        <div class="max-w-5xl mx-auto py-10 px-4 space-y-6">
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
                        Journal System · Reviewer Portal
                    </p>
                    <h1
                        class="font-['Libre_Baskerville'] text-4xl font-bold text-(--ink) leading-tight"
                    >
                        Reviewer
                        <em
                            class="not-italic bg-linear-to-r from-(--teal) to-[#1a6b62] bg-clip-text text-transparent"
                        >
                            Dashboard
                        </em>
                    </h1>
                    <p class="text-sm text-[#8a96a8] mt-1">
                        Track and complete your review assignments
                    </p>
                </div>
                <span
                    class="px-4 py-2 bg-white/80 border border-[#ddd8ce] rounded-xl text-[11px] font-bold text-[#9ea8b8] uppercase tracking-widest backdrop-blur-sm"
                >
                    {{ now()->format('D, M j Y') }}
                </span>
            </div>

            {{-- ── Stats ── --}}
            <div class="fade-up-1 grid grid-cols-2 gap-4">
                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="text-[9px] font-black uppercase tracking-[.15em] text-[#b0aaa0]"
                        >
                            Pending Reviews
                        </span>
                        <div
                            class="w-9 h-9 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center text-base"
                        >
                            ⏰
                        </div>
                    </div>
                    <p
                        class="font-['Libre_Baskerville'] text-4xl font-bold text-(--red) leading-none"
                    >
                        {{ $stats['pending'] }}
                    </p>
                    <p class="text-[11px] text-[#b0aaa0] mt-2">
                        Awaiting your submission
                    </p>
                    <div class="mt-3 h-0.75 rounded-full bg-red-100">
                        <div
                            class="h-full rounded-full bg-(--red)"
                            style="
                                width: {{ min(100, $stats['pending'] * 10) }}%;
                            "
                        ></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="text-[9px] font-black uppercase tracking-[.15em] text-[#b0aaa0]"
                        >
                            Completed
                        </span>
                        <div
                            class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-base"
                        >
                            ✅
                        </div>
                    </div>
                    <p
                        class="font-['Libre_Baskerville'] text-4xl font-bold text-emerald-600 leading-none"
                    >
                        {{ $stats['completed'] }}
                    </p>
                    <p class="text-[11px] text-[#b0aaa0] mt-2">
                        Successfully submitted
                    </p>
                    <div class="mt-3 h-0.75 rounded-full bg-emerald-100">
                        <div
                            class="h-full rounded-full bg-emerald-500"
                            style="
                                width: {{ min(100, $stats['completed'] * 5) }}%;
                            "
                        ></div>
                    </div>
                </div>
            </div>

            {{-- ── Pending Invitations ── --}}
            @if ($pendingInvitations->count() > 0)
                <div class="fade-up-2">
                    <div class="section-heading">
                        <h2>Review Invitations</h2>
                        <span
                            class="pulse-badge inline-flex items-center justify-center w-5 h-5 rounded-full bg-(--red) text-white text-[10px] font-black"
                        >
                            {{ $pendingInvitations->count() }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        @foreach ($pendingInvitations as $a)
                            @php
                                $dueDate = $a->due_at ? \Carbon\Carbon::parse($a->due_at) : null;
                                $daysLeft = $dueDate ? (int) now()->diffInDays($dueDate, false) : null;
                                $dueCls = $daysLeft === null ? '' : ($daysLeft < 0 ? 'due-overdue' : ($daysLeft <= 7 ? 'due-soon' : 'due-ok'));
                                $barPct = $dueDate ? max(0, min(100, ($daysLeft / 30) * 100)) : 0;
                            @endphp

                            <div class="invite-card p-6">
                                <div
                                    class="flex flex-col sm:flex-row sm:items-start gap-5"
                                >
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="flex items-center gap-2 mb-2"
                                        >
                                            <span
                                                class="text-[9px] font-black uppercase tracking-widest text-(--red) bg-red-50 border border-red-200 px-2.5 py-1 rounded-full"
                                            >
                                                New Invitation
                                            </span>
                                        </div>
                                        <h3
                                            class="font-['Libre_Baskerville'] text-base font-bold text-(--ink) leading-snug"
                                        >
                                            {{ Str::limit($a->submission->title ?? 'Untitled', 70) }}
                                        </h3>
                                        <p class="text-xs text-[#8a96a8] mt-1">
                                            by
                                            <span
                                                class="font-semibold text-[#6a7890]"
                                            >
                                                {{ $a->submission->author->name ?? '—' }}
                                            </span>
                                            @if ($a->submission->research_field)
                                                ·
                                                <span
                                                    class="text-(--teal) font-semibold"
                                                >
                                                    {{ $a->submission->research_field }}
                                                </span>
                                            @endif
                                        </p>

                                        @if ($dueDate)
                                            <div class="mt-4">
                                                <div
                                                    class="flex items-center justify-between mb-2"
                                                >
                                                    <span
                                                        class="text-[9px] font-black uppercase tracking-widest text-[#b0aaa0]"
                                                    >
                                                        Review Deadline
                                                    </span>
                                                    <span
                                                        class="text-[11px] font-bold font-mono text-[#6a7890]"
                                                    >
                                                        @if ($daysLeft < 0)
                                                            <span
                                                                class="text-(--red)"
                                                            >
                                                                Overdue
                                                            </span>
                                                            ·
                                                            {{ $dueDate->format('M d, Y') }}
                                                        @elseif ($daysLeft === 0)
                                                            <span
                                                                class="text-(--red)"
                                                            >
                                                                Due Today
                                                            </span>
                                                            ·
                                                            {{ $dueDate->format('g:i A') }}
                                                        @else
                                                            {{ $dueDate->format('M d, Y') }}
                                                            ·
                                                            <span
                                                                class="text-(--red)"
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
                                                class="text-xs text-[#b0aaa0] mt-2"
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
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2.5"
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
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2.5"
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

            {{-- ── Notifications ── --}}
            @if ($notifications->count() > 0)
                <div class="fade-up-2 card">
                    <div class="card-header">
                        <div>
                            <p
                                class="text-[9px] font-black uppercase tracking-[.18em] text-[#b0aaa0]"
                            >
                                Notifications
                            </p>
                            <h2
                                class="font-['Libre_Baskerville'] text-base font-bold text-(--ink)"
                            >
                                Recent Updates
                            </h2>
                        </div>
                        @if ($notifications->count() > 3)
                            <span
                                class="text-[10px] font-black text-[#b0aaa0] uppercase tracking-widest"
                            >
                                {{ $notifications->count() }} total
                            </span>
                        @endif
                    </div>
                    <div class="p-5 space-y-2">
                        @foreach ($notifications->take(3) as $notif)
                            <div
                                class="notif-item {{ $notif->isUnread() ? 'unread' : '' }}"
                            >
                                @if ($notif->isUnread())
                                    <span
                                        class="w-2 h-2 rounded-full bg-(--red) shrink-0 mt-1"
                                    ></span>
                                @endif

                                <span class="text-lg shrink-0">
                                    @if ($notif->type === 'success')
                                        ✅
                                    @elseif ($notif->type === 'danger')
                                        ❌
                                    @elseif ($notif->type === 'warning')
                                        ⚠️
                                    @else
                                            📋
                                    @endif
                                </span>
                                <div class="flex-1 min-w-0">
                                    <div
                                        class="flex items-baseline justify-between gap-2"
                                    >
                                        <p
                                            class="text-sm font-bold text-(--ink) truncate"
                                        >
                                            {{ $notif->title }}
                                        </p>
                                        <span
                                            class="text-[10px] text-[#b0aaa0] whitespace-nowrap"
                                        >
                                            {{ $notif->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p
                                        class="text-xs text-[#8a96a8] mt-0.5 leading-relaxed"
                                    >
                                        {{ $notif->message }}
                                    </p>
                                    @if ($notif->notifiable_type === \App\Models\Submission::class)
                                        <a
                                            href="{{ route('reviewer.pending-assignments') }}"
                                            onclick="
                                                markRead({{ $notif->id }})
                                            "
                                            class="text-xs font-black uppercase tracking-wider text-(--teal) hover:text-(--teal-d) mt-1 inline-block transition-colors"
                                        >
                                            View Assignments →
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if ($notifications->count() > 3)
                            <div
                                id="moreNotifications"
                                class="hidden space-y-2"
                            >
                                @foreach ($notifications->slice(3) as $notif)
                                    <div
                                        class="notif-item {{ $notif->isUnread() ? 'unread' : '' }}"
                                    >
                                        @if ($notif->isUnread())
                                            <span
                                                class="w-2 h-2 rounded-full bg-(--red) shrink-0 mt-1"
                                            ></span>
                                        @endif

                                        <span class="text-lg shrink-0">
                                            @if ($notif->type === 'success')
                                                ✅
                                            @elseif ($notif->type === 'danger')
                                                ❌
                                            @elseif ($notif->type === 'warning')
                                                ⚠️
                                            @else
                                                    📋
                                            @endif
                                        </span>
                                        <div class="flex-1 min-w-0">
                                            <div
                                                class="flex items-baseline justify-between gap-2"
                                            >
                                                <p
                                                    class="text-sm font-bold text-(--ink) truncate"
                                                >
                                                    {{ $notif->title }}
                                                </p>
                                                <span
                                                    class="text-[10px] text-[#b0aaa0] whitespace-nowrap"
                                                >
                                                    {{ $notif->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p
                                                class="text-xs text-[#8a96a8] mt-0.5 leading-relaxed"
                                            >
                                                {{ $notif->message }}
                                            </p>
                                            @if ($notif->notifiable_type === \App\Models\Submission::class)
                                                <a
                                                    href="{{ route('reviewer.pending-assignments') }}"
                                                    onclick="
                                                        markRead(
                                                            {{ $notif->id }},
                                                        )
                                                    "
                                                    class="text-xs font-black uppercase tracking-wider text-(--teal) hover:text-(--teal-d) mt-1 inline-block"
                                                >
                                                    View Assignments →
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button
                                type="button"
                                onclick="toggleMoreNotifications()"
                                class="w-full mt-2 py-2.5 text-[10px] font-black uppercase tracking-widest text-[#9ea8b8] hover:text-(--teal) bg-[#faf8f5] hover:bg-[#f5faf9] border border-[#ede8e0] hover:border-(--teal) rounded-xl transition-all"
                            >
                                <span id="seeMoreText">See More ↓</span>
                                <span id="seeLessText" class="hidden">
                                    See Less ↑
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ── Revised Manuscripts ── --}}
            @if ($revisionReviews->count() > 0)
                <div class="fade-up-2 card">
                    <div
                        class="card-header"
                        style="
                            background: linear-gradient(
                                to right,
                                #faf5ff,
                                #f5f0ff
                            );
                        "
                    >
                        <div>
                            <p
                                class="text-[9px] font-black uppercase tracking-[.18em] text-purple-400"
                            >
                                Needs Attention
                            </p>
                            <h2
                                class="font-['Libre_Baskerville'] text-base font-bold text-(--ink) flex items-center gap-2"
                            >
                                🔄 Revised Manuscripts
                            </h2>
                        </div>
                        <span
                            class="w-8 h-8 rounded-full bg-purple-600 text-white text-xs font-black flex items-center justify-center shadow-sm"
                        >
                            {{ $revisionReviews->count() }}
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="rd-table">
                            <thead>
                                <tr>
                                    <th class="text-left">Manuscript</th>
                                    <th class="text-left">Author</th>
                                    <th class="text-left">Type</th>
                                    <th class="text-left">Notes</th>
                                    <th class="text-left">Deadline</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($revisionReviews as $rr)
                                    @php
                                        $daysLeft = $rr->due_at ? now()->diffInDays($rr->due_at, false) : null;
                                    @endphp

                                    <tr class="group">
                                        <td>
                                            <a
                                                href="{{ route('reviews.revision-review-create', $rr) }}"
                                                class="font-['Libre_Baskerville'] text-sm font-bold text-(--ink) group-hover:text-purple-600 transition-colors line-clamp-2"
                                            >
                                                {{ Str::limit($rr->revisionRequest->submission->title, 50) }}
                                            </a>
                                        </td>
                                        <td>
                                            <span
                                                class="text-sm text-[#6a7890]"
                                            >
                                                {{ $rr->revisionRequest->submission->author->name ?? '—' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($rr->revisionRequest->revision_type === 'minor')
                                                <span class="badge badge-amber">
                                                    <span
                                                        class="badge-dot"
                                                        style="
                                                            background: #d97706;
                                                        "
                                                    ></span>
                                                    Minor
                                                </span>
                                            @else
                                                <span
                                                    class="badge"
                                                    style="
                                                        background: #fff7ed;
                                                        border: 1px solid
                                                            #fed7aa;
                                                        color: #c2410c;
                                                    "
                                                >
                                                    <span
                                                        class="badge-dot"
                                                        style="
                                                            background: #ea580c;
                                                        "
                                                    ></span>
                                                    Major
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($rr->revisionRequest->revision_notes)
                                                <p
                                                    class="text-sm text-[#6a7890] truncate max-w-40"
                                                    title="{{ $rr->revisionRequest->revision_notes }}"
                                                >
                                                    {{ Str::limit($rr->revisionRequest->revision_notes, 35) }}
                                                </p>
                                            @else
                                                <span
                                                    class="text-sm text-[#c0b8b0]"
                                                >
                                                    —
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($rr->status === 'completed')
                                                <p
                                                    class="text-xs font-bold text-emerald-600"
                                                >
                                                    Submitted
                                                </p>
                                                <p
                                                    class="text-[10px] text-[#b0aaa0] font-mono mt-0.5"
                                                >
                                                    {{ $rr->completed_at?->format('M d, Y') ?? 'N/A' }}
                                                </p>
                                            @elseif ($rr->due_at)
                                                @if ($daysLeft < 0)
                                                    <p
                                                        class="text-xs font-bold text-(--red)"
                                                    >
                                                        Overdue
                                                    </p>
                                                    <p
                                                        class="text-[10px] text-[#b0aaa0] font-mono"
                                                    >
                                                        {{ $rr->due_at->format('M d, Y') }}
                                                    </p>
                                                @elseif ($daysLeft === 0)
                                                    <p
                                                        class="text-xs font-bold text-amber-600"
                                                    >
                                                        Due Today
                                                    </p>
                                                @else
                                                    <p
                                                        class="text-[10px] text-[#b0aaa0] font-mono"
                                                    >
                                                        {{ $rr->due_at->format('M d, Y') }}
                                                    </p>
                                                @endif
                                            @else
                                                <span
                                                    class="text-sm text-[#c0b8b0]"
                                                >
                                                    —
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a
                                                href="{{ route('reviews.revision-review-create', $rr) }}"
                                                class="btn-purple"
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
            <div class="fade-up-3 card">
                <div class="card-header">
                    <div>
                        <p
                            class="text-[9px] font-black uppercase tracking-[.18em] text-[#b0aaa0]"
                        >
                            Your Workload
                        </p>
                        <h2
                            class="font-['Libre_Baskerville'] text-base font-bold text-(--ink)"
                        >
                            My Review Assignments
                        </h2>
                    </div>
                    <a
                        href="{{ route('reviewer.pending-assignments') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-(--ink) hover:bg-(--teal) text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95"
                    >
                        📋 All Pending
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="rd-table">
                        <thead>
                            <tr>
                                <th class="text-left">Submission</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Deadline</th>
                                <th class="text-left">Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $a)
                                @php
                                    $dueDate = $a->due_at ? \Carbon\Carbon::parse($a->due_at) : null;
                                    $daysLeft = $dueDate ? (int) now()->diffInDays($dueDate, false) : null;
                                    $dueCls = $daysLeft === null ? 'text-[#b0aaa0]' : ($daysLeft < 0 ? 'text-[var(--red)]' : ($daysLeft <= 7 ? 'text-amber-600' : 'text-emerald-600'));
                                @endphp

                                <tr class="group">
                                    <td>
                                        <p
                                            class="font-['Libre_Baskerville'] text-sm font-bold text-(--ink) group-hover:text-(--teal) transition-colors leading-snug"
                                        >
                                            {{ Str::limit($a->submission->title ?? '', 45) }}
                                        </p>
                                    </td>
                                    <td>
                                        <span class="text-sm text-[#6a7890]">
                                            {{ $a->submission->author->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($a->status === 'completed')
                                            <p
                                                class="text-xs font-bold text-emerald-600 font-mono"
                                            >
                                                Submitted
                                            </p>
                                            <p
                                                class="text-[10px] text-[#b0aaa0] mt-0.5"
                                            >
                                                {{ $a->completed_at?->format('M d, Y') ?? 'N/A' }}
                                            </p>
                                        @elseif ($dueDate)
                                            <p
                                                class="text-xs font-bold {{ $dueCls }} font-mono"
                                            >
                                                @if ($daysLeft < 0)
                                                    <span
                                                        class="text-(--red)"
                                                    >
                                                        Overdue
                                                    </span>
                                                    ·
                                                    {{ $dueDate->format('M d') }}
                                                @elseif ($daysLeft === 0)
                                                    <span
                                                        class="text-amber-600"
                                                    >
                                                        Due Today
                                                    </span>
                                                    ·
                                                    {{ $dueDate->format('g:i A') }}
                                                @else
                                                    {{ $dueDate->format('M d, Y') }}
                                                @endif
                                            </p>

                                            @if ($daysLeft !== null && $daysLeft > 0)
                                                <p
                                                    class="text-[10px] text-[#b0aaa0] mt-0.5"
                                                >
                                                    {{ $daysLeft }}d remaining
                                                </p>
                                            @elseif ($daysLeft !== null && $daysLeft < 0)
                                                <p
                                                    class="text-[10px] text-red-400 mt-0.5"
                                                >
                                                    {{ abs($daysLeft) }}d
                                                    overdue
                                                </p>
                                            @endif
                                        @else
                                            <p class="text-xs text-[#b0aaa0]">
                                                No deadline
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($a->status === 'completed')
                                            <span class="badge badge-green">
                                                <span
                                                    class="badge-dot"
                                                    style="background: #16a34a"
                                                ></span>
                                                Completed
                                            </span>
                                        @elseif ($a->status === 'assigned')
                                            <span class="badge badge-blue">
                                                <span
                                                    class="badge-dot"
                                                    style="background: #2563eb"
                                                ></span>
                                                Accepted
                                            </span>
                                        @else
                                            <span class="badge badge-slate">
                                                <span
                                                    class="badge-dot"
                                                    style="background: #94a3b8"
                                                ></span>
                                                {{ ucfirst($a->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if (in_array($a->status, ['assigned', 'accepted']))
                                            <a
                                                href="{{ route('reviews.create', ['assignment' => $a]) }}"
                                                class="btn-review"
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
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                    />
                                                </svg>
                                                Submit Review
                                            </a>
                                        @else
                                            <div
                                                class="flex flex-col items-end gap-1.5"
                                            >
                                                <span
                                                    class="text-[11px] font-black text-emerald-600"
                                                >
                                                    ✓ Done
                                                </span>
                                                <a
                                                    href="{{ route('reviews.peer-reviews', $a->submission) }}"
                                                    class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-wider text-[#6a7890] hover:text-(--teal) border border-[#e2ddd4] hover:border-(--teal) bg-white hover:bg-[#f5faf9] px-3 py-1.5 rounded-lg transition-all"
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
                                    <td colspan="5">
                                        <div
                                            class="flex flex-col items-center py-14 text-center"
                                        >
                                            <div
                                                class="w-12 h-12 rounded-2xl bg-[#f5f0e8] flex items-center justify-center text-xl mb-3"
                                            >
                                                📋
                                            </div>
                                            <p
                                                class="font-['Libre_Baskerville'] font-bold text-(--ink) text-sm"
                                            >
                                                No active assignments
                                            </p>
                                            <p
                                                class="text-[12px] text-[#b0aaa0] mt-1"
                                            >
                                                New assignments will appear
                                                here.
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
                    <div class="text-[11px] text-[#b0aaa0]">
                        {{ $assignments->links() }}
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

        function declineInvitation(event, assignmentId, title) {
            event.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Decline Invitation?',
                    html: `Are you sure you want to decline the review for<br><strong>${title}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#2D8176',
                    confirmButtonText: 'Yes, Decline',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-2xl p-6',
                        title: 'text-xl font-black tracking-tighter text-slate-900',
                        confirmButton:
                            'px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest mx-1',
                        cancelButton:
                            'px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest mx-1',
                    },
                }).then((r) => {
                    if (r.isConfirmed)
                        document
                            .getElementById(`decline-form-${assignmentId}`)
                            .submit();
                });
            } else {
                if (confirm('Decline this review invitation?'))
                    document
                        .getElementById(`decline-form-${assignmentId}`)
                        .submit();
            }
        }
    </script>
@endpush
