@extends('layouts.app')

@section('title', 'Author Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .author-wrap { font-family: 'DM Sans', sans-serif; }

    /* ── Page Header ── */
    .page-title {
        font-family: 'Instrument Serif', serif;
        font-size: 1.85rem; font-weight: 400;
        color: #0F172A; letter-spacing: -.015em; line-height: 1.2;
    }
    .page-subtitle { font-size: .875rem; color: #64748B; margin-top: 4px; }
    .page-date-badge {
        font-size: .72rem; font-weight: 500; color: #94A3B8;
        background: #fff; border: 1px solid #E2E8F0;
        padding: 5px 12px; border-radius: 20px; white-space: nowrap;
    }
    .btn-new-submission {
        display: inline-flex; align-items: center; gap: 7px;
        background: #DC2626; color: #fff;
        font-size: .76rem; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
        padding: 10px 22px; border-radius: 9px; text-decoration: none;
        transition: background .15s, transform .1s, box-shadow .15s;
        box-shadow: 0 4px 12px rgba(220,38,38,.20); white-space: nowrap;
    }
    .btn-new-submission:hover {
        background: #B91C1C; transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(220,38,38,.28);
    }

    /* ── Stat Cards ── */
    .stat-card {
        background: #fff; border: 1.5px solid #E2E8F0; border-radius: 14px;
        padding: 18px 20px; box-shadow: 0 1px 3px rgba(15,23,42,.05);
        transition: box-shadow .2s, transform .2s, border-color .2s;
        position: relative; overflow: hidden;
    }
    .stat-card::before {
        content: ''; position: absolute; inset: 0;
        opacity: 0; transition: opacity .2s; pointer-events: none;
    }
    .stat-card:hover { box-shadow: 0 6px 20px rgba(15,23,42,.09); transform: translateY(-2px); }
    .stat-card:hover::before { opacity: 1; }
    .stat-card.c-slate::before   { background: linear-gradient(135deg,#F8FAFC 0%,transparent 60%); }
    .stat-card.c-blue::before    { background: linear-gradient(135deg,#EFF6FF 0%,transparent 60%); }
    .stat-card.c-yellow::before  { background: linear-gradient(135deg,#FEFCE8 0%,transparent 60%); }
    .stat-card.c-orange::before  { background: linear-gradient(135deg,#FFF7ED 0%,transparent 60%); }
    .stat-card.c-amber::before   { background: linear-gradient(135deg,#FFFBEB 0%,transparent 60%); }
    .stat-card.c-emerald::before { background: linear-gradient(135deg,#F0FDF4 0%,transparent 60%); }
    .stat-card.c-red::before     { background: linear-gradient(135deg,#FFF5F5 0%,transparent 60%); }
    .stat-card.c-slate:hover   { border-color: #CBD5E1; }
    .stat-card.c-blue:hover    { border-color: #BFDBFE; }
    .stat-card.c-yellow:hover  { border-color: #FDE68A; }
    .stat-card.c-orange:hover  { border-color: #FDBA74; }
    .stat-card.c-amber:hover   { border-color: #FCD34D; }
    .stat-card.c-emerald:hover { border-color: #6EE7B7; }
    .stat-card.c-red:hover     { border-color: #FECACA; }

    .stat-label  { font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #94A3B8; margin-bottom: 10px; display: block; }
    .stat-number { font-family: 'Instrument Serif', serif; font-size: 2.1rem; line-height: 1; }
    .stat-number.c-slate   { color: #0F172A; }
    .stat-number.c-blue    { color: #2563EB; }
    .stat-number.c-yellow  { color: #D97706; }
    .stat-number.c-orange  { color: #EA580C; }
    .stat-number.c-amber   { color: #B45309; }
    .stat-number.c-emerald { color: #059669; }
    .stat-number.c-red     { color: #DC2626; }

    /* ── Search Bar ── */
    .search-bar {
        background: #fff; border: 1.5px solid #E2E8F0; border-radius: 14px;
        padding: 14px 18px; display: flex; align-items: center; gap: 14px;
        box-shadow: 0 1px 3px rgba(15,23,42,.05);
    }
    .search-icon-wrap { position: relative; flex: 1; }
    .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94A3B8; pointer-events: none; }
    .search-input {
        width: 100%; background: #F8FAFC; border: 1px solid #E2E8F0;
        border-radius: 9px; padding: 9px 14px 9px 38px;
        font-size: .82rem; font-family: 'DM Sans', sans-serif; color: #0F172A; outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .search-input:focus { border-color: #FECACA; box-shadow: 0 0 0 3px rgba(220,38,38,.07); }
    .search-input::placeholder { color: #94A3B8; }
    .live-indicator {
        display: flex; align-items: center; gap: 6px;
        font-size: .68rem; font-weight: 700; letter-spacing: .07em;
        text-transform: uppercase; color: #94A3B8; white-space: nowrap;
    }

    /* ── Alert Banner ── */
    .alert-banner { border-radius: 14px; overflow: hidden; border: 1.5px solid #FED7AA; box-shadow: 0 4px 14px rgba(234,88,12,.10); }
    .alert-inner  { background: #FFFBF5; padding: 16px 20px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; }
    .alert-icon-box { width: 38px; height: 38px; border-radius: 10px; background: #FEF3C7; color: #D97706; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .alert-tag  { font-size: .68rem; font-weight: 800; letter-spacing: .07em; text-transform: uppercase; color: #9A3412; }
    .alert-desc { font-size: .78rem; font-weight: 500; color: #92400E; margin-top: 2px; }
    .btn-revise {
        background: #fff; border: 1.5px solid #FED7AA; padding: 7px 14px; border-radius: 7px;
        font-size: .7rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
        color: #EA580C; text-decoration: none; transition: background .15s, transform .1s;
    }
    .btn-revise:hover { background: #EA580C; color: #fff; transform: translateY(-1px); }

    /* ── Table Card ── */
    .table-card {
        background: #fff; border: 1.5px solid #E2E8F0; border-radius: 14px;
        overflow: hidden; box-shadow: 0 1px 3px rgba(15,23,42,.05);
    }
    .tbl-author thead tr { background: #FAFBFC; }
    .tbl-author th {
        padding: 11px 22px; text-align: left;
        font-size: .67rem; font-weight: 800; letter-spacing: .1em;
        text-transform: uppercase; color: #94A3B8; border-bottom: 1.5px solid #E2E8F0;
    }
    .tbl-author th:last-child { text-align: right; }
    .tbl-author td { padding: 14px 22px; font-size: .82rem; border-bottom: 1px solid #F1F5F9; }
    .tbl-author tbody tr:last-child td { border-bottom: none; }
    .tbl-author tbody tr { transition: background .12s; cursor: pointer; }
    .tbl-author tbody tr:hover td { background: #F8FAFC; }
    .tbl-author tbody tr:hover .ms-title { color: #DC2626; }

    .ms-ref   { font-family: monospace; font-size: .72rem; color: #94A3B8; letter-spacing: .04em; }
    .ms-title { font-size: .83rem; font-weight: 600; color: #0F172A; transition: color .12s; }
    .ms-date  { font-size: .72rem; font-weight: 600; color: #94A3B8; text-transform: uppercase; letter-spacing: .04em; }

    /* ── Inline Chips ── */
    .chip-row {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px; border-radius: 20px; border: 1px solid transparent;
        font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
        margin-top: 7px;
    }
    .chip-row .dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .chip-row.emerald { background: #F0FDF4; border-color: #BBF7D0; color: #15803D; }
    .chip-row.emerald .dot { background: #16A34A; }
    .chip-row.red     { background: #FFF5F5; border-color: #FECACA; color: #B91C1C; }
    .chip-row.red .dot { background: #DC2626; }

    .comment-chip {
        display: flex; align-items: flex-start; gap: 8px;
        border-radius: 8px; padding: 8px 10px; margin-top: 6px; border: 1px solid transparent;
    }
    .comment-chip.purple { background: #FAF5FF; border-color: #E9D5FF; }
    .comment-chip.blue   { background: #EFF6FF; border-color: #BFDBFE; }
    .comment-chip svg { flex-shrink: 0; margin-top: 1px; }
    .comment-tag  { font-size: .62rem; font-weight: 800; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 2px; }
    .comment-tag.purple { color: #7C3AED; }
    .comment-tag.blue   { color: #1D4ED8; }
    .comment-text {
        font-size: .75rem; color: #475569; line-height: 1.5;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }

    /* ── Status Badges ── */
    .s-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 11px; border-radius: 20px;
        font-size: .68rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
        border: 1px solid transparent;
    }
    .s-badge .dot { width: 6px; height: 6px; border-radius: 50%; }
    .s-badge.accepted           { background:#F0FDF4; border-color:#BBF7D0; color:#15803D; }
    .s-badge.accepted .dot      { background:#16A34A; }
    .s-badge.under_review       { background:#EFF6FF; border-color:#BFDBFE; color:#1D4ED8; }
    .s-badge.under_review .dot  { background:#2563EB; }
    .s-badge.revisions_requested      { background:#FFF7ED; border-color:#FED7AA; color:#C2410C; }
    .s-badge.revisions_requested .dot { background:#EA580C; }
    .s-badge.rejected           { background:#FFF5F5; border-color:#FECACA; color:#B91C1C; }
    .s-badge.rejected .dot      { background:#DC2626; }
    .s-badge.submitted          { background:#F8FAFC; border-color:#E2E8F0; color:#475569; }
    .s-badge.submitted .dot     { background:#64748B; }

    /* ── Empty State ── */
    .empty-state-wrap { padding: 64px 24px; text-align: center; }
    .empty-icon { width: 56px; height: 56px; border-radius: 50%; background: #F8FAFC; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
    .empty-label { font-size: .72rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #CBD5E1; }

    /* ── Activity Stream ── */
    .activity-title { font-size: .68rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #94A3B8; margin-bottom: 14px; }
    .activity-card {
        background: #fff; border: 1.5px solid #E2E8F0; border-radius: 12px;
        padding: 14px 16px; display: flex; align-items: flex-start; gap: 10px;
        box-shadow: 0 1px 3px rgba(15,23,42,.04);
        transition: box-shadow .15s, transform .15s;
    }
    .activity-card:hover { box-shadow: 0 4px 12px rgba(15,23,42,.08); transform: translateY(-1px); }
    .activity-dot  { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
    .activity-name { font-size: .78rem; font-weight: 600; color: #0F172A; line-height: 1.4; margin-bottom: 3px; }
    .activity-time { font-size: .7rem; color: #94A3B8; font-weight: 500; }

    /* ── Animations ── */
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation: fadeUp .4s .07s ease both; }
    .fade-up-2 { animation: fadeUp .4s .14s ease both; }
    .fade-up-3 { animation: fadeUp .4s .21s ease both; }
    .fade-up-4 { animation: fadeUp .4s .28s ease both; }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(12px); }
        to   { opacity:1; transform:translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="author-wrap max-w-7xl mx-auto space-y-6">

    {{-- ── Page Header ── --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-up">
        <div>
            <h1 class="page-title">Author Workspace</h1>
            <p class="page-subtitle">Overview of your research and manuscript pipeline</p>
        </div>
        <div class="flex items-center gap-3 self-start md:self-auto">
            <span class="page-date-badge hidden sm:inline-block">{{ now()->format('D, M j Y') }}</span>
            <a href="{{ route('submissions.create') }}" class="btn-new-submission">+ New Submission</a>
        </div>
    </div>

    {{-- ── Stats Grid ── --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-4 fade-up-1">
        @foreach([
            ['label' => 'Total',                'value' => $stats['total'],                   'cls' => 'c-slate'],
            ['label' => 'Submitted',            'value' => $stats['submitted'],               'cls' => 'c-blue'],
            ['label' => 'Under Review',         'value' => $stats['under_review'],            'cls' => 'c-yellow'],
            ['label' => 'Revisions Requested',  'value' => $stats['revisions_requested'],     'cls' => 'c-orange'],
            ['label' => 'Revision Under Review','value' => $stats['revision_under_review'],   'cls' => 'c-amber'],
            ['label' => 'Accepted',             'value' => $stats['accepted'],                'cls' => 'c-emerald'],
            ['label' => 'Rejected',             'value' => $stats['rejected'],                'cls' => 'c-red'],
        ] as $stat)
        <div class="stat-card {{ $stat['cls'] }}">
            <span class="stat-label">{{ $stat['label'] }}</span>
            <p class="stat-number {{ $stat['cls'] }}">{{ sprintf('%02d', $stat['value']) }}</p>
        </div>
        @endforeach
    </div>

    {{-- ── Search Bar ── --}}
    <div class="search-bar fade-up-2">
        <div class="search-icon-wrap">
            <span class="search-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/>
                </svg>
            </span>
            <input type="text" id="dashboardSearch"
                placeholder="Filter manuscripts by title, ID, or status..."
                class="search-input" onkeyup="filterTable()">
        </div>
        <div class="live-indicator hidden md:flex">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            System Live
        </div>
    </div>

    {{-- ── Revision Alert ── --}}
    @if ($stats['revisions_requested'] > 0)
        @php $revisionsNeeded = auth()->user()->submissionsAsAuthor()->where('status', 'revisions_requested')->get(); @endphp
        <div class="alert-banner fade-up-2">
            <div class="alert-inner">
                <div class="flex items-center gap-3">
                    <div class="alert-icon-box">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="alert-tag">Action Required</p>
                        <p class="alert-desc">Reviewers submitted feedback on {{ $stats['revisions_requested'] }} paper(s).</p>
                    </div>
                </div>
                <div class="flex gap-2 flex-wrap">
                    @foreach($revisionsNeeded->take(2) as $rev)
                        <a href="{{ route('submissions.revisions', $rev) }}" class="btn-revise">Revise #{{ $rev->id }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ── Revision Decision Alert ── --}}
    @php 
        $revisionDecisions = auth()->user()->submissionsAsAuthor()
            ->whereIn('status', ['accepted', 'rejected'])
            ->where(function($query) {
                $query->where('decision_notes', '!=', null)
                      ->orWhere('editor_decision_at', '!=', null);
            })
            ->get();
    @endphp
    @if ($revisionDecisions->count() > 0)
        @php $latestDecision = $revisionDecisions->first(); @endphp
        <div class="alert-banner fade-up-2" style="border-color: {{ $latestDecision->status === 'accepted' ? '#86efac' : '#fecaca' }}; background: {{ $latestDecision->status === 'accepted' ? '#f0fdf4' : '#fffbf5' }};">
            <div class="alert-inner" style="background: {{ $latestDecision->status === 'accepted' ? '#f0fdf4' : '#fffbf5' }};">
                <div class="flex items-center gap-3">
                    <div class="alert-icon-box" style="background: {{ $latestDecision->status === 'accepted' ? '#dcfce7' : '#ffedd5' }}; color: {{ $latestDecision->status === 'accepted' ? '#22c55e' : '#ea580c' }}; border-radius: 10px;">
                        {{ $latestDecision->status === 'accepted' ? '✓' : '!' }}
                    </div>
                    <div>
                        <p class="alert-tag" style="color: {{ $latestDecision->status === 'accepted' ? '#15803d' : '#ea580c' }}; font-size: .68rem;">
                            {{ $latestDecision->status === 'accepted' ? 'DECISION: ACCEPTED' : 'DECISION: REJECTED' }}
                        </p>
                        <p class="alert-desc" style="color: {{ $latestDecision->status === 'accepted' ? '#166534' : '#7c2d12' }};">
                            The editor has made a final decision on your revised manuscript.
                        </p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('submissions.show', $latestDecision) }}" class="btn-revise" style="background: {{ $latestDecision->status === 'accepted' ? '#16a34a' : '#ea580c' }}; border-color: {{ $latestDecision->status === 'accepted' ? '#16a34a' : '#ea580c' }}; color: white !important; text-decoration: none;">
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
                    @forelse($submissions as $s)
                    <tr class="submission-row" onclick="window.location='{{ route('submissions.show', $s) }}'">
                        <td><span class="ms-ref">#{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                        <td>
                            <p class="ms-title title-cell">{{ $s->title }}</p>

                            @if($s->initial_screening_comments || $s->editor_notes || $s->initial_screening_status !== 'pending')
                            <div onclick="event.stopPropagation()">

                                {{-- Screening Status Chip --}}
                                @if($s->initial_screening_status === 'passed')
                                    <div class="chip-row emerald">
                                        <span class="dot"></span> Passed Initial Screening
                                    </div>
                                @elseif($s->initial_screening_status === 'failed')
                                    <div class="chip-row red">
                                        <span class="dot"></span> Failed Initial Screening
                                    </div>
                                @endif

                                {{-- Acceptance / Rejection Chip --}}
                                @if($s->status === 'accepted')
                                    <div class="chip-row emerald">
                                        <span class="dot"></span> Manuscript Accepted
                                    </div>
                                @elseif($s->status === 'rejected')
                                    <div class="chip-row red">
                                        <span class="dot"></span> Manuscript Rejected
                                    </div>
                                @endif

                                {{-- Screening Comments --}}
                                @if($s->initial_screening_comments)
                                <div class="comment-chip purple">
                                    <svg class="w-3 h-3 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2H6l-4 4V5z"/>
                                    </svg>
                                    <div>
                                        <p class="comment-tag purple">Screening Comments</p>
                                        <p class="comment-text">{{ $s->initial_screening_comments }}</p>
                                    </div>
                                </div>
                                @endif

                                {{-- Editor Notes --}}
                                @if($s->editor_notes)
                                <div class="comment-chip blue">
                                    <svg class="w-3 h-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2H6l-4 4V5z"/>
                                    </svg>
                                    <div>
                                        <p class="comment-tag blue">Editor's Note</p>
                                        <p class="comment-text">{{ $s->editor_notes }}</p>
                                    </div>
                                </div>
                                @endif

                            </div>
                            @endif
                        </td>
                        <td>
                            @php
                                $cls = match($s->status) {
                                    'accepted'              => 'accepted',
                                    'under_review'          => 'under_review',
                                    'revision_under_review' => 'under_review',
                                    'revisions_requested'   => 'revisions_requested',
                                    'rejected'              => 'rejected',
                                    default                 => 'submitted'
                                };
                                $displayStatus = match($s->status) {
                                    'revision_under_review' => 'Revision Under Review',
                                    default                 => str_replace('_', ' ', $s->status)
                                };
                            @endphp
                            <span class="s-badge {{ $cls }} status-cell">
                                <span class="dot"></span>
                                {{ ucfirst($displayStatus) }}
                            </span>
                        </td>
                        <td class="text-right">
                            <span class="ms-date">{{ $s->updated_at->format('d M Y') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state-wrap">
                                <div class="empty-icon">
                                    <svg class="w-7 h-7 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 4v16m8-8H4" stroke-width="2"/>
                                    </svg>
                                </div>
                                <p class="empty-label">No active manuscripts found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Activity Stream ── --}}
    @if($notifications->count() > 0)
    <div class="fade-up-4">
        <p class="activity-title">Live Activity Stream</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($notifications->take(3) as $notif)
            <div class="activity-card">
                <span class="activity-dot {{ $notif->isUnread() ? 'bg-red-500 animate-pulse' : 'bg-slate-200' }}"></span>
                <div class="flex-1">
                    <p class="activity-name">{{ $notif->title }}</p>
                    <p class="activity-time">{{ $notif->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

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
