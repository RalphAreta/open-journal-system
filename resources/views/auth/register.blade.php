@extends('layouts.app')
@section('title', 'Register | JOURNAL SYSTEM')

@push('styles')
<<<<<<< HEAD
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    @keyframes lpShimmer { 0%{background-position:-100% 0} 100%{background-position:100% 0} }
    @keyframes lpDrift { 0%,100%{transform:translate(0,0)} 40%{transform:translate(14px,-10px)} 70%{transform:translate(-8px,14px)} }
    @keyframes lpUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
    @keyframes lpBlink { 0%,100%{opacity:1} 50%{opacity:.3} }
    
    .animate-lp-up { opacity:0; animation: lpUp .65s ease forwards; }
    .animate-lp-shimmer { background: linear-gradient(90deg,transparent,#c9a84c,#f0d678,#c9a84c,transparent); background-size: 200% 100%; animation: lpShimmer 3s linear infinite; }
    .readable-text { text-shadow: 0 2px 4px rgba(0,0,0,0.3); }

    /* Expertise container transition */
    #expertise-container { display:none; }
    .expertise-visible { display:block !important; animation: lpUp .3s ease forwards; }
    .scroll-thin::-webkit-scrollbar { width: 4px; }
    .scroll-thin::-webkit-scrollbar-thumb { background: #c9a84c; border-radius: 4px; }
</style>
@endpush

@section('content')
<div class="flex flex-col md:flex-row min-h-[calc(100vh-64px)] overflow-hidden font-['Source_Sans_3']">

    {{-- LEFT SIDE: THE TEAL SIDE (Matched to Login) --}}
    <div class="relative flex-none md:w-2/5 flex flex-col justify-center px-8 py-12 md:p-16 overflow-hidden bg-[#2D8176] z-10">
        <div class="absolute inset-0 z-0 bg-black/15"></div>
        <div class="absolute inset-0 z-0" 
             style="background-image: radial-gradient(ellipse 80% 60% at 75% 20%, rgba(201,168,76,.18) 0%, transparent 60%), 
                                     radial-gradient(ellipse 60% 70% at 5% 85%, rgba(0,0,0,.25) 0%, transparent 50%);">
        </div>
        <div class="absolute inset-0 z-0 opacity-[0.05]" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute top-0 left-0 right-0 h-[2px] z-20 animate-lp-shimmer"></div>

        <div class="relative z-20">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full border border-white/30 bg-black/20 text-[10px] tracking-widest uppercase text-[#f0d678] font-semibold mb-7 animate-lp-up [animation-delay:80ms]">
                <span class="w-1.5 h-1.5 rounded-full bg-[#c9a84c] shadow-[0_0_8px_rgba(201,168,76,0.8)]" style="animation: lpBlink 2s ease-in-out infinite;"></span>
                Researcher Registration
            </div>
            <h2 class="readable-text font-['Libre_Baskerville'] text-4xl lg:text-5xl font-bold leading-[1.15] text-white mb-6 animate-lp-up [animation-delay:200ms]">
                Start your<br>
                <em class="not-italic font-normal block bg-gradient-to-r from-[#c9a84c] via-[#f0d678] to-[#c9a84c] bg-clip-text text-transparent drop-shadow-sm italic">Contribution</em>
                today.
            </h2>
            <p class="readable-text text-[14px] leading-relaxed font-medium text-white/90 mb-8 animate-lp-up [animation-delay:340ms] border-l-2 border-[#c9a84c]/50 pl-4">
                Create your account to submit manuscripts, track review progress, or join our community of global peer reviewers.
            </p>
        </div>
        
        <div class="absolute -bottom-20 -left-20 opacity-10 pointer-events-none">
            <svg class="w-[300px] h-[300px]" viewBox="0 0 400 400" fill="none" stroke="#ffffff">
                <circle cx="200" cy="200" r="190" stroke-width="1"/><circle cx="200" cy="200" r="140" stroke-width="1"/>
            </svg>
        </div>
    </div>

    {{-- RIGHT SIDE: REGISTRATION FORM (Matched to Login Right Side) --}}
    <div class="flex-1 flex items-center justify-center p-6 md:p-10 relative overflow-y-auto bg-gradient-to-br from-[#f5f0e8] via-[#ede5d5] to-[#e4daf0] z-0">
        <div class="absolute rounded-full w-[500px] h-[500px] -top-40 -right-28 border border-[#a07830]/10"></div>
        <div class="absolute inset-0 opacity-[0.035]" style="background-image: repeating-linear-gradient(-50deg, #8a6520 0px, #8a6520 1px, transparent 1px, transparent 20px);"></div>

        <div class="relative z-10 w-full max-w-[550px] bg-white/90 border border-[#c9a84c]/20 rounded-[20px] p-8 md:p-10 backdrop-blur-xl shadow-2xl animate-lp-up">
            <div class="mb-6">
                <p class="text-[10px] tracking-widest uppercase text-[#a07830] font-medium mb-1 flex items-center gap-2">
                    <span class="w-[18px] h-px bg-[#c9a84c]/60"></span> JOURNAL SYSTEM
                </p>
                <h1 class="font-['Libre_Baskerville'] text-2xl font-bold text-[#0d1628]">Create Account</h1>
                <p class="text-[13px] text-[#8a96a8] font-light">Join the Journal System academic community.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Full Name --}}
                    <div>
                        <label class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] transition-all">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5">Institutional Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] transition-all"
                               placeholder="name@university.edu.ph">
                    </div>
                </div>

                {{-- Register as --}}
                <div>
                    <label class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-2">Register as</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['author', 'reviewer', 'editor'] as $role)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" name="roles[]" value="{{ $role }}"
                                class="role-trigger peer hidden"
                                {{ (is_array(old('roles')) && in_array($role, old('roles'))) || ($role === 'author' && !old('roles')) ? 'checked' : '' }}>
                            <div class="py-2.5 border-[1.5px] border-[#dde4ee] rounded-xl text-center transition-all
                                        peer-checked:border-[#c9a84c] peer-checked:bg-[#c9a84c]/5 group-hover:border-[#c9a84c]/40">
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-600 peer-checked:text-[#a07830]">{{ ucfirst($role) }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Expertise (Conditional) --}}
                <div id="expertise-container" class="transition-all">
                    <div class="p-4 border-[1.5px] border-dashed border-[#c9a84c]/30 rounded-xl bg-[#fafbfd]">
                        <label class="block text-[10px] font-bold uppercase text-[#a07830] mb-3">Fields of Expertise</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 max-h-40 overflow-y-auto pr-2 scroll-thin">
                            @foreach($categories as $category)
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" name="expertise[]" value="{{ $category }}"
                                       class="w-4 h-4 rounded border-[#dde4ee] text-[#a07830] focus:ring-[#c9a84c]">
                                <span class="text-xs text-slate-600 group-hover:text-[#a07830] transition-colors leading-tight">{{ $category }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Password Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5">Password</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] transition-all">
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full py-3 mt-2 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-[#a07830]/20 hover:-translate-y-0.5 transition-all">
                    Complete Registration
                </button>
            </form>

            {{-- Login link --}}
            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                <p class="text-[13px] text-[#8a96a8]">
                    Already have an account? &nbsp;
                    <a href="{{ route('login') }}" class="text-[#a07830] font-semibold hover:text-[#c9a84c] transition-colors underline underline-offset-4 decoration-dashed decoration-[#c9a84c]/40">
                        Sign In Instead
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggers = document.querySelectorAll('.role-trigger');
        const container = document.getElementById('expertise-container');

        function toggleExpertise() {
            const selected = Array.from(document.querySelectorAll('.role-trigger:checked')).map(cb => cb.value);
            if (selected.includes('reviewer') || selected.includes('editor')) {
                container.classList.add('expertise-visible');
            } else {
                container.classList.remove('expertise-visible');
            }
        }

        triggers.forEach(t => t.addEventListener('change', toggleExpertise));
        toggleExpertise();
    });
</script>
@endsection
=======
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap"
        rel="stylesheet"
    />
    <style>
        .font-serif-display {
            font-family: 'Instrument Serif', serif;
        }
        .font-body {
            font-family: 'DM Sans', sans-serif;
        }
        select {
            appearance: none;
            -webkit-appearance: none;
        }
        .field:focus {
            outline: none;
            border-color: #dc2626 !important;
            background: #fff !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.07);
        }
        .pulse-dot {
            animation: pulseDot 2s infinite;
        }
        @keyframes pulseDot {
            0%,
            100% {
                opacity: 1;
            }
            50% {
                opacity: 0.35;
            }
        }
        .fade-in {
            animation: fadeIn 0.5s ease both;
        }
        .fade-in-1 {
            animation: fadeIn 0.5s 0.08s ease both;
        }
        .fade-in-2 {
            animation: fadeIn 0.5s 0.16s ease both;
        }
        .fade-in-3 {
            animation: fadeIn 0.5s 0.24s ease both;
        }
        .fade-in-4 {
            animation: fadeIn 0.5s 0.32s ease both;
        }
        .fade-in-5 {
            animation: fadeIn 0.5s 0.4s ease both;
        }
        .slide-in {
            animation: slideIn 0.7s ease both;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Expertise container transition */
        #expertise-container {
            display: none;
        }
        .expertise-visible {
            display: block !important;
            animation: fadeIn 0.3s ease both;
        }

        /* Thin scrollbar for expertise list */
        .scroll-thin::-webkit-scrollbar {
            width: 4px;
        }
        .scroll-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .scroll-thin::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen flex flex-col md:flex-row font-body bg-slate-50">
        {{-- ── LEFT: Branding ── --}}
        <div
            class="hidden md:flex md:w-3/5 relative items-center justify-center overflow-hidden"
        >
            {{-- BG --}}
            <div class="absolute inset-0">
                <img
                    src="{{ asset('images/homepage-webslider-1.jpg') }}"
                    class="w-full h-full object-cover scale-105 hover:scale-100 transition-transform duration-12000"
                    alt=""
                />
                <div
                    class="absolute inset-0"
                    style="
                        background: linear-gradient(
                            145deg,
                            rgba(127, 7, 7, 0.92) 0%,
                            rgba(30, 10, 10, 0.75) 50%,
                            rgba(15, 23, 42, 0.88) 100%
                        );
                    "
                ></div>
            </div>

            {{-- Top shimmer --}}
            <div
                class="absolute top-0 left-0 right-0 h-px"
                style="
                    background: linear-gradient(
                        90deg,
                        transparent,
                        rgba(255, 255, 255, 0.15),
                        transparent
                    );
                "
            ></div>

            {{-- Decorative rings --}}
            <div
                class="absolute bottom-right right-20 w-80 h-80 rounded-full border border-white/8 pointer-events-none"
            >
                <div
                    class="absolute inset-10 rounded-full border border-white/5"
                ></div>
                <div
                    class="absolute inset-20 rounded-full border border-white/4"
                ></div>
            </div>

            {{-- Content --}}
            <div class="relative z-10 max-w-105 px-12 py-16 slide-in">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-9"
                >
                    <span
                        class="pulse-dot w-1.5 h-1.5 rounded-full bg-red-400"
                    ></span>
                    <span
                        class="text-[10px] font-bold uppercase tracking-[.12em] text-white/90"
                    >
                        Researcher Registration
                    </span>
                </div>

                <h2
                    class="font-serif-display text-[3.4rem] leading-[1.1] font-normal text-white tracking-[-0.02em] mb-5"
                >
                    Start your
                    <br />
                    <span class="italic text-red-300">Contribution</span>
                    <br />
                    today.
                </h2>

                <p
                    class="text-sm text-white/60 leading-relaxed border-l-2 border-white/20 pl-4 mt-6"
                >
                    Create your account to submit manuscripts, track review
                    progress, or join our community of global peer reviewers.
                </p>
            </div>
        </div>

        {{-- ── RIGHT: Form ── --}}
        <div
            class="w-full md:w-2/5 flex items-start justify-center bg-white px-8 sm:px-12 py-12 relative overflow-y-auto before:absolute before:top-0 before:left-0 before:bottom-0 before:w-px before:bg-linears-to-b before:from-transparent before:via-slate-200 before:to-transparent"
        >
            <div class="w-full max-w-100 py-2">
                {{-- Heading --}}
                <div class="mb-7 fade-in-1">
                    <h1
                        class="font-serif-display text-[1.9rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight mb-1.5"
                    >
                        Create Account
                    </h1>
                    <p class="text-sm text-slate-500">
                        Join the IRJIEST academic community.
                    </p>
                </div>

                {{-- Errors --}}
                <x-validation-errors title="Registration Errors" />

                <form
                    method="POST"
                    action="{{ route('register') }}"
                    class="space-y-5"
                >
                    @csrf

                    {{-- Full Name --}}
                    <div class="fade-in-2">
                        <label
                            class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5"
                        >
                            Full Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="field w-full px-3.5 py-2.75 border rounded-[9px] bg-slate-50 text-sm text-slate-900 transition-all placeholder:text-slate-400 {{ $errors->has('name') ? 'border-red-300 bg-red-50/30' : 'border-slate-200' }}"
                        />
                        @error('name')
                            <p
                                class="text-red-500 text-xs font-medium mt-1 ml-0.5"
                            >
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="fade-in-2">
                        <label
                            class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5"
                        >
                            Institutional Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="field w-full px-3.5 py-2.75 border rounded-[9px] bg-slate-50 text-sm text-slate-900 transition-all placeholder:text-slate-400 {{ $errors->has('email') ? 'border-red-300 bg-red-50/30' : 'border-slate-200' }}"
                            placeholder="name@university.edu.ph"
                        />
                        @error('email')
                            <p
                                class="text-red-500 text-xs font-medium mt-1 ml-0.5"
                            >
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Register as --}}
                    <div class="fade-in-3">
                        <label
                            class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-2"
                        >
                            Register as
                        </label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach (['author', 'reviewer', 'editor'] as $role)
                                <label class="relative cursor-pointer group">
                                    <input
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $role }}"
                                        class="role-trigger peer hidden"
                                        {{ (is_array(old('roles')) && in_array($role, old('roles'))) || ($role === 'author' && ! old('roles')) ? 'checked' : '' }}
                                    />
                                    <div
                                        class="py-3 border-[1.5px] border-slate-200 rounded-[9px] text-center transition-all peer-checked:border-red-500 peer-checked:bg-red-50 group-hover:border-red-200"
                                    >
                                        <p
                                            class="text-[11px] font-bold uppercase tracking-wide text-slate-600 peer-checked:text-red-600"
                                        >
                                            {{ ucfirst($role) }}
                                        </p>
                                        <div
                                            class="w-1.5 h-1.5 rounded-full mx-auto mt-1.5 bg-red-500 opacity-0 peer-checked:opacity-100 transition-opacity"
                                        ></div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Expertise --}}
                    <div id="expertise-container" class="fade-in-3">
                        <div
                            class="p-4 border-[1.5px] border-dashed rounded-[9px] {{ $errors->has('expertise') ? 'border-red-300 bg-red-50/20' : 'border-slate-200 bg-slate-50/50' }}"
                        >
                            <label
                                class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-3"
                            >
                                Fields of Expertise
                            </label>
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2.5 max-h-52 overflow-y-auto pr-1 scroll-thin"
                            >
                                @foreach ($categories as $category)
                                    <label
                                        class="flex items-center gap-2.5 cursor-pointer group"
                                    >
                                        <input
                                            type="checkbox"
                                            name="expertise[]"
                                            value="{{ $category }}"
                                            class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500 cursor-pointer"
                                            {{ is_array(old('expertise')) && in_array($category, old('expertise')) ? 'checked' : '' }}
                                        />
                                        <span
                                            class="text-xs font-medium text-slate-600 group-hover:text-red-600 transition-colors leading-tight"
                                        >
                                            {{ $category }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('expertise')
                            <p
                                class="text-red-500 text-xs font-medium mt-1 ml-0.5"
                            >
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 fade-in-4"
                    >
                        <div>
                            <label
                                class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5"
                            >
                                Password
                            </label>
                            <div class="relative">
                                <input
                                    id="reg-password"
                                    type="password"
                                    name="password"
                                    required
                                    class="field w-full px-3.5 py-2.75 pr-10 border rounded-[9px] bg-slate-50 text-sm text-slate-900 transition-all {{ $errors->has('password') ? 'border-red-300 bg-red-50/30' : 'border-slate-200' }}"
                                    placeholder="••••••••"
                                />
                                <button
                                    type="button"
                                    onclick="
                                        togglePassword(
                                            'reg-password',
                                            'eye-reg',
                                        )
                                    "
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 transition-colors"
                                >
                                    <svg
                                        id="eye-reg"
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p
                                    class="text-red-500 text-xs font-medium mt-1"
                                >
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5"
                            >
                                Confirm
                            </label>
                            <div class="relative">
                                <input
                                    id="reg-confirm"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="field w-full px-3.5 py-2.75 pr-10 border border-slate-200 rounded-[9px] bg-slate-50 text-sm text-slate-900 transition-all"
                                    placeholder="••••••••"
                                />
                                <button
                                    type="button"
                                    onclick="
                                        togglePassword(
                                            'reg-confirm',
                                            'eye-conf',
                                        )
                                    "
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 transition-colors"
                                >
                                    <svg
                                        id="eye-conf"
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-1 fade-in-5">
                        <button
                            type="submit"
                            class="w-full bg-slate-900 hover:bg-red-600 text-white py-3 rounded-[9px] text-[11px] font-bold uppercase tracking-[.08em] font-body transition-all duration-200 hover:-translate-y-0.5 shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-red-200/50"
                        >
                            Complete Registration
                        </button>
                    </div>
                </form>

                {{-- Login link --}}
                <div class="mt-7 space-y-4 fade-in-5">
                    <div
                        class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-[.06em] text-slate-300 before:flex-1 before:h-px before:bg-slate-100 after:flex-1 after:h-px after:bg-slate-100"
                    >
                        Already have an account?
                    </div>
                    <a
                        href="{{ route('login') }}"
                        class="flex w-full items-center justify-center py-3 rounded-[9px] border-[1.5px] border-slate-200 text-[11px] font-bold uppercase tracking-[.06em] text-slate-500 hover:border-red-500 hover:text-red-600 hover:-translate-y-0.5 transition-all duration-200"
                    >
                        Sign In Instead
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>';
            } else {
                input.type = 'password';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const triggers = document.querySelectorAll('.role-trigger');
            const container = document.getElementById('expertise-container');

            function toggleExpertise() {
                const selected = Array.from(
                    document.querySelectorAll('.role-trigger:checked'),
                ).map((cb) => cb.value);
                if (
                    selected.includes('reviewer') ||
                    selected.includes('editor')
                ) {
                    container.classList.add('expertise-visible');
                } else {
                    container.classList.remove('expertise-visible');
                }
            }

            triggers.forEach((t) =>
                t.addEventListener('change', toggleExpertise),
            );
            toggleExpertise();
        });
    </script>
@endsection
>>>>>>> 66275644bfe910057a5eabdb829b677db35dd029
