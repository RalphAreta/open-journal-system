@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.submissions') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-red-600 transition-colors">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to submissions
        </a>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">{{ $submission->title }}</h1>

        @php
            $statusClasses = match(strtolower($submission->status)) {
                'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
                'submitted', 'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                default => 'bg-slate-50 text-slate-700 border-slate-100',
            };
        @endphp
        <span class="inline-flex items-center px-4 py-1.5 rounded-full border text-sm font-bold uppercase tracking-wide {{ $statusClasses }}">
            {{ $submission->status }}
        </span>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Author</label>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold mr-3 shadow-sm">
                            {{ strtoupper(substr($submission->author->name ?? 'U', 0, 1)) }}
                        </div>
                        <p class="text-lg font-semibold text-slate-800">{{ $submission->author->name }}</p>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Submission Date</label>
                    <p class="text-lg font-semibold text-slate-800">{{ $submission->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8 mb-8">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Abstract</label>
                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed bg-slate-50/50 p-6 rounded-xl border border-slate-100 italic">
                    "{{ $submission->abstract }}"
                </div>
            </div>

            <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Submission File</label>
                @if($submission->file_path)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-lg border border-slate-200 shadow-sm transition-all hover:border-blue-200">
                        <div class="flex items-center overflow-hidden">
                            <div class="p-2 bg-blue-50 rounded-lg mr-3 text-blue-600">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="overflow-hidden">
                                <span class="block text-sm font-semibold text-slate-700 truncate">{{ $submission->file_name }}</span>
                                <span class="text-xs text-slate-400 font-medium">Research Manuscript</span>
                            </div>
                        </div>
                        <a href="{{ route('submissions.download', ['submission' => $submission]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-blue-100">
                            Download file
                        </a>
                    </div>
                @else
                    <p class="text-slate-500 italic text-sm">No file submitted.</p>
                @endif
            </div>

            @if($submission->reviews->isNotEmpty())
                <div class="mt-10 pt-8 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Reviewer Feedback</label>
                    <div class="space-y-4">
                        @foreach($submission->reviews as $r)
                            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-bold text-slate-900">{{ $r->reviewer->name }}</span>
                                    <span class="px-3 py-1 text-xs font-bold bg-slate-100 text-slate-700 rounded-md border border-slate-200">
                                        {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}
                                    </span>
                                </div>
                                @if($r->comments_for_editor)
                                    <div class="mb-2">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase">Editor Notes:</span>
                                        <p class="text-sm text-slate-600 italic">{{ $r->comments_for_editor }}</p>
                                    </div>
                                @endif
                                @if($r->comments_for_author)
                                    <div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase">Author Feedback:</span>
                                        <p class="text-sm text-slate-500 leading-relaxed">{{ Str::limit($r->comments_for_author, 150) }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
