@extends('layouts.app')

@section('title', 'Review Appeal - ' . $appeal->submission->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('appeals.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="font-medium">Back to Appeals</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Submission Info --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ $appeal->submission->title }}</h2>
                <div class="flex items-center gap-4 text-sm text-slate-600 mb-4">
                    <span><strong>Author:</strong> {{ $appeal->author->name }}</span>
                    <span><strong>ID:</strong> #{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <p class="text-sm text-slate-500">
                    <strong>Original Rejection Date:</strong> {{ $appeal->submission->initial_screening_at?->format('M d, Y') }}
                </p>
                @if($appeal->submission->initial_screening_comments)
                    <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-xs font-bold text-red-600 uppercase mb-2">Rejection Reason</p>
                        <p class="text-sm text-red-900">{{ $appeal->submission->initial_screening_comments }}</p>
                    </div>
                @endif
            </div>

            {{-- Appeal Reason --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Appeal Reason</h3>
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $appeal->reason }}</p>
                </div>
                <p class="text-xs text-slate-500 mt-4">Submitted on {{ $appeal->created_at->format('M d, Y \a\t g:i A') }}</p>
            </div>

            {{-- Review Form --}}
            @if($appeal->isPending())
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Review Appeal</h3>

                    <form action="{{ route('appeals.update', $appeal) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        {{-- Decision --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-3">Decision</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="status" value="approved" required class="w-4 h-4 text-emerald-600">
                                    <span class="text-sm text-slate-700"><strong>Approve</strong> - Proceed with manuscript review</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="status" value="rejected" required class="w-4 h-4 text-red-600">
                                    <span class="text-sm text-slate-700"><strong>Reject</strong> - Uphold the initial screening decision</span>
                                </label>
                            </div>
                            @error('status')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Response --}}
                        <div>
                            <label for="editor_response" class="block text-sm font-bold text-slate-900 mb-2">Your Response</label>
                            <textarea
                                name="editor_response"
                                id="editor_response"
                                rows="6"
                                placeholder="Provide detailed feedback on the appeal decision..."
                                class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent outline-none transition-all @error('editor_response') border-red-500 @enderror"
                                required>{{ old('editor_response') }}</textarea>
                            <p class="text-xs text-slate-500 mt-1">Minimum 10 characters required</p>
                            @error('editor_response')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="px-6 py-3 bg-slate-900 text-white rounded-lg font-semibold hover:bg-slate-800 transition-colors">
                                Submit Decision
                            </button>
                            <a href="{{ route('appeals.index') }}" class="px-6 py-3 bg-slate-100 text-slate-900 rounded-lg font-semibold hover:bg-slate-200 transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            @else
                {{-- Decision Already Made --}}
                <div class="bg-white border-2 {{ $appeal->isApproved() ? 'border-emerald-200 bg-emerald-50' : 'border-red-200 bg-red-50' }} rounded-2xl p-6 shadow-sm">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 {{ $appeal->isApproved() ? 'bg-emerald-200 text-emerald-700' : 'bg-red-200 text-red-700' }} rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                @if($appeal->isApproved())
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                @else
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                @endif
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold {{ $appeal->isApproved() ? 'text-emerald-900' : 'text-red-900' }}">
                                {{ $appeal->isApproved() ? 'Appeal Approved' : 'Appeal Rejected' }}
                            </h4>
                            <p class="text-sm {{ $appeal->isApproved() ? 'text-emerald-800' : 'text-red-800' }} mt-1">
                                Reviewed on {{ $appeal->reviewed_at->format('M d, Y \a\t g:i A') }}
                                @if($appeal->reviewedBy)
                                    by <strong>{{ $appeal->reviewedBy->name }}</strong>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($appeal->editor_response)
                        <div class="mt-4 pt-4 border-t {{ $appeal->isApproved() ? 'border-emerald-200' : 'border-red-200' }}">
                            <p class="text-xs font-bold {{ $appeal->isApproved() ? 'text-emerald-600' : 'text-red-600' }} uppercase mb-2">Editor's Response</p>
                            <p class="text-sm {{ $appeal->isApproved() ? 'text-emerald-900' : 'text-red-900' }}">{{ $appeal->editor_response }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Card --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h4 class="text-sm font-bold text-slate-900 uppercase mb-4">Appeal Status</h4>
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full {{ $appeal->isPending() ? 'bg-amber-500' : ($appeal->isApproved() ? 'bg-emerald-500' : 'bg-red-500') }}"></div>
                    <span class="font-semibold {{ $appeal->isPending() ? 'text-amber-700' : ($appeal->isApproved() ? 'text-emerald-700' : 'text-red-700') }}">
                        {{ $appeal->isPending() ? 'Pending Review' : ($appeal->isApproved() ? 'Approved' : 'Rejected') }}
                    </span>
                </div>
            </div>

            {{-- Submission Info --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h4 class="text-sm font-bold text-slate-900 uppercase mb-4">Submission</h4>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-slate-500">Reference</p>
                        <p class="font-semibold text-slate-900">#{{ str_pad($appeal->submission->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Author</p>
                        <p class="font-semibold text-slate-900">{{ $appeal->author->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Email</p>
                        <p class="font-semibold text-slate-900 break-all text-xs">{{ $appeal->author->email }}</p>
                    </div>
                </div>

                <a href="{{ route('submissions.show', $appeal->submission) }}" class="mt-4 block w-full px-4 py-2 text-center text-sm font-semibold text-slate-900 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                    View Submission
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
