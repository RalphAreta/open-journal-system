<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Journal System | Academic Publishing Portal</title>

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

            /* Modern Teal Gradient Overlay */
            .hero-overlay {
                background: linear-gradient(
                    to bottom,
                    rgba(45, 129, 118, 0.85),
                    rgba(45, 129, 118, 0.4),
                    rgba(245, 240, 232, 1)
                );
            }

            /* Marquee Animation */
            @keyframes scroll {
                from {
                    transform: translateX(0);
                }
                to {
                    transform: translateX(-50%);
                }
            }

            .animate-marquee {
                display: flex;
                width: 200%;
                animation: scroll 30s linear infinite;
            }

            /* Top Shimmer Effect */
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

            /* Scroll Top Button Visibility */
            #scroll-top-btn {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                transform: translateY(100px);
                opacity: 0;
            }

            #scroll-top-btn.visible {
                transform: translateY(0);
                opacity: 1;
            }

            /* ===== NEW PREMIUM ANIMATIONS ===== */

            /* Parallax Hero Effect */
            @media (prefers-reduced-motion: no-preference) {
                .parallax-bg {
                    background-attachment: fixed;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;
                }
            }

            /* Fade-in on scroll */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .fade-in-up {
                animation: fadeInUp 0.6s ease-out forwards;
                opacity: 0;
            }

            .fade-in-up.visible {
                opacity: 1;
            }

            /* Ripple Effect Button */
            @keyframes ripple {
                0% {
                    box-shadow: 0 0 0 0 rgba(201, 168, 76, 0.7);
                }
                70% {
                    box-shadow: 0 0 0 10px rgba(201, 168, 76, 0);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(201, 168, 76, 0);
                }
            }

            .btn-ripple:hover {
                animation: ripple 0.6s ease-out;
            }

            /* Live Activity Pulse */
            @keyframes pulse-glow {
                0%, 100% {
                    box-shadow: 0 0 0 0 rgba(45, 129, 118, 0.5);
                }
                50% {
                    box-shadow: 0 0 0 8px rgba(45, 129, 118, 0);
                }
            }

            .pulse-glow {
                animation: pulse-glow 2s infinite;
            }

            /* Auto-scroll activity feed */
            @keyframes scroll-feed {
                0% {
                    transform: translateY(0);
                }
                10% {
                    transform: translateY(0);
                }
                20% {
                    transform: translateY(-80px);
                }
                30% {
                    transform: translateY(-80px);
                }
                40% {
                    transform: translateY(-160px);
                }
                50% {
                    transform: translateY(-160px);
                }
                60% {
                    transform: translateY(-240px);
                }
                70% {
                    transform: translateY(-240px);
                }
                85% {
                    transform: translateY(-320px);
                }
                95%,
                100% {
                    transform: translateY(0);
                }
            }

            .activity-feed {
                animation: scroll-feed 16s ease-in-out infinite;
            }

            /* Timeline Hover Expand */
            .timeline-card {
                transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
                cursor: pointer;
            }

            .timeline-card:hover {
                transform: translateY(-12px) scale(1.02);
            }

            .timeline-card-content {
                max-height: 0;
                overflow: hidden;
                opacity: 0;
                transition: all 0.4s ease;
            }

            .timeline-card.active .timeline-card-content,
            .timeline-card:hover .timeline-card-content {
                max-height: 200px;
                opacity: 1;
            }

            /* Hover Depth Card Effect */
            .card-hover-depth {
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .card-hover-depth:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(45, 129, 118, 0.15);
            }

            /* Icon Scale on Hover */
            .icon-scale:hover {
                transform: scale(1.15) rotate(5deg);
            }

            /* Stat Number Animation */
            @keyframes count-up {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .stat-number {
                animation: count-up 0.6s ease-out forwards;
            }

            /* Research Fields Grid Hover */
            .field-card {
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
                position: relative;
                overflow: hidden;
            }

            .field-card::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, transparent, rgba(201, 168, 76, 0.1), transparent);
                transform: translateX(-100%);
                transition: transform 0.4s ease;
            }

            .field-card:hover::before {
                transform: translateX(100%);
            }

            .field-card:hover {
                transform: translateY(-6px);
                background: rgba(45, 129, 118, 0.08);
            }

            /* Progress Bar Animation */
            @keyframes progress-fill {
                from {
                    width: 0;
                }
                to {
                    width: 65%;
                }
            }

            .progress-bar {
                animation: progress-fill 2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            }

            /* Badge Subtle Glow */
            .trust-badge {
                transition: all 0.3s ease;
            }

            .trust-badge:hover {
                box-shadow: 0 0 20px rgba(45, 129, 118, 0.2);
                transform: translateY(-2px);
            }

            /* Smooth Page Transition */
            @keyframes page-fade {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            html {
                animation: page-fade 0.8s ease-out;
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

        <header
            class="relative h-[85vh] flex items-center justify-center text-center px-4 overflow-hidden bg-[#2D8176]"
        >
            <img
                src="https://static.vecteezy.com/system/resources/thumbnails/052/072/631/small/a-playful-dog-curiously-investigates-its-surroundings-with-captivating-eyes-photo.jpg"
                alt="Hero Background"
                class="absolute inset-0 w-full h-full object-cover opacity-20"
            />
            <div class="absolute inset-0 hero-overlay"></div>

            <div class="relative z-10 max-w-4xl">
                <span
                    class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-[#f0d678] text-[10px] font-bold uppercase tracking-[0.4em] rounded-full mb-6"
                >
                    Peer-Reviewed Open Access
                </span>
                <h1
                    class="font-libre text-6xl md:text-8xl font-bold text-white tracking-tight mb-4 drop-shadow-xl"
                >
                    Journal System
                </h1>
                <p
                    class="text-[#f0d678] font-bold tracking-[0.3em] mb-10 text-sm md:text-base uppercase opacity-90"
                >
                    Innovation • Science • Engineering • Technology
                </p>
                <div class="flex flex-wrap justify-center gap-5">
                    <a
                        href="/register"
                        class="px-10 py-4 bg-linear-to-br from-[#c9a84c] to-[#a07830] text-white rounded-2xl font-bold uppercase tracking-widest text-xs shadow-2xl shadow-black/20 hover:-translate-y-1 transition-all"
                    >
                        Begin Submission
                    </a>
                    <a
                        href="#journey"
                        class="px-10 py-4 bg-white/10 backdrop-blur-lg border border-white/30 text-white rounded-2xl font-bold uppercase tracking-widest text-xs shadow-xl hover:bg-white/20 transition-all"
                    >
                        Review Process
                    </a>
                </div>
            </div>
        </header>

        <!-- TEAM MARQUEE SECTION -->
        <section class="py-12 bg-white border-b border-[#ede5d5] overflow-hidden">
            <div class="relative flex overflow-x-hidden group opacity-50">
                <div class="animate-marquee whitespace-nowrap flex items-center gap-32">
                    <span class="font-libre text-lg md:text-xl font-bold text-[#2D8176] uppercase tracking-tighter">Nicko</span>
                    <span class="font-libre text-lg md:text-xl font-bold text-[#2D8176] uppercase tracking-tighter">Macky</span>
                    <span class="font-libre text-lg md:text-xl font-bold text-[#2D8176] uppercase tracking-tighter">Ralph</span>
                    <span class="font-libre text-lg md:text-xl font-bold text-[#2D8176] uppercase tracking-tighter">Carlos</span>
                    <span class="font-libre text-lg md:text-xl font-bold text-[#2D8176] uppercase tracking-tighter">Analie</span>
                </div>
            </div>
        </section>

        <!-- RESEARCH METRICS DASHBOARD (Public Stats Bar) -->
        <section class="py-16 bg-linear-to-r from-[#2D8176] to-[#1a4d46] px-6 border-b border-[#2D8176]">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6 md:gap-8 text-center">
                    <div class="stat-number">
                        <div class="text-3xl md:text-4xl font-bold text-[#f0d678]">{{ $publishedPapersCount }}</div>
                        <div class="text-[9px] font-bold uppercase tracking-widest text-white/75 mt-3">Published Papers</div>
                    </div>
                    <div class="stat-number">
                        <div class="text-3xl md:text-4xl font-bold text-[#f0d678]">{{ $activeReviewersCount }}</div>
                        <div class="text-[9px] font-bold uppercase tracking-widest text-white/75 mt-3">Active Reviewers</div>
                    </div>
                    <div class="stat-number">
                        <div class="text-3xl md:text-4xl font-bold text-[#f0d678]">{{ $avgReviewDays }}</div>
                        <div class="text-[9px] font-bold uppercase tracking-widest text-white/75 mt-3">Avg Review Days</div>
                    </div>
                    <div class="stat-number">
                        <div class="text-3xl md:text-4xl font-bold text-[#f0d678]">{{ $acceptanceRate }}%</div>
                        <div class="text-[9px] font-bold uppercase tracking-widest text-white/75 mt-3">Acceptance Rate</div>
                    </div>
                    <div class="stat-number">
                        <div class="text-3xl md:text-4xl font-bold text-[#f0d678]">✓</div>
                        <div class="text-[9px] font-bold uppercase tracking-widest text-white/75 mt-3">Google Scholar</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- LIVE RESEARCH ACTIVITY SECTION -->
        <section class="py-16 bg-white px-6 border-b border-[#ede5d5]">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="font-libre text-3xl md:text-4xl font-bold text-[#2D8176] mb-2">Live Research Activity</h2>
                    <p class="text-sm text-[#6a7890] font-medium">Real-time activity from our community</p>
                </div>

                <div class="bg-[#f9f7f2] rounded-xl p-6 border border-[#e0d8cc] overflow-hidden">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-2 h-2 bg-[#2D8176] rounded-full pulse-glow"></div>
                        <span class="font-bold text-[9px] uppercase tracking-widest text-[#2D8176]">Live Feed</span>
                    </div>

                    <div class="relative h-64 overflow-hidden">
                        <div class="activity-feed space-y-4">
                            @forelse($liveActivities as $activity)
                            <!-- Activity Item -->
                            <div class="flex items-start gap-4 p-4 bg-white rounded-xl border border-[#e0d8cc]/50 hover:border-[#c9a84c]/30 transition-all">
                                <div class="text-2xl shrink-0">{{ $activity['icon'] }}</div>
                                <div class="flex-1">
                                    <div class="font-bold text-[#2D8176] text-sm">{{ $activity['title'] }}</div>
                                    <div class="text-[13px] text-[#6a7890] mt-1">{{ $activity['description'] }}</div>
                                    <div class="text-[11px] text-[#a7b1c7] mt-2 font-medium">
                                        @php
                                            $diff = $activity['timestamp']->diffForHumans();
                                        @endphp
                                        {{ $diff }} • {{ $activity['category'] }}
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="flex items-center justify-center h-64 text-[#6a7890]">
                                <p class="text-sm">No recent activities yet. Start by submitting a paper!</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- WHY PUBLISH WITH US SECTION -->
        <section class="py-20 bg-[#f9f7f2] px-6 border-b border-[#ede5d5]">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-14">
                    <h2 class="font-libre text-3xl md:text-4xl font-bold text-[#2D8176] mb-2 ">Why Publish With Us</h2>
                    <p class="text-sm text-[#6a7890] font-medium">Key advantages of our peer-reviewed journal</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Card 1 -->
                    <div class="card-hover-depth bg-white rounded-xl p-6 border border-[#e0d8cc] group">
                        <div class="text-4xl mb-3">⚡</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-sm">Fast Review</h3>
                        <p class="text-[#6a7890] text-xs leading-relaxed">12-day average. Quality decisions without delays.</p>
                        <div class="h-0.5 w-8 bg-[#c9a84c] mt-4 group-hover:w-full transition-all"></div>
                    </div>
                    <!-- Card 2 -->
                    <div class="card-hover-depth bg-white rounded-xl p-6 border border-[#e0d8cc] group">
                        <div class="text-4xl mb-3">🌍</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-sm">Global Network</h3>
                        <p class="text-[#6a7890] text-xs leading-relaxed">89+ international reviewers across all domains.</p>
                        <div class="h-0.5 w-8 bg-[#c9a84c] mt-4 group-hover:w-full transition-all"></div>
                    </div>
                    <!-- Card 3 -->
                    <div class="card-hover-depth bg-white rounded-xl p-6 border border-[#e0d8cc] group">
                        <div class="text-4xl mb-3">🔐</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-sm">Transparency</h3>
                        <p class="text-[#6a7890] text-xs leading-relaxed">Real-time status updates throughout review.</p>
                        <div class="h-0.5 w-8 bg-[#c9a84c] mt-4 group-hover:w-full transition-all"></div>
                    </div>
                    <!-- Card 4 -->
                    <div class="card-hover-depth bg-white rounded-xl p-6 border border-[#e0d8cc] group">
                        <div class="text-4xl mb-3">🧾</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-sm">DOI + Open Access</h3>
                        <p class="text-[#6a7890] text-xs leading-relaxed">Unique DOI for every paper. Max impact.</p>
                        <div class="h-0.5 w-8 bg-[#c9a84c] mt-4 group-hover:w-full transition-all"></div>
                    </div>
                    <!-- Card 5 -->
                    <div class="card-hover-depth bg-white rounded-xl p-6 border border-[#e0d8cc] group">
                        <div class="text-4xl mb-3">📊</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-sm">Live Metrics</h3>
                        <p class="text-[#6a7890] text-xs leading-relaxed">Track citations and downloads in dashboard.</p>
                        <div class="h-0.5 w-8 bg-[#c9a84c] mt-4 group-hover:w-full transition-all"></div>
                    </div>
                    <!-- Card 6 -->
                    <div class="card-hover-depth bg-white rounded-xl p-6 border border-[#e0d8cc] group">
                        <div class="text-4xl mb-3">👥</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-sm">Expert Support</h3>
                        <p class="text-[#6a7890] text-xs leading-relaxed">Dedicated guidance throughout process.</p>
                        <div class="h-0.5 w-8 bg-[#c9a84c] mt-4 group-hover:w-full transition-all"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PUBLISHING TIMELINE -->
        <section id="journey" class="py-16 max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-libre text-3xl md:text-4xl font-bold text-[#2D8176] mb-2">Publishing Timeline</h2>
                <p class="text-sm text-[#6a7890] font-medium">4 steps from submission to publication</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Step 1 -->
                <div class="timeline-card bg-white rounded-xl p-5 border-2 border-[#2D8176] shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-[#2D8176]/10 rounded-full flex items-center justify-center text-[#2D8176] text-xs font-bold">01</div>
                        <h3 class="font-bold text-[#2D8176] text-sm">Submit</h3>
                    </div>
                    <div class="h-px bg-[#c9a84c]/30 mb-2"></div>
                    <p class="text-[11px] text-[#6a7890] font-medium"><span class="text-[#2D8176] font-bold">1–2 days</span><br/>Initial screening</p>
                    <div class="timeline-card-content text-[10px] text-[#6a7890] mt-3 p-2 bg-[#f9f7f2] rounded border border-[#e0d8cc]">
                        Manuscript, abstract, keywords, affiliations
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="timeline-card bg-white rounded-xl p-5 border-2 border-[#c9a84c] shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-[#c9a84c]/10 rounded-full flex items-center justify-center text-[#a07830] text-xs font-bold">02</div>
                        <h3 class="font-bold text-[#2D8176] text-sm">Screen</h3>
                    </div>
                    <div class="h-px bg-[#c9a84c]/30 mb-2"></div>
                    <p class="text-[11px] text-[#6a7890] font-medium"><span class="text-[#2D8176] font-bold">3–5 days</span><br/>Editorial review</p>
                    <div class="timeline-card-content text-[10px] text-[#6a7890] mt-3 p-2 bg-[#f9f7f2] rounded border border-[#e0d8cc]">
                        Reviewer assignment by expertise
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="timeline-card bg-white rounded-xl p-5 border-2 border-[#2D8176] shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-[#2D8176]/10 rounded-full flex items-center justify-center text-[#2D8176] text-xs font-bold">03</div>
                        <h3 class="font-bold text-[#2D8176] text-sm">Review</h3>
                    </div>
                    <div class="h-px bg-[#c9a84c]/30 mb-2"></div>
                    <p class="text-[11px] text-[#6a7890] font-medium"><span class="text-[#2D8176] font-bold">10–14 days</span><br/>Double-blind eval</p>
                    <div class="timeline-card-content text-[10px] text-[#6a7890] mt-3 p-2 bg-[#f9f7f2] rounded border border-[#e0d8cc]">
                        Expert feedback & recommendations
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="timeline-card bg-white rounded-xl p-5 border-2 border-[#c9a84c] shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-[#c9a84c]/10 rounded-full flex items-center justify-center text-[#a07830] text-xs font-bold">04</div>
                        <h3 class="font-bold text-[#2D8176] text-sm">Publish</h3>
                    </div>
                    <div class="h-px bg-[#c9a84c]/30 mb-2"></div>
                    <p class="text-[11px] text-[#6a7890] font-medium"><span class="text-[#2D8176] font-bold">3 days</span><br/>DOI & format</p>
                    <div class="timeline-card-content text-[10px] text-[#6a7890] mt-3 p-2 bg-[#f9f7f2] rounded border border-[#e0d8cc]">
                        Distribution across databases
                    </div>
                </div>
            </div>
        </section>

        <!-- AUTHOR VS REVIEWER SPLIT PATH -->
        <section class="py-20 max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <h2 class="font-libre text-4xl font-bold text-[#2D8176] mb-2">What's Your Role?</h2>
                <p class="text-sm text-[#6a7890]">Choose your path and get started</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Author Path -->
                <div class="card-hover-depth bg-linear-to-br from-[#2D8176] to-[#1a4d46] rounded-2xl p-9 text-white border border-[#c9a84c]/30 shadow-lg group">
                    <div class="text-5xl mb-4">✍️</div>
                    <h3 class="font-libre text-2xl font-bold mb-3">I'm an Author</h3>
                    <p class="text-white/85 text-sm mb-6 leading-relaxed">
                        Submit your research and track progress through our transparent platform.
                    </p>
                    <ul class="space-y-2 mb-8 text-xs">
                        <li class="flex items-center gap-2">
                            <span class="text-[#f0d678]">✓</span>
                            <span>Easy manuscript submission</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-[#f0d678]">✓</span>
                            <span>Real-time tracking</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-[#f0d678]">✓</span>
                            <span>Dedicated support</span>
                        </li>
                    </ul>
                    <a href="/register" class="inline-block btn-ripple px-8 py-3 bg-[#f0d678] text-[#2D8176] rounded-lg font-bold text-xs uppercase tracking-wider shadow-lg hover:-translate-y-0.5 transition-all">
                        Submit Paper
                    </a>
                </div>

                <!-- Reviewer Path -->
                <div class="card-hover-depth bg-linear-to-br from-[#c9a84c] to-[#a07830] rounded-2xl p-9 text-white border border-[#2D8176]/30 shadow-lg group">
                    <div class="text-5xl mb-4">👓</div>
                    <h3 class="font-libre text-2xl font-bold mb-3">I'm a Reviewer</h3>
                    <p class="text-white/85 text-sm mb-6 leading-relaxed">
                        Review cutting-edge research and build your academic reputation.
                    </p>
                    <ul class="space-y-2 mb-8 text-xs">
                        <li class="flex items-center gap-2">
                            <span class="text-white">✓</span>
                            <span>Curated by expertise</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-white">✓</span>
                            <span>Flexible timeline</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-white">✓</span>
                            <span>Public recognition</span>
                        </li>
                    </ul>
                    <a href="/register" class="inline-block btn-ripple px-8 py-3 bg-white text-[#a07830] rounded-lg font-bold text-xs uppercase tracking-wider shadow-lg hover:-translate-y-0.5 transition-all">
                        Become Reviewer
                    </a>
                </div>
            </div>
        </section>

        <!-- EDITORIAL BOARD PREVIEW -->
        <section class="py-20 bg-[#f9f7f2] px-6 border-y border-[#ede5d5]">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-14">
                    <h2 class="font-libre text-4xl font-bold text-[#2D8176] mb-2">Meet Our Editorial Board</h2>
                    <p class="text-sm text-[#6a7890]">Leading academics ensuring scholarly excellence</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    @forelse($editorialBoard as $member)
                    <!-- Board Member -->
                    <div class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#e0d8cc] shadow-sm group">
                        <div class="h-32 bg-linear-to-br from-[#2D8176]/20 to-[#c9a84c]/20 flex items-center justify-center overflow-hidden">
                            <div class="text-5xl group-hover:scale-105 transition-transform">{{ $loop->iteration % 4 == 1 ? '👨‍🎓' : ($loop->iteration % 4 == 2 ? '👩‍🎓' : ($loop->iteration % 4 == 3 ? '👨‍🏫' : '👩‍💼')) }}</div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-libre text-sm font-bold text-[#2D8176] mb-1">{{ $member['name'] }}</h4>
                            <p class="text-xs text-[#c9a84c] font-bold uppercase mb-2">{{ ucfirst(str_replace('_', ' ', $member['role'])) }}</p>
                            <p class="text-[11px] text-[#6a7890] font-medium mb-1">{{ $member['expertise'] }}</p>

                        </div>
                    </div>
                    @empty
                    <!-- Default Board Member 1 -->
                    <div class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#e0d8cc] shadow-sm group">
                        <div class="h-32 bg-linear-to-br from-[#2D8176]/20 to-[#c9a84c]/20 flex items-center justify-center overflow-hidden">
                            <div class="text-5xl group-hover:scale-105 transition-transform">👨‍🎓</div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-libre text-sm font-bold text-[#2D8176] mb-1">Dr. James Mitchell</h4>
                            <p class="text-xs text-[#c9a84c] font-bold uppercase mb-2">Chief Editor</p>
                            <p class="text-[11px] text-[#6a7890] font-medium mb-1">MIT, Computer Science</p>
                            <p class="text-[10px] text-[#a7b1c7]">United States</p>
                        </div>
                    </div>

                    <!-- Default Board Member 2 -->
                    <div class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#e0d8cc] shadow-sm group">
                        <div class="h-32 bg-linear-to-br from-[#2D8176]/20 to-[#c9a84c]/20 flex items-center justify-center overflow-hidden">
                            <div class="text-5xl group-hover:scale-105 transition-transform">👩‍🎓</div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-libre text-sm font-bold text-[#2D8176] mb-1">Dr. Sarah Chen</h4>
                            <p class="text-xs text-[#c9a84c] font-bold uppercase mb-2">Managing Editor</p>
                            <p class="text-[11px] text-[#6a7890] font-medium mb-1">Oxford University, Physics</p>
                            <p class="text-[10px] text-[#a7b1c7]">United Kingdom</p>
                        </div>
                    </div>

                    <!-- Default Board Member 3 -->
                    <div class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#e0d8cc] shadow-sm group">
                        <div class="h-32 bg-linear-to-br from-[#2D8176]/20 to-[#c9a84c]/20 flex items-center justify-center overflow-hidden">
                            <div class="text-5xl group-hover:scale-105 transition-transform">👨‍🏫</div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-libre text-sm font-bold text-[#2D8176] mb-1">Prof. Andreas Weber</h4>
                            <p class="text-xs text-[#c9a84c] font-bold uppercase mb-2">Senior Editor</p>
                            <p class="text-[11px] text-[#6a7890] font-medium mb-1">ETH Zurich, Engineering</p>
                            <p class="text-[10px] text-[#a7b1c7]">Switzerland</p>
                        </div>
                    </div>

                    <!-- Default Board Member 4 -->
                    <div class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#e0d8cc] shadow-sm group">
                        <div class="h-32 bg-linear-to-br from-[#2D8176]/20 to-[#c9a84c]/20 flex items-center justify-center overflow-hidden">
                            <div class="text-5xl group-hover:scale-105 transition-transform">👩‍💼</div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-libre text-sm font-bold text-[#2D8176] mb-1">Dr. Aisha Patel</h4>
                            <p class="text-xs text-[#c9a84c] font-bold uppercase mb-2">Senior Editor</p>
                            <p class="text-[11px] text-[#6a7890] font-medium mb-1">IIT Delhi, Data Science</p>
                            <p class="text-[10px] text-[#a7b1c7]">India</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- FEATURED RESEARCH SPOTLIGHT -->
        <section class="py-20 max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <h2 class="font-libre text-4xl font-bold text-[#2D8176] mb-2">Featured Research</h2>
                <p class="text-sm text-[#6a7890]">Highlights from our recent publications</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @forelse($featuredResearch as $paper)
                <!-- Spotlight -->
                <div class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#c9a84c] shadow-lg">
                    <div class="h-40 bg-linear-to-br from-[#2D8176]/30 to-[#c9a84c]/20 flex items-center justify-center">
                        <div class="text-7xl">{{ $loop->iteration == 1 ? '🧬' : '♻️' }}</div>
                    </div>
                    <div class="p-7">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2 py-1 bg-[#2D8176]/10 text-[#2D8176] text-[9px] font-bold uppercase rounded-full">Featured</span>
                            <span class="text-[10px] text-[#c9a84c] font-bold uppercase">{{ $paper['category'] }}</span>
                        </div>
                        <h3 class="font-libre text-lg font-bold text-[#2D8176] mb-3 leading-tight">{{ $paper['title'] }}</h3>
                        <p class="text-[#6a7890] text-sm mb-4 leading-relaxed">
                            {{ $paper['abstract'] }}
                        </p>
                        <div class="flex items-center gap-6 mb-6 text-xs font-bold text-[#6a7890]">
                            <div class="flex items-center gap-1">
                                <span class="text-[#c9a84c]">✓</span>
                                <span>{{ $paper['citations'] }} Citations</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="text-[#c9a84c]">✓</span>
                                <span>{{ number_format($paper['downloads']) }} Downloads</span>
                            </div>
                        </div>
                        <a href="{{ route('papers.show', ['submission' => $paper['id']]) }}" class="inline-block px-6 py-2 bg-[#2D8176] text-white rounded-lg font-bold text-xs uppercase tracking-wider hover:-translate-y-0.5 transition-all shadow-md">
                            Read Article
                        </a>
                    </div>
                </div>
                @empty
                <!-- Default Spotlight 1 -->
                <div class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#c9a84c] shadow-lg">
                    <div class="h-40 bg-linear-to-br from-[#2D8176]/30 to-[#c9a84c]/20 flex items-center justify-center">
                        <div class="text-7xl">🧬</div>
                    </div>
                    <div class="p-7">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2 py-1 bg-[#2D8176]/10 text-[#2D8176] text-[9px] font-bold uppercase rounded-full">Featured</span>
                            <span class="text-[10px] text-[#c9a84c] font-bold uppercase">AI & ML</span>
                        </div>
                        <h3 class="font-libre text-lg font-bold text-[#2D8176] mb-3 leading-tight">Quantum-Inspired Neural Networks</h3>
                        <p class="text-[#6a7890] text-sm mb-4 leading-relaxed">
                            Revolutionary approach for protein folding prediction. Accelerates drug discovery by 340%.
                        </p>
                        <div class="flex items-center gap-6 mb-6 text-xs font-bold text-[#6a7890]">
                            <div class="flex items-center gap-1">
                                <span class="text-[#c9a84c]">✓</span>
                                <span>156 Citations</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="text-[#c9a84c]">✓</span>
                                <span>2.4K Downloads</span>
                            </div>
                        </div>
                        <a href="#" class="inline-block px-6 py-2 bg-[#2D8176] text-white rounded-lg font-bold text-xs uppercase tracking-wider hover:-translate-y-0.5 transition-all shadow-md">
                            Read Article
                        </a>
                    </div>
                </div>

                <!-- Default Spotlight 2 -->
                <div class="card-hover-depth bg-white rounded-xl overflow-hidden border border-[#c9a84c] shadow-lg">
                    <div class="h-40 bg-linear-to-br from-[#2D8176]/30 to-[#c9a84c]/20 flex items-center justify-center">
                        <div class="text-7xl">♻️</div>
                    </div>
                    <div class="p-7">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2 py-1 bg-[#2D8176]/10 text-[#2D8176] text-[9px] font-bold uppercase rounded-full">Featured</span>
                            <span class="text-[10px] text-[#c9a84c] font-bold uppercase">Green Tech</span>
                        </div>
                        <h3 class="font-libre text-lg font-bold text-[#2D8176] mb-3 leading-tight">Next-Gen Carbon Capture Materials</h3>
                        <p class="text-[#6a7890] text-sm mb-4 leading-relaxed">
                            Cost-effective graphene-based carbon capture technology for industrial deployment.
                        </p>
                        <div class="flex items-center gap-6 mb-6 text-xs font-bold text-[#6a7890]">
                            <div class="flex items-center gap-1">
                                <span class="text-[#c9a84c]">✓</span>
                                <span>89 Citations</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="text-[#c9a84c]">✓</span>
                                <span>1.8K Downloads</span>
                            </div>
                        </div>
                        <a href="#" class="inline-block px-6 py-2 bg-[#2D8176] text-white rounded-lg font-bold text-xs uppercase tracking-wider hover:-translate-y-0.5 transition-all shadow-md">
                            Read Article
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </section>

        <!-- RESEARCH FIELDS EXPLORER (Filterable Category Grid) -->
        <section class="py-20 max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <h2 class="font-libre text-4xl font-bold text-[#2D8176] mb-2">Research Fields</h2>
                <p class="text-sm text-[#6a7890]">Explore our diverse research categories</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                @forelse($researchFields as $index => $field)
                <!-- Dynamic Field Card -->
                <div class="field-card bg-white rounded-lg p-4 border border-[#e0d8cc] cursor-pointer hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-2">
                        @php
                            $emojis = ['🤖', '⚙️', '🔐', '♻️', '💾', '🧬', '📡', '☁️', '📊', '🚀'];
                            echo $emojis[$index % count($emojis)];
                        @endphp
                    </div>
                    <h3 class="font-bold text-[#2D8176] text-xs mb-1">{{ $field['name'] }}</h3>
                    <p class="text-[10px] text-[#a7b1c7]">{{ $field['count'] }} paper{{ $field['count'] !== 1 ? 's' : '' }}</p>
                </div>
                @empty
                <!-- Fallback: 10 Default Fields -->
                @php
                    $defaultFields = [
                        ['name' => 'Artificial Intelligence', 'count' => 24],
                        ['name' => 'Software Systems', 'count' => 18],
                        ['name' => 'Cybersecurity', 'count' => 16],
                        ['name' => 'Renewable Energy', 'count' => 22],
                        ['name' => 'Data Engineering', 'count' => 20],
                        ['name' => 'Biotechnology', 'count' => 14],
                        ['name' => 'Networking', 'count' => 12],
                        ['name' => 'Cloud Computing', 'count' => 19],
                        ['name' => 'Data Science', 'count' => 26],
                        ['name' => 'Innovation Lab', 'count' => 8]
                    ];
                @endphp
                @foreach($defaultFields as $index => $field)
                <div class="field-card bg-white rounded-lg p-4 border border-[#e0d8cc] cursor-pointer hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-2">
                        @php
                            $emojis = ['🤖', '⚙️', '🔐', '♻️', '💾', '🧬', '📡', '☁️', '📊', '🚀'];
                            echo $emojis[$index % count($emojis)];
                        @endphp
                    </div>
                    <h3 class="font-bold text-[#2D8176] text-xs mb-1">{{ $field['name'] }}</h3>
                    <p class="text-[10px] text-[#a7b1c7]">{{ $field['count'] }} papers</p>
                </div>
                @endforeach
                @endforelse
            </div>
        </section>

        <!-- TRANSPARENT REVIEW TRUST BADGES -->
        <section class="py-16 bg-[#f9f7f2] border-b border-[#ede5d5]">
            <div class="max-w-5xl mx-auto px-6">
                <div class="text-center mb-10">
                    <h2 class="font-libre text-3xl font-bold text-[#2D8176]">Trusted by the Academic Community</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Badge 1 -->
                    <div class="trust-badge bg-white rounded-xl p-6 border border-[#e0d8cc] text-center shadow-sm">
                        <div class="text-3xl mb-3">🛡️</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-xs uppercase tracking-wide">Double-Blind Review</h3>
                        <p class="text-[11px] text-[#6a7890]">Certified peer evaluation ensuring unbiased assessment</p>
                    </div>

                    <!-- Badge 2 -->
                    <div class="trust-badge bg-white rounded-xl p-6 border border-[#e0d8cc] text-center shadow-sm">
                        <div class="text-3xl mb-3">🔓</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-xs uppercase tracking-wide">Open Access Policy</h3>
                        <p class="text-[11px] text-[#6a7890]">All research freely accessible globally</p>
                    </div>

                    <!-- Badge 3 -->
                    <div class="trust-badge bg-white rounded-xl p-6 border border-[#e0d8cc] text-center shadow-sm">
                        <div class="text-3xl mb-3">📚</div>
                        <h3 class="font-bold text-[#2D8176] mb-2 text-xs uppercase tracking-wide">DOI Registered</h3>
                        <p class="text-[11px] text-[#6a7890]">Permanent digital identifiers for all articles</p>
                    </div>
                </div>

                <!-- Additional Trust Indicators -->
                <div class="mt-8 pt-8 border-t border-[#ede5d5]">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-[10px] font-bold uppercase tracking-wider text-[#6a7890]">
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-[#c9a84c]">✓</span>
                            <span>PubMed</span>
                        </div>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-[#c9a84c]">✓</span>
                            <span>Google Scholar</span>
                        </div>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-[#c9a84c]">✓</span>
                            <span>Web of Science</span>
                        </div>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-[#c9a84c]">✓</span>
                            <span>Scopus</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <footer class="bg-[#1a4d46] text-[#ede5d5]/60 py-12 px-6">
            <div class="max-w-7xl mx-auto text-center">
                <h3 class="font-libre text-xl font-bold text-white mb-2">
                    Journal System
                </h3>
                <p
                    class="text-[9px] font-bold uppercase tracking-[0.3em] mb-4"
                >
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
            // ===== SCROLL TO TOP & PROGRESS BUTTON =====
            const btn = document.getElementById('scroll-top-btn');
            const progressCircle = document.getElementById('progress-circle');
            const circumference = 188.4;

            window.onscroll = function () {
                // Button visibility
                if (
                    document.body.scrollTop > 500 ||
                    document.documentElement.scrollTop > 500
                ) {
                    btn.classList.add('visible');
                } else {
                    btn.classList.remove('visible');
                }

                // Progress ring calculation
                const scrollTotal =
                    document.documentElement.scrollHeight -
                    document.documentElement.clientHeight;
                const scrollProgress =
                    document.documentElement.scrollTop / scrollTotal;
                progressCircle.style.strokeDashoffset =
                    circumference - scrollProgress * circumference;
            };

            // ===== FADE-IN ON SCROLL ANIMATION =====
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all fade-in elements
            document.querySelectorAll('.fade-in-up').forEach(el => {
                observer.observe(el);
            });

            // ===== TIMELINE CARD INTERACTIVE EXPAND =====
            document.querySelectorAll('.timeline-card').forEach(card => {
                card.addEventListener('click', function() {
                    this.classList.toggle('active');
                });
            });

            // ===== STAT COUNTER ANIMATION =====
            const statNumbers = document.querySelectorAll('.stat-number');
            const animateCounters = () => {
                statNumbers.forEach(statsGroup => {
                    const numberElement = statsGroup.querySelector('.text-4xl, .text-5xl');
                    if (!numberElement || numberElement.getAttribute('data-animated')) return;

                    numberElement.setAttribute('data-animated', 'true');
                    const isInView = statsGroup.getBoundingClientRect().top < window.innerHeight;
                    if (isInView) {
                        statsGroup.style.animation = 'count-up 0.6s ease-out forwards';
                    }
                });
            };

            window.addEventListener('scroll', animateCounters);
            animateCounters();

            // ===== RESEARCH FIELDS GRID HOVER =====
            document.querySelectorAll('.field-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Could add filtering logic here
                    console.log('Clicked:', this.querySelector('h3').textContent);
                });
            });

            // ===== SMOOTH FADE-IN FOR PAGE LOAD =====
            window.addEventListener('load', function() {
                // Trigger animations after page load
                document.querySelectorAll('.fade-in-up').forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('visible');
                    }, index * 100);
                });
            });

            // ===== PARALLAX EFFECT ON HERO =====
            const parallaxElements = document.querySelectorAll('.parallax-bg');
            window.addEventListener('scroll', function() {
                parallaxElements.forEach(element => {
                    let scrollPosition = window.pageYOffset;
                    element.style.backgroundPosition = `center ${scrollPosition * 0.5}px`;
                });
            });

            // ===== TRUST BADGES STAGGER ANIMATION =====
            const trustBadges = document.querySelectorAll('.trust-badge');
            const badgeObserver = new IntersectionObserver(function(entries) {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            }, { threshold: 0.5 });

            trustBadges.forEach(badge => {
                badge.style.opacity = '0';
                badge.style.transform = 'translateY(20px)';
                badge.style.transition = 'all 0.5s ease';
                badgeObserver.observe(badge);
            });
        </script>
    </body>
</html>
