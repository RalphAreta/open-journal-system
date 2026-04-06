@extends('layouts.app')

@section('title', 'Layout Editor Dashboard')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
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
        }
        * { box-sizing: border-box; }
        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            font-size: 16px;
        }
        .aw-bg {
            background-color: var(--cream);
            background-image:
                radial-gradient(ellipse 80% 50% at 50% -10%, rgba(45,129,118,.08) 0%, transparent 70%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.5'/%3E%3C/svg%3E");
        }

        /* Hero */
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
            font-size: 11px; font-weight: 700;
            letter-spacing: .2em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 10px;
            display: flex; align-items: center; gap: 10px;
        }
        .hero-eyebrow::before {
            content: ''; width: 24px; height: 1px; background: var(--teal);
        }
        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.8rem; font-weight: 700;
            color: var(--ink); letter-spacing: -.01em; line-height: 1.15;
        }
        .hero-title em { font-style: italic; color: var(--teal); }
        .hero-sub { font-size: .98rem; font-weight: 400; color: var(--ink-soft); margin-top: 8px; }
        .date-pill {
            font-size: .78rem; font-weight: 600;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--ink-soft); background: var(--parchment);
            border: 1px solid var(--border);
            padding: 6px 16px; border-radius: 20px;
        }

        /* Stat Grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26,18,9,.07);
        }
        @media (max-width: 640px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }
        .stat-cell {
            padding: 24px 22px 18px;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            position: relative; transition: background .18s; cursor: default;
        }
        .stat-cell:hover { background: #fff; }
        .stat-cell:nth-child(4n) { border-right: none; }
        .stat-cell:nth-child(n+5) { border-bottom: none; }
        @media (max-width: 640px) {
            .stat-cell:nth-child(2n)  { border-right: none; }
            .stat-cell:nth-child(n+3) { border-bottom: none; }
            .stat-cell:nth-child(-n+2){ border-bottom: 1px solid var(--border); }
        }
        .stat-lbl {
            font-size: .68rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: var(--ink-soft); margin-bottom: 10px;
        }
        .stat-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.6rem; font-weight: 700; line-height: 1;
        }
        .stat-cell .accent-line {
            position: absolute; bottom: 0; left: 22px;
            height: 2px; width: 0; border-radius: 2px;
            transition: width .3s ease;
        }
        .stat-cell:hover .accent-line { width: 36px; }
        .sv-teal  { color: var(--teal); }
        .sv-gold  { color: var(--gold-dk); }
        .sv-slate { color: #64748b; }
        .al-teal  { background: var(--teal); }
        .al-gold  { background: var(--gold); }
        .al-slate { background: #64748b; }

        /* Table */
        .ms-table-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
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
            font-size: 1.15rem; font-weight: 700; color: var(--ink);
        }
        .ms-table-head-badge {
            font-size: .76rem; font-weight: 600; color: var(--teal);
            background: var(--teal-lt); border: 1px solid rgba(45,129,118,.25);
            padding: 4px 12px; border-radius: 20px;
        }
        table.mst { width: 100%; border-collapse: collapse; }
        table.mst thead tr { background: var(--parchment); border-bottom: 1.5px solid var(--border-dk); }
        table.mst th {
            padding: 12px 24px; font-size: .68rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase; color: var(--ink-soft); text-align: left;
        }
        table.mst th:last-child { text-align: right; }
        table.mst td {
            padding: 18px 24px; font-size: .92rem;
            border-bottom: 1px solid #f5f0e8; vertical-align: middle;
        }
        table.mst tbody tr:last-child td { border-bottom: none; }
        table.mst tbody tr { transition: background .1s; cursor: pointer; }
        table.mst tbody tr:hover td { background: var(--teal-lt); }
        .ms-ref {
            font-size: .76rem; font-weight: 700; color: var(--teal);
            letter-spacing: .06em; background: rgba(45,129,118,.07);
            border: 1px solid rgba(45,129,118,.22);
            padding: 3px 10px; border-radius: 4px; display: inline-block;
        }
        .ms-row-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem; font-style: italic; color: var(--ink); line-height: 1.4; margin-top: 4px;
            transition: color .12s;
        }
        table.mst tbody tr:hover .ms-row-title { color: var(--teal); }

        /* Status badges */
        .sbadge {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 5px 12px; border-radius: 20px;
            font-size: .7rem; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            border: 1px solid; white-space: nowrap;
        }
        .sbadge .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .sbadge.pending      { background: #fdf8ec; border-color: rgba(201,168,76,.4); color: var(--gold-dk); }
        .sbadge.pending .dot { background: var(--gold); }
        .sbadge.in_progress      { background: var(--teal-lt); border-color: rgba(45,129,118,.35); color: var(--teal-dk); }
        .sbadge.in_progress .dot { background: var(--teal); }
        .sbadge.completed      { background: #f0fdf4; border-color: #86efac; color: var(--teal-dk); }
        .sbadge.completed .dot { background: var(--teal); }

        /* Quick actions */
        .qa-wrap {
            background: #fff; border: 1px solid var(--border-dk);
            border-radius: 14px; overflow: hidden;
            box-shadow: 0 2px 16px rgba(26,18,9,.07);
        }
        .qa-head { padding: 16px 24px 14px; background: var(--parchment); border-bottom: 1px solid var(--border); }
        .qa-head-title { font-family: 'Libre Baskerville', serif; font-size: 1.05rem; font-weight: 700; color: var(--ink); }
        .qa-head-sub { font-size: .76rem; color: var(--ink-soft); margin-top: 2px; }
        .qa-body { padding: 16px; display: flex; flex-direction: column; gap: 10px; }
        .qa-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 14px; border-radius: 10px; border: 1px solid;
            text-decoration: none; transition: all .15s;
        }
        .qa-item:hover { transform: translateY(-1px); }
        .qa-icon {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .qa-label { font-size: .88rem; font-weight: 700; color: var(--ink); }
        .qa-sub   { font-size: .72rem; color: var(--ink-soft); margin-top: 1px; }

        /* Revision alert */
        .alert-strip { border-radius: 10px; overflow: hidden; border: 1px solid; display: flex; align-items: stretch; }
        .alert-strip-accent { width: 5px; flex-shrink: 0; }
        .alert-strip-body { flex: 1; padding: 16px 20px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; }

        /* Empty state */
        .empty-state { padding: 60px 24px; text-align: center; }
        .empty-state-icon {
            width: 60px; height: 60px; border-radius: 50%;
            background: var(--parchment); border: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;
        }

        /* Animations */
        .fu  { animation: fu .45s ease both; }
        .fu1 { animation: fu .45s .08s ease both; }
        .fu2 { animation: fu .45s .16s ease both; }
        .fu3 { animation: fu .45s .24s ease both; }
        .fu4 { animation: fu .45s .32s ease both; }
        @keyframes fu {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes shimmer {
            0%   { background-position: -100% 0; }
            100% { background-position:  100% 0; }
        }
        .shimmer-bar {
            background: linear-gradient(90deg, transparent, #c9a84c, #f0d678, #c9a84c, transparent);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }
    </style>
@endpush

@section('content')
    <div class="h-0.5 w-full shimmer-bar"></div>

    <div class="aw aw-bg max-w-7xl mx-auto px-4">

        {{-- Hero --}}
        <div class="hero-header fu">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <div>
                    <p class="hero-eyebrow">Layout Editor Portal</p>
                    <h1 class="hero-title">Your <em>Layout</em> Workspace</h1>
                    <p class="hero-sub">Manage layouts, format submissions, and prepare publications</p>
                </div>
                <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                    <span class="date-pill hidden sm:inline-block">{{ now()->format('D, M j Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Stat Grid --}}
        <div class="stat-grid fu1 mb-10">
            @foreach ([
                ['For Layout',  $pendingReviewCount,    'sv-gold',  'al-gold'],
                ['In Progress', $inProgressCount,        'sv-teal',  'al-teal'],
                ['Completed',   $completedCount,          'sv-teal',  'al-teal'],
                ['Total',       $assignments->total(),   'sv-slate', 'al-slate'],
            ] as [$lbl, $val, $vc, $ac])
                <div class="stat-cell">
                    <p class="stat-lbl">{{ $lbl }}</p>
                    <p class="stat-val {{ $vc }}">{{ sprintf('%02d', $val) }}</p>
                    <div class="accent-line {{ $ac }}"></div>
                </div>
            @endforeach
        </div>

        {{-- Revision Alert --}}
        @php
            $revisionAssignments = $assignments->filter(fn($a) =>
                $a->status === 'pending' && str_starts_with($a->notes ?? '', 'Author revision request:')
            );
        @endphp

        @if ($revisionAssignments->count())
            <div class="fu2 mb-6">
                <div class="alert-strip" style="border-color:rgba(201,168,76,.4);background:#fffdf5;">
                    <div class="alert-strip-accent" style="background:var(--gold);"></div>
                    <div class="alert-strip-body">
                        <div class="flex items-center gap-3">
                            <div style="width:38px;height:38px;border-radius:8px;background:#fdf8ec;color:var(--gold-dk);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:.7rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--gold-dk);margin-bottom:2px;">
                                    Author Revision Request{{ $revisionAssignments->count() > 1 ? 's' : '' }}
                                </p>
                                <p style="font-size:.9rem;color:var(--ink-mid);">
                                    {{ $revisionAssignments->count() }} {{ Str::plural('paper', $revisionAssignments->count()) }}
                                    need{{ $revisionAssignments->count() === 1 ? 's' : '' }} layout revision based on author feedback
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($revisionAssignments->take(2) as $ra)
                                <a href="{{ route('layout-editor.show', $ra->id) }}"
                                   style="font-size:.76rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:7px 16px;border-radius:5px;text-decoration:none;border:1.5px solid rgba(201,168,76,.5);color:var(--gold-dk);transition:all .15s;white-space:nowrap;">
                                    Revise — {{ Str::limit($ra->submission->title, 28) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 fu3">

            {{-- Quick Actions --}}
            <div class="md:col-span-1 qa-wrap self-start">
                <div class="qa-head">
                    <p class="qa-head-title">Quick Actions</p>
                    <p class="qa-head-sub">Common layout tasks</p>
                </div>
                <div class="qa-body">
                    <a href="#" class="qa-item" style="background:rgba(45,129,118,.05);border-color:rgba(45,129,118,.18);">
                        <span class="qa-icon" style="background:var(--teal);color:#fff;">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" width="18" height="18">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="qa-label">Assigned Papers</p>
                            <p class="qa-sub">Papers pending layout</p>
                        </div>
                    </a>
                    <a href="#" class="qa-item" style="background:rgba(201,168,76,.05);border-color:rgba(201,168,76,.2);">
                        <span class="qa-icon" style="background:var(--gold);color:#fff;">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" width="18" height="18">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                            </svg>
                        </span>
                        <div>
                            <p class="qa-label">Submit Layout</p>
                            <p class="qa-sub">Upload formatted file</p>
                        </div>
                    </a>
                    <a href="#" class="qa-item" style="background:#f8f9fa;border-color:#e9ecef;">
                        <span class="qa-icon" style="background:#e2e8f0;color:#64748b;">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" width="18" height="18">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="qa-label">Layout History</p>
                            <p class="qa-sub">Previously completed</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Assigned Papers Table --}}
            <div class="md:col-span-3 ms-table-wrap">
                <div class="ms-table-head">
                    <span class="ms-table-head-title">Assigned Papers</span>
                    <span class="ms-table-head-badge">
                        {{ $assignments->total() }} {{ Str::plural('record', $assignments->total()) }}
                    </span>
                </div>
                <div class="overflow-x-auto">
                    @if ($assignments->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg fill="none" stroke="#c9b99a" viewBox="0 0 24 24" width="28" height="28">
                                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                            </div>
                            <p style="font-size:.78rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#c9b99a;">No papers assigned yet</p>
                            <p style="font-size:.88rem;color:#b5a595;margin-top:6px;">Papers assigned to you will appear here</p>
                        </div>
                    @else
                        <table class="mst">
                            <thead>
                                <tr>
                                    <th style="width:110px;">Ref No.</th>
                                    <th>Paper Title</th>
                                    <th style="width:130px;">Author</th>
                                    <th style="width:150px;">Status</th>
                                    <th style="width:80px;text-align:right;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    <tr onclick="window.location='{{ route('layout-editor.show', $assignment->id) }}'">
                                        <td>
                                            <span class="ms-ref">#{{ str_pad($assignment->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td>
                                            <p class="ms-row-title">{{ $assignment->submission->title }}</p>
                                            @if ($assignment->notes && str_starts_with($assignment->notes, 'Author revision request:'))
                                                <span style="margin-top:6px;display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:5px;background:#fdf8ec;border:1px solid rgba(201,168,76,.35);font-size:.7rem;font-weight:700;color:var(--gold-dk);">
                                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="10" height="10">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                                    </svg>
                                                    Revision Requested
                                                </span>
                                            @endif
                                        </td>
                                        <td style="color:var(--ink-soft);font-size:.88rem;">
                                            {{ $assignment->submission->author->name ?? 'Unknown' }}
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match($assignment->status) {
                                                    'in_progress' => 'in_progress',
                                                    'completed'   => 'completed',
                                                    default       => 'pending',
                                                };
                                            @endphp
                                            <span class="sbadge {{ $statusClass }}">
                                                <span class="dot"></span>
                                                {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                                            </span>
                                        </td>
                                        <td style="text-align:right;">
                                            <a href="{{ route('layout-editor.show', $assignment->id) }}"
                                               onclick="event.stopPropagation()"
                                               style="display:inline-flex;align-items:center;gap:4px;font-size:.76rem;font-weight:700;color:var(--teal);text-decoration:none;letter-spacing:.04em;white-space:nowrap;">
                                                Open
                                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="13" height="13">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if (method_exists($assignments, 'hasPages') && $assignments->hasPages())
                            <div style="padding:16px 24px;border-top:1px solid var(--border);">
                                {{ $assignments->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection