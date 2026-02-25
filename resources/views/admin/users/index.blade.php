@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                <a href="{{ route('dashboard.admin') }}" class="hover:text-red-600 transition-colors">Admin</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                <span class="text-slate-900 tracking-widest uppercase">Directory</span>
            </nav>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Users</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.admin') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 hover:text-slate-600 transition-all active:scale-95 flex items-center gap-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Back
            </a>
            <a href="{{ route('admin.users.create') }}" class="px-6 py-3 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-100 active:scale-95">
                Add New User
            </a>
        </div>
    </div>

    {{-- Thinner Filter & Search Section --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-6">
        {{-- Search Input (Height Reduced) --}}
        <div class="md:col-span-8 bg-white border border-slate-200 rounded-2xl p-1.5 shadow-sm flex items-center">
            <div class="relative w-full">
                <input type="text" id="userSearch" onkeyup="applyFilters()"
                    placeholder="Search by name or email..."
                    class="w-full pl-10 pr-4 py-2 bg-transparent border-none text-sm font-bold text-slate-900 focus:ring-0 outline-none">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Role Filter (Thinner & Compact) --}}
        <div class="md:col-span-4 relative group">
            <div class="absolute inset-0 bg-slate-900 border border-slate-900 rounded-2xl shadow-md group-hover:bg-red-600 group-hover:border-red-600 transition-all pointer-events-none"></div>

            <div class="absolute inset-0 flex items-center px-5 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-white/50 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="flex flex-col flex-grow">
                    <span class="text-[6px] font-black text-white/40 uppercase tracking-[0.2em] leading-tight">Filter</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-white leading-tight" id="filterLabel">All Roles</span>
                </div>
                <svg class="w-3.5 h-3.5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3"/></svg>
            </div>

            <select id="roleFilter" onchange="applyFilters(); document.getElementById('filterLabel').innerText = this.options[this.selectedIndex].text"
                class="relative z-10 w-full h-full py-4 opacity-0 cursor-pointer">
                <option value="">All Roles</option>
                @foreach(\App\Models\Role::orderBy('display_name')->get() as $role)
                    <option value="{{ strtolower($role->display_name) }}">{{ $role->display_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="userTable">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">User Identity</th>
                        <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Email Address</th>
                        <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Assigned Roles</th>
                        <th class="p-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50/50 transition-colors group user-row"
                        data-roles="{{ strtolower($u->roles->pluck('display_name')->implode(',')) }}">
                        <td class="p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-slate-900 text-white flex items-center justify-center text-[10px] font-black shadow-sm group-hover:bg-red-600 transition-colors uppercase">
                                    {{ substr($u->name, 0, 2) }}
                                </div>
                                <span class="text-sm font-bold text-slate-900 uppercase italic">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="p-5 text-sm font-medium text-slate-500 lowercase">{{ $u->email }}</td>
                        <td class="p-5">
                            <div class="flex flex-wrap gap-1">
                                @php $displayRoles = $u->roles->pluck('display_name')->filter(); @endphp
                                @forelse($displayRoles as $roleName)
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[8px] font-black uppercase tracking-tighter rounded-md border border-slate-200">
                                        {{ $roleName }}
                                    </span>
                                @empty
                                    <span class="text-[9px] font-bold text-slate-300 uppercase italic">No Roles</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $u) }}" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors">
                                    Edit
                                </a>

                                @if(!$u->isAdmin() || \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->count() > 1)
                                    <form id="delete-form-{{ $u->id }}" method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline-flex">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmUserDeletion({{ $u->id }}, '{{ $u->name }}')" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:text-red-800 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-16 text-center">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">No users found in system directory</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function applyFilters() {
        const searchText = document.getElementById('userSearch').value.toLowerCase();
        const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');

        rows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            const rowRoles = row.getAttribute('data-roles');

            const matchesSearch = rowText.includes(searchText);
            const matchesRole = roleFilter === "" || rowRoles.includes(roleFilter);

            if (matchesSearch && matchesRole) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function confirmUserDeletion(userId, userName) {
        Swal.fire({
            title: 'Delete user?',
            text: `Are you sure you want to remove ${userName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-3xl border border-slate-100 shadow-2xl p-6',
                title: 'text-xl font-black tracking-tighter uppercase italic text-slate-900',
                confirmButton: 'px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest mx-1',
                cancelButton: 'px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest mx-1'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>
@endpush
@endsection
