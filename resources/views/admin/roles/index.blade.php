@extends('layouts.app')

@section('title', 'System Roles')

@push('styles')
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --teal-lt: #e8f4f2;
            --gold: #c9a84c;
            --gold-lt: #e8d49a;
            --gold-dk: #8a6e28;
            --blue: #2b5fa5;
            --blue-lt: #eaf0fa;
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
            --emerald: #1a4d46;
        }

        * {
            box-sizing: border-box;
        }

        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            font-size: 16px;
        }
        .serif {
            font-family: 'Libre Baskerville', serif;
        }

        .aw-bg {
            background-color: var(--cream);
            background-image:
                radial-gradient(
                    ellipse 80% 50% at 50% -10%,
                    rgba(45, 129, 118, 0.08) 0%,
                    transparent 70%
                ),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.5'/%3E%3C/svg%3E");
        }

        /* ── Hero Header ── */
        .hero-header {
            position: relative;
            padding: 28px 0 24px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 24px;
        }
        @media (min-width: 768px) {
            .hero-header {
                padding: 44px 0 32px;
                margin-bottom: 36px;
            }
        }
        .hero-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), transparent);
        }
        .hero-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold-dk);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .hero-eyebrow::before {
            content: '';
            width: 24px;
            height: 1px;
            background: var(--gold);
        }
        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.15;
        }
        @media (min-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
        }
        .hero-title em {
            font-style: italic;
            color: var(--gold-dk);
        }
        .hero-sub {
            font-size: 0.9rem;
            color: var(--ink-soft);
            margin-top: 8px;
        }
        @media (min-width: 768px) {
            .hero-sub {
                font-size: 0.98rem;
            }
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 14px;
        }
        .breadcrumb a {
            color: var(--teal);
            text-decoration: none;
            transition: opacity 0.15s;
        }
        .breadcrumb a:hover {
            opacity: 0.7;
        }
        .breadcrumb svg {
            color: var(--border-dk);
        }

        /* ── Back Button ── */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            color: var(--ink-soft);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 9px 14px;
            border-radius: 6px;
            text-decoration: none;
            transition:
                background 0.15s,
                color 0.15s,
                transform 0.12s;
            white-space: nowrap;
        }
        @media (min-width: 480px) {
            .btn-back {
                padding: 10px 18px;
            }
        }
        .btn-back:hover {
            background: #fff;
            color: var(--ink);
            transform: translateY(-1px);
        }

        /* ── Section Label ── */
        .section-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Role Cards ── */
        .roles-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        @media (min-width: 480px) {
            .roles-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
        }
        @media (min-width: 900px) {
            .roles-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }
        }

        .role-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(26, 18, 9, 0.05);
            transition:
                transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.22s,
                border-color 0.2s;
            position: relative;
        }
        .role-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(26, 18, 9, 0.1);
            border-color: var(--gold-lt);
        }

        .role-card-bar {
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--teal));
        }

        .role-card-body {
            padding: 16px;
        }
        @media (min-width: 480px) {
            .role-card-body {
                padding: 22px;
            }
        }

        .role-watermark {
            position: absolute;
            right: -10px;
            top: 10px;
            color: var(--parchment);
            transition: color 0.2s;
            pointer-events: none;
        }
        .role-card:hover .role-watermark {
            color: #ede8df;
        }

        .role-lbl {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 6px;
        }
        .role-name {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--gold-dk);
            font-style: italic;
            line-height: 1.25;
        }
        @media (min-width: 480px) {
            .role-name {
                font-size: 1.15rem;
            }
        }

        .role-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 14px 0;
        }
        @media (min-width: 480px) {
            .role-divider {
                margin: 18px 0;
            }
        }

        .role-footer {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 10px;
        }

        .role-user-lbl {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 4px;
        }
        .role-user-count {
            font-family: 'Libre Baskerville', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
        }
        @media (min-width: 480px) {
            .role-user-count {
                font-size: 2.4rem;
            }
        }

        .btn-configure {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--teal);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 9px 14px;
            border-radius: 6px;
            text-decoration: none;
            white-space: nowrap;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.22);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }
        @media (min-width: 480px) {
            .btn-configure {
                font-size: 0.68rem;
                padding: 10px 18px;
                gap: 7px;
            }
        }
        .btn-configure::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(201, 168, 76, 0.15) 0%,
                transparent 60%
            );
        }
        .btn-configure:hover {
            background: var(--teal-dk);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(45, 129, 118, 0.3);
        }

        .role-card .accent-line {
            position: absolute;
            bottom: 0;
            left: 22px;
            height: 2px;
            width: 0;
            border-radius: 2px;
            background: var(--gold);
            transition: width 0.3s ease;
        }
        .role-card:hover .accent-line {
            width: 40px;
        }

        /* ── Summary Strip ── */
        .summary-strip {
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 18px 20px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
            margin-bottom: 28px;
        }
        @media (min-width: 640px) {
            .summary-strip {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                padding: 20px 28px;
                gap: 16px;
                margin-bottom: 40px;
            }
        }
        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
            text-align: center;
        }
        @media (min-width: 640px) {
            .summary-item {
                text-align: left;
            }
        }
        .summary-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
        }
        @media (min-width: 640px) {
            .summary-val {
                font-size: 1.9rem;
            }
        }
        .summary-lbl {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }
        @media (min-width: 640px) {
            .summary-lbl {
                font-size: 0.64rem;
            }
        }
        .summary-divider {
            display: none;
        }
        @media (min-width: 640px) {
            .summary-divider {
                display: block;
                width: 1px;
                height: 36px;
                background: var(--border-dk);
            }
        }

        /* ── Animations ── */
        .fu {
            animation: fu 0.45s ease both;
        }
        .fu1 {
            animation: fu 0.45s 0.08s ease both;
        }
        .fu2 {
            animation: fu 0.45s 0.16s ease both;
        }
        .fu3 {
            animation: fu 0.45s 0.24s ease both;
        }

        @keyframes fu {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-7xl mx-auto px-4 sm:px-6">
        {{-- ── Hero ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div class="min-w-0 flex-1">
                    <nav class="breadcrumb">
                        <a href="{{ route('dashboard.admin') }}">Admin</a>
                        <svg
                            width="10"
                            height="10"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="3"
                            viewBox="0 0 24 24"
                        >
                            <path d="M9 5l7 7-7 7" />
                        </svg>
                        <span style="color: var(--ink)">Access Control</span>
                    </nav>
                    <p class="hero-eyebrow">System Administration</p>
                    <h1 class="hero-title">
                        Roles &amp;
                        <em>Permissions</em>
                    </h1>
                    <p class="hero-sub">
                        Define access levels and configure role-based
                        permissions across the system
                    </p>
                </div>
                <a
                    href="{{ route('dashboard.admin') }}"
                    class="btn-back self-start md:self-auto shrink-0"
                >
                    <svg
                        width="12"
                        height="12"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M15 19l-7-7 7-7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        {{-- ── Summary Strip ── --}}
        <div class="summary-strip fu1">
            <div class="summary-item">
                <span class="summary-val serif">{{ $roles->count() }}</span>
                <span class="summary-lbl">Total Roles</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-item">
                <span class="summary-val serif">
                    {{ $roles->sum(fn ($r) => $r->users_count ?? $r->users->count()) }}
                </span>
                <span class="summary-lbl">Users Assigned</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-item">
                <span class="summary-val serif" style="color: var(--teal)">
                    OK
                </span>
                <span class="summary-lbl">System Status</span>
            </div>
        </div>

        {{-- ── Roles Grid ── --}}
        <div class="fu2 mb-12">
            <div class="section-label">System Roles</div>
            <div class="roles-grid">
                @foreach ($roles as $role)
                    <div class="role-card">
                        <div class="role-card-bar"></div>

                        <div class="role-watermark">
                            <svg
                                width="88"
                                height="88"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>
                        </div>

                        <div class="role-card-body">
                            <div>
                                <p class="role-lbl">Role Name</p>
                                <p class="role-name">
                                    {{ $role->display_name }}
                                </p>
                            </div>

                            <hr class="role-divider" />

                            <div class="role-footer">
                                <div>
                                    <p class="role-user-lbl">Active Users</p>
                                    <p class="role-user-count">
                                        {{ sprintf('%02d', $role->users_count ?? $role->users->count()) }}
                                    </p>
                                </div>
                                <a
                                    href="{{ route('admin.roles.edit', $role) }}"
                                    class="btn-configure"
                                >
                                    <svg
                                        width="12"
                                        height="12"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                        />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    Configure
                                </a>
                            </div>
                        </div>

                        <div class="accent-line"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
