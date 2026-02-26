        @extends('layouts.app')

        @section('title', 'Initial Screening')

        @section('content')
        <div class="max-w-4xl">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-slate-900">Initial Screening</h1>
                <p class="text-lg text-slate-600 mt-2">{{ $submission->title }}</p>
                <p class="text-slate-700 mt-1">Author: {{ $submission->author->name }}</p>
            </div>

            <div class="bg-white rounded-lg shadow border border-slate-200 p-6 mb-6">
                <h2 class="text-xl font-semibold text-slate-900 mb-4">Submission Details</h2>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Research Field</label>
                        <p class="text-slate-900">{{ $submission->research_field ?? 'Not specified' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Submitted On</label>
                        <p class="text-slate-900">{{ $submission->submitted_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="text-sm font-medium text-slate-700">Abstract</label>
                    <p class="text-slate-700 mt-2 leading-relaxed">{{ $submission->abstract }}</p>
                </div>

                <div class="mb-6">
                    <label class="text-sm font-medium text-slate-700">Keywords</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach (explode(',', $submission->keywords) as $keyword)
                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                                {{ trim($keyword) }}
                            </span>
                        @endforeach
                    </div>
                </div>

                @if($submission->file_path)
                    <div>
                        <label class="text-sm font-medium text-slate-700">Submission File</label>
                        <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded mt-2">
                            <p class="text-sm text-blue-900"><strong>{{ $submission->file_name }}</strong></p>
                            <a href="{{ route('submissions.download', ['submission' => $submission]) }}" class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium">
                                Download
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow border border-slate-200 p-6">
                <h2 class="text-xl font-semibold text-slate-900 mb-6">Initial Screening Decision</h2>

                <x-validation-errors />

                <form action="{{ route('chief-editor.store-initial-screening', $submission) }}" method="POST">
                    @csrf

                 <div class="mb-6">
    <label class="block text-sm font-semibold text-slate-900 mb-3">
        Screening Decision
    </label>
    <div class="space-y-3">
        <div class="flex items-center">
            <input type="radio" id="passed" name="screening_status" value="passed"
                class="h-4 w-4 text-green-600 cursor-pointer screening-radio"
                {{ old('screening_status') === 'passed' ? 'checked' : '' }} required>
            <label for="passed" class="ml-3 cursor-pointer">
                <span class="text-sm font-medium text-slate-900">✓ PASSED</span>
                <span class="text-sm text-slate-600"> — Meets criteria, proceed to editor assignment</span>
            </label>
        </div>
        <div class="flex items-center">
            <input type="radio" id="failed" name="screening_status" value="failed"
                class="h-4 w-4 text-red-600 cursor-pointer screening-radio"
                {{ old('screening_status') === 'failed' ? 'checked' : '' }}>
            <label for="failed" class="ml-3 cursor-pointer">
                <span class="text-sm font-medium text-slate-900">✗ FAILED</span>
                <span class="text-sm text-slate-600"> — Does not meet initial criteria</span>
            </label>
        </div>
    </div>
</div>

{{-- Revision type field - visible only when REQUEST REVISION is selected --}}
<div id="revision-type-field" class="mb-6" style="{{ old('screening_status') === 'revision' ? '' : 'display:none' }}">
    <label class="block text-sm font-semibold text-slate-900 mb-2">
        Revision Type <span class="text-red-600">*</span>
    </label>
    <select name="revision_type" id="revision_type"
        class="w-full max-w-xs rounded-lg border border-slate-300 shadow-sm p-2">
        <option value="">-- Select --</option>
        <option value="minor" {{ old('revision_type') === 'minor' ? 'selected' : '' }}>Minor Revision</option>
        <option value="major" {{ old('revision_type') === 'major' ? 'selected' : '' }}>Major Revision</option>
    </select>
</div>

                    <div class="mb-6">
                        <label for="comments" class="block text-sm font-semibold text-slate-900 mb-2">
                            Screening Comments
                        </label>
                        <p class="text-sm text-slate-600 mb-3">
                            These comments will be sent to the author to explain the screening decision.
                        </p>

                        <textarea
                            id="comments"
                            name="comments"
                            rows="6"
                            maxlength="2000"
                            class="w-full rounded-lg border border-slate-300 shadow-sm p-3 text-slate-900"
                            placeholder="Provide detailed feedback about the screening decision. Include specific reasons for passing or failing the manuscript..."
                        >{{ old('comments') }}</textarea>
                        <p class="text-xs text-slate-500 mt-1"><span id="char-count">0</span>/2000 characters</p>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                        <a
                            href="{{ route('chief-editor.submission.show', $submission) }}"
                            class="text-slate-700 hover:text-slate-900 font-medium"
                        >
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                        >
                            Submit Screening Decision
                        </button>
                    </div>

                    <script>
    const screeningRadios = document.querySelectorAll('.screening-radio');
    const commentsTextarea = document.getElementById('comments');
    const charCountSpan = document.getElementById('char-count');

    const autoComments = {
        passed: `Thank you for submitting your manuscript to our journal. This manuscript has successfully passed our initial screening review and meets the criteria for further consideration.

Your manuscript will now be assigned to our peer review process. We will keep you updated on the progress of your submission.

We appreciate your interest in our journal.`,

        failed: `Thank you for submitting your manuscript to our journal. After careful initial screening, we regret to inform you that your manuscript does not meet our journal's criteria at this time.

Key reasons for this decision:
- [Please specify reasons]

We encourage you to address these concerns and consider resubmitting your work in the future.

Best regards,
Editorial Office`
    };

    function updateCommentAutomatically() {
        const screeningStatus = document.querySelector('input[name="screening_status"]:checked')?.value;

        if (screeningStatus === 'passed') {
            commentsTextarea.value = autoComments.passed;
        } else if (screeningStatus === 'failed') {
            commentsTextarea.value = autoComments.failed;
        }

        updateCharCount();
    }

    function updateCharCount() {
        charCountSpan.textContent = commentsTextarea.value.length;
    }

    commentsTextarea.addEventListener('input', updateCharCount);

    screeningRadios.forEach(r => r.addEventListener('change', updateCommentAutomatically));

    // Initialize on page load
    updateCommentAutomatically();
    updateCharCount();
</script>
                </form>
            </div>
        </div>
        @endsection
