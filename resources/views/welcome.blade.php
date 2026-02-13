<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IRJIEST') }} - Welcome</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('{{ asset('images/homepage-webslider-1.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .hero-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.25) 100%);
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in-down { animation: slideInDown 0.8s ease-out forwards; }
        .slide-in-up { animation: slideInUp 0.8s ease-out forwards; opacity: 0; }
        .slide-in-up:nth-child(1) { animation-delay: 0.1s; }
        .slide-in-up:nth-child(2) { animation-delay: 0.2s; }
        .slide-in-up:nth-child(3) { animation-delay: 0.3s; }
        .slide-in-up:nth-child(4) { animation-delay: 0.4s; }

        .float-animation {
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 text-slate-900 font-sans antialiased flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white border-b-4 border-red-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-8">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/batstateu-logo.png') }}" alt="Batangas State University Logo" class="h-12 w-auto">
                        <span class="text-2xl font-bold bg-gradient-to-r from-red-600 to-red-700 bg-clip-text text-transparent">Batangas State University</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="hidden sm:inline text-sm text-slate-900 font-medium bg-slate-100 px-3 py-1 rounded-full">{{ auth()->user()->name }}</span>
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hidden sm:inline text-sm font-medium text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition-colors duration-200">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-red-600 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-[calc(100vh-80px)] flex items-center justify-center overflow-hidden hero-overlay" style="background-image: url('{{ asset('images/homepage-webslider-1.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="absolute inset-0 hero-overlay"></div>

        <!-- Floating decoration elements -->
        <div class="absolute top-10 right-20 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-5 float-animation"></div>
        <div class="absolute bottom-10 left-20 w-96 h-96 bg-red-400 rounded-full mix-blend-multiply filter blur-3xl opacity-5 float-animation" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Main Heading -->
            <h1 class="text-9xl sm:text-10xl font-bold text-white mb-6 slide-in-down" style="text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4); letter-spacing: -2px;">
                IRJIEST
            </h1>

            <!-- Tagline -->
            <p class="text-xl sm:text-xl font-semibold mb-6 bg-gradient-to-r from-orange-400 to-yellow-300 bg-clip-text text-transparent slide-in-up" style="text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
                ISSN 0115-8228 (Online)
            </p>

            <!-- Description -->
            <p class="text-lg sm:text-xl text-white mb-8 max-w-2xl mx-auto leading-relaxed slide-in-up" style="text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);">
                The International Research Journal on Innovations in Engineering, Science and Technology (IRJIEST), owned and published by the Batangas State University (BatStateU) Philippines , is released once a year in print and electronic formats. The online version may be accessed and downloaded for free.




        </div>
    </div>



    <!-- CTA Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-red-600 to-red-700">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Ready to Publish Your Research?</h2>
            <p class="text-lg text-red-50 mb-8">Join thousands of researchers already using IRJIEST to advance their academic careers</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-white text-red-600 px-8 py-3.5 rounded-lg hover:bg-slate-50 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl hover:scale-105 transform">
                        Sign Up Now
                    </a>
                @endif
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-red-800 text-white px-8 py-3.5 rounded-lg hover:bg-red-900 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl hover:scale-105 transform border-2 border-white">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-100 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h4 class="text-sm font-semibold text-white mb-3">Contact Us</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li class="flex items-start gap-2">
                            <span class="mt-1">📞</span> <span>+63 43 980 0385 loc 1151</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1">✉️</span> <a href="mailto:irjiest@g.batsate-u.edu.ph" class="hover:text-white transition-colors">irjiest@g.batsate-u.edu.ph</a>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1">📍</span> <span>Rizal Ave., Batangas City, Batangas State University Main Campus I</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white mb-3">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Register</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white mb-3">Institution</h4>
                    <p class="text-sm text-slate-400">Batangas State University</p>
                    <p class="text-sm text-slate-500 mt-1">© 2026 | All rights reserved</p>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-6 text-center text-sm text-slate-500">
                <p>Leading Innovations, Transforming Lives, Building the Nation</p>
            </div>
        </div>
    </footer>
</body>
</html>