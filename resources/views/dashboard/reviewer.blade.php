@extends('layouts.app')

@section('title', 'Reviewer Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .dashboard-wrap  { font-family: 'DM Sans', sans-serif; }

    /* ── Page Header ── */
    .page-title {
        font-family: 'Instrument Serif', serif;
        font-size: 1.85rem;
        font-weight: 400;
        color: #0F172A;
        letter-spacing: -.015em;
        line-height: 1.2;
    }
    .page-subtitle {
        font-size: .875rem;
        color: #64748B;
        margin-top: 4px;
    }
    .page-date-badge {
        font-size: .72rem; font-weight: 500;
        color: #94A3B8; background: #fff;
        border: 1px solid #E2E8F0;
        padding: 5px 12px; border-radius: 20px;
        white-space: nowrap;
    }

    /* ── Stat Cards ── */
    .stat-card {
        background: #fff;
        border: 1.5px solid #E2E8F0;
        border-radius: 14px;
        padding: 22px 24px;
        box-shadow: 0 1px 3px rgba(15,23,42,.05);
        transition: box-shadow .2s, transform .2s, border-color .2s;
        position: relative; overflow: hidden;
    }
    .stat-card::before {
        content: ''; position: absolute; inset: 0;
        opacity: 0; transition: opacity .2s; pointer-events: none;
    }
    .stat-card.red::before  { background: linear-gradient(135deg,#FFF5F5 0%,transparent 55%); }
    .stat-card.grn::before  { background: linear-gradient(135deg,#F0FFF4 0%,transparent 55%); }
    .stat-card:hover        { box-shadow: 0 6px 20px rgba(15,23,42,.09); transform: translateY(-2px); }
    .stat-card:hover::before{ opacity: 1; }
    .stat-card.red:hover    { border-color: #FECACA; }
    .stat-card.grn:hover    { border-color: #BBF7D0; }

    .stat-label   { font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #64748B; }
    .stat-icon-box{
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
    }
    .stat-icon-box.red { background: #FEE2E2; }
    .stat-icon-box.grn { background: #DCFCE7; }
    .stat-number  { font-family: 'Instrument Serif', serif; font-size: 2.4rem; line-height: 1; margin-top: 12px; }
    .stat-number.red { color: #DC2626; }
    .stat-number.grn { color: #16A34A; }
    .stat-hint    { font-size: .72rem; color: #94A3B8; margin-top: 5px; }

    /* ── Notifications ── */
    .notif-section {
        background: #fff; border: 1.5px solid #E2E8F0;
        border-radius: 14px; padding: 20px 24px;
        box-shadow: 0 1px 3px rgba(15,23,42,.05);
    }
    .notif-section-title {
        font-size: .7rem; font-weight: 700; letter-spacing: .07em;
        text-transform: uppercase; color: #64748B; margin-bottom: 14px;
    }
    .notif-item {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 13px 15px; border-radius: 10px; border: 1px solid transparent;
    }
    .notif-item.unread { background: #FFFBFB; border-color: #FECACA; }
    .notif-item.read   { background: #F8FAFC; border-color: #E2E8F0; }
    .notif-unread-dot  { width: 7px; height: 7px; border-radius: 50%; background: #DC2626; flex-shrink: 0; margin-top: 5px; }
    .notif-icon-wrap   { font-size: .95rem; margin-top: 2px; }
    .notif-body        { flex: 1; }
    .notif-row         { display: flex; justify-content: space-between; align-items: baseline; gap: 8px; }
    .notif-name        { font-size: .82rem; font-weight: 700; color: #0F172A; }
    .notif-time        { font-size: .7rem; color: #94A3B8; white-space: nowrap; }
    .notif-msg         { font-size: .79rem; color: #475569; margin-top: 3px; line-height: 1.5; }
    .notif-cta         { font-size: .75rem; font-weight: 600; color: #DC2626; text-decoration: none; display: inline-block; margin-top: 6px; }
    .notif-cta:hover   { text-decoration: underline; }

    /* ── Table Card ── */
    .table-card {
        background: #fff; border: 1.5px solid #E2E8F0;
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 1px 3px rgba(15,23,42,.05);
    }
    .table-card-header {
        padding: 16px 24px; border-bottom: 1.5px solid #E2E8F0;
        background: #FAFBFC; display: flex; align-items: center; justify-content: space-between;
    }
    .table-card-title { font-size: .9rem; font-weight: 700; color: #0F172A; letter-spacing: -.01em; }
    .btn-pending-assign {
        display: inline-flex; align-items: center; gap: 7px;
        background: #1E293B; color: #fff;
        font-size: .76rem; font-weight: 600; font-family: 'DM Sans', sans-serif;
        padding: 8px 16px; border-radius: 8px; text-decoration: none;
        transition: background .15s, transform .1s, box-shadow .15s;
        letter-spacing: .01em;
    }
    .btn-pending-assign:hover {
        background: #0F172A; transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(15,23,42,.18);
    }
    .tbl thead tr { background: #FAFBFC; }
    .tbl th {
        padding: 10px 20px; text-align: left;
        font-size: .68rem; font-weight: 700; letter-spacing: .08em;
        text-transform: uppercase; color: #64748B; border-bottom: 1.5px solid #E2E8F0;
    }
    .tbl th:last-child { text-align: right; }
    .tbl td { padding: 13px 20px; font-size: .82rem; color: #0F172A; border-bottom: 1px solid #F1F5F9; }
    .tbl tbody tr:last-child td { border-bottom: none; }
    .tbl tbody tr:hover td { background: #F8FAFC; }
    .tbl td.author-cell { color: #475569; }
    .tbl td.actions-cell { text-align: right; }

    .badge-assigned  { display:inline-block; padding:4px 12px; border-radius:20px; font-size:.7rem; font-weight:700; background:#FEE2E2; color:#DC2626; }
    .badge-completed { display:inline-block; padding:4px 12px; border-radius:20px; font-size:.7rem; font-weight:700; background:#DCFCE7; color:#16A34A; }

    .btn-submit-review {
        display: inline-flex; align-items: center; gap: 5px;
        background: #DC2626; color: #fff;
        font-size: .75rem; font-weight: 600; font-family: 'DM Sans', sans-serif;
        padding: 7px 14px; border-radius: 7px; text-decoration: none;
        transition: background .15s, transform .1s;
    }
    .btn-submit-review:hover { background: #B91C1C; transform: translateY(-1px); }
    .completed-label { font-size: .8rem; font-weight: 600; color: #16A34A; }

    /* ── Animations ── */
    .fade-up { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation: fadeUp .4s .07s ease both; }
    .fade-up-2 { animation: fadeUp .4s .14s ease both; }
    .fade-up-3 { animation: fadeUp .4s .21s ease both; }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(12px); }
        to   { opacity:1; transform:translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">

    {{-- ── Page Header ── --}}
    <div class="flex items-end justify-between mb-7 fade-up">
        <div>
            <h1 class="page-title">Reviewer Dashboard</h1>
            <p class="page-subtitle">Track and complete your review assignments</p>
        </div>
        <span class="page-date-badge hidden sm:inline-block">
            {{ now()->format('D, M j Y') }}
        </span>
    </div>

    {{-- ── Stats ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-card red fade-up-1">
            <div class="flex items-center justify-between">
                <span class="stat-label">Pending Reviews</span>
                <div class="stat-icon-box red">⏰</div>
            </div>
            <p class="stat-number red">{{ $stats['pending'] }}</p>
            <p class="stat-hint">Awaiting your submission</p>
        </div>
        <div class="stat-card grn fade-up-1">
            <div class="flex items-center justify-between">
                <span class="stat-label">Completed Reviews</span>
                <div class="stat-icon-box grn">✅</div>
            </div>
            <p class="stat-number grn">{{ $stats['completed'] }}</p>
            <p class="stat-hint">Submitted</p>
        </div>
        <div class="stat-card fade-up-1" style="border-color: #9F7AEA; box-shadow: 0 1px 3px rgba(159, 122, 234, 0.1);">
            <div class="flex items-center justify-between">
                <span class="stat-label" style="color: #7C3AED;">Revision Reviews</span>
                <div class="stat-icon-box" style="background: #EDE9FE; color: #7C3AED; font-size: 1.1rem;">🔄</div>
            </div>
            <p class="stat-number" style="color: #7C3AED;">{{ $stats['pending_revisions'] }}</p>
            <p class="stat-hint">Revised manuscripts to review</p>
        </div>
        <div class="stat-card fade-up-1" style="border-color: #F59E0B; box-shadow: 0 1px 3px rgba(245, 158, 11, 0.1);">
            <div class="flex items-center justify-between">
                <span class="stat-label" style="color: #B45309;">Revisions Completed</span>
                <div class="stat-icon-box" style="background: #FEF3C7; color: #B45309;">✓</div>
            </div>
            <p class="stat-number" style="color: #B45309;">{{ $stats['completed_revisions'] }}</p>
            <p class="stat-hint">Revision reviews submitted</p>
        </div>
    </div>

    {{-- ── Notifications ── --}}
    @if ($notifications->count() > 0)
    <div class="notif-section mb-6 fade-up-2">
        <p class="notif-section-title">Notifications</p>
        <div class="space-y-2">
            @foreach ($notifications as $notif)
            <div class="notif-item {{ $notif->isUnread() ? 'unread' : 'read' }}">
                @if ($notif->isUnread())
                    <div class="notif-unread-dot"></div>
                @endif
                <div class="notif-icon-wrap">
                    @if ($notif->type === 'success') ✅
                    @elseif ($notif->type === 'danger') ❌
                    @elseif ($notif->type === 'warning') ⚠️
                    @else 📋
                    @endif
                </div>
                <div class="notif-body">
                    <div class="notif-row">
                        <span class="notif-name">{{ $notif->title }}</span>
                        <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notif-msg">{{ $notif->message }}</p>
                    @if ($notif->notifiable_type === \App\Models\Submission::class)
                        <a href="{{ route('reviewer.pending-assignments') }}"
                           onclick="markRead({{ $notif->id }})"
                           class="notif-cta">View Assignments →</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Revised Manuscripts Section ── --}}
    @if ($revisionReviews->count() > 0)
    <div class="table-card fade-up-2 mb-6">
        <div class="table-card-header" style="background: linear-gradient(135deg, #F3E8FF 0%, #FEF3C7 100%);">
            <div>
                <span class="table-card-title" style="color: #7C3AED; font-weight: 700;">🔄 Revised Manuscripts Awaiting Your Review</span>
                <p style="font-size: 0.75rem; color: #7C3AED; margin-top: 4px;">Authors have submitted revised versions - your feedback is needed</p>
            </div>
            <span style="background: #DC2626; color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                {{ $revisionReviews->count() }} awaiting
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full tbl">
                <thead>
                    <tr>
                        <th>Manuscript Title</th>
                        <th>Author</th>
                        <th>Revision Type</th>
                        <th>Author's Notes</th>
                        <th>Due</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revisionReviews as $rr)
                    <tr style="background: #FFFAF0;">
                        <td class="font-medium" style="max-width: 250px;">
                            <span title="{{ $rr->revisionRequest->submission->title }}">
                                {{ Str::limit($rr->revisionRequest->submission->title, 35) }}
                            </span>
                        </td>
                        <td class="author-cell">{{ $rr->revisionRequest->submission->author->name ?? '-' }}</td>
                        <td>
                            @if ($rr->revisionRequest->revision_type === 'minor')
                                <span style="background: #FEF3C7; color: #B45309; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">⚡ Minor</span>
                            @else
                                <span style="background: #FED7AA; color: #C2410C; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">🔴 Major</span>
                            @endif
                        </td>
                        <td class="text-sm text-slate-600">
                            @if ($rr->revisionRequest->revision_notes)
                                <span title="{{ $rr->revisionRequest->revision_notes }}">
                                    {{ Str::limit($rr->revisionRequest->revision_notes, 25) }}
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="text-sm">
                            @if ($rr->due_at)
                                @php
                                    $daysLeft = now()->diffInDays($rr->due_at, false);
                                @endphp
                                @if ($daysLeft < 0)
                                    <span style="color: #DC2626; font-weight: 600;">{{ abs($daysLeft) }}d overdue</span>
                                @elseif ($daysLeft <= 3)
                                    <span style="color: #EA580C; font-weight: 600;">{{ $daysLeft }}d left</span>
                                @else
                                    <span style="color: #16A34A; font-weight: 600;">{{ $daysLeft }}d left</span>
                                @endif
                            @endif
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('reviews.revision-create', $rr) }}" class="btn-submit-review" style="background: #7C3AED; border-color: #7C3AED;">
                                ✎ Review Now
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ── Table Card ── --}}
    <div class="table-card fade-up-3">
        <div class="table-card-header">
            <span class="table-card-title">Review Assignments</span>
            <a href="{{ route('reviewer.pending-assignments') }}" class="btn-pending-assign">
                📋 Pending Reviewer Assignments
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full tbl">
                <thead>
                    <tr>
                        <th>Submission</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $a)
                    <tr>
                        <td class="font-medium">{{ Str::limit($a->submission->title ?? '', 40) }}</td>
                        <td class="author-cell">{{ $a->submission->author->name ?? '-' }}</td>
                        <td>
                            @if($a->status === 'completed')
                                <span class="badge-completed">Completed</span>
                            @else
                                <span class="badge-assigned">{{ ucfirst($a->status) }}</span>
                            @endif
                        </td>
                        <td class="actions-cell">
                            @if($a->status === 'assigned')
                                <a href="{{ route('reviews.create', ['assignment' => $a]) }}" class="btn-submit-review">
                                    ✎ Submit Review
                                </a>
                            @else
                                <span class="completed-label">✓ Completed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-14 text-center text-slate-400 text-sm">
                            No review assignments. Your assigned reviews will appear here.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 bg-slate-50 border-t border-slate-200 text-sm text-slate-400">
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
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        });
    }
</script>
@endpush