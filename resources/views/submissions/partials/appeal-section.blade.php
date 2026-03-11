{{-- Appeal Section for Rejected Manuscripts --}}
@if($submission->initial_screening_status === 'failed' && $submission->status !== 'rejected' && auth()->user()->id === $submission->author_id)
    @php
        $allAppeals = $submission->appeals()->get();
        $pendingAppeal = $submission->appeals()->where('status', 'pending')->first();
        $rejectedAppeals = $submission->appeals()->where('status', 'rejected')->count();
        $totalAppeals = $allAppeals->count();
        $canStillAppeal = $totalAppeals < 2;
    @endphp

    <section class="space-y-6">
        <div class="flex items-center gap-4">
            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Request Appeal</h2>
            <div class="h-px bg-slate-100 flex-1"></div>
        </div>

        @if($pendingAppeal)
            {{-- Pending Appeal Display --}}
            <div class="bg-blue-50 border-2 border-blue-200 rounded-3xl p-8">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H3a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 000-2h2a2 2 0 012 2v12a2 2 0 01-2 2H3a2 2 0 01-2-2V5z" clip-rule="evenodd"/><path d="M7 7a1 1 0 000 2h6a1 1 0 000-2H7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-blue-900 tracking-tight">Appeal Under Review</h3>
                        <p class="text-sm text-blue-800 font-medium mt-1">
                            You've submitted an appeal on {{ $pendingAppeal->created_at->format('M d, Y') }}.
                            Status: <strong>Pending Review</strong>
                        </p>
                    </div>
                </div>
            </div>
        @elseif($rejectedAppeals >= 2)
            {{-- All Appeals Exhausted --}}
            <div class="bg-red-50 border-2 border-red-200 rounded-3xl p-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-red-900 tracking-tight">Appeal Process Completed</h3>
                        <p class="text-sm text-red-800 font-medium mt-1">
                            You have used the maximum number of appeals (2) and unfortunately both were rejected.
                            The initial screening decision is final and cannot be appealed further.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($rejectedAppeals === 1 && $canStillAppeal)
            {{-- Show Latest Rejected Appeal and Allow Resubmission --}}
            @php
                $rejectedAppeal = $submission->appeals()->where('status', 'rejected')->first();
            @endphp

            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-3xl p-8 mb-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-yellow-900 tracking-tight">Failed at Initial Screening - Appeal Rejected</h3>
                        <p class="text-sm text-yellow-800 font-medium mt-1">
                            Your appeal submitted on {{ $rejectedAppeal->created_at->format('M d, Y') }} was rejected. This appeal cannot be edited.
                        </p>
                    </div>
                </div>

                @if($rejectedAppeal->reviewed_at)
                    <div class="bg-white rounded-2xl p-4">
                        <p class="text-xs font-bold text-slate-500 uppercase mb-2">Editor's Response</p>
                        <p class="text-sm text-slate-700">{{ $rejectedAppeal->editor_response }}</p>
                    </div>
                @endif

                <p class="text-sm text-yellow-900 font-medium mt-4 p-3 bg-yellow-100 rounded-xl">
                    ⓘ You have one final appeal remaining. Review the editor's feedback above carefully, as this is your last opportunity to appeal the initial screening decision.
                </p>
            </div>

            {{-- Form for Second Appeal --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
                <form action="{{ route('appeals.store', $submission) }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="appeal_reason" class="block text-sm font-bold text-slate-900 mb-3">
                            Reason for Final Appeal
                        </label>
                        <textarea
                            name="reason"
                            id="appeal_reason"
                            rows="7"
                            placeholder="Please explain why you believe your manuscript should be reconsidered. Provide details about the research quality, methodology, or any concerns about the previous feedback. This is your final opportunity to appeal..."
                            class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition-all text-slate-700 @error('reason') border-red-500 @enderror"
                            required>{{ old('reason') }}</textarea>
                        <p class="text-xs text-slate-500 mt-2">Minimum 50 characters required ({{ strlen(old('reason', '')) }}/50)</p>
                        @error('reason')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-6 py-4 bg-red-600 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-red-700 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Submit Final Appeal
                    </button>
                </form>
            </div>
        @else
            {{-- Initial Appeal Form --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
                <form action="{{ route('appeals.store', $submission) }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="appeal_reason" class="block text-sm font-bold text-slate-900 mb-3">
                            Reason for Appeal
                        </label>
                        <textarea
                            name="reason"
                            id="appeal_reason"
                            rows="7"
                            placeholder="Please explain why you believe your manuscript should be reconsidered. Provide details about the research quality, methodology, or any concerns about the initial screening decision..."
                            class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition-all text-slate-700 @error('reason') border-red-500 @enderror"
                            required>{{ old('reason') }}</textarea>
                        <p class="text-xs text-slate-500 mt-2">Minimum 50 characters required ({{ strlen(old('reason', '')) }}/50)</p>
                        @error('reason')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-6 py-4 bg-red-600 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-red-700 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Submit Appeal
                    </button>
                </form>
            </div>
        @endif
    </section>
@endif
