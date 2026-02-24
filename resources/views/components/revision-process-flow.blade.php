{{-- Revision Process Flow Timeline --}}
<div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
    <h3 class="text-lg font-black text-slate-900 tracking-tight mb-8">Revision Process Flow</h3>
    
    <div class="space-y-6">
        {{-- Step 1: Reviewer Recommends Revision --}}
        <div class="flex gap-4">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-black text-sm shrink-0">
                    1
                </div>
                <div class="w-0.5 h-16 bg-slate-200 mt-2"></div>
            </div>
            <div class="pt-1 pb-6">
                <p class="font-black text-slate-900 tracking-tight">Reviewer Recommends Revision</p>
                <p class="text-sm text-slate-600 mt-1">Reviewer submits review with recommendation (Minor/Major Revisions)</p>
                @if($submission->reviews->whereIn('recommendation', ['minor_revisions', 'major_revisions'])->count() > 0)
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">✓ Completed</span>
                @endif
            </div>
        </div>

        {{-- Step 2: Editor Decision --}}
        <div class="flex gap-4">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-black text-sm shrink-0">
                    2
                </div>
                <div class="w-0.5 h-16 bg-slate-200 mt-2"></div>
            </div>
            <div class="pt-1 pb-6">
                <p class="font-black text-slate-900 tracking-tight">Assigned Editor Decision</p>
                <p class="text-sm text-slate-600 mt-1">Editor reviews all recommendations and decides on Minor/Major Revision</p>
                @if($submission->status === 'revisions_requested')
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">✓ Completed</span>
                    <div class="mt-2 p-3 bg-slate-50 rounded-lg text-sm">
                        <p class="text-xs font-semibold text-slate-600 uppercase">Revision Type:</p>
                        <p class="font-semibold text-slate-900">
                            {{ $submission->revisionRequests->first()?->revision_type === 'minor' ? '📝 Minor Revisions' : '🔴 Major Revisions' }}
                        </p>
                    </div>
                @else
                    <span class="inline-block mt-2 px-3 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-full">⏳ Pending</span>
                @endif
            </div>
        </div>

        {{-- Step 3: System Notifies Author --}}
        <div class="flex gap-4">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-sm shrink-0">
                    3
                </div>
                <div class="w-0.5 h-16 bg-slate-200 mt-2"></div>
            </div>
            <div class="pt-1 pb-6">
                <p class="font-black text-slate-900 tracking-tight">System Notifies Author</p>
                <p class="text-sm text-slate-600 mt-1">Author receives notification with revision requests and feedback</p>
                @if($submission->status === 'revisions_requested')
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">✓ Notified</span>
                @endif
            </div>
        </div>

        {{-- Step 4: Author Uploads Revised Version --}}
        <div class="flex gap-4">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-black text-sm shrink-0">
                    4
                </div>
                <div class="w-0.5 h-16 bg-slate-200 mt-2"></div>
            </div>
            <div class="pt-1 pb-6">
                <p class="font-black text-slate-900 tracking-tight">Author Uploads Revised Version</p>
                <p class="text-sm text-slate-600 mt-1">Author addresses feedback and submits revised manuscript with notes</p>
                @php
                    $revisedSubmissions = $submission->revisionRequests->filter(fn($r) => !is_null($r->revised_at));
                @endphp
                @if($revisedSubmissions->count() > 0)
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">✓ Uploaded</span>
                    <div class="mt-2 p-3 bg-slate-50 rounded-lg text-sm">
                        <p class="text-xs font-semibold text-slate-600 uppercase">Submitted on:</p>
                        <p class="font-semibold text-slate-900">{{ $revisedSubmissions->first()->revised_at->format('M d, Y h:i A') }}</p>
                    </div>
                @else
                    <span class="inline-block mt-2 px-3 py-1 bg-amber-100 text-amber-600 text-xs font-semibold rounded-full">⏳ Awaiting</span>
                @endif
            </div>
        </div>

        {{-- Step 5: Editor Checks Revision --}}
        <div class="flex gap-4">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-sm shrink-0">
                    5
                </div>
                <div class="w-0.5 h-16 bg-slate-200 mt-2"></div>
            </div>
            <div class="pt-1 pb-6">
                <p class="font-black text-slate-900 tracking-tight">Editor Checks Revision</p>
                <p class="text-sm text-slate-600 mt-1">Editor reviews revised manuscript against original feedback</p>
                @if($submission->status === 'revisions_requested' && $revisedSubmissions->count() > 0)
                    <span class="inline-block mt-2 px-3 py-1 bg-amber-100 text-amber-600 text-xs font-semibold rounded-full">⏳ In Review</span>
                @endif
            </div>
        </div>

        {{-- Step 6: Final Decision --}}
        <div class="flex gap-4">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-black text-sm shrink-0">
                    ✓
                </div>
            </div>
            <div class="pt-1">
                <p class="font-black text-slate-900 tracking-tight">Final Decision</p>
                <p class="text-sm text-slate-600 mt-1">Editor makes final decision: Accept, Reject, or Request Further Revisions</p>
                @if(in_array($submission->status, ['accepted', 'rejected']))
                    <span class="inline-block mt-2 px-3 py-1 {{ $submission->status === 'accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs font-semibold rounded-full">
                        ✓ {{ ucfirst($submission->status) }}
                    </span>
                    @if($submission->editor_notes)
                        <div class="mt-2 p-3 bg-slate-50 rounded-lg text-sm">
                            <p class="text-xs font-semibold text-slate-600 uppercase">Decision Notes:</p>
                            <p class="text-slate-700 mt-1">{{ $submission->editor_notes }}</p>
                        </div>
                    @endif
                @elseif($submission->status === 'revisions_requested' && $revisedSubmissions->count() === 0)
                    <span class="inline-block mt-2 px-3 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-full">⏳ Pending</span>
                @endif
            </div>
        </div>
    </div>
</div>
