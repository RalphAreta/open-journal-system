@extends('layouts.app')

@section('title', 'Manage Submission')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #1e7a6e;
            --teal-dark: #0f4d45;
            --teal-light: #e8f5f3;
            --gold: #b8963e;
            --gold-light: #f5ecd4;
            --ink: #0d1628;
            --muted: #64748b;
            --border: #e2e8f0;
            --surface: #f8fafc;
            --white: #ffffff;
            --red: #dc2626;
            --red-light: #fef2f2;
            --amber: #d97706;
            --amber-light: #fffbeb;
            --emerald: #059669;
            --emerald-light: #ecfdf5;
            --blue: #2563eb;
            --blue-light: #eff6ff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f1f5f9;
            color: var(--ink);
        }

        .font-display {
            font-family: 'Cormorant Garamond', serif;
        }
        .font-mono {
            font-family: 'DM Mono', monospace;
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
        .fade-up {
            animation: fadeUp 0.35s ease both;
        }
        .fade-up-1 {
            animation: fadeUp 0.35s 0.06s ease both;
        }
        .fade-up-2 {
            animation: fadeUp 0.35s 0.12s ease both;
        }
        .fade-up-3 {
            animation: fadeUp 0.35s 0.18s ease both;
        }
        .fade-up-4 {
            animation: fadeUp 0.35s 0.24s ease both;
        }

        /* ── Layout shell ── */
        .page-shell {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px 24px 60px;
            align-items: start;
        }
        @media (max-width: 1100px) {
            .page-shell {
                grid-template-columns: 1fr;
            }
            .sidebar {
                order: -1;
            }
        }

        /* ── Card base ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }
        .card + .card {
            margin-top: 16px;
        }

        /* ── Section label ── */
        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Meta grid ── */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px 24px;
        }
        .meta-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 4px;
        }
        .meta-value {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
        }

        /* ── Status pill ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .pill-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }
        .pill-blue {
            background: var(--blue-light);
            border-color: #bfdbfe;
            color: var(--blue);
        }
        .pill-emerald {
            background: var(--emerald-light);
            border-color: #a7f3d0;
            color: var(--emerald);
        }
        .pill-red {
            background: var(--red-light);
            border-color: #fecaca;
            color: var(--red);
        }
        .pill-amber {
            background: var(--amber-light);
            border-color: #fde68a;
            color: var(--amber);
        }
        .pill-slate {
            background: var(--surface);
            border-color: var(--border);
            color: var(--muted);
        }

        /* ── Abstract block ── */
        .abstract-block {
            background: var(--surface);
            border-radius: 10px;
            padding: 16px 18px;
            font-size: 13px;
            color: var(--muted);
            line-height: 1.75;
            margin-top: 20px;
            border: 1px solid var(--border);
        }

        /* ── Download link ── */
        .dl-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--teal);
            text-decoration: none;
            transition: color 0.15s;
        }
        .dl-link:hover {
            color: var(--teal-dark);
        }

        /* ── Review card ── */
        .review-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
        }
        .review-card + .review-card {
            margin-top: 10px;
        }

        /* ── Reviewer selector ── */
        .reviewer-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            max-height: 300px;
            overflow-y: auto;
            padding: 2px;
        }
        .reviewer-grid::-webkit-scrollbar {
            width: 4px;
        }
        .reviewer-grid::-webkit-scrollbar-track {
            background: transparent;
        }
        .reviewer-grid::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        .reviewer-card {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            background: var(--white);
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition:
                border-color 0.16s,
                box-shadow 0.16s,
                transform 0.14s;
            position: relative;
            user-select: none;
        }
        .reviewer-card:hover {
            border-color: var(--teal);
            box-shadow: 0 2px 12px rgba(30, 122, 110, 0.12);
            transform: translateY(-1px);
        }
        .reviewer-card.selected {
            border-color: var(--teal);
            background: var(--teal-light);
            box-shadow: 0 2px 12px rgba(30, 122, 110, 0.15);
        }
        .reviewer-card input[type='checkbox'] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .reviewer-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .reviewer-check {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            flex-shrink: 0;
            transition:
                border-color 0.14s,
                background 0.14s;
        }
        .reviewer-card.selected .reviewer-check {
            background: var(--teal);
            border-color: var(--teal);
        }
        .reviewer-check svg {
            display: none;
        }
        .reviewer-card.selected .reviewer-check svg {
            display: block;
        }

        /* ── Decision radio cards ── */
        .decision-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .decision-option {
            position: relative;
        }
        .decision-option input[type='radio'] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }
        .decision-face {
            display: block;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 14px 12px;
            cursor: pointer;
            transition:
                border-color 0.16s,
                background 0.16s,
                box-shadow 0.16s;
        }
        .decision-face:hover {
            border-color: var(--teal);
        }
        .decision-option input:checked + .decision-face {
            box-shadow: 0 2px 12px rgba(30, 122, 110, 0.15);
        }
        .dec-accept input:checked + .decision-face {
            border-color: var(--emerald);
            background: var(--emerald-light);
        }
        .dec-reject input:checked + .decision-face {
            border-color: var(--red);
            background: var(--red-light);
        }
        .dec-revise input:checked + .decision-face {
            border-color: var(--amber);
            background: var(--amber-light);
        }

        .decision-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }
        .icon-emerald {
            background: var(--emerald-light);
        }
        .icon-red {
            background: var(--red-light);
        }
        .icon-amber {
            background: var(--amber-light);
        }

        .revision-type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .revision-type-grid .decision-option input:checked + .decision-face {
            box-shadow: 0 2px 12px rgba(30, 122, 110, 0.15);
        }
        .revision-type-grid .dec-accept input:checked + .decision-face {
            border-color: var(--emerald);
            background: var(--emerald-light);
        }
        .revision-type-grid .dec-reject input:checked + .decision-face {
            border-color: var(--red);
            background: var(--red-light);
        }

        /* ── Input base ── */
        .field-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: var(--ink);
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            outline: none;
        }
        .field-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(30, 122, 110, 0.1);
            background: var(--white);
        }
        textarea.field-input {
            resize: none;
            line-height: 1.65;
        }

        /* ── Screening state blocks ── */
        .state-block {
            border-radius: 10px;
            padding: 18px 20px;
        }
        .state-pending {
            background: var(--amber-light);
            border: 1px solid #fde68a;
        }
        .state-pass {
            background: var(--emerald-light);
            border: 1px solid #a7f3d0;
        }
        .state-fail {
            background: var(--red-light);
            border: 1px solid #fecaca;
        }
        .state-blue {
            background: var(--blue-light);
            border: 1px solid #bfdbfe;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 22px;
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition:
                transform 0.14s,
                box-shadow 0.14s,
                filter 0.14s;
            text-decoration: none;
        }
        .btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn-teal {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 2px 10px rgba(30, 122, 110, 0.25);
        }
        .btn-red {
            background: var(--red);
            color: #fff;
            box-shadow: 0 2px 10px rgba(220, 38, 38, 0.25);
        }
        .btn-blue {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.25);
        }
        .btn-emerald {
            background: var(--emerald);
            color: #fff;
            box-shadow: 0 2px 10px rgba(5, 150, 105, 0.25);
        }
        .btn-amber {
            background: var(--amber);
            color: #fff;
            box-shadow: 0 2px 10px rgba(217, 119, 6, 0.25);
        }
        .btn-ghost {
            background: var(--surface);
            color: var(--muted);
            border: 1.5px solid var(--border);
        }
        .btn-ghost:hover {
            color: var(--ink);
            border-color: var(--teal);
            background: var(--white);
        }
        .btn-sm {
            padding: 7px 14px;
            font-size: 11px;
            border-radius: 8px;
        }
        .btn-full {
            width: 100%;
        }

        /* ── Info hint ── */
        .hint-box {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            background: var(--blue-light);
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 12px 14px;
        }
        .hint-box p {
            font-size: 12px;
            color: #1d4ed8;
            line-height: 1.6;
        }

        /* ── Sidebar cards ── */
        .sidebar-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }
        .sidebar-card + .sidebar-card {
            margin-top: 14px;
        }

        /* ── Match badge ── */
        .match-badge {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 2px 7px;
            background: var(--emerald-light);
            color: var(--emerald);
            border: 1px solid #a7f3d0;
            border-radius: 100px;
        }

        /* ── Divider ── */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 20px 0;
        }

        /* ── Progress step ── */
        .step-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
        }
        .step-row + .step-row {
            border-top: 1px solid var(--border);
        }
        .step-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .step-done {
            background: var(--emerald-light);
        }
        .step-now {
            background: var(--amber-light);
        }
        .step-next {
            background: var(--surface);
        }
        .step-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink);
        }
        .step-sub {
            font-size: 10px;
            color: var(--muted);
            margin-top: 1px;
        }

        /* ── Date input ── */
        input[type='date'].field-input {
            padding-left: 38px;
        }
        .date-wrap {
            position: relative;
        }
        .date-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        /* ── Scrollbox ── */
        .scrollbox {
            max-height: 260px;
            overflow-y: auto;
            padding-right: 2px;
        }
        .scrollbox::-webkit-scrollbar {
            width: 4px;
        }
        .scrollbox::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        select.field-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        .hidden {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="page-shell">
        {{--
            ══════════════════════════════════════════
            MAIN COLUMN
            ══════════════════════════════════════════
        --}}
        <div class="main-col">
            {{-- ── Back + Title ── --}}
            <div class="mb-5 fade-up">
                <a
                    href="{{ route('editor.submissions') }}"
                    style="
                        display: inline-flex;
                        align-items: center;
                        gap: 6px;
                        font-size: 10px;
                        font-weight: 700;
                        text-transform: uppercase;
                        letter-spacing: 0.12em;
                        color: #94a3b8;
                        text-decoration: none;
                        margin-bottom: 12px;
                    "
                    onmouseover="this.style.color = '#1e7a6e'"
                    onmouseout="this.style.color = '#94a3b8'"
                >
                    <svg
                        width="12"
                        height="12"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                    >
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Back to Submissions
                </a>

                <div
                    style="
                        display: flex;
                        align-items: flex-start;
                        justify-content: space-between;
                        gap: 16px;
                    "
                >
                    <h1
                        class="font-display"
                        style="
                            font-size: 28px;
                            font-weight: 600;
                            color: var(--teal-dark);
                            line-height: 1.2;
                            letter-spacing: -0.01em;
                        "
                    >
                        {{ $submission->title }}
                    </h1>
                    @php
                        $sc = match ($submission->status) {
                            'accepted' => 'pill-emerald',
                            'rejected' => 'pill-red',
                            'under_review' => 'pill-blue',
                            'revisions_requested' => 'pill-amber',
                            default => 'pill-slate',
                        };
                    @endphp

                    <span
                        class="pill {{ $sc }}"
                        style="white-space: nowrap; margin-top: 6px"
                    >
                        {{ \App\Models\Submission::statusOptions()[$submission->status] ?? $submission->status }}
                    </span>
                </div>
            </div>

            {{-- ── Submission Details ── --}}
            <div class="card fade-up-1">
                <div class="section-label">Submission Details</div>
                <div class="meta-grid">
                    <div>
                        <div class="meta-label">Author</div>
                        <div class="meta-value">
                            {{ $submission->author->name }}
                        </div>
                    </div>
                    <div>
                        <div class="meta-label">Research Field</div>
                        <span class="pill pill-blue">
                            <span
                                class="pill-dot"
                                style="background: var(--blue)"
                            ></span>
                            {{ $submission->research_field ?? 'Not specified' }}
                        </span>
                    </div>
                    @if ($submission->file_path)
                        <div>
                            <div class="meta-label">Manuscript</div>
                            <a
                                href="{{ route('submissions.download', ['submission' => $submission]) }}"
                                class="dl-link"
                            >
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                    />
                                </svg>
                                {{ $submission->file_name }}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="abstract-block">
                    <div class="meta-label" style="margin-bottom: 8px">
                        Abstract
                    </div>
                    {{ $submission->abstract }}
                </div>
            </div>

            {{-- ── Revision Re-Review ── --}}
            @if ($submission->status === 'revision_under_review' && $submission->revisionRequests->isNotEmpty())
                @php
                    $latestRevision = $submission->revisionRequests->last();
                @endphp

                <div class="card fade-up-1" style="margin-top: 16px">
                    <div class="section-label">Revision Files</div>

                    <div
                        style="
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 14px;
                            margin-bottom: 20px;
                        "
                    >
                        {{-- Original --}}
                        <div
                            style="
                                background: var(--surface);
                                border: 1px solid var(--border);
                                border-radius: 10px;
                                padding: 16px;
                            "
                        >
                            <div class="meta-label" style="margin-bottom: 10px">
                                Original Manuscript
                            </div>

                            @if ($submission->original_file_path)
                                <p
                                    style="
                                        font-size: 12px;
                                        color: var(--ink);
                                        margin-bottom: 10px;
                                        word-break: break-all;
                                    "
                                >
                                    {{ $submission->original_file_name }}
                                </p>
                                <a
                                    href="{{ route('submissions.download-original', ['submission' => $submission]) }}"
                                    class="dl-link btn btn-sm btn-ghost"
                                >
                                    <svg
                                        width="13"
                                        height="13"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                        />
                                    </svg>
                                    Download
                                </a>
                            @else
                                <p
                                    style="
                                        font-size: 12px;
                                        color: var(--muted);
                                        font-style: italic;
                                    "
                                >
                                    No original file
                                </p>
                            @endif
                        </div>

                        {{-- Revised --}}
                        <div
                            style="
                                background: var(--surface);
                                border: 1px solid var(--border);
                                border-radius: 10px;
                                padding: 16px;
                            "
                        >
                            <div class="meta-label" style="margin-bottom: 10px">
                                Revised Manuscript
                            </div>

                            @if ($latestRevision && $latestRevision->revised_at && $submission->file_path)
                                <p
                                    style="
                                        font-size: 12px;
                                        color: var(--ink);
                                        margin-bottom: 10px;
                                        word-break: break-all;
                                    "
                                >
                                    {{ $submission->file_name }}
                                </p>
                                <a
                                    href="{{ route('submissions.download', ['submission' => $submission]) }}"
                                    class="dl-link btn btn-sm btn-ghost"
                                >
                                    <svg
                                        width="13"
                                        height="13"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                        />
                                    </svg>
                                    Download
                                </a>
                            @else
                                <p
                                    style="
                                        font-size: 12px;
                                        color: var(--muted);
                                        font-style: italic;
                                    "
                                >
                                    Awaiting revised submission
                                </p>
                            @endif
                        </div>
                    </div>

                    @if ($latestRevision && $latestRevision->revision_notes)
                        <div
                            style="
                                background: var(--blue-light);
                                border: 1px solid #bfdbfe;
                                border-radius: 10px;
                                padding: 14px 16px;
                                margin-bottom: 20px;
                            "
                        >
                            <div
                                class="meta-label"
                                style="color: var(--blue); margin-bottom: 6px"
                            >
                                Author's Revision Notes
                            </div>
                            <p
                                style="
                                    font-size: 13px;
                                    color: #1e40af;
                                    line-height: 1.65;
                                "
                            >
                                {{ $latestRevision->revision_notes }}
                            </p>
                        </div>
                    @endif

                    {{-- Assign reviewers to revision --}}
                    <div
                        style="
                            border: 1.5px solid #bfdbfe;
                            border-radius: 12px;
                            padding: 20px;
                            background: var(--blue-light);
                        "
                    >
                        <div
                            style="
                                display: flex;
                                align-items: center;
                                gap: 10px;
                                margin-bottom: 16px;
                            "
                        >
                            <div
                                style="
                                    width: 36px;
                                    height: 36px;
                                    border-radius: 9px;
                                    background: #dbeafe;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                "
                            >
                                <svg
                                    width="17"
                                    height="17"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="var(--blue)"
                                    stroke-width="1.8"
                                >
                                    <path
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p
                                    style="
                                        font-size: 13px;
                                        font-weight: 700;
                                        color: #1e40af;
                                    "
                                >
                                    Assign Reviewers to Revised Manuscript
                                </p>
                                <p
                                    style="
                                        font-size: 11px;
                                        color: #3b82f6;
                                        margin-top: 1px;
                                    "
                                >
                                    Select reviewers to evaluate the revised
                                    version
                                </p>
                            </div>
                        </div>

                        @php
                            $hasActiveRevisionReviews =
                                $latestRevision &&
                                $latestRevision
                                    ->revisionReviews()
                                    ->whereNotIn('status', ['declined'])
                                    ->exists();
                        @endphp

                        @if ($latestRevision && ! $hasActiveRevisionReviews)
                            <form
                                method="POST"
                                action="{{ route('editor.assign-reviewer', $submission) }}"
                                style="
                                    display: flex;
                                    flex-direction: column;
                                    gap: 14px;
                                "
                            >
                                @csrf
                                <p
                                    style="
                                        font-size: 12px;
                                        font-weight: 600;
                                        color: #1e3a8a;
                                    "
                                >
                                    Select reviewers to evaluate this revised
                                    manuscript:
                                </p>

                                @php
                                    $allReviewers = \App\Models\User::whereHas('roles', fn ($q) => $q->where('name', 'reviewer'))->get();
                                    $matchedIds = $matchedReviewers->pluck('id')->toArray();
                                @endphp

                                <div
                                    class="scrollbox"
                                    style="
                                        background: var(--white);
                                        border-radius: 10px;
                                        border: 1px solid #bfdbfe;
                                        padding: 10px;
                                    "
                                >
                                    <div class="reviewer-grid">
                                        @foreach ($allReviewers as $u)
                                            @php
                                                $colors = ['bg-teal-500', 'bg-blue-500', 'bg-violet-500', 'bg-emerald-500', 'bg-amber-500', 'bg-pink-500'];
                                                $bg = $colors[$loop->index % count($colors)];
                                                $isMatch = in_array($u->id, $matchedIds);
                                            @endphp

                                            <label
                                                class="reviewer-card {{ $isMatch ? 'selected' : '' }}"
                                                onclick="toggleReviewer(this)"
                                            >
                                                <input
                                                    type="checkbox"
                                                    name="reviewer_ids[]"
                                                    value="{{ $u->id }}"
                                                    class="reviewer-checkbox"
                                                    {{ $isMatch ? 'checked' : '' }}
                                                />
                                                <div
                                                    class="reviewer-avatar {{ $bg }}"
                                                >
                                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                                </div>
                                                <div
                                                    style="
                                                        min-width: 0;
                                                        flex: 1;
                                                    "
                                                >
                                                    <p
                                                        style="
                                                            font-size: 12px;
                                                            font-weight: 600;
                                                            color: var(--ink);
                                                        "
                                                    >
                                                        {{ $u->name }}
                                                    </p>
                                                    <p
                                                        style="
                                                            font-size: 10px;
                                                            color: var(--muted);
                                                        "
                                                    >
                                                        {{ $u->email }}
                                                    </p>
                                                </div>
                                                @if ($isMatch)
                                                    <span class="match-badge">
                                                        Match
                                                    </span>
                                                @endif

                                                <div class="reviewer-check">
                                                    <svg
                                                        width="10"
                                                        height="10"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="white"
                                                        stroke-width="3"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7"
                                                        />
                                                    </svg>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="meta-label"
                                        style="
                                            display: block;
                                            margin-bottom: 6px;
                                        "
                                    >
                                        Review Deadline (Optional)
                                    </label>
                                    <input
                                        type="date"
                                        name="due_at"
                                        class="field-input"
                                    />
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-blue btn-full"
                                >
                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.2"
                                    >
                                        <path d="M12 4v16m8-8H4" />
                                    </svg>
                                    Assign Selected Reviewers
                                </button>
                            </form>
                        @else
                            <div
                                style="
                                    background: var(--white);
                                    border-radius: 10px;
                                    padding: 14px 16px;
                                    border: 1px solid #bfdbfe;
                                "
                            >
                                <p
                                    style="
                                        font-size: 11px;
                                        font-weight: 700;
                                        color: var(--emerald);
                                        margin-bottom: 10px;
                                        display: flex;
                                        align-items: center;
                                        gap: 6px;
                                    "
                                >
                                    <svg
                                        width="13"
                                        height="13"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path d="M5 13l4 4L19 7" />
                                    </svg>
                                    Reviewers Assigned
                                </p>
                                <div
                                    style="
                                        display: flex;
                                        flex-direction: column;
                                        gap: 8px;
                                    "
                                >
                                    @foreach ($latestRevision->revisionReviews as $rr)
                                        <div
                                            style="
                                                display: flex;
                                                align-items: center;
                                                justify-content: space-between;
                                            "
                                        >
                                            <span
                                                style="
                                                    font-size: 13px;
                                                    color: var(--ink);
                                                    font-weight: 500;
                                                "
                                            >
                                                {{ $rr->reviewer->name }}
                                            </span>
                                            <span
                                                class="pill {{ $rr->status === \App\Models\RevisionReview::STATUS_COMPLETED ? 'pill-emerald' : 'pill-slate' }}"
                                            >
                                                {{ ucfirst($rr->status) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Revision reviewer feedback --}}
                    @if ($latestRevision && $latestRevision->revisionReviews->isNotEmpty())
                        <div style="margin-top: 20px">
                            <div class="section-label">
                                Feedback on Revised Manuscript
                            </div>
                            @foreach ($latestRevision->revisionReviews as $rr)
                                <div class="review-card">
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            margin-bottom: 10px;
                                        "
                                    >
                                        <div>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    font-weight: 700;
                                                    color: var(--ink);
                                                "
                                            >
                                                {{ $rr->reviewer->name ?? 'Anonymous' }}
                                            </p>
                                            <p
                                                style="
                                                    font-size: 10px;
                                                    color: var(--muted);
                                                    margin-top: 2px;
                                                "
                                                class="font-mono"
                                            >
                                                {{ $rr->created_at?->format('M d, Y · h:i A') }}
                                            </p>
                                        </div>
                                        <span class="pill pill-slate">
                                            {{ \App\Models\Review::recommendationOptions()[$rr->recommendation] ?? $rr->recommendation }}
                                        </span>
                                    </div>
                                    @if ($rr->rating)
                                        <p
                                            style="
                                                font-size: 11px;
                                                color: var(--muted);
                                                margin-bottom: 8px;
                                            "
                                        >
                                            Rating:
                                            <strong style="color: var(--ink)">
                                                {{ $rr->rating }}/100
                                            </strong>
                                        </p>
                                    @endif

                                    @if ($rr->comments_for_author)
                                        <div style="margin-bottom: 8px">
                                            <p
                                                class="meta-label"
                                                style="margin-bottom: 4px"
                                            >
                                                For Author
                                            </p>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    color: var(--muted);
                                                    line-height: 1.65;
                                                "
                                            >
                                                {{ $rr->comments_for_author }}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($rr->comments_for_editor)
                                        <div
                                            style="
                                                background: #fafafa;
                                                border-radius: 8px;
                                                padding: 10px 12px;
                                                border: 1px solid var(--border);
                                            "
                                        >
                                            <p
                                                class="meta-label"
                                                style="margin-bottom: 4px"
                                            >
                                                Internal (Editor)
                                            </p>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    color: var(--muted);
                                                    line-height: 1.65;
                                                    font-style: italic;
                                                "
                                            >
                                                {{ $rr->comments_for_editor }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- ── Reviewer Feedback ── --}}
            @if ($submission->reviews->isNotEmpty())
                <div class="card fade-up-1" style="margin-top: 16px">
                    <div class="section-label">Reviewer Feedback</div>
                    @foreach ($submission->reviews as $r)
                        <div class="review-card">
                            <div
                                style="
                                    display: flex;
                                    align-items: center;
                                    justify-content: space-between;
                                    margin-bottom: 10px;
                                "
                            >
                                <p
                                    style="
                                        font-size: 13px;
                                        font-weight: 700;
                                        color: var(--ink);
                                    "
                                >
                                    {{ $r->reviewer->name }}
                                </p>
                                <span class="pill pill-slate">
                                    {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}
                                </span>
                            </div>
                            @if ($r->comments_for_editor)
                                <p
                                    style="
                                        font-size: 13px;
                                        color: var(--muted);
                                        line-height: 1.65;
                                        margin-bottom: 6px;
                                    "
                                >
                                    {{ $r->comments_for_editor }}
                                </p>
                            @endif

                            @if ($r->comments_for_author)
                                <p
                                    style="
                                        font-size: 12px;
                                        color: var(--muted);
                                        font-style: italic;
                                        border-top: 1px solid var(--border);
                                        padding-top: 8px;
                                        margin-top: 8px;
                                    "
                                >
                                    For author:
                                    {{ Str::limit($r->comments_for_author, 140) }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- ── Initial Screening ── --}}
            <div class="card fade-up-2" style="margin-top: 16px">
                <div class="section-label">Initial Screening</div>

                @if ($submission->isPendingInitialScreening())
                    <div
                        class="state-block state-pending"
                        style="text-align: center"
                    >
                        <div
                            style="
                                width: 44px;
                                height: 44px;
                                background: rgba(217, 119, 6, 0.12);
                                border-radius: 12px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                margin: 0 auto 12px;
                            "
                        >
                            <svg
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="var(--amber)"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <p
                            style="
                                font-size: 14px;
                                font-weight: 700;
                                color: #92400e;
                                margin-bottom: 4px;
                            "
                        >
                            Pending Initial Screening
                        </p>
                        <p
                            style="
                                font-size: 12px;
                                color: #b45309;
                                margin-bottom: 16px;
                            "
                        >
                            Review scope, quality and format before assigning
                            reviewers.
                        </p>
                        <a
                            href="{{ route('editor.initial-screening', $submission) }}"
                            class="btn btn-amber"
                        >
                            <svg
                                width="14"
                                height="14"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                />
                            </svg>
                            Perform Screening
                        </a>
                    </div>
                @elseif ($submission->hasPassedInitialScreening())
                    <div class="state-block state-pass">
                        <div
                            style="
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                margin-bottom: 14px;
                            "
                        >
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="var(--emerald)"
                                stroke-width="2.5"
                            >
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            <p
                                style="
                                    font-size: 13px;
                                    font-weight: 700;
                                    color: #065f46;
                                "
                            >
                                Passed Initial Screening
                            </p>
                        </div>
                        <div
                            style="
                                display: grid;
                                grid-template-columns: 1fr 1fr;
                                gap: 12px;
                                margin-bottom: 12px;
                            "
                        >
                            <div>
                                <div class="meta-label" style="color: #059669">
                                    Screened By
                                </div>
                                <div style="font-size: 13px; color: #064e3b">
                                    {{ $submission->initialScreeningBy?->name ?? 'Unknown' }}
                                </div>
                            </div>
                            <div>
                                <div class="meta-label" style="color: #059669">
                                    Date
                                </div>
                                <div style="font-size: 13px; color: #064e3b">
                                    {{ $submission->initial_screening_at?->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        <p
                            style="
                                font-size: 12px;
                                color: #065f46;
                                line-height: 1.65;
                            "
                        >
                            {{ $submission->initial_screening_comments }}
                        </p>
                        <a
                            href="{{ route('editor.initial-screening', $submission) }}"
                            style="
                                font-size: 11px;
                                font-weight: 700;
                                color: var(--emerald);
                                margin-top: 12px;
                                display: inline-block;
                            "
                        >
                            Edit Decision →
                        </a>
                    </div>
                @else
                    <div class="state-block state-fail">
                        <div
                            style="
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                margin-bottom: 14px;
                            "
                        >
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="var(--red)"
                                stroke-width="2.5"
                            >
                                <path d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <p
                                style="
                                    font-size: 13px;
                                    font-weight: 700;
                                    color: #991b1b;
                                "
                            >
                                Failed Initial Screening
                            </p>
                        </div>
                        <div
                            style="
                                display: grid;
                                grid-template-columns: 1fr 1fr;
                                gap: 12px;
                                margin-bottom: 12px;
                            "
                        >
                            <div>
                                <div
                                    class="meta-label"
                                    style="color: var(--red)"
                                >
                                    Screened By
                                </div>
                                <div style="font-size: 13px; color: #7f1d1d">
                                    {{ $submission->initialScreeningBy?->name ?? 'Unknown' }}
                                </div>
                            </div>
                            <div>
                                <div
                                    class="meta-label"
                                    style="color: var(--red)"
                                >
                                    Date
                                </div>
                                <div style="font-size: 13px; color: #7f1d1d">
                                    {{ $submission->initial_screening_at?->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        <p
                            style="
                                font-size: 12px;
                                color: #991b1b;
                                line-height: 1.65;
                            "
                        >
                            {{ $submission->initial_screening_comments }}
                        </p>
                        <a
                            href="{{ route('editor.initial-screening', $submission) }}"
                            style="
                                font-size: 11px;
                                font-weight: 700;
                                color: var(--red);
                                margin-top: 12px;
                                display: inline-block;
                            "
                        >
                            Override Decision →
                        </a>
                    </div>
                @endif
            </div>

            {{-- ── Editor Decision ── --}}
            @if ($submission->reviews->isNotEmpty())
                <div class="card fade-up-3" style="margin-top: 16px">
                    <div class="section-label">Editor Decision</div>

                    @if (in_array($submission->status, ['accepted', 'rejected', 'revisions_requested', 'with_managing_editor', 'layout_editing', 'layout_review', 'author_confirmation']))
                        <div class="state-block state-blue">
                            <div
                                style="
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                    margin-bottom: 14px;
                                "
                            >
                                <svg
                                    width="15"
                                    height="15"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="var(--blue)"
                                    stroke-width="2.5"
                                >
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                                <p
                                    style="
                                        font-size: 13px;
                                        font-weight: 700;
                                        color: #1e40af;
                                    "
                                >
                                    Decision Recorded
                                </p>
                            </div>
                            <div
                                style="
                                    display: grid;
                                    grid-template-columns: 1fr 1fr;
                                    gap: 12px;
                                    margin-bottom: 12px;
                                "
                            >
                                <div>
                                    <div
                                        class="meta-label"
                                        style="color: var(--blue)"
                                    >
                                        Status
                                    </div>
                                    <div
                                        style="
                                            font-size: 13px;
                                            font-weight: 700;
                                            color: #1e3a8a;
                                        "
                                    >
                                        {{ \App\Models\Submission::statusOptions()[$submission->status] }}
                                    </div>
                                </div>
                                @if ($submission->editor_decision_at)
                                    <div>
                                        <div
                                            class="meta-label"
                                            style="color: var(--blue)"
                                        >
                                            Decision Date
                                        </div>
                                        <div
                                            style="
                                                font-size: 13px;
                                                color: #1e3a8a;
                                            "
                                        >
                                            {{ $submission->editor_decision_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if ($submission->editor_notes)
                                <p
                                    style="
                                        font-size: 12px;
                                        color: #1e40af;
                                        line-height: 1.65;
                                    "
                                >
                                    {{ $submission->editor_notes }}
                                </p>
                            @endif

                            {{-- Managing Editor flow --}}
                            @if (in_array($submission->status, ['accepted', 'with_managing_editor', 'layout_editing', 'layout_review', 'author_confirmation']))
                                <div
                                    style="
                                        margin-top: 20px;
                                        padding-top: 20px;
                                        border-top: 1px solid #bfdbfe;
                                    "
                                >
                                    @if ($submission->status === 'accepted')
                                        <p
                                            style="
                                                font-size: 13px;
                                                font-weight: 700;
                                                color: #1e3a8a;
                                                margin-bottom: 14px;
                                            "
                                        >
                                            Assign to Managing Editor
                                        </p>
                                        <form
                                            method="POST"
                                            action="{{ route('editor.send-to-managing-editor', $submission) }}"
                                            style="
                                                display: flex;
                                                flex-direction: column;
                                                gap: 10px;
                                            "
                                        >
                                            @csrf
                                            <div>
                                                <label
                                                    class="meta-label"
                                                    style="
                                                        display: block;
                                                        color: var(--blue);
                                                        margin-bottom: 6px;
                                                    "
                                                >
                                                    Managing Editor
                                                    <span
                                                        style="
                                                            color: var(--red);
                                                        "
                                                    >
                                                        *
                                                    </span>
                                                </label>
                                                <select
                                                    name="managing_editor_id"
                                                    required
                                                    class="field-input"
                                                >
                                                    <option value="">
                                                        — Select a Managing
                                                        Editor —
                                                    </option>
                                                    @foreach ($managingEditors as $me)
                                                        <option
                                                            value="{{ $me->id }}"
                                                        >
                                                            {{ $me->name }} ·
                                                            {{ $me->email }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('managing_editor_id')
                                                    <p
                                                        style="
                                                            font-size: 11px;
                                                            color: var(--red);
                                                            margin-top: 4px;
                                                        "
                                                    >
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <button
                                                type="submit"
                                                class="btn btn-blue"
                                            >
                                                Assign to Managing Editor
                                            </button>
                                        </form>
                                    @elseif ($submission->status === 'with_managing_editor')
                                        <div
                                            style="
                                                display: flex;
                                                align-items: center;
                                                gap: 8px;
                                            "
                                        >
                                            <svg
                                                width="14"
                                                height="14"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="var(--amber)"
                                                stroke-width="2"
                                            >
                                                <path
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    font-weight: 600;
                                                    color: #92400e;
                                                "
                                            >
                                                With Managing Editor — awaiting
                                                CTF &amp; layout assignment
                                            </p>
                                        </div>
                                    @elseif ($submission->status === 'layout_editing')
                                        <div
                                            style="
                                                display: flex;
                                                align-items: center;
                                                gap: 8px;
                                            "
                                        >
                                            <svg
                                                width="14"
                                                height="14"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="var(--amber)"
                                                stroke-width="2"
                                            >
                                                <path
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    font-weight: 600;
                                                    color: #92400e;
                                                "
                                            >
                                                Awaiting layout editor work
                                            </p>
                                        </div>
                                    @elseif ($submission->status === 'layout_review')
                                        <p
                                            style="
                                                font-size: 13px;
                                                font-weight: 700;
                                                color: #1e3a8a;
                                                margin-bottom: 12px;
                                            "
                                        >
                                            Layout file received — ready to send
                                            to author
                                        </p>
                                        <form
                                            method="POST"
                                            action="{{ route('editor.send-layout-to-author', $submission) }}"
                                        >
                                            @csrf
                                            <p
                                                style="
                                                    font-size: 12px;
                                                    color: #3b82f6;
                                                    margin-bottom: 12px;
                                                "
                                            >
                                                Review the layout file, then
                                                send it to the author for final
                                                confirmation.
                                            </p>
                                            <button
                                                type="submit"
                                                class="btn btn-emerald"
                                            >
                                                Send Layout to Author
                                            </button>
                                        </form>
                                    @elseif ($submission->status === 'author_confirmation')
                                        <div
                                            style="
                                                display: flex;
                                                align-items: center;
                                                gap: 8px;
                                            "
                                        >
                                            <svg
                                                width="14"
                                                height="14"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="var(--emerald)"
                                                stroke-width="2.5"
                                            >
                                                <path d="M5 13l4 4L19 7" />
                                            </svg>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    font-weight: 600;
                                                    color: #065f46;
                                                "
                                            >
                                                Sent to author for confirmation
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        {{-- ── Decision Form ── --}}
                        @php
                            $draftData = $submission->editor_decision_draft ? json_decode(json_encode($submission->editor_decision_draft), true) : [];
                            $selectedStatus = old('status', $draftData['status'] ?? '');
                        @endphp

                        <form
                            id="decision-form"
                            method="POST"
                            action="{{ route('editor.decision', $submission) }}"
                            style="
                                display: flex;
                                flex-direction: column;
                                gap: 20px;
                            "
                        >
                            @csrf

                            {{-- Decision --}}
                            <div>
                                <label
                                    style="
                                        display: block;
                                        font-size: 12px;
                                        font-weight: 700;
                                        color: var(--ink);
                                        margin-bottom: 10px;
                                    "
                                >
                                    Decision
                                    <span style="color: var(--red)">*</span>
                                </label>
                                <div class="decision-grid">
                                    <div class="decision-option dec-accept">
                                        <input
                                            type="radio"
                                            name="status"
                                            value="accepted"
                                            id="dec_accepted"
                                            {{ $selectedStatus === 'accepted' ? 'checked' : '' }}
                                        />
                                        <label
                                            class="decision-face"
                                            for="dec_accepted"
                                        >
                                            <div
                                                class="decision-icon icon-emerald"
                                            >
                                                <svg
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="var(--emerald)"
                                                    stroke-width="2.5"
                                                >
                                                    <path d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    font-weight: 700;
                                                    color: var(--ink);
                                                "
                                            >
                                                Accept
                                            </p>
                                            <p
                                                style="
                                                    font-size: 11px;
                                                    color: var(--muted);
                                                    margin-top: 2px;
                                                "
                                            >
                                                Accepted for publication
                                            </p>
                                        </label>
                                    </div>
                                    <div class="decision-option dec-reject">
                                        <input
                                            type="radio"
                                            name="status"
                                            value="rejected"
                                            id="dec_rejected"
                                            {{ $selectedStatus === 'rejected' ? 'checked' : '' }}
                                        />
                                        <label
                                            class="decision-face"
                                            for="dec_rejected"
                                        >
                                            <div class="decision-icon icon-red">
                                                <svg
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="var(--red)"
                                                    stroke-width="2.5"
                                                >
                                                    <path
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                            </div>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    font-weight: 700;
                                                    color: var(--ink);
                                                "
                                            >
                                                Reject
                                            </p>
                                            <p
                                                style="
                                                    font-size: 11px;
                                                    color: var(--muted);
                                                    margin-top: 2px;
                                                "
                                            >
                                                Manuscript rejected
                                            </p>
                                        </label>
                                    </div>
                                    <div class="decision-option dec-revise">
                                        <input
                                            type="radio"
                                            name="status"
                                            value="revisions_requested"
                                            id="dec_revisions"
                                            {{ $selectedStatus === 'revisions_requested' ? 'checked' : '' }}
                                        />
                                        <label
                                            class="decision-face"
                                            for="dec_revisions"
                                        >
                                            <div
                                                class="decision-icon icon-amber"
                                            >
                                                <svg
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="var(--amber)"
                                                    stroke-width="2"
                                                >
                                                    <path
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                    />
                                                </svg>
                                            </div>
                                            <p
                                                style="
                                                    font-size: 13px;
                                                    font-weight: 700;
                                                    color: var(--ink);
                                                "
                                            >
                                                Revisions
                                            </p>
                                            <p
                                                style="
                                                    font-size: 11px;
                                                    color: var(--muted);
                                                    margin-top: 2px;
                                                "
                                            >
                                                Changes required
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Revision fields --}}
                            <div
                                id="revision-fields"
                                style="
                                    border-top: 1px solid var(--border);
                                    padding-top: 20px;
                                    display: none;
                                    flex-direction: column;
                                    gap: 14px;
                                "
                            >
                                <div>
                                    <label
                                        style="
                                            font-size: 12px;
                                            font-weight: 700;
                                            color: var(--ink);
                                            display: block;
                                            margin-bottom: 8px;
                                        "
                                    >
                                        Revision Type
                                        <span style="color: var(--red)">*</span>
                                    </label>
                                    <div class="revision-type-grid">
                                        <div class="decision-option dec-accept">
                                            <input
                                                type="radio"
                                                name="revision_type"
                                                value="minor"
                                                id="rev_minor"
                                                {{ old('revision_type', $draftData['revision_type'] ?? '') === 'minor' ? 'checked' : '' }}
                                            />
                                            <label
                                                class="decision-face"
                                                for="rev_minor"
                                            >
                                                <p
                                                    style="
                                                        font-size: 13px;
                                                        font-weight: 700;
                                                        color: var(--ink);
                                                    "
                                                >
                                                    Minor
                                                </p>
                                                <p
                                                    style="
                                                        font-size: 11px;
                                                        color: var(--muted);
                                                    "
                                                >
                                                    Small targeted changes
                                                </p>
                                            </label>
                                        </div>
                                        <div class="decision-option dec-reject">
                                            <input
                                                type="radio"
                                                name="revision_type"
                                                value="major"
                                                id="rev_major"
                                                {{ old('revision_type', $draftData['revision_type'] ?? '') === 'major' ? 'checked' : '' }}
                                            />
                                            <label
                                                class="decision-face"
                                                for="rev_major"
                                            >
                                                <p
                                                    style="
                                                        font-size: 13px;
                                                        font-weight: 700;
                                                        color: var(--ink);
                                                    "
                                                >
                                                    Major
                                                </p>
                                                <p
                                                    style="
                                                        font-size: 11px;
                                                        color: var(--muted);
                                                    "
                                                >
                                                    Significant restructuring
                                                </p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label
                                        style="
                                            font-size: 12px;
                                            font-weight: 700;
                                            color: var(--ink);
                                            display: block;
                                            margin-bottom: 6px;
                                        "
                                    >
                                        Revision Reason
                                        <span style="color: var(--red)">*</span>
                                    </label>
                                    <textarea
                                        id="revision_reason"
                                        name="revision_reason"
                                        rows="3"
                                        placeholder="Explain what revisions are needed…"
                                        class="field-input"
                                    >
{{ old('revision_reason', $draftData['revision_reason'] ?? '') }}</textarea
                                    >
                                </div>
                            </div>

                            {{-- Editor notes --}}
                            <div>
                                <label
                                    style="
                                        font-size: 12px;
                                        font-weight: 700;
                                        color: var(--ink);
                                        display: block;
                                        margin-bottom: 6px;
                                    "
                                >
                                    Editor Notes
                                    <span
                                        style="
                                            font-weight: 400;
                                            color: var(--muted);
                                        "
                                    >
                                        (optional)
                                    </span>
                                </label>
                                <textarea
                                    id="editor_notes"
                                    name="editor_notes"
                                    rows="3"
                                    maxlength="2000"
                                    placeholder="Additional notes for the author…"
                                    class="field-input"
                                >
{{ old('editor_notes', $draftData['editor_notes'] ?? '') }}</textarea
                                >
                            </div>

                            {{-- Actions --}}
                            <div
                                style="
                                    display: flex;
                                    align-items: center;
                                    justify-content: flex-end;
                                    gap: 10px;
                                    padding-top: 16px;
                                    border-top: 1px solid var(--border);
                                "
                            >
                                <button
                                    type="submit"
                                    name="action"
                                    value="save_draft"
                                    class="btn btn-ghost"
                                >
                                    Save Draft
                                </button>
                                <button
                                    type="submit"
                                    name="action"
                                    value="submit"
                                    class="btn btn-teal"
                                >
                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.2"
                                    >
                                        <path
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    Record Decision
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif

            {{-- ── Assign Reviewer ── --}}
            @php
                $hasActiveAssignments = $submission
                    ->reviewAssignments()
                    ->whereNotIn('status', ['declined'])
                    ->exists();
            @endphp

            @if (in_array($submission->status, ['submitted', 'under_review']) && ! $hasActiveAssignments)
                <div class="card fade-up-4" style="margin-top: 16px">
                    {{-- Header row --}}
                    <div
                        style="
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            margin-bottom: 20px;
                        "
                    >
                        <div>
                            <div
                                class="section-label"
                                style="margin-bottom: 4px"
                            >
                                Assign Reviewer
                            </div>

                            @if ($matchedReviewers->count() > 0)
                                <span class="match-badge">
                                    {{ $matchedReviewers->count() }} matched
                                </span>
                            @else
                                <span
                                    class="pill pill-amber"
                                    style="font-size: 9px"
                                >
                                    No match
                                </span>
                            @endif
                        </div>
                        <span
                            id="selected-count"
                            class="hidden pill pill-red"
                            style="font-size: 9px"
                        >
                            <span id="selected-num">0</span>
                            selected
                        </span>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('editor.assign-reviewer', $submission) }}"
                        style="display: flex; flex-direction: column; gap: 14px"
                    >
                        @csrf

                        <div>
                            <p
                                style="
                                    font-size: 9px;
                                    font-weight: 700;
                                    letter-spacing: 0.07em;
                                    text-transform: uppercase;
                                    color: var(--muted);
                                    margin-bottom: 10px;
                                "
                            >
                                @if ($matchedReviewers->count() > 0)
                                    Matched for
                                    <span style="color: var(--blue)">
                                        {{ $submission->research_field }}
                                    </span>
                                @else
                                        All Reviewers
                                @endif
                            </p>

                            {{-- Matched reviewers --}}
                            @if ($matchedReviewers->count() > 0)
                                <div
                                    style="
                                        display: grid;
                                        grid-template-columns: repeat(2, 1fr);
                                        gap: 8px;
                                        margin-bottom: 14px;
                                    "
                                >
                                    @foreach ($matchedReviewers as $u)
                                        @php
                                            $colors = ['bg-red-500', 'bg-blue-500', 'bg-violet-500', 'bg-emerald-500', 'bg-amber-500', 'bg-pink-500'];
                                            $bg = $colors[$loop->index % count($colors)];
                                            $hasDeclined = in_array($u->id, $declinedReviewerIds);
                                        @endphp

                                        <label
                                            class="reviewer-card {{ $hasDeclined ? '' : '' }}"
                                            style="{{ $hasDeclined ? 'opacity:.7;' : '' }}"
                                            onclick="toggleReviewer(this)"
                                        >
                                            <input
                                                type="checkbox"
                                                name="reviewer_ids[]"
                                                value="{{ $u->id }}"
                                                class="reviewer-checkbox"
                                            />
                                            <div
                                                class="reviewer-avatar {{ $bg }}"
                                            >
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0; flex: 1">
                                                <p
                                                    style="
                                                        font-size: 12px;
                                                        font-weight: 700;
                                                        color: var(--ink);
                                                    "
                                                >
                                                    {{ $u->name }}
                                                    @if ($hasDeclined)
                                                        <span
                                                            style="
                                                                font-size: 9px;
                                                                font-weight: 900;
                                                                color: #d97706;
                                                                margin-left: 4px;
                                                            "
                                                            title="{{ $declineReasons[$u->id] ?? 'No reason provided' }}"
                                                        >
                                                            ✗ Declined
                                                        </span>
                                                    @endif
                                                </p>
                                                @if ($hasDeclined && ! empty($declineReasons[$u->id]))
                                                    <p
                                                        style="
                                                            font-size: 9px;
                                                            color: #92400e;
                                                            margin-top: 3px;
                                                            background: #fffbeb;
                                                            padding: 3px 6px;
                                                            border-radius: 4px;
                                                        "
                                                    >
                                                        <strong>Reason:</strong>
                                                        {{ $declineReasons[$u->id] }}
                                                    </p>
                                                @endif

                                                <p
                                                    style="
                                                        font-size: 11px;
                                                        color: var(--muted);
                                                    "
                                                >
                                                    {{ $u->email }}
                                                </p>
                                                <p
                                                    style="
                                                        font-size: 10px;
                                                        font-weight: 700;
                                                        color: var(--muted);
                                                        margin-top: 2px;
                                                    "
                                                >
                                                    {{ $u->active_reviews_count }}
                                                    {{ $u->active_reviews_count == 1 ? 'active review' : 'active reviews' }}
                                                </p>
                                            </div>
                                            <div class="reviewer-check">
                                                <svg
                                                    width="10"
                                                    height="10"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="white"
                                                    stroke-width="3"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Other reviewers --}}
                            @if ($otherReviewers->count() > 0)
                                @if ($matchedReviewers->count() > 0)
                                    <p
                                        style="
                                            font-size: 9px;
                                            font-weight: 700;
                                            letter-spacing: 0.12em;
                                            text-transform: uppercase;
                                            color: var(--muted);
                                            margin-bottom: 8px;
                                        "
                                    >
                                        Other Reviewers
                                    </p>
                                @endif

                                <div
                                    style="
                                        display: grid;
                                        grid-template-columns: repeat(2, 1fr);
                                        gap: 8px;
                                    "
                                >
                                    @foreach ($otherReviewers as $u)
                                        @php
                                            $colors = ['bg-slate-500', 'bg-cyan-500', 'bg-teal-500', 'bg-indigo-500', 'bg-rose-500', 'bg-lime-500'];
                                            $bg = $colors[$loop->index % count($colors)];
                                            $hasDeclined = in_array($u->id, $declinedReviewerIds);
                                        @endphp

                                        <label
                                            class="reviewer-card"
                                            style="{{ $hasDeclined ? 'opacity:.7;' : '' }}"
                                            onclick="toggleReviewer(this)"
                                        >
                                            <input
                                                type="checkbox"
                                                name="reviewer_ids[]"
                                                value="{{ $u->id }}"
                                                class="reviewer-checkbox"
                                            />
                                            <div
                                                class="reviewer-avatar {{ $bg }}"
                                            >
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0; flex: 1">
                                                <p
                                                    style="
                                                        font-size: 12px;
                                                        font-weight: 700;
                                                        color: var(--ink);
                                                    "
                                                >
                                                    {{ $u->name }}
                                                    @if ($hasDeclined)
                                                        <span
                                                            style="
                                                                font-size: 9px;
                                                                font-weight: 900;
                                                                color: #d97706;
                                                                margin-left: 4px;
                                                            "
                                                            title="{{ $declineReasons[$u->id] ?? 'No reason provided' }}"
                                                        >
                                                            ✗ Declined
                                                        </span>
                                                    @endif
                                                </p>
                                                @if ($hasDeclined && ! empty($declineReasons[$u->id]))
                                                    <p
                                                        style="
                                                            font-size: 9px;
                                                            color: #92400e;
                                                            margin-top: 3px;
                                                            background: #fffbeb;
                                                            padding: 3px 6px;
                                                            border-radius: 4px;
                                                        "
                                                    >
                                                        <strong>Reason:</strong>
                                                        {{ $declineReasons[$u->id] }}
                                                    </p>
                                                @endif

                                                <p
                                                    style="
                                                        font-size: 11px;
                                                        color: var(--muted);
                                                    "
                                                >
                                                    {{ $u->email }}
                                                </p>
                                                <p
                                                    style="
                                                        font-size: 10px;
                                                        font-weight: 700;
                                                        color: var(--muted);
                                                        margin-top: 2px;
                                                    "
                                                >
                                                    {{ $u->active_reviews_count }}
                                                    {{ $u->active_reviews_count == 1 ? 'active review' : 'active reviews' }}
                                                </p>
                                            </div>
                                            <div class="reviewer-check">
                                                <svg
                                                    width="10"
                                                    height="10"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="white"
                                                    stroke-width="3"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div
                            style="
                                border-top: 1px solid var(--border);
                                padding-top: 16px;
                                display: flex;
                                flex-direction: column;
                                gap: 12px;
                            "
                        >
                            <div>
                                <label
                                    class="meta-label"
                                    style="display: block; margin-bottom: 6px"
                                >
                                    Review Deadline
                                    <span style="color: var(--red)">*</span>
                                </label>
                                <div class="date-wrap">
                                    <svg
                                        class="date-icon"
                                        width="14"
                                        height="14"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="var(--muted)"
                                        stroke-width="2"
                                    >
                                        <rect
                                            x="3"
                                            y="4"
                                            width="18"
                                            height="18"
                                            rx="2"
                                            stroke-width="2"
                                        />
                                        <path
                                            d="M16 2v4M8 2v4M3 10h18"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                        />
                                    </svg>
                                    <input
                                        type="date"
                                        name="due_at"
                                        id="due_at"
                                        required
                                        min="{{ now()->addDay()->format('Y-m-d') }}"
                                        class="field-input"
                                        style="padding-left: 36px"
                                        onchange="updateDueDateHint(this)"
                                    />
                                </div>
                                <p
                                    id="due-hint"
                                    class="hidden"
                                    style="
                                        font-size: 11px;
                                        margin-top: 6px;
                                        color: var(--muted);
                                    "
                                >
                                    Reviewer will have
                                    <span
                                        id="due-days"
                                        style="font-weight: 700"
                                    ></span>
                                    days.
                                    <span
                                        id="due-date"
                                        class="font-mono"
                                        style="
                                            display: block;
                                            margin-top: 2px;
                                            font-size: 10px;
                                        "
                                    ></span>
                                </p>
                            </div>

                            <button type="submit" class="btn btn-teal btn-full">
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.2"
                                >
                                    <path d="M12 4v16m8-8H4" />
                                </svg>
                                Send Assignment
                            </button>

                            <div class="hint-box">
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#3b82f6"
                                    stroke-width="2"
                                    style="flex-shrink: 0; margin-top: 1px"
                                >
                                    <path
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <p>
                                    The reviewer will receive an
                                    <strong>invitation</strong>
                                    and can
                                    <strong>accept or decline</strong>
                                    before proceeding.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
        {{-- end main-col --}}

        {{--
            ══════════════════════════════════════════
            SIDEBAR
            ══════════════════════════════════════════
        --}}
        <aside class="sidebar">
            {{-- ── Workflow Progress ── --}}
            <div class="sidebar-card fade-up-4">
                <div class="section-label">Workflow Progress</div>
                @php
                    $steps = [
                        ['label' => 'Submitted', 'sub' => 'Manuscript received', 'done' => true],
                        ['label' => 'Initial Screening', 'sub' => 'Scope & format check', 'done' => $submission->hasPassedInitialScreening()],
                        ['label' => 'Under Review', 'sub' => 'Peer review in progress', 'done' => in_array($submission->status, ['accepted', 'rejected', 'revisions_requested', 'with_managing_editor', 'layout_editing', 'layout_review', 'author_confirmation', 'revision_under_review'])],
                        ['label' => 'Decision', 'sub' => 'Editor records outcome', 'done' => in_array($submission->status, ['accepted', 'rejected', 'revisions_requested', 'with_managing_editor', 'layout_editing', 'layout_review', 'author_confirmation'])],
                        ['label' => 'Publication', 'sub' => 'Layout, DOI & release', 'done' => in_array($submission->status, ['layout_editing', 'layout_review', 'author_confirmation'])],
                    ];
                    $currentStep = collect($steps)
                        ->filter(fn ($s) => $s['done'])
                        ->count();
                @endphp

                <div style="margin-bottom: 14px">
                    <div
                        style="
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            margin-bottom: 6px;
                        "
                    >
                        <span
                            style="
                                font-size: 11px;
                                font-weight: 600;
                                color: var(--muted);
                            "
                        >
                            Progress
                        </span>
                        <span
                            style="
                                font-size: 11px;
                                font-weight: 700;
                                color: var(--teal);
                            "
                            class="font-mono"
                        >
                            {{ $currentStep }}/{{ count($steps) }}
                        </span>
                    </div>
                    <div
                        style="
                            height: 4px;
                            background: var(--border);
                            border-radius: 100px;
                            overflow: hidden;
                        "
                    >
                        <div
                            style="
                                height: 100%;
                                width: {{ ($currentStep / count($steps)) * 100 }}%;
                                background: linear-gradient(
                                    90deg,
                                    var(--teal),
                                    var(--teal-dark)
                                );
                                border-radius: 100px;
                                transition: width 0.6s ease;
                            "
                        ></div>
                    </div>
                </div>

                @foreach ($steps as $i => $step)
                    <div class="step-row">
                        <div
                            class="step-icon {{ $step['done'] ? 'step-done' : ($i === $currentStep ? 'step-now' : 'step-next') }}"
                        >
                            @if ($step['done'])
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="var(--emerald)"
                                    stroke-width="2.5"
                                >
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif ($i === $currentStep)
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="var(--amber)"
                                    stroke-width="2"
                                >
                                    <path
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            @else
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="var(--border)"
                                    stroke-width="2"
                                >
                                    <circle cx="12" cy="12" r="9" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <div
                                class="step-label"
                                style="
                                    color: {{ $step['done'] ? 'var(--ink)' : ($i === $currentStep ? 'var(--amber)' : 'var(--muted)') }};
                                "
                            >
                                {{ $step['label'] }}
                            </div>
                            <div class="step-sub">{{ $step['sub'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>
    </div>
    {{-- end page-shell --}}
@endsection

@push('scripts')
    <script>
        function toggleReviewer(card) {
                const cb = card.querySelector('.reviewer-checkbox');
                if (!cb) return;
                cb.checked = !cb.checked;
                card.classList.toggle('selected', cb.checked);
                const total = document.querySelectorAll('.reviewer-checkbox:checked').length;
                const badge = document.getElementById('selected-count');
                const num   = document.getElementById('selected-num');
                if (badge && num) {
                    num.textContent = total;
                    badge.classList.toggle('hidden', total === 0);
                }
            }

            function updateDueDateHint(input) {
                const hint   = document.getElementById('due-hint');
                const daysEl = document.getElementById('due-days');
                const dateEl = document.getElementById('due-date');
                if (!input.value || !hint) { hint?.classList.add('hidden'); return; }
                const diff = Math.ceil((new Date(input.value) - new Date()) / 86400000);
                daysEl.textContent = diff;
                daysEl.style.color = diff < 0 ? 'var(--red)' : diff <= 7 ? 'var(--amber)' : 'var(--emerald)';
                const opts = { month: 'short', day: 'numeric', year: 'numeric' };
                dateEl.textContent = 'Due: ' + new Date(input.value).toLocaleDateString('en-US', opts) + ' · 11:59 PM';
                hint.classList.remove('hidden');
            }

            /* ── Decision form ── */
            const dForm    = document.getElementById('decision-form');
            const revFields = document.getElementById('revision-fields');
            const revReason = document.getElementById('revision_reason');

            if (dForm && revFields) {
                const statusRadios  = dForm.querySelectorAll('input[name="status"]');
                const revTypeRadios = dForm.querySelectorAll('input[name="revision_type"]');

                function toggleRevision() {
                    const sel   = dForm.querySelector('input[name="status"]:checked');
                    const isRev = sel?.value === 'revisions_requested';
                    revFields.style.display = isRev ? 'flex' : 'none';
                    revTypeRadios.forEach(r => isRev ? r.setAttribute('required','') : r.removeAttribute('required'));
                    if (revReason) isRev ? revReason.setAttribute('required','') : revReason.removeAttribute('required');
                }

                statusRadios.forEach(r => r.addEventListener('change', toggleRevision));

                dForm.addEventListener('submit', () => {
                    const sel = dForm.querySelector('input[name="status"]:checked');
                    if (sel?.value !== 'revisions_requested') {
                        revTypeRadios.forEach(r => r.disabled = true);
                        if (revReason) revReason.disabled = true;
                    }
                });

                // Init on load
                toggleRevision();

                // If previously selected revisions_requested (e.g. old() data), show fields
              @if (isset($selectedStatus) && $selectedStatus === 'revisions_requested')
                    revFields.style.display = 'flex';
                @endif
            }
    </script>
@endpush
