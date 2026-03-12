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
                transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .card-hover-depth:hover {
                transform: translateY(-12px);
                box-shadow: 0 28px 48px rgba(45, 129, 118, 0.2);
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
            class="relative h-80 md:h-96 flex items-center justify-center text-center px-4 overflow-hidden bg-gradient-to-br from-[#2D8176] via-[#2a8675] to-[#1a5451]"
        >
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 1000 600" preserveAspectRatio="none">
                    <defs>
                        <pattern id="dots" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                            <circle cx="50" cy="50" r="1" fill="white" opacity="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="1000" height="600" fill="url(#dots)"/>
                </svg>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-transparent via-transparent to-[rgba(45,129,118,0.1)]"></div>

            <div class="relative z-10 max-w-4xl">
                <div class="inline-block mb-4 px-4 py-2 bg-white/15 backdrop-blur-md rounded-full border border-white/20">
                    <p class="text-[#f0d678] font-bold tracking-[0.2em] text-xs md:text-sm uppercase">
                        📚 Research Repository
                    </p>
                </div>
                <h1
                    class="font-libre text-5xl md:text-6xl lg:text-7xl font-bold text-white tracking-tight mb-6 drop-shadow-2xl leading-tight"
                >
                    Published Papers
                </h1>
                <p class="text-white/90 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                    Explore cutting-edge research published in our peer-reviewed journal. All papers have been rigorously reviewed and validated by leading academics.
                </p>
            </div>
        </section>

        <!-- PAPERS LISTING SECTION -->
        <section class="py-20 max-w-7xl mx-auto px-6">
            <!-- Section Header with Stats -->
            <div class="mb-16">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
                    <div>
                        <h2
                            class="font-libre text-4xl md:text-5xl font-bold text-[#2D8176] mb-3"
                        >
                            All Published Research
                        </h2>
                        <p class="text-[#6a7890] font-medium text-lg">
                            Discover {{ count($papers) }} peer-reviewed papers from leading researchers
                        </p>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-libre font-bold text-[#c9a84c]">{{ count($papers) }}</div>
                            <div class="text-xs uppercase font-bold text-[#6a7890] tracking-wider">Papers Published</div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter (Optional) -->
                <div class="flex flex-col sm:flex-row gap-3 mb-8">
                    <input 
                        type="text" 
                        placeholder="Search papers by title or author..." 
                        id="paperSearch"
                        class="flex-1 px-4 py-3 border border-[#e0d8cc] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#2D8176]/30 focus:border-[#2D8176]"
                    />
                    <select class="px-4 py-3 border border-[#e0d8cc] rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#2D8176]/30">
                        <option value="">All Categories</option>
                        @php
                            $categories = array_unique(array_column($papers->all(), 'category'));
                        @endphp
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($papers->count() > 0)
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    @foreach ($papers as $paper)
                        <!-- Enhanced Paper Card -->
                        <div
                            class="card-hover-depth group bg-white rounded-2xl overflow-hidden border border-[#e0d8cc] shadow-sm hover:shadow-xl transition-all duration-300"
                            data-paper-title="{{ $paper['title'] }}"
                            data-paper-author="{{ $paper['author'] }}"
                            data-paper-abstract="{{ $paper['abstract'] }}"
                            data-paper-category="{{ $paper['category'] }}"
                        >
                            <!-- Header with gradient background -->
                            <div class="relative h-40 bg-gradient-to-br from-[#2D8176]/15 via-[#2D8176]/8 to-[#c9a84c]/10 overflow-hidden flex items-center justify-center border-b border-[#e0d8cc]">
                                <div class="text-6xl opacity-60 group-hover:scale-110 group-hover:opacity-80 transition-transform duration-300">📄</div>
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1.5 bg-[#2D8176] text-white text-[8px] font-black uppercase rounded-full shadow-md">
                                        Published
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8">
                                <!-- Category Tag -->
                                <div class="mb-3">
                                    <span class="inline-block px-3 py-1.5 bg-[#c9a84c]/15 text-[#c9a84c] text-[10px] font-bold uppercase rounded-lg border border-[#c9a84c]/30">
                                        {{ $paper['category'] }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3
                                    class="font-libre text-lg font-bold text-[#2D8176] mb-3 leading-snug line-clamp-3 group-hover:text-[#c9a84c] transition-colors"
                                >
                                    {{ $paper['title'] }}
                                </h3>

                                <!-- Author with icon -->
                                <div class="flex items-center gap-2 mb-4 pb-4 border-b border-[#e0d8cc]">
                                    <svg class="w-4 h-4 text-[#c9a84c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-[#6a7890] font-semibold">
                                        {{ $paper['author'] }}
                                    </p>
                                </div>

                                <!-- Abstract -->
                                <p
                                    class="text-[#6a7890] text-sm mb-6 leading-relaxed line-clamp-3 h-16"
                                >
                                    {{ $paper['abstract'] }}
                                </p>

                                <!-- Stats Grid -->
                                <div class="grid grid-cols-2 gap-3 mb-6 p-4 bg-[#f9f7f2] rounded-lg">
                                    <div class="text-center">
                                        <div class="text-lg font-libre font-bold text-[#2D8176]">
                                            {{ number_format($paper['downloads']) }}
                                        </div>
                                        <div class="text-[10px] font-bold text-[#c9a84c] uppercase tracking-wider">
                                            Downloads
                                        </div>
                                    </div>
                                    <div class="text-center border-l border-[#e0d8cc]">
                                        <div class="text-lg font-libre font-bold text-[#2D8176]">
                                            {{ date('M', strtotime($paper['publishedAt'])) }}
                                        </div>
                                        <div class="text-[10px] font-bold text-[#c9a84c] uppercase tracking-wider">
                                            {{ date('Y', strtotime($paper['publishedAt'])) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Published Date -->
                                <div class="text-[11px] text-[#a7b1c7] mb-5 font-medium flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Published {{ $paper['publishedAt']?->format('M d, Y') ?? 'N/A' }}
                                </div>

                                <!-- CTA Button -->
                                <a
                                    href="{{ route('papers.show', ['submission' => $paper['id']]) }}"
                                    class="inline-block w-full px-5 py-3.5 bg-gradient-to-r from-[#2D8176] to-[#1a4d46] text-white rounded-xl font-bold text-sm uppercase tracking-wider text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2 group-hover:from-[#c9a84c] group-hover:to-[#a07830]"
                                >
                                    <span>Read Full Article</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="mt-20 flex justify-center">
                    {{ $pagination->links('pagination::tailwind') }}
                </div>
            @else
                <div class="text-center py-32">
                    <div class="text-7xl mb-6 animate-bounce">📚</div>
                    <h3
                        class="font-libre text-3xl font-bold text-[#2D8176] mb-3"
                    >
                        No Published Papers Yet
                    </h3>
                    <p class="text-[#6a7890] mb-10 text-lg max-w-md mx-auto">
                        Be the first to contribute to our collection of peer-reviewed research.
                    </p>
                    <a
                        href="/"
                        class="inline-block px-10 py-4 bg-[#2D8176] text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:-translate-y-1 transition-all shadow-lg hover:shadow-xl"
                    >
                        Back to Home
                    </a>
                </div>
            @endif
        </section>

        <!-- CALL TO ACTION SECTION -->
        <section class="py-24 bg-gradient-to-br from-[#f9f7f2] via-[#faf8f4] to-[#f5f0e8] border-y border-[#ede5d5] px-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-[#2D8176]/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-[#c9a84c]/5 rounded-full -ml-32 -mb-32 blur-3xl"></div>
            
            <div class="max-w-4xl mx-auto text-center relative z-10">
                <h2
                    class="font-libre text-4xl md:text-5xl font-bold text-[#2D8176] mb-6"
                >
                    Ready to Publish Your Research?
                </h2>
                <p class="text-[#6a7890] text-lg mb-12 leading-relaxed max-w-2xl mx-auto">
                    Join our community of innovative researchers and get your groundbreaking work published in a peer-reviewed journal. Submit your manuscript today and contribute to advancing knowledge in your field.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a
                        href="/register"
                        class="inline-block px-12 py-4 bg-gradient-to-r from-[#2D8176] to-[#1a5451] text-white rounded-2xl font-bold text-sm uppercase tracking-wider shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2 group"
                    >
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Submit Your Paper</span>
                    </a>
                    <a
                        href="/"
                        class="inline-block px-12 py-4 bg-white border-2 border-[#2D8176] text-[#2D8176] rounded-2xl font-bold text-sm uppercase tracking-wider hover:bg-[#2D8176] hover:text-white transition-all duration-200 flex items-center justify-center gap-2 group"
                    >
                        <svg class="w-5 h-5 group-hover:-rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Learn More</span>
                    </a>
                </div>
            </div>
        </section>

        <footer class="bg-gradient-to-r from-[#1a4d46] to-[#0d2a25] text-[#ede5d5]/70 py-14 px-6 border-t-2 border-[#c9a84c]/20">
            <div class="max-w-7xl mx-auto text-center">
                <h3 class="font-libre text-2xl font-bold text-white mb-2">
                    Journal System
                </h3>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] mb-5 text-[#f0d678]">
                    Advancing Knowledge • Inspiring Innovation
                </p>
                <div class="h-1 w-20 bg-gradient-to-r from-[#c9a84c] to-transparent mx-auto mb-6"></div>
                <p class="text-[10px] font-semibold uppercase tracking-wider">
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
                const docHeight =
                    document.documentElement.scrollHeight - window.innerHeight;
                const scrolled = scrollTop / docHeight;

                btn.classList.toggle('visible', scrolled > 0.2);

                const dashoffset = circumference - scrolled * circumference;
                progressCircle.style.strokeDashoffset = dashoffset;
            };

            // Paper Search & Filter Functionality
            const searchInput = document.getElementById('paperSearch');
            const filterSelect = document.querySelector('select');
            const paperCards = document.querySelectorAll('[data-paper-title]');

            function filterPapers() {
                const searchQuery = searchInput.value.toLowerCase();
                const selectedCategory = filterSelect.value;
                let visibleCount = 0;

                paperCards.forEach(card => {
                    const title = card.getAttribute('data-paper-title').toLowerCase();
                    const author = card.getAttribute('data-paper-author').toLowerCase();
                    const abstract = card.getAttribute('data-paper-abstract').toLowerCase();
                    const category = card.getAttribute('data-paper-category');

                    const matchesSearch = 
                        title.includes(searchQuery) || 
                        author.includes(searchQuery) || 
                        abstract.includes(searchQuery);
                    
                    const matchesCategory = !selectedCategory || category === selectedCategory;

                    if (matchesSearch && matchesCategory) {
                        card.style.display = '';
                        card.classList.add('animate-in');
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                const gridContainer = document.querySelector('.grid');
                let noResultsMsg = document.getElementById('noResultsMsg');
                
                if (visibleCount === 0) {
                    if (!noResultsMsg) {
                        noResultsMsg = document.createElement('div');
                        noResultsMsg.id = 'noResultsMsg';
                        noResultsMsg.className = 'col-span-full text-center py-16';
                        noResultsMsg.innerHTML = `
                            <div class="text-4xl mb-4">🔍</div>
                            <h3 class="font-libre text-2xl font-bold text-[#2D8176] mb-2">No papers found</h3>
                            <p class="text-[#6a7890]">Try adjusting your search or filter criteria</p>
                        `;
                        gridContainer.appendChild(noResultsMsg);
                    }
                } else {
                    if (noResultsMsg) {
                        noResultsMsg.remove();
                    }
                }
            }

            searchInput?.addEventListener('input', filterPapers);
            filterSelect?.addEventListener('change', filterPapers);

            // Add data attributes to paper cards
            document.querySelectorAll('[data-paper-title]').forEach(card => {
                if (!card.getAttribute('data-paper-title')) {
                    const titleEl = card.querySelector('h3');
                    const authorEl = card.querySelector('[data-paper-author]');
                    const abstractEl = card.querySelector('[data-paper-abstract]');
                    if (titleEl) card.setAttribute('data-paper-title', titleEl.textContent);
                    if (authorEl) card.setAttribute('data-paper-author', authorEl.textContent);
                    if (abstractEl) card.setAttribute('data-paper-abstract', abstractEl.textContent);
                }
            });
        </script>
    </body>
</html>
