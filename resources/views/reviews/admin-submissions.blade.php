@extends('layouts.app')

@section('title', 'Manage Submissions')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                <a href="{{ route('dashboard.admin') }}" class="hover:text-red-600 transition-colors">Admin</a>
                <span>&gt;</span>
                <span class="text-slate-900">Submissions</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900">Manage Submissions</h1>
            <p class="text-sm text-slate-500 mt-1">View and manage all incoming user submissions.</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Added Back Button --}}
            <a href="{{ route('dashboard.admin') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-500 rounded-lg text-sm font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back
            </a>

            <div class="bg-slate-100 px-4 py-2 rounded-lg border border-slate-200">
                <span class="text-sm font-medium text-slate-600">Total: {{ $submissions->total() }}</span>
            </div>
        </div>
    </div>

    {{-- Search & Filter Section --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-6">
        {{-- Search Input --}}
        <div class="md:col-span-8 bg-white border border-slate-200 rounded-2xl p-1.5 shadow-sm flex items-center">
            <div class="relative w-full">
                <input type="text" id="submissionSearch" onkeyup="applyFilters()"
                    placeholder="Search by title or author..."
                    class="w-full pl-10 pr-4 py-2 bg-transparent border-none text-sm font-bold text-slate-900 focus:ring-0 outline-none">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Status Filter --}}
        <div class="md:col-span-4 relative group">
            <div class="absolute inset-0 bg-slate-900 border border-slate-900 rounded-2xl shadow-md group-hover:bg-red-600 group-hover:border-red-600 transition-all pointer-events-none"></div>

            <div class="absolute inset-0 flex items-center px-5 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-white/50 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="flex flex-col flex-grow">
                    <span class="text-[6px] font-black text-white/40 uppercase tracking-[0.2em] leading-tight">Filter</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-white leading-tight" id="filterLabel">All Status</span>
                </div>
                <svg class="w-3.5 h-3.5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3"/></svg>
            </div>

            <select id="statusFilter" onchange="applyFilters(); document.getElementById('filterLabel').innerText = this.options[this.selectedIndex].text"
                class="relative z-10 w-full h-full py-4 opacity-0 cursor-pointer">
                <option value="">All Status</option>
                <option value="submitted">Submitted</option>
                <option value="under_review">Under Review</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
                <option value="revisions_requested">Revisions Requested</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Author</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($submissions as $s)
                        <tr class="hover:bg-slate-50/50 transition-colors submission-row"
                            data-searchtext="{{ strtolower($s->title . ' ' . ($s->author->name ?? '')) }}"
                            data-status="{{ strtolower($s->status) }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                {{ Str::limit($s->title, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $s->author->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColor = match(strtolower($s->status)) {
                                        'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'pending'  => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
                                        default    => 'bg-slate-50 text-slate-700 border-slate-100',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full border {{ $statusColor }} uppercase">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.submissions.show', $s) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-slate-500 font-medium">No submissions found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function applyFilters() {
        const searchText = document.getElementById('submissionSearch').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const rows = document.querySelectorAll('.submission-row');

        rows.forEach(row => {
            const rowSearchText = row.getAttribute('data-searchtext');
            const rowStatus = row.getAttribute('data-status');

            const matchesSearch = rowSearchText.includes(searchText);
            const matchesStatus = statusFilter === "" || rowStatus === statusFilter;

            if (matchesSearch && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>
@endpush
