@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .admin-wrap        { font-family: 'DM Sans', sans-serif; }
    .page-title        { font-family: 'Instrument Serif', serif; font-size: 1.85rem; font-weight: 400; letter-spacing: -.015em; line-height: 1.2; }
    .card-number       { font-family: 'Instrument Serif', serif; }
    .card-arrow        { transition: transform .2s; display: inline-block; }
    .nav-card:hover .card-arrow { transform: translateX(4px); }

    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation: fadeUp .4s .07s ease both; }
    .fade-up-2 { animation: fadeUp .4s .14s ease both; }
    .fade-up-3 { animation: fadeUp .4s .21s ease both; }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(12px); }
        to   { opacity:1; transform:translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="admin-wrap max-w-6xl mx-auto">

    {{-- ── Page Header ── --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-7 fade-up">
        <div>
            <h1 class="page-title text-slate-900">Admin Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1">System management and configuration</p>
        </div>
        <span class="text-xs font-medium text-slate-400 bg-white border border-slate-200 px-3 py-1.5 rounded-full hidden sm:inline-block">
            {{ now()->format('D, M j Y') }}
        </span>
    </div>

    {{-- ── Nav / Stat Cards ── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 fade-up-1">

        {{-- Users --}}
        <a href="{{ route('admin.users.index') }}"
           class="nav-card bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm
                  hover:shadow-md hover:border-red-200 hover:-translate-y-0.5
                  transition-all relative overflow-hidden block group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Users</span>
                <div class="w-10 h-10 rounded-[10px] bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-red-50 group-hover:text-red-400 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <p class="card-number text-4xl text-slate-900 leading-none mb-3">{{ $userCount }}</p>
            <p class="text-xs font-bold uppercase tracking-widest text-red-600 flex items-center gap-1">
                Manage users <span class="card-arrow">→</span>
            </p>
        </a>

        {{-- Roles --}}
        <a href="{{ route('admin.roles.index') }}"
           class="nav-card bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm
                  hover:shadow-md hover:border-red-200 hover:-translate-y-0.5
                  transition-all relative overflow-hidden block group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Roles</span>
                <div class="w-10 h-10 rounded-[10px] bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-red-50 group-hover:text-red-400 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>
            <p class="card-number text-4xl text-slate-900 leading-none mb-3">{{ $roleCount }}</p>
            <p class="text-xs font-bold uppercase tracking-widest text-red-600 flex items-center gap-1">
                Manage roles <span class="card-arrow">→</span>
            </p>
        </a>

        {{-- Submissions --}}
        <a href="{{ route('admin.submissions') }}"
           class="nav-card bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm
                  hover:shadow-md hover:border-red-200 hover:-translate-y-0.5
                  transition-all relative overflow-hidden block group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Submissions</span>
                <div class="w-10 h-10 rounded-[10px] bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-red-50 group-hover:text-red-400 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <p class="card-number text-4xl text-slate-900 leading-none mb-3">{{ $submissionCount }}</p>
            <p class="text-xs font-bold uppercase tracking-widest text-red-600 flex items-center gap-1">
                View submissions <span class="card-arrow">→</span>
            </p>
        </a>

    </div>

    {{-- ── Feature Cards ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 fade-up-2">

        {{-- Editor Expertise --}}
        <div class="bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div class="flex items-center gap-4 mb-5">
                <div class="w-11 h-11 bg-slate-900 text-white rounded-[10px] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" stroke-width="2"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-width="2"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 tracking-tight">Editor Expertise</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Manage specialized research fields and reviewer assignments.</p>
                </div>
            </div>
            <a href="{{ route('admin.editor-expertise.index') }}"
               class="flex w-full justify-center items-center gap-2 bg-slate-900 hover:bg-slate-800
                      text-white py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest
                      transition-all hover:-translate-y-0.5 hover:shadow-md">
                Manage Expertise System
            </a>
        </div>

    </div>

</div>
@endsection
