@extends('layouts.app')

@section('title', 'Manuscript Details')

@push('styles')
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --teal-lt: #e8f4f2;
            --gold: #c9a84c;
            --gold-lt: #e8d49a;
            --gold-dk: #8a6e28;
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
        }

        * {
            box-sizing: border-box;
        }

        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            font-size: 16px;
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

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-decoration: none;
            margin-bottom: 28px;
            transition: color 0.15s;
        }
        .back-link:hover {
            color: var(--teal);
        }

        /* Page header */
        .page-header {
            border-bottom: 1px solid var(--border);
            padding-bottom: 28px;
            margin-bottom: 32px;
            position: relative;
        }
        .page-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .eyebrow {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--teal);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .eyebrow::before {
            content: '';
            width: 20px;
            height: 1px;
            background: var(--teal);
        }
        .ms-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 2rem;
            font-weight: 700;
            font-style: italic;
            color: var(--ink);
            line-height: 1.3;
            margin-bottom: 10px;
        }
        .ms-ref-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(45, 129, 118, 0.07);
            border: 1px solid rgba(45, 129, 118, 0.25);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--teal-dk);
        }

        /* Card */
        .card {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
            margin-bottom: 24px;
        }
        .card-header {
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-header-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .card-header-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
        }
        .card-body {
            padding: 24px;
        }

        /* Author row */
        .author-row {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .author-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--teal-lt);
            border: 2px solid rgba(45, 129, 118, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Libre Baskerville', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--teal-dk);
            flex-shrink: 0;
            text-transform: uppercase;
        }
        .author-name {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
        }
        .author-email {
            font-size: 0.82rem;
            color: var(--ink-soft);
            margin-top: 2px;
            word-break: break-all;
        }

        /* Meta grid */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }
        .meta-item {
        }
        .meta-label {
            font-size: 0.66rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 4px;
        }
        .meta-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ink-mid);
        }

        /* Abstract */
        .abstract-text {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.96rem;
            line-height: 1.8;
            color: var(--ink-mid);
            font-style: italic;
        }

        /* Keywords */
        .kw-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .kw-chip {
            background: var(--teal-lt);
            border: 1px solid rgba(45, 129, 118, 0.3);
            color: var(--teal-dk);
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        /* File download card */
        .file-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 10px;
            margin-bottom: 10px;
            gap: 12px;
        }
        .file-card:last-child {
            margin-bottom: 0;
        }
        .file-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid var(--border-dk);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .file-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--ink);
            word-break: break-all;
        }
        .file-tag {
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-top: 2px;
        }
        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: 1.5px solid rgba(45, 129, 118, 0.35);
            color: var(--teal);
            transition: all 0.15s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-download:hover {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 4px 12px rgba(45, 129, 118, 0.25);
        }

        /* Status badge */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .sbadge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }
        .sbadge.pending-me {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.pending-me .dot {
            background: var(--gold);
        }
        .sbadge.ctf-sent {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.ctf-sent .dot {
            background: var(--teal);
        }
        .sbadge.forwarded {
            background: #f0fdf4;
            border-color: #86efac;
            color: var(--teal-dk);
        }
        .sbadge.forwarded .dot {
            background: var(--teal-dk);
        }
        .sbadge.published {
            background: #f0fdf4;
            border-color: #22c55e;
            color: #16a34a;
        }
        .sbadge.published .dot {
            background: #22c55e;
        }

        /* Animations */
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

        /* Divider */
        .section-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 6px 0 20px;
        }

        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 640px) {
            .aw {
                font-size: 15px;
            }

            /* Tighter outer padding on small screens */
            .aw.max-w-5xl {
                padding-left: 16px !important;
                padding-right: 16px !important;
                padding-top: 20px !important;
            }

            /* Shrink the big italic title */
            .ms-title {
                font-size: 1.35rem;
            }

            /* Page header meta row: stack vertically */
            .page-header .flex.flex-wrap {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            /* Cards: tighter padding */
            .card-header {
                padding: 12px 16px;
            }
            .card-body {
                padding: 16px;
            }

            /* Meta grid: 1 column on mobile */
            .meta-grid {
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }

            /* Abstract: slightly smaller */
            .abstract-text {
                font-size: 0.9rem;
            }

            /* File card: stack on very small screens */
            .file-card {
                flex-wrap: wrap;
                padding: 14px 14px;
                gap: 10px;
            }
            .file-card .flex-1 {
                min-width: 0;
                flex: 1 1 calc(100% - 60px);
            }
            .btn-download {
                width: 100%;
                justify-content: center;
                padding: 10px 16px;
            }

            /* CTF upload form: stack input + button */
            .card-body form > div {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .card-body form input[type='file'] {
                width: 100%;
                min-width: unset !important;
            }
            .card-body form button[type='submit'] {
                width: 100%;
                justify-content: center;
            }

            /* Back link: a bit smaller */
            .back-link {
                font-size: 0.72rem;
                margin-bottom: 20px;
            }

            /* Page header padding */
            .page-header {
                padding-bottom: 20px;
                margin-bottom: 24px;
            }
        }

        @media (max-width: 400px) {
            .ms-title {
                font-size: 1.18rem;
            }

            /* Single column meta on tiny phones */
            .meta-grid {
                grid-template-columns: 1fr;
            }

            .card-body {
                padding: 14px 12px;
            }

            .card-header {
                padding: 10px 12px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-5xl mx-auto px-2 py-6">
        {{-- Back --}}
        <a
            href="{{ route('managing-editor.dashboard') }}"
            class="back-link fu"
        >
            <svg
                width="14"
                height="14"
                fill="none"
                stroke="currentColor"
                stroke-width="2.5"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
            Back to Dashboard
        </a>

        {{-- Page Header --}}
        <div class="page-header fu">
            <p class="eyebrow">Manuscript Detail</p>
            <h1 class="ms-title">{{ $submission->title }}</h1>
            <div class="flex flex-wrap items-center gap-3 mt-3">
                <span class="ms-ref-pill">
                    <svg
                        width="12"
                        height="12"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 7h10M7 11h6M7 15h4"
                        />
                    </svg>
                    REF #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                </span>

                @php
                    $meStatus = $submission->managing_editor_status ?? 'pending';
                    [$cls, $label] = match ($meStatus) {
                        'ctf_sent' => ['ctf-sent', 'CTF Sent'],
                        'forwarded' => ['forwarded', 'Sent to Layout'],
                        'published' => ['published', 'Published'],
                        default => ['pending-me', 'Awaiting CTF'],
                    };
                @endphp

                <span class="sbadge {{ $cls }}">
                    <span class="dot"></span>
                    {{ $label }}
                </span>

                <span style="font-size: 0.8rem; color: var(--ink-soft)">
                    Assigned
                    {{
                        $submission->managing_editor_assigned_at
                            ? \Carbon\Carbon::parse($submission->managing_editor_assigned_at)->format('M j, Y')
                            : '—'
                    }}
                </span>
            </div>
        </div>

        {{-- Author Info --}}
        <div class="card fu1">
            <div class="card-header">
                <div
                    class="card-header-icon"
                    style="background: var(--teal-lt)"
                >
                    <svg
                        width="16"
                        height="16"
                        fill="none"
                        stroke="var(--teal)"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                    </svg>
                </div>
                <span class="card-header-title">Author</span>
            </div>
            <div class="card-body">
                <div class="author-row">
                    <div class="author-avatar">
                        {{ strtoupper(substr($submission->author->name ?? 'A', 0, 2)) }}
                    </div>
                    <div>
                        <p class="author-name">
                            {{ $submission->author->name ?? 'Unknown Author' }}
                        </p>
                        <p class="author-email">
                            {{ $submission->author->email ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Manuscript Info --}}
        <div class="card fu1">
            <div class="card-header">
                <div class="card-header-icon" style="background: #fdf8ec">
                    <svg
                        width="16"
                        height="16"
                        fill="none"
                        stroke="var(--gold-dk)"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"
                        />
                    </svg>
                </div>
                <span class="card-header-title">Manuscript Information</span>
            </div>
            <div class="card-body">
                <div class="meta-grid">
                    <div class="meta-item">
                        <p class="meta-label">Research Field</p>
                        <p class="meta-value">
                            {{ $submission->research_field ?? '—' }}
                        </p>
                    </div>
                    <div class="meta-item">
                        <p class="meta-label">Date Submitted</p>
                        <p class="meta-value">
                            {{ $submission->submitted_at?->format('M j, Y') ?? '—' }}
                        </p>
                    </div>
                    <div class="meta-item">
                        <p class="meta-label">Submission Status</p>
                        <p class="meta-value">
                            {{ \App\Models\Submission::statusOptions()[$submission->status] ?? ucfirst($submission->status) }}
                        </p>
                    </div>
                    <div class="meta-item">
                        <p class="meta-label">Assigned Editor</p>
                        <p class="meta-value">
                            {{ $submission->assignedEditor->name ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Abstract --}}
        <div class="card fu2">
            <div class="card-header">
                <div
                    class="card-header-icon"
                    style="background: var(--teal-lt)"
                >
                    <svg
                        width="16"
                        height="16"
                        fill="none"
                        stroke="var(--teal)"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 10h16M4 14h10"
                        />
                    </svg>
                </div>
                <span class="card-header-title">Abstract</span>
            </div>
            <div class="card-body">
                <p class="abstract-text">
                    {{ $submission->abstract ?? 'No abstract provided.' }}
                </p>
            </div>
        </div>

        {{-- Keywords --}}
        @if ($submission->keywords)
            <div class="card fu2">
                <div class="card-header">
                    <div
                        class="card-header-icon"
                        style="background: var(--teal-lt)"
                    >
                        <svg
                            width="16"
                            height="16"
                            fill="none"
                            stroke="var(--teal)"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7 7l10 10M17 7L7 17"
                            />
                        </svg>
                    </div>
                    <span class="card-header-title">Keywords</span>
                </div>
                <div class="card-body">
                    <div class="kw-wrap">
                        @foreach (array_filter(array_map('trim', explode(',', $submission->keywords))) as $kw)
                            <span class="kw-chip">{{ $kw }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Manuscript Files --}}
        <div class="card fu3">
            <div class="card-header">
                <div class="card-header-icon" style="background: #fdf8ec">
                    <svg
                        width="16"
                        height="16"
                        fill="none"
                        stroke="var(--gold-dk)"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
                <span class="card-header-title">Manuscript Files</span>
            </div>
            <div class="card-body">
                {{-- Latest / Revised Copy --}}
                @if ($submission->file_path)
                    <div class="file-card">
                        <div class="file-icon">
                            <svg
                                width="20"
                                height="20"
                                fill="none"
                                stroke="var(--teal)"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="file-name">
                                {{ $submission->file_name ?? basename($submission->file_path) }}
                            </p>
                            <p class="file-tag" style="color: var(--teal-dk)">
                                ✦ Latest / Revised Copy
                            </p>
                        </div>
                        <a
                            href="{{ route('submissions.download', $submission) }}"
                            class="btn-download"
                        >
                            <svg
                                width="13"
                                height="13"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                />
                            </svg>
                            Download
                        </a>
                    </div>
                @endif

                @if (! $submission->file_path && ! $submission->original_file_path)
                    <p
                        style="
                            font-size: 0.88rem;
                            color: var(--ink-soft);
                            text-align: center;
                            padding: 24px 0;
                        "
                    >
                        No files attached to this submission.
                    </p>
                @endif
            </div>
        </div>
        {{-- CTF Upload --}}
        <div class="card fu3">
            <div class="card-header">
                <div class="card-header-icon" style="background: #fdf8ec">
                    <svg
                        width="16"
                        height="16"
                        fill="none"
                        stroke="var(--gold-dk)"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
                <span class="card-header-title">Copyright Transfer Form</span>
            </div>
            <div class="card-body">
                @if ($submission->ctf_file_path)
                    {{-- Already uploaded --}}
                    <div class="file-card">
                        <div class="file-icon">
                            <svg
                                width="20"
                                height="20"
                                fill="none"
                                stroke="var(--gold-dk)"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="file-name">
                                {{ $submission->ctf_file_name ?? 'copyright-transfer-form.pdf' }}
                            </p>
                            <p class="file-tag" style="color: var(--gold-dk)">
                                CTF — Sent
                                {{ $submission->ctf_sent_at?->format('M j, Y') }}
                            </p>
                        </div>
                        <a
                            href="{{ route('submissions.download-ctf', $submission) }}"
                            class="btn-download"
                            style="
                                border-color: rgba(201, 168, 76, 0.4);
                                color: var(--gold-dk);
                            "
                        >
                            <svg
                                width="13"
                                height="13"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                />
                            </svg>
                            Download
                        </a>
                    </div>
                    <p
                        style="
                            font-size: 0.82rem;
                            color: var(--ink-soft);
                            margin-top: 12px;
                        "
                    >
                        Re-upload to replace the existing CTF:
                    </p>
                @endif

                {{-- Upload Form --}}
                @if ($submission->managing_editor_status !== 'forwarded' && $submission->managing_editor_status !== 'published')
                    <form
                        method="POST"
                        action="{{ route('managing-editor.ctf.generate', $submission) }}"
                        enctype="multipart/form-data"
                        style="
                            margin-top: {{ $submission->ctf_file_path ? '8px' : '0' }};
                        "
                    >
                        @csrf
                        <div
                            style="
                                display: flex;
                                gap: 12px;
                                align-items: center;
                                flex-wrap: wrap;
                            "
                        >
                            <input
                                type="file"
                                name="ctf_file"
                                accept=".pdf,.doc,.docx"
                                required
                                style="
                                    font-size: 0.88rem;
                                    color: var(--ink);
                                    flex: 1;
                                    min-width: 200px;
                                "
                            />
                            <button
                                type="submit"
                                style="
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 8px;
                                    background: var(--gold);
                                    color: #fff;
                                    font-size: 0.76rem;
                                    font-weight: 700;
                                    letter-spacing: 0.08em;
                                    text-transform: uppercase;
                                    padding: 10px 20px;
                                    border-radius: 6px;
                                    border: none;
                                    cursor: pointer;
                                    transition: background 0.15s;
                                    white-space: nowrap;
                                "
                            >
                                <svg
                                    width="14"
                                    height="14"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                    />
                                </svg>
                                Upload & Send CTF
                            </button>
                        </div>
                        @error('ctf_file')
                            <p
                                style="
                                    color: #dc2626;
                                    font-size: 0.82rem;
                                    margin-top: 8px;
                                "
                            >
                                {{ $message }}
                            </p>
                        @enderror
                    </form>
                @else
                    <p
                        style="
                            font-size: 0.88rem;
                            color: var(--ink-soft);
                            padding: 12px 0;
                        "
                    >
                        Manuscript has been forwarded to layout editor. CTF
                        upload is locked.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
