@extends('layouts.app')

@section('title', 'Revision Requests - ' . $submission->title)

@section('content')
    <div class="mb-8">
        <h1 class="text-5xl font-bold text-slate-900 mb-2">
            Revision Requests
        </h1>
        <p class="text-lg text-slate-600">{{ $submission->title }}</p>
    </div>

    @if ($submission->revisionRequests->count() === 0)
        <div
            class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center"
        >
            <p class="text-blue-700">No revision requests yet.</p>
        </div>
    @else
        {{-- CHANGED: idagdag ito --}}
        @php
            $latestPending = $submission->revisionRequests
                ->sortByDesc('requested_at')
                ->firstWhere('revised_at', null);
        @endphp

        <div class="space-y-6">
            @foreach ($submission->revisionRequests->sortByDesc('requested_at') as $revision)
                @php
                    $requester = $revision->requestedBy;
                    $role = null;
                    if ($requester) {
                        if ($requester->hasRole('editor-in-chief')) {
                            $role = ['label' => 'Editor-in-Chief', 'class' => 'bg-purple-100 text-purple-700'];
                        } elseif ($requester->hasRole('editor')) {
                            $role = ['label' => 'Editor', 'class' => 'bg-blue-100 text-blue-700'];
                        } elseif ($requester->hasRole('reviewer')) {
                            $role = ['label' => 'Reviewer', 'class' => 'bg-teal-100 text-teal-700'];
                        }
                    }
                @endphp

                <div
                    class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 {{ $revision->isResolved() ? 'opacity-75' : '' }}"
                >
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">
                                {{ ucfirst($revision->revision_type) }}
                                Revision Requested
                            </h2>
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="text-sm text-slate-600">
                                    Requested by
                                    <span class="font-semibold text-slate-900">
                                        {{ $requester?->name ?? 'Unknown' }}
                                    </span>
                                </p>
                                @if ($role)
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold {{ $role['class'] }}"
                                    >
                                        {{ $role['label'] }}
                                    </span>
                                @endif

                                <span class="text-slate-400 text-xs">•</span>
                                <p class="text-xs text-slate-500">
                                    {{ $revision->requested_at->format('F d, Y \a\t h:i A') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            <span
                                class="inline-block px-4 py-2 rounded-lg font-semibold {{ $revision->revision_type === 'minor' ? 'bg-yellow-100 text-yellow-700' : 'bg-orange-100 text-orange-700' }}"
                            >
                                {{ $revision->revision_type === 'minor' ? '⚡ Minor' : '🔴 Major' }}
                            </span>
                            @if ($revision->isResolved())
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700"
                                >
                                    ✓ Resolved
                                </span>
                            @else
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700"
                                >
                                    ⏳ Pending
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-slate-900 mb-2">
                            Reason for Revision
                        </h3>
                        <p class="text-slate-700 whitespace-pre-wrap">
                            {{ $revision->reason }}
                        </p>
                    </div>

                    @if ($revision->isResolved())
                        <div
                            class="bg-green-50 border border-green-200 rounded-lg p-4"
                        >
                            <p class="text-green-700 font-semibold">
                                ✓ Revised Manuscript Submitted
                            </p>
                            <p class="text-sm text-green-600 mt-1">
                                Submitted on
                                {{ $revision->revised_at->format('F d, Y \a\t h:i A') }}
                            </p>
                            @if ($revision->revision_notes)
                                <p class="text-sm text-slate-600 mt-3">
                                    <span class="font-semibold">
                                        Your Notes:
                                    </span>
                                    {{ $revision->revision_notes }}
                                </p>
                            @endif
                        </div>
                    @else
                        {{-- CHANGED: palitan yung dati na direct form, ngayon may condition --}}
                        @if ($revision->id === $latestPending?->id)
                            <form
                                method="POST"
                                action="{{ route('submissions.submit-revision', $submission) }}"
                                enctype="multipart/form-data"
                                class="space-y-4"
                            >
                                @csrf
                                <input
                                    type="hidden"
                                    name="revision_request_id"
                                    value="{{ $revision->id }}"
                                />

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-900 mb-2"
                                    >
                                        Upload Revised Manuscript
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <div
                                        class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-red-500 transition-colors cursor-pointer"
                                        id="file-drop-{{ $revision->id }}"
                                    >
                                        <input
                                            type="file"
                                            name="file"
                                            required
                                            accept=".pdf,.doc,.docx"
                                            class="hidden"
                                            id="file-input-{{ $revision->id }}"
                                        />
                                        <svg
                                            class="w-12 h-12 mx-auto mb-2 text-slate-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 4v16m8-8H4"
                                            ></path>
                                        </svg>
                                        <p class="text-sm text-slate-600">
                                            <span
                                                class="font-semibold text-red-600 cursor-pointer"
                                            >
                                                Click to upload
                                            </span>
                                            or drag and drop
                                        </p>
                                        <p class="text-xs text-slate-500 mt-1">
                                            PDF, DOC or DOCX (Max 10MB)
                                        </p>
                                        <p
                                            id="file-name-{{ $revision->id }}"
                                            class="text-sm text-red-600 font-semibold mt-2 hidden"
                                        ></p>
                                    </div>
                                    @error('file')
                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-slate-900 mb-2"
                                    >
                                        Revision Notes
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <textarea
                                        name="revision_notes"
                                        required
                                        rows="4"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                        placeholder="Describe the changes you made in this revision..."
                                    ></textarea>
                                    @error('revision_notes')
                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 font-semibold transition-colors"
                                >
                                    ✓ Submit Revised Manuscript to
                                    {{ $requester?->name ?? 'Requester' }}
                                </button>
                            </form>
                        @else
                            {{-- CHANGED: para sa older pending revisions --}}
                            <div
                                class="bg-amber-50 border border-amber-200 rounded-lg p-4"
                            >
                                <p class="text-amber-700 font-semibold">
                                    ⏳ Awaiting Revision
                                </p>
                                <p class="text-sm text-amber-600 mt-1">
                                    Submit the latest revision request first
                                    before addressing this one.
                                </p>
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-8">
        <a
            href="{{ route('submissions.show', $submission) }}"
            class="inline-block text-red-600 hover:text-red-700 transition-colors font-medium"
        >
            ← Back to Submission
        </a>
    </div>

    <script>
        @foreach ($submission->revisionRequests->where('revised_at', null) as $revision)
                (function() {
                    const dropZone  = document.getElementById('file-drop-{{ $revision->id }}');
                    const fileInput = document.getElementById('file-input-{{ $revision->id }}');
                    const fileName  = document.getElementById('file-name-{{ $revision->id }}');

                    if (!dropZone) return;   {{-- CHANGED: yung if (!dropZone) return; dito na nagagamit nang tama --}}

                    dropZone.addEventListener('click', () => fileInput.click());

                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => {
                        dropZone.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); });
                    });

                    ['dragenter', 'dragover'].forEach(e => {
                        dropZone.addEventListener(e, () => dropZone.classList.add('border-red-500', 'border-solid'));
                    });

                    ['dragleave', 'drop'].forEach(e => {
                        dropZone.addEventListener(e, () => dropZone.classList.remove('border-red-500', 'border-solid'));
                    });

                    dropZone.addEventListener('drop', e => {
                        fileInput.files = e.dataTransfer.files;
                        showName(e.dataTransfer.files[0]);
                    });

                    fileInput.addEventListener('change', () => {
                        if (fileInput.files.length) showName(fileInput.files[0]);
                    });

                    function showName(file) {
                        fileName.textContent = '📄 ' + file.name;
                        fileName.classList.remove('hidden');
                    }
                })();
            @endforeach
    </script>
@endsection
