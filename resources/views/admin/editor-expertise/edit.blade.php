@extends('layouts.app')

@section('title', 'Edit Expertise: ' . $user->name)

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal: #2d8176;
            --teal-dark: #1a4d46;
            --teal-light: #e8f4f2;
            --ink: #1a1209;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
            --muted: #64748b;
            --white: #ffffff;
            --red: #dc2626;
        }

        * {
            box-sizing: border-box;
        }

        .aw {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
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

        /* ── Hero Header ── */
        .hero-header {
            position: relative;
            padding: 44px 0 32px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 32px;
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
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #c9b99a;
            text-decoration: none;
            margin-bottom: 16px;
            transition: color 0.15s;
        }
        .back-link:hover {
            color: var(--teal);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fu {
            animation: fadeUp 0.4s ease both;
        }
        .fu1 {
            animation: fadeUp 0.4s 0.07s ease both;
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
        }

        /* ── Section label ── */
        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Expertise field row ── */
        .expertise-field {
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 18px 20px;
            position: relative;
        }

        /* ── Field label ── */
        .field-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: block;
            margin-bottom: 6px;
        }

        /* ── Inputs ── */
        .field-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            background: var(--white);
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
            appearance: none;
        }
        .field-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
        }
        .field-input::placeholder {
            color: #b5a595;
        }
        select.field-input {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%236b5740' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 34px;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 22px;
            border: none;
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            transition:
                transform 0.14s,
                box-shadow 0.14s,
                filter 0.14s;
        }
        .btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }
        .btn-teal {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 2px 10px rgba(45, 129, 118, 0.25);
        }
        .btn-ghost {
            background: var(--parchment);
            color: var(--muted);
            border: 1.5px solid var(--border);
        }
        .btn-ghost:hover {
            color: var(--ink);
            border-color: var(--teal);
            background: var(--white);
            filter: none;
            transform: none;
        }
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            background: var(--teal-light);
            color: var(--teal-dark);
            border: 1.5px solid rgba(45, 129, 118, 0.3);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            transition:
                background 0.15s,
                border-color 0.15s;
        }
        .btn-add:hover {
            background: rgba(45, 129, 118, 0.15);
            border-color: var(--teal);
        }

        /* ── Remove link ── */
        .remove-btn {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #c0392b;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: color 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .remove-btn:hover {
            color: var(--red);
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-4xl mx-auto px-6 pb-16">
        {{-- ── Hero Header ── --}}
        <div class="hero-header fu">
            <a
                href="{{ route('admin.editor-expertise.index') }}"
                class="back-link"
            >
                <svg
                    width="12"
                    height="12"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Back to Expertise
            </a>
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Administration</p>
                    <h1 class="hero-title">
                        Edit
                        <em>Expertise</em>
                    </h1>
                    <p class="hero-sub">
                        {{ $user->name }} &nbsp;·&nbsp; {{ $user->email }}
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

        {{-- ── Form Card ── --}}
        <div class="card fu1">
            <form
                method="POST"
                action="{{ route('admin.editor-expertise.update', $user) }}"
                style="display: flex; flex-direction: column; gap: 24px"
            >
                @csrf
                @method('PUT')

                <div>
                    <div class="section-label">Fields of Expertise</div>

                    <div
                        id="expertise-fields"
                        style="
                            display: flex;
                            flex-direction: column;
                            gap: 12px;
                            margin-bottom: 14px;
                        "
                    >
                        @forelse ($expertise as $expert)
                            <div class="expertise-field">
                                <div
                                    style="
                                        display: grid;
                                        grid-template-columns: 1fr 1fr;
                                        gap: 14px;
                                        margin-bottom: 12px;
                                    "
                                >
                                    <div>
                                        <label class="field-label">
                                            Field Name
                                        </label>
                                        <select
                                            name="expertise[]"
                                            class="field-input"
                                            required
                                        >
                                            <option value="">
                                                — Select a field —
                                            </option>
                                            @foreach ($fieldOptions as $value => $label)
                                                <option
                                                    value="{{ $label }}"
                                                    {{ $expert->field_name === $label ? 'selected' : '' }}
                                                >
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="field-label">
                                            Description
                                            <span
                                                style="
                                                    font-weight: 400;
                                                    text-transform: none;
                                                    letter-spacing: 0;
                                                "
                                            >
                                                (optional)
                                            </span>
                                        </label>
                                        <input
                                            type="text"
                                            name="description[]"
                                            class="field-input"
                                            placeholder="e.g., 5+ years experience"
                                            value="{{ $expert->description }}"
                                        />
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    class="remove-btn remove-expertise-btn"
                                >
                                    <svg
                                        width="11"
                                        height="11"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Remove
                                </button>
                            </div>
                        @empty
                            <div class="expertise-field">
                                <div
                                    style="
                                        display: grid;
                                        grid-template-columns: 1fr 1fr;
                                        gap: 14px;
                                        margin-bottom: 12px;
                                    "
                                >
                                    <div>
                                        <label class="field-label">
                                            Field Name
                                        </label>
                                        <select
                                            name="expertise[]"
                                            class="field-input"
                                        >
                                            <option value="">
                                                — Select a field —
                                            </option>
                                            @foreach ($fieldOptions as $value => $label)
                                                <option value="{{ $label }}">
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="field-label">
                                            Description
                                            <span
                                                style="
                                                    font-weight: 400;
                                                    text-transform: none;
                                                    letter-spacing: 0;
                                                "
                                            >
                                                (optional)
                                            </span>
                                        </label>
                                        <input
                                            type="text"
                                            name="description[]"
                                            class="field-input"
                                            placeholder="e.g., 5+ years experience"
                                        />
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    class="remove-btn remove-expertise-btn"
                                >
                                    <svg
                                        width="11"
                                        height="11"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Remove
                                </button>
                            </div>
                        @endforelse
                    </div>

                    <button
                        type="button"
                        id="add-expertise-btn"
                        class="btn-add"
                    >
                        <svg
                            width="12"
                            height="12"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path d="M12 4v16m8-8H4" />
                        </svg>
                        Add Another Field
                    </button>
                </div>

                {{-- Actions --}}
                <div
                    style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding-top: 20px;
                        border-top: 1px solid var(--border);
                    "
                >
                    <button type="submit" class="btn btn-teal">
                        <svg
                            width="13"
                            height="13"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        Save Changes
                    </button>
                    <a
                        href="{{ route('admin.editor-expertise.index') }}"
                        class="btn btn-ghost"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Store the select options HTML once
        const fieldOptionsHTML = document.querySelector(
            '.expertise-field select',
        ).innerHTML;

        document
            .getElementById('add-expertise-btn')
            .addEventListener('click', function () {
                const newField = document.createElement('div');
                newField.className = 'expertise-field';
                newField.innerHTML = `
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:12px">
                    <div>
                        <label class="field-label">Field Name</label>
                        <select name="expertise[]" class="field-input">
                            ${fieldOptionsHTML}
                        </select>
                    </div>
                    <div>
                        <label class="field-label">Description <span style="font-weight:400;text-transform:none;letter-spacing:0">(optional)</span></label>
                        <input type="text" name="description[]" class="field-input" placeholder="e.g., 5+ years experience">
                    </div>
                </div>
                <button type="button" class="remove-btn remove-expertise-btn">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    Remove
                </button>
            `;
                // Reset select to first option
                newField.querySelector('select').value = '';
                document
                    .getElementById('expertise-fields')
                    .appendChild(newField);
                attachRemoveListeners();
            });

        function attachRemoveListeners() {
            document
                .querySelectorAll('.remove-expertise-btn')
                .forEach((btn) => {
                    btn.onclick = function () {
                        if (
                            document.querySelectorAll('.expertise-field')
                                .length > 1
                        ) {
                            this.closest('.expertise-field').remove();
                        } else {
                            alert(
                                'You must have at least one field of expertise.',
                            );
                        }
                    };
                });
        }

        attachRemoveListeners();
    </script>
@endpush
