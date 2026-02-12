@extends('layouts.app')

@section('title', 'Editor Dashboard')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Editor Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Total Submissions</p>
        <p class="text-2xl font-semibold">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">New (Submitted)</p>
        <p class="text-2xl font-semibold">{{ $stats['submitted'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Under Review</p>
        <p class="text-2xl font-semibold">{{ $stats['under_review'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border border-slate-200">
        <p class="text-sm text-slate-500">Decisions Pending</p>
        <p class="text-2xl font-semibold text-amber-600">{{ $stats['decisions_pending'] }}</p>
    </div>
</div>
<div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-medium">All Submissions</h2>
    <a href="{{ route('editor.submissions') }}" class="text-indigo-600 hover:underline text-sm">View all</a>
</div>
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Author</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($submissions as $s)
                <tr>
                    <td class="px-4 py-3 text-sm">{{ Str::limit($s->title, 45) }}</td>
                    <td class="px-4 py-3 text-sm">{{ $s->author->name ?? '-' }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-slate-100">{{ $s->status }}</span></td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('editor.submission.show', $s) }}" class="text-indigo-600 hover:underline text-sm">Manage</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No submissions.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-2 border-t border-slate-200">{{ $submissions->links() }}</div>
</div>
@endsection
