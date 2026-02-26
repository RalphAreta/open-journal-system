@extends('layouts.app')

@section('title', $submission->title)

@section('content')
<div class="max-w-6xl mx-auto py-8">
    {{-- Header & Core Navigation --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div class="flex-1">
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
                <a href="{{ route('submissions.index') }}" class="hover:text-red-600 transition-colors">Board</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                <span class="text-slate-900 tracking-widest">Archive #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter leading-[1.1] max-w-4xl">
                {{ $submission->title }}
            </h1>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            @if($submission->isEditableByAuthor() && auth()->user()->id === $submission->author_id && $submission->status === 'submitted')
                <a href="{{ route('submissions.edit', $submission) }}" class="px-6 py-3 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all">
                    Edit Details
                </a>
            @endif
            <a href="{{ route('submissions.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        {{-- Left: The Meat (Abstract, Revisions, Reviews) --}}
        <div class="lg:col-span-8 space-y-12">

            {{-- 1. Urgent Action: Pending Revisions --}}
            @php $pendingRevisions = $submission->revisionRequests()->whereNull('revised_at')->count(); @endphp
            @if ($pendingRevisions > 0 && auth()->user()->id === $submission->author_id)
                <div class="bg-red-600 rounded-[2.5rem] p-1 shadow-2xl shadow-red-100">
                    <div class="bg-white rounded-[2.2rem] p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight">Revisions Requested</h3>
                                <p class="text-sm text-slate-500 font-medium">{{ $pendingRevisions }} request(s) are awaiting your response.</p>
                            </div>
                        </div>
                        <a href="{{ route('submissions.revisions', $submission) }}" class="w-full md:w-auto px-8 py-4 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all text-center">
                            Submit Revisions
                        </a>
                    </div>
                </div>
            @endif

            {{-- 1.5. Editor Decision on Revised Manuscript --}}
            @if(in_array($submission->status, ['accepted', 'rejected']) && $submission->editor_decision_at)
                <div class="bg-linear-to-br {{ $submission->status === 'accepted' ? 'from-emerald-600 to-green-500' : 'from-red-600 to-rose-500' }} rounded-[2.5rem] p-1 shadow-2xl {{ $submission->status === 'accepted' ? 'shadow-emerald-100' : 'shadow-red-100' }}">
                    <div class="bg-white rounded-[2.2rem] p-8">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-12 h-12 {{ $submission->status === 'accepted' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} rounded-2xl flex items-center justify-center shrink-0 text-xl font-black">
                                {{ $submission->status === 'accepted' ? '✓' : '✗' }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-black {{ $submission->status === 'accepted' ? 'text-emerald-900' : 'text-red-900' }} tracking-tight">
                                    Editorial Decision: {{ ucfirst($submission->status) }}
                                </h3>
                                <p class="text-sm {{ $submission->status === 'accepted' ? 'text-emerald-700' : 'text-red-700' }} font-medium">
                                    Decided on {{ $submission->editor_decision_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        @if($submission->editor_notes)
                            <div class="{{ $submission->status === 'accepted' ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }} rounded-2xl p-6 border">
                                <p class="text-[10px] font-black {{ $submission->status === 'accepted' ? 'text-emerald-600' : 'text-red-600' }} uppercase tracking-widest mb-2">Editor's Comments</p>
                                <p class="text-sm {{ $submission->status === 'accepted' ? 'text-emerald-900' : 'text-red-900' }} leading-relaxed font-medium">{{ $submission->editor_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- 2. Abstract Content --}}
            <section class="space-y-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Abstract</h2>
                    <div class="h-px bg-slate-100 flex-1"></div>
                </div>
                <div class="bg-slate-50 p-10 rounded-[2.5rem] border border-slate-100">
                    <p class="text-slate-700 text-lg leading-relaxed font-medium italic">
                        "{{ $submission->abstract }}"
                    </p>
                </div>
            </section>

            {{-- 2.5. Appeal Section for Authors with Failed Initial Screening --}}
            @include('submissions.partials.appeal-section')

            {{-- 3. Reviewer Feedback (Conditional) --}}
            @if($submission->reviews->isNotEmpty() && (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
                <section class="space-y-6">
                    <div class="flex items-center gap-4">
                        <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Peer Review Logs</h2>
                        <div class="h-px bg-slate-100 flex-1"></div>
                    </div>

                    <div class="space-y-4">
                        @foreach($submission->reviews as $r)
                            <div class="bg-white border border-slate-200 rounded-3xl p-8 hover:border-red-200 transition-colors shadow-sm">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-black">
                                            @if(auth()->user()->id === $submission->author_id)
                                                R
                                            @else
                                                {{ substr($r->reviewer->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            @if(auth()->user()->id === $submission->author_id)
                                                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Reviewer</p>
                                            @else
                                                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Reviewer: {{ $r->reviewer->name }}</p>
                                            @endif
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $r->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    @if(auth()->user()->id !== $submission->author_id)
                                        <span class="px-4 py-1.5 rounded-full bg-slate-50 border border-slate-100 text-[9px] font-black uppercase tracking-widest text-slate-600">
                                            {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}
                                        </span>
                                    @endif
                                </div>

                                @if($r->comments_for_author)
                                    <div class="prose prose-sm max-w-none text-slate-600 leading-relaxed font-medium">
                                        {{ $r->comments_for_author }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- 3.5. Revision Review Feedback --}}
            @php
                $allRevisionReviews = [];
                foreach($submission->revisionRequests as $rev) {
                    foreach($rev->revisionReviews as $revRev) {
                        if($revRev->comments_for_author) {
                            $allRevisionReviews[] = $revRev;
                        }
                    }
                }
            @endphp
            @if(!empty($allRevisionReviews) && (auth()->user()->id === $submission->author_id || auth()->user()->isEditor() || auth()->user()->isAdmin()))
                <section class="space-y-6">
                    <div class="flex items-center gap-4">
                        <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Revision Review Feedback</h2>
                        <div class="h-px bg-slate-100 flex-1"></div>
                    </div>

                    <div class="space-y-4">
                        @foreach($allRevisionReviews as $rr)
                            <div class="bg-white border border-blue-200 rounded-3xl p-8 hover:border-blue-400 transition-colors shadow-sm bg-linear-to-br from-blue-50 to-transparent">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-black">
                                            @if(auth()->user()->id === $submission->author_id)
                                                R
                                            @else
                                                {{ substr($rr->reviewer->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            @if(auth()->user()->id === $submission->author_id)
                                                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Reviewer</p>
                                            @else
                                                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Reviewer: {{ $rr->reviewer->name }}</p>
                                            @endif
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $rr->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    @if($rr->recommendation && auth()->user()->id !== $submission->author_id)
                                        <span class="px-4 py-1.5 rounded-full bg-blue-100 border border-blue-200 text-[9px] font-black uppercase tracking-widest text-blue-700">
                                            {{ \App\Models\RevisionReview::recommendationOptions()[$rr->recommendation] ?? $rr->recommendation }}
                                        </span>
                                    @endif
                                </div>

                                @if($rr->comments_for_author)
                                    <div class="prose prose-sm max-w-none text-slate-600 leading-relaxed font-medium">
                                        {{ $rr->comments_for_author }}
                                    </div>
                                @endif

                                @if($rr->rating)
                                    <div class="mt-4 pt-4 border-t border-blue-100">
                                        <p class="text-[10px] font-bold text-slate-500 uppercase">Rating: <span class="text-blue-600 font-black">{{ $rr->rating }}/5.0</span></p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

         {{-- 4. Editorial Feedback --}}
@if($submission->initial_screening_status !== 'pending' || $submission->initial_screening_comments || $submission->editor_notes)
<section class="space-y-4">
    <div class="flex items-center gap-4">
        <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Editorial Feedback</h2>
        <div class="h-px bg-slate-100 flex-1"></div>
    </div>

    {{-- Chief Editor Block --}}
    @if($submission->initial_screening_status !== 'pending' || $submission->initial_screening_comments)
    <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm space-y-4">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9v-2h2v2zm0-4H9V5h2v4z"/></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Editor-in-Chief</p>
                <p class="text-[10px] text-slate-400 font-medium">Initial Screening Decision</p>
            </div>
            {{-- Status Badge --}}
            @if($submission->initial_screening_status === 'passed')
                <span class="ml-auto inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-100 rounded-full text-[9px] font-black text-emerald-700 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Passed
                </span>
            @elseif($submission->initial_screening_status === 'failed')
                <span class="ml-auto inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 border border-red-100 rounded-full text-[9px] font-black text-red-700 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Failed
                </span>
            @endif
        </div>

        {{-- Comments --}}
        @if($submission->initial_screening_comments)
        <div class="bg-slate-50 rounded-2xl px-5 py-4 border border-slate-100">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Screening Comments</p>
            <p class="text-sm text-slate-600 leading-relaxed font-medium">{{ $submission->initial_screening_comments }}</p>
        </div>
        @endif
    </div>
    @endif

    {{-- Editor Block --}}
    @if($submission->editor_notes)
    <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm space-y-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Editor</p>
                <p class="text-[10px] text-slate-400 font-medium">Official Editorial Notes</p>
            </div>
            {{-- Final decision badge --}}
            @if($submission->status === 'accepted')
                <span class="ml-auto inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-100 rounded-full text-[9px] font-black text-emerald-700 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Accepted
                </span>
            @elseif($submission->status === 'rejected')
                <span class="ml-auto inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 border border-red-100 rounded-full text-[9px] font-black text-red-700 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                </span>
            @endif
        </div>
        <div class="bg-slate-50 rounded-2xl px-5 py-4 border border-slate-100">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Notes</p>
            <p class="text-sm text-slate-600 leading-relaxed font-medium">{{ $submission->editor_notes }}</p>
        </div>
    </div>
    @endif

</section>
@endif
        </div>

        {{-- Right: Technical Sidebar --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm sticky top-8">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-8">Metadata</h3>

                <div class="space-y-8">
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 mb-2">Current Status</p>
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                            {{ str_replace('_', ' ', $submission->status) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 mb-1">Corresponding Author</p>
                        <p class="text-sm font-bold text-slate-900">{{ $submission->author->name }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 mb-1">Submission Date</p>
                        <p class="text-sm font-bold text-slate-900">{{ $submission->submitted_at?->format('M d, Y') ?? '-' }}</p>
                    </div>

                    @if($submission->keywords)
                        <div>
                            <p class="text-[10px] font-black uppercase text-slate-400 mb-3">Key Taxonomy</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $submission->keywords) as $keyword)
                                    <span class="px-3 py-1 bg-slate-50 text-slate-600 text-[10px] font-bold rounded-lg border border-slate-100 capitalize">
                                        {{ trim($keyword) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($submission->file_name)
                        <div class="pt-6 border-t border-slate-100">
                            <p class="text-[10px] font-black uppercase text-slate-400 mb-3">Active Manuscript</p>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100 group cursor-pointer hover:border-red-200 transition-colors">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-red-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-[10px] font-black text-slate-900 truncate uppercase">{{ $submission->file_name }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase">Document File</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
