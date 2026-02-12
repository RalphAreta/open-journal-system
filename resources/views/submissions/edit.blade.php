@extends('layouts.app')

@section('title', 'Edit Submission')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Edit Submission</h1>
<form method="POST" action="{{ route('submissions.update', $submission) }}" enctype="multipart/form-data" class="max-w-2xl space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label for="title" class="block text-sm font-medium text-slate-700">Title *</label>
        <input id="title" type="text" name="title" value="{{ old('title', $submission->title) }}" required
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="abstract" class="block text-sm font-medium text-slate-700">Abstract *</label>
        <textarea id="abstract" name="abstract" rows="5" required
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('abstract') border-red-500 @enderror">{{ old('abstract', $submission->abstract) }}</textarea>
        @error('abstract')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="keywords" class="block text-sm font-medium text-slate-700">Keywords</label>
        <input id="keywords" type="text" name="keywords" value="{{ old('keywords', $submission->keywords) }}"
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div>
        <label for="file" class="block text-sm font-medium text-slate-700">Replace file (optional)</label>
        <p class="text-sm text-slate-500 mb-1">Current: {{ $submission->file_name ?? 'None' }}</p>
        <input id="file" type="file" name="file" accept=".pdf,.doc,.docx"
            class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-indigo-50 file:text-indigo-700">
        @error('file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update</button>
        <a href="{{ route('submissions.show', $submission) }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-md hover:bg-slate-300">Cancel</a>
    </div>
</form>
@endsection
