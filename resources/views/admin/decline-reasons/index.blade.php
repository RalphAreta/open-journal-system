@extends('layouts.app')

@section('title', 'Manage Decline Reasons')

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
            font-weight: 400;
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

        /* ── Section Label ── */
        .section-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Add Form Card ── */
        .add-card {
            background: #fff;
            border: 1.5px dashed var(--border-dk);
            border-radius: 14px;
            padding: 22px 24px;
            margin-bottom: 28px;
        }
        .add-card-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 14px;
        }
        .add-input {
            flex: 1;
            padding: 10px 14px;
            border: 1.5px solid var(--border-dk);
            border-radius: 7px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.92rem;
            color: var(--ink);
            background: var(--parchment);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
        }
        .add-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
            background: #fff;
        }
        .add-input::placeholder {
            color: #b5a595;
        }
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 7px;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--teal);
            color: #fff;
            border: none;
            cursor: pointer;
            transition:
                background 0.15s,
                transform 0.12s,
                box-shadow 0.15s;
            box-shadow: 0 4px 12px rgba(45, 129, 118, 0.25);
            white-space: nowrap;
        }
        .btn-add:hover {
            background: var(--teal-dk);
            transform: translateY(-1px);
        }

        /* ── Reasons Table ── */
        .reasons-wrap {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(26, 18, 9, 0.07);
        }
        .reasons-head {
            padding: 16px 24px 14px;
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .reasons-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
        }
        .reasons-head-eyebrow {
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 2px;
        }

        table.rt {
            width: 100%;
            border-collapse: collapse;
        }
        table.rt thead tr {
            background: var(--parchment);
            border-bottom: 1.5px solid var(--border-dk);
        }
        table.rt th {
            padding: 11px 22px;
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-align: left;
        }
        table.rt th:last-child {
            text-align: right;
        }
        table.rt td {
            padding: 15px 22px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: middle;
        }
        table.rt tbody tr:last-child td {
            border-bottom: none;
        }
        table.rt tbody tr {
            transition: background 0.1s;
        }
        table.rt tbody tr:hover td {
            background: var(--teal-lt);
        }

        /* Status badge */
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
        .sbadge.active {
            background: var(--teal-lt);
            border-color: rgba(45, 129, 118, 0.35);
            color: var(--teal-dk);
        }
        .sbadge.active .dot {
            background: var(--teal);
        }
        .sbadge.inactive {
            background: var(--parchment);
            border-color: var(--border);
            color: var(--ink-soft);
        }
        .sbadge.inactive .dot {
            background: var(--border-dk);
        }

        /* Sort order badge */
        .order-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--parchment);
            border: 1px solid var(--border);
            font-size: 0.72rem;
            font-weight: 800;
            color: var(--ink-soft);
        }

        /* Action buttons */
        .btn-edit-trigger {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 13px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: #fff;
            color: var(--ink-soft);
            border: 1.5px solid var(--border-dk);
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-edit-trigger:hover {
            background: var(--teal-lt);
            color: var(--teal);
            border-color: var(--teal);
        }
        .btn-toggle {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 13px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: #fff;
            border: 1.5px solid var(--border-dk);
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-toggle.deactivate {
            color: var(--gold-dk);
        }
        .btn-toggle.deactivate:hover {
            background: #fdf8ec;
            border-color: rgba(201, 168, 76, 0.5);
        }
        .btn-toggle.activate {
            color: var(--teal);
        }
        .btn-toggle.activate:hover {
            background: var(--teal-lt);
            border-color: var(--teal);
        }
        .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 13px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: #fff;
            color: var(--red);
            border: 1.5px solid #fecaca;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-delete:hover {
            background: var(--red-lt);
            border-color: var(--red);
        }

        /* ── Inline Edit Row ── */
        .edit-row {
            display: none;
        }
        .edit-row.open {
            display: table-row;
        }
        .edit-row td {
            background: var(--teal-lt) !important;
            border-bottom: 2px solid var(--teal) !important;
            padding: 12px 22px !important;
        }
        .edit-input {
            flex: 1;
            padding: 9px 13px;
            border: 1.5px solid var(--teal);
            border-radius: 7px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.9rem;
            color: var(--ink);
            background: #fff;
            outline: none;
            transition: box-shadow 0.15s;
        }
        .edit-input:focus {
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.15);
        }
        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--teal);
            color: #fff;
            border: none;
            cursor: pointer;
            transition:
                background 0.15s,
                transform 0.12s;
            box-shadow: 0 3px 10px rgba(45, 129, 118, 0.22);
        }
        .btn-save:hover {
            background: var(--teal-dk);
            transform: translateY(-1px);
        }
        .btn-cancel-edit {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: #fff;
            color: var(--ink-soft);
            border: 1.5px solid var(--border-dk);
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-cancel-edit:hover {
            background: var(--red-lt);
            color: var(--red);
            border-color: #fecaca;
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
        .total-pill {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--ink-soft);
        }

        /* ── Alert ── */
        .flash-success {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-radius: 10px;
            background: var(--teal-lt);
            border: 1px solid rgba(45, 129, 118, 0.3);
            color: var(--teal-dk);
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 24px;
        }
        .flash-error {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-radius: 10px;
            background: var(--red-lt);
            border: 1px solid #fecaca;
            color: var(--red);
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 24px;
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--ink-soft);
            text-decoration: none;
            transition: color 0.13s;
        }
        .back-link:hover {
            color: var(--teal);
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
    <div class="aw aw-bg max-w-7xl mx-auto px-4">
        {{-- ── Hero ── --}}
        <div class="hero-header fu">
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Admin · Configuration</p>
                    <h1 class="hero-title">
                        Decline
                        <em>Reasons</em>
                    </h1>
                    <p class="hero-sub">
                        Manage the reasons reviewers can select when declining a
                        review invitation
                    </p>
                </div>
                <div
                    class="flex items-center gap-3 self-start md:self-auto shrink-0"
                >
                    <span class="date-pill hidden sm:inline-block">
                        {{ now()->format('D, M j Y') }}
                    </span>
                    <a href="{{ route('dashboard.admin') }}" class="back-link">
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
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Flash Messages ── --}}
        @if (session('success'))
            <div class="flash-success fu">
                <svg
                    class="w-4 h-4 flex-shrink-0"
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
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="flash-error fu">
                <svg
                    class="w-4 h-4 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                    />
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ── Add New Reason ── --}}
        <div class="fu1 mb-8">
            <div class="section-label">Add New Reason</div>
            <div class="add-card">
                <p class="add-card-title">New Decline Reason</p>
                <form
                    method="POST"
                    action="{{ route('admin.decline-reasons.store') }}"
                >
                    @csrf
                    <div class="flex gap-3 items-center flex-wrap">
                        <input
                            type="text"
                            name="reason"
                            class="add-input"
                            placeholder="e.g. Currently on sabbatical leave"
                            value="{{ old('reason') }}"
                            autocomplete="off"
                            required
                            maxlength="255"
                            style="min-width: 280px"
                        />
                        <button type="submit" class="btn-add">
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
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            Add Reason
                        </button>
                    </div>
                    <p
                        style="
                            font-size: 0.74rem;
                            color: var(--ink-soft);
                            margin-top: 10px;
                        "
                    >
                        Active reasons will appear in the reviewer's decline
                        dialog. Inactive reasons are hidden from reviewers but
                        preserved for records.
                    </p>
                </form>
            </div>
        </div>

        {{-- ── Reasons Table ── --}}
        <div class="fu2 reasons-wrap mb-12">
            <div class="reasons-head">
                <div>
                    <p class="reasons-head-eyebrow">All Entries</p>
                    <span class="reasons-head-title">Decline Reasons</span>
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
                    {{ $reasons->count() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="rt">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th style="text-align: right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reasons as $reason)
                            {{-- View Row --}}
                            <tr id="view-row-{{ $reason->id }}">
                                <td>
                                    <span class="order-badge">
                                        {{ $reason->sort_order }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        style="
                                            font-size: 0.92rem;
                                            color: var(--ink);
                                        "
                                    >
                                        {{ $reason->reason }}
                                    </span>
                                </td>
                                <td>
                                    @if ($reason->is_active)
                                        <span class="sbadge active">
                                            <span class="dot"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="sbadge inactive">
                                            <span class="dot"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right">
                                    <div
                                        class="flex items-center justify-end gap-2 flex-wrap"
                                    >
                                        {{-- Edit --}}
                                        <button
                                            type="button"
                                            class="btn-edit-trigger"
                                            onclick="
                                                openEditRow({{ $reason->id }})
                                            "
                                        >
                                            <svg
                                                class="w-3 h-3"
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
                                            Edit
                                        </button>

                                        {{-- Toggle Active --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.decline-reasons.toggle', $reason) }}"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="btn-toggle {{ $reason->is_active ? 'deactivate' : 'activate' }}"
                                            >
                                                @if ($reason->is_active)
                                                    <svg
                                                        class="w-3 h-3"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2.5"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                                                        />
                                                    </svg>
                                                    Deactivate
                                                @else
                                                    <svg
                                                        class="w-3 h-3"
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
                                                    Activate
                                                @endif
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.decline-reasons.destroy', $reason) }}"
                                            onsubmit="
                                                return confirmDelete(
                                                    event,
                                                    '{{ addslashes($reason->reason) }}',
                                                );
                                            "
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn-delete"
                                            >
                                                <svg
                                                    class="w-3 h-3"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Inline Edit Row --}}
                            <tr
                                id="edit-row-{{ $reason->id }}"
                                class="edit-row"
                            >
                                <td colspan="4">
                                    <form
                                        method="POST"
                                        action="{{ route('admin.decline-reasons.update', $reason) }}"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <div
                                            class="flex items-center gap-3 flex-wrap"
                                        >
                                            <input
                                                type="text"
                                                name="reason"
                                                class="edit-input"
                                                value="{{ $reason->reason }}"
                                                required
                                                maxlength="255"
                                                style="min-width: 260px"
                                            />
                                            <button
                                                type="submit"
                                                class="btn-save"
                                            >
                                                <svg
                                                    class="w-3 h-3"
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
                                                Save
                                            </button>
                                            <button
                                                type="button"
                                                class="btn-cancel-edit"
                                                onclick="
                                                    closeEditRow(
                                                        {{ $reason->id }},
                                                    )
                                                "
                                            >
                                                <svg
                                                    class="w-3 h-3"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div
                                        style="
                                            padding: 60px 24px;
                                            text-align: center;
                                        "
                                    >
                                        <div
                                            style="
                                                width: 56px;
                                                height: 56px;
                                                border-radius: 50%;
                                                background: var(--parchment);
                                                border: 1.5px solid
                                                    var(--border);
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                margin: 0 auto 14px;
                                            "
                                        >
                                            <svg
                                                class="w-6 h-6"
                                                fill="none"
                                                stroke="#c9b99a"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                />
                                            </svg>
                                        </div>
                                        <p
                                            style="
                                                font-size: 0.78rem;
                                                font-weight: 700;
                                                letter-spacing: 0.14em;
                                                text-transform: uppercase;
                                                color: #c9b99a;
                                            "
                                        >
                                            No decline reasons yet
                                        </p>
                                        <p
                                            style="
                                                font-size: 0.84rem;
                                                color: #b5a595;
                                                margin-top: 6px;
                                            "
                                        >
                                            Add your first reason using the form
                                            above.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span class="total-pill">
                    {{ $reasons->where('is_active', true)->count() }} active ·
                    {{ $reasons->where('is_active', false)->count() }} inactive
                </span>
                <span class="table-footer-brand">BatStateU · BIRJISE</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openEditRow(id) {
            // Close any other open edit rows first
            document.querySelectorAll('.edit-row.open').forEach((row) => {
                row.classList.remove('open');
            });
            document.getElementById('edit-row-' + id).classList.add('open');
            // Focus the input
            const input = document.querySelector(
                '#edit-row-' + id + ' .edit-input',
            );
            if (input) {
                input.focus();
                input.select();
            }
        }

        function closeEditRow(id) {
            document.getElementById('edit-row-' + id).classList.remove('open');
        }

        function confirmDelete(event, reason) {
            if (typeof Swal !== 'undefined') {
                event.preventDefault();
                const form = event.target;
                Swal.fire({
                    title: 'Delete Reason?',
                    html: `This will permanently remove:<br><strong style="color:#1a1209">"${reason}"</strong><br><br>This cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#c0392b',
                    cancelButtonColor: '#2d8176',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl',
                        confirmButton:
                            'px-6 py-3 rounded-lg text-xs font-bold uppercase tracking-widest mx-1',
                        cancelButton:
                            'px-6 py-3 rounded-lg text-xs font-bold uppercase tracking-widest mx-1',
                    },
                }).then((r) => {
                    if (r.isConfirmed) form.submit();
                });
                return false;
            }
            return confirm(`Delete "${reason}"? This cannot be undone.`);
        }
    </script>
@endpush
