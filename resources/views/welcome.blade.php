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
        </style>
    </head>
    <body class="bg-[#f5f0e8] text-[#0d1628] antialiased overflow-x-hidden">
        <div class="h-[3px] w-full nav-shimmer sticky top-0 z-[60]"></div>

        <nav
            class="bg-white/90 backdrop-blur-md border-b border-[#c9a84c]/20 sticky top-[3px] z-50"
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
                        class="bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white px-7 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-[#a07830]/20 hover:-translate-y-0.5 transition-all"
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
                        class="px-10 py-4 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white rounded-2xl font-bold uppercase tracking-widest text-xs shadow-2xl shadow-black/20 hover:-translate-y-1 transition-all"
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

        <section
            class="py-16 bg-white border-b border-[#ede5d5] overflow-hidden"
        >
            <div class="relative flex overflow-x-hidden group opacity-60">
                <div
                    class="animate-marquee whitespace-nowrap flex items-center gap-24"
                >
                    <span
                        class="font-libre text-2xl font-bold text-[#2D8176] uppercase tracking-tighter"
                    >
                        Nicko
                    </span>
                    <span
                        class="font-libre text-2xl font-bold text-[#2D8176] uppercase tracking-tighter"
                    >
                        Macky
                    </span>
                    <span
                        class="font-libre text-2xl font-bold text-[#2D8176] uppercase tracking-tighter"
                    >
                        Ralph
                    </span>
                    <span
                        class="font-libre text-2xl font-bold text-[#2D8176] uppercase tracking-tighter"
                    >
                        Carlos
                    </span>
                    <span
                        class="font-libre text-2xl font-bold text-[#2D8176] uppercase tracking-tighter"
                    >
                        Analie
                    </span>
                </div>
            </div>
        </section>

        <section id="journey" class="py-32 max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2
                        class="font-libre text-5xl font-bold tracking-tight leading-none mb-6 text-[#2D8176]"
                    >
                        Your Research
                        <br />
                        <span class="text-[#a07830]">Pathway.</span>
                    </h2>
                    <p
                        class="text-lg text-[#6a7890] font-medium mb-12 leading-relaxed"
                    >
                        We provide a rigorous yet supportive environment for
                        authors to refine and publish their high-impact
                        research.
                    </p>

                    <div class="space-y-10">
                        <div class="flex gap-6 group">
                            <div
                                class="w-14 h-14 bg-[#2D8176]/10 rounded-2xl flex items-center justify-center text-[#2D8176] font-bold shrink-0 group-hover:bg-[#2D8176] group-hover:text-white transition-all"
                            >
                                01
                            </div>
                            <div>
                                <h4 class="font-libre text-xl font-bold mb-1">
                                    Paper Submission
                                </h4>
                                <p class="text-sm text-[#8a96a8] font-medium">
                                    Upload your manuscript through our
                                    streamlined and secured author portal.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-6 group">
                            <div
                                class="w-14 h-14 bg-[#c9a84c]/10 rounded-2xl flex items-center justify-center text-[#a07830] font-bold shrink-0 group-hover:bg-[#a07830] group-hover:text-white transition-all"
                            >
                                02
                            </div>
                            <div>
                                <h4 class="font-libre text-xl font-bold mb-1">
                                    Peer Review
                                </h4>
                                <p class="text-sm text-[#8a96a8] font-medium">
                                    Double-blind evaluation conducted by
                                    international experts to ensure quality.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-6 group">
                            <div
                                class="w-14 h-14 bg-[#2D8176]/10 rounded-2xl flex items-center justify-center text-[#2D8176] font-bold shrink-0 group-hover:bg-[#2D8176] group-hover:text-white transition-all"
                            >
                                03
                            </div>
                            <div>
                                <h4 class="font-libre text-xl font-bold mb-1">
                                    Final Publication
                                </h4>
                                <p class="text-sm text-[#8a96a8] font-medium">
                                    Accepted papers are professionally formatted
                                    and published with a unique DOI.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div
                        class="absolute -inset-4 bg-[#c9a84c]/10 rounded-[40px] -rotate-2"
                    ></div>
                    <div
                        class="bg-slate-200 aspect-square rounded-[32px] relative overflow-hidden group shadow-2xl"
                    >
                        <img
                            src="https://static.vecteezy.com/system/resources/thumbnails/052/072/631/small/a-playful-dog-curiously-investigates-its-surroundings-with-captivating-eyes-photo.jpg"
                            class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 scale-110 group-hover:scale-100"
                            alt="Research"
                        />
                        <div
                            class="absolute inset-0 bg-[#2D8176]/20 mix-blend-multiply group-hover:opacity-0 transition-opacity"
                        ></div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-[#1a4d46] text-[#ede5d5]/60 pt-24 pb-12 px-6">
            <div class="max-w-7xl mx-auto text-center">
                <h3 class="font-libre text-2xl font-bold text-white mb-4">
                    Journal System
                </h3>
                <p
                    class="text-[10px] font-bold uppercase tracking-[0.4em] mb-8"
                >
                    Advancing Knowledge • Inspiring Innovation
                </p>
                <div class="h-px w-20 bg-[#c9a84c]/40 mx-auto mb-8"></div>
                <p class="text-[10px] font-medium uppercase tracking-widest">
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
        </script>
    </body>
</html>
