@extends('layouts.app')

@section('title', 'Author Dashboard')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Author Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Total Submissions</p>
        <p class="text-2xl font-semibold">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Submitted</p>
        <p class="text-2xl font-semibold">{{ $stats['submitted'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Under Review</p>
        <p class="text-2xl font-semibold">{{ $stats['under_review'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Accepted</p>
        <p class="text-2xl font-semibold text-green-600">{{ $stats['accepted'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Rejected</p>
        <p class="text-2xl font-semibold text-red-600">{{ $stats['rejected'] }}</p>
    </div>
</div>
<div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-medium">My Submissions</h2>
    <a href="{{ route('submissions.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">New Submission</a>
</div>
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Submitted</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($submissions as $s)
                <tr>
                    <td class="px-4 py-3 text-sm">{{ Str::limit($s->title, 50) }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-slate-100">{{ $s->status }}</span></td>
                    <td class="px-4 py-3 text-sm text-slate-500">{{ $s->submitted_at?->format('M d, Y') ?? '-' }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('submissions.show', $s) }}" class="text-indigo-600 hover:underline text-sm">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No submissions yet. <a href="{{ route('submissions.create') }}" class="text-indigo-600">Submit an article</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-2 border-t border-slate-200">{{ $submissions->links() }}</div>
</div>
@endsection
