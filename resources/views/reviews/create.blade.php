@extends('layouts.app')

@section('title', 'Submit Review')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:py-8 px-4 sm:px-6">
        {{-- Header Section --}}
        <div class="mb-8 sm:mb-10">
            <nav
                class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 flex-wrap"
            >
                <a
                    href="{{ route('reviews.index') }}"
                    class="hover:text-red-600 transition-colors"
                >
                    My Reviews
                </a>
                <svg
                    class="w-3 h-3 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path d="M9 5l7 7-7 7" stroke-width="3" />
                </svg>
                <span class="text-slate-900 tracking-widest">
                    Submit Review
                </span>
            </nav>
            <h1
                class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tighter mb-2"
            >
                Review Submission
            </h1>
            <p class="text-slate-600 text-sm sm:text-base">
                {{ $submission->title }}
            </p>
        </div>

        {{-- Submission Info --}}
        <div
            class="bg-white rounded-lg shadow border border-slate-200 p-4 sm:p-6 mb-6"
        >
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <p
                        class="text-xs font-bold text-slate-400 uppercase tracking-widest"
                    >
                        Author
                    </p>
                    <p class="text-slate-900 font-semibold">
                        {{ $submission->author->name }}
                    </p>
                </div>
                <div>
                    <p
                        class="text-xs font-bold text-slate-400 uppercase tracking-widest"
                    >
                        Research Field
                    </p>
                    <span
                        class="inline-block bg-red-50 border border-red-200 text-red-700 px-2 py-0.5 rounded-full text-sm"
                    >
                        {{ $submission->research_field ?? 'Not specified' }}
                    </span>
                </div>
            </div>
            <div>
                <p
                    class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2"
                >
                    Abstract
                </p>
                <p class="text-slate-700 leading-relaxed text-sm sm:text-base">
                    {{ $submission->abstract }}
                </p>
            </div>
        </div>

        {{-- Submission File --}}
        <div
            class="bg-white rounded-lg shadow border border-slate-200 p-4 sm:p-6 mb-6"
        >
            <p
                class="text-xs font-bold text-slate-600 uppercase tracking-widest mb-4"
            >
                Submission File
            </p>

            @if ($submission->file_path)
                <div
                    class="flex items-start sm:items-center justify-between gap-3 flex-wrap"
                >
                    <div>
                        <p class="text-sm font-medium text-slate-700 mb-1">
                            {{ $submission->file_name }}
                        </p>
                        <p class="text-xs text-slate-500">PDF, DOC, or DOCX</p>
                    </div>
                    <a
                        href="{{ route('submissions.download', ['submission' => $submission]) }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors shrink-0"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                            />
                        </svg>
                        Download file
                    </a>
                </div>
            @else
                <p class="text-slate-700 italic text-sm">No file submitted.</p>
            @endif
        </div>

        {{-- Review Form --}}
        <div
            class="bg-white rounded-lg shadow border border-slate-200 p-4 sm:p-6"
        >
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-6">
                Submit Your Review
            </h2>

            <form
                method="POST"
                action="{{ route('reviews.store') }}"
                class="space-y-6"
            >
                @csrf
                <input
                    type="hidden"
                    name="review_assignment_id"
                    value="{{ $assignment->id }}"
                />

                {{-- Recommendation --}}
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-900 mb-3"
                    >
                        Recommendation
                        <span class="text-red-600">*</span>
                    </label>
                    <select
                        id="recommendation"
                        name="recommendation"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-white text-slate-900 font-medium focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all"
                    >
                        <option value="">— Select Recommendation —</option>
                        @foreach (\App\Models\Review::recommendationOptions() as $value => $label)
                            <option
                                value="{{ $value }}"
                                {{ old('recommendation', $existingReview?->recommendation) === $value ? 'selected' : '' }}
                            >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('recommendation')
                        <p class="text-red-600 text-xs font-medium mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Comments for Author --}}
                <div>
                    <label
                        for="comments_for_author"
                        class="block text-sm font-semibold text-slate-900 mb-3"
                    >
                        Review Comments
                    </label>
                    <textarea
                        id="comments_for_author"
                        name="comments_for_author"
                        rows="5"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all resize-none text-sm sm:text-base"
                        placeholder="Provide constructive feedback for the author..."
                    >
{{ old('comments_for_author', $existingReview?->comments_for_author) }}</textarea
                    >
                    @error('comments_for_author')
                        <p class="text-red-600 text-xs font-medium mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Comments for Editor --}}
                <div>
                    <label
                        for="comments_for_editor"
                        class="block text-sm font-semibold text-slate-900 mb-3"
                    >
                        Confidential Comments for Editor
                        <span class="text-slate-500 font-normal text-xs">
                            (confidential)
                        </span>
                    </label>
                    <textarea
                        id="comments_for_editor"
                        name="comments_for_editor"
                        rows="5"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all resize-none text-sm sm:text-base"
                        placeholder="Share any confidential notes with the editor..."
                    >
{{ old('comments_for_editor', $existingReview?->comments_for_editor) }}</textarea
                    >
                    @error('comments_for_editor')
                        <p class="text-red-600 text-xs font-medium mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Rating Scale Reference --}}
                <div
                    class="bg-slate-50 border border-slate-200 rounded-lg p-4 sm:p-6 mb-6"
                >
                    <h3
                        class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wide"
                    >
                        Rating Scale
                    </h3>
                    <div class="overflow-x-auto -mx-4 sm:mx-0">
                        <div class="min-w-[480px] px-4 sm:px-0 sm:min-w-0">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="border-b border-slate-300">
                                        <th
                                            class="text-left p-2 font-bold text-slate-900"
                                        >
                                            Range
                                        </th>
                                        <th
                                            class="text-left p-2 font-bold text-slate-900"
                                        >
                                            Label
                                        </th>
                                        <th
                                            class="text-left p-2 font-bold text-slate-900"
                                        >
                                            Description
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="border-b border-slate-200 bg-red-50"
                                    >
                                        <td
                                            class="p-2 font-medium text-slate-900"
                                        >
                                            1-20
                                        </td>
                                        <td class="p-2 text-slate-900">
                                            Critically deficient
                                        </td>
                                        <td class="p-2 text-slate-700">
                                            Fundamental flaws; unsuitable for
                                            publication
                                        </td>
                                    </tr>
                                    <tr
                                        class="border-b border-slate-200 bg-orange-50"
                                    >
                                        <td
                                            class="p-2 font-medium text-slate-900"
                                        >
                                            21-40
                                        </td>
                                        <td class="p-2 text-slate-900">
                                            Below standard
                                        </td>
                                        <td class="p-2 text-slate-700">
                                            Major deficiencies; significant
                                            revisions needed
                                        </td>
                                    </tr>
                                    <tr
                                        class="border-b border-slate-200 bg-amber-50"
                                    >
                                        <td
                                            class="p-2 font-medium text-slate-900"
                                        >
                                            41-55
                                        </td>
                                        <td class="p-2 text-slate-900">
                                            Acceptable but limited
                                        </td>
                                        <td class="p-2 text-slate-700">
                                            Concerns present; major revisions
                                            required
                                        </td>
                                    </tr>
                                    <tr
                                        class="border-b border-slate-200 bg-yellow-50"
                                    >
                                        <td
                                            class="p-2 font-medium text-slate-900"
                                        >
                                            56-70
                                        </td>
                                        <td class="p-2 text-slate-900">
                                            Competent work
                                        </td>
                                        <td class="p-2 text-slate-700">
                                            Acceptable quality; moderate
                                            revisions recommended
                                        </td>
                                    </tr>
                                    <tr
                                        class="border-b border-slate-200 bg-lime-50"
                                    >
                                        <td
                                            class="p-2 font-medium text-slate-900"
                                        >
                                            71-85
                                        </td>
                                        <td class="p-2 text-slate-900">
                                            Good to excellent
                                        </td>
                                        <td class="p-2 text-slate-700">
                                            Sound work; minimal revisions needed
                                        </td>
                                    </tr>
                                    <tr class="bg-green-50">
                                        <td
                                            class="p-2 font-medium text-slate-900"
                                        >
                                            86-100
                                        </td>
                                        <td class="p-2 text-slate-900">
                                            Outstanding
                                        </td>
                                        <td class="p-2 text-slate-700">
                                            Exemplary quality; ready for
                                            publication
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Rating --}}
                <div>
                    <label
                        for="rating"
                        class="block text-sm font-semibold text-slate-900 mb-3"
                    >
                        Rating
                        <span class="text-slate-500 font-normal text-xs">
                            (1-100, optional)
                        </span>
                    </label>
                    <div class="flex items-center gap-3 flex-wrap">
                        <input
                            id="rating"
                            type="number"
                            name="rating"
                            min="1"
                            max="100"
                            value="{{ old('rating', $existingReview?->rating) }}"
                            class="w-24 px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 font-medium focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all"
                            placeholder="0"
                        />
                        <span class="text-xs text-slate-500 font-medium">
                            / 100
                        </span>
                        <span
                            id="ratingInterpretation"
                            class="text-xs text-slate-600 font-semibold px-3 py-2 bg-slate-50 rounded-lg"
                        ></span>
                    </div>
                    @error('rating')
                        <p class="text-red-600 text-xs font-medium mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div
                    class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between pt-6 border-t border-slate-200 gap-3"
                >
                    <a
                        href="{{ route('reviews.index') }}"
                        class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors text-center sm:text-left"
                    >
                        Cancel
                    </a>
                    <div
                        class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3"
                    >
                        <button
                            type="submit"
                            name="action"
                            value="save_draft"
                            class="bg-slate-400 hover:bg-slate-500 text-white px-6 py-3 rounded-lg text-sm font-bold uppercase tracking-[.06em] transition-all duration-200 hover:-translate-y-0.5 shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-slate-300/50"
                        >
                            Save & Submit Later
                        </button>
                        <button
                            type="submit"
                            name="action"
                            value="submit"
                            class="bg-slate-900 hover:bg-red-600 text-white px-6 py-3 rounded-lg text-sm font-bold uppercase tracking-[.06em] transition-all duration-200 hover:-translate-y-0.5 shadow-md shadow-slate-200/80 hover:shadow-lg hover:shadow-red-200/50"
                        >
                            Submit Review
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ratingInput = document.getElementById('rating');
            const interpretationDisplay = document.getElementById(
                'ratingInterpretation',
            );

            function updateInterpretation(rating) {
                if (!rating || rating < 1 || rating > 100) {
                    interpretationDisplay.textContent = '';
                    return;
                }

                const interpretations = {
                    '1-20': 'Critically deficient',
                    '21-40': 'Below publication standard',
                    '41-55': 'Acceptable but limited',
                    '56-70': 'Competent work',
                    '71-85': 'Good to excellent',
                    '86-100': 'Outstanding contribution',
                };

                let interpretation = '';
                if (rating >= 1 && rating <= 20)
                    interpretation = interpretations['1-20'];
                else if (rating >= 21 && rating <= 40)
                    interpretation = interpretations['21-40'];
                else if (rating >= 41 && rating <= 55)
                    interpretation = interpretations['41-55'];
                else if (rating >= 56 && rating <= 70)
                    interpretation = interpretations['56-70'];
                else if (rating >= 71 && rating <= 85)
                    interpretation = interpretations['71-85'];
                else if (rating >= 86 && rating <= 100)
                    interpretation = interpretations['86-100'];

                interpretationDisplay.textContent = interpretation;
            }

            if (ratingInput) {
                ratingInput.addEventListener('input', function () {
                    updateInterpretation(this.value);
                });
                if (ratingInput.value) {
                    updateInterpretation(ratingInput.value);
                }
            }
        });
    </script>
@endsection
