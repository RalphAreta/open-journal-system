@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')
<div class="max-w-4xl">
    <h1 class="text-2xl font-semibold mb-6">{{ $submission->title }}</h1>
    <div class="bg-white rounded-lg shadow border border-slate-200 p-6 space-y-4 mb-6">
        <p><span class="text-slate-500">Author:</span> {{ $submission->author->name }}</p>
        <p><span class="text-slate-500">Status:</span> <span class="px-2 py-1 rounded-full bg-slate-100">{{ $submission->status }}</span></p>
        <p><span class="text-slate-500">Abstract:</span> {{ $submission->abstract }}</p>
        
        <div class="border-t pt-4">
            <p class="font-medium text-slate-700 mb-3">Submission File</p>
            @if($submission->file_path)
                <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded">
                    <div>
                        <p class="text-sm text-blue-700"><strong>File:</strong> {{ $submission->file_name }}</p>
                    </div>
                    <a href="{{ route('submissions.download', ['submission' => $submission]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                        Download file
                    </a>
                </div>
            @else
                <p class="text-slate-500 italic">No file submitted.</p>
            @endif
        </div>

        @if($submission->reviews->isNotEmpty())
            <div class="border-t pt-4">
                <p class="font-medium text-slate-700 mb-2">Reviews</p>
                @foreach($submission->reviews as $r)
                    <div class="mb-3 p-3 bg-slate-50 rounded">
                        <p class="text-sm"><strong>{{ $r->reviewer->name }}</strong> — {{ \App\Models\Review::recommendationOptions()[$r->recommendation] ?? $r->recommendation }}</p>
                        @if($r->comments_for_editor)<p class="mt-1 text-slate-600 text-sm">{{ $r->comments_for_editor }}</p>@endif
                        @if($r->comments_for_author)<p class="mt-1 text-slate-500 text-sm">For author: {{ Str::limit($r->comments_for_author, 100) }}</p>@endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.submissions') }}" class="text-red-600 hover:underline">← Back to submissions</a>
    </div>
</div>
@endsection
