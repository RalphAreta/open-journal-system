@extends('layouts.app')

@section('title', 'Manage Users')

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
<div class="font-body max-w-6xl mx-auto">

    {{-- ── Header ── --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-7 fade-up">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mb-4">
                <a href="{{ route('dashboard.admin') }}" class="hover:text-red-600 transition-colors">Admin</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" stroke-width="2.5"/>
                </svg>
                <span class="text-slate-600">Directory</span>
            </nav>
            <h1 class="font-serif-display text-[1.85rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight">
                Users
            </h1>
            <p class="text-sm text-slate-500 mt-1">Manage system accounts and role assignments</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white
                  px-5 py-2.5 rounded-[9px] text-[11px] font-bold uppercase tracking-[.07em]
                  transition-all hover:-translate-y-0.5 shadow-md shadow-red-100/80
                  hover:shadow-lg hover:shadow-red-200/50 whitespace-nowrap self-start md:self-auto">
            + Add New User
        </a>
    </div>

    {{-- ── Table Card ── --}}
    <div class="bg-white border border-slate-200 rounded-[14px] overflow-hidden shadow-sm fade-up-1">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">User Identity</th>
                        <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Email Address</th>
                        <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Assigned Roles</th>
                        <th class="px-6 py-3.5 text-right text-[10px] font-bold uppercase tracking-[.09em] text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50/60 transition-colors group">

                        {{-- Identity --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-[9px] bg-slate-900 text-white flex items-center justify-center
                                            text-[11px] font-bold uppercase flex-shrink-0
                                            group-hover:bg-red-600 transition-colors">
                                    {{ substr($u->name, 0, 2) }}
                                </div>
                                <span class="text-sm font-semibold text-slate-900">{{ $u->name }}</span>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-500 lowercase">{{ $u->email }}</span>
                        </td>

                        {{-- Roles --}}
                        <td class="px-6 py-4">
                            @php $displayRoles = $u->roles->pluck('display_name')->filter(); @endphp
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($displayRoles as $roleName)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200
                                             text-[10px] font-bold uppercase tracking-[.04em] text-slate-600">
                                    {{ $roleName }}
                                </span>
                                @empty
                                <span class="text-xs text-slate-300 italic font-medium">No roles</span>
                                @endforelse
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $u) }}"
                                   class="text-[11px] font-bold uppercase tracking-[.06em] text-slate-400 hover:text-slate-700 transition-colors">
                                    Edit
                                </a>
                                @if(!$u->isAdmin() || \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->count() > 1)
                                <span class="text-slate-200 select-none">|</span>
                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                      class="inline-flex"
                                      onsubmit="return confirm('Permanently delete this user?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-[11px] font-bold uppercase tracking-[.06em] text-red-500 hover:text-red-700 transition-colors">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <p class="text-[11px] font-bold uppercase tracking-[.1em] text-slate-300">No users found in system directory</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-5 py-3 bg-slate-50 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection