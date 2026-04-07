@extends('layouts.app')

@section('title', 'Manage Submissions')

@section('content')
    <div class="min-h-screen bg-[#faf6ef] font-sans text-[#1a1209]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            {{-- ── Hero Header ── --}}
            <div
                class="relative pt-7 sm:pt-11 pb-6 sm:pb-8 mb-6 sm:mb-9 border-b border-[#e8dfd0]"
            >
                <div
                    class="absolute bottom-[-1px] left-0 w-20 h-[3px] bg-gradient-to-r from-[#2d8176] to-transparent"
                ></div>

                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
                >
                    <div>
                        {{-- Breadcrumb --}}
                        <nav class="flex items-center gap-2 mb-3">
                            <a
                                href="{{ route('dashboard.admin') }}"
                                class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#2d8176] hover:opacity-70 transition-opacity"
                            >
                                Admin
                            </a>
                            <svg
                                class="w-2.5 h-2.5 text-[#c9b99a]"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="3"
                                viewBox="0 0 24 24"
                            >
                                <path d="M9 5l7 7-7 7" />
                            </svg>
                            <span
                                class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#1a1209]"
                            >
                                Submissions
                            </span>
                        </nav>

                        {{-- Eyebrow --}}
                        <div class="flex items-center gap-2.5 mb-2">
                            <div class="w-6 h-px bg-[#2d8176]"></div>
                            <p
                                class="text-[11px] font-bold tracking-[0.2em] uppercase text-[#2d8176]"
                            >
                                System Administration
                            </p>
                        </div>

                        <h1
                            class="font-serif text-[2rem] sm:text-[2.8rem] font-bold text-[#1a1209] tracking-[-0.01em] leading-[1.15]"
                        >
                            Manage
                            <em class="italic text-[#2d8176]">Submissions</em>
                        </h1>
                        <p
                            class="text-[0.88rem] sm:text-[0.98rem] text-[#6b5740] mt-2"
                        >
                            View and manage all incoming manuscript submissions
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-2 sm:gap-3 self-start md:self-auto shrink-0"
                    >
                        {{-- Total Count Pill --}}
                        <div
                            class="bg-[#e8f4f2] border border-[#b8ddd9] rounded-full px-3 sm:px-4 py-2 flex items-center gap-2"
                        >
                            <span
                                class="font-serif text-[1rem] sm:text-[1.1rem] font-bold text-[#2d8176] leading-none"
                            >
                                {{ $submissions->total() }}
                            </span>
                            <span
                                class="text-[0.64rem] font-bold tracking-[0.1em] uppercase text-[#2d8176]/70"
                            >
                                Total
                            </span>
                        </div>

                        <a
                            href="{{ route('dashboard.admin') }}"
                            class="inline-flex items-center gap-1.5 bg-[#f3ece0] border border-[#c9b99a] text-[#6b5740] text-[0.68rem] font-bold tracking-[0.1em] uppercase px-3 sm:px-5 py-2.5 rounded-md hover:bg-white hover:text-[#1a1209] transition-all"
                        >
                            <svg
                                class="w-3 h-3"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M15 19l-7-7 7-7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Search & Filter ── --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-6">
                {{-- Search --}}
                <div
                    class="md:col-span-8 bg-white border border-[#e8dfd0] rounded-xl shadow-[0_1px_4px_rgba(26,18,9,0.05)] flex items-center gap-3 px-4 py-1"
                >
                    <svg
                        class="w-4 h-4 text-[#c9b99a] shrink-0"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            stroke-linecap="round"
                        />
                    </svg>
                    <input
                        type="text"
                        id="submissionSearch"
                        onkeyup="applyFilters()"
                        placeholder="Search by title or author..."
                        class="w-full py-2.5 bg-transparent border-none text-[0.88rem] font-semibold text-[#1a1209] placeholder-[#c9b99a] focus:ring-0 outline-none"
                    />
                </div>

                {{-- Status Filter --}}
                <div class="md:col-span-4 relative">
                    <div
                        class="absolute inset-0 bg-[#1a1209] rounded-xl pointer-events-none"
                    ></div>

                    <div
                        class="absolute inset-0 flex items-center px-4 gap-3 pointer-events-none"
                    >
                        <svg
                            class="w-3.5 h-3.5 text-white/40 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <div class="flex flex-col grow min-w-0">
                            <span
                                class="text-[9px] font-bold text-white/40 uppercase tracking-[0.2em] leading-none mb-0.5"
                            >
                                Filter by Status
                            </span>
                            <span
                                class="text-[11px] font-bold uppercase tracking-[0.1em] text-white leading-none truncate"
                                id="filterLabel"
                            >
                                All Status
                            </span>
                        </div>
                        <svg
                            class="w-3 h-3 text-white/40 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="3"
                            viewBox="0 0 24 24"
                        >
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <select
                        id="statusFilter"
                        onchange="
                            applyFilters();
                            document.getElementById('filterLabel').innerText =
                                this.options[this.selectedIndex].text;
                        "
                        class="relative z-10 w-full py-4 opacity-0 cursor-pointer rounded-xl"
                    >
                        <option value="">All Status</option>
                        <option value="submitted">Submitted</option>
                        <option value="under_review">Under Review</option>
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                        <option value="revisions_requested">
                            Revisions Requested
                        </option>
                    </select>
                </div>
            </div>

            {{-- ── Table Card ── --}}
            <div
                class="bg-white border border-[#e8dfd0] rounded-2xl shadow-[0_1px_6px_rgba(26,18,9,0.05)] overflow-hidden mb-10 sm:mb-12"
            >
                {{-- Top accent bar --}}
                <div
                    class="h-[3px] bg-gradient-to-r from-[#2d8176] to-[#c9a84c]"
                ></div>

                {{-- Table Header --}}
                <div
                    class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-[#e8dfd0] bg-[#faf6ef] flex items-center justify-between gap-3 flex-wrap"
                >
                    <div class="flex items-center gap-3">
                        <span
                            class="text-[0.68rem] font-bold tracking-[0.18em] uppercase text-[#6b5740]"
                        >
                            All Submissions
                        </span>
                        <div class="w-8 h-px bg-[#e8dfd0]"></div>
                    </div>
                    <span
                        class="text-[0.64rem] font-bold bg-[#e8f4f2] border border-[#b8ddd9] text-[#2d8176] px-3 py-1 rounded-full tracking-[0.08em] uppercase"
                    >
                        {{ $submissions->total() }}
                        {{ Str::plural('entry', $submissions->total()) }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-[#e8dfd0]">
                                <th
                                    class="px-4 sm:px-6 py-3 text-left text-[0.62rem] font-bold tracking-[0.14em] uppercase text-[#6b5740]"
                                >
                                    Title
                                </th>
                                <th
                                    class="px-4 sm:px-6 py-3 text-left text-[0.62rem] font-bold tracking-[0.14em] uppercase text-[#6b5740] hidden sm:table-cell"
                                >
                                    Author
                                </th>
                                <th
                                    class="px-4 sm:px-6 py-3 text-left text-[0.62rem] font-bold tracking-[0.14em] uppercase text-[#6b5740]"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-4 sm:px-6 py-3 text-right text-[0.62rem] font-bold tracking-[0.14em] uppercase text-[#6b5740]"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f0e8dc]">
                            @forelse ($submissions as $s)
                                @php
                                    $statusMap = match (strtolower($s->status)) {
                                        'accepted' => ['bg-[#e8f4f2] text-[#2d8176] border-[#b8ddd9]', 'dot' => 'bg-[#2d8176]'],
                                        'submitted' => ['bg-[#e8f4f2] text-[#2d8176] border-[#b8ddd9]', 'dot' => 'bg-[#2d8176]'],
                                        'under_review' => ['bg-[#fef9ec] text-[#8a6e28] border-[#e8d49a]', 'dot' => 'bg-[#c9a84c]'],
                                        'revisions_requested' => ['bg-[#fff7ed] text-[#9a5a1a] border-[#fdd9aa]', 'dot' => 'bg-[#f97316]'],
                                        'rejected' => ['bg-[#fef2f2] text-[#b91c1c] border-[#fecaca]', 'dot' => 'bg-[#b91c1c]'],
                                        default => ['bg-[#f3ece0] text-[#6b5740] border-[#e8dfd0]', 'dot' => 'bg-[#c9b99a]'],
                                    };
                                @endphp

                                <tr
                                    class="hover:bg-[#faf6ef] transition-colors submission-row group"
                                    data-searchtext="{{ strtolower($s->title . ' ' . ($s->author->name ?? '')) }}"
                                    data-status="{{ strtolower($s->status) }}"
                                >
                                    <td class="px-4 sm:px-6 py-4">
                                        <p
                                            class="text-[0.85rem] sm:text-[0.88rem] font-bold text-[#1a1209] leading-tight"
                                        >
                                            {{ Str::limit($s->title, 40) }}
                                        </p>
                                        {{-- Show author inline on mobile --}}
                                        <div
                                            class="flex items-center gap-1.5 mt-1 sm:hidden"
                                        >
                                            <div
                                                class="w-5 h-5 bg-[#1a4d46] text-white rounded flex items-center justify-center font-serif text-[10px] font-bold uppercase shrink-0"
                                            >
                                                {{ substr($s->author->name ?? '?', 0, 1) }}
                                            </div>
                                            <span
                                                class="text-[0.75rem] font-semibold text-[#6b5740] truncate"
                                            >
                                                {{ $s->author->name ?? '—' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td
                                        class="px-4 sm:px-6 py-4 hidden sm:table-cell"
                                    >
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-7 h-7 bg-[#1a4d46] text-white rounded-md flex items-center justify-center font-serif text-xs font-bold uppercase shrink-0"
                                            >
                                                {{ substr($s->author->name ?? '?', 0, 1) }}
                                            </div>
                                            <span
                                                class="text-[0.84rem] font-semibold text-[#6b5740]"
                                            >
                                                {{ $s->author->name ?? '—' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 sm:px-3 py-1 text-[0.58rem] sm:text-[0.62rem] font-bold tracking-[0.08em] uppercase rounded-full border {{ $statusMap[0] }}"
                                        >
                                            <span
                                                class="w-1.5 h-1.5 rounded-full shrink-0 {{ $statusMap['dot'] }}"
                                            ></span>
                                            <span class="hidden sm:inline">
                                                {{ str_replace('_', ' ', $s->status) }}
                                            </span>
                                            <span class="sm:hidden">
                                                {{ Str::limit(str_replace('_', ' ', $s->status), 10) }}
                                            </span>
                                        </span>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-right">
                                        <a
                                            href="{{ route('admin.submissions.show', $s) }}"
                                            class="inline-flex items-center gap-1 sm:gap-1.5 bg-[#f3ece0] border border-[#c9b99a] text-[#6b5740] text-[0.58rem] sm:text-[0.62rem] font-bold tracking-[0.1em] uppercase px-2.5 sm:px-4 py-2 rounded-md hover:bg-[#2d8176] hover:border-[#2d8176] hover:text-white transition-all whitespace-nowrap"
                                        >
                                            <span class="hidden sm:inline">
                                                View Details
                                            </span>
                                            <span class="sm:hidden">View</span>
                                            <svg
                                                class="w-2.5 h-2.5"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path d="M9 18l6-6-6-6" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="4"
                                        class="px-6 py-16 sm:py-20 text-center"
                                    >
                                        <svg
                                            class="w-12 h-12 mx-auto text-[#e8dfd0] mb-4"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                        <p
                                            class="text-[0.68rem] font-bold tracking-[0.14em] uppercase text-[#c9b99a]"
                                        >
                                            No Submissions Found
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($submissions->hasPages())
                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#e8dfd0] bg-[#faf6ef]"
                    >
                        {{ $submissions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function applyFilters() {
            const searchText = document
                .getElementById('submissionSearch')
                .value.toLowerCase();
            const statusFilter = document
                .getElementById('statusFilter')
                .value.toLowerCase();
            const rows = document.querySelectorAll('.submission-row');

            rows.forEach((row) => {
                const rowSearchText = row.getAttribute('data-searchtext');
                const rowStatus = row.getAttribute('data-status');
                const matchesSearch = rowSearchText.includes(searchText);
                const matchesStatus =
                    statusFilter === '' || rowStatus === statusFilter;
                row.style.display =
                    matchesSearch && matchesStatus ? '' : 'none';
            });
        }
    </script>
@endpush
