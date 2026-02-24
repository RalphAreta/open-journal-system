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
<div class="max-w-6xl mx-auto py-8 px-4">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
                <a href="{{ route('dashboard.admin') }}" class="hover:text-red-600 transition-colors">Admin</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                <span class="text-slate-900 tracking-widest">Directory</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter leading-tight">Users</h1>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-8 py-4 bg-red-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-100 active:scale-95">
            Add New User
        </a>
    </div>

    {{-- Content Card --}}
    <div class="bg-white border border-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">User Identity</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Email Address</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Assigned Roles</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xs font-black shadow-sm group-hover:bg-red-600 transition-colors uppercase">
                                    {{ substr($u->name, 0, 2) }}
                                </div>
                                <span class="text-sm font-bold text-slate-900">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="p-6 text-sm font-medium text-slate-500 lowercase">{{ $u->email }}</td>
                        <td class="p-6">
                            <div class="flex flex-wrap gap-1.5">
                                @php $displayRoles = $u->roles->pluck('display_name')->filter(); @endphp
                                @forelse($displayRoles as $roleName)
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[9px] font-black uppercase tracking-tighter rounded-lg border border-slate-200">
                                        {{ $roleName }}
                                    </span>
                                @empty
                                    <span class="text-[10px] font-bold text-slate-300 uppercase italic">No Roles</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="p-6">
                            {{-- ALIGNED ACTIONS --}}
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.users.edit', $u) }}" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors">
                                    Edit
                                </a>
                                @if(!$u->isAdmin() || \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->count() > 1)
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline-flex" onsubmit="return confirm('Permanently delete this user?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:text-red-800 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">No users found in system directory</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-6 bg-slate-50 border-t border-slate-100">{{ $users->links() }}</div>
        @endif
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