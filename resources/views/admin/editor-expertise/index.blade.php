@extends('layouts.app')

@section('title', 'Manage Editor Expertise')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
    .font-serif-display { font-family: 'Instrument Serif', serif; }
    .font-body          { font-family: 'DM Sans', sans-serif; }
    .fade-up   { animation: fadeUp .4s ease both; }
    .fade-up-1 { animation: fadeUp .4s .07s ease both; }
    .fade-up-2 { animation: fadeUp .4s .14s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
</style>
@endpush

@section('content')
<div class="font-body">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-7 fade-up">
        <div>
            <h1 class="font-serif-display text-[1.85rem] font-normal text-slate-900 tracking-[-0.015em] leading-tight">
                Manage Editor Expertise
            </h1>
            <p class="text-sm text-slate-500 mt-1">Set and update fields of expertise for each editor</p>
        </div>
        <a href="{{ route('admin.expertise-categories.index') }}"
           class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg transition-colors text-sm font-medium">
             Manage Categories
        </a>
    </div>
</div>

    {{-- ── Editor Cards ── --}}
    @if ($editors->count() > 0)
    <div class="grid gap-4 fade-up-1">
        @foreach ($editors as $editor)
        <div class="bg-white border border-slate-200 rounded-[14px] p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">{{ $editor->name }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $editor->email }}</p>
                </div>
                <a href="{{ route('admin.editor-expertise.edit', $editor) }}"
                   class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white
                          px-3 py-1.5 rounded-[7px] text-[11px] font-bold uppercase tracking-[.05em]
                          transition-all hover:-translate-y-0.5 flex-shrink-0">
                    ✏️ Manage
                </a>
            </div>

            @if ($editor->editorExpertise->count() > 0)
            <div class="flex flex-wrap gap-2">
                @foreach ($editor->editorExpertise as $expertise)
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 border border-red-200 text-xs font-medium text-red-700">
                    {{ $expertise->field_name }}
                </span>
                @endforeach
            </div>
            @else
            <p class="text-xs text-slate-400 italic">No expertise fields assigned yet</p>
            @endif
        </div>
        @endforeach
    </div>

    <div class="mt-5 fade-up-2">{{ $editors->links() }}</div>

    @else
    <div class="bg-white border border-slate-200 rounded-[14px] px-6 py-12 text-center shadow-sm fade-up-1">
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <p class="text-[11px] font-bold uppercase tracking-[.1em] text-slate-300">No editors found</p>
        <p class="text-xs text-slate-400 mt-1">Please create editor accounts first.</p>
    </div>
    @endif

</div>
@endsection
