@extends('layouts.app')

@section('title', 'Review Appeal - ' . $appeal->submission->title)

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-dark: #1a4d46;
            --teal-light: #e8f4f2;
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
            --muted: #64748b;
            --white: #ffffff;
            --red: #dc2626;
            --red-light: #fef2f2;
            --amber: #d97706;
            --amber-light: #fffbeb;
            --emerald: #059669;
            --emerald-light: #ecfdf5;
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
        .font-mono {
            font-family: 'DM Mono', monospace;
        }

        /* ── Hero Header ── */
        .hero-header {
            position: relative;
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 32px;
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
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.25;
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-size: 0.9rem;
            color: var(--ink-soft);
            margin-top: 6px;
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
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #c9b99a;
            text-decoration: none;
            margin-bottom: 16px;
            transition: color 0.15s;
        }
        .back-link:hover {
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
            animation: fadeUp 0.35s ease both;
        }
        .fu1 {
            animation: fadeUp 0.35s 0.07s ease both;
        }
        .fu2 {
            animation: fadeUp 0.35s 0.14s ease both;
        }
        .fu3 {
            animation: fadeUp 0.35s 0.21s ease both;
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
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
            color: var(--ink-soft);
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

        .meta-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 4px;
        }

        /* ── Appeal reason box ── */
        .reason-box {
            background: var(--parchment);
            border: 1px solid var(--border);
            border-left: 3px solid var(--amber);
            border-radius: 10px;
            padding: 16px 18px;
            font-size: 13px;
            color: var(--ink-mid);
            line-height: 1.75;
            /* Fix overflow */
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            max-height: 320px;
            overflow-y: auto;
        }
        .reason-box::-webkit-scrollbar {
            width: 4px;
        }
        .reason-box::-webkit-scrollbar-thumb {
            background: var(--border-dk);
            border-radius: 4px;
        }

        /* ── Rejection note ── */
        .rejection-note {
            background: var(--red-light);
            border: 1px solid #fecaca;
            border-left: 3px solid var(--red);
            border-radius: 10px;
            padding: 14px 16px;
            margin-top: 16px;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* ── Decision radio cards ── */
        .decision-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 8px;
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
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 14px 16px;
            cursor: pointer;
            transition:
                border-color 0.16s,
                background 0.16s,
                box-shadow 0.16s;
        }
        .decision-face:hover {
            border-color: var(--teal);
        }
        .dec-approve input:checked + .decision-face {
            border-color: var(--emerald);
            background: var(--emerald-light);
            box-shadow: 0 2px 10px rgba(5, 150, 105, 0.12);
        }
        .dec-reject input:checked + .decision-face {
            border-color: var(--red);
            background: var(--red-light);
            box-shadow: 0 2px 10px rgba(220, 38, 38, 0.12);
        }
        .decision-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon-emerald {
            background: var(--emerald-light);
        }
        .icon-red {
            background: var(--red-light);
        }

        /* ── Textarea ── */
        .field-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: var(--parchment);
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            color: var(--ink);
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            outline: none;
            resize: vertical;
            line-height: 1.65;
        }
        .field-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
            background: var(--white);
        }
        .field-input::placeholder {
            color: #b5a595;
        }
        .field-input.error {
            border-color: var(--red);
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
            font-family: 'Source Sans 3', sans-serif;
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
        .btn-teal {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 2px 10px rgba(45, 129, 118, 0.25);
        }
        .btn-ghost {
            background: var(--parchment);
            color: var(--muted);
            border: 1.5px solid var(--border);
        }
        .btn-ghost:hover {
            color: var(--ink);
            border-color: var(--teal);
            background: var(--white);
        }

        /* ── Status badge ── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .s-pending {
            background: var(--amber-light);
            border-color: #fde68a;
            color: #92400e;
        }
        .s-pending .status-dot {
            background: var(--amber);
        }
        .s-approved {
            background: var(--emerald-light);
            border-color: #a7f3d0;
            color: #065f46;
        }
        .s-approved .status-dot {
            background: var(--emerald);
        }
        .s-rejected {
            background: var(--red-light);
            border-color: #fecaca;
            color: #991b1b;
        }
        .s-rejected .status-dot {
            background: var(--red);
        }

        /* ── Sidebar card ── */
        .sidebar-card {
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
        }
        .sidebar-card + .sidebar-card {
            margin-top: 14px;
        }
        .sidebar-row {
            margin-bottom: 14px;
        }
        .sidebar-row:last-child {
            margin-bottom: 0;
        }
        .sidebar-val {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            margin-top: 2px;
            word-break: break-word;
        }

        /* ── Decision result block ── */
        .result-block {
            border-radius: 12px;
            padding: 20px;
            border: 1.5px solid;
        }
        .result-approved {
            background: var(--emerald-light);
            border-color: #a7f3d0;
        }
        .result-rejected {
            background: var(--red-light);
            border-color: #fecaca;
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-5xl mx-auto px-6 pb-16">
        {{-- ── Hero Header ── --}}
        <div class="hero-header fu">
            <a href="{{ route('appeals.index') }}" class="back-link">
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
                Back to Appeals
            </a>
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Editor-in-Chief</p>
                    <h1 class="hero-title">
                        Review
                        <em>Appeal</em>
                    </h1>
                    <p class="hero-sub">
                        <strong>{{ $appeal->author->name }}</strong>
                        &nbsp;·&nbsp;
                        #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}
                        &nbsp;·&nbsp;
                        @php
                            $sc = $appeal->isPending() ? 's-pending' : ($appeal->isApproved() ? 's-approved' : 's-rejected');
                            $sl = $appeal->isPending() ? 'Pending Review' : ($appeal->isApproved() ? 'Approved' : 'Rejected');
                        @endphp

                        <span
                            class="status-badge {{ $sc }}"
                            style="vertical-align: middle"
                        >
                            <span class="status-dot"></span>
                            {{ $sl }}
                        </span>
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

        {{-- ── Two-column grid ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- ── Main column ── --}}
            <div class="lg:col-span-2 space-y-0">
                {{-- Submission Info --}}
                <div class="card fu1">
                    <div class="section-label">Submission Details</div>
                    <p
                        style="
                            font-family: 'Libre Baskerville', serif;
                            font-size: 1.1rem;
                            font-weight: 400;
                            font-style: italic;
                            color: var(--ink);
                            line-height: 1.4;
                            margin-bottom: 12px;
                        "
                    >
                        {{ $appeal->submission->title }}
                    </p>
                    <div
                        style="
                            display: flex;
                            flex-wrap: wrap;
                            gap: 20px;
                            font-size: 12px;
                            color: var(--ink-soft);
                        "
                    >
                        <div>
                            <span class="meta-label" style="display: block">
                                Author
                            </span>
                            <span style="font-weight: 600; color: var(--ink)">
                                {{ $appeal->author->name }}
                            </span>
                        </div>
                        <div>
                            <span class="meta-label" style="display: block">
                                Submission Ref
                            </span>
                            <span
                                style="font-weight: 600; color: var(--teal)"
                                class="font-mono"
                            >
                                #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <div>
                            <span class="meta-label" style="display: block">
                                Original Rejection Date
                            </span>
                            <span style="font-weight: 600; color: var(--ink)">
                                {{ $appeal->submission->initial_screening_at?->format('M d, Y') ?? '—' }}
                            </span>
                        </div>
                    </div>

                    @if ($appeal->submission->initial_screening_comments)
                        <div class="rejection-note" style="margin-top: 16px">
                            <p
                                class="meta-label"
                                style="color: #991b1b; margin-bottom: 6px"
                            >
                                Rejection Reason
                            </p>
                            <p
                                style="
                                    font-size: 13px;
                                    color: #7f1d1d;
                                    line-height: 1.7;
                                "
                            >
                                {{ $appeal->submission->initial_screening_comments }}
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Appeal Reason --}}
                <div class="card fu1" style="margin-top: 16px">
                    <div class="section-label">Appeal Reason</div>
                    <div class="reason-box">{{ $appeal->reason }}</div>
                    <p
                        style="
                            font-size: 11px;
                            color: var(--muted);
                            margin-top: 10px;
                        "
                        class="font-mono"
                    >
                        Submitted on
                        {{ $appeal->created_at->format('M d, Y \a\t g:i A') }}
                    </p>
                </div>

                {{-- Review Form or Decision Result --}}
                @if ($appeal->isPending())
                    <div class="card fu2" style="margin-top: 16px">
                        <div class="section-label">Record Decision</div>

                        <form
                            action="{{ route('appeals.update', $appeal) }}"
                            method="POST"
                            style="
                                display: flex;
                                flex-direction: column;
                                gap: 20px;
                            "
                        >
                            @csrf
                            @method('PUT')

                            {{-- Decision --}}
                            <div>
                                <label
                                    style="
                                        display: block;
                                        font-size: 12px;
                                        font-weight: 700;
                                        color: var(--ink);
                                        margin-bottom: 8px;
                                    "
                                >
                                    Decision
                                    <span style="color: var(--red)">*</span>
                                </label>
                                <div class="decision-grid">
                                    <div class="decision-option dec-approve">
                                        <input
                                            type="radio"
                                            name="status"
                                            value="approved"
                                            id="dec_approve"
                                            required
                                        />
                                        <label
                                            class="decision-face"
                                            for="dec_approve"
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
                                            <div>
                                                <p
                                                    style="
                                                        font-size: 13px;
                                                        font-weight: 700;
                                                        color: var(--ink);
                                                    "
                                                >
                                                    Approve
                                                </p>
                                                <p
                                                    style="
                                                        font-size: 11px;
                                                        color: var(--muted);
                                                        margin-top: 2px;
                                                    "
                                                >
                                                    Proceed with manuscript
                                                    review
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="decision-option dec-reject">
                                        <input
                                            type="radio"
                                            name="status"
                                            value="rejected"
                                            id="dec_reject"
                                            required
                                        />
                                        <label
                                            class="decision-face"
                                            for="dec_reject"
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
                                            <div>
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
                                                    Uphold initial decision
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @error('status')
                                    <p
                                        style="
                                            font-size: 11px;
                                            color: var(--red);
                                            margin-top: 6px;
                                        "
                                    >
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Response --}}
                            <div>
                                <label
                                    for="editor_response"
                                    style="
                                        display: block;
                                        font-size: 12px;
                                        font-weight: 700;
                                        color: var(--ink);
                                        margin-bottom: 6px;
                                    "
                                >
                                    Your Response
                                    <span style="color: var(--red)">*</span>
                                </label>
                                <textarea
                                    name="editor_response"
                                    id="editor_response"
                                    rows="6"
                                    placeholder="Provide detailed feedback on the appeal decision…"
                                    class="field-input @error('editor_response') error @enderror"
                                    required
                                >
{{ old('editor_response') }}</textarea
                                >
                                <p
                                    style="
                                        font-size: 11px;
                                        color: var(--muted);
                                        margin-top: 4px;
                                    "
                                >
                                    Minimum 10 characters required
                                </p>
                                @error('editor_response')
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

                            {{-- Actions --}}
                            <div
                                style="
                                    display: flex;
                                    align-items: center;
                                    gap: 10px;
                                    padding-top: 16px;
                                    border-top: 1px solid var(--border);
                                "
                            >
                                <button type="submit" class="btn btn-teal">
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
                                    Submit Decision
                                </button>
                                <a
                                    href="{{ route('appeals.index') }}"
                                    class="btn btn-ghost"
                                >
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                @else
                    <div
                        class="result-block fu2 {{ $appeal->isApproved() ? 'result-approved' : 'result-rejected' }}"
                        style="margin-top: 16px"
                    >
                        <div
                            style="
                                display: flex;
                                align-items: flex-start;
                                gap: 14px;
                                margin-bottom: 16px;
                            "
                        >
                            <div
                                style="
                                    width: 44px;
                                    height: 44px;
                                    border-radius: 10px;
                                    background: {{ $appeal->isApproved() ? 'rgba(5,150,105,.15)' : 'rgba(220,38,38,.15)' }};
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                "
                            >
                                @if ($appeal->isApproved())
                                    <svg
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="var(--emerald)"
                                        stroke-width="2.5"
                                    >
                                        <path d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="var(--red)"
                                        stroke-width="2.5"
                                    >
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4
                                    style="
                                        font-family: 'Libre Baskerville', serif;
                                        font-size: 1.1rem;
                                        font-weight: 700;
                                        color: {{ $appeal->isApproved() ? '#065f46' : '#991b1b' }};
                                    "
                                >
                                    Appeal
                                    {{ $appeal->isApproved() ? 'Approved' : 'Rejected' }}
                                </h4>
                                <p
                                    style="
                                        font-size: 12px;
                                        color: {{ $appeal->isApproved() ? '#059669' : '#dc2626' }};
                                        margin-top: 4px;
                                    "
                                    class="font-mono"
                                >
                                    Reviewed on
                                    {{ $appeal->reviewed_at->format('M d, Y \a\t g:i A') }}
                                    @if ($appeal->reviewedBy)
                                        · by
                                        <strong>
                                            {{ $appeal->reviewedBy->name }}
                                        </strong>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if ($appeal->editor_response)
                            <div
                                style="
                                    padding-top: 16px;
                                    border-top: 1px solid
                                        {{ $appeal->isApproved() ? '#a7f3d0' : '#fecaca' }};
                                "
                            >
                                <p
                                    class="meta-label"
                                    style="
                                        color: {{ $appeal->isApproved() ? '#059669' : '#dc2626' }};
                                        margin-bottom: 8px;
                                    "
                                >
                                    Editor's Response
                                </p>
                                <p
                                    style="
                                        font-size: 13px;
                                        color: {{ $appeal->isApproved() ? '#065f46' : '#7f1d1d' }};
                                        line-height: 1.75;
                                        word-break: break-word;
                                        overflow-wrap: break-word;
                                    "
                                >
                                    {{ $appeal->editor_response }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- ── Sidebar ── --}}
            <div class="fu3">
                {{-- Status --}}
                <div class="sidebar-card">
                    <div class="section-label">Appeal Status</div>
                    <span class="status-badge {{ $sc }}">
                        <span class="status-dot"></span>
                        {{ $sl }}
                    </span>
                </div>

                {{-- Submission info --}}
                <div class="sidebar-card" style="margin-top: 14px">
                    <div class="section-label">Submission</div>
                    <div class="sidebar-row">
                        <p class="meta-label">Reference</p>
                        <p
                            class="sidebar-val font-mono"
                            style="color: var(--teal)"
                        >
                            #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>
                    <div class="sidebar-row">
                        <p class="meta-label">Author</p>
                        <p class="sidebar-val">{{ $appeal->author->name }}</p>
                    </div>
                    <div class="sidebar-row">
                        <p class="meta-label">Email</p>
                        <p class="sidebar-val" style="font-size: 11px">
                            {{ $appeal->author->email }}
                        </p>
                    </div>
                    <div class="sidebar-row">
                        <p class="meta-label">Submitted</p>
                        <p
                            class="sidebar-val font-mono"
                            style="font-size: 11px"
                        >
                            {{ $appeal->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <a
                        href="{{ route('submissions.show', $appeal->submission) }}"
                        style="
                            display: block;
                            width: 100%;
                            padding: 9px 0;
                            text-align: center;
                            font-size: 11px;
                            font-weight: 700;
                            letter-spacing: 0.05em;
                            text-transform: uppercase;
                            color: var(--teal);
                            background: var(--teal-light);
                            border: 1px solid rgba(45, 129, 118, 0.25);
                            border-radius: 8px;
                            text-decoration: none;
                            transition:
                                background 0.15s,
                                color 0.15s;
                            margin-top: 4px;
                        "
                        onmouseover="
                            this.style.background = 'var(--teal)';
                            this.style.color = '#fff';
                        "
                        onmouseout="
                            this.style.background = 'var(--teal-light)';
                            this.style.color = 'var(--teal)';
                        "
                    >
                        View Submission →
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
