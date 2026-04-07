@extends('layouts.app')

@section('title', 'Manage Editor Expertise')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-dark: #1a4d46;
            --teal-light: #e8f4f2;
            --ink: #1a1209;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
            --muted: #64748b;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
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
                margin-bottom: 32px;
            }
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
            color: var(--teal);
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

        /* ── Secondary button ── */
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 14px;
            background: var(--parchment);
            color: var(--ink-soft);
            border: 1.5px solid var(--border-dk);
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-decoration: none;
            transition:
                background 0.15s,
                border-color 0.15s,
                color 0.15s;
            white-space: nowrap;
        }
        @media (min-width: 480px) {
            .btn-secondary {
                font-size: 12px;
                padding: 9px 20px;
            }
        }
        .btn-secondary:hover {
            background: var(--white);
            border-color: var(--teal);
            color: var(--teal);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fu {
            animation: fadeUp 0.4s ease both;
        }
        .fu1 {
            animation: fadeUp 0.4s 0.07s ease both;
        }
        .fu2 {
            animation: fadeUp 0.4s 0.14s ease both;
        }

        /* ── Editor card ── */
        .editor-card {
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
            transition:
                border-color 0.18s,
                box-shadow 0.18s,
                transform 0.15s;
        }
        @media (min-width: 480px) {
            .editor-card {
                padding: 22px 24px;
            }
        }
        .editor-card:hover {
            border-color: var(--teal);
            box-shadow: 0 6px 24px rgba(45, 129, 118, 0.1);
            transform: translateY(-2px);
        }

        /* ── Card header: name+email left, button right ── */
        .card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }
        .card-name {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
            word-break: break-word;
        }
        @media (min-width: 480px) {
            .card-name {
                font-size: 1rem;
            }
        }
        .card-email {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
            word-break: break-all;
        }

        /* ── Manage button ── */
        .btn-manage {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background: var(--teal);
            color: #fff;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-decoration: none;
            transition:
                transform 0.14s,
                box-shadow 0.14s,
                filter 0.14s;
            box-shadow: 0 2px 8px rgba(45, 129, 118, 0.25);
            white-space: nowrap;
            flex-shrink: 0;
        }
        @media (min-width: 480px) {
            .btn-manage {
                font-size: 11px;
                padding: 7px 16px;
                gap: 6px;
            }
        }
        .btn-manage:hover {
            transform: translateY(-1px);
            filter: brightness(1.08);
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.3);
        }

        /* ── Expertise tag ── */
        .expertise-tag {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            background: var(--teal-light);
            border: 1px solid rgba(45, 129, 118, 0.3);
            color: var(--teal-dark);
        }

        /* ── Empty state ── */
        .empty-state {
            padding: 60px 24px;
            text-align: center;
        }
        @media (min-width: 768px) {
            .empty-state {
                padding: 80px 24px;
            }
        }
        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .empty-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-7xl mx-auto px-4 sm:px-6 pb-16">
        {{-- ── Hero Header ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Administration</p>
                    <h1 class="hero-title">
                        Editor
                        <em>Expertise</em>
                    </h1>
                    <p class="hero-sub">
                        Set and update fields of expertise for each editor
                    </p>
                </div>
                <div
                    class="flex items-center gap-3 self-start md:self-auto shrink-0"
                >
                    <span class="date-pill hidden sm:inline-block">
                        {{ now()->format('D, M j Y') }}
                    </span>
                    <a
                        href="{{ route('admin.expertise-categories.index') }}"
                        class="btn-secondary"
                    >
                        <svg
                            width="13"
                            height="13"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.2"
                        >
                            <path
                                d="M4 6h16M4 10h16M4 14h10"
                                stroke-linecap="round"
                            />
                        </svg>
                        Manage Categories
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Editor Cards ── --}}
        @if ($editors->count() > 0)
            <div
                class="fu1"
                style="display: flex; flex-direction: column; gap: 12px"
            >
                @foreach ($editors as $editor)
                    <div class="editor-card">
                        <div class="card-header">
                            <div class="min-w-0">
                                <p class="card-name">{{ $editor->name }}</p>
                                <p class="card-email">{{ $editor->email }}</p>
                            </div>
                            <a
                                href="{{ route('admin.editor-expertise.edit', $editor) }}"
                                class="btn-manage"
                            >
                                <svg
                                    width="11"
                                    height="11"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    />
                                </svg>
                                Manage
                            </a>
                        </div>

                        @if ($editor->editorExpertise->count() > 0)
                            <div
                                style="display: flex; flex-wrap: wrap; gap: 7px"
                            >
                                @foreach ($editor->editorExpertise as $expertise)
                                    <span class="expertise-tag">
                                        {{ $expertise->field_name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p
                                style="
                                    font-size: 12px;
                                    color: #c9b99a;
                                    font-style: italic;
                                "
                            >
                                No expertise fields assigned yet
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="fu2 mt-5">{{ $editors->links() }}</div>
        @else
            <div
                class="fu1"
                style="
                    background: var(--white);
                    border: 1px solid var(--border-dk);
                    border-radius: 14px;
                    box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
                "
            >
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg
                            width="26"
                            height="26"
                            fill="none"
                            stroke="#c9b99a"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            />
                        </svg>
                    </div>
                    <p class="empty-label">No editors found</p>
                    <p
                        style="
                            font-size: 0.88rem;
                            color: #b5a595;
                            margin-top: 6px;
                        "
                    >
                        Please create editor accounts first.
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection
