@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    {{-- Header Section with Back Option --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
                <a href="{{ route('dashboard.admin') }}" class="hover:text-red-600 transition-colors">Admin</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                <a href="{{ route('admin.users.index') }}" class="hover:text-red-600 transition-colors">Directory</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                <span class="text-slate-900 tracking-widest uppercase">Edit Profile</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter leading-tight uppercase italic">Edit User</h1>
        </div>

        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 hover:text-slate-600 transition-all active:scale-95 flex items-center gap-2">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white border border-slate-200 rounded-[2.5rem] p-10 shadow-sm transition-all">
        @csrf
        @method('PUT')

        <div class="space-y-8">
            {{-- Identity Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="name" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name *</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-red-600 focus:bg-white transition-all outline-none @error('name') ring-2 ring-red-500 @enderror">
                    @error('name')<p class="mt-1 text-[10px] font-bold text-red-600 uppercase ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address *</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-red-600 focus:bg-white transition-all outline-none @error('email') ring-2 ring-red-500 @enderror">
                    @error('email')<p class="mt-1 text-[10px] font-bold text-red-600 uppercase ml-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Security Section with Eye Toggle --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-slate-50 pt-8">
                <div class="space-y-2">
                    <label for="password" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password (leave blank to keep)</label>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-red-600 focus:bg-white transition-all outline-none @error('password') ring-2 ring-red-500 @enderror">
                        <button type="button" onclick="togglePassword('password')" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 transition-colors">
                            <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="mt-1 text-[10px] font-bold text-red-600 uppercase ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-red-600 focus:bg-white transition-all outline-none">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 transition-colors">
                            <svg id="eye-icon-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Roles Section --}}
            <div class="space-y-4 border-t border-slate-50 pt-8">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">System Roles</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-colors bordhas-[:checked]:border-red-600er-2 border-transparent group">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
                                class="w-4 h-4 text-red-600 rounded border-slate-300 focus:ring-red-600">
                            <span class="text-[10px] font-black uppercase tracking-tight text-slate-600  transition-colors">
                                {{ $role->display_name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-4 mt-12 pt-8 border-t border-slate-100">
            <button type="submit" class="px-10 py-4 bg-red-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-100 active:scale-95">
                Update Account
            </button>
            <a href="{{ route('admin.users.index') }}" class="px-10 py-4 bg-slate-100 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 hover:text-slate-600 transition-all active:scale-95">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById('eye-icon-' + id);
        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
        } else {
            input.type = "password";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }
</script>
@endsection
