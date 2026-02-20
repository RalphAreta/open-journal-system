@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <div class="mb-10">
        <h1 class="text-5xl font-black text-slate-900 tracking-tighter leading-tight">Admin Dashboard</h1>
        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">System management and configuration</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        {{-- Users --}}
        <a href="{{ route('admin.users.index') }}" class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm hover:shadow-xl hover:border-red-200 transition-all group relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Users</p>
                <p class="text-5xl font-black text-slate-900 mb-4 tracking-tighter">{{ $userCount }}</p>
                <p class="text-[10px] font-black uppercase tracking-widest text-red-600 flex items-center gap-1">
                    Manage users <span class="group-hover:translate-x-1 transition-transform">→</span>
                </p>
            </div>
            <div class="absolute top-8 right-8 text-slate-100 group-hover:text-red-50 transition-colors">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
        </a>

        {{-- Roles --}}
        <a href="{{ route('admin.roles.index') }}" class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm hover:shadow-xl hover:border-red-200 transition-all group relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Roles</p>
                <p class="text-5xl font-black text-slate-900 mb-4 tracking-tighter">{{ $roleCount }}</p>
                <p class="text-[10px] font-black uppercase tracking-widest text-red-600 flex items-center gap-1">
                    Manage roles <span class="group-hover:translate-x-1 transition-transform">→</span>
                </p>
            </div>
            <div class="absolute top-8 right-8 text-slate-100 group-hover:text-red-50 transition-colors">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
        </a>

        {{-- Submissions --}}
        <a href="{{ route('admin.submissions') }}" class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm hover:shadow-xl hover:border-red-200 transition-all group relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Submissions</p>
                <p class="text-5xl font-black text-slate-900 mb-4 tracking-tighter">{{ $submissionCount }}</p>
                <p class="text-[10px] font-black uppercase tracking-widest text-red-600 flex items-center gap-1">
                    View submissions <span class="group-hover:translate-x-1 transition-transform">→</span>
                </p>
            </div>
            <div class="absolute top-8 right-8 text-slate-100 group-hover:text-red-50 transition-colors">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-10 group">
            <div class="flex items-center gap-6 mb-6">
                <div class="w-16 h-16 bg-slate-900 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-slate-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z" stroke-width="2"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-width="2"/></svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">Editor Expertise</h3>
                    <p class="text-xs text-slate-500 font-medium">Manage specialized research fields and reviewer assignments.</p>
                </div>
            </div>
            <a href="{{ route('admin.editor-expertise.index') }}" class="inline-flex w-full justify-center bg-blue-600 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-50 active:scale-95">
                Manage Expertise System
            </a>
        </div>
    </div>
</div>
@endsection
