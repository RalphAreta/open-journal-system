@extends('layouts.app')

@section('title', 'My Submissions')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Instrument Serif', serif; }
    .font-body          { font-family: 'DM Sans', sans-serif; }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation: fadeUp .4s .07s ease both; }
    .fade-up-2 { animation: fadeUp .4s .14s ease both; }
    .fade-up-3 { animation: fadeUp .4s .21s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
</style>
@endpush

@section('content')
<div class="font-body max-w-6xl mx-auto space-y-6">

    {{-- ── Header ── --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-up">
        <div>
            <h1 class="font-serif-display text-[1.85rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight">
                Manuscript Board
            </h1>
            <p class="text-sm text-slate-500 mt-1">Manage and monitor your research papers</p>
        </div>
        <div class="flex items-center gap-3 self-start md:self-auto">
            <span class="text-xs font-medium text-slate-400 bg-white border border-slate-200 px-3 py-1.5 rounded-full hidden sm:inline-block">
                {{ now()->format('D, M j Y') }}
            </span>
            <a href="{{ route('submissions.create') }}"
               class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white
                      px-5 py-2.5 rounded-[9px] text-[11px] font-bold uppercase tracking-[.07em]
                      transition-all hover:-translate-y-0.5 shadow-md shadow-red-100/80
                      hover:shadow-lg hover:shadow-red-200/50 whitespace-nowrap">
                + New Submission
            </a>
        </div>
    </div>

    {{-- ── Search Bar ── --}}
    <div class="bg-white border border-slate-200 rounded-[14px] p-3.5 shadow-sm flex flex-col md:flex-row gap-3 items-center fade-up-1">
        <div class="relative flex-1 w-full">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/>
                </svg>
            </span>
            <input type="text" id="boardSearch"
                placeholder="Search by title, status, or date..."
                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-[9px]
                       text-sm font-body text-slate-700 placeholder:text-slate-400
                       focus:outline-none focus:border-red-400 focus:bg-white focus:ring-2 focus:ring-red-500/10
                       transition-all"
                onkeyup="filterBoard()">
        </div>
        <div class="hidden md:flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-100 rounded-[9px]
                    text-[10px] font-bold uppercase tracking-[.07em] text-slate-400 whitespace-nowrap">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sync Active
        </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="bg-white border border-slate-200 rounded-[14px] overflow-hidden shadow-sm fade-up-2">
        <table class="w-full text-left" id="boardTable">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Manuscript Title</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Status</th>
                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Submitted</th>
                    <th class="px-6 py-3.5 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $s)
                <tr class="board-row border-b border-slate-100 last:border-0 hover:bg-slate-50/60 transition-colors group">
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-slate-900 group-hover:text-red-600 transition-colors title-cell leading-snug">
                            {{ Str::limit($s->title, 75) }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-mono mt-1">#{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $cls = match($s->status) {
                                'accepted'            => 'bg-emerald-50 border-emerald-200 text-emerald-700 [&_.dot]:bg-emerald-500',
                                'under_review'        => 'bg-blue-50 border-blue-200 text-blue-700 [&_.dot]:bg-blue-500',
                                'revisions_requested' => 'bg-orange-50 border-orange-200 text-orange-700 [&_.dot]:bg-orange-500',
                                'rejected'            => 'bg-red-50 border-red-200 text-red-700 [&_.dot]:bg-red-500',
                                default               => 'bg-slate-50 border-slate-200 text-slate-600 [&_.dot]:bg-slate-400',
                            };
                        @endphp
                        <span class="status-cell inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[10px] font-bold uppercase tracking-[.04em] {{ $cls }}">
                            <span class="dot w-1.5 h-1.5 rounded-full"></span>
                            {{ str_replace('_', ' ', $s->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="date-cell text-xs font-medium text-slate-500">
                            {{ $s->submitted_at?->format('M d, Y') ?? '—' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end items-center gap-3">
                            <a href="{{ route('submissions.show', $s) }}"
                               class="text-[11px] font-bold uppercase tracking-[.06em] text-slate-400 hover:text-slate-700 transition-colors">
                                View
                            </a>
                            @if($s->isEditableByAuthor())
                                <span class="text-slate-200 select-none">|</span>
                                <a href="{{ route('submissions.edit', $s) }}"
                                   class="text-[11px] font-bold uppercase tracking-[.06em] text-red-500 hover:text-red-700 transition-colors">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="text-[11px] font-bold uppercase tracking-widest text-slate-300">No manuscripts found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Pagination ── --}}
    @if($submissions->hasPages())
    <div class="fade-up-3">
        {{ $submissions->links() }}
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function filterBoard() {
        const filter = document.getElementById("boardSearch").value.toUpperCase();
        document.querySelectorAll(".board-row").forEach(row => {
            row.style.display = row.innerText.toUpperCase().includes(filter) ? "" : "none";
        });
    }
</script>
@endpush
