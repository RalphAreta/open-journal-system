@push('styles')
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --teal-lt: #e8f4f2;
            --gold-dk: #8a6e28;
            --red: #c0392b;
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

        .form-wrap {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--ink);
            max-width: 680px;
            margin: 0 auto;
            padding: 0 16px 60px;
        }
        .form-hero {
            padding: 24px 0 18px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 28px;
            position: relative;
        }
        .form-hero::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--teal), transparent);
        }
        .form-eyebrow {
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
        .form-eyebrow::before {
            content: '';
            width: 22px;
            height: 1px;
            background: var(--teal);
        }
        .form-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-weight: 700;
            color: var(--ink);
        }
        .form-title em {
            font-style: italic;
            color: var(--teal);
        }

        .form-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 16px rgba(45, 129, 118, 0.07);
        }
        .field-group {
            margin-bottom: 20px;
        }
        .field-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 7px;
            display: block;
        }
        .field-required::after {
            content: ' *';
            color: var(--teal);
        }
        .field-input {
            width: 100%;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 11px 14px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.92rem;
            color: var(--ink);
            outline: none;
            transition:
                border-color 0.15s,
                box-shadow 0.15s;
        }
        .field-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.1);
            background: #fff;
        }
        .field-textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6;
        }
        .field-hint {
            font-size: 0.75rem;
            color: var(--border-dk);
            margin-top: 5px;
        }
        .field-error {
            font-size: 0.75rem;
            color: var(--red);
            margin-top: 5px;
        }

        .field-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b5740' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 560px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }

        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .toggle-track {
            width: 44px;
            height: 24px;
            border-radius: 20px;
            background: var(--border-dk);
            position: relative;
            cursor: pointer;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .toggle-track.on {
            background: var(--teal);
        }
        .toggle-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            position: absolute;
            top: 3px;
            left: 3px;
            transition: left 0.2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }
        .toggle-track.on .toggle-thumb {
            left: 23px;
        }
        .toggle-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink);
        }

        .section-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 24px 0;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            flex-wrap: wrap;
        }
        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--teal);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 13px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(45, 129, 118, 0.28);
            transition:
                background 0.15s,
                transform 0.12s;
        }
        .btn-save:hover {
            background: var(--teal-dk);
            transform: translateY(-1px);
        }
        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--ink-soft);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 13px 22px;
            border-radius: 8px;
            border: 1.5px solid var(--border-dk);
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-cancel:hover {
            border-color: var(--teal);
            color: var(--teal);
            background: var(--teal-lt);
        }

        /* New category input toggle */
        .new-cat-wrap {
            margin-top: 8px;
            display: none;
        }
        .new-cat-wrap.show {
            display: block;
        }
        .new-cat-link {
            font-size: 0.75rem;
            color: var(--teal);
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
            display: inline-block;
            margin-top: 6px;
        }
    </style>
@endpush

