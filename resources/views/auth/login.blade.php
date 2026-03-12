@extends('layouts.app')
@section('title', 'Sign In | Journal System')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal:       #2d8176;
            --teal-dk:    #1a4d46;
            --teal-lt:    #e8f4f2;
            --gold:       #c9a84c;
            --gold-lt:    #f5e9c4;
            --gold-dk:    #8a6e28;
            --ink:        #1a1209;
            --ink-mid:    #3d2f1a;
            --ink-soft:   #6b5740;
            --cream:      #faf6ef;
            --parchment:  #f3ece0;
            --border:     #e8dfd0;
            --border-dk:  #c9b99a;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background: var(--cream);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Shimmer bar ── */
        .shimmer-bar {
            height: 3px;
            background: linear-gradient(
                90deg,
                transparent 0%,
                var(--gold-lt) 20%,
                var(--gold) 40%,
                #f0d678 50%,
                var(--gold) 60%,
                var(--gold-lt) 80%,
                transparent 100%
            );
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer {
            from { background-position: -200% 0; }
            to   { background-position:  200% 0; }
        }

        /* ── Layout ── */
        .login-wrap {
            display: flex;
            min-height: calc(100vh - 67px); /* below shimmer+nav */
        }

        /* ── LEFT PANEL ── */
        .login-left {
            flex: none;
            width: 50%;
            background: var(--teal-dk);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px 64px;
            overflow: hidden;
        }
        @media (max-width: 860px) { .login-left { display: none; } }

        /* grid lines like hero */
        .login-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(201,168,76,0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,168,76,0.07) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        /* gold glow */
        .login-left::after {
            content: '';
            position: absolute;
            top: -20%; right: -15%;
            width: 70%; height: 130%;
            background: radial-gradient(ellipse at center,
                rgba(201,168,76,0.14) 0%,
                rgba(45,129,118,0.06) 40%,
                transparent 68%);
            pointer-events: none;
        }
        .lp-photo {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1400&q=80');
            background-size: cover;
            background-position: center 30%;
            opacity: 0.1;
        }
        .lp-circle-1 {
            position: absolute; top: 10%; right: 6%;
            width: 280px; height: 280px;
            border-radius: 50%;
            border: 1px solid rgba(201,168,76,0.14);
        }
        .lp-circle-2 {
            position: absolute; bottom: -8%; left: -6%;
            width: 340px; height: 340px;
            border-radius: 50%;
            border: 1px solid rgba(201,168,76,0.07);
        }

        .lp-content { position: relative; z-index: 10; max-width: 440px; }

        .lp-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 24px;
        }
        .lp-eyebrow::before {
            content: '';
            width: 24px; height: 1px;
            background: var(--gold);
        }

        .lp-heading {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(2.2rem, 3.5vw, 3.4rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.13;
            letter-spacing: -0.02em;
            margin-bottom: 18px;
        }
        .lp-heading em { font-style: italic; color: var(--gold); }

        .lp-desc {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            margin-bottom: 40px;
            max-width: 380px;
        }

        .lp-divider {
            width: 48px; height: 1.5px;
            background: linear-gradient(90deg, var(--gold), transparent);
            margin-bottom: 28px;
        }

        .lp-quote-wrap { display: flex; gap: 14px; }
        .lp-quote-mark {
            font-family: 'Libre Baskerville', serif;
            font-size: 3.5rem;
            color: rgba(201,168,76,0.25);
            line-height: 1;
            flex-shrink: 0;
            margin-top: -8px;
        }
        .lp-quote-text {
            font-family: 'Libre Baskerville', serif;
            font-style: italic;
            font-size: 0.88rem;
            color: rgba(255,255,255,0.75);
            line-height: 1.75;
            padding-top: 6px;
        }

        /* Trust chips at bottom */
        .lp-trust {
            position: absolute;
            bottom: 40px; left: 64px; right: 64px;
            z-index: 10;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        .lp-trust-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
        }
        .lp-trust-chip::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0.5;
        }

        /* ── RIGHT PANEL ── */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            background: var(--parchment);
            position: relative;
            overflow: hidden;
        }
        /* subtle diagonal texture */
        .login-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                -50deg,
                rgba(138,110,40,0.025) 0px,
                rgba(138,110,40,0.025) 1px,
                transparent 1px,
                transparent 22px
            );
        }
        /* decorative circles */
        .rp-circle-a {
            position: absolute;
            top: -80px; right: -60px;
            width: 320px; height: 320px;
            border-radius: 50%;
            border: 1px solid rgba(201,168,76,0.1);
        }
        .rp-circle-b {
            position: absolute;
            bottom: -60px; left: -50px;
            width: 240px; height: 240px;
            border-radius: 50%;
            border: 1px solid rgba(45,129,118,0.1);
        }

        /* ── Form Card ── */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 44px 40px 40px;
            box-shadow: 0 24px 64px rgba(26,18,9,0.09), 0 4px 16px rgba(26,18,9,0.04);

            opacity: 0;
            transform: translateY(22px);
            animation: fadeUp 0.65s ease 0.1s forwards;
        }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

       

        /* ── Card header ── */
        .card-eyebrow {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.63rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold-dk);
            margin-bottom: 10px;
        }
        .card-eyebrow::before,
        .card-eyebrow::after {
            content: '';
            height: 1px;
            background: var(--border-dk);
            flex: 1;
        }

        .card-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .card-sub {
            font-size: 0.82rem;
            color: var(--ink-soft);
            margin-bottom: 28px;
        }

        /* ── Error box ── */
        .error-box {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-left: 4px solid #dc2626;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 18px;
            font-size: 0.8rem;
            color: #991b1b;
        }
        .error-box ul { list-style: disc; padding-left: 18px; }

        /* ── Form elements ── */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 7px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 11px 16px;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.88rem;
            color: var(--ink);
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
            appearance: none;
        }
        .form-input::placeholder { color: var(--border-dk); }
        .form-input:focus,
        .form-select:focus {
            border-color: var(--teal);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(45,129,118,0.1);
        }

        /* icon wrapper */
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--border-dk);
            pointer-events: none;
            display: flex;
            align-items: center;
        }
        .input-icon-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            font-size: 1rem;
            line-height: 1;
            color: var(--border-dk);
            transition: color 0.15s;
        }
        .input-icon-btn:hover { color: var(--teal); }

        /* select arrow */
        .select-arrow {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 0; height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid var(--border-dk);
            pointer-events: none;
        }

        /* ── Remember me ── */
        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 6px;
            cursor: pointer;
            font-size: 0.83rem;
            color: var(--ink-soft);
        }
        .remember-wrap input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--teal);
            cursor: pointer;
        }

        /* ── Divider ── */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 18px 0;
        }
        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .form-divider-text {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--border-dk);
            white-space: nowrap;
        }

        /* ── Submit button  (matches .btn-hero-primary from landing) ── */
        .btn-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            padding: 13px 24px;
            background: var(--gold);
            color: var(--ink);
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 6px 24px rgba(201,168,76,0.35);
            transition: background 0.15s, transform 0.12s, box-shadow 0.15s;
            position: relative;
            overflow: hidden;
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(255,255,255,0.12), transparent);
            pointer-events: none;
        }
        .btn-submit:hover {
            background: #d9b85c;
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(201,168,76,0.4);
        }
        .btn-submit:active { transform: translateY(0); }

        /* ── Footer link ── */
        .card-footer {
            text-align: center;
            margin-top: 22px;
            font-size: 0.82rem;
            color: var(--ink-soft);
        }
        .card-footer a {
            color: var(--teal);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed rgba(45,129,118,0.35);
            transition: color 0.15s, border-color 0.15s;
        }
        .card-footer a:hover {
            color: var(--teal-dk);
            border-color: rgba(45,129,118,0.6);
        }
    </style>
