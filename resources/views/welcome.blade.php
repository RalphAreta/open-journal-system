<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IRJIEST | International Research Journal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; scroll-behavior: smooth; }

        /* Modern Gradient Overlay */
        .hero-overlay {
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.4), rgba(255, 255, 255, 1));
        }

        /* Marquee Animation */
        @keyframes scroll {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: 200%;
            animation: scroll 30s linear infinite;
        }

        /* Scroll Progress Ring */
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
<body class="bg-white text-slate-900 antialiased overflow-x-hidden">

    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/batstateu-logo.png') }}" alt="Logo" class="h-10">
                <div class="flex flex-col">
                    <span class="text-lg font-extrabold text-red-600 leading-none">BatStateU</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">The National Engineering University</span>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="/login" class="text-sm font-bold text-slate-600">Login</a>
                <a href="/register" class="bg-red-600 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-red-200 hover:bg-red-700 transition-all">Register</a>
            </div>
        </div>
    </nav>

    <header class="relative h-[90vh] flex items-center justify-center text-center px-4 overflow-hidden bg-slate-900">
        <img src="{{ asset('images/homepage-webslider-1.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-60" alt="Campus">
        <div class="absolute inset-0 hero-overlay"></div>

        <div class="relative z-10 max-w-4xl">
            <span class="inline-block px-4 py-1.5 bg-red-600 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">Volume 12 • Issue 2026</span>
            <h1 class="text-7xl md:text-9xl font-black text-white tracking-tighter mb-4 drop-shadow-2xl">IRJIEST</h1>
            <p class="text-orange-400 font-bold tracking-[0.3em] mb-8 text-sm md:text-base uppercase">Innovation • Engineering • Science • Technology</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/register" class="px-10 py-4 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-2xl shadow-red-900/40 hover:-translate-y-1 transition-all">Begin Submission</a>
                <a href="#journey" class="px-10 py-4 bg-white text-slate-900 rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl hover:bg-slate-50 transition-all">Process</a>
            </div>
        </div>
    </header>



    <section class="py-20 border-b border-slate-50 overflow-hidden">

        <div class="relative flex overflow-x-hidden group">
            <div class="animate-marquee whitespace-nowrap flex items-center gap-20">
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">Google Scholar</span>
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">CrossRef</span>
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">DOAJ</span>
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">Philippine E-Journals</span>
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">Scilit</span>
            </div>
            <div class="animate-marquee whitespace-nowrap flex items-center gap-20" aria-hidden="true">
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50">Google Scholar</span>
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50">CrossRef</span>
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50">DOAJ</span>
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50">Philippine E-Journals</span>
                <span class="text-2xl font-black text-slate-300 uppercase tracking-tighter grayscale opacity-50">Scilit</span>
            </div>
        </div>
    </section>

    <section id="journey" class="py-32 max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div>
                <h2 class="text-5xl font-black tracking-tight leading-none mb-6">Your Research <br><span class="text-red-600 font-black">Pathway.</span></h2>
                <p class="text-lg text-slate-500 font-medium mb-12 leading-relaxed">We provide a rigorous yet supportive environment for authors to refine and publish their high-impact research.</p>
                <div class="space-y-12">
                    <div class="flex gap-6 group">
                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 font-black shrink-0 group-hover:bg-red-600 group-hover:text-white transition-all">01</div>
                        <div>
                            <h4 class="text-xl font-black mb-1">Paper Submission</h4>
                            <p class="text-sm text-slate-500 font-medium">Upload your manuscript with our streamlined author portal.</p>
                        </div>
                    </div>
                    <div class="flex gap-6 group">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-900 font-black shrink-0 group-hover:bg-red-600 group-hover:text-white transition-all">02</div>
                        <div>
                            <h4 class="text-xl font-black mb-1">Peer Review</h4>
                            <p class="text-sm text-slate-500 font-medium">Double-blind evaluation by international domain experts.</p>
                        </div>
                    </div>
                    <div class="flex gap-6 group">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-900 font-black shrink-0 group-hover:bg-red-600 group-hover:text-white transition-all">03</div>
                        <div>
                            <h4 class="text-xl font-black mb-1">Technical Revision</h4>
                            <p class="text-sm text-slate-500 font-medium">Refine your work based on high-quality technical feedback.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-100 aspect-square rounded-4xl relative overflow-hidden group">
                <img src="{{ asset('images/homepage-webslider-1.jpg') }}" class="absolute inset-0 w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" alt="Research">
                <div class="absolute inset-0 bg-red-600/20 mix-blend-multiply group-hover:opacity-0 transition-opacity"></div>
            </div>
        </div>
    </section>



    <footer class="bg-slate-900 text-slate-400 pt-24 pb-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                <div class="md:col-span-1">
                    <a href="/" class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/batstateu-logo.png') }}" alt="Logo" class="h-10 brightness-100 opacity-100">
                        <span class="text-xl font-black text-white tracking-tighter">IRJIEST</span>
                    </a>
                    <p class="text-sm leading-relaxed mb-6 font-medium">
                        International Research Journal on Innovations in Engineering, Science and Technology. An official publication of Batangas State University.
                    </p>

                </div>

                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-6">Institution</h4>
                    <p class="text-sm font-black text-slate-100 mb-1">Batangas State University</p>
                    <p class="text-xs mb-4">The National Engineering University</p>
                    <p class="text-[11px] leading-relaxed italic">Leading Innovations, Transforming Lives, Building the Nation.</p>
                </div>

                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-6">Contact Us</h4>
                    <ul class="space-y-3 text-sm font-medium">
                        <li class="flex items-start gap-3">
                            <span class="text-red-500 font-bold">E:</span>
                            <span>irjiest@g.batstate-u.edu.ph</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-red-500 font-bold">P:</span>
                            <span>+63 43 980 0385 loc 1151</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-red-500 font-bold">A:</span>
                            <span>Rizal Avenue, Batangas City, Philippines</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-[10px] font-black uppercase tracking-[0.3em]">© 2026 BatStateU Philippines • All Rights Reserved</p>
                <div class="flex gap-8 text-[10px] font-black uppercase tracking-[0.3em]">
                    <span class="text-slate-600 italic">ISSN: 0115-8228 (Online)</span>
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Back to Top with Corrected Canonical Class and SVG center logic --}}
    <button id="scroll-top-btn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-10 right-10 w-16 h-16 bg-white shadow-2xl rounded-full z-50 flex items-center justify-center group">
        <svg class="w-6 h-6 text-slate-900 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"/></svg>
        <svg class="absolute inset-0 w-full h-full -rotate-90">
            <circle cx="32" cy="32" r="30" stroke="currentColor" stroke-width="2" fill="transparent" class="text-slate-100" />
            <circle id="progress-circle" cx="32" cy="32" r="30" stroke="currentColor" stroke-width="2" fill="transparent" class="text-red-600" stroke-dasharray="188.4" stroke-dashoffset="188.4" />
        </svg>
    </button>

    <script>
        const btn = document.getElementById('scroll-top-btn');
        const progressCircle = document.getElementById('progress-circle');
        const circumference = 188.4;

        window.onscroll = function() {
            if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
            const scrollTotal = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollProgress = document.documentElement.scrollTop / scrollTotal;
            progressCircle.style.strokeDashoffset = circumference - (scrollProgress * circumference);
        };
    </script>

</body>
</html>

