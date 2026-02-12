@extends('layouts.app')

@section('title', 'Editor Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900 mb-2">Editor Dashboard</h1>
    <p class="text-lg text-slate-600">Review and manage submissions</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-slate-200 p-5 transition-all duration-200 hover:border-slate-300">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-slate-700">Total Submissions</p>
            <span class="text-2xl">📊</span>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $stats['total'] }}</p>
        <p class="text-xs text-slate-700 mt-2">All submissions</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-slate-200 p-5 transition-all duration-200 hover:border-blue-200">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-slate-700">New (Submitted)</p>
            <span class="text-2xl">📥</span>
        </div>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['submitted'] }}</p>
        <p class="text-xs text-slate-700 mt-2">Awaiting distribution</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-slate-200 p-5 transition-all duration-200 hover:border-amber-200">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-slate-700">Under Review</p>
            <span class="text-2xl">👥</span>
        </div>
        <p class="text-3xl font-bold text-amber-600">{{ $stats['under_review'] }}</p>
        <p class="text-xs text-slate-700 mt-2">With reviewers</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-slate-200 p-5 transition-all duration-200 hover:border-red-200">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-slate-700">Decision Pending</p>
            <span class="text-2xl">⏳</span>
        </div>
        <p class="text-3xl font-bold text-red-600">{{ $stats['decisions_pending'] }}</p>
        <p class="text-xs text-slate-700 mt-2">Awaiting your decision</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-slate-900">Recent Submissions</h2>
        <a href="{{ route('editor.submissions') }}" class="text-red-600 hover:text-red-700 font-medium text-sm transition-colors">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($submissions as $s)
                    <tr class="hover:bg-slate-50 transition-colors duration-200">
                        <td class="px-6 py-4 text-sm text-slate-900 font-medium">{{ Str::limit($s->title, 45) }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $s->author->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ 
                                $s->status === 'submitted' ? 'bg-blue-100 text-blue-800' :
                                ($s->status === 'under_review' ? 'bg-amber-100 text-amber-800' :
                                ($s->status === 'accepted' ? 'bg-green-100 text-green-800' :
                                ($s->status === 'rejected' ? 'bg-red-100 text-red-800' :
                                'bg-slate-100 text-slate-800')))
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('editor.submission.show', $s) }}" class="text-red-600 hover:text-red-700 hover:underline text-sm font-medium transition-colors">Manage</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">No submissions available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-200 px-6 py-3 bg-slate-50">{{ $submissions->links() }}</div>
</div>
@endsection
