@extends('layouts.app')
@section('title', 'FAQ Management — Admin')

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

        .faq-wrap {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 16px 60px;
        }

        /* Hero */
        .faq-hero {
            padding: 28px 0 20px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 28px;
            position: relative;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .faq-hero::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .faq-eyebrow {
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
        .faq-eyebrow::before {
            content: '';
            width: 22px;
            height: 1px;
            background: var(--teal);
        }
        .faq-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1.15;
        }
        .faq-title em {
            font-style: italic;
            color: var(--teal);
        }
        .faq-sub {
            font-size: 0.9rem;
            color: var(--ink-soft);
            margin-top: 6px;
        }

        /* Stats */
        .faq-stats {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        .faq-stat {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px 20px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 100px;
        }
        .faq-stat-val {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1;
            color: var(--teal);
        }
        .faq-stat-lbl {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }

        /* Add button */
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
            white-space: nowrap;
            margin-top: 8px;
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
        .group-label:first-of-type {
            margin-top: 0;
        }

        /* FAQ rows */
        .faq-table {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 8px;
        }
        .faq-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 18px;
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
            position: relative;
        }
        .faq-row:last-child {
            border-bottom: none;
        }
        .faq-row:hover {
            background: var(--cream);
        }
        .faq-row.inactive {
            opacity: 0.5;
        }

        .faq-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--teal-lt);
            border: 1px solid rgba(45, 129, 118, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 800;
            color: var(--teal);
            flex-shrink: 0;
            margin-top: 2px;
        }
        .faq-content {
            flex: 1;
            min-width: 0;
        }
        .faq-question {
            font-family: 'Libre Baskerville', serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.4;
            margin-bottom: 4px;
        }
        .faq-answer {
            font-size: 0.8rem;
            color: var(--ink-soft);
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Actions */
        .faq-actions {
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
            color: var(--ink-soft);
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
    </style>
@endpush

@section('content')
    <div class="faq-wrap">
        {{-- Hero --}}
        <div class="faq-hero">
            <div>
                <p class="faq-eyebrow">Admin · Journal System</p>
                <h1 class="faq-title">
                    FAQ
                    <em>Management</em>
                </h1>
                <p class="faq-sub">
                    Manage the frequently asked questions shown on the public
                    landing page.
                </p>
            </div>
            <button type="button" class="btn-add" onclick="openAddModal()">
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
                Add Question
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        {{-- Stats --}}
        <div class="faq-stats">
            <div class="faq-stat">
                <span class="faq-stat-val">{{ $total }}</span>
                <span class="faq-stat-lbl">Total FAQs</span>
            </div>
            <div class="faq-stat">
                <span class="faq-stat-val" style="color: var(--gold-dk)">
                    {{ $active }}
                </span>
                <span class="faq-stat-lbl">Active / Visible</span>
            </div>
            <div class="faq-stat">
                <span class="faq-stat-val" style="color: var(--ink-soft)">
                    {{ $total - $active }}
                </span>
                <span class="faq-stat-lbl">Hidden</span>
            </div>
            <div class="faq-stat">
                <span class="faq-stat-val">{{ $faqs->count() }}</span>
                <span class="faq-stat-lbl">Categories</span>
            </div>
        </div>

        {{-- FAQ list grouped by category --}}
        @if ($faqs->isEmpty())
            <div class="empty-state">
                <p style="font-size: 2.5rem; margin-bottom: 12px">❓</p>
                <p
                    style="
                        font-size: 1rem;
                        font-weight: 700;
                        color: var(--ink);
                        margin-bottom: 6px;
                    "
                >
                    No FAQs yet
                </p>
                <p>
                    Click
                    <strong>Add Question</strong>
                    to get started.
                </p>
            </div>
        @else
            @foreach ($faqs as $category => $items)
                <div class="group-label">
                    {{ $category }}
                    <span
                        style="
                            font-size: 0.62rem;
                            color: var(--border-dk);
                            font-weight: 600;
                        "
                    >
                        {{ $items->count() }}
                    </span>
                </div>
                <div class="faq-table">
                    @foreach ($items as $i => $faq)
                        <div
                            class="faq-row {{ $faq->is_active ? '' : 'inactive' }}"
                        >
                            <div class="faq-num">{{ $i + 1 }}</div>
                            <div class="faq-content">
                                <div class="faq-question">
                                    {{ $faq->question }}
                                </div>
                                <div class="faq-answer">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                            <div class="faq-actions">
                                {{-- Toggle visibility --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.faqs.toggle', $faq) }}"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="btn-icon {{ $faq->is_active ? 'toggle-active' : 'toggle-inactive' }}"
                                        title="{{ $faq->is_active ? 'Hide from public' : 'Show on public' }}"
                                    >
                                        @if ($faq->is_active)
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
                                <button
                                    type="button"
                                    class="btn-icon"
                                    title="Edit"
                                    onclick="
                                        openEditModal(
                                            {{ $faq->id }},
                                            '{{ addslashes($faq->category) }}',
                                            '{{ addslashes($faq->question) }}',
                                            '{{ addslashes(strip_tags($faq->answer)) }}',
                                            {{ $faq->sort_order }},
                                        )
                                    "
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
                                </button>
                                {{-- Delete --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.faqs.destroy', $faq) }}"
                                    onsubmit="
                                        return confirm('Delete this FAQ?');
                                    "
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn-icon danger"
                                        title="Delete"
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
    {{-- ── ADD MODAL ── --}}
    <div
        id="add-modal"
        style="
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 900;
            padding: 24px;
            overflow-y: auto;
        "
    >
        <div
            style="
                background: #fff;
                border-radius: 16px;
                max-width: 580px;
                margin: 40px auto;
                padding: 32px;
            "
        >
            <h2
                style="
                    font-family: 'Libre Baskerville', serif;
                    font-size: 1.2rem;
                    margin-bottom: 20px;
                "
            >
                Add FAQ
            </h2>
            <form method="POST" action="{{ route('admin.faqs.store') }}">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 14px">
                    <div>
                        <label
                            style="
                                font-size: 0.75rem;
                                font-weight: 700;
                                letter-spacing: 0.08em;
                                text-transform: uppercase;
                                color: var(--ink-soft);
                            "
                        >
                            Category
                        </label>
                        <input
                            name="category"
                            required
                            style="
                                width: 100%;
                                margin-top: 6px;
                                padding: 10px 12px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                font-size: 0.9rem;
                            "
                        />
                    </div>
                    <div>
                        <label
                            style="
                                font-size: 0.75rem;
                                font-weight: 700;
                                letter-spacing: 0.08em;
                                text-transform: uppercase;
                                color: var(--ink-soft);
                            "
                        >
                            Question
                        </label>
                        <input
                            name="question"
                            required
                            style="
                                width: 100%;
                                margin-top: 6px;
                                padding: 10px 12px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                font-size: 0.9rem;
                            "
                        />
                    </div>
                    <div>
                        <label
                            style="
                                font-size: 0.75rem;
                                font-weight: 700;
                                letter-spacing: 0.08em;
                                text-transform: uppercase;
                                color: var(--ink-soft);
                            "
                        >
                            Answer (HTML allowed)
                        </label>
                        <textarea
                            name="answer"
                            rows="5"
                            required
                            style="
                                width: 100%;
                                margin-top: 6px;
                                padding: 10px 12px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                font-size: 0.9rem;
                                resize: vertical;
                            "
                        ></textarea>
                    </div>
                    <div>
                        <label
                            style="
                                font-size: 0.75rem;
                                font-weight: 700;
                                letter-spacing: 0.08em;
                                text-transform: uppercase;
                                color: var(--ink-soft);
                            "
                        >
                            Sort Order
                        </label>
                        <input
                            name="sort_order"
                            type="number"
                            value="0"
                            style="
                                width: 100%;
                                margin-top: 6px;
                                padding: 10px 12px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                font-size: 0.9rem;
                            "
                        />
                    </div>
                    <div
                        style="
                            display: flex;
                            gap: 10px;
                            justify-content: flex-end;
                            margin-top: 6px;
                        "
                    >
                        <button
                            type="button"
                            onclick="closeAddModal()"
                            style="
                                padding: 10px 20px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                background: #fff;
                                cursor: pointer;
                                font-size: 0.85rem;
                            "
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            style="
                                padding: 10px 22px;
                                background: var(--teal);
                                color: #fff;
                                border: none;
                                border-radius: 8px;
                                font-weight: 700;
                                cursor: pointer;
                                font-size: 0.85rem;
                            "
                        >
                            Save FAQ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ── EDIT MODAL ── --}}
    <div
        id="edit-modal"
        style="
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 900;
            padding: 24px;
            overflow-y: auto;
        "
    >
        <div
            style="
                background: #fff;
                border-radius: 16px;
                max-width: 580px;
                margin: 40px auto;
                padding: 32px;
            "
        >
            <h2
                style="
                    font-family: 'Libre Baskerville', serif;
                    font-size: 1.2rem;
                    margin-bottom: 20px;
                "
            >
                Edit FAQ
            </h2>
            <form id="edit-faq-form" method="POST">
                @csrf
                @method('PUT')
                <div style="display: flex; flex-direction: column; gap: 14px">
                    <div>
                        <label
                            style="
                                font-size: 0.75rem;
                                font-weight: 700;
                                letter-spacing: 0.08em;
                                text-transform: uppercase;
                                color: var(--ink-soft);
                            "
                        >
                            Category
                        </label>
                        <input
                            id="edit-category"
                            name="category"
                            required
                            style="
                                width: 100%;
                                margin-top: 6px;
                                padding: 10px 12px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                font-size: 0.9rem;
                            "
                        />
                    </div>
                    <div>
                        <label
                            style="
                                font-size: 0.75rem;
                                font-weight: 700;
                                letter-spacing: 0.08em;
                                text-transform: uppercase;
                                color: var(--ink-soft);
                            "
                        >
                            Question
                        </label>
                        <input
                            id="edit-question"
                            name="question"
                            required
                            style="
                                width: 100%;
                                margin-top: 6px;
                                padding: 10px 12px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                font-size: 0.9rem;
                            "
                        />
                    </div>
                    <div>
                        <label
                            style="
                                font-size: 0.75rem;
                                font-weight: 700;
                                letter-spacing: 0.08em;
                                text-transform: uppercase;
                                color: var(--ink-soft);
                            "
                        >
                            Answer (HTML allowed)
                        </label>
                        <textarea
                            id="edit-answer"
                            name="answer"
                            rows="5"
                            required
                            style="
                                width: 100%;
                                margin-top: 6px;
                                padding: 10px 12px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                font-size: 0.9rem;
                                resize: vertical;
                            "
                        ></textarea>
                    </div>
                    <div>
                        <label
                            style="
                                font-size: 0.75rem;
                                font-weight: 700;
                                letter-spacing: 0.08em;
                                text-transform: uppercase;
                                color: var(--ink-soft);
                            "
                        >
                            Sort Order
                        </label>
                        <input
                            id="edit-sort-order"
                            name="sort_order"
                            type="number"
                            style="
                                width: 100%;
                                margin-top: 6px;
                                padding: 10px 12px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                font-size: 0.9rem;
                            "
                        />
                    </div>
                    <div
                        style="
                            display: flex;
                            gap: 10px;
                            justify-content: flex-end;
                            margin-top: 6px;
                        "
                    >
                        <button
                            type="button"
                            onclick="closeEditModal()"
                            style="
                                padding: 10px 20px;
                                border: 1.5px solid var(--border);
                                border-radius: 8px;
                                background: #fff;
                                cursor: pointer;
                                font-size: 0.85rem;
                            "
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            style="
                                padding: 10px 22px;
                                background: var(--teal);
                                color: #fff;
                                border: none;
                                border-radius: 8px;
                                font-weight: 700;
                                cursor: pointer;
                                font-size: 0.85rem;
                            "
                        >
                            Update FAQ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openAddModal() {
                document.getElementById('add-modal').style.display = 'block';
            }
            function closeAddModal() {
                document.getElementById('add-modal').style.display = 'none';
            }

            function openEditModal(id, category, question, answer, sortOrder) {
                document.getElementById('edit-category').value = category;
                document.getElementById('edit-question').value = question;
                document.getElementById('edit-answer').value = answer;
                document.getElementById('edit-sort-order').value = sortOrder;
                document.getElementById('edit-faq-form').action = '/faqs/' + id;
                document.getElementById('edit-modal').style.display = 'block';
            }
            function closeEditModal() {
                document.getElementById('edit-modal').style.display = 'none';
            }

            // Close on backdrop click
            ['add-modal', 'edit-modal'].forEach((id) => {
                document
                    .getElementById(id)
                    .addEventListener('click', function (e) {
                        if (e.target === this) this.style.display = 'none';
                    });
            });
        </script>
    @endpush
@endsection
