@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Edit Role: {{ $role->display_name }}</h1>
<form method="POST" action="{{ route('admin.roles.update', $role) }}" class="max-w-md space-y-4 mb-8">
    @csrf
    @method('PUT')
    <div>
        <label for="display_name" class="block text-sm font-medium text-slate-700">Display Name *</label>
        <input id="display_name" type="text" name="display_name" value="{{ old('display_name', $role->display_name) }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
    </div>
    <div>
        <label for="description" class="block text-sm font-medium text-slate-700">Description</label>
        <textarea id="description" name="description" rows="2" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">{{ old('description', $role->description) }}</textarea>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium shadow-sm transition-colors">Update</button>
</form>
<h2 class="text-lg font-medium mb-2">Users with this role</h2>
<ul class="list-disc list-inside text-slate-600">
    @forelse($role->users as $u)
        <li><a href="{{ route('admin.users.edit', $u) }}" class="text-red-600 hover:text-red-700 hover:underline font-medium">{{ $u->name }}</a> ({{ $u->email }})</li>
    @empty
        <li>No users</li>
    @endforelse
</ul>
<p class="mt-4"><a href="{{ route('admin.roles.index') }}" class="text-red-600 hover:text-red-700 hover:underline font-medium">← Back to roles</a></p>
@endsection
