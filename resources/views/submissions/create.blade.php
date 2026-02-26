@extends('layouts.app')

@section('title', 'Submit Manuscript')

@push('styles')
    <style>
        /* Only non-Tailwind things: custom focus ring color & animations */
        .field:focus {
            outline: none;
            border-color: #2d8176 !important;
            background: #fff !important;
            box-shadow: 0 0 0 3px rgba(45,129,118,.12);
        }
        select { appearance: none; -webkit-appearance: none; }

        .fu  { animation: fu .45s ease both; }
        .fu1 { animation: fu .45s .07s ease both; }
        .fu2 { animation: fu .45s .14s ease both; }
        .fu3 { animation: fu .45s .21s ease both; }
        .fu4 { animation: fu .45s .28s ease both; }
        @keyframes fu {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .dropzone:hover .dropzone-icon,
        .dropzone.dragover .dropzone-icon {
            transform: translateY(-3px);
        }
        .dropzone.dragover {
            border-color: #2d8176;
            background-color: #e8f4f2;
        }
    </style>
@endpush

@section('content')
{{-- Page wrapper: cream bg + subtle dot texture via inline bg --}}
<div class="font-['Source_Sans_3',sans-serif] text-[#1a1209] max-w-7xl mx-auto px-1"
     style="background-color:#faf6ef;background-image:radial-gradient(ellipse 80% 50% at 50% -10%,rgba(45,129,118,.08) 0%,transparent 70%)">

    {{-- ── Page Header ── --}}
    <div class="relative pt-10 pb-7 mb-9 border-b border-[#e8dfd0] fu">
        {{-- teal accent underline --}}
        <div class="absolute bottom-[-1px] left-0 w-20 h-[3px]"
             style="background:linear-gradient(90deg,#2d8176,transparent)"></div>

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 mb-3
                    text-[11px] font-bold tracking-[.18em] uppercase text-[#6b5740]">
            <a href="{{ route('submissions.index') }}"
               class="hover:text-[#2d8176] transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 5l7 7-7 7" stroke-width="2.5"/>
            </svg>
            <span class="text-[#1a1209]">New Submission</span>
        </nav>

        {{-- Eyebrow --}}
        <p class="flex items-center gap-2 mb-2
                   text-[11px] font-bold tracking-[.2em] uppercase text-[#2d8176]">
            <span class="inline-block w-6 h-px bg-[#2d8176]"></span>
            Author Workspace
        </p>

        <h1 class="font-['Libre_Baskerville',serif] text-[2.4rem] font-bold
                   text-[#1a1209] leading-tight tracking-tight">
            Submit Your <em class="italic text-[#2d8176]">Research</em>
        </h1>
        <p class="mt-2 text-[.98rem] text-[#6b5740]">
            Join our global community of researchers. Ensure all fields are accurate before submitting.
        </p>
    </div>

    {{-- ── Form ── --}}
    <form method="POST" action="{{ route('submissions.store') }}"
          enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf

        {{-- ════════════════════ LEFT: Form ════════════════════ --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- ── Card 01: Core Information ── --}}
            <div class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden
                        shadow-[0_2px_16px_rgba(26,18,9,.07)] fu1">

                {{-- Card Header --}}
                <div class="flex items-center gap-4 px-7 py-4
                            bg-[#f3ece0] border-b border-[#e8dfd0]">
                    <div class="w-[30px] h-[30px] rounded-lg bg-[#2d8176] text-white
                                flex items-center justify-center shrink-0
                                text-[.68rem] font-extrabold tracking-wider">
                        01
                    </div>
                    <h2 class="font-['Libre_Baskerville',serif] text-[1rem] font-bold
                               text-[#1a1209] tracking-wide flex-1">
                        Core Information
                    </h2>
                </div>

                {{-- Card Body --}}
                <div class="px-7 py-7 space-y-6">

                    {{-- Manuscript Title --}}
                    <div>
                        <label for="title"
                               class="block mb-[7px] text-[.7rem] font-bold
                                      tracking-[.12em] uppercase text-[#6b5740]">
                            Manuscript Title
                            <span class="text-[#2d8176] ml-0.5">*</span>
                        </label>
                        <textarea name="title" id="title" rows="3" required
                            class="field w-full px-4 py-3 border rounded-lg
                                   bg-[#faf6ef] text-[.95rem] text-[#1a1209]
                                   leading-relaxed resize-none transition-all
                                   placeholder:text-[#b5a595]
                                   {{ $errors->has('title')
                                      ? 'border-red-300 bg-red-50'
                                      : 'border-[#e8dfd0]' }}"
                            placeholder="e.g., Quantum Computing Advancements in 2026">{{ old('title') }}</textarea>
                        @error('title')
                            <p class="mt-1.5 text-[.8rem] text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Research Field + Keywords --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Research Field --}}
                        <div>
                            <label for="research_field"
                                   class="block mb-[7px] text-[.7rem] font-bold
                                          tracking-[.12em] uppercase text-[#6b5740]">
                                Research Field
                                <span class="text-[#2d8176] ml-0.5">*</span>
                            </label>
                            <div class="relative">
                                <select name="research_field" id="research_field" required
                                    class="field w-full px-4 py-3 pr-10 border rounded-lg
                                           bg-[#faf6ef] text-[.95rem] text-[#1a1209]
                                           cursor-pointer transition-all
                                           {{ $errors->has('research_field')
                                              ? 'border-red-300 bg-red-50'
                                              : 'border-[#e8dfd0]' }}">
                                    <option value="">— Select Field —</option>
                                    @foreach ($fieldOptions as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('research_field') === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-3.5 top-1/2 -translate-y-1/2
                                            w-[17px] h-[17px] text-[#6b5740] pointer-events-none"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            @error('research_field')
                                <p class="mt-1.5 text-[.8rem] text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Keywords --}}
                        <div>
                            <label for="keywords"
                                   class="block mb-[7px] text-[.7rem] font-bold
                                          tracking-[.12em] uppercase text-[#6b5740]">
                                Keywords
                            </label>
                            <input type="text" name="keywords" id="keywords"
                                value="{{ old('keywords') }}"
                                class="field w-full px-4 py-3 border border-[#e8dfd0]
                                       rounded-lg bg-[#faf6ef] text-[.95rem] text-[#1a1209]
                                       transition-all placeholder:text-[#b5a595]"
                                placeholder="e.g., Quantum, AI, Physics">
                        </div>
                    </div>

                    {{-- Abstract --}}
                    <div>
                        <label for="abstract"
                               class="block mb-[7px] text-[.7rem] font-bold
                                      tracking-[.12em] uppercase text-[#6b5740]">
                            Abstract
                            <span class="text-[#2d8176] ml-0.5">*</span>
                        </label>
                        <textarea name="abstract" id="abstract" rows="7" required
                            class="field w-full px-4 py-3 border rounded-lg
                                   bg-[#faf6ef] text-[.95rem] text-[#1a1209]
                                   leading-relaxed resize-y transition-all
                                   placeholder:text-[#b5a595]
                                   {{ $errors->has('abstract')
                                      ? 'border-red-300 bg-red-50'
                                      : 'border-[#e8dfd0]' }}"
                            placeholder="Provide a concise summary of your research (max 300 words)…">{{ old('abstract') }}</textarea>
                        @error('abstract')
                            <p class="mt-1.5 text-[.8rem] text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ── Card 02: File Upload ── --}}
            <div class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden
                        shadow-[0_2px_16px_rgba(26,18,9,.07)] fu2">

                {{-- Card Header --}}
                <div class="flex items-center gap-4 px-7 py-4
                            bg-[#f3ece0] border-b border-[#e8dfd0]">
                    <div class="w-[30px] h-[30px] rounded-lg bg-[#2d8176] text-white
                                flex items-center justify-center shrink-0
                                text-[.68rem] font-extrabold tracking-wider">
                        02
                    </div>
                    <h2 class="font-['Libre_Baskerville',serif] text-[1rem] font-bold
                               text-[#1a1209] tracking-wide flex-1">
                        Manuscript File
                    </h2>
                </div>

                {{-- Card Body --}}
                <div class="px-7 py-7">
                    <div class="dropzone relative cursor-pointer
                                border-2 border-dashed border-[#c9b99a] rounded-[10px]
                                bg-[#faf6ef] text-center
                                transition-all duration-200
                                hover:border-[#2d8176] hover:bg-[#e8f4f2]
                                {{ $errors->has('file') ? 'border-red-300' : '' }}"
                         id="dropzone">

                        <input type="file" name="file" id="file"
                               accept=".pdf,.doc,.docx" required
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                        <div class="py-10 px-6">
                            {{-- Icon --}}
                            <div class="dropzone-icon w-[52px] h-[52px] mx-auto mb-4
                                        bg-white border border-[#c9b99a] rounded-xl
                                        flex items-center justify-center
                                        shadow-[0_2px_8px_rgba(26,18,9,.06)]
                                        transition-transform duration-200">
                                <svg class="w-6 h-6 text-[#2d8176]"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            <p class="font-['Libre_Baskerville',serif] text-[1rem] font-bold
                                      text-[#1a1209] mb-1">
                                Click or drag file to upload
                            </p>
                            <p class="text-[.85rem] text-[#6b5740]">
                                PDF, DOC, or DOCX — maximum 10 MB
                            </p>

                            {{-- Selected file pill --}}
                            <div id="file-name-display"
                                 class="hidden mt-4 inline-flex items-center gap-2
                                        bg-[#e8f4f2] border border-[rgba(45,129,118,.3)]
                                        text-[#1a4d46] text-[.8rem] font-bold
                                        px-4 py-1.5 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span id="file-name-text"></span>
                            </div>
                        </div>
                    </div>

                    @error('file')
                        <p class="mt-2 text-center text-[.8rem] text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="flex items-center justify-end gap-3 pt-1 fu3">

                <a href="{{ route('submissions.index') }}"
                   class="px-5 py-3 rounded-lg
                          text-[.82rem] font-semibold tracking-[.06em] uppercase
                          text-[#6b5740] transition-all
                          hover:text-[#1a1209] hover:bg-[#f3ece0]">
                    Cancel
                </a>

                <button type="submit"
                    class="relative overflow-hidden inline-flex items-center gap-2
                           px-8 py-3 rounded-lg
                           bg-[#2d8176] hover:bg-[#1a4d46] text-white
                           text-[.82rem] font-bold tracking-[.1em] uppercase
                           transition-all duration-150
                           shadow-[0_4px_14px_rgba(45,129,118,.30)]
                           hover:-translate-y-0.5
                           hover:shadow-[0_8px_22px_rgba(45,129,118,.36)]">
                    {{-- gold shimmer overlay --}}
                    <span class="absolute inset-0 pointer-events-none"
                          style="background:linear-gradient(135deg,rgba(201,168,76,.18) 0%,transparent 60%)"></span>
                    <svg class="w-4 h-4 relative z-10" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span class="relative z-10">Submit Manuscript</span>
                </button>

            </div>
        </div>

        {{-- ════════════════════ RIGHT: Sidebar ════════════════════ --}}
        <div class="lg:col-span-4 fu1">
            <div class="bg-white border border-[#c9b99a] rounded-[14px] overflow-hidden
                        shadow-[0_2px_16px_rgba(26,18,9,.07)] sticky top-7">

                {{-- Sidebar Header --}}
                <div class="px-6 py-4 bg-[#f3ece0] border-b border-[#e8dfd0]">
                    <p class="text-[.68rem] font-extrabold tracking-[.16em] uppercase
                              text-[#6b5740]">
                        Author Checklist
                    </p>
                </div>

                {{-- Checklist Items --}}
                <div class="px-6 py-5">
                    <ul class="divide-y divide-[#e8dfd0]">
                        @foreach([
                            'Anonymize the manuscript file for double-blind peer review.',
                            'The abstract must not exceed 300 words.',
                            'Ensure all authors are properly acknowledged.',
                            'Verify references follow the required citation format.',
                            'Confirm the manuscript has not been submitted elsewhere.',
                        ] as $item)
                            <li class="flex items-start gap-3 py-3
                                       first:pt-0 last:pb-0">
                                {{-- Teal check marker --}}
                                <div class="mt-0.5 w-5 h-5 rounded-full shrink-0
                                            bg-[#e8f4f2] border border-[rgba(45,129,118,.35)]
                                            flex items-center justify-center">
                                    <svg class="w-[10px] h-[10px] text-[#2d8176]"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-[.9rem] text-[#6b5740] leading-[1.55]">
                                    {{ $item }}
                                </p>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Policy note --}}
                    <div class="mt-5 pt-5 border-t border-[#e8dfd0]">
                        <p class="text-[.82rem] italic text-[#6b5740] leading-relaxed">
                            By submitting, you agree to the journal's peer-review policy
                            and copyright transfer agreement.
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
        // File name display
        document.getElementById('file').addEventListener('change', function () {
            const display = document.getElementById('file-name-display');
            const text    = document.getElementById('file-name-text');
            if (this.files.length > 0) {
                text.textContent = this.files[0].name;
                display.classList.remove('hidden');
                display.style.display = 'inline-flex';
            }
        });

        // Drag visual feedback
        const dz = document.getElementById('dropzone');
        dz.addEventListener('dragover',  (e) => { e.preventDefault(); dz.classList.add('dragover'); });
        dz.addEventListener('dragleave', ()  => dz.classList.remove('dragover'));
        dz.addEventListener('drop',      ()  => dz.classList.remove('dragover'));

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '<span style="font-family:\'Libre Baskerville\',serif;font-size:1.3rem;font-weight:700;">Submitted</span>',
                html: '<p style="font-size:.9rem;color:#6b5740;">{{ session('success') }}</p>',
                confirmButtonText: 'Close',
                confirmButtonColor: '#2d8176',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-lg px-8 py-2.5 text-xs font-bold uppercase tracking-widest'
                },
                buttonsStyling: false,
            });
        @endif
    </script>
@endpush