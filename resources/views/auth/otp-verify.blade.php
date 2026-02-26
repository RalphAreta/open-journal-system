@extends('layouts.app')
@section('title', 'Verify Email | JOURNAL SYSTEM')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600&display=swap"
        rel="stylesheet"
    />
@endpush

@section('content')
    <div
        class="flex flex-col md:flex-row min-h-[calc(100vh-64px)] overflow-hidden font-['Source_Sans_3']"
    >
        {{-- LEFT SIDE --}}
        <div
            class="relative flex-none md:w-2/5 flex flex-col justify-center px-8 py-12 md:p-16 overflow-hidden bg-[#2D8176] z-10"
        >
            <div class="absolute inset-0 z-0 bg-black/15"></div>
            <div class="relative z-20">
                <div
                    class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full border border-white/30 bg-black/20 text-[10px] tracking-widest uppercase text-[#f0d678] font-semibold mb-7"
                >
                    <span class="w-1.5 h-1.5 rounded-full bg-[#c9a84c]"></span>
                    Email Verification
                </div>
                <h2
                    class="font-['Libre_Baskerville'] text-4xl lg:text-5xl font-bold leading-[1.15] text-white mb-6"
                >
                    Check your
                    <br />
                    <em
                        class="not-italic font-normal block bg-gradient-to-r from-[#c9a84c] via-[#f0d678] to-[#c9a84c] bg-clip-text text-transparent italic"
                    >
                        Inbox.
                    </em>
                </h2>
                <p
                    class="text-[14px] leading-relaxed font-medium text-white/90 border-l-2 border-[#c9a84c]/50 pl-4"
                >
                    We sent a 6-digit verification code to your email address.
                    Enter it below to activate your account.
                </p>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div
            class="flex-1 flex items-center justify-center p-6 md:p-10 bg-gradient-to-br from-[#f5f0e8] via-[#ede5d5] to-[#e4daf0]"
        >
            <div
                class="relative z-10 w-full max-w-[420px] bg-white/90 border border-[#c9a84c]/20 rounded-[20px] p-8 md:p-10 backdrop-blur-xl shadow-2xl"
            >
                <div class="mb-6 text-center">
                    <div
                        class="w-16 h-16 bg-[#c9a84c]/10 rounded-full flex items-center justify-center mx-auto mb-4"
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
                        class="font-['Libre_Baskerville'] text-2xl font-bold text-[#0d1628]"
                    >
                        Enter your code
                    </h1>
                    <p class="text-[13px] text-[#8a96a8] mt-1">
                        Check your email for the 6-digit code.
                    </p>
                </div>

                @if (session('message'))
                    <div
                        class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 text-center"
                    >
                        {{ session('message') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 text-center"
                    >
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify.submit') }}">
                    @csrf
                    <div class="mb-4">
                        <label
                            class="block text-[10px] font-semibold tracking-wider uppercase text-[#6a7890] mb-2 text-center"
                        >
                            Verification Code
                        </label>
                        <input
                            type="text"
                            name="otp"
                            maxlength="6"
                            autofocus
                            placeholder="000000"
                            class="w-full px-4 py-3 bg-[#fafbfd] border-[1.5px] border-[#dde4ee] rounded-xl text-2xl font-bold text-center tracking-[0.5em] outline-none focus:border-[#c9a84c] transition-all text-[#0d1628]"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 bg-gradient-to-br from-[#c9a84c] to-[#a07830] text-white text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg hover:-translate-y-0.5 transition-all"
                    >
                        Verify Email
                    </button>
                </form>

                <form
                    method="POST"
                    action="{{ route('otp.resend') }}"
                    class="mt-4"
                >
                    @csrf
                    <button
                        type="submit"
                        class="w-full py-2.5 border-[1.5px] border-[#dde4ee] text-[#6a7890] text-[11px] font-semibold uppercase tracking-widest rounded-xl hover:border-[#c9a84c] hover:text-[#a07830] transition-all"
                    >
                        Resend Code
                    </button>
                </form>

                <p class="mt-6 text-center text-xs text-[#8a96a8]">
                    Wrong account?
                    <a
                        href="{{ route('login') }}"
                        class="text-[#a07830] font-semibold hover:text-[#c9a84c] underline underline-offset-4"
                    >
                        Sign in instead
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
