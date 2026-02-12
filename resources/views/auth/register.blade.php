@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-xl p-8 border border-slate-200">
    <div class="text-center mb-6">
        <img src="{{ asset('images/batstateu-logo.png') }}" alt="Batangas State University Logo" class="h-20 mx-auto mb-4">
        <h1 class="text-3xl font-bold text-red-700 mb-2">Create an account</h1>
        <p class="text-sm text-slate-600">Batangas State University</p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
            <input id="password" type="password" name="password" required
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500">
        </div>
        <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-md hover:bg-red-700 font-medium shadow-sm transition-colors">Register</button>
    </form>
    <p class="mt-6 text-sm text-center text-slate-600">Already have an account? <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-medium hover:underline">Sign in</a></p>
</div>
@endsection
