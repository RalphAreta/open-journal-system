@extends('layouts.app')

@section('title', 'Register | IRJIEST Portal')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row bg-slate-50">
    {{-- Left Side: Hero Section --}}
    <div class="hidden md:flex md:w-3/5 relative items-center justify-center p-12 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/homepage-webslider-1.jpg') }}" class="w-full h-full object-cover" alt="BatStateU Campus">
            <div class="absolute inset-0 bg-linear-to-br from-red-900/95 via-red-800/40 to-slate-950/90"></div>
        </div>

        <div class="relative z-10 text-white max-w-lg">
            <div class="mb-6 inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
                <p class="text-[10px] font-black uppercase tracking-[0.3em]">Researcher Registration</p>
            </div>

            <h2 class="text-7xl font-black leading-[1.05] mb-6 tracking-tighter">
                Start your <br>
                <span class="text-red-400">Contribution</span> <br>
                today.
            </h2>

            <p class="text-lg text-slate-200 leading-relaxed font-medium mb-10 opacity-90">
                Create your account to submit manuscripts, track review progress, or join our community of global peer reviewers.
            </p>
        </div>
    </div>

    {{-- Right Side: Form Section --}}
    <div class="w-full md:w-2/5 flex items-start justify-center p-8 sm:p-12 bg-white relative shadow-2xl overflow-y-auto custom-scrollbar">
        <div class="max-w-md w-full py-6">
            <div class="mb-10 text-center md:text-left">
                <img src="{{ asset('images/batstateu-logo.png') }}" class="h-12 mb-6 mx-auto md:mx-0">
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Create Account</h1>
                <p class="text-slate-500 font-medium mt-1">Join the IRJIEST academic community.</p>
            </div>

            {{-- Global Error Alert --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 animate-fade-in">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="text-xs font-black text-red-800 uppercase tracking-tight">Registration Errors</h3>
                    </div>
                    <ul class="text-[10px] font-bold text-red-600/80 uppercase tracking-wide space-y-1 ml-6 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    {{-- Name --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3.5 rounded-xl border transition-all outline-none {{ $errors->has('name') ? 'border-red-500 bg-red-50/30' : 'border-slate-200 bg-slate-50/50 focus:bg-white focus:border-red-500' }}">
                        @error('name') <p class="text-red-500 text-[10px] font-black mt-1 uppercase ml-1 tracking-tight">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Institutional Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3.5 rounded-xl border transition-all outline-none {{ $errors->has('email') ? 'border-red-500 bg-red-50/30' : 'border-slate-200 bg-slate-50/50 focus:bg-white focus:border-red-500' }}">
                        @error('email') <p class="text-red-500 text-[10px] font-black mt-1 uppercase ml-1 tracking-tight">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Roles --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-3 ml-1">Register as</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['author', 'reviewer', 'editor'] as $role)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" name="roles[]" value="{{ $role }}"
                                   class="role-trigger peer hidden"
                                   {{ (is_array(old('roles')) && in_array($role, old('roles'))) || ($role == 'author' && !old('roles')) ? 'checked' : '' }}>
                            <div class="py-3 border-2 border-slate-100 rounded-xl text-center transition-all peer-checked:border-red-600 peer-checked:bg-red-50 group-hover:border-red-200">
                                <p class="text-[11px] font-black text-slate-700 uppercase tracking-tighter">{{ $role }}</p>
                                <div class="w-1.5 h-1.5 bg-red-600 rounded-full mx-auto mt-1 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Expertise --}}
                <div id="expertise-container" class="hidden transform scale-95 opacity-0 transition-all duration-300 origin-top">
                    <div class="p-5 border-2 border-dashed rounded-2xl {{ $errors->has('expertise') ? 'border-red-300 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }}">
                        <label class="block text-[11px] font-black text-slate-800 uppercase tracking-wider mb-4">Fields of Expertise:</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 max-h-56 overflow-y-auto pr-2 custom-scrollbar-thin">
                            @foreach($categories as $category)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="expertise[]" value="{{ $category }}"
                                       class="w-5 h-5 rounded border-slate-300 text-red-600 focus:ring-red-500 transition-all"
                                       {{ is_array(old('expertise')) && in_array($category, old('expertise')) ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-slate-600 group-hover:text-red-600 transition-colors">{{ $category }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @error('expertise') <p class="text-red-500 text-[10px] font-black mt-1 uppercase ml-1 tracking-tight">{{ $message }}</p> @enderror
                </div>

                {{-- Password Grid --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3.5 rounded-xl border transition-all outline-none {{ $errors->has('password') ? 'border-red-500 bg-red-50/30' : 'border-slate-200 bg-slate-50/50 focus:border-red-500' }}">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Confirm</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:border-red-500 outline-none">
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white py-4 rounded-xl font-black uppercase tracking-[0.2em] text-sm hover:bg-red-700 transition-all shadow-xl shadow-red-200 hover:-translate-y-1">
                    Complete Registration
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .expertise-visible { display: block !important; transform: scale(1) !important; opacity: 1 !important; }
    .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const triggers = document.querySelectorAll('.role-trigger');
        const container = document.getElementById('expertise-container');

        function toggleExpertise() {
            const selectedRoles = Array.from(document.querySelectorAll('.role-trigger:checked')).map(cb => cb.value);
            if (selectedRoles.includes('reviewer') || selectedRoles.includes('editor')) {
                container.classList.add('expertise-visible');
            } else {
                container.classList.remove('expertise-visible');
            }
        }

        triggers.forEach(trigger => trigger.addEventListener('change', toggleExpertise));
        toggleExpertise();
    });
</script>
@endsection
