@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Roles</h1>
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Display Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Users</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @foreach($roles as $role)
                <tr>
                    <td class="px-4 py-3 text-sm">{{ $role->name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $role->display_name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $role->users_count }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
