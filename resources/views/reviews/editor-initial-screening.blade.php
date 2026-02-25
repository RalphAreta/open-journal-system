@extends('layouts.app')

@section('title', 'Initial Screening')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Instrument Serif', serif; }
    .font-body          { font-family: 'DM Sans', sans-serif; }
    select, textarea    { font-family: 'DM Sans', sans-serif; }
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
<div class="font-body max-w-4xl">

    {{-- ── Header ── --}}
    <div class="mb-7 fade-up">
        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mb-4">
            <a href="{{ route('editor.submission.show', $submission) }}" class="hover:text-red-600 transition-colors">Submission</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5"/></svg>
            <span class="text-slate-600">Initial Screening</span>
        </nav>
        <h1 class="font-serif-display text-[1.85rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight">
            Initial Screening
        </h1>
        <p class="text-sm font-semibold text-slate-700 mt-1">{{ $submission->title }}</p>
        <p class="text-sm text-slate-500 mt-0.5">Author: {{ $submission->author->name }}</p>
    </div>

    {{-- ── Submission Details Card ── --}}
    <div class="bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm mb-5 fade-up-1">
        <p class="text-[10px] font-bold uppercase tracking-[.09em] text-slate-400 mb-5">Submission Details</p>

        <div class="grid grid-cols-2 gap-6 mb-5">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mb-1">Research Field</p>
                <p class="text-sm font-medium text-slate-900">{{ $submission->research_field ?? 'Not specified' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mb-1">Submitted On</p>
                <p class="text-sm font-medium text-slate-900">{{ $submission->submitted_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="mb-5 pb-5 border-b border-slate-100">
            <p class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mb-2">Abstract</p>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $submission->abstract }}</p>
        </div>

        <div class="mb-5 pb-5 border-b border-slate-100">
            <p class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mb-2">Keywords</p>
            <div class="flex flex-wrap gap-2 mt-1">
                @foreach (explode(',', $submission->keywords) as $keyword)
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-xs font-medium text-slate-600">
                    {{ trim($keyword) }}
                </span>
                @endforeach
            </div>
        </div>

        @if($submission->file_path)
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[.08em] text-slate-400 mb-2">Submission File</p>
            <div class="flex items-center justify-between px-4 py-3 bg-blue-50 border border-blue-200 rounded-[9px]">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm font-semibold text-blue-900">{{ $submission->file_name }}</p>
                </div>
                <a href="{{ route('submissions.download', ['submission' => $submission]) }}"
                   class="text-[11px] font-bold uppercase tracking-[.06em] text-blue-600 hover:text-blue-800 transition-colors">
                    Download
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- ── Screening Decision Card ── --}}
    <div class="bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm fade-up-2">
        <p class="text-[10px] font-bold uppercase tracking-[.09em] text-slate-400 mb-6">Screening Decision</p>

        <x-validation-errors />

        <form action="{{ route('editor.store-initial-screening', $submission) }}" method="POST" class="space-y-5">
            @csrf

            {{-- Decision Radio ── --}}
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-3">Decision</p>
                <div class="space-y-2.5">

                    <label class="flex items-start gap-3 p-3.5 rounded-[9px] border border-slate-200 bg-slate-50 cursor-pointer hover:border-emerald-300 hover:bg-emerald-50/30 transition-all group">
                        <input type="radio" id="passed" name="screening_status" value="passed"
                            class="mt-0.5 h-4 w-4 text-emerald-600 cursor-pointer screening-radio accent-emerald-600"
                            {{ old('screening_status') === 'passed' ? 'checked' : '' }} required>
                        <div>
                            <span class="text-sm font-bold text-slate-900">✓ Passed</span>
                            <span class="text-sm text-slate-500"> — Meets criteria, proceed to editor assignment</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 p-3.5 rounded-[9px] border border-slate-200 bg-slate-50 cursor-pointer hover:border-amber-300 hover:bg-amber-50/30 transition-all group">
                        <input type="radio" id="revision" name="screening_status" value="revision"
                            class="mt-0.5 h-4 w-4 cursor-pointer screening-radio accent-amber-500"
                            {{ old('screening_status') === 'revision' ? 'checked' : '' }}>
                        <div>
                            <span class="text-sm font-bold text-slate-900">🔄 Request Revision</span>
                            <span class="text-sm text-slate-500"> — Ask author to revise before proceeding</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 p-3.5 rounded-[9px] border border-slate-200 bg-slate-50 cursor-pointer hover:border-red-300 hover:bg-red-50/30 transition-all group">
                        <input type="radio" id="failed" name="screening_status" value="failed"
                            class="mt-0.5 h-4 w-4 text-red-600 cursor-pointer screening-radio accent-red-600"
                            {{ old('screening_status') === 'failed' ? 'checked' : '' }}>
                        <div>
                            <span class="text-sm font-bold text-slate-900">✗ Failed</span>
                            <span class="text-sm text-slate-500"> — Does not meet initial criteria</span>
                        </div>
                    </label>

                </div>
            </div>

            {{-- Revision Type ── --}}
            <div id="revision-type-field" class="{{ old('screening_status') === 'revision' ? '' : 'hidden' }}">
                <label class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">
                    Revision Type <span class="text-red-500">*</span>
                </label>
                <div class="relative max-w-xs">
                    <select name="revision_type" id="revision_type"
                        class="field w-full px-3.5 py-2.75 pr-10 border border-slate-200 rounded-[9px] bg-slate-50 text-sm font-medium text-slate-700 cursor-pointer transition-all">
                        <option value="">— Select —</option>
                        <option value="minor" {{ old('revision_type') === 'minor' ? 'selected' : '' }}>Minor Revision</option>
                        <option value="major" {{ old('revision_type') === 'major' ? 'selected' : '' }}>Major Revision</option>
                    </select>
                    <span class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </div>
            </div>

            {{-- Comments ── --}}
            <div>
                <label for="comments" class="block text-[11px] font-bold uppercase tracking-[.09em] text-slate-500 mb-1.5">
                    Screening Comments <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-slate-400 mb-2">These comments will be sent to the author to explain the screening decision.</p>
                <textarea id="comments" name="comments" required rows="6" maxlength="2000"
                    class="field w-full px-3.5 py-3 border border-slate-200 rounded-[9px] bg-slate-50 text-sm text-slate-900 leading-relaxed transition-all resize-none"
                    placeholder="Provide detailed feedback about the screening decision...">{{ old('comments') }}</textarea>
                <p class="text-xs text-slate-400 mt-1">Maximum 2000 characters</p>
            </div>

            {{-- Actions ── --}}
            <div class="flex items-center justify-between pt-5 border-t border-slate-100">
                <a href="{{ route('editor.submission.show', $submission) }}"
                   class="text-xs font-bold uppercase tracking-[.06em] text-slate-400 hover:text-slate-700 transition-colors px-4 py-2">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-slate-900 hover:bg-red-600 text-white px-8 py-3 rounded-[9px]
                           text-[11px] font-bold uppercase tracking-[.08em] font-body
                           transition-all duration-200 hover:-translate-y-0.5
                           shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-red-200/50">
                    Submit Screening Decision
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    const screeningRadios   = document.querySelectorAll('.screening-radio');
    const revisionTypeField = document.getElementById('revision-type-field');
    const revisionTypeSelect= document.getElementById('revision_type');

    function toggleRevisionType() {
        const isRevision = document.getElementById('revision').checked;
        revisionTypeField.classList.toggle('hidden', !isRevision);
        revisionTypeSelect.required = isRevision;
    }

    screeningRadios.forEach(r => r.addEventListener('change', toggleRevisionType));
    toggleRevisionType();
</script>
@endsection
