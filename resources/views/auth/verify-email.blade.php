@extends('layouts.app')
@section('title', 'Verify Email | JOURNAL SYSTEM')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet"
    />
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }
        @keyframes card-in {
            from {
                opacity: 0;
                transform: translateY(28px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        @keyframes pulse-dot {
            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(201, 168, 76, 0.6);
            }
            50% {
                box-shadow: 0 0 0 5px rgba(201, 168, 76, 0);
            }
        }

        .font-playfair {
            font-family: 'Playfair Display', Georgia, serif;
        }
        .font-dm {
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        .shimmer-bar {
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(201, 168, 76, 0.15) 30%,
                rgba(240, 214, 120, 0.7) 50%,
                rgba(201, 168, 76, 0.15) 70%,
                transparent 100%
            );
            background-size: 200% 100%;
            animation: shimmer 3.5s linear infinite;
        }

        .verify-card {
            animation: card-in 0.75s cubic-bezier(0.22, 0.68, 0, 1.2) 0.15s both;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.3rem 0.875rem;
            border: 1px solid rgba(255, 255, 255, 0.22);
            background: rgba(0, 0, 0, 0.2);
            border-radius: 999px;
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #f0d678;
            font-weight: 600;
        }
        .pulse-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background: #c9a84c;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        /* OTP input boxes */
        .otp-wrapper {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 0.5rem;
        }
        .otp-digit {
            width: 3rem;
            height: 3.5rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            background: #f8f9fc;
            border: 1.5px solid #e2e8f2;
            border-radius: 12px;
            color: #0d1628;
            outline: none;
            transition:
                border-color 0.2s,
                box-shadow 0.2s,
                background 0.2s;
            caret-color: transparent;
        }
        .otp-digit:focus {
            border-color: #c9a84c;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.12);
        }
        .otp-digit.filled {
            border-color: #c9a84c;
            background: rgba(201, 168, 76, 0.05);
        }

        .lp-btn {
            width: 100%;
            padding: 0.85rem 1rem;
            background: linear-gradient(135deg, #c9a84c 0%, #a07830 100%);
            color: #fff;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow:
                0 4px 18px rgba(160, 120, 48, 0.4),
                0 1px 3px rgba(160, 120, 48, 0.25);
            transition:
                transform 0.2s cubic-bezier(0.22, 0.68, 0, 1.2),
                box-shadow 0.2s;
        }
        .lp-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.15) 0%,
                transparent 60%
            );
            pointer-events: none;
        }
        .lp-btn:hover {
            transform: translateY(-2px);
            box-shadow:
                0 8px 28px rgba(160, 120, 48, 0.5),
                0 2px 6px rgba(160, 120, 48, 0.3);
        }
        .lp-btn:active {
            transform: translateY(0);
        }
        .lp-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .lp-error {
            background: #fff8f8;
            border: 1.5px solid #fecaca;
            border-left: 4px solid #dc2626;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            color: #991b1b;
            margin-bottom: 1.25rem;
        }
        .lp-success {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-left: 4px solid #16a34a;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            color: #15803d;
            margin-bottom: 1.25rem;
        }

        /* Countdown */
        .countdown-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            color: #a0aab8;
            margin-bottom: 1.5rem;
        }
        .countdown-wrap .time {
            font-weight: 700;
            color: #c9a84c;
            min-width: 2.5rem;
            text-align: center;
        }
        .countdown-wrap .time.urgent {
            color: #dc2626;
        }

        /* Resend button */
        .resend-btn {
            background: none;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            color: #a07830;
            cursor: pointer;
            border-bottom: 1px dashed rgba(160, 120, 48, 0.4);
            padding: 0;
            transition: color 0.2s;
        }
        .resend-btn:hover {
            color: #c9a84c;
        }
        .resend-btn:disabled {
            color: #b0bac8;
            border-color: transparent;
            cursor: not-allowed;
        }

        .form-section-label {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #a07830;
            margin-bottom: 0.75rem;
        }
        .form-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(201, 168, 76, 0.2);
        }

        .email-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 999px;
            padding: 0.3rem 0.875rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #a07830;
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div
        class="font-dm flex flex-col md:flex-row min-h-[calc(100vh-64px)] overflow-x-hidden"
    >
        {{-- ══════════ LEFT: Brand Panel ══════════ --}}
        <div
            class="relative flex-none md:w-[42%] flex flex-col justify-center px-6 py-10 md:p-14 lg:p-20 overflow-hidden"
            style="
                background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1400&q=85&auto=format&fit=crop&crop=center');
                background-size: cover;
                background-position: center 30%;
            "
        >
            <div
                class="absolute inset-0 z-1"
                style="
                    background: linear-gradient(
                        160deg,
                        rgba(18, 72, 65, 0.91) 0%,
                        rgba(36, 105, 96, 0.86) 40%,
                        rgba(28, 84, 76, 0.93) 100%
                    );
                    mix-blend-mode: multiply;
                "
            ></div>
            <div
                class="absolute inset-0 z-2 pointer-events-none"
                style="
                    background:
                        radial-gradient(
                            ellipse 70% 55% at 80% 15%,
                            rgba(201, 168, 76, 0.18) 0%,
                            transparent 55%
                        ),
                        radial-gradient(
                            ellipse 65% 65% at 0% 90%,
                            rgba(0, 0, 0, 0.45) 0%,
                            transparent 50%
                        );
                "
            ></div>
            <div
                class="absolute inset-0 z-3 opacity-[.04] pointer-events-none"
                style="
                    background-image: radial-gradient(
                        circle,
                        #fff 1px,
                        transparent 1px
                    );
                    background-size: 26px 26px;
                "
            ></div>
            <div
                class="top-accent shimmer-bar"
                style="
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 2px;
                    z-index: 20;
                "
            ></div>

            <div class="relative z-10 max-w-sm">
                <div class="mb-6">
                    <div class="stat-pill">
                        <span class="pulse-dot"></span>
                        <span>Email Verification</span>
                    </div>
                </div>

                <h1
                    class="font-playfair text-white text-3xl md:text-4xl font-bold leading-[1.2] mb-4"
                    style="text-shadow: 0 2px 6px rgba(0, 0, 0, 0.25)"
                >
                    One last
                    <em
                        class="not-italic font-normal block mt-1"
                        style="
                            background: linear-gradient(
                                90deg,
                                #c9a84c,
                                #f0d678,
                                #c9a84c
                            );
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;
                        "
                    >
                        step.
                    </em>
                </h1>

                <p
                    class="text-white/75 text-sm leading-relaxed border-l-2 border-[#c9a84c]/50 pl-4 mb-8"
                    style="text-shadow: 0 2px 6px rgba(0, 0, 0, 0.25)"
                >
                    We sent a 6-digit verification code to your email address.
                    Enter it to activate your account.
                </p>

                <div class="w-10 h-0.5 rounded-full bg-[#c9a84c] mb-6"></div>

                <div class="space-y-3">
                    @foreach ([
                            ['01', 'Check your inbox', 'Look for an email from Journal System'],
                            ['02', 'Enter the 6-digit code', 'Valid for 10 minutes only'],
                            ['03', 'Access the portal', 'Your account will be activated instantly']
                        ]
                        as [$n, $title, $sub])
                        <div class="flex items-start gap-3">
                            <span
                                class="font-playfair text-[#c9a84c]/50 text-xs font-bold mt-0.5 w-5 shrink-0"
                            >
                                {{ $n }}
                            </span>
                            <div>
                                <div
                                    class="text-white text-[.8rem] font-semibold"
                                >
                                    {{ $title }}
                                </div>
                                <div class="text-white/55 text-[.7rem]">
                                    {{ $sub }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ══════════ RIGHT: Verify Form ══════════ --}}
        <div
            class="flex-1 flex items-start md:items-center justify-center p-3 sm:p-6 md:p-10 lg:p-14 relative overflow-y-auto"
            style="
                background: linear-gradient(
                    145deg,
                    #f7f3ec 0%,
                    #ede8df 50%,
                    #e8e2f5 100%
                );
            "
        >
            <div
                class="absolute inset-0 opacity-[.03] pointer-events-none"
                style="
                    background-image: repeating-linear-gradient(
                        -50deg,
                        #8a6520 0px,
                        #8a6520 1px,
                        transparent 1px,
                        transparent 22px
                    );
                "
            ></div>

            <div
                class="verify-card relative z-10 w-full max-w-md bg-white/85 backdrop-blur-2xl border border-[#c9a84c]/18 rounded-2xl shadow-2xl shadow-[#a07830]/12 overflow-hidden my-4 md:my-6"
            >
                <div class="h-0.75 w-full shimmer-bar"></div>

                <div class="p-6 sm:p-8 md:p-10">
                    {{-- Brand label --}}
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-5 h-[1.5px] bg-[#c9a84c]/60"></div>
                        <span
                            class="text-[.6rem] tracking-[.2em] uppercase text-[#a07830] font-semibold"
                        >
                            Journal System
                        </span>
                    </div>

                    <h2
                        class="font-playfair text-[1.3rem] sm:text-[1.6rem] font-bold text-[#0d1628] leading-tight mb-1"
                    >
                        Verify your email
                    </h2>
                    <p class="text-[.78rem] text-[#8a96a8] font-light mb-5">
                        Enter the 6-digit code we sent to your inbox.
                    </p>

                    {{-- Email badge --}}
                    @if (session('pending_email'))
                        <div class="flex justify-center">
                            <div class="email-badge">
                                <svg
                                    width="12"
                                    height="12"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                                    />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                                {{ session('pending_email') }}
                            </div>
                        </div>
                    @endif

                    {{-- Alerts --}}
                    @if ($errors->any())
                        <div class="lp-error" role="alert">
                            <div class="flex items-start gap-2">
                                <svg
                                    class="mt-0.5 shrink-0"
                                    width="14"
                                    height="14"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                {{ $errors->first('token') }}
                            </div>
                        </div>
                    @endif

                    @if (session('resent'))
                        <div class="lp-success" role="alert">
                            <div class="flex items-start gap-2">
                                <svg
                                    class="mt-0.5 shrink-0"
                                    width="14"
                                    height="14"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                A new verification code has been sent to your
                                email.
                            </div>
                        </div>
                    @endif

                    {{-- OTP Form --}}
                    <form
                        method="POST"
                        action="{{ route('verify.email') }}"
                        id="otp-form"
                    >
                        @csrf

                        <div class="form-section-label">Verification Code</div>

                        {{-- 6 separate digit boxes --}}
                        <div class="otp-wrapper" id="otp-boxes">
                            @for ($i = 1; $i <= 6; $i++)
                                <input
                                    type="text"
                                    maxlength="1"
                                    inputmode="numeric"
                                    pattern="[0-9]"
                                    class="otp-digit"
                                    data-index="{{ $i - 1 }}"
                                    autocomplete="off"
                                />
                            @endfor
                        </div>

                        {{-- Hidden input na yung actual value --}}
                        <input type="hidden" name="token" id="otp-hidden" />

                        {{-- Countdown --}}
                        <div class="countdown-wrap">
                            <svg
                                width="12"
                                height="12"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            Code expires in
                            <span class="time" id="countdown">10:00</span>
                        </div>

                        <button
                            type="submit"
                            class="lp-btn"
                            id="submit-btn"
                            disabled
                        >
                            <span
                                style="
                                    position: relative;
                                    z-index: 1;
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                "
                            >
                                Verify Email
                                <svg
                                    width="14"
                                    height="14"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.2"
                                    viewBox="0 0 24 24"
                                >
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </span>
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div
                        style="
                            display: flex;
                            align-items: center;
                            gap: 0.75rem;
                            margin: 1.25rem 0;
                        "
                    >
                        <div
                            style="flex: 1; height: 1px; background: #ede8de"
                        ></div>
                        <span
                            style="
                                font-size: 0.6rem;
                                color: #b8aa90;
                                text-transform: uppercase;
                                letter-spacing: 0.18em;
                                white-space: nowrap;
                            "
                        >
                            Didn't receive it?
                        </span>
                        <div
                            style="flex: 1; height: 1px; background: #ede8de"
                        ></div>
                    </div>

                    {{-- Resend --}}
                    <form
                        method="POST"
                        action="{{ route('verify.email.resend') }}"
                        id="resend-form"
                    >
                        @csrf
                        <p class="text-center text-[.8rem] text-[#8a96a8]">
                            Check your spam folder or&nbsp;
                            <button
                                type="submit"
                                class="resend-btn"
                                id="resend-btn"
                            >
                                resend the code
                            </button>
                        </p>
                    </form>

                    {{-- Back to register --}}
                    <p class="text-center mt-4 text-[.8rem] text-[#8a96a8]">
                        Wrong email?&nbsp;
                        <a
                            href="{{ route('register') }}"
                            class="text-[#a07830] font-semibold border-b border-dashed border-[#a07830]/40 hover:text-[#c9a84c] transition-colors"
                        >
                            Go back
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const digits = document.querySelectorAll('.otp-digit');
            const hidden = document.getElementById('otp-hidden');
            const submit = document.getElementById('submit-btn');
            const resend = document.getElementById('resend-btn');

            // ── OTP digit navigation ──
            digits.forEach((input, idx) => {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '').slice(-1);
                    this.classList.toggle('filled', this.value !== '');

                    if (this.value && idx < digits.length - 1) {
                        digits[idx + 1].focus();
                    }

                    syncHidden();
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && !this.value && idx > 0) {
                        digits[idx - 1].focus();
                        digits[idx - 1].value = '';
                        digits[idx - 1].classList.remove('filled');
                        syncHidden();
                    }
                });

                // Handle paste on any digit
                input.addEventListener('paste', function (e) {
                    e.preventDefault();
                    const pasted = (e.clipboardData || window.clipboardData)
                        .getData('text')
                        .replace(/[^0-9]/g, '')
                        .slice(0, 6);
                    pasted.split('').forEach((char, i) => {
                        if (digits[i]) {
                            digits[i].value = char;
                            digits[i].classList.add('filled');
                        }
                    });
                    const next = Math.min(pasted.length, digits.length - 1);
                    digits[next].focus();
                    syncHidden();
                });
            });

            function syncHidden() {
                const val = [...digits].map((d) => d.value).join('');
                hidden.value = val;
                submit.disabled = val.length < 6;
            }

            // Auto-focus first box
            digits[0].focus();

            // ── Countdown timer (10 min) ──
            const countdownEl = document.getElementById('countdown');
            let seconds = 10 * 60;

            const timer = setInterval(() => {
                seconds--;
                const m = Math.floor(seconds / 60)
                    .toString()
                    .padStart(2, '0');
                const s = (seconds % 60).toString().padStart(2, '0');
                countdownEl.textContent = `${m}:${s}`;

                if (seconds <= 60) countdownEl.classList.add('urgent');

                if (seconds <= 0) {
                    clearInterval(timer);
                    countdownEl.textContent = 'Expired';
                    submit.disabled = true;
                    submit.textContent = 'Code expired';
                }
            }, 1000);

            // ── Resend cooldown (60s) ──
            let resendCooldown = 0;

            document
                .getElementById('resend-form')
                .addEventListener('submit', function () {
                    resendCooldown = 60;
                    resend.disabled = true;

                    const cd = setInterval(() => {
                        resendCooldown--;
                        resend.textContent = `resend the code (${resendCooldown}s)`;
                        if (resendCooldown <= 0) {
                            clearInterval(cd);
                            resend.disabled = false;
                            resend.textContent = 'resend the code';
                        }
                    }, 1000);
                });
        });
    </script>
@endsection
