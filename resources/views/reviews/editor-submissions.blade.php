@extends('layouts.app')

@section('title', 'Manage Submissions')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Manage Submissions</h1>
<div class="bg-white rounded-lg shadow overflow-hidden border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Author</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-slate-700 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($submissions as $s)
                <tr>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ Str::limit($s->title, 50) }}</td>
                    <td class="px-4 py-3 text-sm text-slate-900">{{ $s->author->name ?? '-' }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-900">{{ $s->status }}</span></td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('editor.submission.show', $s) }}" class="text-red-600 hover:underline text-sm font-medium">Manage</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-700">No submissions.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-2 border-t border-slate-200">{{ $submissions->links() }}</div>
</div>
@endsection
