@extends('layouts.app')
@section('title', 'Login | JOURNAL SYSTEM')

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
    </style>
@endpush

@section('content')
    <div
        class="flex flex-col md:flex-row min-h-[calc(100vh-64px)] overflow-hidden font-['Source_Sans_3']"
    >
        {{-- LEFT SIDE: THE TEAL SIDE --}}
        <div
            class="relative flex-none md:w-1/2 flex flex-col justify-center px-8 py-12 md:p-16 lg:p-20 overflow-hidden bg-[#2D8176] z-10"
        >
            <div class="absolute inset-0 z-0 bg-black/15"></div>
            <div
                class="absolute inset-0 z-0"
                style="
                    background-image:
                        radial-gradient(
                            ellipse 80% 60% at 75% 20%,
                            rgba(201, 168, 76, 0.2) 0%,
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

            <div class="relative z-20 max-w-[420px]">
                @php
                    if (! isset($visitorCount)) {
                        $visitorCount = null;
                        try {
                            $day = date('Y-m-d');
                            $dir = storage_path('app/visitors');
                            if (! is_dir($dir)) {
                                mkdir($dir, 0755, true);
                            }
                            $path = $dir . DIRECTORY_SEPARATOR . $day . '.count';

                            if (! file_exists($path)) {
                                file_put_contents($path, '1');
                                $visitorCount = 1;
                            } else {
                                $fp = fopen($path, 'c+');
                                if ($fp) {
                                    if (flock($fp, LOCK_EX)) {
                                        $contents = stream_get_contents($fp);
                                        $current = (int) trim($contents);
                                        if ($current < 0) $current = 0;
                                        $current++;
                                        ftruncate($fp, 0);
                                        rewind($fp);
                                        fwrite($fp, (string) $current);
                                        fflush($fp);
                                        flock($fp, LOCK_UN);
                                        $visitorCount = $current;
                                    } else {
                                        $visitorCount = (int) file_get_contents($path);
                                    }
                                    fclose($fp);
                                } else {
                                    $visitorCount = (int) file_get_contents($path) + 1;
                                    file_put_contents($path, (string) $visitorCount);
                                }
                            }
                        } catch (\Throwable $e) {
                            $visitorCount = null;
                        }
                    }
                @endphp

                <div
                    class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full border border-white/30 bg-black/20 text-[10px] tracking-widest uppercase text-[#f0d678] font-semibold mb-7 animate-lp-up [animation-delay:80ms]"
                >
                    <span
                        class="w-1.5 h-1.5 rounded-full bg-[#c9a84c] shadow-[0_0_8px_rgba(201,168,76,0.8)]"
                        style="animation: lpBlink 2s ease-in-out infinite"
                    ></span>
                    @if ($visitorCount !== null)
                        <span class="text-[10px] text-white/80 ml-2">Today's visitors: <strong class="ml-1">{{ $visitorCount }}</strong></span>
                    @endif
                </div>
                <h1
                    class="readable-text font-['Libre_Baskerville'] text-4xl lg:text-5xl font-bold leading-[1.15] text-white mb-6 animate-lp-up [animation-delay:200ms]"
                >
                    Advancing
                    <br />
                    Knowledge.
                    <em
                        class="not-italic font-normal block bg-gradient-to-r from-[#c9a84c] via-[#f0d678] to-[#c9a84c] bg-clip-text text-transparent drop-shadow-sm"
                    >
                        Inspiring Innovation.
                    </em>
                </h1>
                <p
                    class="readable-text text-[14px] leading-relaxed font-medium text-white mb-8 animate-lp-up [animation-delay:340ms]"
                >
                    BatStateU International Research Journal of Information
                    Systems & Engineering Technology — peer-reviewed,
                    open-access research for the global academic community.
                </p>
                <div
                    class="w-12 h-[2px] bg-[#c9a84c] mb-6 animate-lp-up [animation-delay:460ms]"
                ></div>
                <div class="flex gap-4 animate-lp-up [animation-delay:580ms]">
                    <span
                        class="font-['Libre_Baskerville'] text-5xl text-[#c9a84c]/40 leading-none"
                    >
                        "
                    </span>
                    <p
                        class="readable-text font-['Libre_Baskerville'] italic text-[13.5px] text-white/90 leading-relaxed pt-2"
                    >
                        Research is the foundation of progress — and progress is
                        the purpose of this platform.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE: FULL ORIGINAL RESTORED --}}
        <div
            class="flex-1 flex items-center justify-center p-8 md:p-12 lg:p-16 relative overflow-hidden bg-gradient-to-br from-[#f5f0e8] via-[#ede5d5] to-[#e4daf0] z-0"
        >
            <div
                class="absolute rounded-full w-[500px] h-[500px] -top-40 -right-28 border border-[#a07830]/10"
            ></div>
            <div
                class="absolute rounded-full w-[300px] h-[300px] -top-14 -right-5 border border-[#a07830]/5"
            ></div>
            <div
                class="absolute rounded-full w-[240px] h-[240px] -bottom-20 -left-14 border border-[#c9a84c]/10 bg-radial-gradient from-[#c9a84c]/5 to-transparent"
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
                class="relative z-10 w-full max-w-[400px] bg-white/90 border border-[#c9a84c]/20 rounded-[20px] p-10 backdrop-blur-xl shadow-2xl animate-lp-up [animation-delay:200ms]"
            >
                <p
                    class="text-[10px] tracking-widest uppercase text-[#a07830] font-medium mb-2 flex items-center gap-2"
                >
                    <span class="w-[18px] h-px bg-[#c9a84c]/60"></span>
                    JOURNAL SYSTEM
                </p>
                <h2
                    class="font-['Libre_Baskerville'] text-2xl font-bold text-[#0d1628] leading-tight mb-1.5"
                >
                    Sign in to your account
                </h2>
                <p class="text-[13px] text-[#8a96a8] font-light mb-6">
                    Enter your credentials to access the portal.
                </p>

                @if ($errors->any())
                    <div
                        class="bg-[#fff5f5] border border-[#fecaca] border-l-4 border-l-[#dc2626] rounded-lg p-3 mb-4 text-[13px] text-[#991b1b]"
                    >
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="space-y-4"
                >
                    @csrf
                    <div>
                        <label
                            class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5"
                            for="role"
                        >
                            Sign in as
                        </label>
                        <div class="relative">
                            <select
                                id="role"
                                name="role"
                                class="w-full px-4 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] focus:ring-4 focus:ring-[#c9a84c]/10 transition-all appearance-none"
                                required
                            >
                                <option value="" disabled selected>
                                    — Select your role —
                                </option>
                                <option
                                    value="author"
                                    @selected(old('role') == 'author')
                                >
                                    Author
                                </option>
                                <option
                                    value="reviewer"
                                    @selected(old('role') == 'reviewer')
                                >
                                    Reviewer
                                </option>
                                <option
                                    value="editor"
                                    @selected(old('role') == 'editor')
                                >
                                    Editor
                                </option>
                                <option
                                    value="editor-in-chief"
                                    @selected(old('role') == 'editor-in-chief')
                                >
                                    Editor in Chief
                                </option>
                                <option
                                    value="admin"
                                    @selected(old('role') == 'admin')
                                >
                                    Admin
                                </option>
                            </select>
                            <div
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-0 h-0 border-l-[5px] border-l-transparent border-r-[5px] border-r-transparent border-t-[5px] border-t-[#b8aa88] pointer-events-none"
                            ></div>
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5"
                            for="email"
                        >
                            Email Address
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="w-full pl-4 pr-10 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] focus:ring-4 focus:ring-[#c9a84c]/10 transition-all"
                                placeholder="you@example.com"
                                value="{{ old('email') }}"
                                required
                            />
                            <svg
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#c8b888]"
                                width="15"
                                height="15"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                                />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-1.5"
                            for="password"
                        >
                            Password
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full pl-4 pr-10 py-2.5 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-sm outline-none focus:border-[#c9a84c] focus:ring-4 focus:ring-[#c9a84c]/10 transition-all"
                                placeholder="••••••••"
                                required
                            />
                            <svg
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#c8b888]"
                                width="15"
                                height="15"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="3"
                                    y="11"
                                    width="18"
                                    height="11"
                                    rx="2"
                                    ry="2"
                                />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </div>
                    </div>

                    <label
                        class="flex items-center gap-2.5 cursor-pointer text-[13px] text-[#6a7890]"
                    >
                        <input
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 accent-[#a07830]"
                            {{ old('remember') ? 'checked' : '' }}
                        />
                        Keep me signed in
                    </label>

                    <div class="flex items-center gap-3 py-2">
                        <div class="flex-1 h-px bg-[#e8e0d0]"></div>
                        <span
                            class="text-[10px] text-[#b8aa90] uppercase tracking-widest whitespace-nowrap"
                        >
                            Secured Access
                        </span>
                        <div class="flex-1 h-px bg-[#e8e0d0]"></div>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-sm font-semibold tracking-wide rounded-xl shadow-lg shadow-[#a07830]/35 hover:-translate-y-0.5 active:translate-y-0 transition-transform relative overflow-hidden"
                    >
                        <span class="relative z-10">Sign In to Portal →</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-white/10 to-transparent"
                        ></div>
                    </button>
                </form>
                <p class="text-center mt-5 text-[13px] text-[#8a96a8]">
                    New to the journal? &nbsp;
                    <a
                        href="{{ route('register') }}"
                        class="text-[#a07830] font-medium border-b border-dashed border-[#a07830]/40 hover:text-[#c9a84c] transition-colors"
                    >
                        Create Account
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
