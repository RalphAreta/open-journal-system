@extends('layouts.app')

@section('title', 'Submit Manuscript')

@push('styles')
    <style>
        .field:focus {
            outline: none;
            border-color: #2d8176 !important;
            background: #fff !important;
            box-shadow: 0 0 0 3px rgba(45, 129, 118, 0.12);
        }
        select {
            appearance: none;
            -webkit-appearance: none;
        }
        .fu {
            animation: fu 0.45s ease both;
        }
        .fu1 {
            animation: fu 0.45s 0.07s ease both;
        }
        .fu2 {
            animation: fu 0.45s 0.14s ease both;
        }
        .fu3 {
            animation: fu 0.45s 0.21s ease both;
        }
        .fu4 {
            animation: fu 0.45s 0.28s ease both;
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
        .dropzone:hover .dropzone-icon,
        .dropzone.dragover .dropzone-icon {
            transform: translateY(-3px);
        }
        .dropzone.dragover {
            border-color: #2d8176;
            background-color: #e8f4f2;
        }
        .sim-warning {
            background: #fffbeb;
            border: 1.5px solid #fde68a;
            border-radius: 10px;
            padding: 14px 16px;
        }
        .sim-item {
            background: #fff;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 10px 14px;
            margin-top: 8px;
        }
    </style>
@endpush

@section('content')
    <div
        class="font-['Source_Sans_3',sans-serif] text-[#1a1209] max-w-7xl mx-auto px-4 sm:px-6"
        style="
            background-color: #faf6ef;
            background-image: radial-gradient(
                ellipse 80% 50% at 50% -10%,
                rgba(45, 129, 118, 0.08) 0%,
                transparent 70%
            );
        "
    >
        {{-- ── Page Header ── --}}
        <div
            class="relative pt-8 sm:pt-10 pb-6 sm:pb-7 mb-7 sm:mb-9 border-b border-[#e8dfd0] fu"
        >
            <div
                class="absolute bottom-[-1px] left-0 w-20 h-[3px]"
                style="background: linear-gradient(90deg, #2d8176, transparent)"
            ></div>

            <nav
                class="flex items-center gap-2 mb-3 text-[11px] font-bold tracking-[.18em] uppercase text-[#6b5740]"
            >
                <a
                    href="{{ route('submissions.index') }}"
                    class="hover:text-[#2d8176] transition-colors"
                >
                    Dashboard
                </a>
                <svg
                    class="w-3 h-3"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path d="M9 5l7 7-7 7" stroke-width="2.5" />
                </svg>
                <span class="text-[#1a1209]">New Submission</span>
            </nav>

            <p
                class="flex items-center gap-2 mb-2 text-[11px] font-bold tracking-[.2em] uppercase text-[#2d8176]"
            >
                <span class="inline-block w-6 h-px bg-[#2d8176]"></span>
                Author Workspace
            </p>

            <h1
                class="font-['Libre_Baskerville',serif] text-[1.9rem] sm:text-[2.4rem] font-bold text-[#1a1209] leading-tight tracking-tight"
            >
                Submit Your
                <em class="italic text-[#2d8176]">Research</em>
            </h1>
            <p class="mt-2 text-[.95rem] sm:text-[.98rem] text-[#6b5740]">
                Join our global community of researchers. Ensure all fields are
                accurate before submitting.
            </p>
        </div>

        {{-- ── Active Submission Block ── --}}
        @if (isset($isLimitReached) && $isLimitReached)
            <div class="mb-8 fu">
                <div
                    class="bg-white border-2 border-amber-300 rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(217,119,6,.12)]"
                >
                    <div
                        class="flex items-start sm:items-center gap-3 sm:gap-4 px-5 sm:px-7 py-4 bg-amber-50 border-b border-amber-200"
                    >
                        <div
                            class="w-10 h-10 rounded-xl bg-amber-100 border border-amber-300 flex items-center justify-center shrink-0"
                        >
                            <svg
                                class="w-5 h-5 text-amber-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p
                                class="text-[.7rem] font-extrabold tracking-[.16em] uppercase text-amber-600 mb-0.5"
                            >
                                Submission Limit Reached
                            </p>
                            <p
                                class="text-[.95rem] sm:text-[1rem] font-bold text-amber-900"
                            >
                                You have reached the maximum of 2 active
                                submissions
                            </p>
                        </div>
                    </div>

                    <div class="px-5 sm:px-7 py-5 sm:py-6">
                        <p
                            class="text-[.9rem] text-[#6b5740] mb-5 leading-relaxed"
                        >
                            Our policy allows
                            <strong class="text-[#1a1209]">
                                up to 2 active manuscripts per author
                            </strong>
                            at a time. You may submit a new manuscript once one
                            of your current submissions has been
                            <strong class="text-emerald-700">published</strong>
                            or
                            <strong class="text-red-600">rejected</strong>
                            .
                        </p>

                        <div
                            class="bg-[#faf6ef] border border-[#e8dfd0] rounded-xl p-4 sm:p-5 space-y-3"
                        >
                            <p
                                class="text-[.65rem] font-extrabold tracking-[.16em] uppercase text-[#6b5740]"
                            >
                                Your Active Submissions
                            </p>
                            @foreach ($activeSubmissions as $activeSub)
                                <div
                                    class="bg-white border border-[#e8dfd0] rounded-lg p-3"
                                >
                                    <p
                                        class="font-['Libre_Baskerville',serif] text-[.95rem] font-bold text-[#1a1209] mb-2 leading-snug"
                                    >
                                        {{ $activeSub->title }}
                                    </p>
                                    <div
                                        class="flex flex-wrap items-center gap-3"
                                    >
                                        @php
                                            $sc =
                                                $statusColors[$activeSub->status] ??
                                                'bg-slate-50 border-slate-200 text-slate-600';
                                        @endphp

                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[.68rem] font-extrabold tracking-[.06em] uppercase {{ $sc }}"
                                        >
                                            <span
                                                class="w-1.5 h-1.5 rounded-full bg-current opacity-70 inline-block"
                                            ></span>
                                            {{ \App\Models\Submission::statusOptions()[$activeSub->status] ?? $activeSub->status }}
                                        </span>
                                        <span
                                            class="text-[.75rem] text-[#6b5740]"
                                        >
                                            Submitted
                                            {{ $activeSub->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-5 flex flex-wrap items-center gap-3">
                            <a
                                href="{{ route('submissions.index') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#2d8176] hover:bg-[#1a4d46] text-white text-[.75rem] font-bold tracking-[.08em] uppercase transition-all shadow-[0_2px_10px_rgba(45,129,118,.25)] hover:-translate-y-0.5"
                            >
                                <svg
                                    class="w-3.5 h-3.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"
                                    />
                                </svg>
                                View My Submissions
                            </a>
                            <a
                                href="{{ route('submissions.index') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#f3ece0] hover:bg-[#e8dfd0] text-[#6b5740] text-[.75rem] font-bold tracking-[.08em] uppercase border border-[#c9b99a] transition-all"
                            >
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- ── Normal Form ── --}}
            <form
                method="POST"
                action="{{ route('submissions.store') }}"
                enctype="multipart/form-data"
                class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8"
                id="submission-form"
            >
                @csrf

                {{-- ════ LEFT: Form ════ --}}
                <div class="lg:col-span-8 space-y-6">
                    {{-- Similar articles warning --}}
                    @if (isset($similarSubmissions) && $similarSubmissions->isNotEmpty())
                        <div class="sim-warning fu">
                            <div class="flex items-start gap-3 mb-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-amber-100 border border-amber-300 flex items-center justify-center shrink-0 mt-0.5"
                                >
                                    <svg
                                        class="w-4 h-4 text-amber-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <p
                                        class="text-[.72rem] font-extrabold tracking-[.14em] uppercase text-amber-700 mb-0.5"
                                    >
                                        Similar Articles Detected
                                    </p>
                                    <p
                                        class="text-[.88rem] text-amber-900 leading-relaxed"
                                    >
                                        We found
                                        {{ $similarSubmissions->count() }}
                                        submission(s) with a similar title or
                                        topic already in our system. Please
                                        review them before proceeding to avoid
                                        duplication.
                                    </p>
                                </div>
                            </div>
                            @foreach ($similarSubmissions as $sim)
                                <div class="sim-item">
                                    <p
                                        class="text-[.85rem] font-bold text-[#1a1209] leading-snug mb-1"
                                    >
                                        {{ $sim->title }}
                                    </p>
                                    <div
                                        class="flex flex-wrap items-center gap-2"
                                    >
                                        <span
                                            class="text-[.68rem] font-bold uppercase tracking-[.06em] bg-amber-50 border border-amber-200 text-amber-700 px-2.5 py-0.5 rounded-full"
                                        >
                                            {{ \App\Models\Submission::statusOptions()[$sim->status] ?? $sim->status }}
                                        </span>
                                        @if ($sim->research_field)
                                            <span
                                                class="text-[.68rem] font-bold uppercase tracking-[.06em] bg-blue-50 border border-blue-200 text-blue-600 px-2.5 py-0.5 rounded-full"
                                            >
                                                {{ $sim->research_field }}
                                            </span>
                                        @endif

                                        <span
                                            class="text-[.72rem] text-[#6b5740]"
                                        >
                                            Submitted
                                            {{ $sim->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach

                            <p
                                class="mt-3 text-[.78rem] text-amber-700 leading-relaxed"
                            >
                                If your manuscript is
                                <strong>genuinely different</strong>
                                from the above, you may proceed. Otherwise,
                                consider revising your title or abstract to
                                clearly distinguish your work, or contact the
                                editorial office.
                            </p>
                            <label
                                class="flex items-start gap-3 mt-4 cursor-pointer group"
                            >
                                <input
                                    type="checkbox"
                                    id="sim-ack"
                                    name="similarity_acknowledged"
                                    value="1"
                                    class="mt-0.5 w-4 h-4 accent-amber-600 cursor-pointer shrink-0"
                                />
                                <span
                                    class="text-[.82rem] font-semibold text-amber-900 leading-relaxed group-hover:text-amber-700"
                                >
                                    I have reviewed the similar submissions
                                    above and confirm my manuscript is
                                    <strong>original and distinct</strong>
                                    from those listed.
                                </span>
                            </label>
                        </div>
                    @endif

                    {{-- ── Card 01: Core Information ── --}}
                    <div
                        class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden shadow-[0_2px_16px_rgba(26,18,9,.07)] fu1"
                    >
                        <div
                            class="flex items-center gap-4 px-5 sm:px-7 py-4 bg-[#f3ece0] border-b border-[#e8dfd0]"
                        >
                            <div
                                class="w-[30px] h-[30px] rounded-lg bg-[#2d8176] text-white flex items-center justify-center shrink-0 text-[.68rem] font-extrabold tracking-wider"
                            >
                                01
                            </div>
                            <h2
                                class="font-['Libre_Baskerville',serif] text-[1rem] font-bold text-[#1a1209] tracking-wide flex-1"
                            >
                                Core Information
                            </h2>
                        </div>

                        <div class="px-5 sm:px-7 py-5 sm:py-7 space-y-6">
                            {{-- Manuscript Title --}}
                            <div>
                                <label
                                    for="title"
                                    class="block mb-[7px] text-[.7rem] font-bold tracking-[.12em] uppercase text-[#6b5740]"
                                >
                                    Manuscript Title
                                    <span class="text-[#2d8176] ml-0.5">*</span>
                                </label>
                                <textarea
                                    name="title"
                                    id="title"
                                    rows="3"
                                    required
                                    class="field w-full px-4 py-3 border rounded-lg bg-[#faf6ef] text-[.95rem] text-[#1a1209] leading-relaxed resize-none transition-all placeholder:text-[#b5a595] {{ $errors->has('title') ? 'border-red-300 bg-red-50' : 'border-[#e8dfd0]' }}"
                                    placeholder="e.g., Quantum Computing Advancements in 2026"
                                >
{{ old('title') }}</textarea
                                >
                                @error('title')
                                    <p
                                        class="mt-1.5 text-[.8rem] text-red-600 font-medium"
                                    >
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Research Field + Keywords --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label
                                        for="research_field"
                                        class="block mb-[7px] text-[.7rem] font-bold tracking-[.12em] uppercase text-[#6b5740]"
                                    >
                                        Research Field
                                        <span class="text-[#2d8176] ml-0.5">
                                            *
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <select
                                            name="research_field"
                                            id="research_field"
                                            required
                                            class="field w-full px-4 py-3 pr-10 border rounded-lg bg-[#faf6ef] text-[.95rem] text-[#1a1209] cursor-pointer transition-all {{ $errors->has('research_field') ? 'border-red-300 bg-red-50' : 'border-[#e8dfd0]' }}"
                                        >
                                            <option value="">
                                                — Select Field —
                                            </option>
                                            @foreach ($fieldOptions as $value => $label)
                                                <option
                                                    value="{{ $value }}"
                                                    {{ old('research_field') === $value ? 'selected' : '' }}
                                                >
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <svg
                                            class="absolute right-3.5 top-1/2 -translate-y-1/2 w-[17px] h-[17px] text-[#6b5740] pointer-events-none"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 9l-7 7-7-7"
                                            />
                                        </svg>
                                    </div>
                                    @error('research_field')
                                        <p
                                            class="mt-1.5 text-[.8rem] text-red-600 font-medium"
                                        >
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        for="keywords"
                                        class="block mb-[7px] text-[.7rem] font-bold tracking-[.12em] uppercase text-[#6b5740]"
                                    >
                                        Keywords
                                    </label>
                                    <input
                                        type="text"
                                        name="keywords"
                                        id="keywords"
                                        value="{{ old('keywords') }}"
                                        class="field w-full px-4 py-3 border border-[#e8dfd0] rounded-lg bg-[#faf6ef] text-[.95rem] text-[#1a1209] transition-all placeholder:text-[#b5a595]"
                                        placeholder="e.g., Quantum, AI, Physics"
                                    />
                                </div>
                            </div>

                            {{-- Abstract --}}
                            <div>
                                <label
                                    for="abstract"
                                    class="block mb-[7px] text-[.7rem] font-bold tracking-[.12em] uppercase text-[#6b5740]"
                                >
                                    Abstract
                                    <span class="text-[#2d8176] ml-0.5">*</span>
                                </label>
                                <textarea
                                    name="abstract"
                                    id="abstract"
                                    rows="7"
                                    required
                                    class="field w-full px-4 py-3 border rounded-lg bg-[#faf6ef] text-[.95rem] text-[#1a1209] leading-relaxed resize-y transition-all placeholder:text-[#b5a595] {{ $errors->has('abstract') ? 'border-red-300 bg-red-50' : 'border-[#e8dfd0]' }}"
                                    placeholder="Provide a concise summary of your research (max 300 words)…"
                                >
{{ old('abstract') }}</textarea
                                >
                                @error('abstract')
                                    <p
                                        class="mt-1.5 text-[.8rem] text-red-600 font-medium"
                                    >
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── Card 02: Authors & Affiliations ── --}}
                    <div
                        class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden shadow-[0_2px_16px_rgba(26,18,9,.07)] fu2"
                    >
                        <div
                            class="flex items-center gap-4 px-5 sm:px-7 py-4 bg-[#f3ece0] border-b border-[#e8dfd0]"
                        >
                            <div
                                class="w-[30px] h-[30px] rounded-lg bg-[#2d8176] text-white flex items-center justify-center shrink-0 text-[.68rem] font-extrabold tracking-wider"
                            >
                                02
                            </div>
                            <h2
                                class="font-['Libre_Baskerville',serif] text-[1rem] font-bold text-[#1a1209] tracking-wide flex-1"
                            >
                                Authors &amp; Affiliations
                            </h2>
                        </div>

                        <div class="px-5 sm:px-7 py-5 sm:py-7">
                            <p
                                class="text-[.82rem] text-[#6b5740] mb-4 leading-relaxed"
                            >
                                Add all contributing authors in order. Each
                                author can have multiple affiliations.
                            </p>

                            <div id="authors-list" class="space-y-4"></div>

                            <button
                                type="button"
                                onclick="addAuthor()"
                                class="mt-4 flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border-2 border-dashed border-[#c9b99a] text-[.78rem] font-bold text-[#6b5740] hover:border-[#2d8176] hover:text-[#2d8176] hover:bg-[#e8f4f2] transition-all"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>
                                Add Another Author
                            </button>

                            @error('authors')
                                <p
                                    class="mt-2 text-[.8rem] text-red-600 font-medium"
                                >
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- ── Card 03: File Upload ── --}}
                    <div
                        class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden shadow-[0_2px_16px_rgba(26,18,9,.07)] fu2"
                    >
                        <div
                            class="flex items-center gap-4 px-5 sm:px-7 py-4 bg-[#f3ece0] border-b border-[#e8dfd0]"
                        >
                            <div
                                class="w-[30px] h-[30px] rounded-lg bg-[#2d8176] text-white flex items-center justify-center shrink-0 text-[.68rem] font-extrabold tracking-wider"
                            >
                                02
                            </div>
                            <h2
                                class="font-['Libre_Baskerville',serif] text-[1rem] font-bold text-[#1a1209] tracking-wide flex-1"
                            >
                                Manuscript File
                            </h2>
                        </div>

                        <div class="px-5 sm:px-7 py-5 sm:py-7">
                            <div
                                class="dropzone relative cursor-pointer border-2 border-dashed border-[#c9b99a] rounded-[10px] bg-[#faf6ef] text-center transition-all duration-200 hover:border-[#2d8176] hover:bg-[#e8f4f2] {{ $errors->has('file') ? 'border-red-300' : '' }}"
                                id="dropzone"
                            >
                                <input
                                    type="file"
                                    name="file"
                                    id="file"
                                    accept=".doc,.docx"
                                    required
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                />
                                <div class="py-8 sm:py-10 px-4 sm:px-6">
                                    <div
                                        class="dropzone-icon w-[52px] h-[52px] mx-auto mb-4 bg-white border border-[#c9b99a] rounded-xl flex items-center justify-center shadow-[0_2px_8px_rgba(26,18,9,.06)] transition-transform duration-200"
                                    >
                                        <svg
                                            class="w-6 h-6 text-[#2d8176]"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </div>
                                    <p
                                        class="font-['Libre_Baskerville',serif] text-[.95rem] sm:text-[1rem] font-bold text-[#1a1209] mb-1"
                                    >
                                        Click or drag file to upload
                                    </p>
                                    <p
                                        class="text-[.82rem] sm:text-[.85rem] text-[#6b5740]"
                                    >
                                        DOC or DOCX only — maximum 50 MB
                                    </p>
                                    <div
                                        id="file-name-display"
                                        class="hidden mt-4 items-center gap-2 bg-[#e8f4f2] border border-[rgba(45,129,118,.3)] text-[#1a4d46] text-[.8rem] font-bold px-4 py-1.5 rounded-full max-w-full overflow-hidden"
                                    >
                                        <svg
                                            class="w-4 h-4 shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2.5"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        <span
                                            id="file-name-text"
                                            class="truncate min-w-0"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                            @error('file')
                                <p
                                    class="mt-2 text-center text-[.8rem] text-red-600 font-medium"
                                >
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- ── Action Buttons ── --}}
                    <div
                        class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-1 fu3"
                    >
                        <a
                            href="{{ route('submissions.index') }}"
                            class="text-center px-5 py-3 rounded-lg text-[.82rem] font-semibold tracking-[.06em] uppercase text-[#6b5740] transition-all hover:text-[#1a1209] hover:bg-[#f3ece0]"
                        >
                            Cancel
                        </a>
                        <button
                            type="submit"
                            id="submit-btn"
                            class="relative overflow-hidden inline-flex items-center justify-center gap-2 px-8 py-3 rounded-lg bg-[#2d8176] hover:bg-[#1a4d46] text-white text-[.82rem] font-bold tracking-[.1em] uppercase transition-all duration-150 shadow-[0_4px_14px_rgba(45,129,118,.30)] hover:-translate-y-0.5 hover:shadow-[0_8px_22px_rgba(45,129,118,.36)] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                        >
                            <span
                                class="absolute inset-0 pointer-events-none"
                                style="
                                    background: linear-gradient(
                                        135deg,
                                        rgba(201, 168, 76, 0.18) 0%,
                                        transparent 60%
                                    );
                                "
                            ></span>
                            <svg
                                class="w-4 h-4 relative z-10 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                />
                            </svg>
                            <span class="relative z-10">Submit Manuscript</span>
                        </button>
                    </div>
                </div>

                {{-- ════ RIGHT: Sidebar ════ --}}
                {{-- On mobile: appears above the form cards (reordered via order utilities) --}}
                <div class="lg:col-span-4 order-first lg:order-none fu1">
                    <div
                        class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden shadow-[0_2px_16px_rgba(26,18,9,.07)] lg:sticky lg:top-7"
                    >
                        <div
                            class="px-5 sm:px-6 py-4 bg-[#f3ece0] border-b border-[#e8dfd0]"
                        >
                            <p
                                class="text-[.68rem] font-extrabold tracking-[.16em] uppercase text-[#6b5740]"
                            >
                                Author Checklist
                            </p>
                        </div>

                        <div class="px-5 sm:px-6 py-5">
                            <ul class="divide-y divide-[#e8dfd0]">
                                @foreach ([
                                        'Anonymize the manuscript file for double-blind peer review.',
                                        'The abstract must not exceed 300 words.',
                                        'Ensure all authors are properly acknowledged.',
                                        'Verify references follow the required citation format.',
                                        'Confirm the manuscript has not been submitted elsewhere.'
                                    ]
                                    as $item)
                                    <li
                                        class="flex items-start gap-3 py-3 first:pt-0 last:pb-0"
                                    >
                                        <div
                                            class="mt-0.5 w-5 h-5 rounded-full shrink-0 bg-[#e8f4f2] border border-[rgba(45,129,118,.35)] flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-[10px] h-[10px] text-[#2d8176]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="3"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                        </div>
                                        <p
                                            class="text-[.88rem] text-[#6b5740] leading-[1.55]"
                                        >
                                            {{ $item }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-5 pt-5 border-t border-[#e8dfd0]">
                                <div class="flex items-start gap-2 mb-3">
                                    <svg
                                        class="w-4 h-4 text-amber-500 shrink-0 mt-0.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <p
                                        class="text-[.78rem] font-bold text-amber-700 uppercase tracking-[.08em]"
                                    >
                                        One Submission at a Time
                                    </p>
                                </div>
                                <p
                                    class="text-[.82rem] text-[#6b5740] leading-relaxed mb-4"
                                >
                                    You may only have
                                    <strong class="text-[#1a1209]">
                                        one active manuscript
                                    </strong>
                                    in the system at a time. A new submission
                                    can be made once your current manuscript is
                                    published or rejected.
                                </p>
                                <p
                                    class="text-[.82rem] italic text-[#6b5740] leading-relaxed"
                                >
                                    By submitting, you agree to the journal's
                                    peer-review policy and copyright transfer
                                    agreement.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // ── Authors & Affiliations ──────────────────────────────────────────
        let authorIdx = 0;

        const AUTHOR_ROLES = [
            { value: 'first_author',         label: 'First Author' },
            { value: 'co_author',            label: 'Co-Author' },
            { value: 'corresponding_author', label: 'Corresponding Author' },
            { value: 'secondary_author',     label: 'Secondary Author' },
        ];

        function addAuthor() {
            const list   = document.getElementById('authors-list');
            const idx    = authorIdx++;
            const isFirst = list.children.length === 0;

            const roleOptions = AUTHOR_ROLES
                .map((r, i) => `<option value="${r.value}" ${isFirst && i === 0 ? 'selected' : ''}>${r.label}</option>`)
                .join('');

            const removeBtn = isFirst ? '' : `
                <button type="button" onclick="removeAuthor(this)"
                    class="flex items-center gap-1 text-[.7rem] font-bold text-red-400 hover:text-red-600 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Remove
                </button>`;

            const html = `
            <div class="author-row bg-[#faf6ef] border border-[#e8dfd0] rounded-xl p-4 space-y-3" data-idx="${idx}">
                <div class="flex items-center justify-between">
                    <span class="author-label text-[.68rem] font-extrabold tracking-[.16em] uppercase text-[#2d8176]">
                        Author ${list.children.length + 1}
                    </span>
                    ${removeBtn}
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block mb-1.5 text-[.68rem] font-bold tracking-[.12em] uppercase text-[#6b5740]">
                            Full Name <span class="text-[#2d8176]">*</span>
                        </label>
                        <input type="text" name="authors[${idx}][name]" required
                            placeholder="e.g., Juan dela Cruz"
                            class="field w-full px-4 py-2.5 border border-[#e8dfd0] rounded-lg bg-white text-[.92rem] text-[#1a1209] transition-all placeholder:text-[#b5a595]"/>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-[.68rem] font-bold tracking-[.12em] uppercase text-[#6b5740]">
                            Role <span class="text-[#2d8176]">*</span>
                        </label>
                        <div class="relative">
                            <select name="authors[${idx}][role]" required
                                class="field w-full px-4 py-2.5 pr-9 border border-[#e8dfd0] rounded-lg bg-white text-[.92rem] text-[#1a1209] cursor-pointer transition-all appearance-none">
                                ${roleOptions}
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#6b5740] pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block mb-1.5 text-[.68rem] font-bold tracking-[.12em] uppercase text-[#6b5740]">
                        Affiliation(s) <span class="text-[#2d8176]">*</span>
                    </label>
                    <div class="affiliations-list space-y-2">
                        <div class="affil-row flex gap-2">
                            <input type="text" name="authors[${idx}][affiliations][]" required
                                placeholder="e.g., Batangas State University, Philippines"
                                class="field flex-1 px-4 py-2.5 border border-[#e8dfd0] rounded-lg bg-white text-[.88rem] text-[#1a1209] transition-all placeholder:text-[#b5a595]"/>
                        </div>
                    </div>
                    <button type="button" onclick="addAffiliation(this)"
                        class="mt-2 flex items-center gap-1.5 text-[.72rem] font-bold text-[#2d8176] hover:text-[#1a4d46] transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Affiliation
                    </button>
                </div>
            </div>`;

            list.insertAdjacentHTML('beforeend', html);
            renumberAuthors();
        }

        function removeAuthor(btn) {
            btn.closest('.author-row').remove();
            renumberAuthors();
        }

        function addAffiliation(btn) {
            const affList = btn.previousElementSibling; // .affiliations-list
            const idx     = btn.closest('.author-row').dataset.idx;

            const html = `
            <div class="affil-row flex gap-2">
                <input type="text" name="authors[${idx}][affiliations][]"
                    placeholder="e.g., Research Institute, City"
                    class="field flex-1 px-4 py-2.5 border border-[#e8dfd0] rounded-lg bg-white text-[.88rem] text-[#1a1209] transition-all placeholder:text-[#b5a595]"/>
                <button type="button" onclick="removeAffiliation(this)"
                    class="px-2.5 rounded-lg border border-red-200 text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>`;

            affList.insertAdjacentHTML('beforeend', html);
        }

        function removeAffiliation(btn) {
            btn.closest('.affil-row').remove();
        }

        function renumberAuthors() {
            document.querySelectorAll('.author-row').forEach((row, i) => {
                const label = row.querySelector('.author-label');
                if (label) label.textContent = `Author ${i + 1}`;
            });
        }

        // Mag-init ng isang author on load
        document.addEventListener('DOMContentLoaded', () => addAuthor());
                const fileInput = document.getElementById('file');
                                if (fileInput) {
                                   fileInput.addEventListener('change', function () {
                    const display = document.getElementById('file-name-display');
                    const text    = document.getElementById('file-name-text');
                    if (this.files.length > 0) {
                        const file = this.files[0];
                        const ext  = file.name.split('.').pop().toLowerCase();

                        if (ext === 'pdf') {
                            // I-clear ang file input
                            this.value = '';
                            display.classList.add('hidden');
                            display.style.display = '';

                            Swal.fire({
                                icon: 'error',
                                title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.2rem;font-weight:700;">PDF Not Allowed</span>',
                                html: '<p style="font-size:.88rem;color:#6b5740;line-height:1.6">PDF files are not accepted.<br>Please upload your manuscript in <strong style="color:#1a1209">DOC or DOCX</strong> format only.</p>',
                                confirmButtonText: 'Got it',
                                confirmButtonColor: '#2d8176',
                                customClass: {
                                    popup: 'rounded-2xl',
                                    confirmButton: 'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest',
                                },
                                buttonsStyling: true,
                            });
                            return;
                        }

                        text.textContent = file.name;
                        display.classList.remove('hidden');
                        display.style.display = 'inline-flex';
                    }
                });
                                }

                                const dz = document.getElementById('dropzone');
                                if (dz) {
                                    dz.addEventListener('dragover',  (e) => { e.preventDefault(); dz.classList.add('dragover'); });
                                    dz.addEventListener('dragleave', ()  => dz.classList.remove('dragover'));
                                    dz.addEventListener('drop',      ()  => dz.classList.remove('dragover'));
                                }

                                (function () {
                                    const titleEl   = document.getElementById('title');
                                    const submitBtn = document.getElementById('submit-btn');
                                    if (!titleEl) return;

                                    let debounceTimer = null;
                                    let liveWarning   = null;

                                    titleEl.addEventListener('input', () => {
                                        clearTimeout(debounceTimer);
                                        debounceTimer = setTimeout(runCheck, 800);
                                    });

                                    async function runCheck() {
                                        const title    = titleEl.value.trim();
                                        const abstract = document.getElementById('abstract')?.value?.trim() ?? '';
                                        if (title.length < 10) { clearWarning(); return; }
                                        try {
                                            const res  = await fetch(
                                                `{{ route('submissions.check-similarity') }}?title=${encodeURIComponent(title)}&abstract=${encodeURIComponent(abstract)}`,
                                                { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
                                            );
                                            const data = await res.json();
                                            if (data.similar && data.similar.length > 0) renderWarning(data.similar);
                                            else clearWarning();
                                        } catch (e) {}
                                    }

                                    function renderWarning(similar) {
                                        if (!liveWarning) {
                                            liveWarning = document.createElement('div');
                                            liveWarning.id = 'live-sim-warning';
                                            const leftCol = document.querySelector('.lg\\:col-span-8');
                                            if (leftCol) leftCol.prepend(liveWarning);
                                        }
                                        const items = similar.map(s => `
                                            <div class="sim-item">
                                                <p style="font-size:.85rem;font-weight:700;color:#1a1209;margin-bottom:4px">${s.title}</p>
                                                <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;background:#fffbeb;border:1px solid #fde68a;color:#b45309;padding:2px 8px;border-radius:999px">${s.status}</span>
                                                ${s.research_field ? `<span style="font-size:.68rem;font-weight:700;text-transform:uppercase;background:#eff6ff;border:1px solid #bfdbfe;color:#2563eb;padding:2px 8px;border-radius:999px;margin-left:4px">${s.research_field}</span>` : ''}
                                                <span style="font-size:.72rem;color:#6b5740;margin-left:6px">${s.created_at}</span>
                                            </div>`).join('');
                                        liveWarning.innerHTML = `
                                            <div class="sim-warning" style="margin-bottom:20px">
                                                <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:8px">
                                                    <svg style="width:18px;height:18px;color:#d97706;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                                    </svg>
                                                    <div>
                                                        <p style="font-size:.7rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:#b45309;margin-bottom:2px">Similar Articles Detected</p>
                                                        <p style="font-size:.88rem;color:#92400e">${similar.length} submission(s) with a similar title found.</p>
                                                    </div>
                                                </div>
                                                ${items}
                                                <label style="display:flex;align-items:flex-start;gap:10px;margin-top:14px;cursor:pointer">
                                                    <input type="checkbox" id="live-sim-ack" name="similarity_acknowledged" value="1"
                                                           style="margin-top:3px;width:16px;height:16px;accent-color:#d97706;cursor:pointer;flex-shrink:0"/>
                                                    <span style="font-size:.82rem;font-weight:600;color:#92400e;line-height:1.5">
                                                        I confirm my manuscript is <strong>original and distinct</strong> from the listed submissions.
                                                    </span>
                                                </label>
                                            </div>`;
                                        if (submitBtn) {
                                            submitBtn.disabled = true;
                                            document.getElementById('live-sim-ack')?.addEventListener('change', function () {
                                                submitBtn.disabled = !this.checked;
                                            });
                                        }
                                    }

                                    function clearWarning() {
                                        if (liveWarning) { liveWarning.remove(); liveWarning = null; }
                                        if (submitBtn && !document.getElementById('sim-ack')) submitBtn.disabled = false;
                                    }
                                })();

                                const simAck    = document.getElementById('sim-ack');
                                const submitBtn = document.getElementById('submit-btn');
                                if (simAck && submitBtn) {
                                    submitBtn.disabled = true;
                                    submitBtn.title = 'Please acknowledge the similar submissions above first.';
                                    simAck.addEventListener('change', function () {
                                        submitBtn.disabled = !this.checked;
                                        submitBtn.title = '';
                                    });
                                }

                                @if(session('success'))
                                Swal.fire({
                                    icon: 'success',
                                    title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Submitted</span>',
                                    html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
                                    confirmButtonText: 'Close', confirmButtonColor: '#2d8176',
                                    customClass: { popup:'rounded-2xl', confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest' },
                                    buttonsStyling: false,
                                });
                                @endif
                                // ── Submit Confirmation ──
                        const submitBtnConfirm = document.getElementById('submit-btn');
                        if (submitBtnConfirm) {
                            submitBtnConfirm.addEventListener('click', function (e) {
                                // Huwag mag-confirm kung disabled (similarity check)
                                if (this.disabled) return;

                                e.preventDefault();

                                const title    = document.getElementById('title')?.value?.trim() || 'Untitled';
                                const field    = document.getElementById('research_field');
                                const fieldTxt = field?.options[field.selectedIndex]?.text || 'Not specified';
                                const file     = document.getElementById('file')?.files[0];
                                const fileName = file ? file.name : 'No file selected';

                                Swal.fire({
                                    title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.2rem;font-weight:700;">Submit Manuscript?</span>',
                                    html: `
                                        <p style="font-size:.85rem;color:#6b5740;margin-bottom:14px;line-height:1.6">
                                            Are you sure you want to submit this manuscript? 
                                        </p>

                                        <p style="font-size:.76rem;color:#b5a595;margin-top:12px;line-height:1.5">
                                            Once submitted, your manuscript will go through initial screening before peer review.
                                        </p>`,
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, Submit',
                                    cancelButtonText: 'Go Back',
                                    reverseButtons: true,
                                    customClass: {
                                        popup:         'rounded-2xl',
                                        confirmButton: 'rounded-lg px-6 py-2.5 text-xs font-bold uppercase tracking-widest',
                                        cancelButton:  'rounded-lg px-6 py-2.5 text-xs font-bold uppercase tracking-widest',
                                    },
                                    confirmButtonColor: '#2d8176',
                                    cancelButtonColor:  '#f3ece0',
                                    buttonsStyling: true,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('submission-form').submit();
                                    }
                                });
                            });
                        }
    </script>
@endpush
