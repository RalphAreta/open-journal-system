@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow p-6 border border-slate-200 hover:border-indigo-300 transition">
        <p class="text-sm text-slate-500">Users</p>
        <p class="text-3xl font-semibold">{{ $userCount }}</p>
        <p class="mt-2 text-sm text-indigo-600">Manage users →</p>
    </a>
    <a href="{{ route('admin.roles.index') }}" class="bg-white rounded-lg shadow p-6 border border-slate-200 hover:border-indigo-300 transition">
        <p class="text-sm text-slate-500">Roles</p>
        <p class="text-3xl font-semibold">{{ $roleCount }}</p>
        <p class="mt-2 text-sm text-indigo-600">Manage roles →</p>
    </a>
    <a href="{{ route('editor.submissions') }}" class="bg-white rounded-lg shadow p-6 border border-slate-200 hover:border-indigo-300 transition">
        <p class="text-sm text-slate-500">Submissions</p>
        <p class="text-3xl font-semibold">{{ $submissionCount }}</p>
        <p class="mt-2 text-sm text-indigo-600">View submissions →</p>
    </a>
</div>
<div class="flex gap-4">
    <a href="{{ route('admin.settings.index') }}" class="bg-white rounded-lg shadow p-4 border border-slate-200 hover:border-indigo-300 text-slate-700">System Settings</a>
</div>
@endsection
