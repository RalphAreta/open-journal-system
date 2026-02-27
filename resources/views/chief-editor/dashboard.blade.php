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

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up   { animation: fadeUp .35s ease both; }
    .fade-up-1 { animation: fadeUp .35s .06s ease both; }
    .fade-up-2 { animation: fadeUp .35s .12s ease both; }
    .fade-up-3 { animation: fadeUp .35s .18s ease both; }

    /* Tab underline */
    .tab-btn {
        position: relative;
        padding-bottom: 10px;
        color: #94a3b8;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        transition: color .2s;
        white-space: nowrap;
    }
    .tab-btn::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        border-radius: 2px;
        background: #dc2626;
        transform: scaleX(0);
        transition: transform .22s ease;
    }
    .tab-btn.active { color: #0f172a; }
    .tab-btn.active::after { transform: scaleX(1); }
    .tab-btn:hover:not(.active) { color: #475569; }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* Sortable TH */
    th.sortable { cursor: pointer; user-select: none; }
    th.sortable:hover .sort-icon { opacity: 1; }
    .sort-icon { opacity: .35; transition: opacity .15s; margin-left: 3px; }

    /* Search input */
    .search-wrap input:focus { outline: none; box-shadow: 0 0 0 3px rgba(220,38,38,.12); }

    /* Compact row */
    tbody tr { animation: fadeUp .25s ease both; }
</style>
@endpush

@section('content')
<div class="font-body">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 fade-up">
        <div>
            <h1 class="font-serif-display text-[1.75rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight">
                Chief Editor Dashboard
            </h1>
            <p class="text-[13px] text-slate-400 mt-0.5">Manage submissions and assign editors</p>
        </div>
        <span class="text-[11px] font-semibold text-slate-400 bg-white border border-slate-200 px-3 py-1.5 rounded-full hidden sm:inline-block">
            {{ now()->format('D, M j Y') }}
        </span>
    </div>

    {{-- ── Stats Grid ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-7 fade-up-1">

        @php
        $stats_cards = [
            ['label' => 'Total Submissions', 'value' => $stats['total_submissions'], 'icon' => '📄', 'color' => 'slate'],
            ['label' => 'Pending Assignment', 'value' => $stats['pending_assignments'], 'icon' => '⏳', 'color' => 'red'],
            ['label' => 'Under Review',       'value' => $stats['under_review'],       'icon' => '👁️', 'color' => 'blue'],
            ['label' => 'Completed',          'value' => $stats['completed'],          'icon' => '✓',  'color' => 'emerald'],
        ];
        $colorMap = [
            'slate'   => ['border' => 'border-slate-200',   'hover' => 'hover:border-slate-300',   'bg' => 'bg-slate-100',   'text' => 'text-slate-900'],
            'red'     => ['border' => 'border-slate-200',   'hover' => 'hover:border-red-200',     'bg' => 'bg-red-50',      'text' => 'text-red-600'],
            'blue'    => ['border' => 'border-slate-200',   'hover' => 'hover:border-blue-200',    'bg' => 'bg-blue-50',     'text' => 'text-blue-600'],
            'emerald' => ['border' => 'border-slate-200',   'hover' => 'hover:border-emerald-200', 'bg' => 'bg-emerald-50',  'text' => 'text-emerald-600'],
        ];
        @endphp

        @foreach ($stats_cards as $card)
        @php $c = $colorMap[$card['color']]; @endphp
        <div class="bg-white border {{ $c['border'] }} {{ $c['hover'] }} rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">{{ $card['label'] }}</span>
                <div class="w-8 h-8 rounded-lg {{ $c['bg'] }} flex items-center justify-center text-sm">{{ $card['icon'] }}</div>
            </div>
            <p class="font-serif-display text-[2rem] leading-none {{ $c['text'] }}">{{ $card['value'] }}</p>
        </div>
        @endforeach

    </div>

    {{-- ── Tabbed Tables ── --}}
    <div class="fade-up-2">

        {{-- Tab Bar --}}
        <div class="flex items-end gap-6 border-b border-slate-200 mb-5">
            <button class="tab-btn active" data-tab="pending" onclick="switchTab('pending', this)">
                Pending Assignment
                <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-100 text-red-600 text-[10px] font-bold">
                    {{ $stats['pending_assignments'] }}
                </span>
            </button>
            <button class="tab-btn" data-tab="assigned" onclick="switchTab('assigned', this)">
                Assigned Submissions
                <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">
                    {{ $assignedSubmissions->total() }}
                </span>
            </button>
            <button class="tab-btn" data-tab="appeals" onclick="switchTab('appeals', this)">
                Appeals
                <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-100 text-amber-600 text-[10px] font-bold">
                    {{ $stats['pending_appeals'] }}
                </span>
            </button>
        </div>

        {{-- ── PENDING TAB ── --}}
        <div id="tab-pending" class="tab-panel active">

            {{-- Search + Filter bar --}}
            <div class="flex flex-col sm:flex-row gap-3 mb-4">
                <div class="search-wrap relative flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35" stroke-linecap="round"/>
                    </svg>
                    <input type="text"
                           id="pending-search"
                           placeholder="Search by title or author…"
                           oninput="filterTable('pending-tbody', this.value)"
                           class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-red-300 transition-colors placeholder:text-slate-400">
                </div>
                <select id="pending-field-filter"
                        onchange="filterTable('pending-tbody', document.getElementById('pending-search').value)"
                        class="text-sm bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-600 focus:outline-none focus:border-red-300 transition-colors">
                    <option value="">All Research Fields</option>
                    @foreach ($pendingSubmissions->unique('research_field')->pluck('research_field')->filter() as $field)
                    <option value="{{ $field }}">{{ $field }}</option>
                    @endforeach
                </select>
            </div>

            @if ($pendingSubmissions->count() > 0)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full" id="pending-table">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="sortable px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                                    onclick="sortTable('pending-tbody', 0, this)">
                                    Title <span class="sort-icon">↕</span>
                                </th>
                                <th class="sortable px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                                    onclick="sortTable('pending-tbody', 1, this)">
                                    Author <span class="sort-icon">↕</span>
                                </th>
                                <th class="sortable px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                                    onclick="sortTable('pending-tbody', 2, this)">
                                    Research Field <span class="sort-icon">↕</span>
                                </th>
                                <th class="sortable px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                                    onclick="sortTable('pending-tbody', 3, this)">
                                    Submitted <span class="sort-icon">↕</span>
                                </th>
                                <th class="px-5 py-3 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Action</th>
                            </tr>
                        </thead>
                        <tbody id="pending-tbody">
                            @foreach ($pendingSubmissions as $submission)
                            <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/70 transition-colors group"
                                data-title="{{ strtolower($submission->title) }}"
                                data-author="{{ strtolower($submission->author->name) }}"
                                data-field="{{ strtolower($submission->research_field ?? '') }}">
                                <td class="px-5 py-3.5">
                                    <p class="text-sm font-semibold text-slate-800 group-hover:text-red-600 transition-colors leading-snug">
                                        {{ Str::limit($submission->title, 45) }}
                                    </p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-sm text-slate-500">{{ $submission->author->name }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-50 border border-blue-100 text-[10px] font-bold uppercase tracking-[.04em] text-blue-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                        {{ $submission->research_field ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-[11px] font-medium text-slate-400">{{ $submission->submitted_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('chief-editor.submission.show', $submission) }}"
                                       class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white
                                              px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-[.05em]
                                              transition-all hover:-translate-y-0.5">
                                        Review &amp; Assign
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400">
                <span>Showing {{ $pendingSubmissions->firstItem() }}–{{ $pendingSubmissions->lastItem() }} of {{ $pendingSubmissions->total() }}</span>
                <div>{{ $pendingSubmissions->links() }}</div>
            </div>

            @else
            <div class="bg-white border border-emerald-200 rounded-2xl px-6 py-10 text-center shadow-sm">
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-emerald-700">All submissions have been assigned!</p>
            </div>
            @endif

        </div>{{-- /tab-pending --}}

        {{-- ── ASSIGNED TAB ── --}}
        <div id="tab-assigned" class="tab-panel">

            {{-- Search + Status filter --}}
            <div class="flex flex-col sm:flex-row gap-3 mb-4">
                <div class="search-wrap relative flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35" stroke-linecap="round"/>
                    </svg>
                    <input type="text"
                           id="assigned-search"
                           placeholder="Search by title or editor…"
                           oninput="filterTable('assigned-tbody', this.value)"
                           class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-red-300 transition-colors placeholder:text-slate-400">
                </div>
                <select id="assigned-status-filter"
                        onchange="filterTable('assigned-tbody', document.getElementById('assigned-search').value)"
                        class="text-sm bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-600 focus:outline-none focus:border-red-300 transition-colors">
                    <option value="">All Statuses</option>
                    @foreach (Submission::statusOptions() as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            @if ($assignedSubmissions->count() > 0)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="sortable px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                                    onclick="sortTable('assigned-tbody', 0, this)">
                                    Title <span class="sort-icon">↕</span>
                                </th>
                                <th class="sortable px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                                    onclick="sortTable('assigned-tbody', 1, this)">
                                    Assigned Editor <span class="sort-icon">↕</span>
                                </th>
                                <th class="sortable px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                                    onclick="sortTable('assigned-tbody', 2, this)">
                                    Status <span class="sort-icon">↕</span>
                                </th>
                                <th class="sortable px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400"
                                    onclick="sortTable('assigned-tbody', 3, this)">
                                    Assigned Date <span class="sort-icon">↕</span>
                                </th>
                                <th class="px-5 py-3 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Action</th>
                            </tr>
                        </thead>
                        <tbody id="assigned-tbody">
                            @foreach ($assignedSubmissions as $submission)
                            @php
                                $cls = match($submission->status) {
                                    'accepted'            => 'bg-emerald-50 border-emerald-200 text-emerald-700 dot-emerald',
                                    'rejected'            => 'bg-red-50 border-red-200 text-red-700 dot-red',
                                    'under_review'        => 'bg-blue-50 border-blue-200 text-blue-700 dot-blue',
                                    'revisions_requested' => 'bg-amber-50 border-amber-200 text-amber-700 dot-amber',
                                    default               => 'bg-slate-50 border-slate-200 text-slate-600 dot-slate',
                                };
                                $dotColor = match($submission->status) {
                                    'accepted'            => 'bg-emerald-500',
                                    'rejected'            => 'bg-red-500',
                                    'under_review'        => 'bg-blue-500',
                                    'revisions_requested' => 'bg-amber-500',
                                    default               => 'bg-slate-400',
                                };
                            @endphp
                            <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/70 transition-colors group"
                                data-title="{{ strtolower($submission->title) }}"
                                data-editor="{{ strtolower($submission->assignedEditor->name ?? '') }}"
                                data-status="{{ $submission->status }}">
                                <td class="px-5 py-3.5">
                                    <p class="text-sm font-semibold text-slate-800 group-hover:text-red-600 transition-colors leading-snug">
                                        {{ Str::limit($submission->title, 45) }}
                                    </p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-sm text-slate-500">{{ $submission->assignedEditor->name ?? '—' }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full border text-[10px] font-bold uppercase tracking-[.04em] {{ $cls }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                        {{ Submission::statusOptions()[$submission->status] ?? $submission->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-[11px] font-medium text-slate-400">
                                        {{ $submission->chief_editor_review_at?->format('M d, Y') ?? '—' }}
                                    </p>
                                </td>
                                <td class="px-5 py-3.5 text-right">
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

            <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400">
                <span>Showing {{ $assignedSubmissions->firstItem() }}–{{ $assignedSubmissions->lastItem() }} of {{ $assignedSubmissions->total() }}</span>
                <div>{{ $assignedSubmissions->links('pagination::tailwind') }}</div>
            </div>

            @else
            <div class="bg-white border border-slate-200 rounded-2xl px-6 py-10 text-center shadow-sm">
                <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.5"/>
                    </svg>
                </div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-300">No assigned submissions yet</p>
            </div>
            @endif

        </div>{{-- /tab-assigned --}}

        {{-- ── APPEALS TAB ── --}}
        <div id="tab-appeals" class="tab-panel">

            {{-- Search bar --}}
            <div class="flex flex-col sm:flex-row gap-3 mb-4">
                <div class="search-wrap relative flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35" stroke-linecap="round"/>
                    </svg>
                    <input type="text"
                           id="appeals-search"
                           placeholder="Search by title or author…"
                           oninput="filterTable('appeals-tbody', this.value)"
                           class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-red-300 transition-colors placeholder:text-slate-400">
                </div>
            </div>

            @if ($pendingAppeals->count() > 0)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Manuscript</th>
                                <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Author</th>
                                <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Submitted</th>
                                <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Status</th>
                                <th class="px-5 py-3 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Action</th>
                            </tr>
                        </thead>
                        <tbody id="appeals-tbody">
                            @foreach ($pendingAppeals as $appeal)
                            <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/70 transition-colors group"
                                data-title="{{ strtolower($appeal->submission->title) }}"
                                data-author="{{ strtolower($appeal->author->name) }}">
                                <td class="px-5 py-3.5">
                                    <p class="text-sm font-semibold text-slate-800 group-hover:text-red-600 transition-colors leading-snug">
                                        {{ Str::limit($appeal->submission->title, 45) }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">#{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-sm text-slate-600 font-medium">{{ $appeal->author->name }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $appeal->author->email }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-sm text-slate-600">{{ $appeal->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-100 text-[10px] font-bold uppercase tracking-[.04em] text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        Pending
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('appeals.show', $appeal) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400">
                <span>Showing {{ $pendingAppeals->firstItem() }}–{{ $pendingAppeals->lastItem() }} of {{ $pendingAppeals->total() }}</span>
                <div>{{ $pendingAppeals->links('pagination::tailwind') }}</div>
            </div>

            @else
            <div class="bg-white border border-emerald-200 rounded-2xl px-6 py-10 text-center shadow-sm">
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-emerald-700">No pending appeals to review!</p>
            </div>
            @endif

            {{-- Completed Appeals Section --}}
            @if ($completedAppeals->count() > 0)
            <div class="mt-8 pt-6 border-t border-slate-200">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4">Completed Appeals</h3>
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Manuscript</th>
                                    <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Author</th>
                                    <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Decision</th>
                                    <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Reviewed</th>
                                    <th class="px-5 py-3 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Action</th>
                                </tr>
                            </thead>
                            <tbody id="completed-appeals-tbody">
                                @foreach ($completedAppeals as $appeal)
                                <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/70 transition-colors group"
                                    data-title="{{ strtolower($appeal->submission->title) }}"
                                    data-author="{{ strtolower($appeal->author->name) }}">
                                    <td class="px-5 py-3.5">
                                        <p class="text-sm font-semibold text-slate-800 group-hover:text-red-600 transition-colors leading-snug">
                                            {{ Str::limit($appeal->submission->title, 45) }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">#{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <p class="text-sm text-slate-600 font-medium">{{ $appeal->author->name }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $appeal->author->email }}</p>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if ($appeal->status === 'approved')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-100 text-[10px] font-bold uppercase tracking-[.04em] text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            Approved
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-red-50 border border-red-100 text-[10px] font-bold uppercase tracking-[.04em] text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                            Rejected
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <p class="text-sm text-slate-600">{{ $appeal->reviewed_at->format('M d, Y') }}</p>
                                        <p class="text-[10px] text-slate-400">by {{ $appeal->reviewedBy->name ?? 'System' }}</p>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('appeals.show', $appeal) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400">
                    <span>Showing {{ $completedAppeals->firstItem() }}–{{ $completedAppeals->lastItem() }} of {{ $completedAppeals->total() }}</span>
                    <div>{{ $completedAppeals->links('pagination::tailwind') }}</div>
                </div>
            </div>
            @endif

        </div>{{-- /tab-appeals --}}

    </div>{{-- /tabbed section --}}

</div>
@endsection

@push('scripts')
<script>
// ── Tab switching ──────────────────────────────────────────
function switchTab(name, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + name).classList.add('active');
}

// ── Client-side search + filter ───────────────────────────
function filterTable(tbodyId, searchVal) {
    const tbody  = document.getElementById(tbodyId);
    const rows   = tbody.querySelectorAll('tr');
    const search = searchVal.toLowerCase().trim();

    // Determine extra filter (field or status)
    let extraFilter = '';
    if (tbodyId === 'pending-tbody') {
        extraFilter = document.getElementById('pending-field-filter')?.value.toLowerCase() ?? '';
    } else {
        extraFilter = document.getElementById('assigned-status-filter')?.value.toLowerCase() ?? '';
    }

    rows.forEach(row => {
        const title  = row.dataset.title  ?? '';
        const author = row.dataset.author ?? '';
        const editor = row.dataset.editor ?? '';
        const field  = row.dataset.field  ?? '';
        const status = row.dataset.status ?? '';

        const matchSearch = !search ||
            title.includes(search) ||
            author.includes(search) ||
            editor.includes(search) ||
            field.includes(search);

        const matchExtra = !extraFilter ||
            field.includes(extraFilter) ||
            status === extraFilter;

        row.style.display = (matchSearch && matchExtra) ? '' : 'none';
    });
}

// ── Client-side column sort ───────────────────────────────
const sortState = {};

function sortTable(tbodyId, colIndex, th) {
    const tbody = document.getElementById(tbodyId);
    const rows  = Array.from(tbody.querySelectorAll('tr'));
    const key   = tbodyId + '-' + colIndex;

    // Toggle direction
    sortState[key] = sortState[key] === 'asc' ? 'desc' : 'asc';
    const asc = sortState[key] === 'asc';

    // Update icons
    th.closest('thead').querySelectorAll('.sort-icon').forEach(el => el.textContent = '↕');
    th.querySelector('.sort-icon').textContent = asc ? '↑' : '↓';

    rows.sort((a, b) => {
        const aText = a.cells[colIndex]?.innerText.trim().toLowerCase() ?? '';
        const bText = b.cells[colIndex]?.innerText.trim().toLowerCase() ?? '';
        return asc ? aText.localeCompare(bText) : bText.localeCompare(aText);
    });

    rows.forEach(r => tbody.appendChild(r));
}
</script>
@endpush
