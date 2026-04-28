<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Volume {{ $volume }} | Archive | Journal System</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * {
                box-sizing: border-box;
            }
            body {
                font-family: 'Source Sans 3', sans-serif;
                scroll-behavior: smooth;
            }
            .font-libre {
                font-family: 'Libre Baskerville', serif;
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
            @keyframes lpShimmer {
                0% {
                    background-position: -100% 0;
                }
                100% {
                    background-position: 100% 0;
                }
            }

            .papers-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 28px;
            }
            @media (max-width: 1024px) {
                .papers-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 22px;
                }
            }
            @media (max-width: 640px) {
                .papers-grid {
                    grid-template-columns: 1fr;
                    gap: 18px;
                }
            }

            .card-hover-depth {
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            @media (hover: hover) {
                .card-hover-depth:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 26px 52px rgba(13, 22, 40, 0.14);
                }
            }

            .card-actions {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            #scroll-top-btn {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                transform: translateY(100px);
                opacity: 0;
            }
            #scroll-top-btn.visible {
                transform: translateY(0);
                opacity: 1;
            }

            @media (max-width: 640px) {
                #scroll-top-btn {
                    bottom: 20px;
                    right: 16px;
                    width: 48px;
                    height: 48px;
                }
            }
        </style>
    </head>
    <body class="bg-[#f5f0e8] text-[#0d1628] antialiased overflow-x-hidden">
        {{-- Shimmer bar --}}
        <div class="h-1 w-full nav-shimmer sticky top-0 z-60"></div>

        {{-- Navbar --}}
        <nav
            class="bg-white/90 backdrop-blur-md border-b border-[#c9a84c]/20 sticky top-1 z-50"
        >
            <div
                class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between"
            >
                <a href="/" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 bg-[#2D8176] rounded-full flex items-center justify-center group-hover:rotate-12 transition-transform shrink-0"
                    >
                        <svg
                            class="text-[#f0d678] w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="font-libre text-xl font-bold text-[#2d8176]"
                        >
                            Journal System
                        </span>
                        <span
                            class="text-[9px] font-bold text-[#a07830] uppercase tracking-widest"
                        >
                            Academic Publishing Portal
                        </span>
                    </div>
                </a>
                <a
                    href="{{ route('archive') }}"
                    class="text-sm font-bold text-[#2d8176] hover:text-[#c9a84c] transition-colors flex items-center gap-1"
                >
                    ← Back to Archive
                </a>
            </div>
        </nav>

        {{-- Hero --}}
        <section
            class="relative bg-gradient-to-br from-[#2d8176] via-[#2a8f84] to-[#1a4d46] py-16 px-6 overflow-hidden"
        >
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg
                    class="w-full h-full"
                    viewBox="0 0 1000 400"
                    preserveAspectRatio="none"
                >
                    <defs>
                        <pattern
                            id="dots"
                            x="0"
                            y="0"
                            width="60"
                            height="60"
                            patternUnits="userSpaceOnUse"
                        >
                            <circle
                                cx="30"
                                cy="30"
                                r="1.5"
                                fill="white"
                                opacity="0.4"
                            />
                        </pattern>
                    </defs>
                    <rect width="1000" height="400" fill="url(#dots)" />
                </svg>
            </div>

            <div
                class="relative z-10 max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-8"
            >
                {{-- Cover image --}}
                @if ($coverImage)
                    <div
                        class="w-36 flex-shrink-0 rounded-xl overflow-hidden shadow-2xl border-2 border-white/20"
                    >
                        <img
                            src="{{ asset('storage/' . $coverImage) }}"
                            alt="Volume {{ $volume }} Cover"
                            class="w-full h-full object-cover"
                        />
                    </div>
                @endif

                <div class="text-left">
                    <p
                        class="text-[#f0d678] font-bold tracking-[0.25em] text-xs uppercase mb-3 flex items-center gap-2"
                    >
                        <svg
                            class="w-4 h-4 shrink-0"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"
                            />
                        </svg>
                        Archive Directory
                    </p>
                    <h1
                        class="font-libre text-4xl md:text-5xl font-bold text-white mb-3 leading-tight"
                    >
                        Volume {{ $volume }}
                    </h1>
                    <div
                        class="h-1 w-20 bg-gradient-to-r from-[#f0d678] to-transparent rounded-full mb-4"
                    ></div>
                    <p class="text-white/80 text-base font-medium">
                        {{ $papers->count() }}
                        {{ $papers->count() === 1 ? 'paper' : 'papers' }}
                        &nbsp;·&nbsp; {{ $issuesCount }}
                        {{ $issuesCount === 1 ? 'issue' : 'issues' }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Papers Grid --}}
        <section class="max-w-7xl mx-auto px-6 py-16">
            @if ($papers->count() > 0)
                <div class="papers-grid">
                    @foreach ($papers as $paper)
                        <div
                            class="card-hover-depth group bg-white rounded-2xl overflow-hidden border border-[#e0d8cc] shadow-sm flex flex-col"
                        >
                            {{-- Card header --}}
                            <div
                                class="relative h-36 bg-gradient-to-br from-[#2d8176] via-[#2a8675] to-[#c9a84c] flex items-center justify-center overflow-hidden"
                            >
                                <div
                                    class="absolute inset-0 opacity-20 pointer-events-none"
                                >
                                    <svg
                                        class="w-full h-full"
                                        viewBox="0 0 200 160"
                                        preserveAspectRatio="xMidYMid slice"
                                    >
                                        <defs>
                                            <linearGradient
                                                id="lp{{ $paper['id'] }}"
                                                x1="0%"
                                                y1="0%"
                                                x2="100%"
                                                y2="100%"
                                            >
                                                <stop
                                                    offset="0%"
                                                    style="
                                                        stop-color: white;
                                                        stop-opacity: 0.1;
                                                    "
                                                />
                                                <stop
                                                    offset="100%"
                                                    style="
                                                        stop-color: white;
                                                        stop-opacity: 0;
                                                    "
                                                />
                                            </linearGradient>
                                        </defs>
                                        <circle
                                            cx="180"
                                            cy="-20"
                                            r="80"
                                            fill="url(#lp{{ $paper['id'] }})"
                                        />
                                        <circle
                                            cx="20"
                                            cy="180"
                                            r="60"
                                            fill="url(#lp{{ $paper['id'] }})"
                                        />
                                    </svg>
                                </div>
                                <div class="relative z-10 text-center">
                                    <svg
                                        class="w-14 h-14 text-white/80 mx-auto mb-1 group-hover:scale-110 transition-transform duration-300"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    <p
                                        class="text-white/90 text-xs font-semibold tracking-wider uppercase"
                                    >
                                        Research Paper
                                    </p>
                                </div>
                                <div class="absolute top-3 right-3">
                                    <span
                                        class="px-2 py-1 bg-white/20 text-white text-[10px] font-bold uppercase tracking-widest rounded-full"
                                    >
                                        Issue {{ $paper['archiveIssue'] }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6 flex flex-col flex-1">
                                <h3
                                    class="font-libre text-lg font-bold text-[#2d8176] mb-3 leading-snug line-clamp-3 group-hover:text-[#c9a84c] transition-colors"
                                >
                                    {{ $paper['title'] }}
                                </h3>

                                <div
                                    class="flex items-center gap-2 mb-4 pb-4 border-b border-[#e0d8cc]"
                                >
                                    <svg
                                        class="w-4 h-4 text-[#c9a84c] shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                    <p
                                        class="text-sm text-[#6a7890] font-semibold truncate"
                                    >
                                        {{ $paper['author'] }}
                                    </p>
                                </div>

                                <p
                                    class="text-[#6a7890] text-sm mb-6 leading-relaxed line-clamp-3"
                                >
                                    {{ $paper['abstract'] }}
                                </p>

                                <div
                                    class="grid grid-cols-2 gap-3 mb-6 p-4 bg-[#f9f7f2] rounded-lg"
                                >
                                    <div class="text-center">
                                        <div
                                            class="text-lg font-libre font-bold text-[#2d8176]"
                                        >
                                            {{ number_format($paper['downloads']) }}
                                        </div>
                                        <div
                                            class="text-[10px] font-bold text-[#c9a84c] uppercase tracking-wider"
                                        >
                                            Downloads
                                        </div>
                                    </div>
                                    <div
                                        class="text-center border-l border-[#e0d8cc]"
                                    >
                                        <div
                                            class="text-lg font-libre font-bold text-[#2d8176]"
                                        >
                                            {{ $paper['publishedAt']?->format('M') ?? 'N/A' }}
                                        </div>
                                        <div
                                            class="text-[10px] font-bold text-[#c9a84c] uppercase tracking-wider"
                                        >
                                            {{ $paper['publishedAt']?->format('Y') ?? '' }}
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="text-[11px] text-[#a7b1c7] mb-5 font-medium flex items-center gap-2"
                                >
                                    <svg
                                        class="w-3.5 h-3.5 shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    Published
                                    {{ $paper['publishedAt']?->format('M d, Y') ?? 'N/A' }}
                                </div>

                                <div class="card-actions mt-auto">
                                    <a
                                        href="{{ route('papers.show', ['submission' => $paper['id']]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-5 py-3.5 bg-gradient-to-r from-[#2D8176] to-[#1a4d46] text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group-hover:from-[#c9a84c] group-hover:to-[#a07830]"
                                    >
                                        <span>Read Full Article</span>
                                        <svg
                                            class="w-4 h-4 shrink-0 group-hover:translate-x-1 transition-transform"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                                            />
                                        </svg>
                                    </a>

                                    <a
                                        href="{{ route('papers.download-ris', ['submission' => $paper['id']]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-5 py-2.5 bg-white border-2 border-[#c9a84c] text-[#c9a84c] rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#c9a84c] hover:text-white transition-all duration-200"
                                        title="Export citation (RIS)"
                                    >
                                        <svg
                                            class="w-4 h-4 shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm8-5.5V5a2 2 0 00-2-2H6a2 2 0 00-2 2v6.5"
                                            />
                                        </svg>
                                        <span>Export Citation</span>
                                    </a>

                                    <a
                                        href="{{ route('papers.download', ['submission' => $paper['id']]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-5 py-2.5 bg-white border-2 border-[#2D8176] text-[#2D8176] rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#2D8176] hover:text-white transition-all duration-200"
                                        title="Download PDF"
                                    >
                                        <svg
                                            class="w-4 h-4 shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                            />
                                        </svg>
                                        <span>Download PDF</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-24">
                    <div class="text-7xl mb-6">📚</div>
                    <h3
                        class="font-libre text-2xl font-bold text-[#2D8176] mb-3"
                    >
                        No Papers Found
                    </h3>
                    <p class="text-[#6a7890] mb-8">
                        No papers found for this volume.
                    </p>
                    <a
                        href="{{ route('archive') }}"
                        class="inline-block px-8 py-3 bg-[#2D8176] text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:-translate-y-1 transition-all shadow-lg"
                    >
                        Back to Archive
                    </a>
                </div>
            @endif
        </section>

        {{-- Footer --}}
        <footer
            class="bg-gradient-to-r from-[#1a4d46] to-[#0d2a25] text-[#ede5d5]/70 py-14 px-6 border-t-2 border-[#c9a84c]/20"
        >
            <div class="max-w-7xl mx-auto text-center">
                <h3 class="font-libre text-2xl font-bold text-white mb-2">
                    Journal System
                </h3>
                <p
                    class="text-[10px] font-bold uppercase tracking-[0.3em] mb-5 text-[#f0d678]"
                >
                    Advancing Knowledge • Inspiring Innovation
                </p>
                <div
                    class="h-1 w-20 bg-gradient-to-r from-[#c9a84c] to-transparent mx-auto mb-6"
                ></div>
                <p class="text-[10px] font-semibold uppercase tracking-wider">
                    © 2026 Academic Publishing Portal • All Rights Reserved
                </p>
            </div>
        </footer>

        {{-- Scroll to top --}}
        <button
            id="scroll-top-btn"
            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-10 right-10 w-16 h-16 bg-white shadow-2xl rounded-full z-50 flex items-center justify-center group"
        >
            <svg
                class="w-6 h-6 text-[#2D8176] group-hover:-translate-y-1 transition-transform z-10"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 15l7-7 7 7"
                />
            </svg>
            <svg class="absolute inset-0 w-full h-full -rotate-90">
                <circle
                    cx="32"
                    cy="32"
                    r="30"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="transparent"
                    class="text-slate-100"
                />
                <circle
                    id="progress-circle"
                    cx="32"
                    cy="32"
                    r="30"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="transparent"
                    class="text-[#c9a84c]"
                    stroke-dasharray="188.4"
                    stroke-dashoffset="188.4"
                />
            </svg>
        </button>

        <script>
            const btn = document.getElementById('scroll-top-btn');
            const progressCircle = document.getElementById('progress-circle');
            const circumference = 188.4;

            window.onscroll = function () {
                const scrollTop = window.scrollY;
                const docHeight =
                    document.documentElement.scrollHeight - window.innerHeight;
                const scrolled = scrollTop / docHeight;
                btn.classList.toggle('visible', scrolled > 0.2);
                progressCircle.style.strokeDashoffset =
                    circumference - scrolled * circumference;
            };
        </script>
    </body>
</html>
