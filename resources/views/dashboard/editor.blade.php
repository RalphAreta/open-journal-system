@extends('layouts.app')

@section('title', 'Editor Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .editor-wrap { font-family: 'DM Sans', sans-serif; }

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
    .stat-card:hover { box-shadow: 0 6px 20px rgba(15,23,42,.09); transform: translateY(-2px); }
    .stat-card:hover::before { opacity: 1; }

    .stat-card.c-slate::before  { background: linear-gradient(135deg,#F8FAFC 0%,transparent 60%); }
    .stat-card.c-blue::before   { background: linear-gradient(135deg,#EFF6FF 0%,transparent 60%); }
    .stat-card.c-amber::before  { background: linear-gradient(135deg,#FFFBEB 0%,transparent 60%); }
    .stat-card.c-red::before    { background: linear-gradient(135deg,#FFF5F5 0%,transparent 60%); }

    .stat-card.c-slate:hover  { border-color: #CBD5E1; }
    .stat-card.c-blue:hover   { border-color: #BFDBFE; }
    .stat-card.c-amber:hover  { border-color: #FDE68A; }
    .stat-card.c-red:hover    { border-color: #FECACA; }

    .stat-label { font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #64748B; }
    .stat-icon-box {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
    }
    .stat-icon-box.c-slate  { background: #F1F5F9; }
    .stat-icon-box.c-blue   { background: #DBEAFE; }
    .stat-icon-box.c-amber  { background: #FEF3C7; }
    .stat-icon-box.c-red    { background: #FEE2E2; }

    .stat-number { font-family: 'Instrument Serif', serif; font-size: 2.4rem; line-height: 1; margin-top: 12px; }
    .stat-number.c-slate  { color: #0F172A; }
    .stat-number.c-blue   { color: #2563EB; }
    .stat-number.c-amber  { color: #D97706; }
    .stat-number.c-red    { color: #DC2626; }
    .stat-hint { font-size: .72rem; color: #94A3B8; margin-top: 5px; }

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
    .btn-view-all {
        display: inline-flex; align-items: center; gap: 6px;
        background: #1E293B; color: #fff;
        font-size: .76rem; font-weight: 600;
        padding: 8px 16px; border-radius: 8px;
        text-decoration: none;
        transition: background .15s, transform .1s, box-shadow .15s;
        letter-spacing: .01em;
    }
    .btn-view-all:hover {
        background: #0F172A; transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(15,23,42,.18);
    }

    .tbl-editor thead tr { background: #FAFBFC; }
    .tbl-editor th {
        padding: 11px 22px; text-align: left;
        font-size: .67rem; font-weight: 800; letter-spacing: .1em;
        text-transform: uppercase; color: #94A3B8;
        border-bottom: 1.5px solid #E2E8F0;
    }
    .tbl-editor th:last-child { text-align: right; }
    .tbl-editor td { padding: 14px 22px; font-size: .82rem; border-bottom: 1px solid #F1F5F9; color: #0F172A; }
    .tbl-editor tbody tr:last-child td { border-bottom: none; }
    .tbl-editor tbody tr { transition: background .12s; }
    .tbl-editor tbody tr:hover td { background: #F8FAFC; }
    .tbl-editor tbody tr:hover .ms-title { color: #DC2626; }

    .ms-title  { font-size: .83rem; font-weight: 600; color: #0F172A; transition: color .12s; }
    .ms-author { font-size: .82rem; color: #475569; }
    .ms-actions { text-align: right; }

    /* Status badges */
    .s-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 11px; border-radius: 20px;
        font-size: .68rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
        border: 1px solid transparent;
    }
    .s-badge .dot { width: 6px; height: 6px; border-radius: 50%; }
    .s-badge.submitted         { background:#EFF6FF; border-color:#BFDBFE; color:#1D4ED8; }
    .s-badge.submitted .dot    { background:#2563EB; }
    .s-badge.under_review      { background:#FFFBEB; border-color:#FDE68A; color:#B45309; }
    .s-badge.under_review .dot { background:#D97706; }
    .s-badge.accepted          { background:#F0FDF4; border-color:#BBF7D0; color:#15803D; }
    .s-badge.accepted .dot     { background:#16A34A; }
    .s-badge.rejected          { background:#FFF5F5; border-color:#FECACA; color:#B91C1C; }
    .s-badge.rejected .dot     { background:#DC2626; }
    .s-badge.default           { background:#F8FAFC; border-color:#E2E8F0; color:#475569; }
    .s-badge.default .dot      { background:#64748B; }

    .btn-manage {
        display: inline-flex; align-items: center; gap: 5px;
        background: #DC2626; color: #fff;
        font-size: .75rem; font-weight: 600;
        padding: 7px 14px; border-radius: 7px; text-decoration: none;
        transition: background .15s, transform .1s;
    }
    .btn-manage:hover { background: #B91C1C; transform: translateY(-1px); }

    /* Empty State */
    .empty-state-wrap { padding: 56px 24px; text-align: center; }
    .empty-icon {
        width: 52px; height: 52px; border-radius: 50%;
        background: #F8FAFC; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px;
    }
    .empty-label { font-size: .72rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #CBD5E1; }

    /* ── Animations ── */
    .fade-up   { animation: fadeUp .4s ease both; }
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
<div class="editor-wrap">

    {{-- ── Page Header ── --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-7 fade-up">
        <div>
            <h1 class="page-title">Editor Dashboard</h1>
            <p class="page-subtitle">Review and manage submissions</p>
        </div>
        <span class="page-date-badge hidden sm:inline-block">{{ now()->format('D, M j Y') }}</span>
    </div>

    {{-- ── Stats Grid ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 fade-up-1">
        <div class="stat-card c-slate">
            <div class="flex items-center justify-between">
                <span class="stat-label">Total Submissions</span>
                <div class="stat-icon-box c-slate">📊</div>
            </div>
            <p class="stat-number c-slate">{{ $stats['total'] }}</p>
            <p class="stat-hint">All submissions</p>
        </div>
        <div class="stat-card c-blue">
            <div class="flex items-center justify-between">
                <span class="stat-label">New (Submitted)</span>
                <div class="stat-icon-box c-blue">📥</div>
            </div>
            <p class="stat-number c-blue">{{ $stats['submitted'] }}</p>
            <p class="stat-hint">Awaiting distribution</p>
        </div>
        <div class="stat-card c-amber">
            <div class="flex items-center justify-between">
                <span class="stat-label">Under Review</span>
                <div class="stat-icon-box c-amber">📋</div>
            </div>
            <p class="stat-number c-amber">{{ $stats['under_review'] }}</p>
            <p class="stat-hint">With reviewers</p>
        </div>
        <div class="stat-card c-red">
            <div class="flex items-center justify-between">
                <span class="stat-label">Decision Pending</span>
                <div class="stat-icon-box c-red">⏳</div>
            </div>
            <p class="stat-number c-red">{{ $stats['decisions_pending'] }}</p>
            <p class="stat-hint">Awaiting your decision</p>
        </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="table-card fade-up-2">
        <div class="table-card-header">
            <span class="table-card-title">Recent Submissions</span>
            <a href="{{ route('editor.submissions') }}" class="btn-view-all">
                View All →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full tbl-editor">
                <thead>
                    <tr>
                        <th class="w-1/2">Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $s)
                    <tr>
                        <td><p class="ms-title">{{ Str::limit($s->title, 45) }}</p></td>
                        <td><span class="ms-author">{{ $s->author->name ?? '-' }}</span></td>
                        <td>
                            @php
                                $cls = match($s->status) {
                                    'submitted'    => 'submitted',
                                    'under_review' => 'under_review',
                                    'accepted'     => 'accepted',
                                    'rejected'     => 'rejected',
                                    default        => 'default'
                                };
                            @endphp
                            <span class="s-badge {{ $cls }}">
                                <span class="dot"></span>
                                {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                            </span>
                        </td>
                        <td class="ms-actions">
                            <a href="{{ route('editor.submission.show', $s) }}" class="btn-manage">
                                Manage
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state-wrap">
                                <div class="empty-icon">
                                    <svg class="w-7 h-7 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.5"/>
                                    </svg>
                                </div>
                                <p class="empty-label">No submissions available</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 text-sm text-slate-400">
            {{ $submissions->links() }}
        </div>
    </div>

</div>
@endsection