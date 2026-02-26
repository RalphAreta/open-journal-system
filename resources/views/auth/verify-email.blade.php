@extends('layouts.app')
@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#f5f0e8] via-[#ede5d5] to-[#e4daf0]"
    >
        <div
            class="w-full max-w-md bg-white/90 border border-[#c9a84c]/20 rounded-[20px] p-10 shadow-2xl text-center"
        >
            <div
                class="w-16 h-16 bg-[#c9a84c]/10 rounded-full flex items-center justify-center mx-auto mb-6"
            >
                <svg
                    class="w-8 h-8 text-[#a07830]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                </svg>
            </div>

            <h1
                class="font-['Libre_Baskerville'] text-2xl font-bold text-[#0d1628] mb-2"
            >
                Verify your email
            </h1>
            <p class="text-sm text-[#8a96a8] mb-6 leading-relaxed">
                We sent a verification link to your email address. Please check
                your inbox and click the link to activate your account.
            </p>

            @if (session('message'))
                <div
                    class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700"
                >
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full py-3 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg hover:-translate-y-0.5 transition-all"
                >
                    Resend Verification Email
                </button>
            </form>

            <p class="mt-6 text-xs text-[#8a96a8]">
                Wrong email?
                <a
                    href="{{ route('login') }}"
                    class="text-[#a07830] font-semibold hover:text-[#c9a84c] underline underline-offset-4"
                >
                    Sign in with another account
                </a>
            </p>
        </div>
    </div>
@endsection
