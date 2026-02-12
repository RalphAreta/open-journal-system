@extends('layouts.app')

@section('title', 'My Submissions')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">My Submissions</h1>
    <a href="{{ route('submissions.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">New Submission</a>
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
                    <td class="px-4 py-3 text-sm">{{ Str::limit($s->title, 55) }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-slate-100">{{ $s->status }}</span></td>
                    <td class="px-4 py-3 text-sm text-slate-500">{{ $s->submitted_at?->format('M d, Y') ?? '-' }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('submissions.show', $s) }}" class="text-indigo-600 hover:underline text-sm">View</a>
                        @if($s->isEditableByAuthor())
                            <a href="{{ route('submissions.edit', $s) }}" class="ml-2 text-indigo-600 hover:underline text-sm">Edit</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No submissions. <a href="{{ route('submissions.create') }}" class="text-indigo-600">Create one</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-2 border-t border-slate-200">{{ $submissions->links() }}</div>
</div>
@endsection
