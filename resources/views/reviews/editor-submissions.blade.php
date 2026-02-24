@extends('layouts.app')

@section('title', 'Manage Submissions')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Instrument Serif', serif; }
    .font-body          { font-family: 'DM Sans', sans-serif; }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation: fadeUp .4s .07s ease both; }
    .fade-up-2 { animation: fadeUp .4s .14s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
</style>
@endpush

@section('content')
<div class="font-body max-w-7xl mx-auto py-10 px-4">

    {{--  Flash Messages  --}}
    @if ($errors->any())
    <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-[9px] fade-up">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-[11px] font-bold uppercase tracking-widest text-red-700">Error</p>
        </div>
        <ul class="space-y-1 ml-6 list-disc">
            @foreach ($errors->all() as $error)
                <li class="text-xs text-red-600 font-medium">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-[9px] flex items-center gap-2 fade-up">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="text-xs font-semibold text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    {{--  Header  --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 fade-up">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
                <a href="{{ route('dashboard.editor') }}" class="hover:text-red-600 transition-colors">Admin</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                <span class="text-slate-900 tracking-widest">Global Submissions</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Manage Submissions</h1>
            <p class="text-slate-500 font-medium mt-3">Review, assign, and track manuscript progress across the system.</p>
        </div>

        <div class="flex items-center gap-4">
            <span class="text-[10px] font-black text-slate-400 bg-white border border-slate-200 px-4 py-2 rounded-xl hidden sm:inline-block uppercase tracking-widest">
                {{ now()->format('D, M j Y') }}
            </span>
            <a href="{{ route('dashboard.editor') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 hover:text-slate-600 transition-all active:scale-95 flex items-center gap-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Back
            </a>
        </div>
    </div>

    {{--  Table Card  --}}
    <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm fade-up-1">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Title</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Author</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Reviews</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($submissions as $s)
                    @php
                        $reviews        = $s->reviews()->get();
                        $assignments    = $s->reviewAssignments()->get();
                        $completed      = $reviews->count();
                        $pending        = $assignments->where('status', 'assigned')->count();
                        $accepts        = $reviews->where('recommendation', 'accept')->count();
                        $rejects        = $reviews->where('recommendation', 'reject')->count();
                        $minorRevisions = $reviews->where('recommendation', 'minor_revisions')->count();
                        $majorRevisions = $reviews->where('recommendation', 'major_revisions')->count();

                        $statusCls = match($s->status) {
                            'submitted'            => 'bg-blue-50 border-blue-200 text-blue-700 [&_.dot]:bg-blue-500',
                            'under_review'         => 'bg-amber-50 border-amber-200 text-amber-700 [&_.dot]:bg-amber-500',
                            'accepted'             => 'bg-emerald-50 border-emerald-200 text-emerald-700 [&_.dot]:bg-emerald-500',
                            'rejected'             => 'bg-red-50 border-red-200 text-red-700 [&_.dot]:bg-red-500',
                            'revisions_requested'  => 'bg-orange-50 border-orange-200 text-orange-700 [&_.dot]:bg-orange-500',
                            default                => 'bg-slate-50 border-slate-200 text-slate-600 [&_.dot]:bg-slate-400',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors group">
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-900 group-hover:text-red-600 transition-colors leading-snug">
                                {{ Str::limit($s->title, 50) }}
                            </p>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[8px] font-black text-slate-500">
                                    {{ substr($s->author->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-slate-600">{{ $s->author->name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[9px] font-black uppercase tracking-widest {{ $statusCls }}">
                                <span class="dot w-1.5 h-1.5 rounded-full"></span>
                                {{ str_replace('_', ' ', $s->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            @if ($completed > 0 || $pending > 0)
                            <div class="flex flex-wrap items-center gap-1.5">
                                @if ($accepts > 0)
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-50 border border-emerald-200 text-[9px] font-black text-emerald-700">{{ $accepts }}A</span>
                                @endif
                                @if ($rejects > 0)
                                    <span class="px-2 py-0.5 rounded-md bg-red-50 border border-red-200 text-[9px] font-black text-red-700">{{ $rejects }}R</span>
                                @endif
                                @if ($minorRevisions > 0 || $majorRevisions > 0)
                                    <span class="px-2 py-0.5 rounded-md bg-amber-50 border border-amber-200 text-[9px] font-black text-amber-700">{{ $minorRevisions + $majorRevisions }}V</span>
                                @endif
                                @if ($pending > 0)
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 text-[9px] font-black text-slate-500">{{ $pending }}P</span>
                                @endif
                            </div>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">No Activity</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('editor.submission.show', $s) }}"
                               class="inline-flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white
                                      px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest
                                      transition-all active:scale-95 shadow-lg shadow-slate-100">
                                Manage
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/>
                                </svg>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">No submissions found in system</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($submissions->hasPages())
        <div class="px-8 py-4 bg-slate-50 border-t border-slate-100">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>

    {{--  Legend  --}}
    <div class="mt-8 bg-white border border-slate-200 rounded-[2rem] px-8 py-5 flex flex-wrap items-center gap-4 fade-up-2">
        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 mr-2">Review Key</span>
        <div class="flex items-center gap-4">
            <span class="flex items-center gap-2 text-[9px] font-black text-emerald-700 uppercase"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Accept</span>
            <span class="flex items-center gap-2 text-[9px] font-black text-red-700 uppercase"><span class="w-2 h-2 rounded-full bg-red-500"></span> Reject</span>
            <span class="flex items-center gap-2 text-[9px] font-black text-amber-700 uppercase"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Revisions</span>
            <span class="flex items-center gap-2 text-[9px] font-black text-slate-500 uppercase"><span class="w-2 h-2 rounded-full bg-slate-400"></span> Pending</span>
        </div>
    </div>

</div>
@endsection
