<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - IRJIEST</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 text-slate-900 font-sans antialiased flex flex-col">
    <nav class="bg-white border-b-4 border-red-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-8">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/batstateu-logo.png') }}" alt="Batangas State University Logo" class="h-12 w-auto">
                        <span class="text-4xl font-bold bg-gradient-to-r from-red-600 to-red-700 bg-clip-text text-transparent">IRJIEST</span>
                    </a>
                    @auth
                        <div class="hidden md:flex md:space-x-1">
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">Dashboard</a>
                            @if(auth()->user()->isAuthor())
                                <a href="{{ route('submissions.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">Submissions</a>
                            @endif
                            @if(auth()->user()->isReviewer())
                                <a href="{{ route('reviews.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">Reviews</a>
                            @endif
                            @if(auth()->user()->isEditor())
                                <a href="{{ route('editor.submissions') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">Submissions</a>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">Users</a>
                                <a href="{{ route('admin.roles.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">Roles</a>
                                <a href="{{ route('admin.settings.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">Settings</a>
                            @endif
                        </div>
                    @endauth
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="hidden sm:flex items-center space-x-3">
                            <span class="text-sm text-slate-900 font-medium bg-slate-100 px-3 py-1 rounded-full">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg transition-colors duration-200">Logout</button>
                            </form>
                        </div>
                        <div class="sm:hidden">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-red-600 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto w-full py-8 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 text-sm text-green-800 shadow-sm">
                <div class="flex items-center"><span class="text-lg mr-3">✓</span>{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 text-sm text-red-800 shadow-sm">
                <div class="flex items-center"><span class="text-lg mr-3">✕</span>{{ session('error') }}</div>
            </div>
        @endif
        @if(session('info'))
            <div class="mb-6 rounded-lg bg-blue-50 border-l-4 border-blue-500 p-4 text-sm text-blue-800 shadow-sm">
                <div class="flex items-center"><span class="text-lg mr-3">ℹ</span>{{ session('info') }}</div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-100 border-t border-slate-800 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold text-white mb-3">IRJIEST</h3>
                    <p class="text-sm text-slate-400">International Research Journal of Information Systems & Engineering Technology</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white mb-3">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a></li>
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
