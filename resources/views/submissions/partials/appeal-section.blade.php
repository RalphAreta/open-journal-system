{{-- Appeal Section for Rejected Manuscripts --}}
@if($submission->initial_screening_status === 'failed' && auth()->user()->id === $submission->author_id)
    @php
        $existingAppeal = $submission->appeals()->first();
    @endphp
    
    <section class="space-y-6">
        <div class="flex items-center gap-4">
            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Request Appeal</h2>
            <div class="h-px bg-slate-100 flex-1"></div>
        </div>

        @if($existingAppeal)
            {{-- Appeal Already Exists --}}
            <div class="bg-blue-50 border-2 border-blue-200 rounded-3xl p-8">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H3a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 000-2h2a2 2 0 012 2v12a2 2 0 01-2 2H3a2 2 0 01-2-2V5z" clip-rule="evenodd"/><path d="M7 7a1 1 0 000 2h6a1 1 0 000-2H7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-blue-900 tracking-tight">Appeal Already Submitted</h3>
                        <p class="text-sm text-blue-800 font-medium mt-1">
                            You've submitted an appeal on {{ $existingAppeal->created_at->format('M d, Y') }}. 
                            Status: <strong>{{ ucfirst($existingAppeal->status) }}</strong>
                        </p>
                    </div>
                </div>

                @if($existingAppeal->reviewed_at)
                    <div class="bg-white rounded-2xl p-4 mt-4">
                        <p class="text-xs font-bold text-slate-500 uppercase mb-2">Editor's Response</p>
                        <p class="text-sm text-slate-700">{{ $existingAppeal->editor_response }}</p>
                    </div>
                @endif
            </div>
        @else
            {{-- Appeal Form --}}
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
