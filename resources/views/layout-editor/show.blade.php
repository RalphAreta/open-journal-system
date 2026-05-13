@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f9f7f2]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
            <!-- Header -->
            <div class="mb-6 sm:mb-8">
                <a
                    href="{{ route('layout-editor.dashboard') }}"
                    class="text-[#2D8176] hover:text-[#1f5d54] font-bold mb-4 inline-block text-sm sm:text-base"
                >
                    ← Back to Dashboard
                </a>
                <h1
                    class="font-libre text-2xl sm:text-3xl font-bold text-[#2D8176] mb-2 leading-tight"
                >
                    {{ $assignment->submission->title }}
                </h1>
                <p class="text-[#6a7890] text-sm sm:text-base">
                    Layout editing assignment for {{ $paper['author'] }}
                </p>
            </div>

            <!-- Paper Details + Status -->
            <div
                class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8"
            >
                <!-- Paper Details Card -->
                <div
                    class="sm:col-span-2 bg-white rounded-xl p-5 sm:p-6 border border-[#e0d8cc]"
                >
                    <h2 class="font-bold text-lg text-[#2D8176] mb-4">
                        Paper Details
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Title
                            </p>
                            <p
                                class="font-bold text-[#1a1a1a] text-sm sm:text-base"
                            >
                                {{ $paper['title'] }}
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Author
                            </p>
                            <p
                                class="font-bold text-[#1a1a1a] text-sm sm:text-base"
                            >
                                {{ $paper['author'] }}
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Research Field
                            </p>
                            <p
                                class="font-bold text-[#1a1a1a] text-sm sm:text-base"
                            >
                                {{ $paper['category'] }}
                            </p>
                        </div>
                        <div class="border-t border-[#e0d8cc] pt-4">
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-2"
                            >
                                Abstract
                            </p>
                            <p class="text-sm text-[#4a5568] leading-relaxed">
                                {{ $paper['abstract'] }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div
                    class="bg-white rounded-xl p-5 sm:p-6 border border-[#e0d8cc]"
                >
                    <h2 class="font-bold text-lg text-[#2D8176] mb-4">
                        Assignment Status
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Status
                            </p>
                            <span
                                class="inline-block px-3 py-1 bg-[#c9a84c]/10 text-[#c9a84c] font-bold rounded-full text-sm"
                            >
                                {{ ucfirst($assignment->status) }}
                            </span>
                        </div>
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Assigned
                            </p>
                            <p
                                class="font-bold text-[#2D8176] text-sm sm:text-base"
                            >
                                {{ $assignment->assigned_at->format('M d, Y') }}
                            </p>
                            <p class="text-xs text-[#6a7890]">
                                {{ $assignment->assigned_at->diffForHumans() }}
                            </p>
                        </div>
                        @if ($assignment->started_at)
                            <div>
                                <p
                                    class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                                >
                                    Started
                                </p>
                                <p
                                    class="font-bold text-[#2D8176] text-sm sm:text-base"
                                >
                                    {{ $assignment->started_at->format('M d, Y') }}
                                </p>
                            </div>
                        @endif

                        @if ($assignment->completed_at)
                            <div>
                                <p
                                    class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                                >
                                    Completed
                                </p>
                                <p
                                    class="font-bold text-[#2D8176] text-sm sm:text-base"
                                >
                                    {{ $assignment->completed_at->format('M d, Y') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- File Management Section -->
            <div
                class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8"
            >
                <!-- Original File Card -->
                <div
                    class="bg-white rounded-xl p-5 sm:p-6 border border-[#e0d8cc]"
                >
                    <h2 class="font-bold text-lg text-[#2D8176] mb-4">
                        📥 Original File
                    </h2>
                    <p class="text-sm text-[#6a7890] mb-4">
                        Download the file from the editor and make layout
                        adjustments.
                    </p>
                    <div class="flex flex-col gap-2">
                        <button
                            type="button"
                            onclick="openLeFileModal()"
                            class="block w-full px-4 py-3 bg-[#2D8176] text-white rounded-lg font-bold text-center hover:bg-[#1f5d54] transition-colors text-sm sm:text-base"
                        >
                            👁 View Original File
                        </button>
                        <a
                            href="{{ route('layout-editor.download', $assignment->id) }}"
                            class="block w-full px-4 py-3 bg-white text-[#2D8176] rounded-lg font-bold text-center border border-[#2D8176] hover:bg-[#f0fdf4] transition-colors text-sm sm:text-base"
                        >
                            ↓ Download Original File
                        </a>
                    </div>
                </div>

                <!-- Upload Layout Card -->
                <div
                    class="bg-white rounded-xl p-5 sm:p-6 border border-[#e0d8cc]"
                >
                    <h2 class="font-bold text-lg text-[#2D8176] mb-4">
                        📤 Upload Layout Version
                    </h2>
                    <p class="text-sm text-[#6a7890] mb-4">
                        @if ($assignment->status === 'completed')
                            ✓ Layout file uploaded successfully
                        @else
                                Upload your edited layout file after making
                                adjustments.
                        @endif
                    </p>

                    @if ($assignment->status !== 'completed')
                        <form
                            action="{{ route('layout-editor.upload', $assignment->id) }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div class="mb-4">
                                <label
                                    class="block text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-2"
                                >
                                    Upload File
                                </label>
                                <input
                                    type="file"
                                    name="file"
                                    accept=".pdf"
                                    required
                                    class="w-full px-3 py-2 border border-[#e0d8cc] rounded-lg focus:border-[#2D8176] focus:outline-none text-sm"
                                />
                                @error('file')
                                    <p class="text-red-600 text-xs mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <p class="text-xs text-[#6a7890] mt-1">
                                    Accepted: PDF only (Max 50MB)
                                </p>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-2"
                                >
                                    Notes (Optional)
                                </label>
                                <textarea
                                    name="notes"
                                    rows="4"
                                    placeholder="Add any notes about the layout adjustments..."
                                    class="w-full px-3 py-2 border border-[#e0d8cc] rounded-lg focus:border-[#2D8176] focus:outline-none text-sm"
                                ></textarea>
                                @error('notes')
                                    <p class="text-red-600 text-xs mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="w-full px-4 py-3 bg-[#c9a84c] text-white rounded-lg font-bold hover:bg-[#b89940] transition-colors text-sm sm:text-base"
                            >
                                Upload Layout File
                            </button>
                        </form>
                    @else
                        <div
                            class="p-4 bg-green-50 border border-green-200 rounded-lg"
                        >
                            <p class="text-sm text-green-700 font-bold mb-2">
                                ✓ Layout file uploaded on
                                {{ $assignment->completed_at->format('M d, Y') }}
                            </p>
                            <a
                                href="{{ route('layout-editor.download-layout', $assignment->id) }}"
                                class="text-green-600 hover:text-green-700 font-bold text-sm"
                            >
                                Download your layout file
                            </a>
                        </div>

                        @if ($assignment->notes)
                            <div
                                class="mt-4 p-4 bg-[#f9f7f2] border border-[#e0d8cc] rounded-lg"
                            >
                                <p
                                    class="text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-2"
                                >
                                    Your Notes
                                </p>
                                <p class="text-sm text-[#4a5568]">
                                    {{ $assignment->notes }}
                                </p>
                            </div>
                        @endif

                        <!-- Author Feedback Section -->
                        @if ($assignment->author_feedback)
                            <div
                                class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg"
                            >
                                <p
                                    class="text-xs text-amber-900 uppercase tracking-wider font-bold mb-2"
                                >
                                    📋 Author's Revision Feedback
                                </p>
                                <p
                                    class="text-sm text-amber-900 whitespace-pre-line"
                                >
                                    {{ $assignment->author_feedback }}
                                </p>
                                <p class="text-xs text-amber-700 mt-2">
                                    Submitted:
                                    {{ $assignment->author_feedback_at?->format('M d, Y \a\t g:i A') ?? 'N/A' }}
                                </p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Author's Revision Notes Section -->
            @php
                $latestRevision = $submission
                    ->revisionRequests()
                    ->whereNotNull('revision_notes')
                    ->orderBy('created_at', 'desc')
                    ->first();
            @endphp

            @if ($latestRevision && $latestRevision->revision_notes)
                <div
                    class="bg-blue-50 rounded-xl p-5 sm:p-6 border border-blue-200 mb-6 sm:mb-8"
                >
                    <div class="flex items-start gap-3">
                        <span class="text-2xl flex-shrink-0">💬</span>
                        <div class="flex-1 min-w-0">
                            <h2 class="font-bold text-lg text-blue-900 mb-2">
                                Author's Revision Notes
                            </h2>
                            <p class="text-sm text-blue-700 mb-4">
                                The author submitted the following notes when
                                revising their manuscript:
                            </p>
                            <div
                                class="bg-white rounded-lg p-4 border-l-4 border-blue-400"
                            >
                                <p
                                    class="text-sm text-[#4a5568] whitespace-pre-wrap break-words"
                                >
                                    {{ $latestRevision->revision_notes }}
                                </p>
                            </div>
                            @if ($latestRevision->revised_at)
                                <p class="text-xs text-blue-600 mt-3">
                                    📅 Submitted:
                                    {{ $latestRevision->revised_at->format('M d, Y \a\t g:i A') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Workflow Info -->
            <div
                class="bg-[#2D8176]/5 rounded-xl p-5 sm:p-6 border border-[#2D8176]/20"
            >
                <h3 class="font-bold text-[#2D8176] mb-3 text-sm sm:text-base">
                    📋 Layout Editing Workflow
                </h3>
                <ol class="space-y-2 text-sm text-[#4a5568]">
                    <li>
                        <strong>1. Review:</strong>
                        Download and review the file sent by the editor
                    </li>
                    <li>
                        <strong>2. Edit:</strong>
                        Make any necessary layout adjustments
                    </li>
                    <li>
                        <strong>3. Upload:</strong>
                        Upload your edited version with notes (if needed)
                    </li>
                    <li>
                        <strong>4. Review:</strong>
                        Editor will review your layout and send to author for
                        final approval
                    </li>
                    <li>
                        <strong>5. Author:</strong>
                        Author confirms and the paper is published
                    </li>
                </ol>
            </div>
        </div>
    </div>
    {{-- File Viewer Modal --}}
    <div
        id="le-file-modal"
        style="
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
        "
        onclick="if (event.target === this) this.style.display = 'none';"
    >
        <div
            style="
                width: min(900px, 100%);
                height: min(88vh, 860px);
                background: white;
                border-radius: 14px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                display: flex;
                flex-direction: column;
                overflow: hidden;
            "
        >
            {{-- Header --}}
            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 14px 20px;
                    border-bottom: 1px solid #e0d8cc;
                    background: #f9f7f2;
                    flex-shrink: 0;
                "
            >
                <div
                    style="
                        display: flex;
                        align-items: center;
                        gap: 12px;
                        min-width: 0;
                    "
                >
                    <div
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 8px;
                            background: #e8f4f2;
                            border: 1px solid rgba(45, 129, 118, 0.25);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            flex-shrink: 0;
                        "
                    >
                        <svg
                            width="16"
                            height="16"
                            fill="none"
                            stroke="#2D8176"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                    </div>
                    <div style="min-width: 0">
                        <p
                            style="
                                font-size: 9px;
                                font-weight: 700;
                                text-transform: uppercase;
                                letter-spacing: 0.14em;
                                color: #6a7890;
                                margin: 0;
                            "
                        >
                            Original Manuscript
                        </p>
                        <p
                            style="
                                font-size: 13px;
                                font-weight: 700;
                                color: #1a1a1a;
                                margin: 0;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;
                            "
                        >
                            {{ $assignment->submission->file_name ?? $assignment->submission->title }}
                        </p>
                    </div>
                </div>
                <div
                    style="
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        flex-shrink: 0;
                        margin-left: 12px;
                    "
                >
                    <a
                        href="{{ route('layout-editor.download', $assignment->id) }}"
                        style="
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            padding: 6px 12px;
                            border-radius: 6px;
                            background: #f0fdf4;
                            border: 1px solid #bbf7d0;
                            font-size: 10px;
                            font-weight: 700;
                            text-transform: uppercase;
                            letter-spacing: 0.08em;
                            color: #166534;
                            text-decoration: none;
                        "
                    >
                        <svg
                            width="12"
                            height="12"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2.5"
                        >
                            <path
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                            />
                        </svg>
                        Download
                    </a>
                    <button
                        type="button"
                        onclick="
                            document.getElementById(
                                'le-file-modal',
                            ).style.display = 'none'
                        "
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 6px;
                            border: none;
                            background: none;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: #6a7890;
                        "
                    >
                        <svg
                            width="16"
                            height="16"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2.5"
                        >
                            <path d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Viewer --}}
            <div
                style="
                    flex: 1;
                    overflow: hidden;
                    background: #f9f7f2;
                    position: relative;
                "
            >
                <iframe
                    id="le-preview-iframe"
                    data-src="{{ route('editor.preview-file', $assignment->submission) }}#toolbar=1&navpanes=0&scrollbar=1&view=FitH"
                    style="width: 100%; height: 100%; border: 0"
                    title="Manuscript Preview"
                ></iframe>
                <div
                    id="le-viewer-loading"
                    style="
                        position: absolute;
                        inset: 0;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        background: #f9f7f2;
                        transition: opacity 0.4s;
                        pointer-events: none;
                    "
                >
                    <div
                        style="
                            width: 40px;
                            height: 40px;
                            border-radius: 8px;
                            background: white;
                            border: 1px solid #e0d8cc;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin-bottom: 12px;
                        "
                    >
                        <svg
                            style="
                                width: 20px;
                                height: 20px;
                                animation: le-spin 1s linear infinite;
                            "
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                style="opacity: 0.25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="#2D8176"
                                stroke-width="4"
                            />
                            <path
                                style="opacity: 0.75"
                                fill="#2D8176"
                                d="M4 12a8 8 0 018-8v8H4z"
                            />
                        </svg>
                    </div>
                    <p
                        style="
                            font-size: 11px;
                            font-weight: 700;
                            color: #6a7890;
                            text-transform: uppercase;
                            letter-spacing: 0.1em;
                            margin: 0;
                        "
                    >
                        Converting document…
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes le-spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        function openLeFileModal() {
            const modal = document.getElementById('le-file-modal');
            modal.style.display = 'flex';

            const iframe = document.getElementById('le-preview-iframe');
            if (iframe && iframe.dataset.src && !iframe.src) {
                iframe.src = iframe.dataset.src;
                iframe.addEventListener('load', () => {
                    const loading =
                        document.getElementById('le-viewer-loading');
                    if (loading) loading.style.opacity = '0';
                });
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.getElementById('le-file-modal');
                if (modal) modal.style.display = 'none';
            }
        });
    </script>
@endsection
