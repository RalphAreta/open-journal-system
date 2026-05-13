@extends('layouts.app')

@section('title', 'Submit Review')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet"
    />

    <style>
        .rv-root {
            font-family: 'DM Sans', sans-serif;
            background: #f7f6f3;
            min-height: 100vh;
            padding: 2.5rem 1rem;
        }
        .rv-inner {
            max-width: 780px;
            margin: 0 auto;
        }

        /* Breadcrumb */
        .rv-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
        }
        .rv-breadcrumb a {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #94928a;
            text-decoration: none;
            transition: color 0.15s;
        }
        .rv-breadcrumb a:hover {
            color: #b91c1c;
        }
        .rv-breadcrumb-sep {
            color: #c7c4bd;
            font-size: 11px;
        }
        .rv-breadcrumb-current {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #1c1917;
        }

        /* Page header */
        .rv-header {
            border-left: 3px solid #b91c1c;
            padding-left: 1.25rem;
            margin-bottom: 2rem;
        }
        .rv-header h1 {
            font-family: 'Lora', serif;
            font-size: 2rem;
            font-weight: 600;
            color: #1c1917;
            line-height: 1.2;
            margin: 0 0 0.4rem;
        }
        .rv-header p {
            font-size: 0.875rem;
            color: #78716c;
            margin: 0;
            font-weight: 300;
        }

        /* Cards */
        .rv-card {
            background: #fff;
            border: 1px solid #e7e5e0;
            border-radius: 6px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.25rem;
        }
        .rv-card-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #a09e97;
            margin: 0 0 1.25rem;
        }

        /* Submission info grid */
        .rv-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }
        @media (max-width: 560px) {
            .rv-meta-grid {
                grid-template-columns: 1fr;
            }
        }
        .rv-meta-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #a09e97;
            margin-bottom: 0.3rem;
        }
        .rv-meta-value {
            font-size: 0.9375rem;
            font-weight: 500;
            color: #1c1917;
        }
        .rv-tag {
            display: inline-block;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 0.2rem 0.75rem;
            border-radius: 2px;
        }
        .rv-abstract {
            font-size: 0.9rem;
            color: #57534e;
            line-height: 1.75;
            border-top: 1px solid #f0ede8;
            padding-top: 1.25rem;
        }

        /* File download */
        .rv-file-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .rv-file-icon {
            width: 40px;
            height: 40px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .rv-file-icon svg {
            width: 18px;
            height: 18px;
            color: #b91c1c;
        }
        .rv-file-info {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }
        .rv-file-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1c1917;
        }
        .rv-file-sub {
            font-size: 0.75rem;
            color: #a09e97;
        }
        .rv-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #b91c1c;
            text-decoration: none;
            letter-spacing: 0.03em;
            border: 1px solid #fecaca;
            padding: 0.45rem 1rem;
            border-radius: 4px;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .rv-download-btn:hover {
            background: #fef2f2;
            color: #991b1b;
        }
        .rv-download-btn svg {
            width: 14px;
            height: 14px;
        }

        /* Section heading inside form card */
        .rv-form-heading {
            font-family: 'Lora', serif;
            font-size: 1.375rem;
            font-weight: 600;
            color: #1c1917;
            margin: 0 0 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0ede8;
        }

        /* Form fields */
        .rv-field {
            margin-bottom: 1.75rem;
        }
        .rv-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #1c1917;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.625rem;
            letter-spacing: 0.01em;
        }
        .rv-required {
            color: #b91c1c;
        }
        .rv-optional {
            font-size: 0.75rem;
            font-weight: 400;
            color: #a09e97;
        }

        /* Tooltip */
        .rv-tip-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .rv-tip-btn {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #e7e5e0;
            border: none;
            cursor: pointer;
            font-size: 10px;
            font-weight: 800;
            color: #78716c;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            padding: 0;
            transition:
                background 0.15s,
                color 0.15s;
        }
        .rv-tip-btn:hover {
            background: #1c1917;
            color: #fff;
        }
        .rv-tip-box {
            position: absolute;
            left: 50%;
            bottom: calc(100% + 10px);
            transform: translateX(-50%);
            width: 280px;
            background: #1c1917;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 400;
            line-height: 1.6;
            border-radius: 6px;
            padding: 0.875rem 1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            z-index: 30;
        }
        .rv-tip-box::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 100%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: #1c1917;
        }
        .rv-tip-wrap:hover .rv-tip-box,
        .rv-tip-btn:focus + .rv-tip-box {
            opacity: 1;
        }
        .rv-tip-label {
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 0.35rem;
            display: block;
        }
        .rv-tip-amber {
            color: #fbbf24;
        }
        .rv-tip-blue {
            color: #60a5fa;
        }

        /* Inputs */
        .rv-select,
        .rv-textarea,
        .rv-number {
            width: 100%;
            border: 1px solid #e7e5e0;
            border-radius: 5px;
            background: #fff;
            color: #1c1917;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            outline: none;
            box-sizing: border-box;
        }
        .rv-select {
            padding: 0.6rem 1rem;
            height: 42px;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2378716c' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.875rem center;
            padding-right: 2.5rem;
        }
        .rv-textarea {
            padding: 0.75rem 1rem;
            resize: vertical;
            min-height: 140px;
            line-height: 1.65;
        }
        .rv-number {
            padding: 0.6rem 1rem;
            width: 100px;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
        }
        .rv-select:focus,
        .rv-textarea:focus,
        .rv-number:focus {
            border-color: #b91c1c;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.08);
        }
        .rv-select:hover,
        .rv-textarea:hover,
        .rv-number:hover {
            border-color: #c7c4bd;
        }
        .rv-error {
            color: #b91c1c;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.375rem;
        }

        /* Rating row */
        .rv-rating-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .rv-rating-suffix {
            font-size: 0.875rem;
            color: #a09e97;
            font-weight: 500;
        }
        .rv-rating-badge {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 0.875rem;
            border-radius: 3px;
            letter-spacing: 0.02em;
            transition: all 0.2s;
        }
        .rv-badge-1 {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        .rv-badge-2 {
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }
        .rv-badge-3 {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .rv-badge-4 {
            background: #fefce8;
            color: #854d0e;
            border: 1px solid #fef08a;
        }
        .rv-badge-5 {
            background: #f7fee7;
            color: #3f6212;
            border: 1px solid #d9f99d;
        }
        .rv-badge-6 {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .rv-badge-empty {
            background: transparent;
            color: transparent;
            border: 1px solid transparent;
        }

        /* Rating scale */
        .rv-scale {
            margin-top: 0;
        }
        .rv-scale-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #a09e97;
            margin-bottom: 0.875rem;
        }
        .rv-scale-bar {
            display: flex;
            border-radius: 4px;
            overflow: hidden;
            height: 8px;
            margin-bottom: 1.25rem;
        }
        .rv-scale-seg {
            flex: 1;
        }
        .rv-scale-seg-1 {
            background: #fca5a5;
        }
        .rv-scale-seg-2 {
            background: #fdba74;
        }
        .rv-scale-seg-3 {
            background: #fde68a;
        }
        .rv-scale-seg-4 {
            background: #fef08a;
        }
        .rv-scale-seg-5 {
            background: #bef264;
        }
        .rv-scale-seg-6 {
            background: #86efac;
        }
        .rv-scale-rows {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }
        @media (max-width: 480px) {
            .rv-scale-rows {
                grid-template-columns: 1fr;
            }
        }
        .rv-scale-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
        }
        .rv-scale-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .rv-scale-range {
            font-weight: 700;
            color: #1c1917;
            min-width: 40px;
        }
        .rv-scale-desc {
            color: #78716c;
        }

        /* Divider inside form */
        .rv-divider {
            border: none;
            border-top: 1px solid #f0ede8;
            margin: 2rem 0;
        }

        /* Actions */
        .rv-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f0ede8;
        }
        .rv-cancel {
            font-size: 0.875rem;
            font-weight: 500;
            color: #78716c;
            text-decoration: none;
            letter-spacing: 0.01em;
            transition: color 0.15s;
        }
        .rv-cancel:hover {
            color: #1c1917;
        }
        .rv-action-btns {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .rv-btn-draft {
            background: #fff;
            border: 1.5px solid #e7e5e0;
            color: #57534e;
            padding: 0.625rem 1.375rem;
            border-radius: 5px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.15s;
        }
        .rv-btn-draft:hover {
            border-color: #a09e97;
            color: #1c1917;
            background: #f7f6f3;
        }

        .rv-btn-submit {
            background: #1c1917;
            border: 1.5px solid #1c1917;
            color: #fff;
            padding: 0.625rem 1.625rem;
            border-radius: 5px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .rv-btn-submit:hover {
            background: #b91c1c;
            border-color: green;
        }
        .rv-btn-submit svg {
            width: 14px;
            height: 14px;
        }
    </style>

    <div class="rv-root">
        <div class="rv-inner">
            {{-- Breadcrumb --}}
            <nav class="rv-breadcrumb">
                <a href="{{ route('reviews.index') }}">My Reviews</a>
                <span class="rv-breadcrumb-sep">›</span>
                <span class="rv-breadcrumb-current">Submit Review</span>
            </nav>

            {{-- Page header --}}
            <div class="rv-header">
                <h1>Review Submission</h1>
                <p>{{ $submission->title }}</p>
            </div>

            {{-- Submission Info --}}
            <div class="rv-card">
                <p class="rv-card-title">Submission Details</p>
                <div class="rv-meta-grid">
                    <div>
                        <p class="rv-meta-label">Author</p>
                        <p class="rv-meta-value">
                            {{ $submission->author->name }}
                        </p>
                    </div>
                    <div>
                        <p class="rv-meta-label">Research Field</p>
                        <span class="rv-tag">
                            {{ $submission->research_field ?? 'Not specified' }}
                        </span>
                    </div>
                </div>
                <div class="rv-abstract">
                    <p class="rv-meta-label" style="margin-bottom: 0.5rem">
                        Abstract
                    </p>
                    {{ $submission->abstract }}
                </div>
            </div>

            {{-- Submission File --}}
            <div class="rv-card">
                <p class="rv-card-title">Submission File</p>

                @if ($submission->file_path)
                  <div class="rv-file-row">
                        <div class="rv-file-info">
                            <div class="rv-file-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="rv-file-name">{{ $submission->file_name }}</p>
                                <p class="rv-file-sub">DOC · DOCX</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <button
                                type="button"
                                onclick="openFileModal()"
                                class="rv-download-btn"
                                style="background:none;border-color:#fecaca;cursor:pointer;"
                            >
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View File
                            </button>
                            <a href="{{ route('submissions.download', ['submission' => $submission]) }}"
                                class="rv-download-btn">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>

                    {{-- File Viewer Modal — OUTSIDE rv-file-row --}}
                <div
    id="rv-file-modal"
    style="display:none;position:fixed;inset:0;z-index:999;align-items:center;justify-content:center;padding:16px;background:rgba(28,25,23,0.75);backdrop-filter:blur(4px);"
    onclick="if(event.target===this) this.style.display='none'"
>
                        <div style="width:min(900px,100%);height:min(88vh,860px);background:white;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.3);display:flex;flex-direction:column;overflow:hidden;">
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #e7e5e0;background:#f7f6f3;flex-shrink:0;">
                                <div style="display:flex;align-items:center;gap:12px;min-width:0;">
                                    <div style="width:32px;height:32px;border-radius:6px;background:#fef2f2;border:1px solid #fecaca;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="16" height="16" fill="none" stroke="#b91c1c" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div style="min-width:0;">
                                        <p style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.14em;color:#a09e97;margin:0;">Manuscript File</p>
                                        <p style="font-size:13px;font-weight:600;color:#1c1917;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $submission->file_name }}</p>
                                    </div>
                                </div>
                                <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;margin-left:12px;">
                                    <a href="{{ route('submissions.download', ['submission' => $submission]) }}"
                                        style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:5px;background:#f0fdf4;border:1px solid #bbf7d0;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#166534;text-decoration:none;">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download
                                    </a>
                                    <button type="button"
                                        onclick="document.getElementById('rv-file-modal').style.display='none'"                                        style="width:32px;height:32px;border-radius:6px;border:none;background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#a09e97;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div style="flex:1;overflow:hidden;background:#f7f6f3;position:relative;">
                              <iframe
    data-src="{{ route('reviewer.preview-file', $submission) }}#toolbar=1&navpanes=0&scrollbar=1&view=FitH"
    style="width:100%;height:100%;border:0;"
    title="Manuscript Preview"
    id="rv-preview-iframe"
></iframe>
                                <div id="rv-viewer-loading"
                                    style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f7f6f3;transition:opacity 0.4s;pointer-events:none;">
                                    <div style="width:40px;height:40px;border-radius:8px;background:white;border:1px solid #e7e5e0;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                                        <svg style="width:20px;height:20px;animation:rv-spin 1s linear infinite;" fill="none" viewBox="0 0 24 24">
                                            <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="#b91c1c" stroke-width="4"/>
                                            <path style="opacity:.75" fill="#b91c1c" d="M4 12a8 8 0 018-8v8H4z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:11px;font-weight:700;color:#a09e97;text-transform:uppercase;letter-spacing:.1em;margin:0;">Converting document…</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>@keyframes rv-spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }</style>

                  @else
        <p style="font-size:0.875rem;color:#a09e97;font-style:italic;margin:0;">
            No file submitted.
        </p>
    @endif
</div>

            {{-- Review Form --}}
            <div class="rv-card">
                <h2 class="rv-form-heading">Your Review</h2>

                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <input
                        type="hidden"
                        name="review_assignment_id"
                        value="{{ $assignment->id }}"
                    />

                    {{-- Recommendation --}}
                    <div class="rv-field">
                        <label class="rv-label">
                            Recommendation
                            <span class="rv-required">*</span>
                        </label>
                        <select name="recommendation" class="rv-select">
                            <option value="">
                                — Select a recommendation —
                            </option>
                            @foreach (\App\Models\Review::recommendationOptions() as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old('recommendation', $existingReview?->recommendation) === $value ? 'selected' : '' }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('recommendation')
                            <p class="rv-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="rv-divider" />

                    {{-- Comments for Author --}}
                    <div class="rv-field">
                        <label for="comments_for_author" class="rv-label">
                            Review Comments
                            <span class="rv-required">*</span>
                            <span class="rv-tip-wrap">
                                <button
                                    type="button"
                                    class="rv-tip-btn"
                                    aria-label="Hint"
                                >
                                    ?
                                </button>
                                <span class="rv-tip-box">
                                    <span class="rv-tip-label rv-tip-amber">
                                        ⚠ Reminder
                                    </span>
                                    Do not state your final recommendation
                                    directly in the review comments. Focus on
                                    constructive, actionable feedback for the
                                    author.
                                </span>
                            </span>
                        </label>
                        <textarea
                            id="comments_for_author"
                            name="comments_for_author"
                            class="rv-textarea"
                            required
                            placeholder="Provide detailed, constructive feedback to help the author improve their work…"
                        >
{{ old('comments_for_author', $existingReview?->comments_for_author) }}</textarea
                        >
                        @error('comments_for_author')
                            <p class="rv-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Comments for Editor --}}
                    <div class="rv-field">
                        <label for="comments_for_editor" class="rv-label">
                            Comments for Editor
                            <span class="rv-required">*</span>
                            <span class="rv-tip-wrap">
                                <button
                                    type="button"
                                    class="rv-tip-btn"
                                    aria-label="Hint"
                                >
                                    ?
                                </button>
                                <span class="rv-tip-box">
                                    <span class="rv-tip-label rv-tip-blue">
                                        🔒 Confidential
                                    </span>
                                    Visible to the editor only. Include ethical
                                    concerns, conflicts of interest, or
                                    observations about research integrity.
                                </span>
                            </span>
                        </label>
                        <textarea
                            id="comments_for_editor"
                            name="comments_for_editor"
                            class="rv-textarea"
                            required
                            placeholder="Share confidential notes, ethical concerns, or integrity observations with the editor…"
                        >
{{ old('comments_for_editor', $existingReview?->comments_for_editor) }}</textarea
                        >
                        @error('comments_for_editor')
                            <p class="rv-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="rv-divider" />

                    {{-- Rating Scale Reference --}}
                    <div class="rv-scale rv-field">
                        <p class="rv-scale-title">Rating Scale Reference</p>
                        <div class="rv-scale-bar">
                            <div
                                class="rv-scale-seg rv-scale-seg-1"
                                style="flex: 20"
                            ></div>
                            <div
                                class="rv-scale-seg rv-scale-seg-2"
                                style="flex: 20"
                            ></div>
                            <div
                                class="rv-scale-seg rv-scale-seg-3"
                                style="flex: 15"
                            ></div>
                            <div
                                class="rv-scale-seg rv-scale-seg-4"
                                style="flex: 15"
                            ></div>
                            <div
                                class="rv-scale-seg rv-scale-seg-5"
                                style="flex: 15"
                            ></div>
                            <div
                                class="rv-scale-seg rv-scale-seg-6"
                                style="flex: 15"
                            ></div>
                        </div>
                        <div class="rv-scale-rows">
                            <div class="rv-scale-row">
                                <span
                                    class="rv-scale-dot"
                                    style="background: #fca5a5"
                                ></span>
                                <span class="rv-scale-range">1–20</span>
                                <span class="rv-scale-desc">
                                    Critically deficient
                                </span>
                            </div>
                            <div class="rv-scale-row">
                                <span
                                    class="rv-scale-dot"
                                    style="background: #fdba74"
                                ></span>
                                <span class="rv-scale-range">21–40</span>
                                <span class="rv-scale-desc">
                                    Below standard
                                </span>
                            </div>
                            <div class="rv-scale-row">
                                <span
                                    class="rv-scale-dot"
                                    style="background: #fde68a"
                                ></span>
                                <span class="rv-scale-range">41–55</span>
                                <span class="rv-scale-desc">
                                    Acceptable but limited
                                </span>
                            </div>
                            <div class="rv-scale-row">
                                <span
                                    class="rv-scale-dot"
                                    style="background: #fef08a"
                                ></span>
                                <span class="rv-scale-range">56–70</span>
                                <span class="rv-scale-desc">
                                    Competent work
                                </span>
                            </div>
                            <div class="rv-scale-row">
                                <span
                                    class="rv-scale-dot"
                                    style="background: #bef264"
                                ></span>
                                <span class="rv-scale-range">71–85</span>
                                <span class="rv-scale-desc">
                                    Good to excellent
                                </span>
                            </div>
                            <div class="rv-scale-row">
                                <span
                                    class="rv-scale-dot"
                                    style="background: #86efac"
                                ></span>
                                <span class="rv-scale-range">86–100</span>
                                <span class="rv-scale-desc">Outstanding</span>
                            </div>
                        </div>
                    </div>

                    {{-- Rating --}}
                    <div class="rv-field">
                        <label for="rating" class="rv-label">
                            Rating
                            <span class="rv-optional">(1 – 100, optional)</span>
                        </label>
                        <div class="rv-rating-row">
                            <input
                                id="rating"
                                type="number"
                                name="rating"
                                min="1"
                                max="100"
                                value="{{ old('rating', $existingReview?->rating) }}"
                                class="rv-number"
                                placeholder="—"
                            />
                            <span class="rv-rating-suffix">/ 100</span>
                            <span
                                id="ratingBadge"
                                class="rv-rating-badge rv-badge-empty"
                            ></span>
                        </div>
                        @error('rating')
                            <p class="rv-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="rv-actions">
                        <a
                            href="{{ route('reviews.index') }}"
                            class="rv-cancel"
                        >
                            Cancel
                        </a>
                        <div class="rv-action-btns">
                            <button
                                type="submit"
                                name="action"
                                value="save_draft"
                                class="rv-btn-draft"
                            >
                                Save Draft
                            </button>
                            <button
                                type="submit"
                                name="action"
                                value="submit"
                                class="rv-btn-submit"
                            >
                                <svg
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                Submit Review
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('rating');
            const badge = document.getElementById('ratingBadge');

            const bands = [
                {
                    min: 1,
                    max: 20,
                    label: 'Critically deficient',
                    cls: 'rv-badge-1',
                },
                {
                    min: 21,
                    max: 40,
                    label: 'Below standard',
                    cls: 'rv-badge-2',
                },
                {
                    min: 41,
                    max: 55,
                    label: 'Acceptable but limited',
                    cls: 'rv-badge-3',
                },
                {
                    min: 56,
                    max: 70,
                    label: 'Competent work',
                    cls: 'rv-badge-4',
                },
                {
                    min: 71,
                    max: 85,
                    label: 'Good to excellent',
                    cls: 'rv-badge-5',
                },
                { min: 86, max: 100, label: 'Outstanding', cls: 'rv-badge-6' },
            ];

            function update(val) {
                const n = parseInt(val, 10);
                badge.className = 'rv-rating-badge rv-badge-empty';
                badge.textContent = '';
                if (!val || isNaN(n) || n < 1 || n > 100) return;
                const band = bands.find((b) => n >= b.min && n <= b.max);
                if (band) {
                    badge.className = 'rv-rating-badge ' + band.cls;
                    badge.textContent = band.label;
                }
            }

            if (input) {
                input.addEventListener('input', () => update(input.value));
                update(input.value);
            }
        });
       function openFileModal() {
    const modal = document.getElementById('rv-file-modal');
    modal.style.display = 'flex';

    // Lazy-load iframe only on first open
    const iframe = document.getElementById('rv-preview-iframe');
    if (iframe && iframe.dataset.src && !iframe.src) {
        iframe.src = iframe.dataset.src;
        iframe.addEventListener('load', () => {
            const loading = document.getElementById('rv-viewer-loading');
            if (loading) loading.style.opacity = '0';
        });
    }
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modal = document.getElementById('rv-file-modal');
        if (modal) modal.style.display = 'none';
    }
});
    </script>
@endsection
