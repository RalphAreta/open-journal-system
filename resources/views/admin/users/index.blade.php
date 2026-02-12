@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Users</h1>
    <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add User</a>
</div>
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Roles</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($users as $u)
                <tr>
                    <td class="px-4 py-3 text-sm">{{ $u->name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $u->email }}</td>
                    <td class="px-4 py-3 text-sm">{{ $u->roles->pluck('display_name')->join(', ') ?: '-' }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.users.edit', $u) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                        @if(!$u->isAdmin() || \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->count() > 1)
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline ml-2" onsubmit="return confirm('Delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No users.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-2 border-t border-slate-200">{{ $users->links() }}</div>
</div>
@endsection
