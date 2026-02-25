@extends('layouts.app')

@section('title', 'Manage Submissions')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap"
        rel="stylesheet"
    />
    <style>
        .font-serif-display {
            font-family: 'Instrument Serif', serif;
        }
        .font-body {
            font-family: 'DM Sans', sans-serif;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-up {
            animation: fadeUp 0.4s ease both;
        }
        .fade-up-1 {
            animation: fadeUp 0.4s 0.07s ease both;
        }
        .fade-up-2 {
            animation: fadeUp 0.4s 0.14s ease both;
        }
    </style>
@endpush

@section('content')
    <div class="font-body">
        {{-- ── Flash Messages (handled by layout) ── --}}
        {{-- ── Validation Errors ── --}}
        <x-validation-errors />

        {{-- ── Header ── --}}
        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-7 fade-up"
        >
            <div>
                <h1
                    class="font-serif-display text-[1.85rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight"
                >
                    Manage Submissions
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Review, assign, and track manuscript progress
                </p>
            </div>
            <span
                class="text-xs font-medium text-slate-400 bg-white border border-slate-200 px-3 py-1.5 rounded-full hidden sm:inline-block"
            >
                {{ now()->format('D, M j Y') }}
            </span>
        </div>

        {{-- ── Table Card ── --}}
        <div
            class="bg-white border border-slate-200 rounded-[14px] overflow-hidden shadow-sm fade-up-1"
        >
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th
                                class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                            >
                                Title
                            </th>
                            <th
                                class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                            >
                                Author
                            </th>
                            <th
                                class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                            >
                                Reviews
                            </th>
                            <th
                                class="px-6 py-3.5 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $s)
                            @php
                                $reviews = $s->reviews;
                                $assignments = $s->reviewAssignments;
                                $completed = $reviews->count();
                                $pending = $assignments->where('status', 'assigned')->count();
                                $accepts = $reviews->where('recommendation', 'accept')->count();
                                $rejects = $reviews->where('recommendation', 'reject')->count();
                                $minorRevisions = $reviews->where('recommendation', 'minor_revisions')->count();
                                $majorRevisions = $reviews->where('recommendation', 'major_revisions')->count();

                                $statusCls = match ($s->status) {
                                    'submitted' => 'bg-blue-50 border-blue-200 text-blue-700 [&_.dot]:bg-blue-500',
                                    'under_review' => 'bg-amber-50 border-amber-200 text-amber-700 [&_.dot]:bg-amber-500',
                                    'accepted' => 'bg-emerald-50 border-emerald-200 text-emerald-700 [&_.dot]:bg-emerald-500',
                                    'rejected' => 'bg-red-50 border-red-200 text-red-700 [&_.dot]:bg-red-500',
                                    'revisions_requested' => 'bg-orange-50 border-orange-200 text-orange-700 [&_.dot]:bg-orange-500',
                                    default => 'bg-slate-50 border-slate-200 text-slate-600 [&_.dot]:bg-slate-400',
                                };
                            @endphp

                            <tr
                                class="border-b border-slate-100 last:border-0 hover:bg-slate-50/60 transition-colors group"
                            >
                                <td class="px-6 py-4">
                                    <p
                                        class="text-sm font-semibold text-slate-900 group-hover:text-red-600 transition-colors leading-snug"
                                    >
                                        {{ Str::limit($s->title, 40) }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-500">
                                        {{ $s->author->name ?? '—' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[10px] font-bold uppercase tracking-[.04em] {{ $statusCls }}"
                                    >
                                        <span
                                            class="dot w-1.5 h-1.5 rounded-full"
                                        ></span>
                                        {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($completed > 0 || $pending > 0)
                                        <div
                                            class="flex flex-wrap items-center gap-1.5"
                                        >
                                            @if ($accepts > 0)
                                                <x-review-status-badge type="accept" :count="$accepts" />
                                            @endif

                                            @if ($rejects > 0)
                                                <x-review-status-badge type="reject" :count="$rejects" />
                                            @endif

                                            @if ($minorRevisions > 0)
                                                <x-review-status-badge type="minor" :count="$minorRevisions" />
                                            @endif

                                            @if ($majorRevisions > 0)
                                                <x-review-status-badge type="major" :count="$majorRevisions" />
                                            @endif

                                            @if ($pending > 0)
                                                <x-review-status-badge type="pending" :count="$pending" />
                                            @endif
                                        </div>
                                    @else
                                        <span
                                            class="text-xs text-slate-400 font-medium"
                                        >
                                            No reviews yet
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a
                                        href="{{ route('editor.submission.show', $s) }}"
                                        class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-[7px] text-[11px] font-bold uppercase tracking-[.05em] transition-all hover:-translate-y-0.5"
                                    >
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div
                                        class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3"
                                    >
                                        <svg
                                            class="w-6 h-6 text-slate-200"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                stroke-width="1.5"
                                            />
                                        </svg>
                                    </div>
                                    <p
                                        class="text-[11px] font-bold uppercase tracking-widest text-slate-300"
                                    >
                                        No submissions found
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100">
                {{ $submissions->links() }}
            </div>
        </div>

        {{-- ── Legend ── --}}
        <div
            class="mt-5 bg-white border border-slate-200 rounded-[14px] px-5 py-4 flex flex-wrap items-center gap-3 fade-up-2"
        >
            <span
                class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mr-1"
            >
                Legend
            </span>
            <x-review-status-badge type="accept" />
            <x-review-status-badge type="reject" />
            <x-review-status-badge type="minor" />
            <x-review-status-badge type="major" />
            <x-review-status-badge type="pending" />
        </div>
    </div>
@endsection