@endpush

@section('content')
    {{-- Shimmer bar (matches landing page top shimmer) --}}
    <div class="shimmer-bar"></div>

    <div class="login-wrap">

        {{-- ═══ LEFT PANEL ═══ --}}
        <div class="login-left">
            <div class="lp-photo"></div>
            <div class="lp-circle-1"></div>
            <div class="lp-circle-2"></div>

            <div class="lp-content">
              

                <h1 class="lp-heading">
                    Advancing<br>
                    Knowledge.<br>
                    <em>Inspiring<br>Innovation.</em>
                </h1>

                <p class="lp-desc">
                    The official international peer-reviewed journal publishing
                    high-impact research in engineering, science, information
                    technology, and innovation.
                </p>

                <div class="lp-divider"></div>

                <div class="lp-quote-wrap">
                    <span class="lp-quote-mark">"</span>
                    <p class="lp-quote-text">
                        Research is the foundation of progress — and progress
                        is the purpose of this platform.
                    </p>
                </div>
            </div>

            <div class="lp-trust">
                @foreach (['Double-Blind Review', 'Open Access', 'DOI Registered', 'Google Scholar'] as $t)
                    <span class="lp-trust-chip">{{ $t }}</span>
                @endforeach
            </div>
        </div>

        {{-- ═══ RIGHT PANEL ═══ --}}
        <div class="login-right">
            <div class="rp-circle-a"></div>
            <div class="rp-circle-b"></div>

            <div class="login-card">

                {{-- Card header --}}
                <p class="card-eyebrow">Journal System</p>
                <h2 class="card-title">Sign in to your account</h2>
                <p class="card-sub">Enter your credentials to access the portal.</p>

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Role --}}
                    <div class="form-group">
                        <label class="form-label" for="role">Sign in as</label>
                        <div class="input-wrap">
                            <select id="role" name="role" class="form-select" required>
                                <option value="" disabled selected>— Select your role —</option>
                                <option value="author"          @selected(old('role') == 'author')>Author</option>
                                <option value="reviewer"        @selected(old('role') == 'reviewer')>Reviewer</option>
                                <option value="editor"          @selected(old('role') == 'editor')>Editor</option>
                                <option value="editor-in-chief" @selected(old('role') == 'editor-in-chief')>Editor in Chief</option>
                                <option value="admin"           @selected(old('role') == 'admin')>Admin</option>
                                <option value="layout-editor"   @selected(old('role') == 'layout-editor')>Layout Editor</option>
                                <option value="managing-editor" @selected(old('role') == 'managing-editor')>Managing Editor</option>
                            </select>
                            <div class="select-arrow"></div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="input-wrap">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="form-input"
                                style="padding-right: 40px;"
                                placeholder="you@example.com"
                                value="{{ old('email') }}"
                                required
                            />
                            <span class="input-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-input"
                                style="padding-right: 44px;"
                                placeholder="••••••••"
                                required
                            />
                            <button
                                id="togglePwBtn"
                                type="button"
                                class="input-icon-btn"
                                onclick="togglePassword()"
                                title="Toggle password visibility"
                            >
                                😺
                            </button>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <label class="remember-wrap">
                        <input
                            type="checkbox"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        />
                        Keep me signed in
                    </label>

                    {{-- Divider --}}
                    <div class="form-divider">
                        <span class="form-divider-text">Secured Access</span>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14"/>
                        </svg>
                        Sign In to Portal
                    </button>
                </form>

                <p class="card-footer">
                    New to the journal? &nbsp;
                    <a href="{{ route('register') }}">Create Account</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const btn   = document.getElementById('togglePwBtn');
            if (input.type === 'password') {
                input.type      = 'text';
                btn.textContent = '🙀';
            } else {
                input.type      = 'password';
                btn.textContent = '😺';
            }
        }
    </script>
@endsection 