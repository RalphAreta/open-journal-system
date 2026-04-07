@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f9f7f2]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
            <!-- Header -->
            <div class="mb-6 sm:mb-8">
                <h1
                    class="font-libre text-2xl sm:text-3xl font-bold text-[#2D8176] mb-2"
                >
                    Final Layout Review
                </h1>
                <p class="text-[#6a7890] text-sm sm:text-base">
                    Your paper is ready for final approval before publication
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
                            <p class="font-bold text-[#1a1a1a] break-words">
                                {{ $submission->title }}
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Author
                            </p>
                            <p class="font-bold text-[#1a1a1a]">
                                {{ $submission->author->name ?? 'Anonymous' }}
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Research Field
                            </p>
                            <p class="font-bold text-[#1a1a1a]">
                                {{ $submission->research_field }}
                            </p>
                        </div>
                        <div class="border-t border-[#e0d8cc] pt-4">
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-2"
                            >
                                Abstract
                            </p>
                            <p class="text-sm text-[#4a5568] leading-relaxed">
                                {{ $submission->abstract }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div
                    class="bg-white rounded-xl p-5 sm:p-6 border border-[#e0d8cc]"
                >
                    <h2 class="font-bold text-lg text-[#2D8176] mb-4">
                        Status
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Current Status
                            </p>
                            <span
                                class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 font-bold rounded-full text-sm"
                            >
                                Ready for Publication
                            </span>
                        </div>
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Submitted
                            </p>
                            <p class="font-bold text-[#2D8176]">
                                {{ $submission->submitted_at->format('M d, Y') }}
                            </p>
                            <p class="text-xs text-[#6a7890]">
                                {{ $submission->submitted_at->diffForHumans() }}
                            </p>
                        </div>
                        <div>
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider mb-1"
                            >
                                Accepted
                            </p>
                            <p class="font-bold text-[#2D8176]">
                                {{ $submission->editor_decision_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Layout File Card -->
            <div
                class="bg-white rounded-xl p-5 sm:p-6 border border-[#e0d8cc] mb-6 sm:mb-8"
            >
                <h2 class="font-bold text-lg text-[#2D8176] mb-2">
                    📄 Review Final Layout
                </h2>
                <p class="text-sm text-[#6a7890] mb-5 sm:mb-6">
                    The layout editor has prepared the final version of your
                    paper. Please review it before publication.
                </p>

                @if ($layoutAssignment && $layoutAssignment->layout_file_path)
                    <div
                        class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg mb-5 sm:mb-6"
                    >
                        <p class="text-sm text-emerald-700 font-bold mb-2">
                            ✓ Layout file ready for review
                        </p>
                        <p class="text-xs text-emerald-600 mb-4">
                            Received on
                            {{ $layoutAssignment->completed_at->format('M d, Y') }}
                        </p>
                        <a
                            href="{{ route('author.download-layout', ['submission' => $submission->id]) }}"
                            class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-emerald-600 text-white rounded-lg font-bold hover:bg-emerald-700 transition-colors text-sm"
                        >
                            📥 Download Final Layout
                        </a>
                    </div>

                    @if ($layoutAssignment->notes)
                        <div
                            class="p-4 bg-[#f9f7f2] border border-[#e0d8cc] rounded-lg mb-5 sm:mb-6"
                        >
                            <p
                                class="text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-2"
                            >
                                Layout Editor Notes
                            </p>
                            <p class="text-sm text-[#4a5568]">
                                {{ $layoutAssignment->notes }}
                            </p>
                        </div>
                    @endif
                @else
                    <div
                        class="p-4 bg-amber-50 border border-amber-200 rounded-lg"
                    >
                        <p class="text-sm text-amber-700">
                            ⏳ Layout is being prepared by the layout editor...
                        </p>
                    </div>
                @endif
            </div>

            <!-- Publication Timeline -->
            <div
                class="bg-gradient-to-r from-[#2D8176] to-[#1f5d54] rounded-xl p-6 sm:p-8 text-white mb-6 sm:mb-8"
            >
                <h3 class="font-bold text-lg mb-4">Publication Timeline</h3>
                <ol class="space-y-3">
                    <li class="flex gap-3 text-sm sm:text-base">
                        <span class="font-bold shrink-0">✓</span>
                        <span>Paper Accepted by Editor</span>
                    </li>
                    <li class="flex gap-3 text-sm sm:text-base">
                        <span class="font-bold shrink-0">✓</span>
                        <span>Layout Editing Completed</span>
                    </li>
                    <li class="flex gap-3 text-sm sm:text-base">
                        <span class="font-bold shrink-0">✓</span>
                        <span>Final Review by Editor</span>
                    </li>
                    <li class="flex gap-3 text-sm sm:text-base">
                        <span class="font-bold shrink-0">✓</span>
                        <span>Sent for Your Confirmation</span>
                    </li>
                    <li class="flex gap-3 text-sm sm:text-base">
                        <span class="opacity-70 shrink-0">⏳</span>
                        <span class="opacity-70">
                            Editor-in-Chief Final Approval
                        </span>
                    </li>
                    <li class="flex gap-3 text-sm sm:text-base">
                        <span class="opacity-70 shrink-0">⏳</span>
                        <span class="opacity-70">
                            Published to Public Repository
                        </span>
                    </li>
                </ol>
            </div>

            <!-- Info Box -->
            <div
                class="p-5 sm:p-6 bg-[#2D8176]/5 border border-[#2D8176]/20 rounded-xl"
            >
                <h3 class="font-bold text-[#2D8176] mb-3">
                    ℹ️ What happens next?
                </h3>
                <p class="text-sm text-[#4a5568] mb-3 leading-relaxed">
                    Your paper has passed all review stages and is ready for
                    publication. The layout is final and will not be changed.
                    The Editor-in-Chief will perform a final approval check and
                    your paper will be published to the public repository.
                </p>
                <p class="text-xs text-[#6a7890]">
                    You'll receive an email notification once your paper is
                    officially published.
                </p>
            </div>
        </div>
    </div>
@endsection
