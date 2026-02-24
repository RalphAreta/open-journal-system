@php
use App\Models\Submission;
@endphp

@extends('layouts.app')

@section('title', 'Chief Editor Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Instrument Serif', serif; }
    .font-body          { font-family: 'DM Sans', sans-serif; }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation: fadeUp .4s .07s ease both; }
    .fade-up-2 { animation: fadeUp .4s .14s ease both; }
    .fade-up-3 { animation: fadeUp .4s .21s ease both; }
    .fade-up-4 { animation: fadeUp .4s .28s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
</style>
@endpush

@section('content')
<div class="font-body">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-7 fade-up">
        <div>
            <h1 class="font-serif-display text-[1.85rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight">
                Chief Editor Dashboard
            </h1>
            <p class="text-sm text-slate-500 mt-1">Manage submissions and assign editors</p>
        </div>
        <span class="text-xs font-medium text-slate-400 bg-white border border-slate-200 px-3 py-1.5 rounded-full hidden sm:inline-block">
            {{ now()->format('D, M j Y') }}
        </span>
    </div>

    {{-- ── Stats Grid ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 fade-up-1">

        <div class="bg-white border border-slate-200 rounded-[14px] p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400">Total Submissions</span>
                <div class="w-9 h-9 rounded-[8px] bg-slate-100 flex items-center justify-center text-base">📄</div>
            </div>
            <p class="font-serif-display text-[2.2rem] leading-none text-slate-900">{{ $stats['total_submissions'] }}</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-[14px] p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:border-red-200 transition-all relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400">Pending Assignment</span>
                <div class="w-9 h-9 rounded-[8px] bg-red-50 flex items-center justify-center text-base">⏳</div>
            </div>
            <p class="font-serif-display text-[2.2rem] leading-none text-red-600">{{ $stats['pending_assignments'] }}</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-[14px] p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:border-blue-200 transition-all relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400">Under Review</span>
                <div class="w-9 h-9 rounded-[8px] bg-blue-50 flex items-center justify-center text-base">👁️</div>
            </div>
            <p class="font-serif-display text-[2.2rem] leading-none text-blue-600">{{ $stats['under_review'] }}</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-[14px] p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:border-emerald-200 transition-all relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400">Completed</span>
                <div class="w-9 h-9 rounded-[8px] bg-emerald-50 flex items-center justify-center text-base">✓</div>
            </div>
            <p class="font-serif-display text-[2.2rem] leading-none text-emerald-600">{{ $stats['completed'] }}</p>
        </div>

    </div>

    {{-- ── Pending Assignments Table ── --}}
    <div class="mb-6 fade-up-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-serif-display text-[1.3rem] font-normal text-slate-900 tracking-[-0.01em]">Pending Assignments</h2>
        </div>

        @if ($pendingSubmissions->count() > 0)
        <div class="bg-white border border-slate-200 rounded-[14px] overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Title</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Author</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Research Field</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Submitted</th>
                            <th class="px-6 py-3.5 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingSubmissions as $submission)
                        <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50/60 transition-colors group">
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-900 group-hover:text-red-600 transition-colors">
                                    {{ Str::limit($submission->title, 40) }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-500">{{ $submission->author->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[10px] font-bold uppercase tracking-[.04em] text-blue-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    {{ $submission->research_field ?? 'Not specified' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs font-medium text-slate-500">{{ $submission->submitted_at->format('M d, Y') }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('chief-editor.submission.show', $submission) }}"
                                   class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white
                                          px-3 py-1.5 rounded-[7px] text-[11px] font-bold uppercase tracking-[.05em]
                                          transition-all hover:-translate-y-0.5">
                                    Review & Assign
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $pendingSubmissions->links() }}</div>

        @else
        <div class="bg-white border border-emerald-200 rounded-[14px] px-6 py-8 text-center shadow-sm">
            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-emerald-700">All submissions have been assigned!</p>
        </div>
        @endif
    </div>

    {{-- ── Assigned Submissions Table ── --}}
    <div class="fade-up-3">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-serif-display text-[1.3rem] font-normal text-slate-900 tracking-[-0.01em]">Assigned Submissions</h2>
        </div>

        @if ($assignedSubmissions->count() > 0)
        <div class="bg-white border border-slate-200 rounded-[14px] overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Title</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Assigned Editor</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Status</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Assigned Date</th>
                            <th class="px-6 py-3.5 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignedSubmissions as $submission)
                        <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50/60 transition-colors group">
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-900 group-hover:text-red-600 transition-colors">
                                    {{ Str::limit($submission->title, 40) }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-500">{{ $submission->assignedEditor->name ?? 'Unassigned' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $cls = match($submission->status) {
                                        'accepted'            => 'bg-emerald-50 border-emerald-200 text-emerald-700 [&_.dot]:bg-emerald-500',
                                        'rejected'            => 'bg-red-50 border-red-200 text-red-700 [&_.dot]:bg-red-500',
                                        'under_review'        => 'bg-blue-50 border-blue-200 text-blue-700 [&_.dot]:bg-blue-500',
                                        'revisions_requested' => 'bg-amber-50 border-amber-200 text-amber-700 [&_.dot]:bg-amber-500',
                                        default               => 'bg-slate-50 border-slate-200 text-slate-600 [&_.dot]:bg-slate-400',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[10px] font-bold uppercase tracking-[.04em] {{ $cls }}">
                                    <span class="dot w-1.5 h-1.5 rounded-full"></span>
                                    {{ Submission::statusOptions()[$submission->status] ?? $submission->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs font-medium text-slate-500">
                                    {{ $submission->chief_editor_review_at?->format('M d, Y') ?? '—' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('chief-editor.submission.show', $submission) }}"
                                   class="text-[11px] font-bold uppercase tracking-[.06em] text-red-500 hover:text-red-700 transition-colors">
                                    View →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $assignedSubmissions->links('pagination::tailwind') }}</div>

        @else
        <div class="bg-white border border-slate-200 rounded-[14px] px-6 py-8 text-center shadow-sm">
            <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.5"/>
                </svg>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-[.1em] text-slate-300">No assigned submissions yet</p>
        </div>
        @endif
    </div>

</div>
@endsection