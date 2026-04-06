@extends('layouts.app')

@section('title', 'My Reviews')

@push('styles')
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --teal-lt: #e8f4f2;
            --gold: #c9a84c;
            --gold-dk: #8a6e28;
            --ink: #1a1209;
            --ink-mid: #3d2f1a;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
            --red: #c0392b;
            --red-lt: #fef2f2;
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

        /* ── Hero ── */
        .hero-header {
            position: relative;
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 36px;
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
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-size: 0.98rem;
            color: var(--ink-soft);
            margin-top: 8px;
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

        /* ── Table Wrap ── */
        .ms-table-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
        }
        .ms-table-head {
            padding: 16px 24px 14px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ms-table-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
        }
        .ms-table-head-eyebrow {
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 2px;
        }

        table.mst {
            width: 100%;
            border-collapse: collapse;
        }
        table.mst thead tr {
            background: var(--parchment);
            border-bottom: 1.5px solid var(--border-dk);
        }
        table.mst th {
            padding: 11px 22px;
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-align: left;
        }
        table.mst th:last-child {
            text-align: right;
        }
        table.mst td {
            padding: 15px 22px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: middle;
        }
        table.mst tbody tr:last-child td {
            border-bottom: none;
        }
        table.mst tbody tr {
            transition: background 0.1s;
            cursor: default;
        }
        table.mst tbody tr:hover td {
            background: var(--teal-lt);
        }
        table.mst tbody tr:hover .ms-row-title {
            color: var(--teal);
        }

        .ms-row-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.92rem;
            font-weight: 700;
            font-style: italic;
            color: var(--ink);
            line-height: 1.4;
            transition: color 0.12s;
        }
        .ms-author {
            font-size: 0.76rem;
            color: var(--ink-soft);
            margin-top: 2px;
        }

        /* Status badges */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border: 1px solid;
            white-space: nowrap;
        }
        .sbadge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .sbadge.completed {
            background: #f0fdf4;
            border-color: #86efac;
            color: var(--teal-dk);
        }
        .sbadge.completed .dot {
            background: var(--teal);
        }
        .sbadge.assigned {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.assigned .dot {
            background: var(--teal);
        }
        .sbadge.pending {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.4);
            color: var(--gold-dk);
        }
        .sbadge.pending .dot {
            background: var(--gold);
        }
        .sbadge.default {
            background: var(--parchment);
            border-color: var(--border);
            color: var(--ink-soft);
        }
        .sbadge.default .dot {
            background: var(--border-dk);
        }

        /* Action buttons */
        .btn-submit-review {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--red);
            color: #fff;
            text-decoration: none;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 3px 10px rgba(192, 57, 43, 0.2);
        }
        .btn-submit-review:hover {
            background: #a93226;
            transform: translateY(-1px);
        }
        .btn-done {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            font-weight: 800;
            color: var(--teal-dk);
        }

        /* Table footer */
        .table-footer {
            padding: 12px 24px;
            background: var(--parchment);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .table-footer-brand {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }

        /* Empty state */
        .empty-state {
            padding: 70px 24px;
            text-align: center;
        }
        .empty-state-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--parchment);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }
        .empty-state-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #c9b99a;
        }

        /* ── Animations ── */
        .fu {
            animation: fu 0.45s ease both;
        }
        .fu1 {
            animation: fu 0.45s 0.08s ease both;
        }
        .fu2 {
            animation: fu 0.45s 0.16s ease both;
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
    <div class="aw aw-bg max-w-7xl mx-auto px-4">
        {{-- ── Hero ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Reviewer Portal</p>
                    <h1 class="hero-title">
                        My
                        <em>Reviews</em>
                    </h1>
                    <p class="hero-sub">
                        All your review assignments in one place
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

        {{-- ── Table ── --}}
        <div class="fu1 ms-table-wrap mb-12">
            <div class="ms-table-head">
                <div>
                    <p class="ms-table-head-eyebrow">Your Workload</p>
                    <span class="ms-table-head-title">Review Assignments</span>
                </div>
                <span
                    style="
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        width: 28px;
                        height: 28px;
                        border-radius: 50%;
                        background: var(--teal);
                        color: #fff;
                        font-size: 0.72rem;
                        font-weight: 800;
                    "
                >
                    {{ $assignments->total() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="mst">
                    <thead>
                        <tr>
                            <th style="width: 40%">Submission</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assignments as $a)
                            <tr>
                                <td>
                                    <p class="ms-row-title">
                                        {{ Str::limit($a->submission->title ?? '', 50) }}
                                    </p>
                                </td>
                                <td>
                                    <p
                                        class="ms-author"
                                        style="
                                            margin-top: 0;
                                            font-size: 0.84rem;
                                            color: var(--ink-mid);
                                        "
                                    >
                                        {{ $a->submission->author->name ?? '—' }}
                                    </p>
                                </td>
                                <td>
                                    @php
                                        $badgeCls = match ($a->status) {
                                            'completed' => 'completed',
                                            'assigned' => 'assigned',
                                            'pending' => 'pending',
                                            default => 'default',
                                        };
                                    @endphp

                                    <span class="sbadge {{ $badgeCls }}">
                                        <span class="dot"></span>
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td style="text-align: right">
                                    @if ($a->status === 'assigned')
                                        <a
                                            href="{{ route('reviews.create', ['assignment' => $a]) }}"
                                            class="btn-submit-review"
                                        >
                                            <svg
                                                class="w-3.5 h-3.5"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                            Submit Review
                                        </a>
                                    @else
                                        <span class="btn-done">
                                            <svg
                                                class="w-3.5 h-3.5"
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
                                            Done
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <svg
                                                class="w-7 h-7"
                                                fill="none"
                                                stroke="#c9b99a"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </div>
                                        <p class="empty-state-label">
                                            No review assignments
                                        </p>
                                        <p
                                            style="
                                                font-size: 0.84rem;
                                                color: #b5a595;
                                                margin-top: 6px;
                                            "
                                        >
                                            New assignments will appear here.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="text-sm">{{ $assignments->links() }}</div>
            </div>
        </div>
    </div>
@endsection
