@extends('layouts.app')

@section('title', 'New Submission')

@section('content')
<h1 class="text-2xl font-semibold mb-6">New Submission</h1>
<form method="POST" action="{{ route('submissions.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-4">
    @csrf
    <div>
        <label for="title" class="block text-sm font-medium text-slate-700">Title *</label>
        <input id="title" type="text" name="title" value="{{ old('title') }}" required
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="abstract" class="block text-sm font-medium text-slate-700">Abstract *</label>
        <textarea id="abstract" name="abstract" rows="5" required
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('abstract') border-red-500 @enderror">{{ old('abstract') }}</textarea>
        @error('abstract')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="keywords" class="block text-sm font-medium text-slate-700">Keywords</label>
        <input id="keywords" type="text" name="keywords" value="{{ old('keywords') }}" placeholder="Comma-separated"
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('keywords')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="file" class="block text-sm font-medium text-slate-700">Article file (PDF, DOC, DOCX) *</label>
        <input id="file" type="file" name="file" accept=".pdf,.doc,.docx" required
            class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-indigo-50 file:text-indigo-700">
        @error('file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Submit</button>
        <a href="{{ route('submissions.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-md hover:bg-slate-300">Cancel</a>
    </div>
</form>
@endsection
