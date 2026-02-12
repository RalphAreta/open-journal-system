@extends('layouts.app')

@section('title', 'Reviewer Dashboard')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Reviewer Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Pending Reviews</p>
        <p class="text-2xl font-semibold">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Completed Reviews</p>
        <p class="text-2xl font-semibold text-green-600">{{ $stats['completed'] }}</p>
    </div>
</div>
<h2 class="text-lg font-medium mb-4">Review Assignments</h2>
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Submission</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Author</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($assignments as $a)
                <tr>
                    <td class="px-4 py-3 text-sm">{{ Str::limit($a->submission->title ?? '', 40) }}</td>
                    <td class="px-4 py-3 text-sm">{{ $a->submission->author->name ?? '-' }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full {{ $a->status === 'completed' ? 'bg-green-100' : 'bg-amber-100' }}">{{ $a->status }}</span></td>
                    <td class="px-4 py-3 text-right">
                        @if($a->status === 'assigned')
                            <a href="{{ route('reviews.create', ['assignment' => $a]) }}" class="text-indigo-600 hover:underline text-sm">Submit Review</a>
                        @else
                            <span class="text-slate-400 text-sm">Completed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No review assignments.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-2 border-t border-slate-200">{{ $assignments->links() }}</div>
</div>
@endsection
