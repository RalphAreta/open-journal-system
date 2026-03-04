@extends('layouts.app')

@section('title', 'Layout Editor Dashboard')

@push('styles')
    <style>
        .aw-bg {
            background-color: #faf6ef;
            background-image:
                radial-gradient(ellipse 80% 50% at 50% -10%, rgba(45,129,118,0.08) 0%, transparent 70%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.5'/%3E%3C/svg%3E");
        }
        .hero-header::after {
            content: '';
            position: absolute;
            bottom: -1px; left: 0;
            width: 80px; height: 3px;
            background: linear-gradient(90deg, #2d8176, transparent);
        }
        .hero-eyebrow::before {
            content: '';
            width: 24px; height: 1px;
            background: #2d8176;
        }
        .stat-cell .accent-line {
            position: absolute;
            bottom: 0; left: 22px;
            height: 2px; width: 0;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        .stat-cell:hover .accent-line { width: 36px; }
        .ms-row-title { transition: color 0.12s; }
        table.mst tbody tr:hover .ms-row-title { color: #2d8176; }
        .note-chip-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .fu  { animation: fu 0.45s ease both; }
        .fu1 { animation: fu 0.45s 0.08s ease both; }
        .fu2 { animation: fu 0.45s 0.16s ease both; }
        .fu3 { animation: fu 0.45s 0.24s ease both; }
        .fu4 { animation: fu 0.45s 0.32s ease both; }
        @keyframes fu {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
@endpush

@section('content')
    <div class="aw-bg max-w-7xl mx-auto px-1 font-['Source_Sans_3'] text-[#1a1209] text-base">

        {{-- Hero --}}
        <div class="hero-header relative pt-11 pb-8 border-b border-[#e8dfd0] mb-9 fu">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <div>
                    <p class="hero-eyebrow flex items-center gap-2.5 text-[11px] font-bold tracking-[0.2em] uppercase text-[#2d8176] mb-2.5">
                        Layout Editor Dashboard
                    </p>
                    <h1 class="font-['Libre_Baskerville'] text-[2.8rem] font-bold text-[#1a1209] tracking-tight leading-[1.15]">
                         <em class="italic text-[#2d8176]">Layout</em> Queue
                    </h1>
                    <p class="text-[0.98rem] text-[#6b5740] mt-2">
                        Manage assigned papers, format submissions, and prepare publications
                    </p>
                </div>
                <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                    <span class="hidden sm:inline-block text-[0.78rem] font-semibold tracking-[0.06em] uppercase text-[#6b5740] bg-[#f3ece0] border border-[#e8dfd0] px-4 py-1.5 rounded-full">
                        {{ now()->format('D, M j Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="fu1 mb-10 grid grid-cols-2 md:grid-cols-4 bg-[#f3ece0] border border-[#c9b99a] rounded-2xl overflow-hidden shadow-sm">
            @foreach ([
                ['For Layout',  $stats['for_layout']  ?? 0, 'text-[#2d8176]', 'bg-[#2d8176]'],
                ['In Progress', $stats['in_progress'] ?? 0, 'text-[#8a6e28]', 'bg-[#c9a84c]'],
                ['For Review',  $stats['for_review']  ?? 0, 'text-[#a07830]', 'bg-[#a07830]'],
                ['Published',   $stats['published']   ?? 0, 'text-[#1a4d46]', 'bg-[#1a4d46]'],
            ] as [$lbl, $val, $vc, $ac])
                <div class="stat-cell relative p-6 pb-5 border-r border-b border-[#e8dfd0] last:border-r-0 [&:nth-child(n+3)]:border-b-0 max-md:[&:nth-child(2n)]:border-r-0 max-md:[&:nth-child(-n+2)]:border-b hover:bg-white transition-colors cursor-default">
                    <p class="text-[0.68rem] font-bold tracking-[0.1em] uppercase text-[#6b5740] mb-2.5">{{ $lbl }}</p>
                    <p class="font-['Libre_Baskerville'] text-[2.6rem] font-bold leading-none {{ $vc }}">
                        {{ sprintf('%02d', $val) }}
                    </p>
                    <div class="accent-line {{ $ac }}"></div>
                </div>
            @endforeach
        </div>

        {{-- New Assignment Alert --}}
        @php
            $newAssignments = isset($papers) ? $papers->where('layout_status', 'for_layout') : collect();
        @endphp

        @if ($newAssignments->count() > 0)
            <div class="fu2 mb-4 rounded-[10px] overflow-hidden border border-[rgba(45,129,118,0.35)] bg-[#f5fdfb] flex items-stretch">
                <div class="w-[5px] shrink-0 bg-[#2d8176]"></div>
                <div class="flex-1 px-5 py-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-[38px] h-[38px] shrink-0 rounded-lg bg-[#e8f4f2] text-[#2d8176] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[0.7rem] font-[800] tracking-[0.12em] uppercase text-[#1a4d46] mb-0.5">New Assignment</p>
                            <p class="text-[0.9rem] text-[#3d2f1a]">
                                {{ $newAssignments->count() }} {{ $newAssignments->count() === 1 ? 'paper has' : 'papers have' }} been assigned for layout
                            </p>
                        </div>
                    </div>
                    <a href="#submissionsTable" class="text-[0.76rem] font-bold tracking-[0.06em] uppercase px-4 py-[7px] rounded-[5px] border border-[rgba(45,129,118,0.35)] text-[#1a4d46] hover:bg-[#e8f4f2] transition-all whitespace-nowrap">
                        View Papers →
                    </a>
                </div>
            </div>
        @endif

        {{-- Search --}}
        <div class="fu2 mb-6 relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-[18px] h-[18px] text-[#6b5740] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/>
            </svg>
            <input
                type="text"
                id="dashboardSearch"
                class="w-full bg-white border-[1.5px] border-[#e8dfd0] rounded-lg py-[13px] pr-[18px] pl-12 font-['Source_Sans_3'] text-[0.95rem] text-[#1a1209] outline-none shadow-sm transition-all placeholder-[#b5a595] focus:border-[#2d8176] focus:shadow-[0_0_0_3px_rgba(45,129,118,0.12)]"
                placeholder="Filter by title, reference number, author, or status…"
                onkeyup="filterTable()"
            />
        </div>

        {{-- Papers Table --}}
        <div class="fu3 bg-white border border-[#c9b99a] rounded-2xl overflow-hidden shadow-[0_2px_16px_rgba(26,18,9,0.07)]" id="submissionsTable">
            <div class="px-7 py-4 bg-[#f3ece0] border-b border-[#e8dfd0] flex items-center justify-between">
                <span class="font-['Libre_Baskerville'] text-[1.15rem] font-bold text-[#1a1209]">Assigned Papers</span>
                <span class="text-[0.76rem] font-semibold text-[#6b5740] bg-[#faf6ef] border border-[#e8dfd0] px-3 py-1 rounded-full">
                    {{ isset($papers) ? (method_exists($papers, 'total') ? $papers->total() : $papers->count()) : 0 }} records
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="mst w-full border-collapse">
                    <thead>
                        <tr class="bg-[#f3ece0] border-b-[1.5px] border-[#c9b99a]">
                            <th class="px-6 py-3 text-left text-[0.68rem] font-bold tracking-[0.1em] uppercase text-[#6b5740] w-[110px]">Ref No.</th>
                            <th class="px-6 py-3 text-left text-[0.68rem] font-bold tracking-[0.1em] uppercase text-[#6b5740]">Manuscript Title &amp; Author</th>
                            <th class="px-6 py-3 text-left text-[0.68rem] font-bold tracking-[0.1em] uppercase text-[#6b5740] w-[170px]">Layout Status</th>
                            <th class="px-6 py-3 text-right text-[0.68rem] font-bold tracking-[0.1em] uppercase text-[#6b5740] w-[120px]">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($papers ?? [] as $paper)
                            <tr
                                class="paper-row border-b border-[#f5f0e8] last:border-b-0 hover:bg-[#e8f4f2] transition-colors cursor-pointer"
                                onclick="window.location='{{ route('layout.papers.show', $paper) }}'"
                            >
                                <td class="px-6 py-[18px] text-[0.92rem] align-top">
                                    <span class="inline-block text-[0.76rem] font-bold text-[#2d8176] tracking-[0.06em] bg-[rgba(45,129,118,0.07)] border border-[rgba(45,129,118,0.22)] px-2.5 py-[3px] rounded">
                                        #{{ str_pad($paper->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-6 py-[18px] text-[0.92rem] align-top">
                                    <p class="ms-row-title title-cell font-['Libre_Baskerville'] text-[1.05rem] italic text-[#1a1209] leading-[1.4] mt-1">
                                        {{ $paper->title }}
                                    </p>
                                    <p class="author-cell text-[0.82rem] text-[#6b5740] mt-1">
                                        {{ $paper->author->name ?? $paper->author_name ?? '—' }}
                                    </p>

                                    @if ($paper->layout_notes || $paper->editor_notes)
                                        <div onclick="event.stopPropagation()" class="mt-2 space-y-1">
                                            @if ($paper->layout_notes)
                                                <div class="flex items-start gap-2 mt-2 px-3 py-[9px] rounded-[7px] bg-[#e8f4f2] border-l-[3px] border-[#2d8176]">
                                                    <div class="mt-px">
                                                        <p class="text-[0.65rem] font-[800] tracking-[0.1em] uppercase text-[#1a4d46] mb-[3px]">Layout Note</p>
                                                        <p class="note-chip-text text-[0.85rem] text-[#6b5740] leading-[1.5]">{{ $paper->layout_notes }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($paper->editor_notes)
                                                <div class="flex items-start gap-2 mt-2 px-3 py-[9px] rounded-[7px] bg-[#fdf8ec] border-l-[3px] border-[#c9a84c]">
                                                    <div class="mt-px">
                                                        <p class="text-[0.65rem] font-[800] tracking-[0.1em] uppercase text-[#8a6e28] mb-[3px]">Editor's Note</p>
                                                        <p class="note-chip-text text-[0.85rem] text-[#6b5740] leading-[1.5]">{{ $paper->editor_notes }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-[18px] text-[0.92rem] align-top">
                                    @php
                                        $badge = match ($paper->layout_status ?? 'for_layout') {
                                            'in_progress' => ['In Progress', 'bg-[#fdf8ec] border-[rgba(201,168,76,0.4)] text-[#8a6e28]', 'bg-[#c9a84c]'],
                                            'for_review'  => ['For Review',  'bg-[#fff7ed] border-[#fed7aa] text-[#9a3412]',              'bg-[#f97316]'],
                                            'published'   => ['Published',   'bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]',              'bg-[#2d8176]'],
                                            default       => ['For Layout',  'bg-[#e8f4f2] border-[rgba(45,129,118,0.35)] text-[#1a4d46]','bg-[#2d8176]'],
                                        };
                                    @endphp
                                    <span class="status-cell inline-flex items-center gap-[7px] px-3 py-[5px] rounded-full text-[0.7rem] font-bold tracking-[0.06em] uppercase border whitespace-nowrap {{ $badge[1] }}">
                                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $badge[2] }}"></span>
                                        {{ $badge[0] }}
                                    </span>
                                </td>
                                <td class="px-6 py-[18px] text-[0.92rem] align-top text-right">
                                    <span class="text-[0.78rem] font-semibold text-[#6b5740] tracking-[0.04em] whitespace-nowrap">
                                        {{ $paper->updated_at->format('d M Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-[80px] text-center">
                                    <div class="w-16 h-16 rounded-full bg-[#f3ece0] border border-[#e8dfd0] flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="#c9b99a" viewBox="0 0 24 24">
                                            <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <p class="text-[0.78rem] font-bold tracking-[0.14em] uppercase text-[#c9b99a]">No papers assigned yet</p>
                                    <p class="text-[0.88rem] text-[#b5a595] mt-1.5">Papers assigned to you will appear here</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (isset($papers) && method_exists($papers, 'hasPages') && $papers->hasPages())
            <div class="fu4 mt-5">{{ $papers->links() }}</div>
        @endif

    </div>
@endsection

@push('scripts')
    <script>
        function filterTable() {
            const f = document.getElementById('dashboardSearch').value.toUpperCase();
            document.querySelectorAll('.paper-row').forEach(row => {
                const title  = row.querySelector('.title-cell')?.innerText.toUpperCase()  ?? '';
                const author = row.querySelector('.author-cell')?.innerText.toUpperCase() ?? '';
                const ref    = row.cells[0]?.innerText.toUpperCase()                      ?? '';
                const status = row.querySelector('.status-cell')?.innerText.toUpperCase() ?? '';
                row.style.display = (title.includes(f) || author.includes(f) || ref.includes(f) || status.includes(f)) ? '' : 'none';
            });
        }

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Confirmed</span>',
            html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
            confirmButtonText: 'Close',
            confirmButtonColor: '#2d8176',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest' },
            buttonsStyling: false,
        });
        @endif
    </script>
@endpush