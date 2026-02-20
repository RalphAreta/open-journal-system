<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IRJIEST') }} - Welcome</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; scroll-behavior: smooth; }

        .hero-overlay {
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.4));
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-in-down { animation: slideInDown 0.8s ease-out forwards; }
        .slide-in-up { animation: slideInUp 0.8s ease-out forwards; opacity: 0; }

        /* Smooth scale for role buttons */
        .role-btn { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-900 antialiased flex flex-col">
    <nav class="bg-white border-b border-slate-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/batstateu-logo.png') }}" alt="Logo" class="h-10 w-auto transition-transform group-hover:scale-110">
                        <span class="text-xl font-extrabold text-red-600 tracking-tight">Batangas State University</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-white bg-slate-900 px-5 py-2.5 rounded-full hover:bg-red-600 transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-red-600 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-red-600 hover:bg-red-700 px-6 py-2.5 rounded-full shadow-lg shadow-red-200 transition-all hover:-translate-y-0.5">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="relative min-h-[85vh] flex items-center justify-center overflow-hidden"
         style="background-image: url('{{ asset('images/homepage-webslider-1.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 hero-overlay"></div>
        <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
            <div class="inline-block mb-6 px-4 py-1.5 bg-red-600/10 border border-red-500/20 backdrop-blur-md rounded-full slide-in-down">
                <span class="text-xs font-black uppercase tracking-[0.3em] text-red-400">Official Research Portal</span>
            </div>
            <h1 class="text-8xl md:text-[10rem] font-black text-white mb-4 slide-in-down tracking-tighter" style="line-height: 0.9;">IRJIEST</h1>
            <p class="text-lg md:text-xl font-bold text-orange-400 mb-8 tracking-[0.2em] slide-in-up" style="animation-delay: 0.2s;">ISSN 0115-8228 (ONLINE)</p>
            <p class="text-lg md:text-xl text-slate-200 mb-10 max-w-3xl mx-auto leading-relaxed slide-in-up font-medium" style="animation-delay: 0.4s;">
                The International Research Journal on Innovations in Engineering, Science and Technology, published by BatStateU Philippines, released annually for global academic advancement.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center slide-in-up" style="animation-delay: 0.6s;">
                <a href="#timeline" class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-xl backdrop-blur-md border border-white/20 font-bold transition-all">View Process</a>
                <a href="{{ route('register') }}" class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-2xl shadow-red-900/40 transition-all hover:-translate-y-1">Submit Manuscript</a>
            </div>
        </div>
    </div>

    <section id="timeline" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-black text-slate-900 tracking-tight mb-4">Submission Journey</h2>
                <div class="w-24 h-1.5 bg-red-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @php
                    $steps = [
                        ['n' => '01', 't' => 'Submission', 'd' => 'Authors upload manuscripts and provide metadata through our portal.', 'c' => 'bg-red-600'],
                        ['n' => '02', 't' => 'Peer Review', 'd' => 'Assigned experts evaluate research quality and provide feedback.', 'c' => 'bg-slate-900'],
                        ['n' => '03', 't' => 'Editorial', 'd' => 'Editors make final decisions based on reviewer recommendations.', 'c' => 'bg-slate-900'],
                        ['n' => '04', 't' => 'Publication', 'd' => 'Accepted works are indexed and published in annual volumes.', 'c' => 'bg-red-600']
                    ];
                @endphp
                @foreach($steps as $step)
                <div class="relative p-8 rounded-4xl bg-slate-50 border border-slate-100 hover:shadow-xl hover:bg-white transition-all group">
                    <div class="absolute -top-4 -left-4 w-12 h-12 {{ $step['c'] }} text-white flex items-center justify-center rounded-2xl font-black shadow-lg shadow-red-100">{{ $step['n'] }}</div>
                    <h3 class="text-xl font-black mb-3 mt-4">{{ $step['t'] }}</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">{{ $step['d'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 bg-red-600 relative overflow-hidden">
        <div class="max-w-4xl mx-auto text-center relative z-10 px-4">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Ready to Publish Your Research?</h2>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-red-600 px-10 py-4 rounded-xl font-black uppercase tracking-widest text-sm hover:bg-slate-50 transition-all shadow-xl">Sign Up Now</a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest text-sm hover:bg-white hover:text-red-600 transition-all">Sign In</a>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 border-b border-slate-800 pb-12">
                <div>
                    <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Contact Details</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li>✉️ irjiest@g.batstate-u.edu.ph</li>
                        <li>📞 +63 43 980 0385 loc 1151</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Institution</h4>
                    <p class="text-sm font-black text-slate-300">Batangas State University</p>
                    <p class="text-xs mt-2 uppercase tracking-tighter">Leading Innovations, Transforming Lives</p>
                </div>
                <div class="flex justify-end items-end">
                    <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-600">© 2026 IRJIEST | All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
