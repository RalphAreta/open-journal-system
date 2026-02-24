@extends('layouts.app')

@section('title', 'Edit Submission')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">
                <a href="{{ route('submissions.index') }}" class="hover:text-red-600 transition-colors">Board</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                <span class="text-slate-900 tracking-widest">Edit Manuscript #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Refine Submission</h1>
            <p class="text-slate-500 font-medium mt-2">Update your manuscript metadata or replace the active research file.</p>
        </div>

        {{-- Added Back Button --}}
        <a href="{{ route('submissions.show', $submission) }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 hover:text-slate-600 transition-all active:scale-95 flex items-center gap-2">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to Details
        </a>
    </div>

    <form method="POST" action="{{ route('submissions.update', $submission) }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        @csrf
        @method('PUT')

        {{-- Left: Form Inputs --}}
        <div class="lg:col-span-8 space-y-10">

            {{-- Part 1: Metadata --}}
            <section class="space-y-6">
                <div class="flex items-center gap-4 mb-8">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white text-[10px] font-black">01</span>
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Core Information</h2>
                    <div class="h-px bg-slate-100 flex-1"></div>
                </div>

                {{-- Title --}}
                <div class="space-y-2">
                    <label for="title" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Article Title *</label>
                    <textarea name="title" id="title" rows="3" required
                        class="w-full p-4 bg-white border rounded-2xl text-sm font-bold focus:ring-4 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none leading-relaxed @error('title') border-red-500 @else border-slate-200 @enderror"
                        placeholder="Enter title...">{{ old('title', $submission->title) }}</textarea>
                    @error('title')<p class="text-[10px] font-bold text-red-600 uppercase mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Research Field --}}
                    <div class="space-y-2">
                        <label for="research_field" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Research Field *</label>
                        <select name="research_field" id="research_field" required
                            class="w-full p-4 bg-white border rounded-2xl text-sm font-bold focus:ring-4 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none appearance-none @error('research_field') border-red-500 @else border-slate-200 @enderror">
                            <option value="">-- Select Field --</option>
                            @foreach ($fieldOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('research_field', $submission->research_field) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('research_field')<p class="text-[10px] font-bold text-red-600 uppercase mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Keywords --}}
                    <div class="space-y-2">
                        <label for="keywords" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Keywords</label>
                        <input type="text" name="keywords" id="keywords" value="{{ old('keywords', $submission->keywords) }}"
                            class="w-full p-4 bg-white border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none"
                            placeholder="Comma-separated">
                    </div>
                </div>

                {{-- Abstract --}}
                <div class="space-y-2">
                    <label for="abstract" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Abstract *</label>
                    <textarea name="abstract" id="abstract" rows="6" required
                        class="w-full p-4 bg-white border rounded-2xl text-sm font-medium focus:ring-4 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none leading-relaxed @error('abstract') border-red-500 @else border-slate-200 @enderror">{{ old('abstract', $submission->abstract) }}</textarea>
                    @error('abstract')<p class="text-[10px] font-bold text-red-600 uppercase mt-1">{{ $message }}</p>@enderror
                </div>
            </section>

            {{-- Part 2: File Update --}}
            <section class="space-y-6">
                <div class="flex items-center gap-4 mb-8">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white text-[10px] font-black">02</span>
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Manuscript File</h2>
                    <div class="h-px bg-slate-100 flex-1"></div>
                </div>

                {{-- Current File Indicator --}}
                <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 mb-4">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-emerald-800 uppercase tracking-widest">Active File</p>
                        <p class="text-xs font-bold text-emerald-600">{{ $submission->file_name ?? 'No file uploaded' }}</p>
                    </div>
                </div>

                <div class="relative group">
                    <input type="file" name="file" id="file" accept=".pdf,.doc,.docx"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="p-10 border-2 border-dashed rounded-[2.5rem] group-hover:bg-white group-hover:border-red-600 transition-all text-center @error('file') border-red-500 bg-red-50 @else border-slate-200 bg-slate-50 @enderror">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <p class="text-sm font-black text-slate-900 uppercase tracking-widest mb-1">Replace Manuscript</p>
                        <p class="text-xs text-slate-400 font-medium">Leave blank to keep the current file</p>
                        <div id="file-name" class="mt-4 text-[10px] font-black text-red-600 uppercase tracking-widest hidden"></div>
                    </div>
                </div>
                @error('file')<p class="text-[10px] font-bold text-red-600 uppercase mt-1 text-center">{{ $message }}</p>@enderror
            </section>

            {{-- Update Actions --}}
            <div class="pt-10 flex items-center justify-end gap-6 border-t border-slate-100">
                <a href="{{ route('submissions.show', $submission) }}" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-colors">Discard Changes</a>
                <button type="submit" class="px-12 py-4 bg-red-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-100 active:scale-95">
                    Save Updates
                </button>
            </div>
        </div>

        {{-- Right: Status Sidebar --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white sticky top-8 shadow-2xl shadow-slate-200">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-red-500 mb-8">System Status</h3>

                <div class="space-y-6">
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                        <p class="text-[10px] font-black uppercase text-slate-500 mb-1 tracking-widest">Current Stage</p>
                        <p class="text-sm font-bold text-white uppercase tracking-tight">{{ str_replace('_', ' ', $submission->status) }}</p>
                    </div>

                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                        <p class="text-[10px] font-black uppercase text-slate-500 mb-1 tracking-widest">Last Modified</p>
                        <p class="text-sm font-bold text-white uppercase tracking-tight">{{ $submission->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="mt-12 p-6 bg-red-600/10 rounded-2xl border border-red-600/20">
                    <p class="text-[10px] font-black uppercase tracking-widest text-red-500 mb-2">Editor Note</p>
                    <p class="text-[11px] text-slate-400 leading-relaxed font-medium italic">Changes made here will be logged in the manuscript history and visible to the editorial board.</p>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('file').onchange = function() {
        const nameDisplay = document.getElementById('file-name');
        if(this.files.length > 0) {
            nameDisplay.classList.remove('hidden');
            nameDisplay.innerHTML = `Replacing with: ${this.files[0].name}`;
        }
    };
</script>
@endpush
@endsection
