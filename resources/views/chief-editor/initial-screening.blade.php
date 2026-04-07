@extends('layouts.app')

@section('title', 'Initial Screening')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --gold: #c9a84c;
            --gold-dk: #8a6e28;
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #ede6d8;
            --parch-lt: #f3ede0;
            --border: #ddd4c0;
            --border-lt: #e8dfd0;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
        }

        .screening-page {
            min-height: 100vh;
            background-color: var(--parchment);
            background-image: repeating-linear-gradient(
                -50deg,
                rgba(138, 110, 40, 0.018) 0px,
                rgba(138, 110, 40, 0.018) 1px,
                transparent 1px,
                transparent 22px
            );
            padding-bottom: 60px;
        }

        /* ── Page hero ── */
        .page-hero {
            padding: 24px 0 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }
        @media (min-width: 640px) {
            .page-hero {
                padding: 36px 0 28px;
                margin-bottom: 28px;
            }
        }
        .page-hero::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .hero-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 10px;
        }
        .hero-eyebrow::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--teal);
            border-radius: 2px;
        }
        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(1.6rem, 5vw, 2.8rem);
            font-weight: 700;
            color: var(--ink);
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-size: 0.82rem;
            color: var(--ink-soft);
        }
        @media (min-width: 640px) {
            .hero-sub {
                font-size: 0.88rem;
            }
        }
        .hero-sub strong {
            color: var(--ink-mid);
            font-weight: 600;
        }

        /* ── Cards ── */
        .sc-card {
            background: var(--parch-lt);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow:
                0 2px 12px rgba(26, 18, 9, 0.05),
                0 1px 3px rgba(26, 18, 9, 0.03);
        }
        .sc-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 16px;
            border-bottom: 1px solid var(--border-lt);
            background: linear-gradient(
                to right,
                var(--parchment),
                var(--parch-lt)
            );
        }
        @media (min-width: 640px) {
            .sc-card-head {
                padding: 13px 22px;
            }
        }
        .sc-card-head h2 {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: var(--ink-mid);
        }
        .sc-card-head span {
            font-size: 0.65rem;
            color: var(--gold-dk);
            font-weight: 600;
            opacity: 0.8;
        }
        .sc-card-body {
            padding: 16px;
        }
        @media (min-width: 640px) {
            .sc-card-body {
                padding: 22px;
            }
        }

        .meta-label {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold-dk);
            margin-bottom: 6px;
            opacity: 0.75;
        }

        .field-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(45, 129, 118, 0.08);
            border: 1px solid rgba(45, 129, 118, 0.22);
            color: var(--teal-dk);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .keyword-chip {
            display: inline-flex;
            padding: 3px 10px;
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 0.7rem;
            color: var(--ink-soft);
            font-weight: 500;
        }

        .file-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            background: rgba(45, 129, 118, 0.06);
            border: 1px solid rgba(45, 129, 118, 0.18);
            border-radius: 10px;
            padding: 10px 14px;
        }
        .file-box-name {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--teal-dk);
            word-break: break-all;
        }
        .file-box-dl {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--teal);
            border: 1px solid var(--teal);
            padding: 5px 12px;
            border-radius: 8px;
            text-decoration: none;
            transition:
                background 0.15s,
                color 0.15s;
            white-space: nowrap;
        }
        .file-box-dl:hover {
            background: var(--teal);
            color: #fff;
        }

        .sc-divider {
            height: 1px;
            background: linear-gradient(to right, var(--border), transparent);
            margin: 16px 0;
        }

        /* ── Decision panel ── */
        .decision-panel {
            background: var(--parch-lt);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.05);
            position: relative;
            overflow: hidden;
        }
        @media (min-width: 640px) {
            .decision-panel {
                padding: 22px;
            }
        }
        .decision-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 16px;
            right: 16px;
            height: 2px;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(201, 168, 76, 0.55),
                rgba(240, 214, 120, 0.9),
                rgba(201, 168, 76, 0.55),
                transparent
            );
        }
        .decision-panel h2 {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 14px;
            padding-top: 4px;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 10px;
            padding: 9px 12px;
            margin-bottom: 16px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .status-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .status-pending {
            background: #fffbeb;
            border: 1px solid #f6d860;
            color: #92400e;
        }
        .status-pending .dot {
            background: #f6c90e;
        }
        .status-passed {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #166534;
        }
        .status-passed .dot {
            background: #22c55e;
        }
        .status-failed {
            background: #fff1f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }
        .status-failed .dot {
            background: #ef4444;
        }

        .decision-card {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 11px 13px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            cursor: pointer;
            background: var(--cream);
            transition:
                border-color 0.15s,
                background 0.15s,
                box-shadow 0.15s;
        }
        .decision-card.is-pass.selected {
            border-color: var(--teal);
            background: rgba(45, 129, 118, 0.05);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.08);
        }
        .decision-card.is-fail.selected {
            border-color: #dc2626;
            background: #fff5f5;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.07);
        }
        .dc-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--ink-mid);
        }
        .dc-hint {
            font-size: 0.63rem;
            color: var(--gold-dk);
            margin-top: 2px;
            opacity: 0.75;
        }

        .sc-textarea {
            width: 100%;
            padding: 10px 14px;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.85rem;
            color: var(--ink);
            resize: none;
            outline: none;
            line-height: 1.65;
            transition:
                border-color 0.18s,
                box-shadow 0.18s,
                background 0.18s;
        }
        .sc-textarea:focus {
            border-color: var(--teal);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(45, 129, 118, 0.1);
        }
        .sc-textarea::placeholder {
            color: #c9b99a;
        }

        .btn-submit-decision {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 20px;
            background: linear-gradient(
                135deg,
                var(--teal) 0%,
                var(--teal-dk) 100%
            );
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(26, 77, 70, 0.22);
            transition:
                transform 0.14s,
                box-shadow 0.14s;
            position: relative;
            overflow: hidden;
        }
        .btn-submit-decision::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            pointer-events: none;
        }
        .btn-submit-decision:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(26, 77, 70, 0.3);
        }
        .btn-submit-decision:active {
            transform: translateY(0);
        }

        .tip-card {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: rgba(201, 168, 76, 0.07);
            border: 1px solid rgba(201, 168, 76, 0.28);
            border-radius: 12px;
            padding: 13px 15px;
        }
        .tip-card p {
            font-size: 0.72rem;
            color: #78520a;
            line-height: 1.65;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-decoration: none;
            transition: color 0.15s;
            padding-top: 24px;
            margin-bottom: 16px;
        }
        @media (min-width: 640px) {
            .back-link {
                padding-top: 32px;
                margin-bottom: 20px;
            }
        }
        .back-link:hover {
            color: var(--teal-dk);
        }
        .back-link:hover svg {
            transform: translateX(-3px);
        }
        .back-link svg {
            transition: transform 0.15s;
        }
    </style>
