@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900 mb-2">Admin Dashboard</h1>
    <p class="text-lg text-slate-600">System management and configuration</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <a href="{{ route('admin.users.index') }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 p-6 transition-all duration-200 group">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-slate-600 group-hover:text-slate-900">Users</p>
            <span class="text-3xl group-hover:scale-110 transition-transform duration-200">👥</span>
        </div>
        <p class="text-4xl font-bold text-slate-900 mb-2">{{ $userCount }}</p>
        <p class="text-sm text-red-600 font-medium group-hover:text-red-700">Manage users →</p>
    </a>

    <a href="{{ route('admin.roles.index') }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 p-6 transition-all duration-200 group">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-slate-600 group-hover:text-slate-900">Roles</p>
            <span class="text-3xl group-hover:scale-110 transition-transform duration-200">🔐</span>
        </div>
        <p class="text-4xl font-bold text-slate-900 mb-2">{{ $roleCount }}</p>
        <p class="text-sm text-red-600 font-medium group-hover:text-red-700">Manage roles →</p>
    </a>

    <a href="{{ route('admin.submissions') }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 p-6 transition-all duration-200 group">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-slate-600 group-hover:text-slate-900">Submissions</p>
            <span class="text-3xl group-hover:scale-110 transition-transform duration-200">📄</span>
        </div>
        <p class="text-4xl font-bold text-slate-900 mb-2">{{ $submissionCount }}</p>
        <p class="text-sm text-red-600 font-medium group-hover:text-red-700">View submissions →</p>
    </a>
</div>

<div class="flex gap-4">
    <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-all duration-200 font-medium shadow-sm hover:shadow-md">
        <span>⚙️</span> System Settings
    </a>
</div>
@endsection
