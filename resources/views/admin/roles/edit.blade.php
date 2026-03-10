@extends('layouts.app')

@section('title', 'Edit Role: ' . $role->display_name)

@section('content')
<div class="min-h-screen bg-[#faf6ef] font-sans text-[#1a1209]" x-data="{ tab: 'settings' }">
<div class="max-w-4xl mx-auto px-4">

    {{-- ── Hero Header ── --}}
    <div class="relative pt-11 pb-8 mb-9 border-b border-[#e8dfd0]">
        <div class="absolute bottom-[-1px] left-0 w-20 h-[3px] bg-gradient-to-r from-[#c9a84c] to-transparent"></div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 mb-3.5">
                    <a href="{{ route('dashboard.admin') }}" class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#2d8176] hover:opacity-70 transition-opacity">Admin</a>
                    <svg class="w-2.5 h-2.5 text-[#c9b99a]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('admin.roles.index') }}" class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#2d8176] hover:opacity-70 transition-opacity">Roles</a>
                    <svg class="w-2.5 h-2.5 text-[#c9b99a]" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    <span class="text-[11px] font-bold tracking-[0.14em] uppercase text-[#1a1209]">{{ $role->name }}</span>
                </nav>

                {{-- Eyebrow --}}
                <div class="flex items-center gap-2.5 mb-2.5">
                    <div class="w-6 h-px bg-[#c9a84c]"></div>
                    <p class="text-[11px] font-bold tracking-[0.2em] uppercase text-[#8a6e28]">Role Configuration</p>
                </div>

                <h1 class="font-serif text-[2.8rem] font-bold text-[#1a1209] tracking-[-0.01em] leading-[1.15]">
                    <em class="italic text-[#8a6e28]">{{ $role->display_name }}</em>
                </h1>
                <p class="text-[0.98rem] text-[#6b5740] mt-2">Update role details and manage assigned members</p>
            </div>

            <a href="{{ route('admin.roles.index') }}"
               class="self-start md:self-auto shrink-0 inline-flex items-center gap-2 bg-[#f3ece0] border border-[#c9b99a] text-[#6b5740] text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-md hover:bg-white hover:text-[#1a1209] transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Back to Roles
            </a>
        </div>
    </div>

    {{-- ── Tabs ── --}}
    <div class="flex items-center gap-2 mb-6">
        <button @click="tab = 'settings'"
            :class="tab === 'settings'
                ? 'bg-[#2d8176] text-white shadow-[0_4px_14px_rgba(45,129,118,0.28)]'
                : 'bg-white border border-[#e8dfd0] text-[#6b5740] hover:border-[#c9b99a] hover:text-[#1a1209]'"
            class="inline-flex items-center gap-2 text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-md transition-all">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            Settings
        </button>

        <button @click="tab = 'members'"
            :class="tab === 'members'
                ? 'bg-[#2d8176] text-white shadow-[0_4px_14px_rgba(45,129,118,0.28)]'
                : 'bg-white border border-[#e8dfd0] text-[#6b5740] hover:border-[#c9b99a] hover:text-[#1a1209]'"
            class="inline-flex items-center gap-2 text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-md transition-all">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a2 2 0 11-4 0 2 2 0 014 0zM7 16a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Members
            <span :class="tab === 'members' ? 'bg-white/20 text-white' : 'bg-[#f3ece0] text-[#6b5740]'"
                  class="text-[0.6rem] font-bold px-2 py-0.5 rounded-full transition-all">
                {{ $role->users->count() }}
            </span>
        </button>
    </div>

    {{-- ── Tab: Settings ── --}}
    <div x-show="tab === 'settings'" x-transition class="space-y-4 mb-12">

        {{-- Form Card --}}
        <div class="bg-white border border-[#e8dfd0] rounded-2xl shadow-[0_1px_6px_rgba(26,18,9,0.05)] overflow-hidden">

            {{-- Card Top Bar --}}
            <div class="h-[3px] bg-gradient-to-r from-[#c9a84c] to-[#2d8176]"></div>

            <div class="p-8">
                {{-- Section label --}}
                <div class="flex items-center gap-3 mb-7">
                    <span class="text-[0.68rem] font-bold tracking-[0.18em] uppercase text-[#6b5740] whitespace-nowrap">Role Details</span>
                    <div class="flex-1 h-px bg-[#e8dfd0]"></div>
                </div>

                <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Display Name --}}
                    <div>
                        <label class="block text-[0.64rem] font-bold tracking-[0.14em] uppercase text-[#6b5740] mb-2">
                            Display Name
                        </label>
                        <input type="text" name="display_name"
                               value="{{ old('display_name', $role->display_name) }}"
                               required
                               class="w-full px-4 py-3 bg-[#f3ece0] border border-[#e8dfd0] rounded-lg text-[0.92rem] font-semibold text-[#1a1209] font-sans focus:outline-none focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[rgba(201,168,76,0.12)] transition-all">
                        @error('display_name')
                            <p class="mt-1.5 text-[0.72rem] text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-[0.64rem] font-bold tracking-[0.14em] uppercase text-[#6b5740] mb-2">
                            Scope Description
                        </label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-3 bg-[#f3ece0] border border-[#e8dfd0] rounded-lg text-[0.92rem] font-semibold text-[#1a1209] font-sans focus:outline-none focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[rgba(201,168,76,0.12)] transition-all resize-none">{{ old('description', $role->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-[0.72rem] text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 pt-2 border-t border-[#e8dfd0]">
                        <button type="submit"
                                class="relative overflow-hidden inline-flex items-center gap-2 bg-[#2d8176] text-white text-[0.68rem] font-bold tracking-[0.1em] uppercase px-6 py-3 rounded-md shadow-[0_4px_14px_rgba(45,129,118,0.25)] hover:bg-[#1a4d46] hover:-translate-y-0.5 hover:shadow-[0_8px_22px_rgba(45,129,118,0.3)] transition-all">
                            <span class="absolute inset-0 bg-gradient-to-br from-[rgba(201,168,76,0.15)] to-transparent pointer-events-none"></span>
                            <svg class="w-3.5 h-3.5 relative z-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span class="relative z-10">Update Details</span>
                        </button>
                        <a href="{{ route('admin.roles.index') }}"
                           class="inline-flex items-center gap-2 bg-[#f3ece0] border border-[#c9b99a] text-[#6b5740] text-[0.68rem] font-bold tracking-[0.1em] uppercase px-6 py-3 rounded-md hover:bg-white hover:text-[#1a1209] transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-red-50 border border-red-100 rounded-2xl px-8 py-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div>
                <p class="text-[0.64rem] font-bold tracking-[0.14em] uppercase text-red-500 mb-1.5">Danger Zone</p>
                <p class="text-[0.84rem] text-red-400 font-medium">Permanently remove this role from the system.</p>
            </div>
            <form id="delete-role-form" action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="shrink-0">
                @csrf
                @method('DELETE')
                <button type="button"
                        onclick="confirmRoleDeletion('{{ $role->display_name }}')"
                        class="inline-flex items-center gap-2 bg-white border border-red-200 text-red-500 text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-md hover:border-red-400 hover:text-red-600 hover:-translate-y-px transition-all whitespace-nowrap">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Delete Role
                </button>
            </form>
        </div>
    </div>

    {{-- ── Tab: Members ── --}}
    <div x-show="tab === 'members'" x-transition class="mb-12">
        <div class="bg-white border border-[#e8dfd0] rounded-2xl shadow-[0_1px_6px_rgba(26,18,9,0.05)] overflow-hidden">

            {{-- Card Top Bar --}}
            <div class="h-[3px] bg-gradient-to-r from-[#c9a84c] to-[#2d8176]"></div>

            {{-- Card Header --}}
            <div class="px-8 py-5 border-b border-[#e8dfd0] bg-[#faf6ef] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-[0.68rem] font-bold tracking-[0.18em] uppercase text-[#6b5740]">Assigned Members</span>
                    <div class="w-8 h-px bg-[#e8dfd0]"></div>
                </div>
                <span class="text-[0.64rem] font-bold bg-[#f3ece0] border border-[#e8dfd0] text-[#6b5740] px-3 py-1 rounded-full tracking-[0.08em] uppercase">
                    {{ $role->users->count() }} {{ Str::plural('user', $role->users->count()) }}
                </span>
            </div>

            {{-- Member List --}}
            <div class="p-6 space-y-1.5">
                @forelse($role->users as $u)
                <div class="flex items-center justify-between px-4 py-3.5 rounded-lg border border-transparent hover:bg-[#e8f4f2] hover:border-[#e8dfd0] transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-[#1a4d46] text-white rounded-lg flex items-center justify-center font-serif text-sm font-bold uppercase shrink-0">
                            {{ substr($u->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[0.88rem] font-bold text-[#1a1209] leading-tight">{{ $u->name }}</p>
                            <p class="text-[0.72rem] text-[#6b5740] leading-tight mt-0.5">{{ $u->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.edit', $u) }}"
                       class="opacity-0 group-hover:opacity-100 inline-flex items-center gap-1.5 text-[0.62rem] font-bold tracking-[0.1em] uppercase text-[#2d8176] transition-opacity shrink-0">
                        View Profile
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                </div>
                @empty
                <div class="text-center py-16">
                    <svg class="w-12 h-12 mx-auto text-[#e8dfd0] mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a2 2 0 11-4 0 2 2 0 014 0zM7 16a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p class="text-[0.68rem] font-bold tracking-[0.14em] uppercase text-[#c9b99a]">No Users Assigned</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
</div>

@push('scripts')
<script>
    function confirmRoleDeletion(roleName) {
        Swal.fire({
            title: 'Delete Role?',
            text: `Are you sure you want to permanently remove the "${roleName}" role?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2d8176',
            cancelButtonColor: '#c9b99a',
            confirmButtonText: 'Yes, Delete it',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-role-form').submit();
            }
        });
    }
</script>
@endpush
@endsection