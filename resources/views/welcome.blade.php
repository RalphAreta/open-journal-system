<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IRJIEST - Welcome</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }

        /* Enhanced Contrast Overlay */
        .hero-overlay {
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.7) 0%, rgba(15, 23, 42, 0.3) 50%, rgba(15, 23, 42, 0.8) 100%);
        }

        /* Sophisticated Text Shadow for readability */
        .text-readable {
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        /* Card Hover Effects */
        .journey-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .journey-card:hover {
            transform: translateY(-10px);
            border-color: #ef4444; /* red-500 */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased overflow-x-hidden">

    <nav class="bg-white/95 backdrop-blur-sm border-b border-slate-100 sticky top-0 z-50 py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/batstateu-logo.png') }}" alt="Logo" class="h-10">
                <span class="text-xl font-extrabold text-red-600 tracking-tight">Batangas State University</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="/login" class="text-sm font-bold text-slate-600 hover:text-red-600 transition-colors">Login</a>
                <a href="/register" class="bg-red-600 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-red-200 hover:bg-red-700 transition-all">Register</a>
            </div>
        </div>
    </nav>

    <header class="relative h-[85vh] flex items-center justify-center text-center px-4 overflow-hidden">
        <img src="{{ asset('images/homepage-webslider-1.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="Campus">
        <div class="absolute inset-0 hero-overlay"></div>

        <div class="relative z-10 max-w-4xl animate-fade-in">
            <span class="inline-block px-4 py-1.5 bg-red-600 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">Official Research Portal</span>
            <h1 class="text-7xl md:text-9xl font-black text-white tracking-tighter mb-4 text-readable">IRJIEST</h1>
            <p class="text-orange-400 font-bold tracking-[0.2em] mb-8">ISSN 0115-8228 (ONLINE)</p>
            <p class="text-slate-200 text-lg md:text-xl font-medium leading-relaxed mb-10 text-readable">
                The International Research Journal on Innovations in Engineering, Science and Technology, published by BatStateU Philippines.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#journey" class="px-8 py-4 bg-white/10 text-white rounded-xl border border-white/20 font-bold backdrop-blur-md hover:bg-white/20 transition-all">View Process</a>
                <a href="/register" class="px-8 py-4 bg-red-600 text-white rounded-xl font-bold shadow-2xl shadow-red-900/40 hover:-translate-y-1 transition-all">Submit Manuscript</a>
            </div>
        </div>
    </header>

    <section id="journey" class="py-24 max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black tracking-tight mb-2">Submission Journey</h2>
            <div class="w-16 h-1 bg-red-600 mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $steps = [
                    ['id' => '01', 'title' => 'Submission', 'desc' => 'Authors upload manuscripts and metadata through our streamlined portal.'],
                    ['id' => '02', 'title' => 'Peer Review', 'desc' => 'Assigned experts evaluate research quality and provide detailed feedback.'],
                    ['id' => '03', 'title' => 'Editorial', 'desc' => 'Editors-in-chief make final decisions based on reviewer recommendations.'],
                    ['id' => '04', 'title' => 'Publication', 'desc' => 'Accepted works are formatted and published in our annual volumes.']
                ];
            @endphp
            @foreach($steps as $step)
            <div class="journey-card bg-slate-50/50 border border-slate-100 p-8 rounded-[2rem] relative">
                <span class="absolute -top-3 -left-3 w-10 h-10 {{ $loop->index % 2 == 0 ? 'bg-red-600' : 'bg-slate-900' }} text-white flex items-center justify-center rounded-xl font-black text-sm shadow-lg">{{ $step['id'] }}</span>
                <h3 class="text-xl font-black mb-4 mt-2">{{ $step['title'] }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="bg-red-600 py-20 text-center px-6">
        <h2 class="text-4xl font-black text-white mb-4">Ready to Publish Your Research?</h2>
        <p class="text-red-100 mb-10 font-medium">Join thousands of researchers advancing their careers through IRJIEST.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="/register" class="bg-white text-red-600 px-10 py-4 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-slate-50 transition-all">Sign Up Now</a>
            <a href="/login" class="border-2 border-white text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-white hover:text-red-600 transition-all">Sign In</a>
        </div>
    </section>

    <footer class="bg-slate-950 text-slate-500 py-16 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 border-b border-slate-800/50 pb-12">
            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-[0.2em] mb-6">Contact</h4>
                <p class="text-sm mb-2">✉️ irjiest@g.batstate-u.edu.ph</p>
                <p class="text-sm">📞 +63 43 980 0385 loc 1151</p>
            </div>
            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-[0.2em] mb-6">Institution</h4>
                <p class="text-sm text-slate-300 font-bold">Batangas State University</p>
                <p class="text-[10px] uppercase tracking-widest mt-1">The National Engineering University</p>
            </div>
            <div class="md:text-right">
                <p class="text-[10px] font-black uppercase tracking-[0.4em]">© 2026 IRJIEST</p>
                <p class="text-[9px] mt-2">All Rights Reserved</p>
            </div>
        </div>
    </footer>

</body>
</html>
