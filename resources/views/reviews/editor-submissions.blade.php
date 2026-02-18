@extends('layouts.app')

@section('title', 'Manage Submissions')

@section('content')
@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <h3 class="font-semibold text-red-900 mb-2">Error</h3>
        <ul class="text-red-700 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-700 font-semibold">
        ✓ {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 text-red-700 font-semibold">
        ✗ {{ session('error') }}
    </div>
@endif

<h1 class="text-2xl font-semibold mb-6">Manage Submissions</h1>
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Author</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Reviews</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-700 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($submissions as $s)
                @php
                    $reviews = $s->reviews()->get();
                    $assignments = $s->reviewAssignments()->get();
                    $completed = $reviews->count();
                    $pending = $assignments->where('status', 'assigned')->count();
                    
                    $accepts = $reviews->where('recommendation', 'accept')->count();
                    $rejects = $reviews->where('recommendation', 'reject')->count();
                    $minorRevisions = $reviews->where('recommendation', 'minor_revisions')->count();
                    $majorRevisions = $reviews->where('recommendation', 'major_revisions')->count();
                @endphp
                <tr>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ Str::limit($s->title, 40) }}</td>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ $s->author->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full font-semibold
                            {{ $s->status === 'submitted' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $s->status === 'under_review' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $s->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $s->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $s->status === 'revisions_requested' ? 'bg-orange-100 text-orange-700' : '' }}
                        ">
                            {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if ($completed > 0 || $pending > 0)
                            <div class="flex items-center gap-2 text-xs">
                                @if ($accepts > 0)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full font-semibold">✓ {{ $accepts }}</span>
                                @endif
                                @if ($rejects > 0)
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full font-semibold">✗ {{ $rejects }}</span>
                                @endif
                                @if ($minorRevisions > 0)
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-semibold">⚠ {{ $minorRevisions }}</span>
                                @endif
                                @if ($majorRevisions > 0)
                                    <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-semibold">🔴 {{ $majorRevisions }}</span>
                                @endif
                                @if ($pending > 0)
                                    <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded-full font-semibold">⏳ {{ $pending }}</span>
                                @endif
                            </div>
                        @else
                            <span class="text-xs text-slate-500">No reviews yet</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('editor.submission.show', $s) }}" class="text-red-600 hover:underline text-sm font-medium">Manage</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-700">No submissions.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-2 border-t border-slate-200">{{ $submissions->links() }}</div>
</div>

<div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <p class="text-sm text-blue-700">
        <strong>Legend:</strong>
        <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs mr-2">✓ Accept</span>
        <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded text-xs mr-2">✗ Reject</span>
        <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs mr-2">⚠ Minor</span>
        <span class="inline-block bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs mr-2">🔴 Major</span>
        <span class="inline-block bg-slate-100 text-slate-700 px-2 py-1 rounded text-xs">⏳ Pending</span>
    </p>
</div>
@endsection
