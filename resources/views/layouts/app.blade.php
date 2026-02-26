<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', config('app.name')) - Journal System</title>

        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            @keyframes lpShimmer {
                0% {
                    background-position: -100% 0;
                }
                100% {
                    background-position: 100% 0;
                }
            }
            .nav-shimmer {
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
            .font-libre {
                font-family: 'Libre Baskerville', serif;
            }
            .font-source {
                font-family: 'Source Sans 3', sans-serif;
            }
            .nav-link-active {
                background: rgba(255, 255, 255, 0.15);
                border-bottom: 2px solid #f0d678;
            }
        </style>
        @stack('styles')
    </head>
    <body
        class="min-h-screen bg-[#f5f0e8] text-[#0d1628] font-source antialiased flex flex-col"
    >
        <div class="h-[3px] w-full nav-shimmer sticky top-0 z-[60]"></div>

        <nav
            class="bg-[#2D8176] shadow-xl sticky top-[3px] z-50 border-b border-white/10"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center gap-6">
                        <a
                            href="{{ url('/') }}"
                            class="flex items-center space-x-3 group transition-all"
                        >
                            <div
                                class="relative w-12 h-12 flex items-center justify-center bg-gradient-to-br from-[#c9a84c] to-[#a07830] rounded-full border-2 border-white/30 shadow-inner group-hover:rotate-12 transition-transform duration-500"
                            >
                                <svg
                                    class="text-white w-7 h-7"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                    ></path>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="font-libre text-2xl font-bold text-white leading-none tracking-tight"
                                >
                                    Journal System
                                </span>
                                <span
                                    class="text-[9px] font-bold text-[#f0d678] tracking-[0.2em] uppercase opacity-90"
                                >
                                    Academic Publishing Portal
                                </span>
                            </div>
                        </a>

                        @auth
                            @php
                                /*
                                 * Determine the ONE active role to show nav links for.
                                 * Priority: session('active_role') → session('preferred_dashboard') → primaryRole → first role.
                                 * This prevents multi-role users from seeing all nav links at once.
                                 */
                                $activeRole = session('active_role');
                                if (!$activeRole) {
                                    $preferred = session('preferred_dashboard');
                                    if ($preferred) {
                                        $activeRole = $preferred;
                                    } else {
                                        $user = auth()->user();
                                        if (method_exists($user, 'primaryRole') && $user->primaryRole()) {
                                            $activeRole = $user->primaryRole()->name;
                                        } else {
                                            $activeRole = optional($user->roles->first())->name ?? 'author';
                                        }
                                    }
                                }

                                $linkBase = 'px-4 py-2 rounded-lg text-[13px] font-semibold tracking-wide transition-all duration-300 ';
                                $inactive = 'text-white/80 hover:text-[#f0d678] hover:bg-black/10';
                            @endphp

                            <div
                                class="hidden md:flex items-center space-x-1 ml-6 border-l border-white/10 pl-6"
                            >
                                {{-- Dashboard is always shown --}}
                                <a
                                    href="{{ route('dashboard') }}"
                                    class="{{ $linkBase . $inactive }}"
                                >
                                    DASHBOARD
                                </a>

                                {{-- Author links --}}
                                @if ($activeRole === 'author')
                                    <a
                                        href="{{ route('submissions.index') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        SUBMISSIONS
                                    </a>
                                @endif

                                {{-- Reviewer links --}}
                                @if ($activeRole === 'reviewer')
                                    <a
                                        href="{{ route('reviews.index') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        REVIEWS
                                    </a>
                                @endif

                                {{-- Editor links --}}
                                @if ($activeRole === 'editor')
                                    <a
                                        href="{{ route('editor.submissions') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        EDITORIAL
                                    </a>
                                @endif

                                {{-- Editor-in-chief links --}}
                                @if ($activeRole === 'editor-in-chief')
                                    <a
                                        href="{{ route('editor.submissions') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        EDITORIAL
                                    </a>
                                    @if (Route::has('appeals.index'))
                                        <a
                                            href="{{ route('appeals.index') }}"
                                            class="{{ $linkBase . $inactive }}"
                                        >
                                            APPEALS
                                        </a>
                                    @endif
                                @endif

                                {{-- Admin links --}}
                                @if ($activeRole === 'admin')
                                    <a
                                        href="{{ route('admin.users.index') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        MANAGEMENT
                                    </a>
                                @endif

                                {{-- Role badge — shows the active role so multi-role users know which context they're in --}}
                                @php
                                    $roleColors = [
                                        'author' => 'bg-blue-500/20 text-blue-200 border-blue-400/30',
                                        'reviewer' => 'bg-violet-500/20 text-violet-200 border-violet-400/30',
                                        'editor' => 'bg-amber-500/20 text-amber-200 border-amber-400/30',
                                        'editor-in-chief' => 'bg-orange-500/20 text-orange-200 border-orange-400/30',
                                        'admin' => 'bg-red-500/20 text-red-200 border-red-400/30',
                                    ];
                                    $badgeCls = $roleColors[$activeRole] ?? 'bg-white/10 text-white/60 border-white/20';
                                @endphp

                                <span
                                    class="ml-2 px-2.5 py-1 rounded-full border text-[9px] font-bold uppercase tracking-[.12em] {{ $badgeCls }}"
                                >
                                    {{ str_replace('-', ' ', $activeRole) }}
                                </span>
                            </div>
                        @endauth
                    </div>

                    <div class="flex items-center gap-4">
                        @auth
                            <div class="flex items-center gap-3">
                                <div
                                    class="hidden lg:flex flex-col items-end mr-2 text-right"
                                >
                                    <span
                                        class="text-[9px] font-bold text-[#f0d678] uppercase tracking-widest leading-none mb-1"
                                    >
                                        Authenticated
                                    </span>
                                    <span
                                        class="text-sm font-medium text-white/95 truncate max-w-[150px]"
                                    >
                                        {{ auth()->user()->name }}
                                    </span>
                                </div>

                                @php
                                    $userRoles = auth()->user()->roles()->pluck('name')->toArray();
                                @endphp

                                @if (count($userRoles) > 1)
                                    <div class="relative group">
                                        <button
                                            class="px-3 py-2 bg-white/10 text-white text-[11px] font-bold tracking-widest rounded-lg hover:bg-white/20 transition-all uppercase border border-white/20"
                                        >
                                            {{ ucfirst(str_replace('-', ' ', session('active_role', 'Switch Role'))) }} ▼
                                        </button>
                                        <div class="absolute right-0 mt-2 w-48 bg-[#1a4d46] border border-white/20 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                                            @foreach ($userRoles as $role)
                                                <a
                                                    href="{{ route('dashboard.switch-role', $role) }}"
                                                    class="block px-4 py-2 text-white text-sm {{ session('active_role') === $role ? 'bg-white/20 font-bold text-[#f0d678]' : 'hover:bg-white/10' }} {{ $loop->first ? 'rounded-t-lg' : '' }} {{ $loop->last ? 'rounded-b-lg' : '' }}"
                                                >
                                                    {{ str_replace('-', ' ', ucfirst($role)) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                                id="logout-form"
                            >
                                @csrf
                                <button
                                    type="button"
                                    onclick="confirmLogout()"
                                    class="px-5 py-2 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-[11px] font-bold tracking-widest rounded-full shadow-lg hover:shadow-[#a07830]/40 transition-all active:scale-95 uppercase border border-white/20"
                                >
                                    Logout
                                </button>
                            </form>
                        @else
                            <a
                                href="{{ url('/') }}"
                                class="text-sm font-bold text-white/90 hover:text-[#f0d678] transition-colors uppercase tracking-wider mr-4"
                            >
                                Home
                            </a>
                            <a
                                href="{{ route('login') }}"
                                class="text-sm font-bold text-white/90 hover:text-[#f0d678] transition-colors uppercase tracking-wider mr-4"
                            >
                                Login
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="px-6 py-2.5 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-sm font-bold tracking-wide rounded-xl shadow-lg hover:-translate-y-0.5 transition-all active:translate-y-0 border border-white/10"
                            >
                                REGISTER →
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="grow max-w-7xl mx-auto w-full py-12 px-4 sm:px-6 lg:px-8">
            <x-flash-messages />
            @yield('content')
        </main>

        <footer class="bg-[#1a4d46] text-white/70 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="md:col-span-2">
                        <h3
                            class="font-libre text-2xl font-bold text-white mb-4"
                        >
                            Journal System
                        </h3>
                        <p class="text-sm leading-relaxed max-w-md">
                            A centralized platform for scholarly publishing and
                            academic peer review.
                        </p>
                    </div>
                    <div>
                        <h4
                            class="text-[11px] font-bold text-[#f0d678] uppercase tracking-[0.2em] mb-6"
                        >
                            Portal Links
                        </h4>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <a
                                    href="{{ url('/') }}"
                                    class="hover:text-white transition-colors"
                                >
                                    Home
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="hover:text-white transition-colors"
                                >
                                    Journal Guidelines
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4
                            class="text-[11px] font-bold text-[#f0d678] uppercase tracking-[0.2em] mb-6"
                        >
                            Publication Info
                        </h4>
                        <p class="text-[10px] uppercase tracking-tighter">
                            © 2026 | All Rights Reserved
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            function confirmLogout() {
                Swal.fire({
                    title: '<span class="font-libre text-[#2D8176]">Confirm Sign Out</span>',
                    text: 'Are you sure you want to logout?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2D8176',
                    cancelButtonColor: '#a07830',
                    confirmButtonText: 'Yes, Sign Out',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            }
        </script>
        @stack('scripts')
    </body>
</html>
