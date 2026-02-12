@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Roles</h1>
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Display Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Users</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-700 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @foreach($roles as $role)
                <tr>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ $role->name }}</td>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ $role->display_name }}</td>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ $role->users_count }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-red-600 hover:text-red-700 hover:underline text-sm font-medium">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
