@extends('layouts.app')

@section('title', 'Author Dashboard')

@push('styles')
    <style>
        /* ── Libre Baskerville + Source Sans 3 are already loaded by layouts/app.blade.php ── */
        :root {
            --teal:       #2d8176;
            --teal-dk:    #1a4d46;
            --teal-lt:    #e8f4f2;
            --gold:       #c9a84c;
            --gold-lt:    #e8d49a;
            --gold-dk:    #8a6e28;
            --ink:        #1a1209;
            --ink-mid:    #3d2f1a;
            --ink-soft:   #6b5740;
            --cream:      #faf6ef;
            --parchment:  #f3ece0;
            --border:     #e8dfd0;
            --border-dk:  #c9b99a;
        }

        * { box-sizing: border-box; }

        /* Base: Source Sans 3 for all UI copy */
        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            font-size: 16px; /* raised base from ~13px */
        }

        /* Display: Libre Baskerville for headings — matches nav/footer */
        .serif { font-family: 'Libre Baskerville', serif; }

        /* ── Background ── */
        .aw-bg {
            background-color: var(--cream);
            background-image:
                radial-gradient(ellipse 80% 50% at 50% -10%,
                    rgba(45,129,118,.08) 0%, transparent 70%),
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
            bottom: -1px; left: 0;
            width: 80px; height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .hero-eyebrow {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px; font-weight: 700;
            letter-spacing: .2em; text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 10px;
            display: flex; align-items: center; gap: 10px;
        }
        .hero-eyebrow::before {
            content: ''; width: 24px; height: 1px;
            background: var(--teal);
        }
        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.8rem; font-weight: 700;  /* bold, not 300 */
            color: var(--ink); letter-spacing: -.01em; line-height: 1.15;
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .98rem; font-weight: 400;
            color: var(--ink-soft); margin-top: 8px; letter-spacing: .01em;
        }
        .date-pill {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .78rem; font-weight: 600;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--ink-soft);
            background: var(--parchment);
            border: 1px solid var(--border);
            padding: 6px 16px; border-radius: 20px;
        }
        .btn-submit {
            display: inline-flex; align-items: center; gap: 9px;
            background: var(--teal);
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-size: .82rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            padding: 12px 26px; border-radius: 6px;
            text-decoration: none;
            transition: background .15s, transform .12s, box-shadow .15s;
            box-shadow: 0 4px 14px rgba(45,129,118,.30);
            position: relative; overflow: hidden;
        }
        .btn-submit::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg,
                rgba(201,168,76,.18) 0%, transparent 60%);
        }
        .btn-submit:hover {
            background: var(--teal-dk);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(45,129,118,.36);
        }

        /* ── Stat Grid ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px; overflow: hidden;
            box-shadow: 0 2px 12px rgba(26,18,9,.07);
        }
        @media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 560px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }

        .stat-cell {
            padding: 24px 22px 18px;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            position: relative; transition: background .18s; cursor: default;
        }
        .stat-cell:hover { background: #fff; }
        .stat-cell:last-child,
        .stat-cell:nth-child(6) { border-right: none; }
        .stat-cell:nth-child(n+5) { border-bottom: none; }

        @media (max-width: 900px) {
            .stat-cell:nth-child(3n)   { border-right: none; }
            .stat-cell:nth-child(n+4)  { border-bottom: none; }
            .stat-cell:nth-child(-n+3) { border-bottom: 1px solid var(--border); }
        }

        .stat-lbl {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .68rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: var(--ink-soft); margin-bottom: 10px;
        }
        .stat-val {
            /* Libre Baskerville numerals look authoritative */
            font-family: 'Libre Baskerville', serif;
            font-size: 2.6rem; font-weight: 700; line-height: 1;
        }
        .stat-cell .accent-line {
            position: absolute; bottom: 0; left: 22px;
            height: 2px; width: 0; border-radius: 2px;
            transition: width .3s ease;
        }
        .stat-cell:hover .accent-line { width: 36px; }

        .sv-teal    { color: var(--teal); }
        .sv-gold    { color: var(--gold-dk); }
        .sv-orange  { color: #c2410c; }
        .sv-amber   { color: #a07830; }
        .sv-emerald { color: var(--teal-dk); }
        .sv-red     { color: #c0392b; }

        .al-teal    { background: var(--teal); }
        .al-gold    { background: var(--gold); }
        .al-orange  { background: #ea580c; }
        .al-amber   { background: #a07830; }
        .al-emerald { background: var(--teal-dk); }
        .al-red     { background: #c0392b; }

        /* ── Search ── */
        .search-wrap { position: relative; }
        .search-wrap svg {
            position: absolute; left: 16px; top: 50%;
            transform: translateY(-50%);
            color: var(--ink-soft); pointer-events: none;
            width: 18px; height: 18px;
        }
        .search-inp {
            width: 100%;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 13px 18px 13px 48px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: .95rem; color: var(--ink);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            box-shadow: 0 1px 4px rgba(26,18,9,.05);
        }
        .search-inp:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45,129,118,.12);
        }
        .search-inp::placeholder { color: #b5a595; }

        /* ── Alert Banner ── */
        .alert-strip {
            border-radius: 10px; overflow: hidden;
            border: 1px solid;
            display: flex; align-items: stretch;
        }
        .alert-strip-accent { width: 5px; flex-shrink: 0; }
        .alert-strip-body {
            flex: 1; padding: 16px 20px;
            display: flex; flex-wrap: wrap;
            align-items: center; justify-content: space-between; gap: 12px;
        }
        .alert-tag {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .7rem; font-weight: 800;
            letter-spacing: .12em; text-transform: uppercase; margin-bottom: 3px;
        }
        .alert-desc {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .9rem; font-weight: 400;
        }
        .btn-alert-action {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .76rem; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            padding: 7px 16px; border-radius: 5px;
            text-decoration: none; border: 1.5px solid;
            transition: all .15s; white-space: nowrap;
        }

        /* ── Table ── */
        .ms-table-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px; overflow: hidden;
            box-shadow: 0 2px 16px rgba(26,18,9,.07);
        }
        .ms-table-head {
            padding: 16px 28px 14px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .ms-table-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.15rem; font-weight: 700;
            color: var(--ink); letter-spacing: .01em;
        }
        .ms-table-head-count {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .76rem; font-weight: 600;
            color: var(--ink-soft);
            background: var(--cream);
            border: 1px solid var(--border);
            padding: 4px 12px; border-radius: 20px;
        }

        table.mst { width: 100%; border-collapse: collapse; }
        table.mst thead tr {
            background: var(--parchment);
            border-bottom: 1.5px solid var(--border-dk);
        }
        table.mst th {
            padding: 12px 24px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: .68rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: var(--ink-soft); text-align: left;
        }
        table.mst th:last-child { text-align: right; }
        table.mst td {
            padding: 18px 24px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: .92rem;
            border-bottom: 1px solid #f5f0e8; vertical-align: top;
        }
        table.mst tbody tr:last-child td { border-bottom: none; }
        table.mst tbody tr { transition: background .1s; cursor: pointer; }
        table.mst tbody tr:hover td { background: var(--teal-lt); }
        table.mst tbody tr:hover .ms-row-title { color: var(--teal); }

        .ms-ref {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .76rem; font-weight: 700;
            color: var(--teal);
            letter-spacing: .06em;
            background: rgba(45,129,118,.07);
            border: 1px solid rgba(45,129,118,.22);
            padding: 3px 10px; border-radius: 4px;
            display: inline-block;
        }
        .ms-row-title {
            /* Libre Baskerville for manuscript titles — feels academic */
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem; font-weight: 400; font-style: italic;
            color: var(--ink); line-height: 1.4; margin-top: 5px;
            transition: color .12s;
        }

        /* Status badges */
        .sbadge {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 5px 12px; border-radius: 20px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: .7rem; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            border: 1px solid; white-space: nowrap;
        }
        .sbadge .dot {
            width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
        }

        .sbadge.submitted     { background: var(--teal-lt); border-color: rgba(45,129,118,.35); color: var(--teal-dk); }
        .sbadge.submitted     .dot { background: var(--teal); }

        .sbadge.under_review  { background: #fdf8ec; border-color: rgba(201,168,76,.4); color: var(--gold-dk); }
        .sbadge.under_review  .dot { background: var(--gold); }

        .sbadge.revisions_requested { background: #fff7ed; border-color: #fed7aa; color: #9a3412; }
        .sbadge.revisions_requested .dot { background: #f97316; }

        .sbadge.revision_review { background: #fefce8; border-color: #fde68a; color: #78350f; }
        .sbadge.revision_review .dot { background: #f59e0b; }

        .sbadge.accepted      { background: #f0fdf4; border-color: #86efac; color: var(--teal-dk); }
        .sbadge.accepted      .dot { background: var(--teal); }

        .sbadge.rejected      { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .sbadge.rejected      .dot { background: #c0392b; }

        /* Note chips */
        .note-chip {
            display: flex; align-items: flex-start; gap: 8px;
            margin-top: 8px; padding: 9px 12px;
            border-radius: 7px; border-left: 3px solid;
        }
        .note-chip.teal    { background: var(--teal-lt); border-color: var(--teal); }
        .note-chip.gold    { background: #fdf8ec;        border-color: var(--gold); }
        .note-chip.emerald { background: #f0fdf4;        border-color: var(--teal-dk); }
        .note-chip.red     { background: #fef2f2;        border-color: #c0392b; }

        .note-chip-tag {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .65rem; font-weight: 800;
            letter-spacing: .1em; text-transform: uppercase; margin-bottom: 3px;
        }
        .note-chip.teal    .note-chip-tag { color: var(--teal-dk); }
        .note-chip.gold    .note-chip-tag { color: var(--gold-dk); }
        .note-chip.emerald .note-chip-tag { color: var(--teal-dk); }
        .note-chip.red     .note-chip-tag { color: #991b1b; }

        .note-chip-text {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .85rem; color: var(--ink-soft); line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ms-date {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .78rem; font-weight: 600;
            color: var(--ink-soft); letter-spacing: .04em; white-space: nowrap;
        }

        /* Empty state */
        .empty-state { padding: 80px 24px; text-align: center; }
        .empty-state-icon {
            width: 64px; height: 64px; border-radius: 50%;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }
        .empty-state-label {
            font-family: 'Source Sans 3', sans-serif;
            font-size: .78rem; font-weight: 700;
            letter-spacing: .14em; text-transform: uppercase; color: #c9b99a;
        }

        /* Fade animations */
        .fu  { animation: fu .45s ease both; }
        .fu1 { animation: fu .45s .08s ease both; }
        .fu2 { animation: fu .45s .16s ease both; }
        .fu3 { animation: fu .45s .24s ease both; }
        .fu4 { animation: fu .45s .32s ease both; }
        @keyframes fu {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-7xl mx-auto px-1">

        {{-- ── Hero Header ── --}}
        <div class="hero-header fu">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <div>
                    <p class="hero-eyebrow">Author Workspace</p>
                    <h1 class="hero-title">
                        Your <em>Manuscript</em> Pipeline
                    </h1>
                    <p class="hero-sub">
                        Track submissions, revisions, and editorial decisions in one place
                    </p>
                </div>
                <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                    <span class="date-pill hidden sm:inline-block">
                        {{ now()->format('D, M j Y') }}
                    </span>
                    <a href="{{ route('submissions.create') }}" class="btn-submit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Submission
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Stats Grid ── --}}
        <div class="stat-grid fu1 mb-10">
            @foreach ([
                ['Submitted',            $stats['submitted'],            'sv-teal',   'al-teal'],
                ['Under Review',         $stats['under_review'],         'sv-gold',   'al-gold'],
                ['Revisions Requested',  $stats['revisions_requested'],  'sv-orange', 'al-orange'],
                ['Revision Under Review',$stats['revision_under_review'],'sv-amber',  'al-amber'],
                ['Accepted',             $stats['accepted'],             'sv-emerald','al-emerald'],
                ['Rejected',             $stats['rejected'],             'sv-red',    'al-red'],
            ] as [$lbl, $val, $vc, $ac])
                <div class="stat-cell">
                    <p class="stat-lbl">{{ $lbl }}</p>
                    <p class="stat-val {{ $vc }}">{{ sprintf('%02d', $val) }}</p>
                    <div class="accent-line {{ $ac }}"></div>
                </div>
            @endforeach
        </div>

        {{-- ── Search ── --}}
        <div class="fu2 mb-6">
            <div class="search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/>
                </svg>
                <input
                    type="text"
                    id="dashboardSearch"
                    class="search-inp"
                    placeholder="Filter by title, reference number, or status…"
                    onkeyup="filterTable()"
                />
            </div>
        </div>

        {{-- ── Revision Alert ── --}}
        @if ($stats['revisions_requested'] > 0)
            @php
                $revisionsNeeded = auth()->user()
                    ->submissionsAsAuthor()
                    ->where('status', 'revisions_requested')
                    ->orderBy('updated_at', 'desc')
                    ->get();
            @endphp
            <div class="fu2 mb-4">
                <div class="alert-strip" style="border-color:#fed7aa;background:#fffdf9;">
                    <div class="alert-strip-accent" style="background:#f97316;"></div>
                    <div class="alert-strip-body">
                        <div class="flex items-center gap-3">
                            <div style="width:38px;height:38px;border-radius:8px;background:#fff7ed;color:#ea580c;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="alert-tag" style="color:#9a3412;">Action Required</p>
                                <p class="alert-desc" style="color:#7c2d12;">
                                    {{ $stats['revisions_requested'] }}
                                    manuscript{{ $stats['revisions_requested'] > 1 ? 's require' : ' requires' }} your attention
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($revisionsNeeded->take(2) as $rev)
                                <a href="{{ route('submissions.show', $rev) }}" class="btn-alert-action"
                                   style="color:#ea580c;border-color:#fed7aa;">
                                    Revise #{{ str_pad($rev->id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Final Decision Alert ── --}}
        @php
            $revisionDecisions = auth()->user()
                ->submissionsAsAuthor()
                ->whereIn('status', ['accepted', 'rejected'])
                ->where(function ($q) {
                    $q->where('editor_notes', '!=', null)->orWhere('editor_decision_at', '!=', null);
                })
                ->orderBy('updated_at', 'desc')
                ->get();
        @endphp

        @if ($revisionDecisions->count() > 0)
            @php $ld = $revisionDecisions->first(); $isAcc = $ld->status === 'accepted'; @endphp
            <div class="fu2 mb-4">
                <div class="alert-strip" style="
                    border-color: {{ $isAcc ? 'rgba(45,129,118,.35)' : '#fecaca' }};
                    background:   {{ $isAcc ? '#f5fdfb' : '#fffafa' }};
                ">
                    <div class="alert-strip-accent" style="background:{{ $isAcc ? 'var(--teal)' : '#dc2626' }};"></div>
                    <div class="alert-strip-body">
                        <div class="flex items-center gap-3">
                            <div style="width:38px;height:38px;border-radius:8px;
                                background:{{ $isAcc ? 'var(--teal-lt)' : '#fef2f2' }};
                                color:{{ $isAcc ? 'var(--teal)' : '#dc2626' }};
                                display:flex;align-items:center;justify-content:center;
                                font-size:1.1rem;flex-shrink:0;font-family:'Libre Baskerville',serif;font-weight:700;">
                                {{ $isAcc ? '✓' : '✕' }}
                            </div>
                            <div>
                                <p class="alert-tag" style="color:{{ $isAcc ? 'var(--teal-dk)' : '#991b1b' }};">
                                    Final Decision: {{ $isAcc ? 'Accepted' : 'Rejected' }}
                                </p>
                                <p class="alert-desc" style="color:{{ $isAcc ? 'var(--teal-dk)' : '#7f1d1d' }};">
                                    The editor has issued a final decision on your revised manuscript
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('submissions.show', $ld) }}" class="btn-alert-action"
                           style="color:{{ $isAcc ? 'var(--teal-dk)' : '#991b1b' }};
                                  border-color:{{ $isAcc ? 'rgba(45,129,118,.35)' : '#fecaca' }};">
                            View Details →
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Manuscripts Table ── --}}
        <div class="ms-table-wrap fu3">
            <div class="ms-table-head">
                <span class="ms-table-head-title">Manuscripts</span>
                <span class="ms-table-head-count">
                    {{ $submissions->total() ?? $submissions->count() }} records
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="mst" id="submissionsTable">
                    <thead>
                        <tr>
                            <th style="width:110px">Ref No.</th>
                            <th>Manuscript Title &amp; Notes</th>
                            <th style="width:170px">Status</th>
                            <th style="width:120px;text-align:right">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $s)
                            <tr class="submission-row"
                                onclick="window.location='{{ route('submissions.show', $s) }}'">
                                <td>
                                    <span class="ms-ref">
                                        #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>
                                    {{-- Manuscript title: italic Libre Baskerville — academic convention --}}
                                    <p class="ms-row-title title-cell">{{ $s->title }}</p>

                                    @if ($s->initial_screening_comments || $s->editor_notes || $s->initial_screening_status !== 'pending')
                                        <div onclick="event.stopPropagation()" class="mt-2 space-y-1">

                                            @if ($s->initial_screening_comments)
                                                <div class="note-chip teal">
                                                    <div style="margin-top:1px;">
                                                        <p class="note-chip-tag">Screening Note</p>
                                                        <p class="note-chip-text">{{ $s->initial_screening_comments }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($s->editor_notes)
                                                <div class="note-chip gold">
                                                    <div style="margin-top:1px;">
                                                        <p class="note-chip-tag">Editor's Note</p>
                                                        <p class="note-chip-text">{{ $s->editor_notes }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            @php $appeal = $s->appeals()->latest()->first(); @endphp
                                            @if ($appeal)
                                                <div class="note-chip {{ $appeal->status === 'approved' ? 'emerald' : 'red' }}">
                                                    <div style="margin-top:1px;">
                                                        <p class="note-chip-tag">Appeal {{ ucfirst($appeal->status) }}</p>
                                                        <p class="note-chip-text">
                                                            {{ $appeal->editor_response ?? 'Awaiting editor-in-chief review…' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $cls = match ($s->status) {
                                            'accepted'             => 'accepted',
                                            'under_review'         => 'under_review',
                                            'revision_under_review'=> 'revision_review',
                                            'revisions_requested'  => 'revisions_requested',
                                            'rejected'             => 'rejected',
                                            default                => 'submitted',
                                        };
                                        $label = match ($s->status) {
                                            'revision_under_review' => 'Revision Review',
                                            default => ucfirst(str_replace('_', ' ', $s->status)),
                                        };
                                    @endphp
                                    <span class="sbadge {{ $cls }} status-cell">
                                        <span class="dot"></span>{{ $label }}
                                    </span>
                                </td>
                                <td style="text-align:right">
                                    <span class="ms-date">{{ $s->updated_at->format('d M Y') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <svg class="w-8 h-8" fill="none" stroke="#c9b99a" viewBox="0 0 24 24">
                                                <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                      stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <p class="empty-state-label">No manuscripts found</p>
                                        <p style="font-size:.88rem;color:#b5a595;margin-top:6px;">
                                            Submit your first manuscript to get started
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if (method_exists($submissions, 'hasPages') && $submissions->hasPages())
            <div class="fu4 mt-5">{{ $submissions->links() }}</div>
        @endif

    </div>
@endsection

@push('scripts')
    <script>
        function filterTable() {
            const f = document.getElementById('dashboardSearch').value.toUpperCase();
            document.querySelectorAll('.submission-row').forEach(row => {
                const title  = row.querySelector('.title-cell')?.innerText.toUpperCase() ?? '';
                const ref    = row.cells[0]?.innerText.toUpperCase() ?? '';
                const status = row.querySelector('.status-cell')?.innerText.toUpperCase() ?? '';
                row.style.display = (title.includes(f) || ref.includes(f) || status.includes(f)) ? '' : 'none';
            });
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Confirmed</span>',
                html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
                confirmButtonText: 'Close',
                confirmButtonColor: '#2d8176',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'
                },
                buttonsStyling: false,
            });
        @endif
    </script>
@endpush
