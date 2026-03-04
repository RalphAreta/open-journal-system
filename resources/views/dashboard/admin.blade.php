@extends('layouts.app')

@section('title', 'Admin Dashboard')

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
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 36px;
        }
        .hero-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .hero-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .hero-eyebrow::before {
            content: '';
            width: 24px;
            height: 1px;
            background: var(--teal);
        }
        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.15;
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-size: 0.98rem;
            font-weight: 400;
            color: var(--ink-soft);
            margin-top: 8px;
        }
        .date-pill {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--ink-soft);
            background: var(--parchment);
            border: 1px solid var(--border);
            padding: 6px 16px;
            border-radius: 20px;
        }

        /* ── Stat Grid ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        @media (max-width: 700px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }
        }
        .stat-cell {
            padding: 24px 22px 18px;
            border-right: 1px solid var(--border);
            position: relative;
            transition: background 0.18s;
            cursor: default;
            text-decoration: none;
            display: block;
        }
        .stat-cell:last-child {
            border-right: none;
        }
        .stat-cell:hover {
            background: #fff;
        }
        .stat-lbl {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 10px;
        }
        .stat-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 2.6rem;
            font-weight: 700;
            line-height: 1;
        }
        .stat-cta {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            transition: gap 0.15s;
        }
        .stat-cell:hover .stat-cta {
            gap: 9px;
        }
        .stat-cell .accent-line {
            position: absolute;
            bottom: 0;
            left: 22px;
            height: 2px;
            width: 0;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        .stat-cell:hover .accent-line {
            width: 36px;
        }

        .sv-teal {
            color: var(--teal);
        }
        .sv-gold {
            color: var(--gold-dk);
        }
        .sv-blue {
            color: var(--blue);
        }
        .cta-teal {
            color: var(--teal);
        }
        .cta-gold {
            color: var(--gold-dk);
        }
        .cta-blue {
            color: var(--blue);
        }
        .al-teal {
            background: var(--teal);
        }
        .al-gold {
            background: var(--gold);
        }
        .al-blue {
            background: var(--blue);
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
            margin-bottom: 16px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Feature Cards ── */
        .feature-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 1px 6px rgba(26, 18, 9, 0.05);
            transition:
                transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.22s;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(26, 18, 9, 0.1);
        }
        .feature-card-dashed {
            background: var(--parchment);
            border: 1.5px dashed var(--border-dk);
            box-shadow: none;
        }
        .feature-card-dashed:hover {
            transform: none;
            box-shadow: none;
        }
        .feature-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .feature-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
        }
        .feature-desc {
            font-size: 0.82rem;
            color: var(--ink-soft);
            line-height: 1.6;
        }

        .btn-manage {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: var(--teal);
            color: #fff;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 11px 22px;
            border-radius: 6px;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.28);
            width: 100%;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .btn-manage::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(201, 168, 76, 0.15) 0%,
                transparent 60%
            );
        }
        .btn-manage:hover {
            background: var(--teal-dk);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(45, 129, 118, 0.34);
        }

        /* ── Quick Actions ── */
        .action-card {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 8px 6px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        .action-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 14px;
            border-radius: 9px;
            text-decoration: none;
            transition: background 0.13s;
            margin: 2px 0;
        }
        .action-row:hover {
            background: var(--teal-lt);
        }
        .action-row:hover .action-name {
            color: var(--teal);
        }
        .action-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .action-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--ink);
            transition: color 0.13s;
        }
        .action-sub {
            font-size: 0.72rem;
            color: var(--ink-soft);
            margin-top: 2px;
        }
        .action-badge {
            font-size: 0.68rem;
            font-weight: 700;
            font-family: 'Source Sans 3', sans-serif;
            letter-spacing: 0.06em;
            padding: 3px 11px;
            border-radius: 20px;
            background: var(--parchment);
            color: var(--ink-soft);
            border: 1px solid var(--border);
            white-space: nowrap;
        }

        /* ── Health Strip ── */
        .health-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
        }
        @media (max-width: 800px) {
            .health-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        .health-cell {
            padding: 22px 20px 18px;
            border-right: 1px solid var(--border);
            text-align: center;
            position: relative;
            transition: background 0.15s;
        }
        .health-cell:last-child {
            border-right: none;
        }
        .health-cell:hover {
            background: #fff;
        }
        .health-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .health-ok {
            background: var(--teal);
            box-shadow: 0 0 6px rgba(45, 129, 118, 0.5);
        }
        .health-status-lbl {
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }
        .health-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink);
            margin: 8px 0 4px;
            line-height: 1;
        }
        .health-lbl {
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }
        .health-status {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--teal);
            margin-top: 5px;
        }
        .health-cell .accent-line {
            position: absolute;
            bottom: 0;
            left: 20px;
            height: 2px;
            width: 0;
            border-radius: 2px;
            background: var(--teal);
            transition: width 0.3s ease;
        }
        .health-cell:hover .accent-line {
            width: 30px;
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
        .fu4 {
            animation: fu 0.45s 0.32s ease both;
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
    <div class="aw aw-bg max-w-7xl mx-auto px-4">
        {{-- ── Hero ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Admin Dashboard</p>
                    <h1 class="hero-title">
                        System
                        <em>Administration</em>
                    </h1>
                    <p class="hero-sub">
                        Manage users, roles, submissions, and system
                        configuration
                    </p>
                </div>
                <div
                    class="flex items-center gap-3 self-start md:self-auto shrink-0"
                >
                    <span class="date-pill hidden sm:inline-block">
                        {{ now()->format('D, M j Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Stat Cards ── --}}
        <div class="stat-grid fu1 mb-10">
            <a href="{{ route('admin.users.index') }}" class="stat-cell">
                <p class="stat-lbl">Total Users</p>
                <p class="stat-val sv-teal">
                    {{ sprintf('%02d', $userCount) }}
                </p>
                <div class="stat-cta cta-teal">
                    Manage users
                    <svg
                        width="13"
                        height="13"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </div>
                <div class="accent-line al-teal"></div>
            </a>

            <a href="{{ route('admin.roles.index') }}" class="stat-cell">
                <p class="stat-lbl">System Roles</p>
                <p class="stat-val sv-gold">
                    {{ sprintf('%02d', $roleCount) }}
                </p>
                <div class="stat-cta cta-gold">
                    Manage roles
                    <svg
                        width="13"
                        height="13"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </div>
                <div class="accent-line al-gold"></div>
            </a>

            <a href="{{ route('admin.submissions') }}" class="stat-cell">
                <p class="stat-lbl">Submissions</p>
                <p class="stat-val sv-blue">
                    {{ sprintf('%02d', $submissionCount) }}
                </p>
                <div class="stat-cta cta-blue">
                    View submissions
                    <svg
                        width="13"
                        height="13"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </div>
                <div class="accent-line al-blue"></div>
            </a>
        </div>

        {{-- ── Two-column: Management Tools + Quick Actions ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10 fu2">
            {{-- Management Tools --}}
            <div>
                <div class="section-label">Management Tools</div>
                <div class="flex flex-col gap-4">
                    {{-- Editor Expertise --}}
                    <div class="feature-card">
                        <div class="flex items-start gap-4 mb-5">
                            <div
                                class="feature-icon"
                                style="background: var(--teal-lt)"
                            >
                                <svg
                                    width="20"
                                    height="20"
                                    fill="none"
                                    stroke="var(--teal)"
                                    stroke-width="1.7"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="feature-title">Editor Expertise</p>
                                <p class="feature-desc">
                                    Manage specialized research fields and
                                    configure reviewer–submission matching
                                    criteria.
                                </p>
                            </div>
                        </div>
                        <a
                            href="{{ route('admin.editor-expertise.index') }}"
                            class="btn-manage"
                        >
                            <svg
                                width="14"
                                height="14"
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
                            Manage Expertise System
                        </a>
                    </div>

                    {{-- Placeholder --}}
                    <div class="feature-card feature-card-dashed">
                        <div class="flex items-start gap-4">
                            <div
                                class="feature-icon"
                                style="background: var(--border)"
                            >
                                <svg
                                    width="18"
                                    height="18"
                                    fill="none"
                                    stroke="#c9b99a"
                                    stroke-width="1.7"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <p
                                    class="feature-title"
                                    style="color: var(--ink-soft)"
                                >
                                    More Tools
                                </p>
                                <p class="feature-desc" style="color: #c9b99a">
                                    Additional admin features can be added here
                                    as the system grows.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div>
                <div class="section-label">Quick Actions</div>
                <div class="action-card">
                    @php
                        $actions = [
                            [
                                'label' => 'User Management',
                                'sub' => 'Add, edit or deactivate accounts',
                                'route' => 'admin.users.index',
                                'dot' => 'var(--teal)',
                                'badge' => $userCount . ' users',
                            ],
                            [
                                'label' => 'Role Configuration',
                                'sub' => 'Define permissions & access levels',
                                'route' => 'admin.roles.index',
                                'dot' => 'var(--gold)',
                                'badge' => $roleCount . ' roles',
                            ],
                            [
                                'label' => 'All Submissions',
                                'sub' => 'System-wide manuscript view',
                                'route' => 'admin.submissions',
                                'dot' => 'var(--blue)',
                                'badge' => $submissionCount . ' total',
                            ],
                            [
                                'label' => 'Expertise Setup',
                                'sub' => 'Reviewer field matching',
                                'route' => 'admin.editor-expertise.index',
                                'dot' => 'var(--teal-dk)',
                                'badge' => 'Configure',
                            ],
                        ];
                    @endphp

                    @foreach ($actions as $action)
                        <a
                            href="{{ route($action['route']) }}"
                            class="action-row"
                        >
                            <div class="flex items-center gap-3">
                                <span
                                    class="action-dot"
                                    style="background: {{ $action['dot'] }}"
                                ></span>
                                <div>
                                    <p class="action-name">
                                        {{ $action['label'] }}
                                    </p>
                                    <p class="action-sub">
                                        {{ $action['sub'] }}
                                    </p>
                                </div>
                            </div>
                            <span class="action-badge">
                                {{ $action['badge'] }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── System Health ── --}}
        <div class="fu3 mb-12">
            <div class="section-label">System Health</div>
            <div class="health-grid">
                <div class="health-cell">
                    <div>
                        <span class="health-indicator health-ok"></span>
                        <span class="health-status-lbl">Database</span>
                    </div>
                    <div class="health-val">OK</div>
                    <div class="health-lbl">Connection</div>
                    <div class="health-status">Healthy</div>
                    <div class="accent-line"></div>
                </div>

                <div class="health-cell">
                    <div>
                        <span class="health-indicator health-ok"></span>
                        <span class="health-status-lbl">Users</span>
                    </div>
                    <div class="health-val serif">{{ $userCount }}</div>
                    <div class="health-lbl">Registered</div>
                    <div class="health-status">Active</div>
                    <div class="accent-line"></div>
                </div>

                <div class="health-cell">
                    <div>
                        <span class="health-indicator health-ok"></span>
                        <span class="health-status-lbl">Submissions</span>
                    </div>
                    <div class="health-val serif">{{ $submissionCount }}</div>
                    <div class="health-lbl">Total</div>
                    <div class="health-status">Tracked</div>
                    <div class="accent-line"></div>
                </div>

                <div class="health-cell">
                    <div>
                        <span class="health-indicator health-ok"></span>
                        <span class="health-status-lbl">Version</span>
                    </div>
                    <div
                        class="health-val"
                        style="font-size: 1.5rem; margin: 10px 0 6px"
                    >
                        v1.0
                    </div>
                    <div class="health-lbl">Journal System</div>
                    <div class="health-status">Up to date</div>
                    <div class="accent-line"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
