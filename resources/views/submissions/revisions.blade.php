@extends('layouts.app')

@section('title', 'Revision Requests - ' . $submission->title)

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
            --orange: #ea580c;
            --orange-lt: #fff7ed;
        }
        * {
            box-sizing: border-box;
        }
        .rw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            font-size: 16px;
        }
        .serif {
            font-family: 'Libre Baskerville', serif;
        }

        /* Hero */
        .hero-header {
            position: relative;
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 36px;
        }
        @media (max-width: 640px) {
            .hero-header {
                padding: 28px 0 22px;
                margin-bottom: 24px;
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
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.15;
        }
        @media (max-width: 640px) {
            .hero-title {
                font-size: 2rem;
            }
        }
        @media (max-width: 400px) {
            .hero-title {
                font-size: 1.65rem;
            }
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
        @media (max-width: 640px) {
            .hero-sub {
                font-size: 0.9rem;
            }
        }

        /* Hero layout row */
        .hero-row {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
        }
        @media (max-width: 640px) {
            .hero-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: var(--parchment);
            transition: all 0.15s;
            white-space: nowrap;
        }
        .back-link:hover {
            border-color: var(--teal);
            color: var(--teal);
            background: var(--teal-lt);
        }

        /* Revision card */
        .rev-card {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
            transition: box-shadow 0.2s;
            margin-bottom: 20px;
        }
        .rev-card.resolved {
            opacity: 0.72;
        }
        .rev-card-header {
            padding: 22px 28px 18px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }
        @media (max-width: 640px) {
            .rev-card-header {
                padding: 16px 16px 14px;
                flex-direction: column;
                gap: 12px;
            }
        }
        .rev-type-label {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }
        @media (max-width: 640px) {
            .rev-type-label {
                font-size: 1.05rem;
            }
        }
        .rev-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .rev-meta-text {
            font-size: 0.85rem;
            color: var(--ink-soft);
        }
        .rev-meta-text strong {
            color: var(--ink);
            font-weight: 700;
        }
        .role-chip {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .role-chip.chief {
            background: #f5f0ff;
            border-color: #c4b5fd;
            color: #5b21b6;
        }
        .role-chip.editor {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8;
        }
        .role-chip.reviewer {
            background: #f0fdf4;
            border-color: #6ee7b7;
            color: #065f46;
        }
        .rev-dot {
            color: var(--border-dk);
            font-size: 0.7rem;
        }
        @media (max-width: 480px) {
            .rev-dot {
                display: none;
            }
        }
        .rev-date {
            font-size: 0.75rem;
            color: var(--ink-soft);
            letter-spacing: 0.03em;
        }

        /* Badge group in header */
        .rev-badge-group {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            flex-shrink: 0;
        }
        @media (max-width: 640px) {
            .rev-badge-group {
                flex-direction: row;
                align-items: center;
                flex-wrap: wrap;
            }
        }

        /* Type + status badges */
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
            white-space: nowrap;
        }
        .type-badge.minor {
            background: #fefce8;
            border-color: #fde68a;
            color: #854d0e;
        }
        .type-badge.major {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #9a3412;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
            white-space: nowrap;
        }
        .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .status-badge.resolved {
            background: #f0fdf4;
            border-color: #86efac;
            color: #166534;
        }
        .status-badge.resolved .dot {
            background: #22c55e;
        }
        .status-badge.pending {
            background: #fffbeb;
            border-color: #fcd34d;
            color: #92400e;
        }
        .status-badge.pending .dot {
            background: #f59e0b;
        }

        /* Card body */
        .rev-card-body {
            padding: 24px 28px;
        }
        @media (max-width: 640px) {
            .rev-card-body {
                padding: 16px 16px;
            }
        }
        .reason-block {
            background: var(--parchment);
            border: 1px solid var(--border);
            border-left: 3px solid var(--teal);
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 22px;
        }
        @media (max-width: 640px) {
            .reason-block {
                padding: 12px 14px;
                margin-bottom: 16px;
            }
        }
        .reason-label {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--teal-dk);
            margin-bottom: 8px;
        }
        .reason-text {
            font-size: 0.92rem;
            color: var(--ink-mid);
            line-height: 1.7;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* Resolved state */
        .resolved-block {
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 10px;
            padding: 18px 22px;
        }
        @media (max-width: 640px) {
            .resolved-block {
                padding: 14px 16px;
            }
        }
        .resolved-title {
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #166534;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .resolved-date {
            font-size: 0.82rem;
            color: #4ade80;
            margin-bottom: 0;
        }
        .resolved-notes {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #bbf7d0;
            font-size: 0.88rem;
            color: #15803d;
            line-height: 1.6;
            word-break: break-word;
        }
        .resolved-notes strong {
            font-weight: 700;
        }

        /* Awaiting older */
        .awaiting-block {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-left: 3px solid #f59e0b;
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        @media (max-width: 480px) {
            .awaiting-block {
                padding: 14px 14px;
                gap: 10px;
            }
        }
        .awaiting-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #fef3c7;
            color: #d97706;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .awaiting-title {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #92400e;
            margin-bottom: 3px;
        }
        .awaiting-desc {
            font-size: 0.85rem;
            color: #a16207;
        }

        /* Upload form */
        .upload-form-wrap {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .form-label {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 8px;
            display: block;
        }
        .form-label .req {
            color: var(--orange);
            margin-left: 2px;
        }

        .dropzone {
            border: 2px dashed var(--border-dk);
            border-radius: 10px;
            padding: 32px 24px;
            text-align: center;
            cursor: pointer;
            transition:
                border-color 0.15s,
                background 0.15s;
            background: var(--cream);
        }
        @media (max-width: 640px) {
            .dropzone {
                padding: 24px 16px;
            }
        }
        .dropzone:hover,
        .dropzone.drag-over {
            border-color: var(--teal);
            border-style: solid;
            background: var(--teal-lt);
        }
        .dropzone-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: var(--ink-soft);
        }
        .dropzone-main {
            font-size: 0.88rem;
            color: var(--ink-soft);
        }
        .dropzone-main span {
            color: var(--teal);
            font-weight: 700;
            cursor: pointer;
        }
        .dropzone-sub {
            font-size: 0.75rem;
            color: #b5a595;
            margin-top: 4px;
        }
        .dropzone-filename {
            margin-top: 10px;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--teal);
            display: none;
            word-break: break-all;
        }

        .form-textarea {
            width: 100%;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 13px 18px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.92rem;
            color: var(--ink);
            outline: none;
            resize: vertical;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            box-shadow: 0 1px 4px rgba(26, 18, 9, 0.05);
        }
        @media (max-width: 640px) {
            .form-textarea {
                padding: 11px 14px;
                font-size: 1rem; /* prevent iOS zoom on focus */
            }
        }
        .form-textarea:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
        }
        .form-textarea::placeholder {
            color: #b5a595;
        }

        .btn-submit-revision {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            background: var(--teal);
            color: #fff;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 14px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.3);
            position: relative;
            overflow: hidden;
            /* allow text to wrap on very small screens */
            text-align: center;
            word-break: break-word;
        }
        @media (max-width: 480px) {
            .btn-submit-revision {
                font-size: 0.72rem;
                padding: 13px 16px;
                letter-spacing: 0.08em;
            }
        }
        .btn-submit-revision::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(201, 168, 76, 0.18) 0%,
                transparent 60%
            );
        }
        .btn-submit-revision:hover {
            background: var(--teal-dk);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(45, 129, 118, 0.36);
        }

        /* Empty state */
        .empty-wrap {
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 72px 24px;
            text-align: center;
        }
        @media (max-width: 640px) {
            .empty-wrap {
                padding: 48px 20px;
            }
        }
        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--cream);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            color: #c9b99a;
        }
        .empty-label {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }
        .empty-sub {
            font-size: 0.88rem;
            color: #b5a595;
            margin-top: 6px;
        }

        .field-error {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 5px;
        }

        /* Outer page padding on small screens */
        @media (max-width: 640px) {
            .rw.max-w-7xl {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
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
    </style>
@endpush

@section('content')
    <div class="rw max-w-7xl mx-auto px-1">
        {{-- Hero --}}
        <div class="hero-header fu">
            <div class="hero-row">
                <div>
                    <p class="hero-eyebrow">Manuscript Review</p>
                    <h1 class="hero-title">
                        Revision
                        <em>Requests</em>
                    </h1>
                    <p class="hero-sub">{{ $submission->title }}</p>
                </div>
                <div class="shrink-0">
                    <a
                        href="{{ route('submissions.show', $submission) }}"
                        class="back-link"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Back to Submission
                    </a>
                </div>
            </div>
        </div>

        @if ($submission->revisionRequests->count() === 0)
            <div class="empty-wrap fu1">
                <div class="empty-icon">
                    <svg
                        class="w-8 h-8"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                        />
                    </svg>
                </div>
                <p class="empty-label">No Revision Requests</p>
                <p class="empty-sub">
                    Your manuscript has not received any revision requests yet.
                </p>
            </div>
        @else
            @php
                $latestPending = $submission->revisionRequests
                    ->sortByDesc('requested_at')
                    ->firstWhere('revised_at', null);
            @endphp

            <div class="fu1">
                @foreach ($submission->revisionRequests->sortByDesc('requested_at') as $i => $revision)
                    @php
                        $requester = $revision->requestedBy;
                        $role = null;
                        if ($requester) {
                            if ($requester->hasRole('editor-in-chief')) {
                                $role = ['label' => 'Editor-in-Chief', 'cls' => 'chief'];
                            } elseif ($requester->hasRole('editor')) {
                                $role = ['label' => 'Editor', 'cls' => 'editor'];
                            } elseif ($requester->hasRole('reviewer')) {
                                $role = ['label' => 'Reviewer', 'cls' => 'reviewer'];
                            }
                        }
                        $animClass = ['fu', 'fu1', 'fu2', 'fu3'][$i] ?? 'fu3';
                    @endphp

                    <div
                        class="rev-card {{ $revision->isResolved() ? 'resolved' : '' }} {{ $animClass }}"
                    >
                        {{-- Card Header --}}
                        <div class="rev-card-header">
                            <div>
                                <p class="rev-type-label">
                                    {{ ucfirst($revision->revision_type) }}
                                    Revision Requested
                                </p>
                                <div class="rev-meta">
                                    <span class="rev-meta-text">
                                        Requested by
                                        <strong>
                                            {{ $requester?->name ?? 'Unknown' }}
                                        </strong>
                                    </span>
                                    @if ($role)
                                        <span
                                            class="role-chip {{ $role['cls'] }}"
                                        >
                                            {{ $role['label'] }}
                                        </span>
                                    @endif

                                    <span class="rev-dot">•</span>
                                    <span class="rev-date">
                                        {{ $revision->requested_at->format('F d, Y \a\t h:i A') }}
                                    </span>
                                </div>
                            </div>
                            <div class="rev-badge-group">
                                <span
                                    class="type-badge {{ $revision->revision_type === 'minor' ? 'minor' : 'major' }}"
                                >
                                    {{ $revision->revision_type === 'minor' ? '⚡ Minor' : '🔴 Major' }}
                                </span>
                                @if ($revision->isResolved())
                                    <span class="status-badge resolved">
                                        <span class="dot"></span>
                                        Resolved
                                    </span>
                                @else
                                    <span class="status-badge pending">
                                        <span class="dot"></span>
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="rev-card-body">
                            {{-- Reason --}}
                            <div class="reason-block">
                                <p class="reason-label">Reason for Revision</p>
                                <p class="reason-text">
                                    {{ $revision->reason }}
                                </p>
                            </div>

                            {{-- Resolved --}}
                            @if ($revision->isResolved())
                                <div class="resolved-block">
                                    <p class="resolved-title">
                                        <svg
                                            class="w-4 h-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        Revised Manuscript Submitted
                                    </p>
                                    <p class="resolved-date">
                                        Submitted on
                                        {{ $revision->revised_at->format('F d, Y \a\t h:i A') }}
                                    </p>
                                    @if ($revision->revision_notes)
                                        <div class="resolved-notes">
                                            <strong>Your Notes:</strong>
                                            {{ $revision->revision_notes }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                @if ($revision->id === $latestPending?->id)
                                    {{-- Upload Form --}}
                                    <form
                                        method="POST"
                                        action="{{ route('submissions.submit-revision', $submission) }}"
                                        enctype="multipart/form-data"
                                        class="upload-form-wrap"
                                    >
                                        @csrf
                                        <input
                                            type="hidden"
                                            name="revision_request_id"
                                            value="{{ $revision->id }}"
                                        />

                                        <div>
                                            <label class="form-label">
                                                Upload Revised Manuscript
                                                <span class="req">*</span>
                                            </label>
                                            <div
                                                class="dropzone"
                                                id="file-drop-{{ $revision->id }}"
                                                onclick="
                                                    document
                                                        .getElementById(
                                                            'file-input-{{ $revision->id }}',
                                                        )
                                                        .click()
                                                "
                                            >
                                                <input
                                                    type="file"
                                                    name="file"
                                                    required
                                                    accept=".pdf,.doc,.docx"
                                                    class="hidden"
                                                    id="file-input-{{ $revision->id }}"
                                                />
                                                <div class="dropzone-icon">
                                                    <svg
                                                        class="w-6 h-6"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="1.8"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                                        />
                                                    </svg>
                                                </div>
                                                <p class="dropzone-main">
                                                    <span>Click to upload</span>
                                                    or drag and drop
                                                </p>
                                                <p class="dropzone-sub">
                                                    PDF, DOC or DOCX — Max 10MB
                                                </p>
                                                <p
                                                    id="file-name-{{ $revision->id }}"
                                                    class="dropzone-filename"
                                                ></p>
                                            </div>
                                            @error('file')
                                                <p class="field-error">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                Revision Notes
                                                <span class="req">*</span>
                                            </label>
                                            <textarea
                                                name="revision_notes"
                                                required
                                                rows="4"
                                                class="form-textarea"
                                                placeholder="Describe the changes you made in this revision…"
                                            ></textarea>
                                            @error('revision_notes')
                                                <p class="field-error">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <button
                                            type="submit"
                                            class="btn-submit-revision"
                                        >
                                            <svg
                                                class="w-4 h-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2.5"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                                />
                                            </svg>
                                            Submit Revised Manuscript to
                                            {{ $requester?->name ?? 'Requester' }}
                                        </button>
                                    </form>
                                @else
                                    {{-- Older pending --}}
                                    <div class="awaiting-block">
                                        <div class="awaiting-icon">
                                            <svg
                                                class="w-5 h-5"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="awaiting-title">
                                                Awaiting Prior Revision
                                            </p>
                                            <p class="awaiting-desc">
                                                Submit the latest revision
                                                request first before addressing
                                                this one.
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        @foreach ($submission->revisionRequests->where('revised_at', null) as $revision)
            (function() {
                const dropZone  = document.getElementById('file-drop-{{ $revision->id }}');
                const fileInput = document.getElementById('file-input-{{ $revision->id }}');
                const fileName  = document.getElementById('file-name-{{ $revision->id }}');

                if (!dropZone) return;

                ['dragenter','dragover','dragleave','drop'].forEach(e => {
                    dropZone.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); });
                });
                ['dragenter','dragover'].forEach(e => {
                    dropZone.addEventListener(e, () => dropZone.classList.add('drag-over'));
                });
                ['dragleave','drop'].forEach(e => {
                    dropZone.addEventListener(e, () => dropZone.classList.remove('drag-over'));
                });
                dropZone.addEventListener('drop', e => {
                    fileInput.files = e.dataTransfer.files;
                    showName(e.dataTransfer.files[0]);
                });
                fileInput.addEventListener('change', () => {
                    if (fileInput.files.length) showName(fileInput.files[0]);
                });
                function showName(file) {
                    fileName.textContent = '📄 ' + file.name;
                    fileName.style.display = 'block';
                }
            })();
            @endforeach
    </script>
@endsection
