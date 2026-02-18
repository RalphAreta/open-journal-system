@php
use App\Models\Submission;
@endphp

@extends('layouts.app')

@section('title', 'Chief Editor Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-5xl font-bold text-slate-900 mb-2">Chief Editor Dashboard</h1>
    <p class="text-lg text-slate-600">Manage submissions and assign editors</p>
</div>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Total Submissions</p>
                <p class="text-4xl font-bold text-slate-900 mt-2">{{ $stats['total_submissions'] }}</p>
            </div>
            <span class="text-5xl opacity-20">📄</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Pending Assignment</p>
                <p class="text-4xl font-bold text-red-600 mt-2">{{ $stats['pending_assignments'] }}</p>
            </div>
            <span class="text-5xl opacity-20">⏳</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Under Review</p>
                <p class="text-4xl font-bold text-slate-900 mt-2">{{ $stats['under_review'] }}</p>
            </div>
            <span class="text-5xl opacity-20">👁️</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Completed</p>
                <p class="text-4xl font-bold text-green-600 mt-2">{{ $stats['completed'] }}</p>
            </div>
            <span class="text-5xl opacity-20">✓</span>
        </div>
    </div>
</div>

<!-- Pending Submissions (Need Assignment) -->
<div class="mb-10">
    <h2 class="text-3xl font-bold text-slate-900 mb-6">Pending Assignments</h2>

    @if ($pendingSubmissions->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Author</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Research Field</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Submitted</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($pendingSubmissions as $submission)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-900">{{ Str::limit($submission->title, 40) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-slate-600">{{ $submission->author->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $submission->research_field ?? 'Not specified' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-600">{{ $submission->submitted_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('chief-editor.submission.show', $submission) }}" class="inline-block text-red-600 hover:text-red-700 font-semibold text-sm transition-colors">
                                        Review & Assign →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $pendingSubmissions->links() }}
    @else
        <div class="bg-green-50 border border-green-200 rounded-xl p-8 text-center">
            <p class="text-green-700 font-medium">✓ All submissions have been assigned!</p>
        </div>
    @endif
</div>

<!-- Assigned Submissions -->
<div>
    <h2 class="text-3xl font-bold text-slate-900 mb-6">Assigned Submissions</h2>

    @if ($assignedSubmissions->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Assigned Editor</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Assigned Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($assignedSubmissions as $submission)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-900">{{ Str::limit($submission->title, 40) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-slate-600">{{ $submission->assignedEditor->name ?? 'Unassigned' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        {{ $submission->status === 'accepted' ? 'bg-green-50 text-green-700' : '' }}
                                        {{ $submission->status === 'rejected' ? 'bg-red-50 text-red-700' : '' }}
                                        {{ $submission->status === 'under_review' ? 'bg-blue-50 text-blue-700' : '' }}
                                        {{ $submission->status === 'revisions_requested' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                    ">
                                        {{ Submission::statusOptions()[$submission->status] ?? $submission->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-600">
                                        {{ $submission->chief_editor_review_at?->format('M d, Y') ?? '-' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('chief-editor.submission.show', $submission) }}" class="inline-block text-red-600 hover:text-red-700 font-semibold text-sm transition-colors">
                                        View →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $assignedSubmissions->links('pagination::tailwind') }}
    @else
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-8 text-center">
            <p class="text-slate-600">No assigned submissions yet.</p>
        </div>
    @endif
</div>
@endsection
