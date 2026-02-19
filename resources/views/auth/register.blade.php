@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-md">

        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800">Create an account</h2>
            <p class="mt-1 text-sm text-red-700 font-semibold">Batangas State University</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                           @error('name') border-red-500 @enderror"/>
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                           @error('email') border-red-500 @enderror"/>
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                           @error('password') border-red-500 @enderror"/>
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"/>
            </div>

            {{-- Roles --}}
            <div>
                <p class="block text-sm font-medium text-gray-700 mb-2">
                    Register as <span class="text-gray-400 font-normal">(select at least one)</span>
                </p>
                <div class="grid grid-cols-3 gap-2">
                    @foreach ([
                        'author'          => 'Author',
                        'reviewer'        => 'Reviewer',
                        'editor'          => 'Editor',
                    ] as $value => $label)
                        <label class="flex flex-col items-center justify-center gap-1 border rounded-lg p-3 cursor-pointer
                                      transition hover:border-red-400 hover:bg-red-50
                                      has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                            <input type="checkbox" name="roles[]" value="{{ $value }}"
                                {{ in_array($value, old('roles', [])) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500"/>
                            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                       text-sm font-medium text-white bg-red-700 hover:bg-red-800
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                Register
            </button>

            <p class="text-center text-sm text-gray-500">
                Already have an account?
                <a href="{{ route('login') }}" class="text-red-700 font-medium hover:underline">Sign in</a>
            </p>
        </form>
    </div>
</div>
@endsection