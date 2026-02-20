@extends('layouts.app')

@section('title', 'My Submissions')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    {{-- Clean Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manuscript Board</h1>
            <p class="text-sm text-slate-500 font-medium">Manage and monitor your research papers</p>
        </div>
        <a href="{{ route('submissions.create') }}" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-center shadow-lg shadow-red-100">
            + New Submission
        </a>
    </div>

    {{-- Functional Action Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 group w-full">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/></svg>
            </span>
            <input type="text" id="boardSearch" placeholder="Search by title, status, or date..."
                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-red-500/20 transition-all outline-none"
                onkeyup="filterBoard()">
        </div>
        <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-xl border border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sync Active
        </div>
    </div>

    {{-- Main Table Section --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse" id="boardTable">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Manuscript Title</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Submitted</th>
                    <th class="px-6 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($submissions as $s)
                    <tr class="board-row hover:bg-slate-50/50 transition-colors group cursor-default">
                        <td class="px-6 py-5">
                            <p class="text-sm font-bold text-slate-900 group-hover:text-red-600 transition-colors title-cell">{{ Str::limit($s->title, 75) }}</p>
                            <p class="text-[10px] text-slate-400 font-mono mt-1">ID: #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $statusColor = match($s->status) {
                                    'accepted' => 'emerald',
                                    'under_review' => 'blue',
                                    'revisions_requested' => 'orange',
                                    'rejected' => 'red',
                                    'submitted' => 'slate',
                                    default => 'slate'
                                };
                            @endphp
                            <span class="status-cell inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-{{ $statusColor }}-50 text-{{ $statusColor }}-700 border border-{{ $statusColor }}-100 text-[10px] font-black uppercase tracking-tighter">
                                <span class="w-1 h-1 rounded-full bg-{{ $statusColor }}-600"></span>
                                {{ str_replace('_', ' ', $s->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="date-cell text-xs font-medium text-slate-500">{{ $s->submitted_at?->format('M d, Y') ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('submissions.show', $s) }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-600 transition-colors">
                                    View
                                </a>
                                @if($s->isEditableByAuthor())
                                    <span class="text-slate-200">|</span>
                                    <a href="{{ route('submissions.edit', $s) }}" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:text-red-800 transition-colors">
                                        Edit
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 text-slate-300 mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round"/></svg>
                            </div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">No manuscripts found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Simple Pagination --}}
    @if($submissions->hasPages())
        <div class="mt-4">
            {{ $submissions->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    /**
     * Board Search Logic
     * Filters Title, ID, Status, and Date
     */
    function filterBoard() {
        const input = document.getElementById("boardSearch");
        const filter = input.value.toUpperCase();
        const rows = document.querySelectorAll(".board-row");

        rows.forEach(row => {
            const text = row.innerText.toUpperCase(); // Grabs all text in the row

            if (text.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>
@endpush
@endsection
