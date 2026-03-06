<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Published Papers | Journal System</title>

        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
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

            .card-hover-depth {
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .card-hover-depth:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(45, 129, 118, 0.15);
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
        </style>
    </head>
    <body class="bg-[#f5f0e8] text-[#0d1628] antialiased overflow-x-hidden">
        <div class="h-0.75 w-full nav-shimmer sticky top-0 z-60"></div>

        <nav
            class="bg-white/90 backdrop-blur-md border-b border-[#c9a84c]/20 sticky top-0.75 z-50"
        >
            <div
                class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center"
            >
                <a href="/" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 flex items-center justify-center bg-[#2D8176] rounded-full border border-[#c9a84c]/30 shadow-sm group-hover:rotate-12 transition-transform"
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
                            ></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="font-libre text-xl font-bold text-[#2D8176] leading-none"
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
                <div class="hidden md:flex items-center gap-8">
                    <a
                        href="/published-papers"
                        class="text-sm font-bold text-[#2D8176] hover:text-[#c9a84c] transition-colors"
                    >
                        Published Papers
                    </a>
                    <a
                        href="/login"
                        class="text-sm font-bold text-[#2D8176] hover:text-[#c9a84c] transition-colors"
                    >
                        Login
                    </a>
                    <a
                        href="/register"
                        class="bg-linear-to-br from-[#c9a84c] to-[#a07830] text-white px-7 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-[#a07830]/20 hover:-translate-y-0.5 transition-all"
                    >
                        Register
                    </a>
                </div>
            </div>
        </nav>

        <!-- HEADER SECTION -->
        <section
            class="relative h-96 flex items-center justify-center text-center px-4 overflow-hidden bg-[#2D8176]"
        >
            <div class="absolute inset-0 hero-overlay"></div>

            <div class="relative z-10 max-w-4xl">
                <h1
                    class="font-libre text-5xl md:text-6xl font-bold text-white tracking-tight mb-4 drop-shadow-xl"
                >
                    Published Papers
                </h1>
                <p
                    class="text-[#f0d678] font-bold tracking-[0.2em] mb-6 text-sm md:text-base uppercase opacity-90"
                >
                    Peer-Reviewed Research from Our Journal
                </p>
                <p class="text-white/85 text-lg max-w-2xl mx-auto">
                    Explore cutting-edge research published in our journal. All papers have been rigorously reviewed and peer-validated.
                </p>
            </div>
        </section>

        <!-- PAPERS LISTING SECTION -->
        <section class="py-20 max-w-7xl mx-auto px-6">
            <div class="mb-12">
                <h2 class="font-libre text-3xl md:text-4xl font-bold text-[#2D8176] mb-2">
                    All Published Research
                </h2>
                <p class="text-sm text-[#6a7890] font-medium">
                    Displaying {{ count($papers) }} paper(s) on this page
                </p>
            </div>

            @if ($papers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($papers as $paper)
                        <!-- Paper Card -->
                        <div
                            class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#e0d8cc] shadow-sm"
                        >
                            <div
                                class="h-32 bg-linear-to-br from-[#2D8176]/20 to-[#c9a84c]/20 flex items-center justify-center"
                            >
                                <div class="text-5xl">📄</div>
                            </div>
                            <div class="p-6">
                                <!-- Category Badge -->
                                <div class="flex items-center gap-2 mb-3">
                                    <span
                                        class="px-2 py-1 bg-[#2D8176]/10 text-[#2D8176] text-[9px] font-bold uppercase rounded-full"
                                    >
                                        Published
                                    </span>
                                    <span
                                        class="text-[10px] text-[#c9a84c] font-bold uppercase"
                                    >
                                        {{ $paper['category'] }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3
                                    class="font-libre text-base font-bold text-[#2D8176] mb-2 leading-tight line-clamp-2"
                                >
                                    {{ $paper['title'] }}
                                </h3>

                                <!-- Author -->
                                <p class="text-xs text-[#c9a84c] font-bold mb-3">
                                    {{ $paper['author'] }}
                                </p>

                                <!-- Abstract -->
                                <p class="text-[#6a7890] text-sm mb-4 leading-relaxed line-clamp-3">
                                    {{ $paper['abstract'] }}
                                </p>

                                <!-- Stats -->
                                <div
                                    class="flex items-center gap-4 mb-5 text-xs font-bold text-[#6a7890] border-t pt-4"
                                >
                                    <div class="flex items-center gap-1">
                                        <span class="text-[#c9a84c]">✓</span>
                                        <span>{{ number_format($paper['downloads']) }} Downloads</span>
                                    </div>
                                </div>

                                <!-- Published Date -->
                                <div class="text-[10px] text-[#a7b1c7] mb-4 font-medium">
                                    Published: {{ $paper['publishedAt']?->format('M d, Y') ?? 'N/A' }}
                                </div>

                                <!-- Citation -->
                                <div class="bg-[#f9f7f2] p-3 rounded-lg mb-4 border-l-4 border-[#c9a84c]">
                                    <p class="text-[10px] font-bold text-[#2D8176] uppercase mb-2">Citation</p>
                                    <p class="text-[11px] text-[#6a7890] italic font-medium">
                                        {{ $paper['author'] }} ({{ $paper['publishedAt']?->format('Y') ?? 'N/A' }}). {{ $paper['title'] }}. Journal System.
                                    </p>
                                </div>

                                <!-- Read Article Button -->
                                <a
                                    href="{{ route('papers.show', ['submission' => $paper['id']]) }}"
                                    class="inline-block w-full px-4 py-2.5 bg-[#2D8176] text-white rounded-lg font-bold text-xs uppercase tracking-wider text-center hover:-translate-y-0.5 transition-all shadow-md"
                                >
                                    Read Article
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="mt-16 flex justify-center">
                    {{ $pagination->links('pagination::tailwind') }}
                </div>
            @else
                <div class="text-center py-20">
                    <div class="text-6xl mb-4">📚</div>
                    <h3 class="font-libre text-2xl font-bold text-[#2D8176] mb-2">
                        No Published Papers Yet
                    </h3>
                    <p class="text-[#6a7890] mb-8">
                        Check back soon for our first publication.
                    </p>
                    <a
                        href="/"
                        class="inline-block px-8 py-3 bg-[#2D8176] text-white rounded-lg font-bold text-sm uppercase tracking-wider hover:-translate-y-0.5 transition-all"
                    >
                        Back to Home
                    </a>
                </div>
            @endif
        </section>

        <!-- CALL TO ACTION SECTION -->
        <section class="py-20 bg-[#f9f7f2] border-y border-[#ede5d5] px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-libre text-3xl md:text-4xl font-bold text-[#2D8176] mb-4">
                    Ready to Publish Your Research?
                </h2>
                <p class="text-[#6a7890] text-lg mb-8 leading-relaxed">
                    Join our community of researchers and get your work published in a peer-reviewed journal today.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a
                        href="/register"
                        class="px-10 py-4 bg-[#2D8176] text-white rounded-2xl font-bold uppercase tracking-widest text-sm shadow-lg hover:-translate-y-0.5 transition-all"
                    >
                        Submit Your Paper
                    </a>
                    <a
                        href="/"
                        class="px-10 py-4 bg-white border-2 border-[#2D8176] text-[#2D8176] rounded-2xl font-bold uppercase tracking-widest text-sm hover:bg-[#2D8176] hover:text-white transition-all"
                    >
                        Learn More
                    </a>
                </div>
            </div>
        </section>

        <footer class="bg-[#1a4d46] text-[#ede5d5]/60 py-12 px-6">
            <div class="max-w-7xl mx-auto text-center">
                <h3 class="font-libre text-xl font-bold text-white mb-2">
                    Journal System
                </h3>
                <p class="text-[9px] font-bold uppercase tracking-[0.3em] mb-4">
                    Advancing Knowledge • Inspiring Innovation
                </p>
                <div class="h-px w-16 bg-[#c9a84c]/40 mx-auto mb-4"></div>
                <p class="text-[9px] font-medium uppercase tracking-widest">
                    © 2026 Academic Publishing Portal • All Rights Reserved
                </p>
            </div>
        </footer>

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
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const scrolled = scrollTop / docHeight;

                btn.classList.toggle('visible', scrolled > 0.2);

                const dashoffset = circumference - scrolled * circumference;
                progressCircle.style.strokeDashoffset = dashoffset;
            };
        </script>
    </body>
</html>
