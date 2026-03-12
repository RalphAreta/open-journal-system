@extends('layouts.app')

@section('title', 'Review Layout')

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

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            font-size: 1.8rem;
            font-weight: 700;
            font-style: italic;
            color: var(--ink);
            line-height: 1.3;
        }

        /* Cards */
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

        /* Meta */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
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

        /* Author row */
        .author-row {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .author-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--teal-lt);
            border: 2px solid rgba(45, 129, 118, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--teal-dk);
            flex-shrink: 0;
            text-transform: uppercase;
        }
        .author-name {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
        }
        .author-email {
            font-size: 0.8rem;
            color: var(--ink-soft);
            margin-top: 2px;
        }

        /* Layout file card */
        .file-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            background: var(--parchment);
            border: 1.5px solid var(--border-dk);
            border-radius: 10px;
            gap: 16px;
        }
        .file-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: #fff;
            border: 1px solid var(--border-dk);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .file-name {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--ink);
            word-break: break-all;
        }
        .file-tag {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--teal-dk);
            margin-top: 3px;
        }

        /* Notes box */
        .notes-box {
            background: #fffdf9;
            border: 1px solid rgba(201, 168, 76, 0.35);
            border-left: 4px solid var(--gold);
            border-radius: 8px;
            padding: 16px 20px;
        }
        .notes-label {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold-dk);
            margin-bottom: 8px;
        }
        .notes-text {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.92rem;
            font-style: italic;
            color: var(--ink-mid);
            line-height: 1.7;
        }

        /* No file state */
        .no-file {
            text-align: center;
            padding: 48px 24px;
            background: var(--parchment);
            border-radius: 10px;
            border: 1.5px dashed var(--border-dk);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 11px 24px;
            border-radius: 8px;
            text-decoration: none;
            border: 1.5px solid;
            transition: all 0.15s;
            cursor: pointer;
        }
        .btn-teal {
            background: var(--teal);
            color: #fff;
            border-color: var(--teal);
        }
        .btn-teal:hover {
            background: var(--teal-dk);
            border-color: var(--teal-dk);
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.3);
        }
        .btn-outline {
            background: #fff;
            color: var(--teal);
            border-color: rgba(45, 129, 118, 0.4);
        }
        .btn-outline:hover {
            background: var(--teal-lt);
        }
        .btn-gold {
            background: var(--gold);
            color: #fff;
            border-color: var(--gold);
        }
        .btn-gold:hover {
            background: var(--gold-dk);
            border-color: var(--gold-dk);
            box-shadow: 0 4px 14px rgba(201, 168, 76, 0.3);
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
        .sbadge.layout-review {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.layout-review .dot {
            background: var(--teal);
        }
        .sbadge.layout-editing {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.layout-editing .dot {
            background: var(--gold);
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

        /* Approve section */
        .approve-section {
            background: #f0fdf8;
            border: 1.5px solid rgba(45, 129, 118, 0.3);
            border-radius: 14px;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .approve-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--teal-dk);
            margin-bottom: 4px;
        }
        .approve-desc {
            font-size: 0.85rem;
            color: var(--ink-soft);
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-4xl mx-auto px-2 py-6">
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

        {{-- Header --}}
        <div class="page-header fu">
            <p class="eyebrow">Layout Review</p>
            <h1 class="ms-title">{{ $submission->title }}</h1>
            <div class="flex flex-wrap items-center gap-3 mt-3">
                <span
                    style="
                        font-family: 'Source Sans 3', sans-serif;
                        font-size: 0.75rem;
                        font-weight: 700;
                        color: var(--teal);
                        background: rgba(45, 129, 118, 0.07);
                        border: 1px solid rgba(45, 129, 118, 0.22);
                        padding: 3px 12px;
                        border-radius: 4px;
                    "
                >
                    REF #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                </span>
                @php
                    $sc =
                        $submission->status === 'layout_review'
                            ? 'layout-review'
                            : 'layout-editing';
                    $sl =
                        $submission->status === 'layout_review'
                            ? 'Layout Review'
                            : 'Layout Editing';
                @endphp

                <span class="sbadge {{ $sc }}">
                    <span class="dot"></span>
                    {{ $sl }}
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
                            {{ $submission->author->name ?? 'Unknown' }}
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
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
                <span class="card-header-title">Manuscript Information</span>
            </div>
            <div class="card-body">
                <div class="meta-grid">
                    <div>
                        <p class="meta-label">Research Field</p>
                        <p class="meta-value">
                            {{ $submission->research_field ?? '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="meta-label">Assigned Editor</p>
                        <p class="meta-value">
                            {{ $submission->assignedEditor->name ?? '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="meta-label">Forwarded to Layout</p>
                        <p class="meta-value">
                            {{
                                $submission->forwarded_to_layout_at
                                    ? \Carbon\Carbon::parse($submission->forwarded_to_layout_at)->format('M j, Y')
                                    : '—'
                            }}
                        </p>
                    </div>
                    <div>
                        <p class="meta-label">Layout Editor</p>
                        <p class="meta-value">
                            {{ $layoutAssignment?->layoutEditor->name ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Layout File --}}
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
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
                <span class="card-header-title">
                    Layout File from Layout Editor
                </span>
            </div>
            <div class="card-body">
                @if ($layoutAssignment && $layoutAssignment->layout_file_path)
                    {{-- File download --}}
                    <div class="file-card mb-5">
                        <div class="file-icon">
                            <svg
                                width="22"
                                height="22"
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
                                {{ $layoutAssignment->layout_file_name ?? 'layout-file.pdf' }}
                            </p>
                            <p class="file-tag">
                                ✦ Completed
                                {{ $layoutAssignment->completed_at?->format('M j, Y') ?? '' }}
                                · by
                                {{ $layoutAssignment->layoutEditor->name ?? '—' }}
                            </p>
                        </div>
                        <a
                            href="{{ route('managing-editor.layout.download', $submission) }}"
                            class="btn btn-outline"
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
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                />
                            </svg>
                            Download
                        </a>
                    </div>

                    {{-- Layout editor notes --}}
                    @if ($layoutAssignment->notes)
                        <div class="notes-box">
                            <p class="notes-label">📝 Layout Editor's Notes</p>
                            <p class="notes-text">
                                {{ $layoutAssignment->notes }}
                            </p>
                        </div>
                    @endif

                    {{-- Author feedback/revision notes --}}
                    @if ($layoutAssignment->author_feedback)
                        <div style="background: #fffbf0; border: 1px solid rgba(217, 119, 6, 0.35); border-left: 4px solid #d97706; border-radius: 8px; padding: 16px 20px; margin-top: 12px;">
                            <p style="font-size: 0.68rem; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; color: #92400e; margin-bottom: 8px;">💬 Author's Revision Feedback</p>
                            <p style="font-family: 'Libre Baskerville', serif; font-size: 0.92rem; color: #78350f; line-height: 1.7; white-space: pre-wrap;">{{ $layoutAssignment->author_feedback }}</p>
                            <p style="font-size: 0.75rem; color: #b45309; margin-top: 8px;">📅 Submitted: {{ $layoutAssignment->author_feedback_at?->format('M d, Y \a\t g:i A') ?? 'N/A' }}</p>
                        </div>
                    @endif
                @else
                    <div class="no-file">
                        <svg
                            width="40"
                            height="40"
                            fill="none"
                            stroke="#c9b99a"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                            style="margin: 0 auto 12px"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        <p
                            style="
                                font-size: 0.82rem;
                                font-weight: 700;
                                color: #c9b99a;
                                letter-spacing: 0.1em;
                                text-transform: uppercase;
                            "
                        >
                            Layout file not yet uploaded
                        </p>
                        <p
                            style="
                                font-size: 0.82rem;
                                color: #b5a595;
                                margin-top: 6px;
                            "
                        >
                            The layout editor hasn't uploaded the file yet.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Approve & Forward to Editor --}}
        @if ($layoutAssignment && $layoutAssignment->layout_file_path && $submission->status === \App\Models\Submission::STATUS_LAYOUT_REVIEW)
            <div class="approve-section fu3">
                <div>
                    <p class="approve-title">
                        ✅ Approve & Forward to Layout Editor
                    </p>
                    <p class="approve-desc">
                        After reviewing the layout file, approve it to notify
                        the assigned editor for final review before sending to
                        the author.
                    </p>
                </div>
                <form
                    method="POST"
                    action="{{ route('managing-editor.layout.approve', $submission) }}"
                >
                    @csrf
                    <button type="submit" class="btn btn-teal">
                        <svg
                            width="16"
                            height="16"
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
                        Approve Layout & Notify Layout Editor
                    </button>
                </form>
            </div>
        @elseif ($submission->status !== \App\Models\Submission::STATUS_LAYOUT_REVIEW)
            <div
                style="
                    background: var(--parchment);
                    border: 1px solid var(--border);
                    border-radius: 10px;
                    padding: 18px 24px;
                    text-align: center;
                "
                class="fu3"
            >
                <p style="font-size: 0.85rem; color: var(--ink-soft)">
                    ⏳ Waiting for layout editor to upload the file…
                </p>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Done</span>',
                        html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#2d8176',
                        customClass: { popup:'rounded-2xl', confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest' },
                        buttonsStyling: false,
                    });
                @endif
                @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Oops!</span>',
            html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('error') }}</p>',
            confirmButtonText: 'Close',
            confirmButtonColor: '#c9a84c',
            customClass: { popup:'rounded-2xl', confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest' },
            buttonsStyling: false,
        });
        @endif

        @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Note</span>',
            html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('info') }}</p>',
            confirmButtonText: 'Got it',
            confirmButtonColor: '#2d8176',
            customClass: { popup:'rounded-2xl', confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest' },
            buttonsStyling: false,
        });
        @endif

        @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Warning</span>',
            html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('warning') }}</p>',
            confirmButtonText: 'Understood',
            confirmButtonColor: '#c9a84c',
            customClass: { popup:'rounded-2xl', confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest' },
            buttonsStyling: false,
        });
        @endif
    </script>
@endpush
