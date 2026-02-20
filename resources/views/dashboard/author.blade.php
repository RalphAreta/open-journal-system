@extends('layouts.app')

@section('title', 'Author Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-2">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Author Workspace</h1>
            <p class="text-sm text-slate-500 font-medium">Overview of your research and manuscript pipeline</p>
        </div>
        <a href="{{ route('submissions.create') }}" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-center shadow-lg shadow-red-100">
            + New Submission
        </a>
    </div>

    {{-- Re-integrated Full Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach([
            ['label' => 'Total Submissions', 'value' => $stats['total'], 'color' => 'slate-900', 'bg' => 'slate-50'],
            ['label' => 'Submitted', 'value' => $stats['submitted'], 'color' => 'blue-600', 'bg' => 'blue-50/50'],
            ['label' => 'Under Review', 'value' => $stats['under_review'], 'color' => 'yellow-600', 'bg' => 'yellow-50/50'],
            ['label' => 'Revisions', 'value' => $stats['revisions_requested'], 'color' => 'orange-600', 'bg' => 'orange-50/50'],
            ['label' => 'Accepted', 'value' => $stats['accepted'], 'color' => 'emerald-600', 'bg' => 'emerald-50/50'],
            ['label' => 'Rejected', 'value' => $stats['rejected'], 'color' => 'red-600', 'bg' => 'red-50/50'],
        ] as $stat)
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 leading-tight">{{ $stat['label'] }}</p>
                <p class="text-3xl font-black text-{{ $stat['color'] }}">{{ sprintf('%02d', $stat['value']) }}</p>
            </div>
        @endforeach
    </div>

    {{-- Action Bar with Working Search --}}
    <div class="flex flex-col md:flex-row gap-4 items-center bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="relative flex-1 group">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/></svg>
            </span>
            <input type="text" id="dashboardSearch" placeholder="Filter manuscripts by title, ID, or status..."
                class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-red-500/20 transition-all outline-none"
                onkeyup="filterTable()">
        </div>
        <div class="hidden md:flex items-center gap-2 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            System Live
        </div>
    </div>

    {{-- Urgent Revision Alert --}}
    @if ($stats['revisions_requested'] > 0)
        @php $revisionsNeeded = auth()->user()->submissionsAsAuthor()->where('status', 'revisions_requested')->get(); @endphp
        <div class="bg-orange-600 rounded-2xl p-1 shadow-lg shadow-orange-100">
            <div class="bg-orange-50 rounded-[14px] p-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 text-orange-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"/></svg>
                    </span>
                    <div>
                        <p class="text-sm font-black text-orange-950 uppercase tracking-tight">Action Required</p>
                        <p class="text-xs font-medium text-orange-800">Reviewers have submitted feedback on {{ $stats['revisions_requested'] }} paper(s).</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    @foreach($revisionsNeeded->take(2) as $rev)
                        <a href="{{ route('submissions.revisions', $rev) }}" class="bg-white border border-orange-200 px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest text-orange-700 hover:bg-orange-600 hover:text-white transition-all shadow-sm">
                            Revise #{{ $rev->id }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Main Submissions Table --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left" id="submissionsTable">
            <thead class="bg-slate-50/50 border-b border-slate-200">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Reference</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 w-1/2">Manuscript Title</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Last Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($submissions as $s)
                    <tr class="submission-row hover:bg-slate-50/80 transition-all cursor-pointer group" onclick="window.location='{{ route('submissions.show', $s) }}'">
                        <td class="px-8 py-6 font-mono text-[11px] text-slate-400">#{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-900 group-hover:text-red-600 transition-colors title-cell">{{ $s->title }}</p>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $color = match($s->status) {
                                    'accepted' => 'emerald',
                                    'under_review' => 'blue',
                                    'revisions_requested' => 'orange',
                                    'rejected' => 'red',
                                    default => 'slate'
                                };
                            @endphp
                            <div class="status-cell inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-{{ $color }}-50 border border-{{ $color }}-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $color }}-500"></span>
                                <span class="text-[9px] font-black uppercase tracking-widest text-{{ $color }}-700">
                                    {{ str_replace('_', ' ', $s->status) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tabular-nums">
                                {{ $s->updated_at->format('d M Y') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2"/></svg>
                                </div>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">No active manuscripts found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Bottom Activity Bar --}}
    @if($notifications->count() > 0)
    <div class="pt-4">
        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Live Activity Stream</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($notifications->take(3) as $notif)
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-3">
                    <span class="w-2 h-2 rounded-full mt-1.5 {{ $notif->isUnread() ? 'bg-red-500 animate-pulse' : 'bg-slate-200' }}"></span>
                    <div class="flex-1">
                        <p class="text-[11px] font-bold text-slate-900 leading-tight mb-1">{{ $notif->title }}</p>
                        <p class="text-[10px] text-slate-500 font-medium">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    /**
     * Optimized Live Search
     * Searches Title, ID, and Status badge
     */
    function filterTable() {
        const input = document.getElementById("dashboardSearch");
        const filter = input.value.toUpperCase();
        const rows = document.querySelectorAll(".submission-row");

        rows.forEach(row => {
            const title = row.querySelector(".title-cell").innerText.toUpperCase();
            const id = row.cells[0].innerText.toUpperCase();
            const status = row.querySelector(".status-cell").innerText.toUpperCase();

            if (title.includes(filter) || id.includes(filter) || status.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '<span class="text-sm font-black uppercase tracking-widest">Confirmed</span>',
            html: '<p class="text-xs font-medium text-slate-500">{{ session('success') }}</p>',
            confirmButtonText: 'CLOSE',
            confirmButtonColor: '#000000',
            customClass: {
                popup: 'rounded-[2rem] border-none shadow-2xl',
                confirmButton: 'rounded-xl px-8 py-3 font-black text-[10px] uppercase tracking-[0.2em]'
            },
            buttonsStyling: false,
        });
    @endif
</script>
@endpush
@endsection
