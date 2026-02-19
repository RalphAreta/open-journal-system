@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center relative overflow-hidden"
     style="background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
            url('{{ asset('images/homepage-webslider-1.jpg') }}') center/cover no-repeat;">

    <div class="max-w-xl w-full bg-white rounded-2xl p-10 border-2 border-red-200 shadow-2xl mx-4 relative z-10">

        {{-- Header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/batstateu-logo.png') }}" alt="BatStateU Logo"
                 class="h-12 mx-auto mb-4 hover:opacity-80 transition-opacity">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 to-red-700 bg-clip-text text-transparent mb-2">
                Welcome to IRJIEST
            </h1>
            <p class="text-sm text-slate-600">International Research Journal of Information Systems & Engineering Technology</p>
            <p class="text-xs text-slate-500 mt-1">Batangas State University</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Role Selector --}}
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Sign in as</label>
                <div class="relative">
                    <select id="role" name="role" required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 shadow-sm appearance-none
                               bg-white text-slate-700 font-medium
                               focus:border-red-500 focus:ring-2 focus:ring-red-500 focus:ring-opacity-50
                               transition-all cursor-pointer
                               @error('role') border-red-500 @enderror">
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>— Select your role —</option>
                        <option value="author"          {{ old('role') === 'author'           ? 'selected' : '' }}>  Author</option>
                        <option value="reviewer"        {{ old('role') === 'reviewer'         ? 'selected' : '' }}>  Reviewer</option>
                        <option value="editor"          {{ old('role') === 'editor'           ? 'selected' : '' }}>  Editor</option>
                        <option value="editor-in-chief" {{ old('role') === 'editor-in-chief'  ? 'selected' : '' }}>  Editor in Chief</option>
                        <option value="admin"           {{ old('role') === 'admin'            ? 'selected' : '' }}>  Admin</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 shadow-sm
                           focus:border-red-500 focus:ring-2 focus:ring-red-500 focus:ring-opacity-50
                           transition-all @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 shadow-sm
                           focus:border-red-500 focus:ring-2 focus:ring-red-500 focus:ring-opacity-50
                           transition-all">
            </div>

            {{-- Remember me --}}
            <div class="flex items-center pt-1">
                <input id="remember" type="checkbox" name="remember"
                       class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-2 focus:ring-red-500">
                <label for="remember" class="ml-2 text-sm text-slate-600 cursor-pointer">Keep me signed in</label>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-2.5 px-4 rounded-lg
                       hover:shadow-lg hover:from-red-700 hover:to-red-800
                       font-semibold transition-all duration-200 mt-2">
                Sign In
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-200">
            <p class="text-sm text-center text-slate-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 font-semibold transition-colors">
                    Create account
                </a>
            </p>
        </div>
    </div>
</div>
@endsection