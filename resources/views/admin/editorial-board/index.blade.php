@extends('layouts.app')

@section('title', 'Editorial Board — Admin')

@push('styles')
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --teal-lt: #e8f4f2;
            --gold: #c9a84c;
            --gold-lt: #f5e9c4;
            --gold-dk: #8a6e28;
            --red: #c0392b;
            --red-lt: #fce8e6;
            --ink: #1a1209;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
        }
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .eb-wrap {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 16px 60px;
        }

        /* Hero */
        .eb-hero {
            padding: 28px 0 20px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 28px;
            position: relative;
        }
        .eb-hero::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .eb-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .eb-eyebrow::before {
            content: '';
            width: 22px;
            height: 1px;
            background: var(--teal);
        }
        .eb-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(1.5rem, 3vw, 2.4rem);
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.15;
        }
        .eb-title em {
            font-style: italic;
            color: var(--teal);
        }
        .eb-sub {
            font-size: 0.9rem;
            color: var(--ink-soft);
            margin-top: 6px;
        }

        /* Stats row */
        .eb-stats {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        .eb-stat {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px 20px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 100px;
        }
        .eb-stat-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1;
            color: var(--teal);
        }
        .eb-stat-lbl {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }

        /* Toolbar */
        .eb-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--teal);
            color: #fff;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 11px 22px;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.28);
            transition:
                background 0.15s,
                transform 0.12s;
        }
        .btn-add:hover {
            background: var(--teal-dk);
            transform: translateY(-1px);
        }

        /* Alert */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .alert-success {
            background: var(--teal-lt);
            color: var(--teal-dk);
            border: 1px solid rgba(45, 129, 118, 0.25);
        }

        /* Group label */
        .group-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--teal);
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 28px 0 12px;
        }
        .group-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .group-label:first-child {
            margin-top: 0;
        }

        /* Member cards grid */
        .member-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 14px;
        }

        .member-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            transition:
                box-shadow 0.2s,
                border-color 0.2s;
            position: relative;
            overflow: hidden;
        }
        .member-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--teal);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .member-card:hover {
            box-shadow: 0 8px 24px rgba(45, 129, 118, 0.1);
            border-color: rgba(45, 129, 118, 0.3);
        }
        .member-card:hover::before {
            opacity: 1;
        }
        .member-card.inactive {
            opacity: 0.55;
        }

        /* Avatar */
        .member-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), #1f6550);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Libre Baskerville', serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(45, 129, 118, 0.2);
        }

        .member-info {
            flex: 1;
            min-width: 0;
        }
        .member-name {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.3;
            margin-bottom: 3px;
        }
        .member-role-badge {
            display: inline-block;
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--teal);
            background: var(--teal-lt);
            border: 1px solid rgba(45, 129, 118, 0.2);
            padding: 2px 10px;
            border-radius: 20px;
            margin-bottom: 6px;
        }
        .member-affil {
            font-size: 0.78rem;
            color: var(--ink-soft);
            line-height: 1.5;
        }
        .member-loc {
            font-size: 0.72rem;
            color: var(--border-dk);
            margin-top: 3px;
        }

        /* Actions */
        .member-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }
        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            text-decoration: none;
        }
        .btn-icon:hover {
            border-color: var(--teal);
            background: var(--teal-lt);
            color: var(--teal);
        }
        .btn-icon.danger:hover {
            border-color: var(--red);
            background: var(--red-lt);
            color: var(--red);
        }
        .btn-icon.toggle-active {
            color: var(--teal);
        }
        .btn-icon.toggle-inactive {
            color: var(--border-dk);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--ink-soft);
        }
        .empty-state p:first-child {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="eb-wrap">
        {{-- Hero --}}
        <div class="eb-hero">
            <div
                style="
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    gap: 16px;
                    flex-wrap: wrap;
                "
            >
                <div>
                    <p class="eb-eyebrow">Admin · Journal System</p>
                    <h1 class="eb-title">
                        Editorial
                        <em>Board</em>
                    </h1>
                    <p class="eb-sub">
                        Manage editors, reviewers, and advisors displayed on the
                        public landing page.
                    </p>
                </div>
                <a
                    href="{{ route('admin.editorial-board.create') }}"
                    class="btn-add"
                    style="margin-top: 8px"
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
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Add Member
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        {{-- Stats --}}
        <div class="eb-stats">
            <div class="eb-stat">
                <span class="eb-stat-val">{{ $total }}</span>
                <span class="eb-stat-lbl">Total Members</span>
            </div>
            <div class="eb-stat">
                <span class="eb-stat-val" style="color: var(--gold-dk)">
                    {{ $active }}
                </span>
                <span class="eb-stat-lbl">Active / Visible</span>
            </div>
            <div class="eb-stat">
                <span class="eb-stat-val" style="color: var(--ink-soft)">
                    {{ $total - $active }}
                </span>
                <span class="eb-stat-lbl">Hidden</span>
            </div>
            <div class="eb-stat">
                <span class="eb-stat-val">{{ $members->count() }}</span>
                <span class="eb-stat-lbl">Role Groups</span>
            </div>
        </div>

        {{-- Members grouped by role --}}
        @if ($members->isEmpty())
            <div class="empty-state">
                <p>📋</p>
                <p
                    style="
                        font-size: 1rem;
                        font-weight: 700;
                        color: var(--ink);
                        margin-bottom: 6px;
                    "
                >
                    No members yet
                </p>
                <p>
                    Click
                    <strong>Add Member</strong>
                    to get started.
                </p>
            </div>
        @else
            @foreach ($members as $roleKey => $group)
                <div class="group-label">
                    {{ $roles[$roleKey] ?? ucwords(str_replace('_', ' ', $roleKey)) }}
                    <span
                        style="
                            font-size: 0.62rem;
                            color: var(--border-dk);
                            font-weight: 600;
                        "
                    >
                        {{ $group->count() }}
                    </span>
                </div>
                <div class="member-grid" style="margin-bottom: 8px">
                    @foreach ($group as $member)
                        <div
                            class="member-card {{ $member->is_active ? '' : 'inactive' }}"
                        >
                            <div class="member-avatar">
                                {{ $member->initials }}
                            </div>
                            <div class="member-info">
                                <div class="member-name">
                                    {{ $member->full_name }}
                                </div>
                                <div class="member-role-badge">
                                    {{ $member->role_label }}
                                </div>
                                @if ($member->affiliation)
                                    <div class="member-affil">
                                        {{ $member->affiliation }}
                                    </div>
                                @endif

                                @if ($member->location)
                                    <div class="member-loc">
                                        📍 {{ $member->location }}
                                    </div>
                                @endif

                                @if ($member->expertise)
                                    <div
                                        style="
                                            font-size: 0.72rem;
                                            color: var(--teal);
                                            margin-top: 4px;
                                            font-weight: 600;
                                        "
                                    >
                                        {{ $member->expertise }}
                                    </div>
                                @endif
                            </div>
                            <div class="member-actions">
                                {{-- Toggle active --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.editorial-board.toggle', $member) }}"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="btn-icon {{ $member->is_active ? 'toggle-active' : 'toggle-inactive' }}"
                                        title="{{ $member->is_active ? 'Hide from public' : 'Show on public' }}"
                                    >
                                        @if ($member->is_active)
                                            <svg
                                                width="14"
                                                height="14"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                />
                                            </svg>
                                        @else
                                            <svg
                                                width="14"
                                                height="14"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                                                />
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin.editorial-board.edit', $member) }}"
                                    class="btn-icon"
                                    title="Edit"
                                >
                                    <svg
                                        width="14"
                                        height="14"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                        />
                                    </svg>
                                </a>
                                {{-- Delete --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.editorial-board.destroy', $member) }}"
                                    onsubmit="
                                        return confirm(
                                            'Remove {{ addslashes($member->name) }}?',
                                        );
                                    "
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn-icon danger"
                                        title="Remove"
                                    >
                                        <svg
                                            width="14"
                                            height="14"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
@endsection