@endpush

@section('content')
    <div class="screening-page">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back link --}}
            <a
                href="{{ route('chief-editor.submission.show', $submission) }}"
                class="back-link"
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
                        d="M19 12H5M12 5l-7 7 7 7"
                    />
                </svg>
                Back to Submission
            </a>

            {{-- Page Hero --}}
            <div class="page-hero">
                <div class="hero-eyebrow">Chief Editor · Review</div>
                <h1 class="hero-title">
                    <em>Initial</em>
                    Screening
                </h1>
                <p class="hero-sub">
                    <strong>{{ $submission->title }}</strong>
                    &nbsp;·&nbsp; Author: {{ $submission->author->name }}
                </p>
            </div>

            {{-- Grid: stacks on mobile, side-by-side on lg --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">
                {{-- LEFT --}}
                <div class="lg:col-span-2 flex flex-col gap-5">
                    <div class="sc-card">
                        <div class="sc-card-head">
                            <h2>📄 Submission Details</h2>
                            <span>ID #{{ $submission->id }}</span>
                        </div>
                        <div class="sc-card-body">
                            {{-- 2-col on sm+, 1-col on mobile --}}
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 mb-4"
                            >
                                <div>
                                    <p class="meta-label">Research Field</p>
                                    <span class="field-badge">
                                        🔬
                                        {{ $submission->research_field ?? 'Not specified' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="meta-label">Submitted On</p>
                                    <p
                                        class="text-sm font-semibold"
                                        style="color: var(--ink-mid)"
                                    >
                                        {{ $submission->submitted_at->format('M d, Y') }}
                                    </p>
                                    <p
                                        class="text-xs"
                                        style="
                                            color: var(--gold-dk);
                                            opacity: 0.7;
                                        "
                                    >
                                        {{ $submission->submitted_at->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                            <div class="sc-divider"></div>
                            <div class="mb-5">
                                <p class="meta-label">Abstract</p>
                                <p
                                    class="text-sm leading-relaxed text-justify"
                                    style="
                                        color: var(--ink-mid);
                                        line-height: 1.75;
                                    "
                                >
                                    {{ $submission->abstract }}
                                </p>
                            </div>
                            <div class="mb-5">
                                <p class="meta-label">Keywords</p>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    @foreach (explode(',', $submission->keywords) as $keyword)
                                        <span class="keyword-chip">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @if ($submission->file_name)
                                <div>
                                    <p class="meta-label">Submission File</p>
                                    <div class="file-box mt-1">
                                        <span class="file-box-name">
                                            <svg
                                                width="15"
                                                height="15"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                                />
                                                <polyline
                                                    points="14 2 14 8 20 8"
                                                />
                                            </svg>
                                            {{ $submission->original_file_name ?? $submission->file_name }}
                                        </span>
                                        <a
                                            href="{{ route('submissions.download-original', $submission) }}"
                                            class="file-box-dl"
                                        >
                                            ↓ Download
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (! $submission->isPendingInitialScreening())
                        <div class="sc-card">
                            <div class="sc-card-head">
                                <h2>📋 Previous Screening Record</h2>
                            </div>
                            <div class="sc-card-body">
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4"
                                >
                                    <div>
                                        <p class="meta-label">Screened By</p>
                                        <p
                                            class="text-sm font-semibold"
                                            style="color: var(--ink-mid)"
                                        >
                                            {{ $submission->initialScreeningBy?->name ?? 'Unknown' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="meta-label">Screening Date</p>
                                        <p
                                            class="text-sm font-semibold"
                                            style="color: var(--ink-mid)"
                                        >
                                            {{ $submission->initial_screening_at?->format('M d, Y') }}
                                        </p>
                                        <p
                                            class="text-xs"
                                            style="
                                                color: var(--gold-dk);
                                                opacity: 0.7;
                                            "
                                        >
                                            {{ $submission->initial_screening_at?->format('h:i A') }}
                                        </p>
                                    </div>
                                    @if ($submission->initial_screening_comments)
                                        <div class="col-span-1 sm:col-span-2">
                                            <p class="meta-label">Comments</p>
                                            <p
                                                class="text-sm leading-relaxed text-justify"
                                                style="
                                                    color: var(--ink-mid);
                                                    line-height: 1.75;
                                                "
                                            >
                                                {{ $submission->initial_screening_comments }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- RIGHT --}}
                <div class="lg:col-span-1 flex flex-col gap-4">
                    <div class="decision-panel">
                        <h2>⚖️ Make Decision</h2>

                        @php
                            $currentStatus = $submission->initial_screening_status;
                        @endphp

                        @if ($submission->isPendingInitialScreening())
                            <div class="status-badge status-pending">
                                <span class="dot"></span>
                                Awaiting initial screening
                            </div>
                        @elseif ($currentStatus === 'passed')
                            <div class="status-badge status-passed">
                                <span class="dot"></span>
                                Currently: Passed Screening
                            </div>
                        @else
                            <div class="status-badge status-failed">
                                <span class="dot"></span>
                                Currently: {{ ucfirst($currentStatus) }}
                            </div>
                        @endif

                        <form
                            method="POST"
                            action="{{ route('chief-editor.store-initial-screening', $submission) }}"
                        >
                            @csrf
                            <div class="mb-4">
                                <p
                                    class="meta-label"
                                    style="margin-bottom: 8px"
                                >
                                    Decision
                                </p>
                                <div class="flex flex-col gap-2">
                                    <label
                                        class="decision-card is-pass"
                                        id="card-pass"
                                    >
                                        <input
                                            type="radio"
                                            name="screening_status"
                                            value="passed"
                                            style="
                                                accent-color: var(--teal);
                                                margin-top: 2px;
                                            "
                                            {{ old('screening_status', $currentStatus) === 'passed' ? 'checked' : '' }}
                                        />
                                        <div>
                                            <p class="dc-label">
                                                ✓ Pass — Proceed
                                            </p>
                                            <p class="dc-hint">
                                                Meets basic standards
                                            </p>
                                        </div>
                                    </label>
                                    <label
                                        class="decision-card is-fail"
                                        id="card-fail"
                                    >
                                        <input
                                            type="radio"
                                            name="screening_status"
                                            value="failed"
                                            style="
                                                accent-color: #dc2626;
                                                margin-top: 2px;
                                            "
                                            {{ old('screening_status', $currentStatus) === 'failed' ? 'checked' : '' }}
                                        />
                                        <div>
                                            <p class="dc-label">
                                                ✗ Fail — Reject
                                            </p>
                                            <p class="dc-hint">
                                                Below submission quality
                                            </p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label
                                    class="meta-label"
                                    style="display: block; margin-bottom: 6px"
                                >
                                    Comments / Suggestions
                                    <span style="color: #dc2626">*</span>
                                </label>
                                <textarea
                                    id="comments-box"
                                    name="comments"
                                    rows="4"
                                    required
                                    class="sc-textarea"
                                    placeholder="Provide feedback or reasons for your decision..."
                                >
{{ old('comments', $submission->initial_screening_comments) }}</textarea
                                >
                            </div>

                            <button type="submit" class="btn-submit-decision">
                                <svg
                                    width="13"
                                    height="13"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                {{ $submission->isPendingInitialScreening() ? 'Submit Decision' : 'Update Decision' }}
                            </button>
                        </form>

                        <div
                            class="mt-4 pt-4 text-center"
                            style="border-top: 1px solid var(--border-lt)"
                        >
                            <a
                                href="{{ route('chief-editor.submission.show', $submission) }}"
                                class="text-xs font-semibold"
                                style="
                                    color: var(--gold-dk);
                                    opacity: 0.7;
                                    text-decoration: none;
                                    transition: color 0.15s;
                                "
                                onmouseover="
                                    this.style.color = 'var(--teal-dk)';
                                    this.style.opacity = 1;
                                "
                                onmouseout="
                                    this.style.color = 'var(--gold-dk)';
                                    this.style.opacity = 0.7;
                                "
                            >
                                Cancel — Go back
                            </a>
                        </div>
                    </div>

                    <div class="tip-card">
                        <span
                            style="
                                font-size: 1.1rem;
                                line-height: 1;
                                flex-shrink: 0;
                            "
                        >
                            💡
                        </span>
                        <p>
                            Submitting will notify the author.
                            <strong>Passed</strong>
                            submissions will be available for editor assignment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll(
                'input[name="screening_status"]',
            );
            const commentsBox = document.getElementById('comments-box');
            const cardPass = document.getElementById('card-pass');
            const cardFail = document.getElementById('card-fail');

            const autoComments = {
                passed: 'Congratulations! Your submission has passed the initial screening and will proceed to the next stage of peer review.',
                failed: 'Thank you for your submission. Unfortunately, your manuscript does not meet the minimum requirements for our journal at this time.',
            };

            function updateUI() {
                radios.forEach((radio) => {
                    if (radio.checked) {
                        if (radio.value === 'passed') {
                            cardPass.classList.add('selected');
                            cardFail.classList.remove('selected');
                            if (
                                !commentsBox.value ||
                                commentsBox.value === autoComments.failed
                            )
                                commentsBox.value = autoComments.passed;
                        } else {
                            cardFail.classList.add('selected');
                            cardPass.classList.remove('selected');
                            if (
                                !commentsBox.value ||
                                commentsBox.value === autoComments.passed
                            )
                                commentsBox.value = autoComments.failed;
                        }
                    }
                });
            }

            radios.forEach((r) => r.addEventListener('change', updateUI));
            updateUI();
        });
    </script>
@endsection
