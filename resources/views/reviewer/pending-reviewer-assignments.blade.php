@extends('layouts.app')

@section('title', 'Pending Reviewer Assignments')

@push('styles')
    <style>
        /* ── MOBILE RESPONSIVE for Reviewer Assignments ── */
        @media (max-width: 640px) {
            /* Page header: tighter spacing */
            .assign-page-header h1 {
                font-size: 1.6rem !important;
            }

            /* Assignment card: tighter padding */
            .assign-card {
                padding: 16px !important;
            }

            /* Reviewer # / Assigned by: show inline below title on mobile */
            .assign-meta-right {
                display: flex !important;
                flex-direction: row;
                gap: 16px;
                margin-top: 12px;
            }

            /* Action links: wrap tightly, bigger tap targets */
            .assign-actions a,
            .assign-actions button {
                padding: 4px 0;
                font-size: 0.8rem !important;
            }

            /* Date row: allow 2-column wrap */
            .assign-dates {
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 8px 16px;
            }

            /* Comments panel: remove max-height restriction on mobile so it doesn't clip */
            .assign-comments-scroll {
                max-height: none !important;
            }

            /* Comments card: remove top margin gap from grid collapse */
            .assign-comments-card {
                margin-top: 16px;
            }
        }

        @media (max-width: 400px) {
            .assign-page-header h1 {
                font-size: 1.35rem !important;
            }

            .assign-dates {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="mb-6 flex items-center justify-between assign-page-header">
        <div>
            <a
                href="{{ route('dashboard.reviewer') }}"
                class="text-sm text-red-600 hover:text-red-700 font-medium"
            >
                ← Back to Dashboard
            </a>
            <h1 class="text-4xl font-bold text-slate-900 mt-1">
                Pending Reviewer Assignments
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Page: {{ $assignments->currentPage() }} of
                {{ $assignments->lastPage() }} ({{ $assignments->total() }}
                total assignments)
            </p>
        </div>
    </div>

    <div
        class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden"
    >
        <div class="space-y-4">
            @forelse ($assignments as $assignment)
                @php
                    $review = $assignment->submission->reviews->firstWhere('reviewer_id', auth()->id());
                    $days = $assignment->daysUntilDue();
                @endphp

                <div class="p-5 md:p-6 border-b border-slate-100 assign-card">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left / Main column (span 2) -->
                        <div class="md:col-span-2">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <p
                                        class="text-xs text-slate-500 font-semibold"
                                    >
                                        Manuscript
                                    </p>
                                    <p
                                        class="text-sm font-mono text-slate-500 mt-1"
                                    >
                                        #{{ str_pad($assignment->submission_id, 5, '0', STR_PAD_LEFT) }}
                                    </p>
                                    <h3
                                        class="text-lg font-semibold text-slate-900 mt-2 leading-snug"
                                    >
                                        {{ $assignment->submission->title }}
                                    </h3>
                                    <p class="text-sm text-slate-600 mt-2">
                                        {{ Str::limit($assignment->submission->abstract ?? 'No abstract available.', 250) }}
                                    </p>
                                </div>
                                {{-- Desktop: right-aligned meta --}}
                                <div
                                    class="text-right hidden md:block flex-shrink-0"
                                >
                                    <p class="text-xs text-slate-400">
                                        Reviewer #
                                    </p>
                                    <p class="text-sm font-mono text-slate-700">
                                        {{ $assignment->reviewer_number ?? '—' }}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-3">
                                        Assigned by
                                    </p>
                                    <p class="text-sm text-slate-700">
                                        {{ $assignment->editor->name ?? '—' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Mobile: reviewer # + assigned by inline --}}
                            <div
                                class="assign-meta-right hidden mt-3 text-sm text-slate-600"
                            >
                                <div>
                                    <span class="text-xs text-slate-400 block">
                                        Reviewer #
                                    </span>
                                    <span class="font-mono text-slate-700">
                                        {{ $assignment->reviewer_number ?? '—' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs text-slate-400 block">
                                        Assigned by
                                    </span>
                                    <span class="text-slate-700">
                                        {{ $assignment->editor->name ?? '—' }}
                                    </span>
                                </div>
                            </div>

                            <div
                                class="mt-4 flex flex-wrap items-center gap-3 text-xs assign-actions"
                            >
                                <a
                                    href="{{ route('submissions.show', $assignment->submission) }}"
                                    class="text-blue-600 hover:underline"
                                >
                                    View Submission
                                </a>
                                <a
                                    href="{{ route('reviews.create', ['assignment' => $assignment]) }}"
                                    class="text-blue-600 hover:underline"
                                >
                                    Submit Recommendation
                                </a>
                                <a
                                    href="mailto:{{ $assignment->editor->email }}"
                                    class="text-blue-600 hover:underline"
                                >
                                    Email Editor
                                </a>
                                <button
                                    onclick="alert('Linked References')"
                                    class="text-slate-500"
                                >
                                    Linked References
                                </button>
                                <button
                                    onclick="alert('Decision Letter')"
                                    class="text-slate-500"
                                >
                                    Decision Letter
                                </button>
                            </div>

                            <div
                                class="mt-4 flex flex-wrap gap-4 text-sm text-slate-600 assign-dates"
                            >
                                <div>
                                    Invited:
                                    <span class="font-medium text-slate-700">
                                        {{ $assignment->invited_at?->format('M d, Y') ?? '—' }}
                                    </span>
                                </div>
                                <div>
                                    Agreed:
                                    <span class="font-medium text-slate-700">
                                        {{ $assignment->agreed_at?->format('M d, Y') ?? 'Pending' }}
                                    </span>
                                </div>
                                <div>
                                    Due:
                                    <span class="font-medium text-slate-700">
                                        {{ $assignment->review_due_at?->format('M d, Y') ?? '—' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium">
                                        @if ($days === null)
                                            —
                                        @elseif ($days < 0)
                                            <span class="text-red-600">
                                                {{ abs($days) }}d overdue
                                            </span>
                                        @elseif ($days <= 3)
                                            <span class="text-amber-600">
                                                {{ $days }}d left
                                            </span>
                                        @else
                                            <span class="text-green-700">
                                                {{ $days }}d left
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Right / Comments column -->
                        <div class="md:col-span-1 assign-comments-card">
                            <div
                                class="h-full bg-slate-50 border border-slate-100 rounded-lg p-4 flex flex-col"
                            >
                                <div class="flex items-center justify-between">
                                    <h4
                                        class="text-sm font-semibold text-slate-800"
                                    >
                                        Comments & Notes
                                    </h4>
                                    @if ($review)
                                        <span
                                            class="text-xs text-green-700 font-semibold"
                                        >
                                            Draft saved
                                        </span>
                                    @endif
                                </div>
                                <div
                                    class="mt-3 text-sm text-slate-700 overflow-auto assign-comments-scroll"
                                    style="max-height: 180px"
                                >
                                    @if ($review && ($review->comments_for_author || $review->comments_for_editor))
                                        @if ($review->comments_for_author)
                                            <p
                                                class="font-semibold text-xs text-slate-600"
                                            >
                                                Comments for Author
                                            </p>
                                            <p
                                                class="text-sm whitespace-pre-wrap mb-3"
                                            >
                                                {{ Str::limit($review->comments_for_author, 800) }}
                                            </p>
                                        @endif

                                        @if ($review->comments_for_editor)
                                            <p
                                                class="font-semibold text-xs text-slate-600"
                                            >
                                                Comments for Editor
                                            </p>
                                            <p
                                                class="text-sm italic whitespace-pre-wrap"
                                            >
                                                {{ Str::limit($review->comments_for_editor, 800) }}
                                            </p>
                                        @endif
                                    @else
                                        <p class="text-sm text-slate-500">
                                            No reviewer comments saved yet. See
                                            manuscript abstract or open the
                                            review form to add feedback.
                                        </p>
                                    @endif
                                </div>

                                <div
                                    class="mt-4 pt-3 border-t border-slate-100"
                                >
                                    <a
                                        href="{{ route('reviews.create', ['assignment' => $assignment]) }}"
                                        class="block text-center bg-red-600 text-white px-3 py-2 rounded-md text-sm font-semibold"
                                    >
                                        Open Review
                                    </a>
                                    <a
                                        href="{{ route('submissions.show', $assignment->submission) }}"
                                        class="block text-center text-xs text-slate-600 mt-2 hover:underline"
                                    >
                                        View full submission
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-slate-500">
                    No pending reviewer assignments found.
                </div>
            @endforelse

            <div class="border-t border-slate-200 px-6 py-3 bg-slate-50">
                {{ $assignments->links() }}
            </div>
        </div>
    </div>
@endsection
