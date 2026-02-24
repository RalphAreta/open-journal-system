{{-- Revision Review Form for Editors --}}
@if($submission->status === 'revisions_requested' && $submission->revisionRequests->where('revised_at', '!=', null)->count() > 0 && auth()->user()->id === $submission->assigned_editor_id)
    <section class="space-y-6 mt-12">
        <div class="flex items-center gap-4">
            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Revised Submission Review</h2>
            <div class="h-px bg-slate-100 flex-1"></div>
        </div>

        <div class="bg-indigo-50 border border-indigo-200 rounded-3xl p-8">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-900">Review Revised Manuscript</h3>
                    <p class="text-sm text-slate-600 mt-1">Compare the revised submission against the original feedback and make your final decision.</p>
                </div>
            </div>

            {{-- Revision History --}}
            <div class="bg-white rounded-2xl p-6 mb-6 border border-slate-200">
                <h4 class="font-black text-slate-900 mb-4 text-sm">Revision History</h4>
                <div class="space-y-3">
                    @foreach($submission->revisionRequests->sortByDesc('requested_at') as $revision)
                        <div class="border-l-2 border-slate-200 pl-4 py-2">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-slate-900 text-sm">
                                        Revision requested by {{ $revision->requestedBy->name }}
                                    </p>
                                    <p class="text-xs text-slate-600 mt-1">
                                        Type: <span class="font-semibold text-slate-900">{{ ucfirst($revision->revision_type) }}</span>
                                    </p>
                                    <p class="text-xs text-slate-600">Requested: {{ $revision->requested_at->format('M d, Y h:i A') }}</p>
                                </div>
                                @if($revision->revised_at)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-semibold rounded-full">✓ Revised</span>
                                @else
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] font-semibold rounded-full">⏳ Pending</span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-700 mt-2 bg-slate-50 p-3 rounded">{{ $revision->reason }}</p>
                            @if($revision->revised_at)
                                <div class="mt-3 p-3 bg-green-50 rounded text-sm">
                                    <p class="text-xs font-semibold text-green-700 mb-1">Author's Response Notes:</p>
                                    <p class="text-slate-700">{{ $revision->revision_notes }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Review Form --}}
            <form method="POST" action="{{ route('editor.revision-review', $submission) }}" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-black text-slate-900 uppercase tracking-widest mb-3">
                        Your Assessment <span class="text-red-600">*</span>
                    </label>
                    <textarea name="revision_assessment" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"