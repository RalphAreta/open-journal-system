<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - Open Journal System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 font-sans antialiased">
    <nav class="bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-semibold text-slate-800">OJS</a>
                    @auth
                        <div class="hidden sm:ml-8 sm:flex sm:space-x-4">
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100">Dashboard</a>
                            @if(auth()->user()->isAuthor())
                                <a href="{{ route('submissions.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100">My Submissions</a>
                            @endif
                            @if(auth()->user()->isReviewer())
                                <a href="{{ route('reviews.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100">My Reviews</a>
                            @endif
                            @if(auth()->user()->isEditor())
                                <a href="{{ route('editor.submissions') }}" class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100">Submissions</a>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100">Users</a>
                                <a href="{{ route('admin.roles.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100">Roles</a>
                                <a href="{{ route('admin.settings.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-100">Settings</a>
                            @endif
                        </div>
                    @endauth
                </div>
                <div class="flex items-center">
                    @auth
                        <span class="text-sm text-slate-500 mr-2">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-slate-600 hover:text-slate-900">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Login</a>
                        <a href="{{ route('register') }}" class="ml-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="mb-4 rounded-md bg-blue-50 p-4 text-sm text-blue-800">{{ session('info') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
