@extends('layouts.app')

@section('title', 'Edit Role: ' . $role->display_name)

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4" x-data="{ tab: 'settings' }">
    {{-- Header Section --}}
    <div class="flex items-start justify-between mb-8">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                <a href="{{ route('dashboard.admin') }}">Admin</a>
                <span>&gt;</span>
                <a href="{{ route('admin.roles.index') }}">Roles</a>
                <span>&gt;</span>
                <span class="text-slate-900">{{ $role->name }}</span>
            </nav>
            <h1 class="text-6xl font-black text-red-600 uppercase italic tracking-tighter">{{ $role->display_name }}</h1>
        </div>

        {{-- Added Back Button --}}
        <a href="{{ route('admin.roles.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-500 rounded-2xl text-xs font-bold uppercase tracking-wide hover:bg-slate-50 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back
        </a>
    </div>

    {{-- Tab Switcher --}}
    <div class="flex gap-2 mb-6">
        <button @click="tab = 'settings'"
            :class="tab === 'settings' ? 'bg-red-600 text-white shadow-lg shadow-red-100' : 'bg-white text-slate-400 border border-slate-200'"
            class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
            Settings
        </button>
        <button @click="tab = 'members'"
            :class="tab === 'members' ? 'bg-red-600 text-white shadow-lg shadow-red-100' : 'bg-white text-slate-400 border border-slate-200'"
            class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2">
            Members
            <span class="bg-black/20 px-2 py-0.5 rounded text-[8px]">{{ $role->users->count() }}</span>
        </button>
    </div>

    {{-- Tab 1: Settings Form --}}
    <div x-show="tab === 'settings'" x-transition class="space-y-6">
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-10 shadow-sm">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-8">
                @csrf @method('PUT')

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Display Name</label>
                    <input type="text" name="display_name" value="{{ old('display_name', $role->display_name) }}" required
                        class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-red-600 focus:bg-white transition-all outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Scope Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-red-600 focus:bg-white transition-all outline-none resize-none">{{ old('description', $role->description) }}</textarea>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                    <button type="submit" class="px-10 py-4 bg-red-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-100 active:scale-95">
                        Update Details
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="px-10 py-4 bg-slate-100 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-red-50 border border-red-100 rounded-[2rem] p-8 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1">Danger Zone</p>
                <p class="text-xs text-red-400 font-medium">Permanently remove this role from the system.</p>
            </div>

            <form id="delete-role-form" action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                @csrf @method('DELETE')
                <button type="button"
                    onclick="confirmRoleDeletion('{{ $role->display_name }}')"
                    class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">
                    Delete Role
                </button>
            </form>
        </div>
    </div>

    {{-- Tab 2: User List --}}
    <div x-show="tab === 'members'" x-transition class="bg-white border border-slate-200 rounded-[2.5rem] p-10 shadow-sm">
        <div class="space-y-4">
            @forelse($role->users as $u)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl group hover:bg-white border border-transparent hover:border-slate-200 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center text-xs font-black uppercase">
                            {{ substr($u->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $u->name }}</p>
                            <p class="text-[10px] font-medium text-slate-400 lowercase">{{ $u->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.edit', $u) }}" class="text-[10px] font-black text-red-600 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                        View Profile
                    </a>
                </div>
            @empty
                <div class="text-center py-20 text-slate-300 font-black uppercase text-[10px]">
                    No Users Found
                </div>
            @endforelse
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
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, Delete it',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl p-6',
                title: 'text-2xl font-black tracking-tighter uppercase italic text-slate-900',
                confirmButton: 'px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest mx-2',
                cancelButton: 'px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest mx-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                document.getElementById('delete-role-form').submit();
            }
        });
    }
</script>
@endpush
@endsection
