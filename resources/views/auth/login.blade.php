@extends('layouts.app')
@section('title', 'Sign In | Journal System')

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
            0%, 100% { transform: translate(0,0)   scale(1);    }
            33%       { transform: translate(18px,-12px) scale(1.05); }
            66%       { transform: translate(-10px,16px) scale(.97); }
        }
        @keyframes line-grow {
            from { transform: scaleX(0); }
            to   { transform: scaleX(1); }
        }
        @keyframes card-in {
            from { opacity: 0; transform: translateY(28px) scale(.97); }
            to   { opacity: 1; transform: translateY(0)   scale(1);    }
        }
        @keyframes input-focus-ring {
            from { box-shadow: 0 0 0 0 rgba(201,168,76,.35); }
            to   { box-shadow: 0 0 0 6px rgba(201,168,76,0); }
        }

        /* ── Utility ── */
        .font-playfair { font-family: 'Playfair Display', Georgia, serif; }
        .font-dm       { font-family: 'DM Sans', system-ui, sans-serif; }

        .lp-fade-up {
            opacity: 0;
            animation: fadeUp .7s cubic-bezier(.22,.68,0,1.2) forwards;
        }

        /* ── Left panel decorative shimmer bar ── */
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
        .orb { animation: float-orb 8s ease-in-out infinite; }
        .orb-2 { animation: float-orb 11s ease-in-out infinite reverse; animation-delay:-4s; }

        /* ── Card ── */
        .login-card {
            animation: card-in .75s cubic-bezier(.22,.68,0,1.2) .15s both;
        }

        /* ── Input ── */
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
        .lp-input::placeholder { color: #b0bac8; }
        .lp-input:focus {
            border-color: #c9a84c;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(201,168,76,.12);
        }
        .lp-input:focus + .input-icon,
        .lp-input:focus ~ .input-icon { color: #c9a84c; }

        /* Select specific */
        .lp-select {
            width: 100%;
            padding: .65rem 2.5rem .65rem 1rem;
            background: #f8f9fc;
            border: 1.5px solid #e2e8f2;
            border-radius: 12px;
            font-size: .875rem;
            font-family: 'DM Sans', system-ui, sans-serif;
            color: #1a202c;
            outline: none;
            appearance: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
            cursor: pointer;
        }
        .lp-select:focus {
            border-color: #c9a84c;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(201,168,76,.12);
        }

        /* ── Submit button ── */
        .lp-btn {
            width: 100%;
            padding: .8rem 1rem;
            background: linear-gradient(135deg, #c9a84c 0%, #a07830 100%);
            color: #fff;
            font-size: .875rem;
            font-weight: 600;
            letter-spacing: .04em;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(160,120,48,.4), 0 1px 3px rgba(160,120,48,.25);
            transition: transform .2s cubic-bezier(.22,.68,0,1.2), box-shadow .2s;
        }
        .lp-btn::before {
            content:'';
            position:absolute;inset:0;
            background: linear-gradient(180deg, rgba(255,255,255,.15) 0%, transparent 60%);
            pointer-events:none;
        }
        .lp-btn::after {
            content:'';
            position:absolute;inset:0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.15), transparent);
            background-size: 200% 100%;
            opacity:0;
            transition: opacity .3s;
        }
        .lp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(160,120,48,.5), 0 2px 6px rgba(160,120,48,.3);
        }
        .lp-btn:hover::after { opacity:1; animation: shimmer 1.5s linear infinite; }
        .lp-btn:active { transform: translateY(0); }

        /* ── Eye toggle ── */
        .eye-btn {
            position:absolute; right:.75rem; top:50%; transform:translateY(-50%);
            background:none; border:none; cursor:pointer; padding:.25rem;
            color:#b0bac8; transition:color .2s;
            display:flex; align-items:center;
        }
        .eye-btn:hover { color:#a07830; }

        /* ── Error alert ── */
        .lp-error {
            background: #fff8f8;
            border: 1.5px solid #fecaca;
            border-left: 4px solid #dc2626;
            border-radius: 10px;
            padding: .75rem 1rem;
            font-size: .8rem;
            color: #991b1b;
        }

        /* ── Divider ── */
        .lp-divider {
            display:flex; align-items:center; gap:.75rem;
            margin: .25rem 0;
        }
        .lp-divider::before, .lp-divider::after {
            content:''; flex:1; height:1px; background:#ede8de;
        }

        /* ── Readable text shadow on dark bg ── */
        .text-shadow { text-shadow: 0 2px 6px rgba(0,0,0,.25); }

        /* ── Stat pill ── */
        .stat-pill {
            display:inline-flex; align-items:center; gap:.5rem;
            padding:.3rem .875rem;
            border: 1px solid rgba(255,255,255,.22);
            background: rgba(0,0,0,.2);
            border-radius:999px;
            font-size:.65rem; letter-spacing:.12em; text-transform:uppercase;
            color:#f0d678; font-weight:600;
        }
        .pulse-dot {
            width:.5rem; height:.5rem; border-radius:50%;
            background:#c9a84c;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        /* ── Role icon badge ── */
        .role-icon {
            position:absolute; left:.875rem; top:50%; transform:translateY(-50%);
            width:1rem; height:1rem; color:#b0bac8; pointer-events:none;
            transition:color .2s;
        }

        /* ── Checkbox custom ── */
        .lp-checkbox {
            width:1rem; height:1rem; border-radius:4px;
            border:1.5px solid #c9a84c; cursor:pointer;
            accent-color:#a07830; flex-shrink:0;
        }

        /* ── Decorative quote mark ── */
        .quote-glyph {
            font-family:'Playfair Display',serif;
            font-size:5rem; line-height:.8;
            color:rgba(201,168,76,.25); user-select:none;
        }

        /* ── Bottom accent line (left panel top) ── */
        .top-accent {
            position:absolute; top:0; left:0; right:0; height:2px; z-index:20;
            transform-origin:left;
            animation: line-grow .8s cubic-bezier(.22,.68,0,1.2) .1s both;
        }
    </style>
@endpush

@section('content')
<div class="font-dm flex flex-col md:flex-row min-h-[calc(100vh-64px)] overflow-hidden">

    {{-- ═══════════════════ LEFT: Brand Panel ═══════════════════ --}}
    <div class="relative flex-none md:w-[48%] flex flex-col justify-center
                px-8 py-14 md:p-14 lg:p-20 overflow-hidden"
         style="background-image:url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1400&q=85&auto=format&fit=crop&crop=center');
                background-size:cover;background-position:center 30%;">

        {{-- Layer 1: Teal brand wash --}}
        <div class="absolute inset-0 z-[1]"
             style="background:linear-gradient(160deg,rgba(18,72,65,.91) 0%,rgba(36,105,96,.86) 40%,rgba(28,84,76,.93) 100%);
                    mix-blend-mode:multiply;"></div>

        {{-- Layer 2: Vignette edges + gold light spill --}}
        <div class="absolute inset-0 z-[2] pointer-events-none"
             style="background:
                 radial-gradient(ellipse 70% 55% at 80% 15%, rgba(201,168,76,.18) 0%, transparent 55%),
                 radial-gradient(ellipse 65% 65% at 0%  90%, rgba(0,0,0,.45)       0%, transparent 50%),
                 radial-gradient(ellipse 100% 30% at 50% 100%,rgba(0,0,0,.35)      0%, transparent 60%),
                 radial-gradient(ellipse 80%  20% at 50%   0%, rgba(0,0,0,.2)       0%, transparent 50%)"></div>

        {{-- Dot-grid texture --}}
        <div class="absolute inset-0 z-[3] opacity-[.04]"
             style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);
                    background-size:26px 26px"></div>

        {{-- Floating orbs --}}
        <div class="orb absolute -top-24 -right-16 w-80 h-80 rounded-full
                    opacity-25 blur-3xl pointer-events-none z-[4]"
             style="background:radial-gradient(circle at 40% 40%,#c9a84c,transparent 70%)"></div>
        <div class="orb-2 absolute -bottom-32 -left-20 w-96 h-96 rounded-full
                    opacity-20 blur-3xl pointer-events-none z-[4]"
             style="background:radial-gradient(circle at 60% 60%,#1a3a5c,transparent 70%)"></div>

        {{-- Top shimmer accent --}}
        <div class="top-accent shimmer-bar z-[5]"></div>

        {{-- Content --}}
        <div class="relative z-[10] max-w-sm">

            {{-- Visitor pill --}}
            @php
                $visitorCount = null;
                try {
                    $day  = date('Y-m-d');
                    $path = storage_path('app/visitors').DIRECTORY_SEPARATOR.$day.'.count';
                    if (file_exists($path)) $visitorCount = (int) @file_get_contents($path);
                } catch (\Throwable $_) {}
            @endphp

            <div class="lp-fade-up mb-8" style="animation-delay:.08s">
                <div class="stat-pill">
                    <span class="pulse-dot"></span>
                    <span>Official Research Portal</span>
                    @if($visitorCount !== null)
                        <span class="text-white/70 font-normal">
                            · <strong class="text-white">{{ number_format($visitorCount) }}</strong> today
                        </span>
                    @endif
                </div>
            </div>

            {{-- Headline --}}
            <h1 class="font-playfair text-shadow text-white
                        text-4xl lg:text-[2.85rem] font-bold leading-[1.2]
                        lp-fade-up mb-5"
                style="animation-delay:.2s">
                Advancing<br>Knowledge.
                <em class="not-italic font-normal block mt-1"
                    style="background:linear-gradient(90deg,#c9a84c,#f0d678,#c9a84c);
                           -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                           background-clip:text">
                    Inspiring Innovation.
                </em>
            </h1>

            {{-- Description --}}
            <p class="text-shadow text-[.875rem] leading-relaxed text-white/80
                       lp-fade-up mb-7"
               style="animation-delay:.34s">
                A peer-reviewed, open-access journal publishing original research across science, technology, engineering, and innovation — connecting scholars and advancing knowledge for the global academic community.
            </p>

            {{-- Gold rule --}}
            <div class="lp-fade-up mb-6" style="animation-delay:.46s">
                <div class="w-10 h-[2px] rounded-full bg-[#c9a84c]"></div>
            </div>

            {{-- Pull quote --}}
            <div class="lp-fade-up flex gap-3" style="animation-delay:.58s">
                <div class="quote-glyph">&ldquo;</div>
                <p class="font-playfair italic text-[.8rem] text-white/85
                           leading-relaxed pt-5">
                    Research is the foundation of progress — and progress is
                    the purpose of this platform.
                </p>
            </div>

            {{-- Bottom stats row --}}
            <div class="lp-fade-up flex gap-5 mt-10 pt-8
                        border-t border-white/10"
                 style="animation-delay:.7s">
                @foreach([['Peer Reviewed','100%'],['Open Access','Free'],['Impact Factor','Indexed']] as [$label,$val])
                <div>
                    <div class="text-[#f0d678] font-semibold text-sm">{{ $val }}</div>
                    <div class="text-white/50 text-[.65rem] tracking-widest uppercase mt-0.5">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══════════════════ RIGHT: Login Form ═══════════════════ --}}
    <div class="flex-1 flex items-center justify-center
                p-8 md:p-10 lg:p-16 relative overflow-hidden"
         style="background:linear-gradient(145deg,#f7f3ec 0%,#ede8df 50%,#e8e2f5 100%)">

        {{-- Decorative rings --}}
        <div class="absolute -top-36 -right-24 w-[30rem] h-[30rem] rounded-full
                    border border-[#a07830]/10 pointer-events-none"></div>
        <div class="absolute -top-10 -right-5 w-[18rem] h-[18rem] rounded-full
                    border border-[#a07830]/07 pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-16 w-60 h-60 rounded-full
                    border border-[#c9a84c]/10 pointer-events-none"></div>

        {{-- Diagonal stripe texture --}}
        <div class="absolute inset-0 opacity-[.03] pointer-events-none"
             style="background-image:repeating-linear-gradient(-50deg,
                        #8a6520 0px,#8a6520 1px,transparent 1px,transparent 22px)"></div>

        {{-- ── Login Card ── --}}
        <div class="login-card relative z-10 w-full max-w-[26rem]
                    bg-white/85 backdrop-blur-2xl
                    border border-[#c9a84c]/18
                    rounded-2xl shadow-2xl shadow-[#a07830]/12
                    overflow-hidden">

            {{-- Card top accent stripe --}}
            <div class="h-[3px] w-full shimmer-bar"></div>

            <div class="p-8 md:p-10">

                {{-- Brand label --}}
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-5 h-[1.5px] bg-[#c9a84c]/60"></div>
                    <span class="text-[.6rem] tracking-[.2em] uppercase
                                 text-[#a07830] font-semibold">
                        Journal System
                    </span>
                </div>

                {{-- Heading --}}
                <h2 class="font-playfair text-[1.6rem] font-bold
                           text-[#0d1628] leading-tight mb-1">
                    Sign in to your account
                </h2>
                <p class="text-[.8rem] text-[#8a96a8] font-light mb-7">
                    Enter your credentials to access the portal.
                </p>

                {{-- Error alert --}}
                @if($errors->any())
                <div class="lp-error mb-5" role="alert">
                    <div class="flex items-start gap-2">
                        <svg class="mt-0.5 shrink-0" width="14" height="14" fill="none"
                             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <ul class="list-none space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Role --}}
                    <div>
                        <label class="block text-[.68rem] font-semibold tracking-[.12em]
                                      uppercase text-[#6a7890] mb-1.5"
                               for="role">
                            Sign in as
                        </label>
                        <div class="relative">
                            <svg class="role-icon" fill="none" stroke="currentColor"
                                 stroke-width="1.8" viewBox="0 0 24 24">
                            </svg>
                            <select id="role" name="role"
                                    class="lp-select pl-9"
                                    required>
                                <option value="" disabled selected>— Select your role —</option>
                                @foreach([
                                    'author'          => 'Author',
                                    'reviewer'        => 'Reviewer',
                                    'editor'          => 'Editor',
                                    'editor-in-chief' => 'Editor in Chief',
                                    'admin'           => 'Admin',
                                    'layout-editor'   => 'Layout Editor',
                                    'managing-editor' => 'Managing Editor',
                                ] as $val => $label)
                                <option value="{{ $val }}" @selected(old('role')===$val)>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                            {{-- Custom chevron --}}
                            <svg class="absolute right-3.5 top-1/2 -translate-y-1/2
                                        w-3.5 h-3.5 text-[#b8aa88] pointer-events-none"
                                 fill="none" stroke="currentColor" stroke-width="2.2"
                                 viewBox="0 0 24 24">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-[.68rem] font-semibold tracking-[.12em]
                                      uppercase text-[#6a7890] mb-1.5"
                               for="email">
                            Email Address
                        </label>
                        <div class="relative">
                            <svg class="role-icon" fill="none" stroke="currentColor"
                                 stroke-width="1.8" viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <input id="email" name="email" type="email"
                                   class="lp-input"
                                   placeholder="you@example.com"
                                   value="{{ old('email') }}"
                                   autocomplete="email"
                                   required/>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-[.68rem] font-semibold tracking-[.12em]
                                          uppercase text-[#6a7890]"
                                   for="password">
                                Password
                            </label>
                            {{-- Optional: forgot password link --}}
                            {{-- <a href="#" class="text-[.72rem] text-[#a07830] hover:text-[#c9a84c]
                                                    transition-colors border-b border-dashed border-[#a07830]/40">
                                Forgot?
                            </a> --}}
                        </div>
                        <div class="relative">
                            <svg class="role-icon" fill="none" stroke="currentColor"
                                 stroke-width="1.8" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input id="password" name="password" type="password"
                                   class="lp-input pr-11"
                                   placeholder="••••••••"
                                   autocomplete="current-password"
                                   required/>
                            <button id="eyeToggle" type="button"
                                    onclick="togglePassword()"
                                    class="eye-btn"
                                    aria-label="Toggle password visibility">
                                {{-- Eye open --}}
                                <svg id="eyeOpen" width="16" height="16" fill="none"
                                     stroke="currentColor" stroke-width="1.8"
                                     viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                {{-- Eye closed (hidden by default) --}}
                                <svg id="eyeClosed" width="16" height="16" fill="none"
                                     stroke="currentColor" stroke-width="1.8"
                                     viewBox="0 0 24 24" class="hidden">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8
                                             a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12
                                             4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07
                                             a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember me --}}
                    <label class="flex items-center gap-2.5 cursor-pointer
                                  text-[.8rem] text-[#6a7890] select-none">
                        <input type="checkbox" name="remember"
                               class="lp-checkbox"
                               {{ old('remember') ? 'checked' : '' }}/>
                        Keep me signed in
                    </label>

                    {{-- Divider --}}
                    <div class="lp-divider">
                        <span class="text-[.6rem] text-[#b8aa90] uppercase
                                     tracking-[.18em] whitespace-nowrap px-1">
                            Secured Access
                        </span>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="lp-btn">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Sign In to Portal
                            <svg width="14" height="14" fill="none"
                                 stroke="currentColor" stroke-width="2.2"
                                 viewBox="0 0 24 24">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </span>
                    </button>
                </form>

                {{-- Register link --}}
                <p class="text-center mt-6 text-[.8rem] text-[#8a96a8]">
                    New to the journal?&nbsp;
                    <a href="{{ route('register') }}"
                       class="text-[#a07830] font-semibold
                              border-b border-dashed border-[#a07830]/40
                              hover:text-[#c9a84c] hover:border-[#c9a84c]/50
                              transition-colors">
                        Create Account
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input     = document.getElementById('password');
        const eyeOpen   = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');
        const isHidden  = input.type === 'password';

        input.type = isHidden ? 'text' : 'password';
        eyeOpen  .classList.toggle('hidden',  isHidden);
        eyeClosed.classList.toggle('hidden', !isHidden);
    }

    /* Subtle input icon color sync via JS (complements CSS :focus) */
    document.querySelectorAll('.lp-input, .lp-select').forEach(el => {
        const icon = el.parentElement.querySelector('.role-icon');
        if (!icon) return;
        el.addEventListener('focus',  () => icon.style.color = '#c9a84c');
        el.addEventListener('blur',   () => icon.style.color = '');
    });
</script>
@endsection