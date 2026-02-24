@extends('layouts.app')

@section('title', 'System Roles')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    {{-- Header Section with Back Option --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
                <a href="{{ route('dashboard.admin') }}" class="hover:text-red-600 transition-colors">Admin</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                <span class="text-slate-900 tracking-widest uppercase">Access Control</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter leading-tight uppercase italic">Roles & Permissions</h1>
        </div>

        <a href="{{ route('dashboard.admin') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 hover:text-slate-600 transition-all active:scale-95 flex items-center gap-2">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($roles as $role)
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm group hover:border-red-200 transition-all relative overflow-hidden">
            {{-- Decorative Icon --}}
            <div class="absolute -right-4 -top-4 text-slate-50 group-hover:text-red-50 transition-colors transform rotate-12">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>

            <div class="relative z-10">
                <div class="mb-6">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Role Name</p>
                    <h3 class="text-lg font-black text-red-600 uppercase tracking-tight leading-tight italic">{{ $role->display_name }}</h3>
                </div>

                <div class="flex items-end justify-between border-t border-slate-50 pt-6 mt-12">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Active Users</p>
                        <p class="text-3xl font-black text-slate-900 tracking-tighter leading-none">
                            {{ $role->users_count ?? $role->users->count() }}
                        </p>
                    </div>
                    <a href="{{ route('admin.roles.edit', $role) }}" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-red-600 transition-all shadow-lg shadow-slate-200 active:scale-95">
                        Configure
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
