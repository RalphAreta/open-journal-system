@extends('layouts.app')

@section('title', 'Reviewer Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .font-serif { font-family: 'Instrument Serif', serif; }
    .font-body  { font-family: 'DM Sans', sans-serif; }

    @keyframes fadeUp {
        from { opacity:0; transform:translateY(10px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .fade-up   { animation: fadeUp .35s ease both; }
    .fade-up-1 { animation: fadeUp .35s .07s ease both; }
    .fade-up-2 { animation: fadeUp .35s .14s ease both; }
    .fade-up-3 { animation: fadeUp .35s .21s ease both; }

    /* Pulse on pending invitation badge */
    @keyframes pulse-ring {
        0%   { box-shadow: 0 0 0 0 rgba(220,38,38,.35); }
        70%  { box-shadow: 0 0 0 8px rgba(220,38,38,0); }
        100% { box-shadow: 0 0 0 0 rgba(220,38,38,0); }
    }
    .pulse-badge { animation: pulse-ring 2s infinite; }

    /* Due date bar */
    .due-bar-wrap { height: 4px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
    .due-bar      { height: 100%; border-radius: 4px; transition: width .4s ease; }
    .due-ok       { background: #16a34a; }
    .due-soon     { background: #d97706; }
    .due-overdue  { background: #dc2626; }

    /* Invitation card --*/
    .invite-card {
        border: 2px solid #fecaca;
        border-radius: 16px;
        background: linear-gradient(135deg, #fff5f5 0%, #fff 60%);
        box-shadow: 0 4px 20px rgba(220,38,38,.08);
    }
</style>
@endpush

@section('content')
<div class="font-body">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 fade-up">
        <div>
            <h1 class="font-serif text-[1.75rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight">
                Reviewer Dashboard
            </h1>
            <p class="text-[13px] text-slate-400 mt-0.5">Track and complete your review assignments</p>
        </div>
        <span class="text-[11px] font-semibold text-slate-400 bg-white border border-slate-200 px-3 py-1.5 rounded-full hidden sm:inline-block">
            {{ now()->format('D, M j Y') }}
        </span>
    </div>

    {{-- ── Stats ── --}}
    <div class="grid grid-cols-2 gap-3 mb-6 fade-up-1">
        <div class="bg-white border border-slate-200 hover:border-red-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Pending Reviews</span>
                <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-sm">⏰</div>
            </div>
            <p class="font-serif text-[2rem] leading-none text-red-600">{{ $stats['pending'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Awaiting your submission</p>
        </div>
        <div class="bg-white border border-slate-200 hover:border-emerald-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Completed</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-sm">✅</div>
            </div>
            <p class="font-serif text-[2rem] leading-none text-emerald-600">{{ $stats['completed'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Submitted</p>
        </div>
    </div>

    {{-- ── PENDING INVITATIONS ── --}}
    {{-- These are assignments where status = 'pending' (not yet accepted/declined) --}}
    @php $pendingInvitations = $assignments->where('status', 'pending'); @endphp
    @if($pendingInvitations->count() > 0)
    <div class="mb-6 fade-up-2">
        <div class="flex items-center gap-3 mb-3">
            <h2 class="font-serif text-[1.2rem] font-normal text-slate-900 tracking-[-0.01em]">Review Invitations</h2>
            <span class="pulse-badge inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-600 text-white text-[10px] font-bold">
                {{ $pendingInvitations->count() }}
            </span>
        </div>

        <div class="space-y-3">
            @foreach($pendingInvitations as $a)
            @php
                $dueDate   = $a->due_at ? \Carbon\Carbon::parse($a->due_at) : null;
                $daysLeft  = $dueDate ? (int) now()->diffInDays($dueDate, false) : null;
                $dueCls    = $daysLeft === null ? '' : ($daysLeft < 0 ? 'due-overdue' : ($daysLeft <= 7 ? 'due-soon' : 'due-ok'));
                $barPct    = $dueDate ? max(0, min(100, ($daysLeft / 30) * 100)) : 0;
            @endphp
            <div class="invite-card p-5">
                <div class="flex flex-col sm:flex-row sm:items-start gap-4">

                    {{-- Left: info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold uppercase tracking-[.07em] text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">
                                New Invitation
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug mt-1">
                            {{ Str::limit($a->submission->title ?? 'Untitled', 70) }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            by {{ $a->submission->author->name ?? '—' }}
                            @if($a->submission->research_field)
                            · <span class="text-blue-600 font-semibold">{{ $a->submission->research_field }}</span>
                            @endif
                        </p>

                        {{-- Due date --}}
                        @if($dueDate)
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] font-bold uppercase tracking-[.06em] text-slate-400">Review Deadline</span>
                                <span class="text-xs font-bold {{ $dueCls }}">
                                    @if($daysLeft < 0)
                                        Overdue by {{ abs($daysLeft) }}d
                                    @elseif($daysLeft === 0)
                                        Due today
                                    @else
                                        {{ $dueDate->format('M d, Y') }} · {{ $daysLeft }}d left
                                    @endif
                                </span>
                            </div>
                            <div class="due-bar-wrap">
                                <div class="due-bar {{ $dueCls }}" style="width: {{ $barPct }}%"></div>
                            </div>
                        </div>
                        @else
                        <p class="text-xs text-slate-400 mt-2">No deadline set</p>
                        @endif
                    </div>

                    {{-- Right: actions --}}
                    <div class="flex sm:flex-col gap-2 sm:items-end">
                        {{-- Accept --}}
                        <form method="POST" action="{{ route('reviewer.invitation.accept', $a) }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700
                                           text-white px-4 py-2 rounded-xl text-xs font-bold transition-all hover:-translate-y-0.5 w-full justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Accept Assignment
                            </button>
                        </form>

                        {{-- Decline --}}
                        <form method="POST" action="{{ route('reviewer.invitation.decline', $a) }}">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to decline this review invitation?')"
                                    class="inline-flex items-center gap-1.5 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-300
                                           text-slate-600 hover:text-red-600 px-4 py-2 rounded-xl text-xs font-bold transition-all hover:-translate-y-0.5 w-full justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Decline
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Notifications ── --}}
    @if ($notifications->count() > 0)
    <div class="bg-white border border-slate-200 rounded-2xl p-5 mb-6 shadow-sm fade-up-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400">Notifications</h2>
            @if($notifications->count() > 3)
            <span class="text-[10px] font-semibold text-slate-400">{{ $notifications->count() }} total</span>
            @endif
        </div>
        <div class="space-y-2">
            @foreach ($notifications->take(3) as $notif)
            <div class="notification-item flex items-start gap-3 px-4 py-3 rounded-xl border transition-colors
                {{ $notif->isUnread() ? 'bg-red-50/60 border-red-100' : 'bg-slate-50 border-slate-100' }}">
                @if($notif->isUnread())
                <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0 mt-1.5"></span>
                @endif
                <span class="text-base flex-shrink-0">
                    @if($notif->type === 'success') ✅
                    @elseif($notif->type === 'danger') ❌
                    @elseif($notif->type === 'warning') ⚠️
                    @else 📋
                    @endif
                </span>
                <div class="flex-1 min-w-0">
                    <div class="flex items-baseline justify-between gap-2">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $notif->title }}</p>
                        <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $notif->message }}</p>
                    @if($notif->notifiable_type === \App\Models\Submission::class)
                    <a href="{{ route('reviewer.pending-assignments') }}"
                       onclick="markRead({{ $notif->id }})"
                       class="text-xs font-bold text-red-500 hover:text-red-700 mt-1 inline-block transition-colors">
                        View Assignments →
                    </a>
                    @endif
                </div>
            </div>
            @endforeach

            {{-- Hidden additional notifications --}}
            @if($notifications->count() > 3)
            <div id="moreNotifications" class="hidden space-y-2">
                @foreach ($notifications->slice(3) as $notif)
                <div class="notification-item flex items-start gap-3 px-4 py-3 rounded-xl border transition-colors
                    {{ $notif->isUnread() ? 'bg-red-50/60 border-red-100' : 'bg-slate-50 border-slate-100' }}">
                    @if($notif->isUnread())
                    <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0 mt-1.5"></span>
                    @endif
                    <span class="text-base flex-shrink-0">
                        @if($notif->type === 'success') ✅
                        @elseif($notif->type === 'danger') ❌
                        @elseif($notif->type === 'warning') ⚠️
                        @else 📋
                        @endif
                    </span>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-baseline justify-between gap-2">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ $notif->title }}</p>
                            <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $notif->message }}</p>
                        @if($notif->notifiable_type === \App\Models\Submission::class)
                        <a href="{{ route('reviewer.pending-assignments') }}"
                           onclick="markRead({{ $notif->id }})"
                           class="text-xs font-bold text-red-500 hover:text-red-700 mt-1 inline-block transition-colors">
                            View Assignments →
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- See More Button --}}
            <button type="button" onclick="toggleMoreNotifications()"
                    class="w-full mt-3 px-4 py-2.5 text-center text-[11px] font-bold uppercase tracking-[.05em] text-slate-600 hover:text-slate-900
                           bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg transition-all hover:-translate-y-0.5">
                <span id="seeMoreText">See More</span>
                <span id="seeLessText" class="hidden">See Less</span>
            </button>
            @endif
        </div>
    </div>
    @endif

    {{-- ── Revised Manuscripts Section ── --}}
    @if ($revisionReviews->count() > 0)
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm fade-up-2 mb-6">
        <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-purple-50 to-amber-50 border-b border-slate-100">
            <div>
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <span class="text-lg">🔄</span>
                    Revised Manuscripts Awaiting Review
                </h2>
                <p class="text-xs text-slate-500 mt-1">Authors have submitted revisions - your feedback is needed</p>
            </div>
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-600 text-white text-xs font-bold shadow-sm">
                {{ $revisionReviews->count() }}
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Manuscript</th>
                        <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Author</th>
                        <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Type</th>
                        <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Notes</th>
                        <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Deadline</th>
                        <th class="px-6 py-3 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revisionReviews as $rr)
                    @php
                        $daysLeft = $rr->due_at ? now()->diffInDays($rr->due_at, false) : null;
                    @endphp
                    <tr class="border-b border-slate-50 last:border-0 hover:bg-purple-50/40 transition-colors group">
                        <td class="px-6 py-3.5">
                            <a href="{{ route('reviews.revision-review-create', $rr) }}" class="text-sm font-semibold text-slate-800 group-hover:text-purple-600 transition-colors line-clamp-2">
                                {{ Str::limit($rr->revisionRequest->submission->title, 50) }}
                            </a>
                        </td>
                        <td class="px-6 py-3.5">
                            <p class="text-sm text-slate-600">{{ $rr->revisionRequest->submission->author->name ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-3.5">
                            @if ($rr->revisionRequest->revision_type === 'minor')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-yellow-50 border border-yellow-200 text-[10px] font-bold uppercase tracking-[.04em] text-yellow-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Minor
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-orange-50 border border-orange-200 text-[10px] font-bold uppercase tracking-[.04em] text-orange-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>Major
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5">
                            @if ($rr->revisionRequest->revision_notes)
                                <p class="text-sm text-slate-600 truncate" title="{{ $rr->revisionRequest->revision_notes }}">
                                    {{ Str::limit($rr->revisionRequest->revision_notes, 35, '...') }}
                                </p>
                            @else
                                <span class="text-sm text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5">
                            @if ($rr->due_at)
                                <div class="text-sm">
                                    @if ($daysLeft < 0)
                                        <p class="font-bold text-red-600">{{ abs($daysLeft) }}d overdue</p>
                                    @elseif ($daysLeft <= 3)
                                        <p class="font-bold text-amber-600">{{ $daysLeft }}d left</p>
                                    @else
                                        <p class="font-semibold text-emerald-600">{{ $daysLeft }}d left</p>
                                    @endif
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $rr->due_at->format('M d') }}</p>
                                </div>
                            @else
                                <span class="text-sm text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <a href="{{ route('reviews.revision-review-create', $rr) }}" class="inline-flex items-center gap-1.5 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-[11px] font-bold transition-all hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
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

    {{-- ── Active Assignments Table ── --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm fade-up-3">
        <div class="flex items-center justify-between px-5 py-4 bg-slate-50 border-b border-slate-200">
            <h2 class="text-sm font-bold text-slate-800">My Review Assignments</h2>
            <a href="{{ route('reviewer.pending-assignments') }}"
               class="inline-flex items-center gap-1.5 bg-slate-800 hover:bg-slate-900 text-white
                      px-3 py-1.5 rounded-lg text-[11px] font-bold transition-all hover:-translate-y-0.5">
                📋 All Pending
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Submission</th>
                        <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Author</th>
                        <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Deadline</th>
                        <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Status</th>
                        <th class="px-5 py-3 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments->whereNotIn('status', ['pending']) as $a)
                    @php
                        $dueDate  = $a->due_at ? \Carbon\Carbon::parse($a->due_at) : null;
                        $daysLeft = $dueDate ? (int) now()->diffInDays($dueDate, false) : null;
                        $dueCls   = $daysLeft === null ? 'text-slate-400' : ($daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 7 ? 'text-amber-600' : 'text-emerald-600'));
                    @endphp
                    <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/60 transition-colors group">
                        <td class="px-5 py-3.5">
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-red-600 transition-colors leading-snug">
                                {{ Str::limit($a->submission->title ?? '', 45) }}
                            </p>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-sm text-slate-500">{{ $a->submission->author->name ?? '—' }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($dueDate)
                            <div>
                                <p class="text-xs font-bold {{ $dueCls }}">
                                    @if($daysLeft < 0)
                                        Overdue ({{ $dueDate->format('M d') }})
                                    @elseif($daysLeft === 0)
                                        Due Today
                                    @else
                                        {{ $dueDate->format('M d, Y') }}
                                    @endif
                                </p>
                                @if($daysLeft !== null && $daysLeft >= 0)
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $daysLeft }} day{{ $daysLeft != 1 ? 's' : '' }} remaining</p>
                                @endif
                            </div>
                            @else
                            <p class="text-xs text-slate-400">No deadline</p>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            @if($a->status === 'completed')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-[10px] font-bold uppercase tracking-[.04em] text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Completed
                            </span>
                            @elseif($a->status === 'accepted')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-50 border border-blue-200 text-[10px] font-bold uppercase tracking-[.04em] text-blue-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Accepted
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-50 border border-slate-200 text-[10px] font-bold uppercase tracking-[.04em] text-slate-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>{{ ucfirst($a->status) }}
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            @if(in_array($a->status, ['assigned', 'accepted']))
                            <a href="{{ route('reviews.create', ['assignment' => $a]) }}"
                               class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700
                                      text-white px-3 py-1.5 rounded-lg text-[10px] font-bold
                                      transition-all hover:-translate-y-0.5">
                                ✎ Submit Review
                            </a>
                            @else
                            <span class="text-[11px] font-bold text-emerald-600">✓ Done</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-14 text-center">
                            <p class="text-[11px] font-bold uppercase tracking-[.1em] text-slate-300">No active assignments</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 text-sm text-slate-400">
            {{ $assignments->links() }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function markRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
}

function toggleMoreNotifications() {
    const moreContainer = document.getElementById('moreNotifications');
    const seeMoreText = document.getElementById('seeMoreText');
    const seeLessText = document.getElementById('seeLessText');

    if (moreContainer.classList.contains('hidden')) {
        moreContainer.classList.remove('hidden');
        seeMoreText.classList.add('hidden');
        seeLessText.classList.remove('hidden');
    } else {
        moreContainer.classList.add('hidden');
        seeMoreText.classList.remove('hidden');
        seeLessText.classList.add('hidden');
    }
}
</script>
@endpush
