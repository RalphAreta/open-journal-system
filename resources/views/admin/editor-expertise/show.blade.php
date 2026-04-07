@extends('layouts.app')

@section('title', 'Expertise Profile: ' . $user->name)

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
            --white: #ffffff;
            --red: #dc2626;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            background-color: var(--cream);
            background-image:
                radial-gradient(
                    ellipse 80% 50% at 50% -10%,
                    rgba(45, 129, 118, 0.08) 0%,
                    transparent 70%
                ),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23faf6ef'/%3E%3Ccircle cx='1' cy='1' r='.4' fill='%23e8dfd0' opacity='.5'/%3E%3C/svg%3E");
        }

        .academic-font {
            font-family: 'Libre Baskerville', serif;
        }
        .ui-font {
            font-family: 'Source Sans 3', sans-serif;
        }

        /* Hero */
        .hero-header {
            position: relative;
            padding: 24px 0 20px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 24px;
        }
        @media (min-width: 768px) {
            .hero-header {
                padding: 32px 0 24px;
                margin-bottom: 32px;
            }
        }
        .hero-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }

        /* Hero title */
        .hero-title {
            font-size: 1.75rem;
            line-height: 1.2;
        }
        @media (min-width: 768px) {
            .hero-title {
                font-size: 2.25rem;
            }
        }

        /* Manage Profile button — full width on mobile */
        .btn-manage-profile {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.15s;
        }
        @media (min-width: 640px) {
            .btn-manage-profile {
                width: auto;
                padding: 10px 24px;
            }
        }

        /* Card */
        .card {
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 12px;
            padding: 18px 16px;
            box-shadow: 0 1px 3px rgba(26, 18, 9, 0.04);
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
            overflow: hidden;
            word-break: break-word;
            overflow-wrap: break-word;
        }
        @media (min-width: 480px) {
            .card {
                padding: 24px;
            }
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 18, 9, 0.08);
        }

        .btn-teal {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 2px 8px rgba(45, 129, 118, 0.2);
            transition: all 0.15s;
        }
        .btn-teal:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(45, 129, 118, 0.3);
        }
        .btn-teal:active {
            transform: translateY(0);
        }

        /* Expertise Grid — 1 col mobile, 2+ col desktop */
        .expertise-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }
        @media (min-width: 480px) {
            .expertise-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 20px;
            }
        }

        /* Remove button — always visible on mobile (no hover needed) */
        .remove-btn {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #c0392b;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
            transition:
                background 0.15s,
                color 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .remove-btn:hover {
            color: var(--red);
            background: #fdf2f2;
        }
        /* On desktop keep the hover-reveal; on mobile always show */
        @media (min-width: 768px) {
            .remove-btn {
                opacity: 0;
            }
            .group:hover .remove-btn {
                opacity: 1;
            }
        }

        /* Email row — allow wrapping on small screens */
        .hero-email {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--ink-soft);
            word-break: break-all;
        }
        .hero-email svg {
            flex-shrink: 0;
            margin-top: 2px;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 pb-20">
        {{-- Back Link --}}
        <div class="pt-6 sm:pt-8 mb-5 sm:mb-6">
            <a
                href="{{ route('admin.editor-expertise.index') }}"
                class="inline-flex items-center gap-2 font-bold text-[10px] uppercase tracking-wider text-[#c9b99a] hover:text-[#2d8176] transition-colors"
            >
                <svg
                    width="12"
                    height="12"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    viewBox="0 0 24 24"
                >
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Back to Editor Index
            </a>
        </div>

        {{-- Hero Header --}}
        <div class="hero-header">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div class="min-w-0 flex-1">
                    <p
                        class="text-[11px] font-bold tracking-[0.2em] uppercase text-[#2d8176] mb-2 block academic-font"
                    >
                        Specialization
                    </p>
                    <h1
                        class="hero-title font-bold academic-font text-[#1a1209] leading-tight mb-2"
                    >
                        {{ $user->name }}'s
                        <span class="italic text-[#2d8176]">Expertise</span>
                    </h1>
                    <p class="hero-email">
                        <svg
                            width="14"
                            height="14"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            />
                        </svg>
                        {{ $user->email }}
                    </p>
                </div>

                <a
                    href="{{ route('admin.editor-expertise.edit', $user) }}"
                    class="btn-teal btn-manage-profile self-stretch sm:self-auto active:scale-95 shadow-sm"
                >
                    <svg
                        width="13"
                        height="13"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                    </svg>
                    Manage Profile
                </a>
            </div>
        </div>

        {{-- Expertise Grid --}}
        <div class="expertise-grid">
            @if ($user->editorExpertise->count() > 0)
                @foreach ($user->editorExpertise as $expertise)
                    <div
                        class="card flex flex-col justify-between group h-full"
                    >
                        <div class="min-w-0">
                            <div
                                class="flex justify-between items-start mb-4 gap-2"
                            >
                                <h3
                                    class="academic-font font-bold text-base text-[#1a1209] leading-tight break-words min-w-0"
                                >
                                    {{ $expertise->field_name }}
                                </h3>

                                <form
                                    method="POST"
                                    action="{{ route('admin.editor-expertise.remove-field', $expertise) }}"
                                    class="flex-shrink-0"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="remove-btn"
                                        onclick="
                                            return confirm(
                                                'Remove this expertise field?',
                                            );
                                        "
                                    >
                                        <svg
                                            width="11"
                                            height="11"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                            viewBox="0 0 24 24"
                                        >
                                            <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            </div>

                            <div
                                class="mt-2 text-[#1a1209] text-sm leading-relaxed font-normal break-words overflow-hidden"
                            >
                                @if ($expertise->description)
                                    {{ $expertise->description }}
                                @else
                                    <span class="text-[#6b5740] italic text-xs">
                                        No description provided
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div
                    class="col-span-full py-12 sm:py-16 px-6 bg-[#f3ece0]/30 border border-dashed border-[#c9b99a] rounded-xl text-center shadow-inner"
                >
                    <div class="text-[#c9b99a] mb-3">
                        <svg
                            width="32"
                            height="32"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                            class="mx-auto"
                        >
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>
                    <h2
                        class="academic-font text-lg font-bold text-[#1a1209] mb-1"
                    >
                        Walang Expertise Fields
                    </h2>
                    <p class="text-[#6b5740] mb-4 text-xs font-medium">
                        Mukhang wala pa siyang naka-assign na field of expertise
                        sa system.
                    </p>
                    <a
                        href="{{ route('admin.editor-expertise.edit', $user) }}"
                        class="btn-teal inline-flex items-center gap-1.5 px-5 py-2 rounded-lg text-[10px] uppercase font-bold tracking-wider"
                    >
                        Add Field Now
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
