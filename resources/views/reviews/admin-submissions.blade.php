@extends('layouts.app')

@section('title', 'Manage Submissions')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                <a href="{{ route('dashboard.admin') }}" class="hover:text-red-600 transition-colors">Admin</a>
                <span>&gt;</span>
                <span class="text-slate-900">Submissions</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900">Manage Submissions</h1>
            <p class="text-sm text-slate-500 mt-1">View and manage all incoming user submissions.</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Added Back Button --}}
            <a href="{{ route('dashboard.admin') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-500 rounded-lg text-sm font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back
            </a>

            <div class="bg-slate-100 px-4 py-2 rounded-lg border border-slate-200">
                <span class="text-sm font-medium text-slate-600">Total: {{ $submissions->total() }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Author</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($submissions as $s)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                {{ Str::limit($s->title, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $s->author->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColor = match(strtolower($s->status)) {
                                        'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'pending'  => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
                                        default    => 'bg-slate-50 text-slate-700 border-slate-100',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full border {{ $statusColor }} uppercase">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.submissions.show', $s) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-slate-500 font-medium">No submissions found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
