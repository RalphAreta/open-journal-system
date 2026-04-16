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
            @keyframes pulse-subtle {
                0%,
                100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.85;
                }
            }
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-8px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
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

            /* ── Mobile menu slide-down ── */
            .mobile-menu[data-open='true'] {
                display: block;
                animation: slideDown 0.22s ease forwards;
            }
            .mobile-menu[data-open='false'] {
                display: none;
            }

            /* ── Enhanced Form Elements ── */
            input[type='text'],
            input[type='email'],
            input[type='password'],
            input[type='number'],
            input[type='date'],
            input[type='time'],
            textarea,
            select {
                transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
                border-color: #d1cfc8 !important;
            }
            input:focus,
            textarea:focus,
            select:focus {
                border-color: #2d8176 !important;
                box-shadow:
                    0 0 0 3px rgba(45, 129, 118, 0.1),
                    0 4px 12px rgba(45, 129, 118, 0.15) !important;
                outline: none !important;
            }

            /* ── Buttons ── */
            .btn-primary {
                transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
                box-shadow: 0 4px 14px rgba(45, 129, 118, 0.25);
                position: relative;
                overflow: hidden;
            }
            .btn-primary::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: translate(-50%, -50%);
                transition: all 0.5s ease;
            }
            .btn-primary:hover::before {
                width: 300px;
                height: 300px;
            }
            .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 12px 28px rgba(45, 129, 118, 0.35);
            }

            /* ── Badges ── */
            .badge {
                transition: all 0.25s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }
            .badge-success {
                background: linear-gradient(
                    135deg,
                    #f0fdf4,
                    #ecfdf5
                ) !important;
                border: 1.5px solid #86efac !important;
                color: #166534 !important;
                box-shadow: 0 2px 8px rgba(34, 197, 94, 0.12);
            }
            .badge-danger {
                background: linear-gradient(
                    135deg,
                    #fef2f2,
                    #fef1f1
                ) !important;
                border: 1.5px solid #fca5a5 !important;
                color: #991b1b !important;
                box-shadow: 0 2px 8px rgba(239, 68, 68, 0.12);
            }
            .badge-warning {
                background: linear-gradient(
                    135deg,
                    #fffbeb,
                    #fef3c7
                ) !important;
                border: 1.5px solid #fce181 !important;
                color: #b45309 !important;
                box-shadow: 0 2px 8px rgba(217, 119, 6, 0.12);
            }
            .badge-info {
                background: linear-gradient(
                    135deg,
                    #f0f9ff,
                    #e0f2fe
                ) !important;
                border: 1.5px solid #7dd3fc !important;
                color: #0e7490 !important;
                box-shadow: 0 2px 8px rgba(6, 182, 212, 0.12);
            }
            .badge:hover {
                transform: translateY(-2px);
            }

            /* ── Cards ── */
            .card {
                transition: all 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
                border-color: #e8dfd0 !important;
                border-width: 1.5px;
            }
            .card:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 48px rgba(45, 129, 118, 0.12) !important;
                border-color: rgba(45, 129, 118, 0.3) !important;
            }

            /* ── Alerts ── */
            .alert {
                border-radius: 12px;
                border-width: 1.5px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                transition: all 0.25s ease;
            }
            .alert-success {
                background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
                border-color: #86efac;
                color: #166534;
            }
            .alert-danger {
                background: linear-gradient(135deg, #fef2f2, #fef1f1);
                border-color: #fca5a5;
                color: #991b1b;
            }
            .alert-warning {
                background: linear-gradient(135deg, #fffbeb, #fef3c7);
                border-color: #fce181;
                color: #b45309;
            }

            /* ── Table rows ── */
            .table tbody tr {
                transition: all 0.2s ease;
                border-bottom-color: #e8dfd0 !important;
            }
            .table tbody tr:hover {
                background-color: #f9f6f0 !important;
                box-shadow: inset 4px 0 0 0 #2d8176;
            }

            /* ── Spinner ── */
            .spinner-pulse {
                animation: pulse-subtle 2s ease-in-out infinite;
            }

            /* ── Notification dropdown responsive ── */
            @media (max-width: 480px) {
                #notification-dropdown {
                    width: calc(100vw - 2rem) !important;
                    right: -4rem !important;
                }
            }

            /* ── Safe-area for notched phones ── */
            @supports (padding: env(safe-area-inset-bottom)) {
                footer {
                    padding-bottom: max(2rem, env(safe-area-inset-bottom));
                }
            }

            /* ── Hamburger icon morph ── */
            .ham-line {
                display: block;
                width: 22px;
                height: 2px;
                background: #fff;
                border-radius: 2px;
                transition:
                    transform 0.25s ease,
                    opacity 0.2s ease;
            }
            .ham-open .ham-line:nth-child(1) {
                transform: translateY(6px) rotate(45deg);
            }
            .ham-open .ham-line:nth-child(2) {
                opacity: 0;
            }
            .ham-open .ham-line:nth-child(3) {
                transform: translateY(-6px) rotate(-45deg);
            }

            /* ── FIX: Ensure nav always stays on top of page content ── */
            #main-navbar {
                position: sticky;
                top: 3px;
                z-index: 999 !important;
            }
            #nav-shimmer-bar {
                position: sticky;
                top: 0;
                z-index: 1000 !important;
            }
        </style>
        @stack('styles')
    </head>

    <body
        class="min-h-screen bg-[#f5f0e8] text-[#0d1628] font-source antialiased flex flex-col"
    >
        {{-- ── Shimmer top bar ── --}}
        <div id="nav-shimmer-bar" class="h-[3px] w-full nav-shimmer"></div>

        {{--
            ═══════════════════════════════════════
            NAVIGATION
            ═══════════════════════════════════════
        --}}
        <nav
            id="main-navbar"
            class="bg-[#2D8176] shadow-xl border-b border-white/10"
            x-data="{ mobileOpen: false, notifOpen: false }"
        >
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 md:h-20">
                    {{-- ── Left: Logo + Desktop Nav ── --}}
                    <div class="flex items-center gap-3 md:gap-6 min-w-0">
                        {{-- Logo --}}
                        <a
                            href="{{ url('/') }}"
                            class="flex items-center space-x-2.5 group transition-all shrink-0"
                        >
                            <div
                                class="relative w-9 h-9 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-[#c9a84c] to-[#a07830] rounded-full border-2 border-white/30 shadow-inner group-hover:rotate-12 transition-transform duration-500"
                            >
                                <svg
                                    class="text-white w-5 h-5 md:w-7 md:h-7"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                    />
                                </svg>
                            </div>
                            <div class="flex flex-col leading-none">
                                <span
                                    class="font-libre text-base sm:text-xl md:text-2xl font-bold text-white tracking-tight"
                                >
                                    Journal System
                                </span>
                                <span
                                    class="hidden sm:block text-[8px] md:text-[9px] font-bold text-[#f0d678] tracking-[0.2em] uppercase opacity-90 mt-0.5"
                                >
                                    Academic Publishing Portal
                                </span>
                            </div>
                        </a>

                        {{-- Desktop nav links --}}
                        @auth
                            @php
                                $activeRole = session('active_role');
                                if (! $activeRole) {
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
                                $linkBase = 'px-3 py-2 rounded-lg text-[12px] font-semibold tracking-wide transition-all duration-300 ';
                                $inactive = 'text-white/80 hover:text-[#f0d678] hover:bg-black/10';
                            @endphp

                            <div
                                class="hidden md:flex items-center space-x-1 ml-4 border-l border-white/10 pl-4"
                            >
                                <a
                                    href="{{ route('dashboard') }}"
                                    class="{{ $linkBase . $inactive }}"
                                >
                                    DASHBOARD
                                </a>

                                @if ($activeRole === 'author')
                                    <a
                                        href="{{ route('submissions.index') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        SUBMISSIONS
                                    </a>
                                @endif

                                @if ($activeRole === 'reviewer')
                                    <a
                                        href="{{ route('reviews.index') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        REVIEWS
                                    </a>
                                @endif

                                @if ($activeRole === 'editor')
                                    <a
                                        href="{{ route('editor.submissions') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        EDITORIAL
                                    </a>
                                @endif

                                @if ($activeRole === 'editor-in-chief')
                                    @if (Route::has('appeals.index'))
                                        <a
                                            href="{{ route('appeals.index') }}"
                                            class="{{ $linkBase . $inactive }}"
                                        >
                                            APPEALS
                                        </a>
                                    @endif
                                @endif

                                @if ($activeRole === 'admin')
                                    <a
                                        href="{{ route('admin.users.index') }}"
                                        class="{{ $linkBase . $inactive }}"
                                    >
                                        MANAGEMENT
                                    </a>
                                @endif
                            </div>
                        @endauth
                    </div>

                    {{-- ── Right: Actions ── --}}
                    <div class="flex items-center gap-1.5 sm:gap-3">
                        @auth
                            @php
                                $activeRole =
                                    session('active_role') ??
                                    (optional(
                                        auth()
                                            ->user()
                                            ->roles->first(),
                                    )->name ??
                                        'author');
                                $userRoles = auth()
                                    ->user()
                                    ->roles()
                                    ->pluck('name')
                                    ->toArray();

                                $unreadQuery = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at');
                                if ($activeRole) {
                                    $unreadQuery->where(function ($q) use ($activeRole) {
                                        $q->where('role', $activeRole)->orWhereNull('role');
                                    });
                                }
                                $unreadCount = $unreadQuery->count();

                                $notifQuery = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at');
                                if ($activeRole) {
                                    $notifQuery->where(function ($q) use ($activeRole) {
                                        $q->where('role', $activeRole)->orWhereNull('role');
                                    });
                                }
                                $unreadNotifs = $notifQuery
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp

                            {{-- Desktop: user name + role switcher --}}
                            <div
                                class="hidden lg:flex flex-col items-end mr-1 text-right"
                            >
                                <span
                                    class="text-[9px] font-bold text-[#f0d678] uppercase tracking-widest leading-none mb-1"
                                >
                                    Authenticated
                                </span>
                                <span
                                    class="text-sm font-medium text-white/95 truncate max-w-[9rem]"
                                >
                                    {{ auth()->user()->name }}
                                </span>
                            </div>

                            {{-- Role switcher — desktop only --}}
                            @if (count($userRoles) > 1)
                                <div
                                    class="relative hidden md:block group"
                                    style="z-index: 1001"
                                >
                                    <button
                                        class="px-3 py-1.5 bg-white/10 text-white text-[11px] font-bold tracking-widest rounded-lg hover:bg-white/20 transition-all uppercase border border-white/20 whitespace-nowrap"
                                    >
                                        {{ ucfirst(str_replace('-', ' ', $activeRole)) }}
                                        ▼
                                    </button>
                                    <div
                                        class="absolute right-0 mt-2 w-48 bg-[#1a4d46] border border-white/20 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all"
                                        style="z-index: 1002"
                                    >
                                        @foreach ($userRoles as $role)
                                            <a
                                                href="{{ route('dashboard.switch-role', $role) }}"
                                                class="block px-4 py-2.5 text-white text-sm {{ session('active_role') === $role ? 'bg-white/20 font-bold text-[#f0d678]' : 'hover:bg-white/10' }} {{ $loop->first ? 'rounded-t-lg' : '' }} {{ $loop->last ? 'rounded-b-lg' : '' }}"
                                            >
                                                {{ str_replace('-', ' ', ucfirst($role)) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Notification Bell --}}
                            <div
                                class="relative"
                                id="notification-bell-wrapper"
                                style="z-index: 1001"
                                x-data="{ open: false }"
                                @mouseenter="open = true; markRead()"
                                @mouseleave="open = false"
                                @click.outside="open = false"
                            >
                                <button
                                    id="notification-bell-btn"
                                    class="relative p-2 text-white/80 hover:text-white transition-colors min-w-[2.5rem] min-h-[2.5rem] flex items-center justify-center"
                                    @click="open = !open; if(open) markRead()"
                                >
                                    <svg
                                        class="w-5 h-5 md:w-6 md:h-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                        />
                                    </svg>
                                    @if ($unreadCount > 0)
                                        <span
                                            id="notification-badge"
                                            class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center"
                                        >
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </button>

                                {{-- Dropdown --}}
                                <div
                                    id="notification-dropdown"
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-2"
                                    class="absolute right-0 mt-2 w-80 bg-white border border-[#ede8e0] rounded-2xl shadow-2xl overflow-hidden"
                                    style="z-index: 1002; display: none"
                                >
                                    <div
                                        class="px-4 py-3 border-b border-[#ede8e0] bg-[#faf8f5] flex items-center justify-between"
                                    >
                                        <p
                                            class="text-[10px] font-black uppercase tracking-widest text-[#2D8176]"
                                        >
                                            Notifications
                                        </p>
                                    </div>

                                    <div
                                        id="notification-list"
                                        class="max-h-[60vh] overflow-y-auto"
                                    >
                                        @forelse ($unreadNotifs as $notif)
                                            <div
                                                class="px-4 py-3 border-b border-[#f0ece6] hover:bg-[#faf8f5] transition-colors bg-blue-50/50 notification-item"
                                            >
                                                <div
                                                    class="flex items-start gap-3"
                                                >
                                                    <div
                                                        class="shrink-0 mt-1.5"
                                                    >
                                                        @if ($notif->type === 'success')
                                                            <span
                                                                class="w-2 h-2 rounded-full bg-emerald-500 block"
                                                            ></span>
                                                        @elseif ($notif->type === 'danger' || $notif->type === 'error')
                                                            <span
                                                                class="w-2 h-2 rounded-full bg-red-500 block"
                                                            ></span>
                                                        @elseif ($notif->type === 'warning')
                                                            <span
                                                                class="w-2 h-2 rounded-full bg-amber-500 block"
                                                            ></span>
                                                        @else
                                                            <span
                                                                class="w-2 h-2 rounded-full bg-blue-500 block"
                                                            ></span>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p
                                                            class="text-[12px] font-bold text-[#0d1628] leading-snug"
                                                        >
                                                            {{ $notif->title }}
                                                        </p>
                                                        <p
                                                            class="text-[11px] text-[#6a7890] mt-0.5 leading-relaxed"
                                                        >
                                                            {{ Str::limit($notif->message, 80) }}
                                                        </p>
                                                        <p
                                                            class="text-[9px] text-[#b0aaa0] mt-1"
                                                        >
                                                            {{ $notif->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="px-4 py-8 text-center">
                                                <svg
                                                    class="w-8 h-8 text-[#d0ccc5] mx-auto mb-2"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                                    />
                                                </svg>
                                                <p
                                                    class="text-[12px] text-[#b0aaa0]"
                                                >
                                                    No new notifications
                                                </p>
                                            </div>
                                        @endforelse
                                    </div>

                                    <div
                                        class="px-4 py-2.5 bg-[#faf8f5] text-center border-t border-[#ede8e0]"
                                    >
                                        <a
                                            href="{{ route('notifications.index') }}"
                                            class="text-[10px] font-black uppercase tracking-widest text-[#2D8176] hover:text-[#1f5d54] transition-colors"
                                        >
                                            View All →
                                        </a>
                                    </div>
                                </div>

                                <script>
                                    function markRead() {
                                        fetch(
                                            '{{ route('notifications.markAllRead') }}',
                                            {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type':
                                                        'application/json',
                                                    'X-CSRF-TOKEN': document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]',
                                                        )
                                                        .getAttribute(
                                                            'content',
                                                        ),
                                                    Accept: 'application/json',
                                                },
                                                body: JSON.stringify({}),
                                            },
                                        )
                                            .then((r) => r.json())
                                            .then((data) => {
                                                const badge =
                                                    document.getElementById(
                                                        'notification-badge',
                                                    );
                                                if (
                                                    badge &&
                                                    data.unread_count === 0
                                                )
                                                    badge.remove();
                                                document
                                                    .querySelectorAll(
                                                        '.notification-item',
                                                    )
                                                    .forEach((i) =>
                                                        i.classList.remove(
                                                            'bg-blue-50/50',
                                                        ),
                                                    );
                                            })
                                            .catch(console.error);
                                    }

                                    /* Poll for new notifications every 10 s */
                                    setInterval(() => {
                                        fetch(
                                            '{{ route('notifications.unreadCount') }}',
                                        )
                                            .then((r) => r.json())
                                            .then((data) => {
                                                const badge =
                                                    document.getElementById(
                                                        'notification-badge',
                                                    );
                                                const count = data.unread_count;
                                                if (count > 0) {
                                                    if (!badge) {
                                                        const btn =
                                                            document.getElementById(
                                                                'notification-bell-btn',
                                                            );
                                                        const newBadge =
                                                            document.createElement(
                                                                'span',
                                                            );
                                                        newBadge.id =
                                                            'notification-badge';
                                                        newBadge.className =
                                                            'absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center';
                                                        newBadge.textContent =
                                                            count;
                                                        btn.appendChild(
                                                            newBadge,
                                                        );
                                                    } else {
                                                        badge.textContent =
                                                            count;
                                                    }
                                                } else if (badge) {
                                                    badge.remove();
                                                }
                                            })
                                            .catch(console.error);
                                    }, 10000);
                                </script>
                            </div>

                            {{-- Logout — desktop: pill, mobile: icon button --}}
                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                                id="logout-form"
                            >
                                @csrf
                                {{-- Desktop pill --}}
                                <button
                                    type="button"
                                    onclick="confirmLogout()"
                                    class="hidden sm:inline-flex items-center px-4 py-1.5 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-[11px] font-bold tracking-widest rounded-full shadow-lg hover:shadow-[#a07830]/40 transition-all active:scale-95 uppercase border border-white/20"
                                >
                                    Logout
                                </button>
                                {{-- Mobile icon --}}
                                <button
                                    type="button"
                                    onclick="confirmLogout()"
                                    class="sm:hidden flex items-center justify-center w-9 h-9 bg-white/10 hover:bg-white/20 rounded-lg text-white/80 hover:text-white transition-all border border-white/15"
                                    aria-label="Logout"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                        />
                                    </svg>
                                </button>
                            </form>

                            {{-- Hamburger (mobile only, auth) --}}
                            <button
                                id="hamburger-btn"
                                class="md:hidden flex flex-col items-center justify-center gap-[5px] w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 transition-all border border-white/15 ml-0.5"
                                aria-label="Toggle menu"
                                onclick="toggleMobileMenu()"
                            >
                                <span class="ham-line"></span>
                                <span class="ham-line"></span>
                                <span class="ham-line"></span>
                            </button>
                        @else
                            {{-- ── Guest actions ── --}}

                            <a
                                href="{{ url('/') }}"
                                class="hidden sm:block text-sm font-bold text-white/90 hover:text-[#f0d678] transition-colors uppercase tracking-wider mr-1"
                            >
                                Home
                            </a>

                            @if (! Route::is('login'))
                                <a
                                    href="{{ route('login') }}"
                                    class="hidden sm:inline-flex px-4 sm:px-6 py-2 sm:py-2.5 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-xs sm:text-sm font-bold tracking-wide rounded-xl shadow-lg hover:-translate-y-0.5 transition-all active:translate-y-0 border border-white/10"
                                >
                                    LOGIN →
                                </a>
                            @endif

                            @if (! Route::is('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="hidden sm:inline-flex px-6 py-2.5 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-sm font-bold tracking-wide rounded-xl shadow-lg hover:-translate-y-0.5 transition-all active:translate-y-0 border border-white/10"
                                >
                                    REGISTER →
                                </a>
                            @endif

                            {{-- Guest hamburger — mobile only --}}
                            <button
                                id="guest-hamburger-btn"
                                class="sm:hidden flex flex-col items-center justify-center gap-[5px] w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 transition-all border border-white/15"
                                aria-label="Toggle menu"
                                onclick="toggleGuestMenu()"
                            >
                                <span class="ham-line"></span>
                                <span class="ham-line"></span>
                                <span class="ham-line"></span>
                            </button>
                        @endauth
                    </div>
                </div>
            </div>

            {{--
                ══════════════════════════════════
                MOBILE MENU DRAWER — GUEST
                ══════════════════════════════════
            --}}
            @guest
                <div
                    id="guest-mobile-menu"
                    class="mobile-menu sm:hidden border-t border-white/10 bg-[#236b61]"
                    data-open="false"
                >
                    <div class="max-w-7xl mx-auto px-4 py-4 space-y-1.5">
                        <a
                            href="{{ url('/') }}"
                            class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold text-white/90 hover:text-white hover:bg-white/10 transition-all"
                            onclick="toggleGuestMenu()"
                        >
                            <svg
                                class="w-4 h-4 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                />
                            </svg>
                            Home
                        </a>

                        @if (! Route::is('login'))
                            <a
                                href="{{ route('login') }}"
                                class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold text-white/90 hover:text-white hover:bg-white/10 transition-all"
                                onclick="toggleGuestMenu()"
                            >
                                <svg
                                    class="w-4 h-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                                    />
                                </svg>
                                Sign In
                            </a>
                        @endif

                        @if (! Route::is('register'))
                            <a
                                href="{{ route('register') }}"
                                class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold text-[#f0d678] hover:text-white bg-white/8 hover:bg-white/15 transition-all border border-[#c9a84c]/30"
                                onclick="toggleGuestMenu()"
                            >
                                <svg
                                    class="w-4 h-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                                    />
                                </svg>
                                Create Account
                            </a>
                        @endif
                    </div>
                </div>
            @endguest

            {{--
                ══════════════════════════════════
                MOBILE MENU DRAWER (auth only)
                ══════════════════════════════════
            --}}
            @auth
                <div
                    id="mobile-menu"
                    class="mobile-menu md:hidden border-t border-white/10 bg-[#236b61]"
                    data-open="false"
                >
                    <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
                        {{-- User info strip --}}
                        <div
                            class="flex items-center gap-3 px-3 py-3 mb-3 bg-white/10 rounded-xl border border-white/10"
                        >
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-br from-[#c9a84c] to-[#a07830] flex items-center justify-center shrink-0 text-white font-bold text-sm"
                            >
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p
                                    class="text-white font-semibold text-sm truncate"
                                >
                                    {{ auth()->user()->name }}
                                </p>
                                <p
                                    class="text-[#f0d678] text-[10px] uppercase tracking-widest font-bold"
                                >
                                    {{ str_replace('-', ' ', ucfirst($activeRole)) }}
                                </p>
                            </div>
                        </div>

                        {{-- Nav links --}}
                        @php
                            $mLink = 'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold
                                                                                              text-white/90 hover:text-white hover:bg-white/10 transition-all tracking-wide';
                        @endphp

                        <a
                            href="{{ route('dashboard') }}"
                            class="{{ $mLink }}"
                        >
                            <svg
                                class="w-4 h-4 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect
                                    x="14"
                                    y="3"
                                    width="7"
                                    height="7"
                                    rx="1"
                                />
                                <rect
                                    x="3"
                                    y="14"
                                    width="7"
                                    height="7"
                                    rx="1"
                                />
                                <rect
                                    x="14"
                                    y="14"
                                    width="7"
                                    height="7"
                                    rx="1"
                                />
                            </svg>
                            Dashboard
                        </a>

                        @if ($activeRole === 'author')
                            <a
                                href="{{ route('submissions.index') }}"
                                class="{{ $mLink }}"
                            >
                                <svg
                                    class="w-4 h-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                                Submissions
                            </a>
                        @endif

                        @if ($activeRole === 'reviewer')
                            <a
                                href="{{ route('reviews.index') }}"
                                class="{{ $mLink }}"
                            >
                                <svg
                                    class="w-4 h-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                    />
                                </svg>
                                Reviews
                            </a>
                        @endif

                        @if ($activeRole === 'editor')
                            <a
                                href="{{ route('editor.submissions') }}"
                                class="{{ $mLink }}"
                            >
                                <svg
                                    class="w-4 h-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    />
                                </svg>
                                Editorial
                            </a>
                        @endif

                        @if ($activeRole === 'editor-in-chief' && Route::has('appeals.index'))
                            <a
                                href="{{ route('appeals.index') }}"
                                class="{{ $mLink }}"
                            >
                                <svg
                                    class="w-4 h-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"
                                    />
                                </svg>
                                Appeals
                            </a>
                        @endif

                        @if ($activeRole === 'admin')
                            <a
                                href="{{ route('admin.users.index') }}"
                                class="{{ $mLink }}"
                            >
                                <svg
                                    class="w-4 h-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                    />
                                </svg>
                                Management
                            </a>
                        @endif

                        {{-- Role switcher (mobile) --}}
                        @php
                            $userRoles = auth()
                                ->user()
                                ->roles()
                                ->pluck('name')
                                ->toArray();
                        @endphp

                        @if (count($userRoles) > 1)
                            <div class="pt-3 mt-3 border-t border-white/10">
                                <p
                                    class="px-3 mb-2 text-[9px] font-black uppercase tracking-[.2em] text-[#f0d678]"
                                >
                                    Switch Role
                                </p>
                                <div class="grid grid-cols-2 gap-1.5">
                                    @foreach ($userRoles as $role)
                                        <a
                                            href="{{ route('dashboard.switch-role', $role) }}"
                                            class="px-3 py-2.5 rounded-xl text-center text-xs font-semibold transition-all border {{
                                                session('active_role') === $role
                                                    ? 'bg-[#c9a84c]/20 border-[#c9a84c]/50 text-[#f0d678] font-bold'
                                                    : 'bg-white/8 border-white/15 text-white/80 hover:bg-white/15 hover:text-white'
                                            }}"
                                        >
                                            {{ str_replace('-', ' ', ucfirst($role)) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Mobile logout --}}
                        <div class="pt-3 mt-2 border-t border-white/10">
                            <button
                                type="button"
                                onclick="confirmLogout()"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-red-300 hover:text-red-200 hover:bg-red-500/10 transition-all"
                            >
                                <svg
                                    class="w-4 h-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                    />
                                </svg>
                                Sign Out
                            </button>
                        </div>
                    </div>
                </div>
            @endauth
        </nav>

        {{--
            ══════════════════════════════════════
            MAIN CONTENT
            ══════════════════════════════════════
        --}}
        <main
            class="grow max-w-7xl mx-auto w-full py-6 md:py-12 px-3 sm:px-6 lg:px-8"
        >
            <x-flash-messages />
            @yield('content')
        </main>

        {{--
            ══════════════════════════════════════
            FOOTER
            ══════════════════════════════════════
        --}}
        <footer class="bg-[#1a4d46] text-white/70 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 md:gap-12"
                >
                    <div class="sm:col-span-2">
                        <h3
                            class="font-libre text-xl md:text-2xl font-bold text-white mb-3 md:mb-4"
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
                            class="text-[11px] font-bold text-[#f0d678] uppercase tracking-[0.2em] mb-4 md:mb-6"
                        >
                            Portal Links
                        </h4>
                        <ul class="space-y-2.5 md:space-y-3 text-sm">
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
                            class="text-[11px] font-bold text-[#f0d678] uppercase tracking-[0.2em] mb-4 md:mb-6"
                        >
                            Publication Info
                        </h4>
                        <p class="text-[10px] uppercase tracking-tighter">
                            © {{ date('Y') }} | All Rights Reserved
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        {{-- ══ Scripts ══ --}}
        <script>
            /* ── Logout confirm ── */
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
                    if (result.isConfirmed)
                        document.getElementById('logout-form').submit();
                });
            }

            /* ── Auth hamburger ── */
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburger = document.getElementById('hamburger-btn');

            function toggleMobileMenu(forceClose = false) {
                if (!mobileMenu || !hamburger) return;
                const isOpen = mobileMenu.dataset.open === 'true';
                const next = forceClose ? false : !isOpen;
                mobileMenu.dataset.open = next;
                hamburger.classList.toggle('ham-open', next);
                document.body.style.overflow = next ? 'hidden' : '';
            }

            /* ── Guest hamburger ── */
            const guestMenu = document.getElementById('guest-mobile-menu');
            const guestHamburger = document.getElementById(
                'guest-hamburger-btn',
            );

            function toggleGuestMenu(forceClose = false) {
                if (!guestMenu || !guestHamburger) return;
                const isOpen = guestMenu.dataset.open === 'true';
                const next = forceClose ? false : !isOpen;
                guestMenu.dataset.open = next;
                guestHamburger.classList.toggle('ham-open', next);
                document.body.style.overflow = next ? 'hidden' : '';
            }

            /* Close both menus on resize to sm+ (guest) / md+ (auth) */
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) toggleMobileMenu(true);
                if (window.innerWidth >= 640) toggleGuestMenu(true);
            });

            /* Close auth menu when a link inside it is tapped */
            mobileMenu?.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => toggleMobileMenu(true));
            });
        </script>
        <script
            defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
        ></script>
        @stack('scripts')
    </body>
</html>
