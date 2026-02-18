@extends('layouts.app')

@section('title', 'Revision Requests - ' . $submission->title)

@section('content')
<div class="mb-8">
    <h1 class="text-5xl font-bold text-slate-900 mb-2">Revision Requests</h1>
    <p class="text-lg text-slate-600">{{ $submission->title }}</p>
</div>

@if ($submission->revisionRequests()->pending()->count() === 0)
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center">
        <p class="text-blue-700">No pending revision requests.</p>
    </div>
@else
    <div class="space-y-6">
        @foreach ($submission->revisionRequests()->pending()->latest()->get() as $revision)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">
                            {{ ucfirst($revision->revision_type) }} Revisions Requested
                        </h2>
                        <p class="text-sm text-slate-600">
                            Requested by {{ $revision->requestedBy->name }} on 
                            {{ $revision->requested_at->format('F d, Y \a\t h:i A') }}
                        </p>
                    </div>
                    <span class="inline-block px-4 py-2 rounded-lg font-semibold
                        {{ $revision->revision_type === 'minor' ? 'bg-yellow-100 text-yellow-700' : 'bg-orange-100 text-orange-700' }}
                    ">
                        {{ $revision->revision_type === 'minor' ? '⚠️ Minor' : '🔴 Major' }}
                    </span>
                </div>

                <div class="bg-slate-50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-slate-900 mb-2">Reason for Revision</h3>
                    <p class="text-slate-700 whitespace-pre-wrap">{{ $revision->reason }}</p>
                </div>

                @if (!$revision->isResolved())
                    <form method="POST" action="{{ route('submissions.submit-revision', $submission) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="revision_request_id" value="{{ $revision->id }}">

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Upload Revised Manuscript</label>
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-red-500 transition-colors cursor-pointer" id="file-drop-{{ $revision->id }}">
                                <input type="file" name="file" required accept=".pdf,.doc,.docx" class="hidden" id="file-input-{{ $revision->id }}">
                                <p class="text-slate-600 mb-2">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </p>
                                <p class="text-sm text-slate-600">
                                    <span class="font-semibold text-red-600 cursor-pointer">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-slate-500 mt-1">PDF, DOC or DOCX (Max 10MB)</p>
                                <p id="file-name-{{ $revision->id }}" class="text-sm text-red-600 font-semibold mt-2 hidden"></p>
                            </div>
                            @error('file') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Revision Notes</label>
                            <textarea name="revision_notes" required rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Describe the changes you made in this revision..."></textarea>
                            @error('revision_notes') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 font-semibold transition-colors">
                            ✓ Submit Revised Manuscript
                        </button>
                    </form>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-green-700 font-semibold">✓ Resolved</p>
                        <p class="text-sm text-green-600 mt-1">
                            Revised manuscript submitted on {{ $revision->revised_at->format('F d, Y \a\t h:i A') }}
                        </p>
                        @if ($revision->revision_notes)
                            <p class="text-sm text-slate-600 mt-3">
                                <span class="font-semibold">Author Notes:</span> {{ $revision->revision_notes }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif

<div class="mt-8">
    <a href="{{ route('submissions.show', $submission) }}" class="inline-block text-red-600 hover:text-red-700 transition-colors font-medium">
        ← Back to Submission
    </a>
</div>

<script>
    // File drop handler
    @foreach ($submission->revisionRequests()->pending()->latest()->get() as $revision)
        const dropZone{{ $revision->id }} = document.getElementById('file-drop-{{ $revision->id }}');
        const fileInput{{ $revision->id }} = document.getElementById('file-input-{{ $revision->id }}');
        const fileName{{ $revision->id }} = document.getElementById('file-name-{{ $revision->id }}');

        dropZone{{ $revision->id }}.addEventListener('click', () => fileInput{{ $revision->id }}.click());

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone{{ $revision->id }}.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone{{ $revision->id }}.addEventListener(eventName, () => {
                dropZone{{ $revision->id }}.classList.add('border-red-500', 'border-solid');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone{{ $revision->id }}.addEventListener(eventName, () => {
                dropZone{{ $revision->id }}.classList.remove('border-red-500', 'border-solid');
            }, false);
        });

        dropZone{{ $revision->id }}.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput{{ $revision->id }}.files = files;
            updateFileName{{ $revision->id }}(files[0]);
        }, false);

        fileInput{{ $revision->id }}.addEventListener('change', () => {
            if (fileInput{{ $revision->id }}.files.length > 0) {
                updateFileName{{ $revision->id }}(fileInput{{ $revision->id }}.files[0]);
            }
        });

        function updateFileName{{ $revision->id }}(file) {
            fileName{{ $revision->id }}.textContent = '📄 ' + file.name;
            fileName{{ $revision->id }}.classList.remove('hidden');
        }
    @endforeach
</script>
@endsection
