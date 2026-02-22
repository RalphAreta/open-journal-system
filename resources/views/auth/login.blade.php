@extends('layouts.app')

@section('title', 'Login | IRJIEST Portal')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row bg-slate-50">
    {{-- Left Side: Branding & Visuals --}}
    <div class="hidden md:flex md:w-3/5 relative items-center justify-center p-12 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/homepage-webslider-1.jpg') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-linear-to-br from-red-900/90 via-red-800/40 to-slate-900/80"></div>
        </div>

        <div class="relative z-10 text-white max-w-lg">
            <div class="mb-8 inline-block px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
                <p class="text-xs font-black uppercase tracking-[0.3em]">Official Research Portal</p>
            </div>
            <h2 class="text-6xl font-black leading-tight mb-6 tracking-tighter">
                Advancing <br>
                <span class="text-red-500">Innovation</span> <br>
                through Research.
            </h2>
            <p class="text-xl text-slate-200 leading-relaxed font-medium opacity-90">
                BatStateU International Research Journal of Information Systems & Engineering Technology.
            </p>
        </div>
        <div class="absolute bottom-[-10%] right-[-5%] w-80 h-80 bg-red-500/20 rounded-full blur-3xl"></div>
    </div>

    {{-- Right Side: Login Form --}}
    <div class="w-full md:w-2/5 flex items-center justify-center p-8 sm:p-12 bg-white relative shadow-2xl">
        <div class="max-w-md w-full">
            <div class="mb-12">
                <a href="/">
                    <img src="{{ asset('images/batstateu-logo.png') }}" class="h-16 mb-8 hover:scale-105 transition-transform duration-300">
                </a>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter mb-3">Sign in to IRJIEST</h1>
                <p class="text-slate-500 font-medium text-lg">Enter your credentials to access the portal.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Role Selector --}}
                <div>
                    <label for="role" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Sign in as</label>
                    <div class="relative group">
                        <select id="role" name="role" required
                            class="w-full px-4 py-4 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-700 font-semibold focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all appearance-none cursor-pointer">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>— Select your role —</option>
                            <option value="author" {{ old('role') === 'author' ? 'selected' : '' }}>Author</option>
                            <option value="reviewer" {{ old('role') === 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                            <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                            <option value="editor-in-chief" {{ old('role') === 'editor-in-chief' ? 'selected' : '' }}>Editor in Chief</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400 group-hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-4 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all outline-none"
                        placeholder="name@university.edu.ph">
                </div>

                <div>
                    <label for="password" class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-4 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all outline-none pr-12"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password', 'eye-icon')" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-red-600 transition-colors">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-300 text-red-600 focus:ring-red-500 transition-all">
                        <span class="ml-3 text-sm font-bold text-slate-600 group-hover:text-slate-900 transition-colors">Keep me signed in</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-slate-900 text-white py-4 rounded-xl font-black uppercase tracking-widest text-sm hover:bg-red-700 transition-all duration-300 shadow-xl shadow-slate-200 hover:shadow-red-200 hover:-translate-y-1">
                    Sign In to Portal
                </button>
            </form>

            <div class="mt-12 pt-8 border-t border-slate-100 text-center">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">New to the journal?</p>
                <a href="{{ route('register') }}" class="inline-block w-full py-4 rounded-xl border-2 border-slate-100 text-slate-900 font-black uppercase tracking-widest text-sm hover:border-red-600 hover:text-red-600 transition-all duration-300">
                    Create Account
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
        } else {
            passwordInput.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>
@endsection
