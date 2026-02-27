@extends('layouts.app')

@section('title', 'Add User')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --gold: #c9a84c;
            --gold-l: #f0d678;
            --ink: #0d1628;
            --mist: #f5f0e8;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }
        @keyframes pulse-dot {
            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(201, 168, 76, 0.6);
            }
            50% {
                box-shadow: 0 0 0 6px rgba(201, 168, 76, 0);
            }
        }

        .fade-up {
            opacity: 0;
            animation: fadeUp 0.55s cubic-bezier(0.22, 0.68, 0, 1.2) forwards;
        }

        .shimmer-bar {
            background: linear-gradient(
                90deg,
                transparent,
                var(--gold),
                var(--gold-l),
                var(--gold),
                transparent
            );
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        /* Floating label inputs */
        .field-wrap {
            position: relative;
        }
        .field-wrap input {
            width: 100%;
            padding: 22px 20px 8px;
            background: #fff;
            border: 1.5px solid #e2ddd4;
            border-radius: 14px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.2s,
                box-shadow 0.2s,
                background 0.2s;
        }
        .field-wrap input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(45, 129, 118, 0.1);
            background: #fff;
        }
        .field-wrap input:focus + label,
        .field-wrap input:not(:placeholder-shown) + label {
            top: 8px;
            font-size: 9px;
            letter-spacing: 0.12em;
            color: var(--teal);
        }
        .field-wrap label {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            font-weight: 700;
            color: #9ea8b8;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            pointer-events: none;
            transition: all 0.18s ease;
            font-family: 'Source Sans 3', sans-serif;
        }
        .field-wrap input::placeholder {
            color: transparent;
        }

        /* Role cards */
        .role-card {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: #faf9f7;
            border: 1.5px solid #e8e2d8;
            border-radius: 14px;
            cursor: pointer;
            transition:
                border-color 0.18s,
                background 0.18s,
                transform 0.15s;
            overflow: hidden;
        }
        .role-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(45, 129, 118, 0.07) 0%,
                transparent 60%
            );
            opacity: 0;
            transition: opacity 0.18s;
        }
        .role-card:hover {
            border-color: var(--teal);
            transform: translateY(-1px);
        }
        .role-card:hover::before {
            opacity: 1;
        }
        .role-card input[type='checkbox'] {
            display: none;
        }
        .role-card .check-box {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #d0cac0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition:
                border-color 0.18s,
                background 0.18s;
        }
        .role-card .check-box svg {
            opacity: 0;
            transition: opacity 0.15s;
        }
        .role-card input:checked ~ .role-label {
            color: var(--teal);
        }
        .role-card:has(input:checked) {
            border-color: var(--teal);
            background: #fff;
        }
        .role-card:has(input:checked) .check-box {
            background: var(--teal);
            border-color: var(--teal);
        }
        .role-card:has(input:checked) .check-box svg {
            opacity: 1;
        }
        .role-card:has(input:checked)::before {
            opacity: 1;
        }

        .role-label {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #6a7890;
            transition: color 0.18s;
            line-height: 1.2;
        }

        /* Eye toggle */
        .eye-btn {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #b0aaa0;
            cursor: pointer;
            transition: color 0.15s;
            padding: 4px;
        }
        .eye-btn:hover {
            color: var(--teal);
        }

        /* Submit button */
        .btn-primary {
            position: relative;
            overflow: hidden;
            padding: 16px 40px;
            background: var(--teal);
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            transition:
                background 0.2s,
                transform 0.15s,
                box-shadow 0.2s;
            box-shadow: 0 8px 24px rgba(45, 129, 118, 0.3);
        }
        .btn-primary::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(255, 255, 255, 0.12),
                transparent
            );
        }
        .btn-primary:hover {
            background: #236860;
            transform: translateY(-1px);
            box-shadow: 0 12px 32px rgba(45, 129, 118, 0.4);
        }
        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-cancel {
            padding: 16px 40px;
            background: transparent;
            color: #9ea8b8;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            border-radius: 14px;
            border: 1.5px solid #e2ddd4;
            cursor: pointer;
            transition:
                background 0.18s,
                color 0.18s,
                border-color 0.18s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-cancel:hover {
            background: #f5f0e8;
            color: #6a7890;
            border-color: #c9c0b0;
        }

        /* Section divider */
        .section-rule {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 0;
        }
        .section-rule span {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #b0aaa0;
            white-space: nowrap;
        }
        .section-rule::before,
        .section-rule::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ede8e0;
        }

        /* Left accent panel */
        .accent-panel {
            background: var(--teal);
            border-radius: 24px 0 0 24px;
            position: relative;
            overflow: hidden;
            display: none;
        }
        @media (min-width: 900px) {
            .accent-panel {
                display: flex;
            }
        }

        .dot-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(
                circle,
                rgba(255, 255, 255, 0.12) 1px,
                transparent 1px
            );
            background-size: 22px 22px;
        }

        .form-shell {
            display: grid;
            grid-template-columns: 1fr;
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow:
                0 24px 80px rgba(13, 22, 40, 0.1),
                0 4px 16px rgba(13, 22, 40, 0.06);
            border: 1px solid #ede8e0;
        }
        @media (min-width: 900px) {
            .form-shell {
                grid-template-columns: 240px 1fr;
            }
        }

        /* Error flash */
        .error-flash {
            background: #fff5f5;
            border: 1.5px solid #fecaca;
            border-left: 4px solid #dc2626;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #991b1b;
            font-family: 'Source Sans 3', sans-serif;
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen bg-[var(--mist)] py-10 px-4 font-['Source_Sans_3']"
        style="
            background: linear-gradient(
                135deg,
                #f5f0e8 0%,
                #ede5d5 50%,
                #e8e0f0 100%
            );
        "
    >
        {{-- Top shimmer --}}
        <div class="fixed top-0 left-0 right-0 h-[2px] shimmer-bar z-50"></div>

        <div class="max-w-5xl mx-auto">
            {{-- Breadcrumb + heading --}}
            <div class="mb-8 fade-up" style="animation-delay: 60ms">
                <nav
                    class="flex items-center gap-2 text-[10px] font-black text-[#b0aaa0] uppercase tracking-widest mb-3"
                >
                    <a
                        href="{{ route('dashboard.admin') }}"
                        class="hover:text-[var(--teal)] transition-colors"
                    >
                        Admin
                    </a>
                    <svg
                        class="w-3 h-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M9 5l7 7-7 7" stroke-width="2.5" />
                    </svg>
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="hover:text-[var(--teal)] transition-colors"
                    >
                        Directory
                    </a>
                    <svg
                        class="w-3 h-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M9 5l7 7-7 7" stroke-width="2.5" />
                    </svg>
                    <span class="text-[var(--ink)]">New Profile</span>
                </nav>
                <div class="flex items-end justify-between gap-4 flex-wrap">
                    <div>
                        <p
                            class="text-[10px] font-black uppercase tracking-[.2em] text-[var(--teal)] mb-1 flex items-center gap-2"
                        >
                            <span
                                class="w-1.5 h-1.5 rounded-full bg-[var(--gold)]"
                                style="
                                    animation: pulse-dot 2s ease-in-out infinite;
                                "
                            ></span>
                            Journal System · Admin Panel
                        </p>
                        <h1
                            class="font-['Libre_Baskerville'] text-4xl font-bold text-[var(--ink)] leading-tight"
                        >
                            Create
                            <em
                                class="not-italic bg-gradient-to-r from-[var(--teal)] to-[#1a6b62] bg-clip-text text-transparent"
                            >
                                New User
                            </em>
                        </h1>
                    </div>
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl border border-[#ddd8ce] bg-white/80 text-[10px] font-black uppercase tracking-widest text-[#9ea8b8] hover:text-[var(--teal)] hover:border-[var(--teal)] transition-all active:scale-95 backdrop-blur-sm"
                    >
                        <svg
                            class="w-3 h-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M15 19l-7-7 7-7"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        Back to Directory
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div
                    class="error-flash fade-up mb-6"
                    style="animation-delay: 100ms"
                >
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Shell --}}
            <div class="form-shell fade-up" style="animation-delay: 160ms">
                {{-- Left accent panel --}}
                <div class="accent-panel flex-col justify-between p-8">
                    <div class="dot-grid"></div>
                    <div
                        class="absolute inset-0"
                        style="
                            background: radial-gradient(
                                ellipse 80% 60% at 20% 80%,
                                rgba(201, 168, 76, 0.15) 0%,
                                transparent 60%
                            );
                        "
                    ></div>

                    <div class="relative z-10">
                        <div
                            class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center mb-6"
                        >
                            <svg
                                class="w-5 h-5 text-[var(--gold-l)]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                        </div>
                        <h2
                            class="font-['Libre_Baskerville'] text-xl font-bold text-white leading-snug mb-3"
                        >
                            New System
                            <br />
                            Account
                        </h2>
                        <p class="text-white/60 text-[12px] leading-relaxed">
                            Fill in the details to register a new user in the
                            BIRJISE journal platform.
                        </p>
                    </div>

                    <div class="relative z-10 space-y-3 mt-8">
                        @foreach ([['📝', 'Identity', 'Name & email'], ['🔐', 'Security', 'Set a password'], ['🎭', 'Roles', 'Assign access']] as [$icon, $title, $sub])
                            <div class="flex items-center gap-3">
                                <span class="text-base">{{ $icon }}</span>
                                <div>
                                    <p
                                        class="text-white text-[11px] font-bold uppercase tracking-wider"
                                    >
                                        {{ $title }}
                                    </p>
                                    <p class="text-white/50 text-[11px]">
                                        {{ $sub }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="relative z-10 mt-8 pt-6 border-t border-white/10"
                    >
                        <p
                            class="text-[10px] text-white/40 uppercase tracking-widest"
                        >
                            BatStateU · BIRJISE
                        </p>
                    </div>
                </div>

                {{-- Right form --}}
                <form
                    method="POST"
                    action="{{ route('admin.users.store') }}"
                    class="p-8 md:p-10 space-y-8"
                >
                    @csrf

                    {{-- Identity --}}
                    <div>
                        <div class="section-rule mb-6">
                            <span>Identity</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="field-wrap">
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    placeholder=" "
                                />
                                <label for="name">Full Name *</label>
                            </div>
                            <div class="field-wrap">
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder=" "
                                />
                                <label for="email">Email Address *</label>
                            </div>
                        </div>
                    </div>

                    {{-- Security --}}
                    <div>
                        <div class="section-rule mb-6">
                            <span>Security</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="field-wrap">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    placeholder=" "
                                />
                                <label for="password">Password *</label>
                                <button
                                    type="button"
                                    class="eye-btn"
                                    onclick="
                                        togglePassword(
                                            'password',
                                            'eye-password',
                                        )
                                    "
                                >
                                    <svg
                                        id="eye-password"
                                        width="18"
                                        height="18"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"
                                        />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                            <div class="field-wrap">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    placeholder=" "
                                />
                                <label for="password_confirmation">
                                    Confirm Password *
                                </label>
                                <button
                                    type="button"
                                    class="eye-btn"
                                    onclick="
                                        togglePassword(
                                            'password_confirmation',
                                            'eye-confirm',
                                        )
                                    "
                                >
                                    <svg
                                        id="eye-confirm"
                                        width="18"
                                        height="18"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"
                                        />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Roles --}}
                    <div>
                        <div class="section-rule mb-6">
                            <span>System Roles</span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach ($roles as $role)
                                <label class="role-card">
                                    <input
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $role->id }}"
                                        {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                                    />
                                    <div class="check-box">
                                        <svg
                                            width="11"
                                            height="11"
                                            viewBox="0 0 12 12"
                                            fill="none"
                                        >
                                            <path
                                                d="M2 6l3 3 5-5"
                                                stroke="#fff"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </div>
                                    <span class="role-label">
                                        {{ $role->display_name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-[#b0aaa0] mt-3 ml-1">
                            Select one or more roles to assign to this user.
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div
                        class="flex items-center gap-3 pt-4 border-t border-[#ede8e0]"
                    >
                        <button type="submit" class="btn-primary">
                            <span class="relative z-10 flex items-center gap-2">
                                <svg
                                    width="14"
                                    height="14"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>
                                Create User
                            </span>
                        </button>
                        <a
                            href="{{ route('admin.users.index') }}"
                            class="btn-cancel"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <p
                class="text-center text-[10px] text-[#c0b8a8] uppercase tracking-widest mt-6 fade-up"
                style="animation-delay: 300ms"
            >
                BatStateU · BIRJISE Journal System
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`
                : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>`;
        }
    </script>
@endsection
