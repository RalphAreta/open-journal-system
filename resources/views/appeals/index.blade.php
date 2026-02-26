@extends('layouts.app')

@section('title', 'Manage Appeals')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                <a href="{{ route('chief-editor.dashboard') }}" class="hover:text-red-600 transition-colors">Editor-in-Chief</a>
                <span>&gt;</span>
                <span class="text-slate-900">Appeals</span>
            </nav>
            <h1 class="text-3xl font-bold text-slate-900">Manuscript Appeals</h1>
            <p class="text-sm text-slate-500 mt-1">Review and respond to author appeals on rejected manuscripts.</p>
        </div>

        <div class="bg-slate-100 px-4 py-2 rounded-lg border border-slate-200">
            <span class="text-sm font-medium text-slate-600">Total: {{ $appeals->total() }}</span>
        </div>
    </div>

    {{-- Appeals Grid --}}
    <div class="space-y-4">
        @forelse($appeals as $appeal)
            <div class="bg-white border-2 border-slate-200 rounded-2xl p-6 hover:border-amber-300 transition-colors shadow-sm">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-bold text-slate-900">{{ $appeal->submission->title }}</h3>
                            @if($appeal->isPending())
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">PENDING</span>
                            @elseif($appeal->isApproved())
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">APPROVED</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">REJECTED</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-600">By <span class="font-semibold">{{ $appeal->author->name }}</span></p>
                        <p class="text-xs text-slate-400 mt-1">Submitted on {{ $appeal->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>

                    <div class="shrink-0">
                        <a href="{{ route('appeals.show', $appeal) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-slate-800 transition-colors">
                            <span>Review</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Appeal Reason Preview --}}
                <div class="bg-slate-50 rounded-lg p-4 border border-slate-100 mb-4">
                    <p class="text-xs font-bold text-slate-500 uppercase mb-2">Appeal Reason</p>
                    <p class="text-sm text-slate-700 line-clamp-3">{{ $appeal->reason }}</p>
                </div>

                {{-- Status Info --}}
                @if($appeal->reviewed_at)
                    <div class="text-xs text-slate-500">
                        <span>Reviewed on {{ $appeal->reviewed_at->format('M d, Y') }}</span>
                        @if($appeal->reviewedBy)
                            <span> by <strong>{{ $appeal->reviewedBy->name }}</strong></span>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-200">
                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-slate-500 font-medium">No appeals to review.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($appeals->hasPages())
        <div class="mt-8">
            {{ $appeals->links() }}
        </div>
    @endif
</div>
@endsection