<div class="form-wrap">
    <div class="form-hero">
        <p class="form-eyebrow">Admin · FAQ Management</p>
        <h1 class="form-title">
            {{ isset($faq) ? 'Edit' : 'Add' }}
            <em>FAQ</em>
        </h1>
    </div>

    <form
        method="POST"
        action="{{ isset($faq) ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}"
    >
        @csrf
        @if (isset($faq))
            @method('PUT')
        @endif

        <div class="form-card">
            {{-- Category --}}
            <div class="field-group">
                <label class="field-label field-required" for="category">
                    Category
                </label>
                @php
                    $currentCat = old('category', $faq?->category ?? '');
                @endphp

                <select
                    class="field-input field-select"
                    id="category-select"
                    name="category_select"
                >
                    <option
                        value=""
                        disabled
                        {{ $currentCat ? '' : 'selected' }}
                    >
                        — Select a category —
                    </option>
                    @foreach ($categories as $cat)
                        <option
                            value="{{ $cat }}"
                            {{ $currentCat === $cat ? 'selected' : '' }}
                        >
                            {{ $cat }}
                        </option>
                    @endforeach

                    <option value="__new__">+ Add new category…</option>
                </select>
                <div
                    class="new-cat-wrap {{ ! $currentCat || $categories->contains($currentCat) ? '' : 'show' }}"
                    id="new-cat-wrap"
                >
                    <input
                        class="field-input"
                        id="new-category"
                        placeholder="Type new category name…"
                        value="{{ ! $categories->contains($currentCat) ? $currentCat : '' }}"
                    />
                    <span class="new-cat-link" onclick="useExisting()">
                        ← Use existing category instead
                    </span>
                </div>
                {{-- Hidden real input --}}
                <input
                    type="hidden"
                    name="category"
                    id="category-final"
                    value="{{ $currentCat }}"
                />
                @error('category')
                    <p class="field-error">{{ $message }}</p>
                @enderror

                <p class="field-hint">
                    Groups this FAQ under a section heading in the panel.
                </p>
            </div>

            <hr class="section-divider" />

            {{-- Question --}}
            <div class="field-group">
                <label class="field-label field-required" for="question">
                    Question
                </label>
                <input
                    class="field-input"
                    id="question"
                    name="question"
                    required
                    value="{{ old('question', $faq?->question) }}"
                    placeholder="e.g. How do I submit a manuscript?"
                />
                @error('question')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Answer --}}
            <div class="field-group">
                <label class="field-label field-required" for="answer">
                    Answer
                </label>
                <textarea
                    class="field-input field-textarea"
                    id="answer"
                    name="answer"
                    required
                    placeholder='Write the full answer here. You can use plain text or basic HTML like &lt;strong&gt;, &lt;a href="..."&gt;.'
                >
{{ old('answer', $faq?->answer) }}</textarea
                >
                @error('answer')
                    <p class="field-error">{{ $message }}</p>
                @enderror

                <p class="field-hint">
                    Basic HTML is supported: &lt;strong&gt;, &lt;a
                    href="..."&gt;, &lt;em&gt;.
                </p>
            </div>

            <hr class="section-divider" />

            {{-- Sort order & Visibility --}}
            <div class="two-col">
                <div class="field-group">
                    <label class="field-label" for="sort_order">
                        Display Order
                    </label>
                    <input
                        class="field-input"
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        min="0"
                        value="{{ old('sort_order', $faq?->sort_order ?? 0) }}"
                    />
                    <p class="field-hint">
                        Lower = appears first within its category.
                    </p>
                </div>
                <div class="field-group">
                    <label class="field-label">Visibility</label>
                    <div class="toggle-wrap" style="margin-top: 10px">
                        @php
                            $isActive = old('is_active', $faq?->is_active ?? true);
                        @endphp

                        <div
                            class="toggle-track {{ $isActive ? 'on' : '' }}"
                            id="toggle-track"
                            onclick="toggleActive()"
                        >
                            <div class="toggle-thumb"></div>
                        </div>
                        <span class="toggle-label" id="toggle-label">
                            {{ $isActive ? 'Visible on public page' : 'Hidden from public page' }}
                        </span>
                        <input
                            type="hidden"
                            name="is_active"
                            id="is_active"
                            value="{{ $isActive ? '1' : '0' }}"
                        />
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-save">
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
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                    {{ isset($faq) ? 'Save Changes' : 'Add FAQ' }}
                </button>
                <a href="{{ route('admin.faqs.index') }}" class="btn-cancel">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    // Toggle visibility
    function toggleActive() {
        const track = document.getElementById('toggle-track');
        const input = document.getElementById('is_active');
        const label = document.getElementById('toggle-label');
        const isOn = track.classList.toggle('on');
        input.value = isOn ? '1' : '0';
        label.textContent = isOn
            ? 'Visible on public page'
            : 'Hidden from public page';
    }

    // Category logic
    const catSelect = document.getElementById('category-select');
    const newCatWrap = document.getElementById('new-cat-wrap');
    const newCatInput = document.getElementById('new-category');
    const finalInput = document.getElementById('category-final');

    function syncFinal() {
        if (catSelect.value === '__new__') {
            finalInput.value = newCatInput.value.trim();
        } else {
            finalInput.value = catSelect.value;
        }
    }

    catSelect.addEventListener('change', () => {
        if (catSelect.value === '__new__') {
            newCatWrap.classList.add('show');
            newCatInput.focus();
        } else {
            newCatWrap.classList.remove('show');
        }
        syncFinal();
    });

    newCatInput.addEventListener('input', syncFinal);

    function useExisting() {
        catSelect.value = '';
        newCatWrap.classList.remove('show');
        finalInput.value = '';
    }

    // Init on load
    syncFinal();
    if (catSelect.value === '' && newCatInput.value) {
        catSelect.value = '__new__';
        newCatWrap.classList.add('show');
    }
</script>
