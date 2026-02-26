@extends('layouts.app')
@section('title', 'Register | JOURNAL SYSTEM')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600&display=swap"
        rel="stylesheet"
    />
    <style>
        @keyframes lpShimmer {
            0% {
                background-position: -100% 0;
            }
            100% {
                background-position: 100% 0;
            }
        }
        @keyframes lpDrift {
            0%,
            100% {
                transform: translate(0, 0);
            }
            40% {
                transform: translate(14px, -10px);
            }
            70% {
                transform: translate(-8px, 14px);
            }
        }
        @keyframes lpUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes lpBlink {
            0%,
            100% {
                opacity: 1;
            }
            50% {
                opacity: 0.3;
            }
        }

        .animate-lp-up {
            opacity: 0;
            animation: lpUp 0.65s ease forwards;
        }
        .animate-lp-shimmer {
            background: linear-gradient(
                90deg,
                transparent,
                #c9a84c,
                #f0d678,
                #c9a84c,
                transparent
            );
            background-size: 200% 100%;
            animation: lpShimmer 3s linear infinite;
        }
        .readable-text {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Expertise container transition */
        #expertise-container {
            display: none;
        }
        .expertise-visible {
            display: block !important;
            animation: lpUp 0.3s ease forwards;
        }
        .scroll-thin::-webkit-scrollbar {
            width: 4px;
        }
        .scroll-thin::-webkit-scrollbar-thumb {
            background: #c9a84c;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
    <div
        class="flex flex-col md:flex-row min-h-[calc(100vh-64px)] overflow-hidden font-['Source_Sans_3']"
    >
        {{-- LEFT SIDE: THE TEAL SIDE (Matched to Login) --}}
        <div
            class="relative flex-none md:w-2/5 flex flex-col justify-center px-8 py-12 md:p-16 overflow-hidden bg-[#2D8176] z-10"
        >
            <div class="absolute inset-0 z-0 bg-black/15"></div>
            <div
                class="absolute inset-0 z-0"
                style="
                    background-image:
                        radial-gradient(
                            ellipse 80% 60% at 75% 20%,
                            rgba(201, 168, 76, 0.18) 0%,
                            transparent 60%
                        ),
                        radial-gradient(
                            ellipse 60% 70% at 5% 85%,
                            rgba(0, 0, 0, 0.25) 0%,
                            transparent 50%
                        );
                "
            ></div>
            <div
                class="absolute inset-0 z-0 opacity-[0.05]"
                style="
                    background-image: radial-gradient(
                        circle,
                        #ffffff 1px,
                        transparent 1px
                    );
                    background-size: 28px 28px;
                "
            ></div>
            <div
                class="absolute top-0 left-0 right-0 h-[2px] z-20 animate-lp-shimmer"
            ></div>

            <div class="relative z-20">
                <div
                    class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full border border-white/30 bg-black/20 text-[10px] tracking-widest uppercase text-[#f0d678] font-semibold mb-7 animate-lp-up [animation-delay:80ms]"
                >
                    <span
                        class="w-1.5 h-1.5 rounded-full bg-[#c9a84c] shadow-[0_0_8px_rgba(201,168,76,0.8)]"
                        style="animation: lpBlink 2s ease-in-out infinite"
                    ></span>
                    Researcher Registration
                </div>
                <h2
                    class="readable-text font-['Libre_Baskerville'] text-4xl lg:text-5xl font-bold leading-[1.15] text-white mb-6 animate-lp-up [animation-delay:200ms]"
                >
                    Start your
                    <br />
                    <em
                        class="not-italic font-normal block bg-gradient-to-r from-[#c9a84c] via-[#f0d678] to-[#c9a84c] bg-clip-text text-transparent drop-shadow-sm italic"
                    >
                        Contribution
                    </em>
                    today.
                </h2>
                <p
                    class="readable-text text-[14px] leading-relaxed font-medium text-white/90 mb-8 animate-lp-up [animation-delay:340ms] border-l-2 border-[#c9a84c]/50 pl-4"
                >
                    Create your account to submit manuscripts, track review
                    progress, or join our community of global peer reviewers.
                </p>
            </div>

            <div
                class="absolute -bottom-20 -left-20 opacity-10 pointer-events-none"
            >
                <svg
                    class="w-[300px] h-[300px]"
                    viewBox="0 0 400 400"
                    fill="none"
                    stroke="#ffffff"
                >
                    <circle cx="200" cy="200" r="190" stroke-width="1" />
                    <circle cx="200" cy="200" r="140" stroke-width="1" />
                </svg>
            </div>
        </div>

        {{-- RIGHT SIDE: REGISTRATION FORM (Matched to Login Right Side) --}}
        <div
            class="flex-1 flex items-center justify-center p-6 md:p-10 relative overflow-y-auto bg-gradient-to-br from-[#f5f0e8] via-[#ede5d5] to-[#e4daf0] z-0"
        >
            <div
                class="absolute rounded-full w-[500px] h-[500px] -top-40 -right-28 border border-[#a07830]/10"
            ></div>
            <div
                class="absolute inset-0 opacity-[0.035]"
                style="
                    background-image: repeating-linear-gradient(
                        -50deg,
                        #8a6520 0px,
                        #8a6520 1px,
                        transparent 1px,
                        transparent 20px
                    );
                "
            ></div>

            <div
                class="relative z-10 w-full max-w-[550px] bg-white/90 border border-[#c9a84c]/20 rounded-[20px] p-8 md:p-10 backdrop-blur-xl shadow-2xl animate-lp-up"
            >
                <div class="mb-6">
                    <p
                        class="text-[10px] tracking-widest uppercase text-[#a07830] font-medium mb-1 flex items-center gap-2"
                    >
                        <span class="w-[18px] h-px bg-[#c9a84c]/60"></span>
                        JOURNAL SYSTEM
                    </p>
                    <h1
                        class="font-['Libre_Baskerville'] text-2xl font-bold text-[#0d1628]"
                    >
                        Create Account
                    </h1>
                    <p class="text-[13px] text-[#8a96a8] font-light">
                        Join the Journal System academic community.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('register') }}"
                    class="space-y-4"
                >
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Full Name --}}
                        <div>
                            <label
                                class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5"
                            >
                                Full Name
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] transition-all"
                            />
                        </div>

                        {{-- Email --}}
                        <div>
                            <label
                                class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5"
                            >
                                Institutional Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] transition-all"
                                placeholder="name@university.edu.ph"
                            />
                        </div>
                    </div>

                    {{-- Register as --}}
                    <div>
                        <label
                            class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-2"
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
                                        class="py-2.5 border-[1.5px] border-[#dde4ee] rounded-xl text-center transition-all peer-checked:border-[#c9a84c] peer-checked:bg-[#c9a84c]/5 group-hover:border-[#c9a84c]/40"
                                    >
                                        <p
                                            class="text-[11px] font-bold uppercase tracking-wide text-slate-600 peer-checked:text-[#a07830]"
                                        >
                                            {{ ucfirst($role) }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Expertise (Conditional) --}}
                    <div id="expertise-container" class="transition-all">
                        <div
                            class="p-4 border-[1.5px] border-dashed border-[#c9a84c]/30 rounded-xl bg-[#fafbfd]"
                        >
                            <label
                                class="block text-[10px] font-bold uppercase text-[#a07830] mb-3"
                            >
                                Fields of Expertise
                            </label>
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 max-h-40 overflow-y-auto pr-2 scroll-thin"
                            >
                                @foreach ($categories as $category)
                                    <label
                                        class="flex items-center gap-2.5 cursor-pointer group"
                                    >
                                        <input
                                            type="checkbox"
                                            name="expertise[]"
                                            value="{{ $category }}"
                                            class="w-4 h-4 rounded border-[#dde4ee] text-[#a07830] focus:ring-[#c9a84c]"
                                        />
                                        <span
                                            class="text-xs text-slate-600 group-hover:text-[#a07830] transition-colors leading-tight"
                                        >
                                            {{ $category }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Password Section --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5"
                            >
                                Password
                            </label>
                            <input
                                type="password"
                                name="password"
                                required
                                class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] transition-all"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5"
                            >
                                Confirm Password
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] transition-all"
                            />
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full py-3 mt-2 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-[#a07830]/20 hover:-translate-y-0.5 transition-all"
                    >
                        Complete Registration
                    </button>
                </form>

                {{-- Login link --}}
                <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                    <p class="text-[13px] text-[#8a96a8]">
                        Already have an account? &nbsp;
                        <a
                            href="{{ route('login') }}"
                            class="text-[#a07830] font-semibold hover:text-[#c9a84c] transition-colors underline underline-offset-4 decoration-dashed decoration-[#c9a84c]/40"
                        >
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
