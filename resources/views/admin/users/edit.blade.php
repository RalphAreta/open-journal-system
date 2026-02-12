@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Edit User</h1>
<form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-md space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label for="name" class="block text-sm font-medium text-slate-700">Name *</label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm @error('name') border-red-500 @enderror">
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email *</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm @error('email') border-red-500 @enderror">
        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-slate-700">New Password (leave blank to keep)</label>
        <input id="password" type="password" name="password" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm @error('password') border-red-500 @enderror">
        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm New Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Roles</label>
        @foreach($roles as $role)
            <label class="inline-flex items-center mr-4">
                <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'checked' : '' }} class="rounded border-slate-300">
                <span class="ml-2">{{ $role->display_name }}</span>
            </label>
        @endforeach
    </div>
    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update</button>
        <a href="{{ route('admin.users.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-md hover:bg-slate-300">Cancel</a>
    </div>
</form>
@endsection
