@extends('layouts.app')

@section('title', 'Manage Expertise Categories')

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
            --red-light: #fef2f2;
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
        .fu2 {
            animation: fadeUp 0.4s 0.14s ease both;
        }

        /* ── Section label ── */
        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 14px;
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
        .section-label span {
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
            color: #c9b99a;
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.06);
        }

        /* ── Field input ── */
        .field-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: block;
            margin-bottom: 6px;
        }
        .field-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            background: var(--parchment);
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
        }
        .field-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
            background: var(--white);
        }
        .field-input::placeholder {
            color: #b5a595;
        }
        .field-input.error {
            border-color: var(--red);
        }

        /* ── Add button ── */
        .btn-add {
            width: 100%;
            padding: 10px 0;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            transition:
                filter 0.14s,
                transform 0.14s;
            box-shadow: 0 2px 10px rgba(45, 129, 118, 0.25);
        }
        .btn-add:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        /* ── Default category row ── */
        .cat-row-default {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 10px 16px;
            font-size: 13px;
            color: var(--ink);
        }
        .cat-row-default + .cat-row-default {
            margin-top: 6px;
        }

        .badge-default {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            background: var(--cream);
            border: 1px solid var(--border-dk);
            padding: 2px 9px;
            border-radius: 100px;
        }

        /* ── Custom category row ── */
        .cat-row-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: var(--white);
            border: 1px solid var(--border-dk);
            border-radius: 9px;
            padding: 10px 14px;
            transition: border-color 0.15s;
        }
        .cat-row-custom + .cat-row-custom {
            margin-top: 6px;
        }
        .cat-row-custom:hover {
            border-color: var(--teal);
        }
        .cat-row-custom:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.08);
        }

        .cat-edit-input {
            flex: 1;
            padding: 5px 8px;
            border: 1.5px solid transparent;
            border-radius: 6px;
            background: transparent;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            color: var(--ink);
            outline: none;
            transition:
                background 0.14s,
                border-color 0.14s;
        }
        .cat-edit-input:focus {
            background: var(--parchment);
            border-color: var(--border-dk);
        }

        .btn-save-inline {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--teal);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 8px;
            opacity: 0;
            transition: opacity 0.15s;
            white-space: nowrap;
        }
        .cat-row-custom:hover .btn-save-inline,
        .cat-row-custom:focus-within .btn-save-inline {
            opacity: 1;
        }

        .badge-custom {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--teal-dark);
            background: var(--teal-light);
            border: 1px solid rgba(45, 129, 118, 0.3);
            padding: 2px 9px;
            border-radius: 100px;
            flex-shrink: 0;
        }

        .btn-delete {
            background: none;
            border: none;
            cursor: pointer;
            color: #c9b99a;
            font-size: 18px;
            line-height: 1;
            padding: 2px 4px;
            transition: color 0.14s;
            flex-shrink: 0;
        }
        .btn-delete:hover {
            color: var(--red);
        }

        /* ── Empty note ── */
        .empty-note {
            padding: 20px;
            text-align: center;
            font-size: 13px;
            font-style: italic;
            color: #c9b99a;
            background: var(--parchment);
            border: 1px solid var(--border);
            border-radius: 9px;
            margin-top: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-6xl mx-auto px-6 pb-16">
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
                Back to Editor Expertise
            </a>
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
            >
                <div>
                    <p class="hero-eyebrow">Administration</p>
                    <h1 class="hero-title">
                        Expertise
                        <em>Categories</em>
                    </h1>
                    <p class="hero-sub">
                        Manage the list of expertise fields available for
                        editors
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

        {{-- ── Two-column layout ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ── LEFT: Add form ── --}}
            <div class="lg:col-span-1 fu1">
                <div class="card" style="position: sticky; top: 24px">
                    <div class="section-label">Add New Category</div>
                    <p
                        style="
                            font-size: 12px;
                            color: var(--ink-soft);
                            margin-bottom: 18px;
                            line-height: 1.65;
                        "
                    >
                        Custom categories will be marked with a badge and can be
                        edited or deleted later.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.expertise-categories.store') }}"
                        style="display: flex; flex-direction: column; gap: 14px"
                    >
                        @csrf
                        <div>
                            <label for="name" class="field-label">
                                Category Name
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="e.g. Nanotechnology"
                                class="field-input @error('name') error @enderror"
                            />
                            @error('name')
                                <p
                                    style="
                                        font-size: 11px;
                                        color: var(--red);
                                        margin-top: 5px;
                                    "
                                >
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn-add">
                            + Add Category
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── RIGHT: Category list ── --}}
            <div class="lg:col-span-2 fu2">
                {{-- Default categories --}}
                <div class="section-label">
                    Default Categories
                    <span>(cannot be deleted)</span>
                </div>

                @foreach ($categories as $category)
                    @if (! $category->is_custom)
                        <div class="cat-row-default">
                            <span>{{ $category->name }}</span>
                            <span class="badge-default">Default</span>
                        </div>
                    @endif
                @endforeach

                {{-- Custom categories --}}
                @php
                    $customCategories = $categories->filter(fn ($c) => $c->is_custom);
                @endphp

                <div style="margin-top: 28px">
                    <div class="section-label">Custom Categories</div>

                    @if ($customCategories->count() > 0)
                        @foreach ($customCategories as $category)
                            <div class="cat-row-custom">
                                <form
                                    method="POST"
                                    action="{{ route('admin.expertise-categories.update', $category) }}"
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 6px;
                                        flex: 1;
                                        min-width: 0;
                                    "
                                >
                                    @csrf
                                    @method('PUT')
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ $category->name }}"
                                        class="cat-edit-input"
                                    />
                                    <button
                                        type="submit"
                                        class="btn-save-inline"
                                    >
                                        Save
                                    </button>
                                </form>

                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 8px;
                                        flex-shrink: 0;
                                    "
                                >
                                    <span class="badge-custom">Custom</span>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.expertise-categories.destroy', $category) }}"
                                        onsubmit="
                                            return confirm(
                                                'Delete this category?',
                                            );
                                        "
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn-delete"
                                            title="Delete"
                                        >
                                            &times;
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-note">
                            No custom categories yet. Add one using the form on
                            the left.
                        </div>
                    @endif
                </div>

                <div style="margin-top: 20px">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
@endsection
