@extends('layouts.app')

@section('title', 'Managing Editor Dashboard')

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
            bottom: -1px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .hero-eyebrow {
            font-family: 'Source Sans 3', sans-serif;
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
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.98rem;
            font-weight: 400;
            color: var(--ink-soft);
            margin-top: 8px;
            letter-spacing: 0.01em;
        }
        .date-pill {
            font-family: 'Source Sans 3', sans-serif;
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

        /* Stat Grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        @media (max-width: 700px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-cell {
            padding: 24px 22px 18px;
            border-right: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            position: relative;
            transition: background 0.18s;
            cursor: default;
        }
        .stat-cell:hover {
            background: #fff;
        }
        .stat-cell:nth-child(4n) {
            border-right: none;
        }
        .stat-cell:nth-last-child(-n + 4) {
            border-bottom: none;
        }

        .stat-lbl {
            font-family: 'Source Sans 3', sans-serif;
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

        .sv-teal {
            color: var(--teal);
        }
        .sv-gold {
            color: var(--gold-dk);
        }
        .sv-emerald {
            color: var(--teal-dk);
        }
        .sv-amber {
            color: #a07830;
        }

        .al-teal {
            background: var(--teal);
        }
        .al-gold {
            background: var(--gold);
        }
        .al-emerald {
            background: var(--teal-dk);
        }
        .al-amber {
            background: #a07830;
        }

        /* Search */
        .search-wrap {
            position: relative;
        }
        .search-wrap svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-soft);
            pointer-events: none;
            width: 18px;
            height: 18px;
        }
        .search-inp {
            width: 100%;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 13px 18px 13px 48px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.95rem;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            box-shadow: 0 1px 4px rgba(26, 18, 9, 0.05);
        }
        .search-inp:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
        }
        .search-inp::placeholder {
            color: #b5a595;
        }

        /* Table */
        .ms-table-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
        }
        .ms-table-head {
            padding: 16px 28px 14px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ms-table-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: 0.01em;
        }
        .ms-table-head-count {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.76rem;
            font-weight: 600;
            color: var(--ink-soft);
            background: var(--cream);
            border: 1px solid var(--border);
            padding: 4px 12px;
            border-radius: 20px;
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
            padding: 12px 24px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.68rem;
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
            padding: 18px 24px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.92rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: top;
        }
        table.mst tbody tr:last-child td {
            border-bottom: none;
        }
        table.mst tbody tr {
            transition: background 0.1s;
        }
        table.mst tbody tr:hover td {
            background: var(--teal-lt);
        }
        table.mst tbody tr:hover .ms-row-title {
            color: var(--teal);
        }

        .ms-ref {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.76rem;
            font-weight: 700;
            color: var(--teal);
            letter-spacing: 0.06em;
            background: rgba(45, 129, 118, 0.07);
            border: 1px solid rgba(45, 129, 118, 0.22);
            padding: 3px 10px;
            border-radius: 4px;
            display: inline-block;
        }
        .ms-row-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            font-weight: 400;
            font-style: italic;
            color: var(--ink);
            line-height: 1.4;
            margin-top: 5px;
            transition: color 0.12s;
        }
        .ms-author {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.8rem;
            color: var(--ink-soft);
            margin-top: 3px;
        }

        /* Status badges */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            border-radius: 20px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.7rem;
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

        .sbadge.pending-me {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.pending-me .dot {
            background: var(--gold);
        }

        .sbadge.ctf-sent {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.ctf-sent .dot {
            background: var(--teal);
        }

        .sbadge.forwarded {
            background: #f0fdf4;
            border-color: #86efac;
            color: var(--teal-dk);
        }
        .sbadge.forwarded .dot {
            background: var(--teal-dk);
        }

        /* Action buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 7px 14px;
            border-radius: 6px;
            text-decoration: none;
            border: 1.5px solid;
            transition: all 0.15s;
            white-space: nowrap;
            cursor: pointer;
            background: none;
        }
        .btn-action.teal {
            color: var(--teal);
            border-color: rgba(45, 129, 118, 0.35);
        }
        .btn-action.teal:hover {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 4px 12px rgba(45, 129, 118, 0.25);
        }
        .btn-action.gold {
            color: var(--gold-dk);
            border-color: rgba(201, 168, 76, 0.4);
        }
        .btn-action.gold:hover {
            background: var(--gold);
            color: #fff;
            box-shadow: 0 4px 12px rgba(201, 168, 76, 0.25);
        }

        /* Alert strip */
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
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .alert-desc {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
        }

        .ms-date {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--ink-soft);
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        /* Empty state */
        .empty-state {
            padding: 80px 24px;
            text-align: center;
        }
        .empty-state-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .empty-state-label {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }

        /* Fade animations */
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
    <div class="aw aw-bg max-w-7xl mx-auto px-1">
        {{-- Hero Header --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Managing Editor Workspace</p>
                    <h1 class="hero-title">
                        Editorial
                        <em>Production</em>
                        Pipeline
                    </h1>
                    <p class="hero-sub">
                        Manage accepted manuscripts, issue copyright transfer
                        forms, and forward to layout
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

        {{-- Stats Grid --}}
        <div class="stat-grid fu1 mb-10">
            @foreach ([
                    ['Awaiting CTF', $stats['pending'], 'sv-gold', 'al-gold'],
                    ['CTF Sent', $stats['ctf_sent'], 'sv-teal', 'al-teal'],
                    ['Sent to Layout', $stats['forwarded'], 'sv-emerald', 'al-emerald'],
                    ['Total Handled', $stats['total'], 'sv-amber', 'al-amber']
                ]
                as [$lbl, $val, $vc, $ac])
                <div class="stat-cell">
                    <p class="stat-lbl">{{ $lbl }}</p>
                    <p class="stat-val {{ $vc }}">
                        {{ sprintf('%02d', $val) }}
                    </p>
                    <div class="accent-line {{ $ac }}"></div>
                </div>
            @endforeach
        </div>

        {{-- Alert: manuscripts awaiting CTF --}}
        @if ($stats['pending'] > 0)
            <div class="fu2 mb-4">
                <div
                    class="alert-strip"
                    style="
                        border-color: rgba(201, 168, 76, 0.4);
                        background: #fffdf9;
                    "
                >
                    <div
                        class="alert-strip-accent"
                        style="background: var(--gold)"
                    ></div>
                    <div class="alert-strip-body">
                        <div class="flex items-center gap-3">
                            <div
                                style="
                                    width: 38px;
                                    height: 38px;
                                    border-radius: 8px;
                                    background: #fdf8ec;
                                    color: var(--gold-dk);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                "
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p
                                    class="alert-tag"
                                    style="color: var(--gold-dk)"
                                >
                                    Action Required
                                </p>
                                <p
                                    class="alert-desc"
                                    style="color: var(--ink-mid)"
                                >
                                    {{ $stats['pending'] }}
                                    manuscript{{ $stats['pending'] > 1 ? 's are' : ' is' }}
                                    awaiting copyright transfer form
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Search --}}
        <div class="fu2 mb-6">
            <div class="search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        stroke-width="2.5"
                    />
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

        {{-- Manuscripts Table --}}
        <div class="ms-table-wrap fu3">
            <div class="ms-table-head">
                <span class="ms-table-head-title">Assigned Manuscripts</span>
                <span class="ms-table-head-count">
                    {{ $submissions->count() }}
                    records
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="mst" id="submissionsTable">
                    <thead>
                        <tr>
                            <th style="width: 110px">Ref No.</th>
                            <th>Manuscript Title &amp; Author</th>
                            <th style="width: 170px">Status</th>
                            <th style="width: 200px">Actions</th>
                            <th style="width: 120px; text-align: right">
                                Updated
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $s)
                            <tr class="submission-row">
                                <td>
                                    <span class="ms-ref">
                                        #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>
                                    <p class="ms-row-title title-cell">
                                        {{ $s->title }}
                                    </p>
                                    <p class="ms-author">
                                        by
                                        {{ $s->author->name ?? 'Unknown Author' }}
                                    </p>
                                </td>
                                <td>
                                    @php
                                        $meStatus = $s->managing_editor_status ?? 'pending';
                                        [$cls, $label] = match ($meStatus) {
                                            'ctf_sent' => ['ctf-sent', 'CTF Sent'],
                                            'forwarded' => ['forwarded', 'Sent to Layout'],
                                            default => ['pending-me', 'Awaiting CTF'],
                                        };
                                    @endphp

                                    <span
                                        class="sbadge {{ $cls }} status-cell"
                                    >
                                        <span class="dot"></span>
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-2">
                                        {{-- View button (always visible) --}}
                                        <a
                                            href="{{ route('managing-editor.submission.show', $s) }}"
                                            class="btn-action teal"
                                        >
                                            <svg
                                                width="12"
                                                height="12"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"
                                                />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                            View
                                        </a>

                                        {{-- Generate CTF (shown when pending) --}}
                                        @if ($meStatus === 'pending')
                                            <a href="#" class="btn-action gold">
                                                <svg
                                                    width="12"
                                                    height="12"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                    />
                                                </svg>
                                                Generate CTF
                                            </a>
                                        @endif

                                        {{-- Send to Layout (shown when CTF sent) --}}
                                        @if ($meStatus === 'ctf_sent')
                                            <a href="#" class="btn-action teal">
                                                <svg
                                                    width="12"
                                                    height="12"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M13 5l7 7-7 7M5 5l7 7-7 7"
                                                    />
                                                </svg>
                                                Send to Layout
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td style="text-align: right">
                                    <span class="ms-date">
                                        {{ $s->updated_at->format('d M Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <svg
                                                class="w-8 h-8"
                                                fill="none"
                                                stroke="#c9b99a"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </div>
                                        <p class="empty-state-label">
                                            No manuscripts assigned yet
                                        </p>
                                        <p
                                            style="
                                                font-size: 0.88rem;
                                                color: #b5a595;
                                                margin-top: 6px;
                                            "
                                        >
                                            Manuscripts accepted by editors will
                                            appear here
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
                title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Done</span>',
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
