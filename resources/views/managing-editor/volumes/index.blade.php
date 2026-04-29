@extends('layouts.app')

@section('title', 'Volumes & Issues')

@push('styles')
    <style>
        :root {
            --teal: #2d8176;
            --teal-dk: #1a4d46;
            --teal-lt: #e8f4f2;
            --gold: #c9a84c;
            --gold-lt: #fdf8ec;
            --gold-dk: #8a6e28;
            --ink: #1a1209;
            --ink-soft: #6b5740;
            --cream: #faf6ef;
            --parchment: #f3ece0;
            --border: #e8dfd0;
            --border-dk: #c9b99a;
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
            background-image: radial-gradient(
                ellipse 80% 50% at 50% -10%,
                rgba(45, 129, 118, 0.08) 0%,
                transparent 70%
            );
        }

        /* Header */
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
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.15;
        }
        .hero-title em {
            font-style: italic;
            color: var(--teal);
        }
        .hero-sub {
            font-size: 0.95rem;
            color: var(--ink-soft);
            margin-top: 8px;
        }

        /* Card */
        .card {
            background: #fff;
            border: 1px solid var(--border-dk);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 18, 9, 0.07);
            margin-bottom: 20px;
        }
        .card-head {
            background: var(--parchment);
            border-bottom: 1px solid var(--border);
            padding: 14px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .card-head-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
        }
        .card-body {
            padding: 20px 22px;
        }

        /* Vol badge */
        .vol-badge {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 20px;
            background: var(--teal-lt);
            border: 1px solid rgba(45, 129, 118, 0.3);
            color: var(--teal-dk);
        }
        .vol-year {
            font-size: 0.82rem;
            color: var(--ink-soft);
        }

        /* Issue grid */
        .issue-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
            margin-top: 16px;
        }
        .issue-card {
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            background: var(--cream);
        }
        .issue-card-thumb {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            display: block;
            background: var(--parchment);
        }
        .issue-card-thumb-empty {
            width: 100%;
            aspect-ratio: 3/4;
            background: var(--parchment);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .issue-card-thumb-empty svg {
            width: 36px;
            height: 36px;
            color: #c9b99a;
        }
        .issue-card-body {
            padding: 10px 12px;
            border-top: 1px solid var(--border);
        }
        .issue-card-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--teal);
        }
        .issue-card-sub {
            font-size: 0.8rem;
            color: var(--ink-soft);
            margin-top: 2px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 8px 16px;
            border-radius: 7px;
            border: 1.5px solid;
            cursor: pointer;
            font-family: 'Source Sans 3', sans-serif;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-teal {
            color: var(--teal);
            border-color: rgba(45, 129, 118, 0.35);
            background: none;
        }
        .btn-teal:hover {
            background: var(--teal);
            color: #fff;
        }
        .btn-gold {
            color: var(--gold-dk);
            border-color: rgba(201, 168, 76, 0.4);
            background: none;
        }
        .btn-gold:hover {
            background: var(--gold);
            color: #fff;
        }
        .btn-solid-teal {
            background: var(--teal);
            color: #fff;
            border-color: var(--teal);
        }
        .btn-solid-teal:hover {
            background: var(--teal-dk);
            border-color: var(--teal-dk);
        }

        /* Form panel */
        .form-panel {
            background: var(--parchment);
            border: 1px solid var(--border-dk);
            border-radius: 12px;
            padding: 20px 22px;
            margin-bottom: 20px;
        }
        .form-panel h3 {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            margin: 0 0 16px;
        }
        .field-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }
        .field {
            flex: 1;
            min-width: 120px;
        }
        .field label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: block;
            margin-bottom: 6px;
        }
        .field input[type='number'],
        .field input[type='file'] {
            width: 100%;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            padding: 10px 14px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.9rem;
            color: var(--ink);
            outline: none;
            transition: border-color 0.15s;
        }
        .field input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.1);
        }
        .field input[type='file'] {
            padding: 8px 12px;
            cursor: pointer;
        }

        /* Upload form inside issue card */
        .upload-form {
            padding: 8px 12px 12px;
        }
        .upload-form label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: block;
            margin-bottom: 5px;
        }
        .upload-form input[type='file'] {
            width: 100%;
            font-size: 0.75rem;
            margin-bottom: 8px;
        }

        /* Animations */
        .fu {
            animation: fu 0.4s ease both;
        }
        @keyframes fu {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="aw aw-bg max-w-7xl mx-auto px-4 sm:px-6">
        {{-- Header --}}
        <div class="hero-header fu">
            <p class="hero-eyebrow">Managing Editor</p>
            <h1 class="hero-title">
                Volumes &amp;
                <em>Issues</em>
            </h1>
            <p class="hero-sub">
                Add volumes and upload cover images per issue
            </p>
        </div>

        {{-- Add Volume Form --}}
        <div class="form-panel fu">
            <h3>Add New Volume</h3>
            <form
                method="POST"
                action="{{ route('managing-editor.volumes.store') }}"
            >
                @csrf
                <div class="field-row">
                    <div class="field">
                        <label>Volume No.</label>
                        <input
                            type="number"
                            name="number"
                            placeholder="e.g. 12"
                            min="1"
                            required
                            value="{{ old('number') }}"
                        />
                        @error('number')
                            <p
                                style="
                                    font-size: 0.75rem;
                                    color: #dc2626;
                                    margin-top: 4px;
                                "
                            >
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Year</label>
                        <input
                            type="number"
                            name="year"
                            placeholder="e.g. 2025"
                            min="1900"
                            max="2100"
                            required
                            value="{{ old('year', now()->year) }}"
                        />
                        @error('year')
                            <p
                                style="
                                    font-size: 0.75rem;
                                    color: #dc2626;
                                    margin-top: 4px;
                                "
                            >
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div
                        class="field"
                        style="flex: 0; display: flex; align-items: flex-end"
                    >
                        <button type="submit" class="btn btn-solid-teal">
                            <svg
                                width="12"
                                height="12"
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
                            Create Volume
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Volumes List --}}
        @forelse ($volumes as $volume)
            <div class="card fu">
                <div class="card-head">
                    <div style="display: flex; align-items: center; gap: 12px">
                        <span class="vol-badge">
                            Volume {{ $volume->number }}
                        </span>
                        <span class="vol-year">{{ $volume->year }}</span>
                    </div>

                    {{-- Add Issue Button --}}
                    <button
                        type="button"
                        class="btn btn-gold"
                        onclick="toggleIssueForm('issueForm{{ $volume->id }}')"
                    >
                        <svg
                            width="12"
                            height="12"
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
                        Add Issue
                    </button>
                </div>

                <div class="card-body">
                    {{-- Add Issue Form (hidden by default) --}}
                    <div
                        id="issueForm{{ $volume->id }}"
                        style="
                            display: none;
                            background: var(--parchment);
                            border: 1px solid var(--border);
                            border-radius: 10px;
                            padding: 16px 18px;
                            margin-bottom: 16px;
                        "
                    >
                        <p
                            style="
                                font-size: 0.8rem;
                                font-weight: 700;
                                text-transform: uppercase;
                                letter-spacing: 0.1em;
                                color: var(--ink-soft);
                                margin-bottom: 12px;
                            "
                        >
                            New Issue for Volume {{ $volume->number }}
                        </p>
                        <form
                            method="POST"
                            action="{{ route('managing-editor.issues.store', $volume) }}"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <div class="field-row">
                                <div class="field">
                                    <label>Issue No.</label>
                                    <input
                                        type="number"
                                        name="number"
                                        placeholder="e.g. 1"
                                        min="1"
                                        required
                                    />
                                </div>
                                <div class="field" style="flex: 2">
                                    <label>Cover Image (JPG/PNG)</label>
                                    <input
                                        type="file"
                                        name="cover_image"
                                        accept="image/jpeg,image/png"
                                    />
                                </div>
                            </div>
                            <div style="display: flex; gap: 8px">
                                <button
                                    type="submit"
                                    class="btn btn-solid-teal"
                                >
                                    Save Issue
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-teal"
                                    onclick="
                                        toggleIssueForm(
                                            'issueForm{{ $volume->id }}',
                                        )
                                    "
                                >
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Issues Grid --}}
                    @if ($volume->issues->isEmpty())
                        <p
                            style="
                                font-size: 0.85rem;
                                color: var(--ink-soft);
                                text-align: center;
                                padding: 24px 0;
                            "
                        >
                            No issues yet — click "Add Issue" to create one.
                        </p>
                    @else
                        <div class="issue-grid">
                            @foreach ($volume->issues as $issue)
                                <div class="issue-card">
                                    {{-- Cover image or placeholder --}}

                                    @if ($issue->cover_image)
                                        <img
                                            src="{{ asset('storage/' . $issue->cover_image) }}"
                                            alt="Cover Vol.{{ $volume->number }} Issue {{ $issue->number }}"
                                            class="issue-card-thumb"
                                        />
                                    @else
                                        <div class="issue-card-thumb-empty">
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="issue-card-body">
                                        <p class="issue-card-label">
                                            Issue {{ $issue->number }}
                                        </p>
                                        <p class="issue-card-sub">
                                            Vol. {{ $volume->number }} ·
                                            {{ $volume->year }}
                                        </p>

                                        {{-- Upload / Replace cover --}}
                                        <form
                                            method="POST"
                                            action="{{ route('managing-editor.issues.cover', $issue) }}"
                                            enctype="multipart/form-data"
                                            style="margin-top: 8px"
                                        >
                                            @csrf
                                            <input
                                                type="file"
                                                name="cover_image"
                                                accept="image/jpeg,image/png"
                                                style="
                                                    font-size: 0.72rem;
                                                    width: 100%;
                                                    margin-bottom: 6px;
                                                "
                                                required
                                            />
                                            <button
                                                type="submit"
                                                class="btn btn-gold"
                                                style="
                                                    width: 100%;
                                                    justify-content: center;
                                                    font-size: 0.68rem;
                                                    padding: 6px 10px;
                                                "
                                            >
                                                <svg
                                                    width="11"
                                                    height="11"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                                    />
                                                </svg>
                                                {{ $issue->cover_image ? 'Replace Cover' : 'Upload Cover' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div
                style="
                    text-align: center;
                    padding: 60px 0;
                    color: var(--ink-soft);
                "
            >
                <p style="font-size: 0.85rem">
                    No volumes yet. Create your first volume above.
                </p>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
    <script>
        function toggleIssueForm(id) {
            const el = document.getElementById(id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }

        @if(session('success'))
        Swal.fire({
            icon:'success',
            title:'<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Done</span>',
            html:'<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
            confirmButtonText:'Close', confirmButtonColor:'#2d8176',
            customClass:{popup:'rounded-2xl',confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'},
            buttonsStyling:false,
        });
        @endif
        @if(session('error'))
        Swal.fire({
            icon:'error',
            title:'<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Oops!</span>',
            html:'<p style="font-size:.9rem;color:#6b5740;">{{ session('error') }}</p>',
            confirmButtonText:'Close', confirmButtonColor:'#c9a84c',
            customClass:{popup:'rounded-2xl',confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'},
            buttonsStyling:false,
        });
        @endif
    </script>
@endpush
