@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f9f7f2]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
            <!-- Header -->
            <div class="mb-6 sm:mb-8">
                <h1
                    class="font-libre text-2xl sm:text-3xl font-bold text-[#2D8176] mb-2"
                >
                    Layout Editor Feedback
                </h1>
                <p class="text-sm sm:text-base text-[#6a7890]">
                    Review feedback and edits from the layout editor
                </p>
            </div>

            <!-- Back Button -->
            <div class="mb-5 sm:mb-6">
                <a
                    href="{{ route('submissions.show', $submission) }}"
                    class="text-[#2D8176] hover:text-[#1f5d54] font-semibold flex items-center gap-2 text-sm sm:text-base"
                >
                    ← Back to Submission
                </a>
            </div>

            <!-- Paper Info Card -->
            <div
                class="bg-white rounded-xl p-4 sm:p-6 border border-[#e0d8cc] mb-6 sm:mb-8"
            >
                <h2 class="font-bold text-base sm:text-lg text-[#2D8176] mb-4">
                    Paper Information
                </h2>
                <div class="space-y-3">
                    <div>
                        <p
                            class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                        >
                            Title
                        </p>
                        <p
                            class="font-bold text-[#1a1a1a] text-sm sm:text-base"
                        >
                            {{ $submission->title }}
                        </p>
                    </div>
                    <div>
                        <p
                            class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                        >
                            Status
                        </p>
                        <span
                            class="inline-block px-3 py-1 bg-[#e8f4f2] text-[#2D8176] font-bold rounded-full text-xs sm:text-sm"
                        >
                            In Layout Review
                        </span>
                    </div>
                </div>
            </div>

            <!-- Layout Editor Feedback Cards -->
            @forelse ($layoutAssignments as $assignment)
                <div
                    class="bg-white rounded-xl p-4 sm:p-6 border border-[#e0d8cc] mb-6 sm:mb-8"
                >
                    <!-- Header -->
                    <div
                        class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6"
                    >
                        <div>
                            <h2
                                class="font-bold text-base sm:text-lg text-[#2D8176] mb-1"
                            >
                                Layout Editor:
                                {{ $assignment->layoutEditor->name }}
                            </h2>
                            <p class="text-xs sm:text-sm text-[#6a7890]">
                                Completed on
                                {{ $assignment->completed_at->format('F d, Y') }}
                                ({{ $assignment->completed_at->diffForHumans() }})
                            </p>
                        </div>
                        <div class="sm:text-right">
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Status
                            </p>
                            <span
                                class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 font-bold rounded-full text-xs sm:text-sm"
                            >
                                ✓ Completed
                            </span>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div
                        class="border-t border-[#e0d8cc] pt-5 sm:pt-6 mb-5 sm:mb-6"
                    >
                        <p
                            class="text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-4"
                        >
                            Timeline
                        </p>
                        <div class="space-y-3">
                            <div class="flex gap-3 sm:gap-4">
                                <div class="shrink-0">
                                    <div
                                        class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-[#2D8176] text-white text-xs sm:text-sm font-bold"
                                    >
                                        1
                                    </div>
                                </div>
                                <div>
                                    <p
                                        class="font-bold text-[#1a1a1a] text-sm sm:text-base"
                                    >
                                        Assigned
                                    </p>
                                    <p
                                        class="text-xs sm:text-sm text-[#6a7890]"
                                    >
                                        {{ $assignment->assigned_at->format('F d, Y \a\t g:i A') }}
                                    </p>
                                </div>
                            </div>
                            @if ($assignment->started_at)
                                <div class="flex gap-3 sm:gap-4">
                                    <div class="shrink-0">
                                        <div
                                            class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-[#2D8176] text-white text-xs sm:text-sm font-bold"
                                        >
                                            2
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            class="font-bold text-[#1a1a1a] text-sm sm:text-base"
                                        >
                                            Work Started
                                        </p>
                                        <p
                                            class="text-xs sm:text-sm text-[#6a7890]"
                                        >
                                            {{ $assignment->started_at->format('F d, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex gap-3 sm:gap-4">
                                <div class="shrink-0">
                                    <div
                                        class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-emerald-500 text-white text-xs sm:text-sm font-bold"
                                    >
                                        ✓
                                    </div>
                                </div>
                                <div>
                                    <p
                                        class="font-bold text-[#1a1a1a] text-sm sm:text-base"
                                    >
                                        Completed
                                    </p>
                                    <p
                                        class="text-xs sm:text-sm text-[#6a7890]"
                                    >
                                        {{ $assignment->completed_at->format('F d, Y \a\t g:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes/Feedback Section -->

                    @if ($assignment->notes)
                        <div
                            class="border-t border-[#e0d8cc] pt-5 sm:pt-6 mb-5 sm:mb-6"
                        >
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-4"
                            >
                                📝 Layout Editor Notes
                            </p>
                            <div
                                class="p-3 sm:p-4 bg-[#f9f7f2] border border-[#e0d8cc] rounded-lg"
                            >
                                <p
                                    class="text-xs sm:text-sm text-[#4a5568] leading-relaxed whitespace-pre-line"
                                >
                                    {{ $assignment->notes }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div
                            class="border-t border-[#e0d8cc] pt-5 sm:pt-6 mb-5 sm:mb-6"
                        >
                            <p class="text-xs sm:text-sm text-[#6a7890] italic">
                                No specific notes provided by the layout editor
                            </p>
                        </div>
                    @endif

                    <!-- Author Feedback/Revision Notes Section -->
                    @if ($assignment->author_feedback)
                        <div
                            class="border-t border-[#e0d8cc] pt-5 sm:pt-6 mb-5 sm:mb-6"
                        >
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-4"
                            >
                                💬 Your Revision Notes
                            </p>
                            <div
                                class="p-3 sm:p-4 bg-amber-50 border border-amber-200 rounded-lg"
                            >
                                <p
                                    class="text-xs sm:text-sm text-amber-900 leading-relaxed whitespace-pre-line"
                                >
                                    {{ $assignment->author_feedback }}
                                </p>
                            </div>
                            <p class="text-xs text-[#6a7890] mt-2">
                                Submitted:
                                {{ $assignment->author_feedback_at?->format('M d, Y \a\t g:i A') ?? 'N/A' }}
                            </p>
                        </div>
                    @endif

                    <!-- Download Layout File -->
                    <div class="border-t border-[#e0d8cc] pt-5 sm:pt-6">
                        <p
                            class="text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-4"
                        >
                            📥 Layout File
                        </p>
                        <a
                            href="{{ route('author.download-layout', $submission) }}"
                            class="inline-block w-full sm:w-auto text-center px-6 py-3 bg-[#2D8176] text-white rounded-lg font-bold hover:bg-[#1f5d54] transition-colors text-sm sm:text-base"
                        >
                            Download Edited Layout
                        </a>
                        <p class="text-xs text-[#6a7890] mt-2">
                            {{ $assignment->layout_file_name ?? 'layout-file.pdf' }}
                        </p>
                    </div>
                </div>
            @empty
                <div
                    class="bg-amber-50 border border-amber-200 rounded-xl p-4 sm:p-6"
                >
                    <p
                        class="text-amber-700 font-semibold text-sm sm:text-base"
                    >
                        ⏳ Layout editor is working on your manuscript
                    </p>
                    <p class="text-xs sm:text-sm text-amber-600 mt-1">
                        Check back soon for feedback and the edited layout
                    </p>
                </div>
            @endforelse

            <!-- Info Section -->
            <div
                class="bg-linear-to-r from-[#2D8176] to-[#1f5d54] rounded-xl p-5 sm:p-8 text-white mt-6 sm:mt-8"
            >
                <h3 class="font-bold text-base sm:text-lg mb-4">
                    What Happens Next?
                </h3>
                <ol class="space-y-2 text-xs sm:text-sm">
                    <li class="flex gap-2 sm:gap-3">
                        <span class="font-bold shrink-0">✓</span>
                        <span>Layout editor completes the editing</span>
                    </li>
                    <li class="flex gap-2 sm:gap-3">
                        <span class="font-bold shrink-0">✓</span>
                        <span>You review the feedback and edited layout</span>
                    </li>
                    <li class="flex gap-2 sm:gap-3">
                        <span class="opacity-70 shrink-0">⏳</span>
                        <span class="opacity-70">
                            Submit your approval or request changes
                        </span>
                    </li>
                    <li class="flex gap-2 sm:gap-3">
                        <span class="opacity-70 shrink-0">⏳</span>
                        <span class="opacity-70">
                            Editor reviews your confirmation
                        </span>
                    </li>
                    <li class="flex gap-2 sm:gap-3">
                        <span class="opacity-70 shrink-0">⏳</span>
                        <span class="opacity-70">Manuscript is published</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>
@endsection
