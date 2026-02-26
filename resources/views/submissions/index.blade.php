@extends('layouts.app')

@section('title', 'My Submissions')

@push('styles')
    <style>
        .field:focus {
            outline: none;
            border-color: #2d8176 !important;
            background: #fff !important;
            box-shadow: 0 0 0 3px rgba(45,129,118,.12);
        }

        .fu  { animation: fu .45s ease both; }
        .fu1 { animation: fu .45s .07s ease both; }
        .fu2 { animation: fu .45s .14s ease both; }
        .fu3 { animation: fu .45s .21s ease both; }
        @keyframes fu {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
@endpush

@section('content')
<div class="font-['Source_Sans_3',sans-serif] text-[#1a1209] max-w-7xl mx-auto px-1"
     style="background-color:#faf6ef;background-image:radial-gradient(ellipse 80% 50% at 50% -10%,rgba(45,129,118,.08) 0%,transparent 70%)">

    {{-- ── Page Header ── --}}
    <div class="relative pt-10 pb-7 mb-9 border-b border-[#e8dfd0] fu">
        <div class="absolute bottom-[-1px] left-0 w-20 h-[3px]"
             style="background:linear-gradient(90deg,#2d8176,transparent)"></div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-5">
            <div>
                {{-- Eyebrow --}}
                <p class="flex items-center gap-2 mb-2
                           text-[11px] font-bold tracking-[.2em] uppercase text-[#2d8176]">
                    <span class="inline-block w-6 h-px bg-[#2d8176]"></span>
                    Author Workspace
                </p>
                <h1 class="font-['Libre_Baskerville',serif] text-[2.4rem] font-bold
                           text-[#1a1209] leading-tight tracking-tight">
                    Manuscript <em class="italic text-[#2d8176]">Board</em>
                </h1>
                <p class="mt-2 text-[.98rem] text-[#6b5740]">
                    Manage and monitor all your research submissions in one place.
                </p>
            </div>

            <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                <span class="hidden sm:inline-block
                             text-[.7rem] font-semibold tracking-[.06em] uppercase text-[#6b5740]
                             bg-[#f3ece0] border border-[#e8dfd0] px-4 py-[5px] rounded-full">
                    {{ now()->format('D, M j Y') }}
                </span>

                <a href="{{ route('submissions.create') }}"
                   class="relative overflow-hidden inline-flex items-center gap-2
                          px-6 py-[11px] rounded-lg
                          bg-[#2d8176] hover:bg-[#1a4d46] text-white
                          text-[.72rem] font-bold tracking-[.1em] uppercase
                          transition-all duration-150
                          shadow-[0_4px_14px_rgba(45,129,118,.30)]
                          hover:-translate-y-0.5
                          hover:shadow-[0_8px_22px_rgba(45,129,118,.36)]
                          whitespace-nowrap">
                    <span class="absolute inset-0 pointer-events-none"
                          style="background:linear-gradient(135deg,rgba(201,168,76,.18) 0%,transparent 60%)"></span>
                    <svg class="w-3.5 h-3.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="relative z-10">New Submission</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Search Bar ── --}}
    <div class="fu1 mb-6">
        <div class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-[17px] h-[17px]
                        text-[#6b5740] pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/>
            </svg>
            <input type="text"
                   id="boardSearch"
                   placeholder="Search by title, status, or date…"
                   class="field w-full pl-11 pr-4 py-3
                          bg-white border border-[#e8dfd0] rounded-lg
                          text-[.95rem] text-[#1a1209] placeholder:text-[#b5a595]
                          transition-all shadow-[0_1px_4px_rgba(26,18,9,.05)]"
                   onkeyup="filterBoard()">
        </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden
                shadow-[0_2px_16px_rgba(26,18,9,.07)] fu2">

        {{-- Table Header --}}
        <div class="flex items-center justify-between px-7 py-4
                    bg-[#f3ece0] border-b border-[#e8dfd0]">
            <span class="font-['Libre_Baskerville',serif] text-[1.05rem] font-bold
                         text-[#1a1209] tracking-wide">
                Manuscripts
            </span>
            <span class="text-[.68rem] font-semibold text-[#6b5740]
                         bg-[#faf6ef] border border-[#e8dfd0]
                         px-3 py-[3px] rounded-full">
                {{ $submissions->total() ?? $submissions->count() }} records
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left" id="boardTable">
                <thead class="bg-[#f3ece0] border-b border-[#c9b99a]">
                    <tr>
                        <th class="px-6 py-[10px] text-[.6rem] font-bold tracking-[.1em]
                                   uppercase text-[#6b5740]">
                            Manuscript Title
                        </th>
                        <th class="px-6 py-[10px] text-[.6rem] font-bold tracking-[.1em]
                                   uppercase text-[#6b5740] w-[170px]">
                            Status
                        </th>
                        <th class="px-6 py-[10px] text-[.6rem] font-bold tracking-[.1em]
                                   uppercase text-[#6b5740] w-[130px]">
                            Submitted
                        </th>
                        <th class="px-6 py-[10px] text-right text-[.6rem] font-bold
                                   tracking-[.1em] uppercase text-[#6b5740] w-[110px]">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $s)
                        <tr class="board-row border-b border-[#f5f0e8] last:border-0
                                   hover:bg-[#e8f4f2] transition-colors group cursor-pointer"
                            onclick="window.location='{{ route('submissions.show', $s) }}'">

                            {{-- Title + Ref --}}
                            <td class="px-6 py-[17px]">
                                <p class="font-['Libre_Baskerville',serif] italic
                                          text-[1.02rem] font-normal text-[#1a1209]
                                          group-hover:text-[#2d8176] transition-colors
                                          title-cell leading-snug">
                                    {{ Str::limit($s->title, 80) }}
                                </p>
                                <span class="inline-block mt-1.5
                                             text-[.68rem] font-bold text-[#2d8176]
                                             tracking-[.06em]
                                             bg-[rgba(45,129,118,.07)]
                                             border border-[rgba(45,129,118,.22)]
                                             px-2 py-[2px] rounded">
                                    #{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-[17px]">
                                @php
                                    $cls = match ($s->status) {
                                        'accepted'
                                            => 'bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]',
                                        'under_review',
                                        'revision_under_review'
                                            => 'bg-[#fdf8ec] border-[rgba(201,168,76,.4)] text-[#8a6e28]',
                                        'revisions_requested'
                                            => 'bg-[#fff7ed] border-[#fed7aa] text-[#9a3412]',
                                        'rejected'
                                            => 'bg-[#fef2f2] border-[#fecaca] text-[#991b1b]',
                                        default
                                            => 'bg-[#e8f4f2] border-[rgba(45,129,118,.3)] text-[#1a4d46]',
                                    };
                                    $dot = match ($s->status) {
                                        'accepted'              => 'bg-[#2d8176]',
                                        'under_review',
                                        'revision_under_review' => 'bg-[#c9a84c]',
                                        'revisions_requested'   => 'bg-[#f97316]',
                                        'rejected'              => 'bg-[#c0392b]',
                                        default                 => 'bg-[#2d8176]',
                                    };
                                    $label = match ($s->status) {
                                        'revision_under_review' => 'Revision Review',
                                        default => ucfirst(str_replace('_', ' ', $s->status)),
                                    };
                                @endphp
                                <span class="status-cell inline-flex items-center gap-[6px]
                                             px-[10px] py-[4px] rounded-full border
                                             text-[.62rem] font-bold tracking-[.06em]
                                             uppercase whitespace-nowrap {{ $cls }}">
                                    <span class="w-[5px] h-[5px] rounded-full flex-shrink-0 {{ $dot }}"></span>
                                    {{ $label }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-[17px]">
                                <span class="date-cell text-[.78rem] font-semibold
                                             text-[#6b5740] tracking-[.04em]">
                                    {{ $s->submitted_at?->format('d M Y') ?? '—' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-[17px] text-right"
                                onclick="event.stopPropagation()">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('submissions.show', $s) }}"
                                       class="text-[.68rem] font-bold tracking-[.06em] uppercase
                                              text-[#6b5740] hover:text-[#2d8176] transition-colors">
                                        View
                                    </a>
                                    @if ($s->isEditableByAuthor())
                                        <span class="text-[#e8dfd0] select-none">|</span>
                                        <a href="{{ route('submissions.edit', $s) }}"
                                           class="text-[.68rem] font-bold tracking-[.06em] uppercase
                                                  text-[#c9a84c] hover:text-[#8a6e28] transition-colors">
                                            Edit
                                        </a>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="w-[60px] h-[60px] rounded-full
                                            bg-[#f3ece0] border border-[#e8dfd0]
                                            flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="#c9b99a" viewBox="0 0 24 24">
                                        <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                              stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <p class="text-[.68rem] font-bold tracking-[.14em]
                                          uppercase text-[#c9b99a]">
                                    No manuscripts found
                                </p>
                                <p class="text-[.82rem] text-[#b5a595] mt-1.5">
                                    Submit your first manuscript to get started
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Pagination ── --}}
    @if (method_exists($submissions, 'hasPages') && $submissions->hasPages())
        <div class="mt-5 fu3">{{ $submissions->links() }}</div>
    @endif

</div>
@endsection

@push('scripts')
    <script>
        function filterBoard() {
            const f = document.getElementById('boardSearch').value.toUpperCase();
            document.querySelectorAll('.board-row').forEach(row => {
                row.style.display = row.innerText.toUpperCase().includes(f) ? '' : 'none';
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