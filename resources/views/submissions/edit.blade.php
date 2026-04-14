@extends('layouts.app')

@section('title', 'Edit Submission')

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
        .dropzone.dragover {
            border-color: #2d8176;
            background-color: #e8f4f2;
        }
        .dropzone:hover .dropzone-icon,
        .dropzone.dragover .dropzone-icon {
            transform: translateY(-3px);
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

            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 sm:gap-5"
            >
                <div>
                    {{-- Breadcrumb --}}
                    <nav
                        class="flex flex-wrap items-center gap-2 mb-3 text-[11px] font-bold tracking-[.18em] uppercase text-[#6b5740]"
                    >
                        <a
                            href="{{ route('submissions.index') }}"
                            class="hover:text-[#2d8176] transition-colors"
                        >
                            Dashboard
                        </a>
                        <svg
                            class="w-3 h-3 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M9 5l7 7-7 7" stroke-width="2.5" />
                        </svg>
                        <a
                            href="{{ route('submissions.show', $submission) }}"
                            class="hover:text-[#2d8176] transition-colors"
                        >
                            #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                        <svg
                            class="w-3 h-3 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M9 5l7 7-7 7" stroke-width="2.5" />
                        </svg>
                        <span class="text-[#1a1209]">Edit</span>
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
                        Refine Your
                        <em class="italic text-[#2d8176]">Submission</em>
                    </h1>
                    <p
                        class="mt-2 text-[.95rem] sm:text-[.98rem] text-[#6b5740]"
                    >
                        Update manuscript metadata or replace the active
                        research file.
                    </p>
                </div>

                {{-- Back Button --}}
                <a
                    href="{{ route('submissions.show', $submission) }}"
                    class="inline-flex items-center gap-2 shrink-0 self-start md:self-auto px-5 py-2.5 rounded-lg bg-white border border-[#c9b99a] text-[.76rem] font-bold tracking-[.08em] uppercase text-[#6b5740] shadow-[0_2px_8px_rgba(26,18,9,.06)] hover:text-[#2d8176] hover:border-[#2d8176] hover:bg-[#e8f4f2] transition-all"
                >
                    <svg
                        class="w-3.5 h-3.5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M15 19l-7-7 7-7"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                    Back to Details
                </a>
            </div>
        </div>

        {{-- ── Form ── --}}
        <form
            method="POST"
            action="{{ route('submissions.update', $submission) }}"
            enctype="multipart/form-data"
            class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8"
        >
            @csrf
            @method('PUT')

            {{-- ════ LEFT: Form ════ --}}
            <div class="lg:col-span-8 space-y-6">
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
                        {{-- Title --}}
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
                            >
{{ old('title', $submission->title) }}</textarea
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
                                    <span class="text-[#2d8176] ml-0.5">*</span>
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
                                                {{ old('research_field', $submission->research_field) === $value ? 'selected' : '' }}
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
                                    value="{{ old('keywords', $submission->keywords) }}"
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
                            >
{{ old('abstract', $submission->abstract) }}</textarea
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

                {{-- ── Card 02: File Upload ── --}}
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

                    <div class="px-5 sm:px-7 py-5 sm:py-7 space-y-4">
                        {{-- Current File Indicator --}}
                        <div
                            class="flex items-center gap-3 sm:gap-4 px-4 sm:px-5 py-4 bg-[#e8f4f2] border border-[rgba(45,129,118,.3)] rounded-xl"
                        >
                            <div
                                class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-[#2d8176] border border-[#e8dfd0] shrink-0 shadow-[0_1px_4px_rgba(26,18,9,.06)]"
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        stroke-width="2"
                                    />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p
                                    class="text-[.68rem] font-extrabold tracking-[.12em] uppercase text-[#1a4d46] mb-0.5"
                                >
                                    Active File
                                </p>
                                <p
                                    class="text-[.88rem] font-semibold text-[#2d8176] truncate"
                                >
                                    {{ $submission->file_name ?? 'No file uploaded' }}
                                </p>
                            </div>
                        </div>

                        {{-- Drop Zone --}}
                        <div
                            class="dropzone relative cursor-pointer border-2 border-dashed border-[#c9b99a] rounded-[10px] bg-[#faf6ef] text-center transition-all duration-200 hover:border-[#2d8176] hover:bg-[#e8f4f2] {{ $errors->has('file') ? 'border-red-300' : '' }}"
                            id="dropzone"
                        >
                            <input
                                type="file"
                                name="file"
                                id="file"
                                accept=".pdf,.doc,.docx"
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
                                    Click or drag to replace file
                                </p>
                                <p
                                    class="text-[.8rem] sm:text-[.85rem] text-[#6b5740]"
                                >
                                    Leave blank to keep the current file — PDF,
                                    DOC, DOCX, max 50 MB
                                </p>
                                <div
                                    id="file-name-display"
                                    class="hidden mt-4 items-center gap-2 bg-[#e8f4f2] border border-[rgba(45,129,118,.3)] text-[#1a4d46] text-[.8rem] font-bold px-4 py-1.5 rounded-full"
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
                                        class="truncate"
                                    ></span>
                                </div>
                            </div>
                        </div>

                        @error('file')
                            <p
                                class="text-center text-[.8rem] text-red-600 font-medium"
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
                        href="{{ route('submissions.show', $submission) }}"
                        class="text-center px-5 py-3 rounded-lg text-[.82rem] font-semibold tracking-[.06em] uppercase text-[#6b5740] transition-all hover:text-[#1a1209] hover:bg-[#f3ece0]"
                    >
                        Discard Changes
                    </a>
                    <button
                        type="submit"
                        class="relative overflow-hidden inline-flex items-center justify-center gap-2 px-8 py-3 rounded-lg bg-[#2d8176] hover:bg-[#1a4d46] text-white text-[.82rem] font-bold tracking-[.1em] uppercase transition-all duration-150 shadow-[0_4px_14px_rgba(45,129,118,.30)] hover:-translate-y-0.5 hover:shadow-[0_8px_22px_rgba(45,129,118,.36)]"
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
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                        <span class="relative z-10">Save Updates</span>
                    </button>
                </div>
            </div>

            {{-- ════ RIGHT: Sidebar ════ --}}
            {{-- On mobile: appears above the form (order-first), sticky only on lg+ --}}
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
                            Submission Status
                        </p>
                    </div>

                    {{-- On mobile: show as horizontal scrollable row of stat pills --}}
                    <div class="px-5 sm:px-6 py-4 sm:py-5 space-y-3">
                        {{-- Current Stage --}}
                        <div
                            class="px-4 py-3 bg-[#faf6ef] border border-[#e8dfd0] rounded-xl"
                        >
                            <p
                                class="text-[.65rem] font-extrabold tracking-[.14em] uppercase text-[#6b5740] mb-1"
                            >
                                Current Stage
                            </p>
                            @php
                                $cls = match ($submission->status) {
                                    'accepted' => 'bg-[#f0fdf4] border-[#86efac] text-[#1a4d46]',
                                    'under_review', 'revision_under_review' => 'bg-[#fdf8ec] border-[rgba(201,168,76,.4)] text-[#8a6e28]',
                                    'revisions_requested' => 'bg-[#fff7ed] border-[#fed7aa] text-[#9a3412]',
                                    'rejected' => 'bg-[#fef2f2] border-[#fecaca] text-[#991b1b]',
                                    default => 'bg-[#e8f4f2] border-[rgba(45,129,118,.3)] text-[#1a4d46]',
                                };
                                $dot = match ($submission->status) {
                                    'accepted', 'revision_under_review', 'under_review' => '',
                                    'revisions_requested' => 'bg-[#f97316]',
                                    'rejected' => 'bg-[#c0392b]',
                                    default => 'bg-[#2d8176]',
                                };
                                $label = match ($submission->status) {
                                    'revision_under_review' => 'Revision Review',
                                    default => ucfirst(str_replace('_', ' ', $submission->status)),
                                };
                            @endphp

                            <span
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border text-[.7rem] font-bold tracking-[.06em] uppercase {{ $cls }}"
                            >
                                <span
                                    class="w-[6px] h-[6px] rounded-full {{ $dot }}"
                                ></span>
                                {{ $label }}
                            </span>
                        </div>

                        {{-- Last Modified + Ref: side by side on mobile --}}
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3">
                            <div
                                class="px-4 py-3 bg-[#faf6ef] border border-[#e8dfd0] rounded-xl"
                            >
                                <p
                                    class="text-[.65rem] font-extrabold tracking-[.14em] uppercase text-[#6b5740] mb-1"
                                >
                                    Last Modified
                                </p>
                                <p
                                    class="font-['Libre_Baskerville',serif] text-[1.2rem] sm:text-[1.4rem] font-bold text-[#1a1209] leading-none"
                                >
                                    {{ $submission->updated_at->format('d M') }}
                                </p>
                                <p class="text-[.78rem] text-[#6b5740] mt-0.5">
                                    {{ $submission->updated_at->format('Y · H:i') }}
                                </p>
                            </div>

                            <div
                                class="px-4 py-3 bg-[#faf6ef] border border-[#e8dfd0] rounded-xl"
                            >
                                <p
                                    class="text-[.65rem] font-extrabold tracking-[.14em] uppercase text-[#6b5740] mb-1"
                                >
                                    Reference No.
                                </p>
                                <span
                                    class="inline-block font-['Source_Sans_3',sans-serif] text-[.78rem] font-bold text-[#2d8176] tracking-[.06em] bg-[rgba(45,129,118,.07)] border border-[rgba(45,129,118,.22)] px-3 py-1 rounded"
                                >
                                    #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </div>

                        {{-- Editor note --}}
                        <div
                            class="px-4 py-4 bg-[#fdf8ec] border border-[rgba(201,168,76,.3)] rounded-xl"
                        >
                            <p
                                class="text-[.65rem] font-extrabold tracking-[.14em] uppercase text-[#8a6e28] mb-2"
                            >
                                Editorial Note
                            </p>
                            <p
                                class="text-[.85rem] italic text-[#6b5740] leading-relaxed"
                            >
                                Changes made here will be logged in the
                                manuscript history and visible to the editorial
                                board.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('file').addEventListener('change', function () {
            const display = document.getElementById('file-name-display');
            const text    = document.getElementById('file-name-text');
            if (this.files.length > 0) {
                text.textContent = this.files[0].name;
                display.classList.remove('hidden');
                display.style.display = 'inline-flex';
            }
        });

        const dz = document.getElementById('dropzone');
        dz.addEventListener('dragover',  (e) => { e.preventDefault(); dz.classList.add('dragover'); });
        dz.addEventListener('dragleave', ()  => dz.classList.remove('dragover'));
        dz.addEventListener('drop',      ()  => dz.classList.remove('dragover'));

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Updated</span>',
            html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
            confirmButtonText: 'Close', confirmButtonColor: '#2d8176',
            customClass: { popup:'rounded-2xl', confirmButton:'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest' },
            buttonsStyling: false,
        });
        @endif
    </script>
@endpush
