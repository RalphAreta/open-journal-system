@extends('layouts.app')

@section('title', 'Initial Screening')

@section('content')

<div class="min-h-screen bg-stone-100 pb-16">
<div class="max-w-6xl mx-auto px-8 pt-10">

    {{-- Back link --}}
    <a href="{{ route('chief-editor.submission.show', $submission) }}"
       class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-teal-700 transition-colors mb-6 tracking-widest uppercase">
        ← Back to Submission
    </a>

    {{-- Page Hero --}}
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-teal-700 mb-2">🔍 Chief Editor · Review</p>
        <h1 class="text-3xl font-bold text-slate-900 leading-tight mb-1">
            Initial Screening
        </h1>
        <p class="text-sm text-slate-500">
            <span class="font-semibold text-slate-700">{{ $submission->title }}</span>
            &nbsp;·&nbsp; Author: {{ $submission->author->name }}
        </p>
    </div>

    {{-- Two-column grid --}}
    <div class="grid grid-cols-3 gap-6 items-start">

        {{-- ── LEFT: Submission Details ── --}}
        <div class="col-span-2 flex flex-col gap-5">

            {{-- Submission Details Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800">📄 Submission Details</h2>
                    <span class="text-xs text-slate-400">ID #{{ $submission->id }}</span>
                </div>
                <div class="p-6">

                    {{-- Research Field + Date --}}
                    <div class="grid grid-cols-2 gap-x-10 gap-y-5 mb-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1.5">Research Field</p>
                            <span class="inline-flex items-center gap-1.5 bg-teal-50 border border-teal-200 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">
                                🔬 {{ $submission->research_field ?? 'Not specified' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1.5">Submitted On</p>
                            <p class="text-sm text-slate-800 font-medium">{{ $submission->submitted_at->format('M d, Y') }}</p>
                            <p class="text-xs text-slate-400">{{ $submission->submitted_at->format('h:i A') }}</p>
                        </div>
                    </div>

                    <div class="h-px bg-slate-100 my-5"></div>

                    {{-- Abstract --}}
                    <div class="mb-5">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Abstract</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $submission->abstract }}</p>
                    </div>

                    {{-- Keywords --}}
                    <div class="mb-5">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Keywords</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach (explode(',', $submission->keywords) as $keyword)
                                <span class="bg-slate-100 border border-slate-200 text-slate-600 px-3 py-1 rounded-full text-xs font-medium">
                                    {{ trim($keyword) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Submission File --}}
                    @if ($submission->file_name)
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Submission File</p>
                            <div class="flex items-center justify-between bg-teal-50 border border-teal-200 rounded-xl px-4 py-3 gap-3">
                                <span class="flex items-center gap-2 text-sm font-semibold text-teal-800">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                    {{ $submission->original_file_name ?? $submission->file_name }}
                                </span>
                                <a href="{{ route('submissions.download-original', $submission) }}"
                                   class="shrink-0 text-xs font-semibold text-teal-700 border border-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-700 hover:text-white transition-all">
                                    ↓ Download
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Previous Screening Record --}}
            @if (!$submission->isPendingInitialScreening())
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="text-sm font-semibold text-slate-800">📋 Previous Screening Record</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-x-10 gap-y-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1.5">Screened By</p>
                                <p class="text-sm text-slate-800 font-medium">{{ $submission->initialScreeningBy?->name ?? 'Unknown' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1.5">Screening Date</p>
                                <p class="text-sm text-slate-800 font-medium">{{ $submission->initial_screening_at?->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-400">{{ $submission->initial_screening_at?->format('h:i A') }}</p>
                            </div>
                            @if ($submission->initial_screening_comments)
                                <div class="col-span-2">
                                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1.5">Comments</p>
                                    <p class="text-sm text-slate-700 leading-relaxed">{{ $submission->initial_screening_comments }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>

        {{-- ── RIGHT: Decision Panel (sticky) ── --}}
        <div class="col-span-1 sticky top-6 flex flex-col gap-4">

            {{-- Decision Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800">
                        ⚖️ {{ $submission->isPendingInitialScreening() ? 'Screening Decision' : 'Override Decision' }}
                    </h2>
                </div>
                <div class="p-6">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                            <p class="text-xs font-bold text-red-700 mb-1">Please fix the following:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li class="text-xs text-red-600">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Status Ribbon --}}
                    @if ($submission->isPendingInitialScreening())
                        <div class="flex items-center gap-2.5 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-5">
                            <span class="w-2 h-2 rounded-full bg-amber-400 shrink-0"></span>
                            <p class="text-xs font-semibold text-amber-700">Awaiting initial screening</p>
                        </div>
                    @elseif ($submission->hasPassedInitialScreening())
                        <div class="flex items-center gap-2.5 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 mb-5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                            <p class="text-xs font-semibold text-emerald-700">Currently: Passed Screening</p>
                        </div>
                    @else
                        <div class="flex items-center gap-2.5 bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
                            <span class="w-2 h-2 rounded-full bg-red-400 shrink-0"></span>
                            <p class="text-xs font-semibold text-red-700">Currently: Failed Screening</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('chief-editor.store-initial-screening', $submission) }}">
                        @csrf

                        {{-- Decision Options --}}
                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Decision</label>
                            <div class="flex flex-col gap-2">

                                <label class="flex items-start gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                                    {{ old('decision', $submission->hasPassedInitialScreening() ? 'pass' : '') === 'pass'
                                        ? 'border-teal-500 bg-teal-50'
                                        : 'border-slate-200 hover:border-teal-300' }}">
                                    <input type="radio" name="decision" value="pass"
                                        class="mt-0.5 accent-teal-600"
                                        {{ old('decision', $submission->hasPassedInitialScreening() ? 'pass' : '') === 'pass' ? 'checked' : '' }}>
                                    <div>
                                        <p class="text-xs font-semibold text-emerald-700">✓ Pass — Proceed to Review</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Manuscript meets basic criteria</p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                                    {{ old('decision', !$submission->isPendingInitialScreening() && !$submission->hasPassedInitialScreening() ? 'fail' : '') === 'fail'
                                        ? 'border-red-400 bg-red-50'
                                        : 'border-slate-200 hover:border-red-300' }}">
                                    <input type="radio" name="decision" value="fail"
                                        class="mt-0.5 accent-red-500"
                                        {{ old('decision', !$submission->isPendingInitialScreening() && !$submission->hasPassedInitialScreening() ? 'fail' : '') === 'fail' ? 'checked' : '' }}>
                                    <div>
                                        <p class="text-xs font-semibold text-red-600">✗ Fail — Reject Submission</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Does not meet submission standards</p>
                                    </div>
                                </label>

                            </div>
                        </div>

                        {{-- Comments --}}
                        <div class="mb-5">
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">
                                Comments <span class="font-normal normal-case text-slate-400">(optional)</span>
                            </label>
                            <textarea name="comments" rows="4"
                                class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-700 resize-none focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                placeholder="Screening notes, issues found, or reason for decision...">{{ old('comments', $submission->initial_screening_comments) }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-teal-700 hover:bg-teal-800 text-white font-semibold text-sm py-2.5 rounded-xl transition-colors shadow-sm">
                            {{ $submission->isPendingInitialScreening() ? 'Submit Decision' : 'Update Decision' }}
                        </button>

                    </form>

                    <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                        <a href="{{ route('chief-editor.submission.show', $submission) }}"
                           class="text-xs text-slate-400 hover:text-teal-700 font-medium transition-colors">
                            Cancel — Go back
                        </a>
                    </div>

                </div>
            </div>

            {{-- Tip chip --}}
            <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                <span class="text-base leading-none shrink-0">💡</span>
                <p class="text-xs text-amber-800 leading-relaxed">
                    Passing will make this submission available for editor assignment. Failing will notify the author.
                </p>
            </div>

        </div>

    </div>
</div>
</div>

@endsection