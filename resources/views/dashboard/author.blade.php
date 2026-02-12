@extends('layouts.app')

@section('title', 'Author Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-red-700 mb-2">Author Dashboard</h1>
    <p class="text-slate-600">Manage your submissions</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-red-100">
        <p class="text-sm text-slate-700 font-medium">Total Submissions</p>
        <p class="text-2xl font-bold text-black">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-red-100">
        <p class="text-sm text-slate-700 font-medium">Submitted</p>
        <p class="text-2xl font-bold text-black">{{ $stats['submitted'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-red-100">
        <p class="text-sm text-slate-700 font-medium">Under Review</p>
        <p class="text-2xl font-bold text-yellow-500">{{ $stats['under_review'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-green-100">
        <p class="text-sm text-slate-700 font-medium">Accepted</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['accepted'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-red-100">
        <p class="text-sm text-slate-700 font-medium">Rejected</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
    </div>
</div>
<div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-medium">My Submissions</h2>
    <a href="{{ route('submissions.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-sm font-medium shadow-sm transition-colors">New Submission</a>
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
                        <a href="{{ route('submissions.show', $s) }}" class="text-red-600 hover:text-red-700 hover:underline text-sm font-medium">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No submissions yet. <a href="{{ route('submissions.create') }}" class="text-red-600 hover:text-red-700 font-medium">Submit an article</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-2 border-t border-slate-200">{{ $submissions->links() }}</div>
</div>
@endsection
