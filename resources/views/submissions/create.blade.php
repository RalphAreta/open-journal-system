@extends('layouts.app')

@section('title', 'Submit Manuscript')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Instrument Serif', serif; }
    .font-body          { font-family: 'DM Sans', sans-serif; }
    select, textarea, input { font-family: 'DM Sans', sans-serif; }
    select { appearance: none; -webkit-appearance: none; }
    .field:focus { outline:none; border-color:#DC2626 !important; background:#fff !important; box-shadow:0 0 0 3px rgba(220,38,38,.07); }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation: fadeUp .4s .07s ease both; }
    .fade-up-2 { animation: fadeUp .4s .14s ease both; }
    .fade-up-3 { animation: fadeUp .4s .21s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
</style>
@endpush

@section('content')
<div class="font-body max-w-6xl mx-auto">

    {{-- ── Header ── --}}
    <div class="mb-7 fade-up">
        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mb-4">
            <a href="{{ route('submissions.index') }}" class="hover:text-red-600 transition-colors">Board</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5"/></svg>
            <span class="text-slate-600">New Submission</span>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h1 class="font-serif-display text-[1.85rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight">
                    Submit Your Research
                </h1>
                <p class="text-sm text-slate-500 mt-1">Please ensure all fields are accurate before submitting.</p>
            </div>
            <span class="text-xs font-medium text-slate-400 bg-white border border-slate-200 px-3 py-1.5 rounded-full hidden sm:inline-block self-start sm:self-auto">
                {{ now()->format('D, M j Y') }}
            </span>
        </div>
    </div>

    <form method="POST" action="{{ route('submissions.store') }}" enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf

        {{-- ── LEFT: Form ── --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Section 01: Core Information --}}
            <div class="bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm fade-up-1">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-7 h-7 rounded-lg bg-slate-900 text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0">01</span>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-[.06em]">Core Information</h2>
                    <div class="h-px bg-slate-100 flex-1"></div>
                </div>

                <div class="space-y-5">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">Article Title *</label>
                        <textarea name="title" id="title" rows="3" required
                            class="field w-full px-3.5 py-3 border rounded-[9px] bg-slate-50 text-sm text-slate-900 leading-relaxed transition-all resize-none
                                   {{ $errors->has('title') ? 'border-red-300 bg-red-50/30' : 'border-slate-200' }}"
                            placeholder="e.g., Quantum Computing Advancements in 2026">{{ old('title') }}</textarea>
                        @error('title')<p class="text-red-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Research Field --}}
                        <div>
                            <label for="research_field" class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">Research Field *</label>
                            <div class="relative">
                                <select name="research_field" id="research_field" required
                                    class="field w-full px-3.5 py-[11px] pr-10 border rounded-[9px] bg-slate-50 text-sm font-medium text-slate-700 cursor-pointer transition-all
                                           {{ $errors->has('research_field') ? 'border-red-300 bg-red-50/30' : 'border-slate-200' }}">
                                    <option value="">— Select Field —</option>
                                    @foreach ($fieldOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('research_field') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </div>
                            @error('research_field')<p class="text-red-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Keywords --}}
                        <div>
                            <label for="keywords" class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">Keywords</label>
                            <input type="text" name="keywords" id="keywords" value="{{ old('keywords') }}"
                                class="field w-full px-3.5 py-[11px] border border-slate-200 rounded-[9px] bg-slate-50 text-sm text-slate-900 transition-all placeholder:text-slate-400"
                                placeholder="Quantum, AI, Physics">
                        </div>
                    </div>

                    {{-- Abstract --}}
                    <div>
                        <label for="abstract" class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">Abstract *</label>
                        <textarea name="abstract" id="abstract" rows="6" required
                            class="field w-full px-3.5 py-3 border rounded-[9px] bg-slate-50 text-sm text-slate-900 leading-relaxed transition-all resize-none
                                   {{ $errors->has('abstract') ? 'border-red-300 bg-red-50/30' : 'border-slate-200' }}"
                            placeholder="Provide a concise summary of your research...">{{ old('abstract') }}</textarea>
                        @error('abstract')<p class="text-red-500 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Section 02: File Upload --}}
            <div class="bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm fade-up-2">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-7 h-7 rounded-lg bg-slate-900 text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0">02</span>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-[.06em]">Manuscript File</h2>
                    <div class="h-px bg-slate-100 flex-1"></div>
                </div>

                <div class="relative group">
                    <input type="file" name="file" id="file" accept=".pdf,.doc,.docx" required
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="p-8 border-[1.5px] border-dashed rounded-[9px] text-center transition-all
                                group-hover:border-red-400 group-hover:bg-red-50/30
                                {{ $errors->has('file') ? 'border-red-300 bg-red-50/20' : 'border-slate-200 bg-slate-50' }}">
                        <div class="w-12 h-12 bg-white border border-slate-200 rounded-[10px] flex items-center justify-center mx-auto mb-3 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-700 mb-1">Click to Upload Manuscript</p>
                        <p class="text-xs text-slate-400 font-medium">PDF, DOC, or DOCX — max 10MB</p>
                        <div id="file-name-display" class="mt-3 text-xs font-bold text-red-600 hidden"></div>
                    </div>
                </div>
                @error('file')<p class="text-red-500 text-xs font-medium mt-2 text-center">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 pt-2 fade-up-3">
                <a href="{{ route('submissions.index') }}"
                   class="text-xs font-bold uppercase tracking-[.06em] text-slate-400 hover:text-slate-700 transition-colors px-4 py-2">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-slate-900 hover:bg-red-600 text-white px-8 py-3 rounded-[9px]
                           text-[11px] font-bold uppercase tracking-[.08em] font-body
                           transition-all duration-200 hover:-translate-y-0.5
                           shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-red-200/50">
                    Submit Article
                </button>
            </div>
        </div>

        {{-- ── RIGHT: Sidebar ── --}}
        <div class="lg:col-span-4 fade-up-1">
            <div class="bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm sticky top-8">
                <p class="text-[10px] font-bold uppercase tracking-[.1em] text-slate-400 mb-5">Author Checklist</p>

                <ul class="space-y-4">
                    @foreach([
                        'Anonymize the manuscript file for double-blind review.',
                        'The abstract should not exceed 300 words.',
                        'Ensure all authors are properly acknowledged.',
                    ] as $item)
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 w-4 h-4 rounded-full border-[1.5px] border-red-500 flex items-center justify-center flex-shrink-0">
                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                        </div>
                        <p class="text-xs font-medium text-slate-600 leading-relaxed">{{ $item }}</p>
                    </li>
                    @endforeach
                </ul>

                <div class="mt-6 pt-5 border-t border-slate-100">
                    <p class="text-xs text-slate-400 leading-relaxed italic">
                        By submitting, you agree to the IRJIEST peer-review policy and copyright transfer agreement.
                    </p>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('file').onchange = function () {
        const display = document.getElementById('file-name-display');
        if (this.files.length > 0) {
            display.classList.remove('hidden');
            display.textContent = 'Selected: ' + this.files[0].name;
        }
    };
</script>
@endpush