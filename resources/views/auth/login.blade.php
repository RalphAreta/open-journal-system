@extends('layouts.app')

@section('title', 'Login | IRJIEST Portal')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Instrument Serif', serif; }
    .font-body { font-family: 'DM Sans', sans-serif; }
    select { appearance: none; -webkit-appearance: none; }
    .field:focus { outline:none; border-color:#DC2626 !important; background:#fff !important; box-shadow:0 0 0 3px rgba(220,38,38,.07); }
    .pulse-dot { animation: pulseDot 2s infinite; }
    @keyframes pulseDot { 0%,100%{opacity:1} 50%{opacity:.35} }
    .fade-in   { animation: fadeIn .5s ease both; }
    .fade-in-1 { animation: fadeIn .5s .10s ease both; }
    .fade-in-2 { animation: fadeIn .5s .18s ease both; }
    .fade-in-3 { animation: fadeIn .5s .26s ease both; }
    .fade-in-4 { animation: fadeIn .5s .34s ease both; }
    .fade-in-5 { animation: fadeIn .5s .42s ease both; }
    .slide-in  { animation: slideIn .7s ease both; }
    @keyframes fadeIn  { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    @keyframes slideIn { from{opacity:0;transform:translateX(-20px)} to{opacity:1;transform:translateX(0)} }
</style>
@endpush

@section('content')
<div class="min-h-screen flex flex-col md:flex-row font-body bg-slate-50">

    {{-- ── LEFT: Branding ── --}}
    <div class="hidden md:flex md:w-3/5 relative items-center justify-center overflow-hidden">

        {{-- BG --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/homepage-webslider-1.jpg') }}"
                 class="w-full h-full object-cover scale-105 hover:scale-100 transition-transform duration-12000" alt="">
            <div class="absolute inset-0" style="background:linear-gradient(145deg,rgba(127,7,7,.92) 0%,rgba(30,10,10,.75) 50%,rgba(15,23,42,.88) 100%);"></div>
        </div>

        {{-- Top shimmer line --}}
        <div class="absolute top-0 left-0 right-0 h-px" style="background:linear-gradient(90deg,transparent,rgba(255,255,255,.15),transparent);"></div>

        {{-- Decorative rings --}}
        <div class="absolute bottom-20 right-20 w-80 h-80 rounded-full border border-white/8 pointer-events-none">
            <div class="absolute inset-10 rounded-full border border-white/5"></div>
            <div class="absolute inset-20 rounded-full border border-white/4"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 max-w-105 px-12 py-16 slide-in">

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-9">
                <span class="pulse-dot w-1.5 h-1.5 rounded-full bg-red-400"></span>
                <span class="text-[10px] font-bold uppercase tracking-[.12em] text-white/90">Official Research Portal</span>
            </div>

            <h2 class="font-serif-display text-[3.4rem] leading-[1.1] font-normal text-white tracking-[-0.02em] mb-5">
                Advancing<br>
                <span class="italic text-red-300">Innovation</span><br>
                through Research.
            </h2>

            <p class="text-sm text-white/60 leading-relaxed border-l-2 border-white/20 pl-4 mt-6">
                BatStateU International Research Journal of Information Systems &amp; Engineering Technology — peer-reviewed, open-access research for the global academic community.
            </p>


        </div>
    </div>

    {{-- ── RIGHT: Form ── --}}
    <div class="w-full md:w-2/5 flex items-center justify-center bg-white px-8 sm:px-12 py-12 relative
                before:absolute before:top-0 before:left-0 before:bottom-0 before:w-px
                before:bg-linear-to-b before:from-transparent before:via-slate-200 before:to-transparent">

        <div class="w-full max-w-100 relative z-10">
            {{-- Heading --}}
            <div class="mb-7 fade-in-1">
                <h1 class="font-serif-display text-[1.9rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight mb-1.5">
                    Sign in to IRJIEST
                </h1>
                <p class="text-sm text-slate-500">Enter your credentials to access the portal.</p>
            </div>

            {{-- Errors --}}
            <x-validation-errors />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Role --}}
                <div class="fade-in-2">
                    <label for="role" class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">Sign in as</label>
                    <div class="relative">
                        <select id="role" name="role" required
                            class="field w-full px-3.5 py-2.75 pr-10 border border-slate-200 rounded-[9px] bg-slate-50 text-sm font-medium text-slate-700 cursor-pointer transition-all">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>— Select your role —</option>
                            <option value="author"          {{ old('role') === 'author'          ? 'selected' : '' }}>Author</option>
                            <option value="reviewer"        {{ old('role') === 'reviewer'        ? 'selected' : '' }}>Reviewer</option>
                            <option value="editor"          {{ old('role') === 'editor'          ? 'selected' : '' }}>Editor</option>
                            <option value="editor-in-chief" {{ old('role') === 'editor-in-chief' ? 'selected' : '' }}>Editor in Chief</option>
                            <option value="admin"           {{ old('role') === 'admin'           ? 'selected' : '' }}>Admin</option>
                        </select>
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Email --}}
                <div class="fade-in-2">
                    <label for="email" class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="field w-full px-3.5 py-2.75 border border-slate-200 rounded-[9px] bg-slate-50 text-sm text-slate-900 transition-all placeholder:text-slate-400"
                        placeholder="name@university.edu.ph">
                </div>

                {{-- Password --}}
                <div class="fade-in-3">
                    <label for="password" class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="field w-full px-3.5 py-2.75 pr-11 border border-slate-200 rounded-[9px] bg-slate-50 text-sm text-slate-900 transition-all placeholder:text-slate-400"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password','eye-icon')"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 transition-colors">
                            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember --}}
                <div class="fade-in-3">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500 cursor-pointer">
                        <span class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">Keep me signed in</span>
                    </label>
                </div>

                {{-- Submit --}}
                <div class="pt-1 fade-in-4">
                    <button type="submit"
                        class="w-full bg-slate-900 hover:bg-red-600 text-white py-3 rounded-[9px]
                               text-[11px] font-bold uppercase tracking-[.08em] font-body
                               transition-all duration-200 hover:-translate-y-0.5
                               shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-red-200/50">
                        Sign In to Portal
                    </button>
                </div>
            </form>

            {{-- Register --}}
            <div class="mt-7 space-y-4 fade-in-5">
                <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-[.06em] text-slate-300
                            before:flex-1 before:h-px before:bg-slate-100
                            after:flex-1 after:h-px after:bg-slate-100">
                    New to the journal?
                </div>
                <a href="{{ route('register') }}"
                   class="flex w-full items-center justify-center py-3 rounded-[9px]
                          border-[1.5px] border-slate-200 text-[11px] font-bold uppercase tracking-[.06em]
                          text-slate-500 hover:border-red-500 hover:text-red-600
                          hover:-translate-y-0.5 transition-all duration-200">
                    Create Account
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }
</script>
@endsection
