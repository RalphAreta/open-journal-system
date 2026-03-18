@extends('layouts.app')
@section('title', 'Register | JOURNAL SYSTEM')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet"
    />
    <style>
        /* ── Keyframes ── */
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position:  200% 0; }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0);    }
        }
        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201,168,76,.6); }
            50%       { box-shadow: 0 0 0 5px rgba(201,168,76,0); }
        }
        @keyframes float-orb {
            0%, 100% { transform: translate(0,0)       scale(1);    }
            33%       { transform: translate(18px,-12px) scale(1.05); }
            66%       { transform: translate(-10px,16px) scale(.97); }
        }
        @keyframes line-grow {
            from { transform: scaleX(0); }
            to   { transform: scaleX(1); }
        }
        @keyframes card-in {
            from { opacity: 0; transform: translateY(28px) scale(.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1);   }
        }
        @keyframes expertise-open {
            from { opacity: 0; transform: translateY(-8px); max-height: 0; }
            to   { opacity: 1; transform: translateY(0);    max-height: 400px; }
        }

        /* ── Base ── */
        .font-playfair { font-family: 'Playfair Display', Georgia, serif; }
        .font-dm       { font-family: 'DM Sans', system-ui, sans-serif; }

        .lp-fade-up {
            opacity: 0;
            animation: fadeUp .7s cubic-bezier(.22,.68,0,1.2) forwards;
        }

        /* ── Shimmer bar ── */
        .shimmer-bar {
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(201,168,76,.15) 30%,
                rgba(240,214,120,.7) 50%,
                rgba(201,168,76,.15) 70%,
                transparent 100%);
            background-size: 200% 100%;
            animation: shimmer 3.5s linear infinite;
        }

        /* ── Orbs ── */
        .orb   { animation: float-orb 8s ease-in-out infinite; }
        .orb-2 { animation: float-orb 11s ease-in-out infinite reverse; animation-delay:-4s; }

        /* ── Card ── */
        .register-card {
            animation: card-in .75s cubic-bezier(.22,.68,0,1.2) .15s both;
        }

        /* ── Top accent ── */
        .top-accent {
            position: absolute; top: 0; left: 0; right: 0; height: 2px; z-index: 20;
            transform-origin: left;
            animation: line-grow .8s cubic-bezier(.22,.68,0,1.2) .1s both;
        }

        /* ── Inputs ── */
        .lp-input {
            width: 100%;
            padding: .65rem 1rem .65rem 2.75rem;
            background: #f8f9fc;
            border: 1.5px solid #e2e8f2;
            border-radius: 12px;
            font-size: .875rem;
            font-family: 'DM Sans', system-ui, sans-serif;
            color: #1a202c;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .lp-input.no-icon { padding-left: 1rem; }
        .lp-input::placeholder { color: #b0bac8; }
        .lp-input:focus {
            border-color: #c9a84c;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(201,168,76,.12);
        }

        /* ── Field icon ── */
        .field-icon {
            position: absolute; left: .875rem; top: 50%; transform: translateY(-50%);
            width: 1rem; height: 1rem; color: #b0bac8; pointer-events: none;
            transition: color .2s;
        }
        .lp-input:focus ~ .field-icon { color: #c9a84c; }

        /* ── Role cards ── */
        .role-card input[type="checkbox"] { display: none; }
        .role-card-inner {
            display: flex; flex-direction: column; align-items: center;
            gap: .4rem; padding: .875rem .5rem;
            border: 1.5px solid #e2e8f2; border-radius: 12px;
            background: #f8f9fc; cursor: pointer;
            transition: border-color .2s, background .2s, box-shadow .2s, transform .15s;
            text-align: center;
        }
        .role-card-inner:hover {
            border-color: rgba(201,168,76,.5);
            transform: translateY(-1px);
        }
        .role-card input:checked + .role-card-inner {
            border-color: #c9a84c;
            background: rgba(201,168,76,.06);
            box-shadow: 0 0 0 3px rgba(201,168,76,.12);
        }
        .role-card input:checked + .role-card-inner .role-icon-wrap {
            background: rgba(201,168,76,.15);
            color: #a07830;
        }
        .role-card input:checked + .role-card-inner .role-label {
            color: #a07830;
        }
        .role-icon-wrap {
            width: 2rem; height: 2rem; border-radius: 8px;
            background: rgba(180,190,210,.12);
            display: flex; align-items: center; justify-content: center;
            color: #8a96a8; transition: background .2s, color .2s;
        }
        .role-label {
            font-size: .65rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: #6a7890; transition: color .2s;
        }
        .role-desc {
            font-size: .6rem; color: #a0aab8; line-height: 1.3;
        }

        /* ── Expertise panel ── */
        #expertise-container {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height .4s cubic-bezier(.22,.68,0,1.2),
                        opacity .3s ease,
                        margin .3s ease;
            margin-top: 0;
        }
        #expertise-container.expertise-visible {
            max-height: 400px;
            opacity: 1;
            margin-top: 0;
        }
        .scroll-thin::-webkit-scrollbar       { width: 4px; }
        .scroll-thin::-webkit-scrollbar-thumb { background: #c9a84c; border-radius: 4px; }

        /* Expertise checkbox ── */
        .exp-check {
            display: flex; align-items: flex-start; gap: .6rem;
            cursor: pointer; padding: .35rem .5rem; border-radius: 8px;
            transition: background .15s;
        }
        .exp-check:hover { background: rgba(201,168,76,.06); }
        .exp-check input[type="checkbox"] {
            margin-top: .1rem; flex-shrink: 0;
            width: .9rem; height: .9rem;
            accent-color: #a07830; cursor: pointer;
        }
        .exp-check span {
            font-size: .75rem; color: #4a5568; line-height: 1.4;
            transition: color .15s;
        }
        .exp-check:hover span { color: #a07830; }

        /* ── Password eye toggle ── */
        .eye-btn {
            position: absolute; right: .75rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; padding: .25rem;
            color: #b0bac8; transition: color .2s;
            display: flex; align-items: center;
        }
        .eye-btn:hover { color: #a07830; }

        /* ── Submit button ── */
        .lp-btn {
            width: 100%; padding: .8rem 1rem;
            background: linear-gradient(135deg, #c9a84c 0%, #a07830 100%);
            color: #fff; font-size: .875rem; font-weight: 600;
            letter-spacing: .04em; border: none; border-radius: 12px;
            cursor: pointer; position: relative; overflow: hidden;
            box-shadow: 0 4px 18px rgba(160,120,48,.4), 0 1px 3px rgba(160,120,48,.25);
            transition: transform .2s cubic-bezier(.22,.68,0,1.2), box-shadow .2s;
        }
        .lp-btn::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,.15) 0%, transparent 60%);
            pointer-events: none;
        }
        .lp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(160,120,48,.5), 0 2px 6px rgba(160,120,48,.3);
        }
        .lp-btn:active { transform: translateY(0); }

        /* ── Error alert ── */
        .lp-error {
            background: #fff8f8; border: 1.5px solid #fecaca;
            border-left: 4px solid #dc2626; border-radius: 10px;
            padding: .75rem 1rem; font-size: .8rem; color: #991b1b;
        }

        /* ── Stat pill ── */
        .stat-pill {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .3rem .875rem;
            border: 1px solid rgba(255,255,255,.22);
            background: rgba(0,0,0,.2); border-radius: 999px;
            font-size: .65rem; letter-spacing: .12em; text-transform: uppercase;
            color: #f0d678; font-weight: 600;
        }
        .pulse-dot {
            width: .5rem; height: .5rem; border-radius: 50%;
            background: #c9a84c;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        /* ── Section divider ── */
        .form-section-label {
            display: flex; align-items: center; gap: .6rem;
            font-size: .6rem; font-weight: 700; letter-spacing: .15em;
            text-transform: uppercase; color: #a07830; margin-bottom: .75rem;
        }
        .form-section-label::after {
            content: ''; flex: 1; height: 1px; background: rgba(201,168,76,.2);
        }

        /* ── Password strength bar ── */
        .strength-bar-wrap {
            height: 3px; border-radius: 3px; background: #e8e2f0;
            margin-top: .4rem; overflow: hidden;
        }
        .strength-bar {
            height: 100%; border-radius: 3px;
            width: 0%; transition: width .3s, background .3s;
        }
        .strength-label {
            font-size: .6rem; color: #a0aab8; margin-top: .25rem;
        }

        /* ── Quote glyph ── */
        .quote-glyph {
            font-family: 'Playfair Display', serif;
            font-size: 5rem; line-height: .8;
            color: rgba(201,168,76,.25); user-select: none;
        }

        /* ── Text shadow ── */
        .text-shadow { text-shadow: 0 2px 6px rgba(0,0,0,.25); }

        .hidden { display: none !important; }
    </style>
@endpush

@section('content')
<div class="font-dm flex flex-col md:flex-row min-h-[calc(100vh-64px)] overflow-x-hidden">

    {{-- ═══════════════════ LEFT: Brand Panel ═══════════════════ --}}
    <div class="relative flex-none md:w-[42%] flex flex-col justify-center
                px-8 py-14 md:p-14 lg:p-20 overflow-hidden"
         style="background-image:url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1400&q=85&auto=format&fit=crop&crop=center');
                background-size:cover; background-position:center 30%;">

        {{-- Layer 1: teal brand wash --}}
        <div class="absolute inset-0 z-1"
             style="background:linear-gradient(160deg,rgba(18,72,65,.91) 0%,rgba(36,105,96,.86) 40%,rgba(28,84,76,.93) 100%);
                    mix-blend-mode:multiply;"></div>

        {{-- Layer 2: vignette + gold light spill --}}
        <div class="absolute inset-0 z-2 pointer-events-none"
             style="background:
                 radial-gradient(ellipse 70% 55% at 80% 15%, rgba(201,168,76,.18) 0%, transparent 55%),
                 radial-gradient(ellipse 65% 65% at 0%  90%, rgba(0,0,0,.45)       0%, transparent 50%),
                 radial-gradient(ellipse 100% 30% at 50% 100%,rgba(0,0,0,.35)      0%, transparent 60%),
                 radial-gradient(ellipse 80%  20% at 50%   0%, rgba(0,0,0,.2)       0%, transparent 50%)"></div>

        {{-- Dot-grid texture --}}
        <div class="absolute inset-0 z-3 opacity-[.04] pointer-events-none"
             style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);
                    background-size:26px 26px;"></div>

        {{-- Floating orbs --}}
        <div class="orb absolute -top-24 -right-16 w-80 h-80 rounded-full
                    opacity-25 blur-3xl pointer-events-none z-4"
             style="background:radial-gradient(circle at 40% 40%,#c9a84c,transparent 70%)"></div>
        <div class="orb-2 absolute -bottom-32 -left-20 w-96 h-96 rounded-full
                    opacity-20 blur-3xl pointer-events-none z-4"
             style="background:radial-gradient(circle at 60% 60%,#1a3a5c,transparent 70%)"></div>

        {{-- Top shimmer accent --}}
        <div class="top-accent shimmer-bar" style="z-index:20;"></div>

        {{-- Content --}}
        <div class="relative z-10 max-w-sm">

            {{-- Pill badge --}}
            <div class="lp-fade-up mb-8" style="animation-delay:.08s">
                <div class="stat-pill">
                    <span class="pulse-dot"></span>
                    <span>Researcher Registration</span>
                </div>
            </div>

            {{-- Headline --}}
            <h1 class="font-playfair text-shadow text-white
                        text-4xl lg:text-[2.75rem] font-bold leading-[1.2]
                        lp-fade-up mb-5"
                style="animation-delay:.2s">
                Start your
                <em class="not-italic font-normal block mt-1"
                    style="background:linear-gradient(90deg,#c9a84c,#f0d678,#c9a84c);
                           -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                           background-clip:text">
                    Contribution
                </em>
                today.
            </h1>

            {{-- Description --}}
            <p class="text-shadow text-[.875rem] leading-relaxed text-white/80
                       lp-fade-up border-l-2 border-[#c9a84c]/50 pl-4 mb-8"
               style="animation-delay:.34s">
                Create your account to submit manuscripts, track review
                progress, or join our community of global peer reviewers.
            </p>

            {{-- Gold rule --}}
            <div class="lp-fade-up mb-6" style="animation-delay:.46s">
                <div class="w-10 h-0.5 rounded-full bg-[#c9a84c]"></div>
            </div>

            {{-- Steps list --}}
            <div class="lp-fade-up space-y-3" style="animation-delay:.58s">
                @foreach([
                    ['01', 'Fill in your details',    'Name, email, and your role'],
                    ['02', 'Set your expertise',      'So we match you with relevant work'],
                    ['03', 'Access the portal',       'Submit, review, and track in one place'],
                ] as [$n, $title, $sub])
                <div class="flex items-start gap-3">
                    <span class="font-playfair text-[#c9a84c]/50 text-xs font-bold mt-0.5 w-5 shrink-0">{{ $n }}</span>
                    <div>
                        <div class="text-white text-[.8rem] font-semibold">{{ $title }}</div>
                        <div class="text-white/55 text-[.7rem]">{{ $sub }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Bottom stats --}}
            <div class="lp-fade-up flex gap-5 mt-10 pt-8 border-t border-white/10"
                 style="animation-delay:.7s">
                @foreach([['100%','Peer Reviewed'],['Free','Open Access'],['Indexed','Impact Factor']] as [$v,$l])
                <div>
                    <div class="text-[#f0d678] font-semibold text-sm">{{ $v }}</div>
                    <div class="text-white/50 text-[.6rem] tracking-widest uppercase mt-0.5">{{ $l }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══════════════════ RIGHT: Registration Form ═══════════════════ --}}
    <div class="flex-1 flex items-start md:items-center justify-center
                p-6 md:p-10 lg:p-14 relative overflow-x-hidden overflow-y-auto"
         style="background:linear-gradient(145deg,#f7f3ec 0%,#ede8df 50%,#e8e2f5 100%)">

        {{-- Diagonal stripe --}}
        <div class="absolute inset-0 opacity-[.03] pointer-events-none"
             style="background-image:repeating-linear-gradient(-50deg,
                        #8a6520 0px,#8a6520 1px,transparent 1px,transparent 22px)"></div>

        {{-- ── Register Card ── --}}
        <div class="register-card relative z-10 w-full max-w-2xl
                    bg-white/85 backdrop-blur-2xl
                    border border-[#c9a84c]/18
                    rounded-2xl shadow-2xl shadow-[#a07830]/12
                    overflow-hidden my-6">

            {{-- Card top shimmer stripe --}}
            <div class="h-0.75 w-full shimmer-bar"></div>

            <div class="p-8 md:p-10">

                {{-- Brand label --}}
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-5 h-[1.5px] bg-[#c9a84c]/60"></div>
                    <span class="text-[.6rem] tracking-[.2em] uppercase text-[#a07830] font-semibold">
                        Journal System
                    </span>
                </div>

                <h2 class="font-playfair text-[1.6rem] font-bold text-[#0d1628] leading-tight mb-1">
                    Create your account
                </h2>
                <p class="text-[.8rem] text-[#8a96a8] font-light mb-7">
                    Join our academic community — it only takes a minute.
                </p>

                {{-- Error alert --}}
                @if ($errors->any())
                <div class="lp-error mb-6" role="alert">
                    <div class="flex items-start gap-2">
                        <svg class="mt-0.5 shrink-0" width="14" height="14" fill="none"
                             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8"  x2="12"    y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <ul class="list-none space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    {{-- ── Section: Personal Info ── --}}
                    <div>
                        <div class="form-section-label">Personal Information</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Full Name --}}
                            <div>
                                <label class="block text-[.68rem] font-semibold tracking-[.12em]
                                              uppercase text-[#6a7890] mb-1.5">
                                    Full Name
                                </label>
                                <div class="relative">
                                    <svg class="field-icon" fill="none" stroke="currentColor"
                                         stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                    <input type="text" name="name"
                                           value="{{ old('name') }}"
                                           class="lp-input"
                                           placeholder="Juan dela Cruz"
                                           autocomplete="name"
                                           required/>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-[.68rem] font-semibold tracking-[.12em]
                                              uppercase text-[#6a7890] mb-1.5">
                                    Institutional Email
                                </label>
                                <div class="relative">
                                    <svg class="field-icon" fill="none" stroke="currentColor"
                                         stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                    <input type="email" name="email"
                                           value="{{ old('email') }}"
                                           class="lp-input"
                                           placeholder="name@university.edu.ph"
                                           autocomplete="email"
                                           required/>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Section: Role ── --}}
                    <div>
                        <div class="form-section-label">Register as</div>
                        <div class="grid grid-cols-3 gap-3">

                            {{-- Author --}}
                            <label class="role-card">
                                <input type="checkbox" name="roles[]" value="author"
                                       class="role-trigger"
                                       {{ (is_array(old('roles')) && in_array('author', old('roles'))) || (!old('roles')) ? 'checked' : '' }}/>
                                <div class="role-card-inner">
                                    <div class="role-icon-wrap">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                        </svg>
                                    </div>
                                    <span class="role-label">Author</span>
                                    <span class="role-desc">Submit manuscripts</span>
                                </div>
                            </label>

                            {{-- Reviewer --}}
                            <label class="role-card">
                                <input type="checkbox" name="roles[]" value="reviewer"
                                       class="role-trigger"
                                       {{ is_array(old('roles')) && in_array('reviewer', old('roles')) ? 'checked' : '' }}/>
                                <div class="role-card-inner">
                                    <div class="role-icon-wrap">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </div>
                                    <span class="role-label">Reviewer</span>
                                    <span class="role-desc">Evaluate papers</span>
                                </div>
                            </label>

                            {{-- Editor --}}
                            <label class="role-card">
                                <input type="checkbox" name="roles[]" value="editor"
                                       class="role-trigger"
                                       {{ is_array(old('roles')) && in_array('editor', old('roles')) ? 'checked' : '' }}/>
                                <div class="role-card-inner">
                                    <div class="role-icon-wrap">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </div>
                                    <span class="role-label">Editor</span>
                                    <span class="role-desc">Manage submissions</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- ── Expertise Panel (conditional) ── --}}
                    <div id="expertise-container">
                        <div class="p-5 border border-dashed border-[#c9a84c]/35
                                    rounded-xl bg-[#fdfcf8]">
                            <div class="form-section-label" style="margin-bottom:.875rem">
                                Fields of Expertise
                            </div>
                            <p class="text-[.72rem] text-[#a0aab8] mb-3 -mt-1">
                                Select all areas that match your academic background.
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-0.5
                                        max-h-44 overflow-y-auto pr-1 scroll-thin">
                                @foreach ($categories as $category)
                                <label class="exp-check">
                                    <input type="checkbox" name="expertise[]"
                                           value="{{ $category }}"/>
                                    <span>{{ $category }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- ── Section: Password ── --}}
                    <div>
                        <div class="form-section-label">Security</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Password --}}
                            <div>
                                <label class="block text-[.68rem] font-semibold tracking-[.12em]
                                              uppercase text-[#6a7890] mb-1.5">
                                    Password
                                </label>
                                <div class="relative">
                                    <svg class="field-icon" fill="none" stroke="currentColor"
                                         stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    <input id="password" type="password" name="password"
                                           class="lp-input" style="padding-right:2.75rem"
                                           placeholder="••••••••"
                                           autocomplete="new-password"
                                           oninput="checkStrength(this.value)"
                                           required/>
                                    <button type="button" class="eye-btn"
                                            onclick="togglePassword('password', this)"
                                            aria-label="Toggle password visibility">
                                        <svg class="eye-open" width="16" height="16" fill="none"
                                             stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <svg class="eye-closed hidden" width="16" height="16" fill="none"
                                             stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                            <line x1="1" y1="1" x2="23" y2="23"/>
                                        </svg>
                                    </button>
                                </div>
                                {{-- Strength bar --}}
                                <div class="strength-bar-wrap">
                                    <div id="strengthBar" class="strength-bar"></div>
                                </div>
                                <div id="strengthLabel" class="strength-label">Enter a password</div>
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="block text-[.68rem] font-semibold tracking-[.12em]
                                              uppercase text-[#6a7890] mb-1.5">
                                    Confirm Password
                                </label>
                                <div class="relative">
                                    <svg class="field-icon" fill="none" stroke="currentColor"
                                         stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                    <input id="password_confirmation" type="password"
                                           name="password_confirmation"
                                           class="lp-input" style="padding-right:2.75rem"
                                           placeholder="••••••••"
                                           autocomplete="new-password"
                                           required/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div style="display:flex;align-items:center;gap:.75rem;margin:.25rem 0">
                        <div style="flex:1;height:1px;background:#ede8de"></div>
                        <span style="font-size:.6rem;color:#b8aa90;text-transform:uppercase;
                                     letter-spacing:.18em;white-space:nowrap">
                            Secure Registration
                        </span>
                        <div style="flex:1;height:1px;background:#ede8de"></div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="lp-btn">
                        <span style="position:relative;z-index:1;display:inline-flex;
                                     align-items:center;gap:.5rem">
                            Complete Registration
                            <svg width="14" height="14" fill="none" stroke="currentColor"
                                 stroke-width="2.2" viewBox="0 0 24 24">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </span>
                    </button>
                </form>

                {{-- Login link --}}
                <p class="text-center mt-6 text-[.8rem] text-[#8a96a8]">
                    Already have an account?&nbsp;
                    <a href="{{ route('login') }}"
                       class="text-[#a07830] font-semibold
                              border-b border-dashed border-[#a07830]/40
                              hover:text-[#c9a84c] hover:border-[#c9a84c]/50
                              transition-colors">
                        Sign In Instead
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
/* ── Expertise visibility ── */
document.addEventListener('DOMContentLoaded', function () {
    const triggers   = document.querySelectorAll('.role-trigger');
    const container  = document.getElementById('expertise-container');

    function toggleExpertise() {
        const selected = [...document.querySelectorAll('.role-trigger:checked')]
                            .map(cb => cb.value);
        const show = selected.includes('reviewer') || selected.includes('editor');
        container.classList.toggle('expertise-visible', show);
    }

    triggers.forEach(t => t.addEventListener('change', toggleExpertise));
    toggleExpertise();
});

/* ── Password toggle ── */
function togglePassword(fieldId, btn) {
    const input   = document.getElementById(fieldId);
    const isHide  = input.type === 'password';
    input.type    = isHide ? 'text' : 'password';
    btn.querySelectorAll('.eye-open') .forEach(el => el.classList.toggle('hidden',  isHide));
    btn.querySelectorAll('.eye-closed').forEach(el => el.classList.toggle('hidden', !isHide));
}

/* ── Password strength ── */
function checkStrength(val) {
    const bar   = document.getElementById('strengthBar');
    const label = document.getElementById('strengthLabel');
    let score   = 0;
    if (val.length >= 8)              score++;
    if (/[A-Z]/.test(val))            score++;
    if (/[0-9]/.test(val))            score++;
    if (/[^A-Za-z0-9]/.test(val))     score++;

    const levels = [
        { w: '0%',    bg: 'transparent',  txt: 'Enter a password' },
        { w: '25%',   bg: '#ef4444',      txt: 'Weak' },
        { w: '50%',   bg: '#f97316',      txt: 'Fair' },
        { w: '75%',   bg: '#eab308',      txt: 'Good' },
        { w: '100%',  bg: '#22c55e',      txt: 'Strong ✓' },
    ];
    const l = levels[val.length === 0 ? 0 : score] || levels[0];
    bar.style.width      = l.w;
    bar.style.background = l.bg;
    label.textContent    = l.txt;
    label.style.color    = l.bg === 'transparent' ? '#a0aab8' : l.bg;
}

/* ── Input icon focus colour sync ── */
document.querySelectorAll('.lp-input').forEach(el => {
    const icon = el.parentElement.querySelector('.field-icon');
    if (!icon) return;
    el.addEventListener('focus', () => icon.style.color = '#c9a84c');
    el.addEventListener('blur',  () => icon.style.color = '');
});
</script>
@endsection
