@extends('layouts.app')

@section('title', 'Register | IRJIEST Portal')

@section('content')
@php
    $categories = [
        'Business & Management', 'Computer Science', 'Education', 'Engineering',
        'Environmental Sciences', 'Health & Medical Sciences', 'Humanities',
        'Information Systems', 'Mathematics & Statistics', 'Science & Technology',
        'Social Sciences'
    ];
@endphp

<div class="min-h-screen flex flex-col md:flex-row bg-slate-50">
    {{-- Left Side: Hero Section --}}
    <div class="hidden md:flex md:w-3/5 relative items-center justify-center p-12 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/homepage-webslider-1.jpg') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-linear-to-br from-red-900/90 via-red-800/40 to-slate-900/80"></div>
        </div>

        <div class="relative z-10 text-white max-w-lg">
            <div class="mb-6 inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
                <p class="text-[10px] font-black uppercase tracking-[0.3em]">Researcher Registration</p>
            </div>

            <h2 class="text-7xl font-black leading-[1.1] mb-6 tracking-tight">
                Start your <br>
                <span class="text-red-400">Contribution</span> <br>
                today.
            </h2>

            <p class="text-lg text-slate-200 leading-relaxed font-medium mb-10 opacity-90">
                Create your account to submit manuscripts, track your review progress, or join our community of peer reviewers.
            </p>

            <ul class="space-y-5">
                <li class="flex items-center gap-4 text-white font-bold">
                    <div class="bg-red-500 rounded-full p-1 shadow-lg shadow-red-500/40">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    Streamlined Submission Process
                </li>
                <li class="flex items-center gap-4 text-white font-bold">
                    <div class="bg-red-500 rounded-full p-1 shadow-lg shadow-red-500/40">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    Real-time Peer Review Tracking
                </li>
            </ul>
        </div>
    </div>

    {{-- Right Side: Form Section --}}
    <div class="w-full md:w-2/5 flex items-start justify-center p-8 sm:p-12 bg-white relative shadow-2xl overflow-y-auto custom-scrollbar">
        <div class="max-w-md w-full py-6">
            <div class="mb-10">
                <img src="{{ asset('images/batstateu-logo.png') }}" class="h-12 mb-6">
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Create Account</h1>
                <p class="text-slate-500 font-medium">Select one or more roles to get started.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all outline-none" placeholder="Enter your full name">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Institutional Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all outline-none" placeholder="name@university.edu.ph">
                    </div>
                </div>

                {{-- Multi-Role Selection (Checkboxes instead of Radios) --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-3 ml-1">Register as (Select all that apply)</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['Author', 'Reviewer', 'Editor'] as $role)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" name="roles[]" value="{{ strtolower($role) }}"
                                   class="role-trigger peer hidden"
                                   {{ strtolower($role) == 'author' ? 'checked' : '' }}>
                            <div class="py-3 border-2 border-slate-100 rounded-xl text-center transition-all peer-checked:border-red-600 peer-checked:bg-red-50 group-hover:border-red-200">
                                <p class="text-[11px] font-black text-slate-700 uppercase tracking-tighter">{{ $role }}</p>
                                <div class="w-1.5 h-1.5 bg-red-600 rounded-full mx-auto mt-1 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Fields of Expertise (Shows if Reviewer OR Editor is checked) --}}
                <div id="expertise-container" class="hidden transition-all duration-300">
                    <div class="p-5 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                        <label class="block text-[11px] font-black text-slate-800 uppercase tracking-wider mb-4">Fields of Expertise:</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 max-h-56 overflow-y-auto pr-2 custom-scrollbar-thin">
                            @foreach($categories as $category)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="expertise[]" value="{{ $category }}" class="w-5 h-5 rounded border-slate-300 text-red-600 focus:ring-red-500 transition-all">
                                <span class="text-xs font-bold text-slate-600 group-hover:text-red-600 transition-colors">{{ $category }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:border-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2 ml-1">Confirm</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:border-red-500 outline-none">
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
    .custom-scrollbar-thin::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .custom-scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const triggers = document.querySelectorAll('.role-trigger');
        const container = document.getElementById('expertise-container');

        function toggleExpertise() {
            // Get all checked values
            const selectedRoles = Array.from(document.querySelectorAll('.role-trigger:checked'))
                                     .map(cb => cb.value);

            // Show container if 'reviewer' OR 'editor' is in the array
            if (selectedRoles.includes('reviewer') || selectedRoles.includes('editor')) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        triggers.forEach(trigger => {
            trigger.addEventListener('change', toggleExpertise);
        });

        toggleExpertise(); // Initial check
    });
</script>
@endsection
