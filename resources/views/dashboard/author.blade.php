@extends('layouts.app')

@section('title', 'Author Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-5xl font-bold text-slate-900 mb-2">Author Dashboard</h1>
    <p class="text-slate-600">Manage your submissions</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-red-100">
        <p class="text-md text-slate-700 font-medium">Total Submissions</p>
        <p class="text-2xl font-bold text-black">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-red-100">
        <p class="text-md text-slate-700 font-medium">Submitted</p>
        <p class="text-2xl font-bold text-black">{{ $stats['submitted'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-red-100">
        <p class="text-md text-slate-700 font-medium">Under Review</p>
        <p class="text-2xl font-bold text-yellow-500">{{ $stats['under_review'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-orange-100">
        <p class="text-md text-slate-700 font-medium">Revisions Requested</p>
        <p class="text-2xl font-bold text-orange-600">{{ $stats['revisions_requested'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-green-100">
        <p class="text-md text-slate-700 font-medium">Accepted</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['accepted'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 border-2 border-red-100">
        <p class="text-md text-slate-700 font-medium">Rejected</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
    </div>
</div>
<div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-medium">My Submissions</h2>
    <a href="{{ route('submissions.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-sm font-medium shadow-sm transition-colors">New Submission</a>
</div>

@if ($stats['revisions_requested'] > 0)
    @php
        $revisionsNeeded = auth()->user()->submissionsAsAuthor()->where('status', 'revisions_requested')->get();
    @endphp
    <div class="mb-6 bg-orange-50 border border-orange-200 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <svg class="w-6 h-6 text-orange-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <div class="flex-1">
                <h3 class="font-bold text-orange-900 text-lg">Revisions Required</h3>
                <p class="text-sm text-orange-800 mt-2">You have {{ $stats['revisions_requested'] }} submission{{ $stats['revisions_requested'] > 1 ? 's' : '' }} that require revisions. Please review the feedback and submit your revised manuscripts.</p>
                <div class="mt-3 space-y-2">
                    @foreach ($revisionsNeeded as $submission)
                        <div class="flex items-center justify-between bg-white rounded p-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ Str::limit($submission->title, 50) }}</p>
                                <p class="text-sm text-slate-600">Requested {{ $submission->editor_decision_at->format('M d, Y') }}</p>
                            </div>
                            <a href="{{ route('submissions.revisions', $submission) }}" class="text-orange-700 hover:text-orange-900 font-semibold text-sm whitespace-nowrap">
                                View & Revise →
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

@if ($notifications->count() > 0)
    <div class="mb-6">
        <h2 class="text-lg font-medium mb-3">Notifications</h2>
        <div class="space-y-3">
            @foreach ($notifications as $notif)
                <div class="flex items-start gap-4 p-4 rounded-lg border
                    {{ $notif->isUnread() ? 'bg-white border-red-200 shadow-sm' : 'bg-slate-50 border-slate-200' }}">
                    <div class="text-xl mt-0.5">
                        @if ($notif->type === 'success') ✅
                        @elseif ($notif->type === 'danger') ❌
                        @elseif ($notif->type === 'warning') ⚠️
                        @else ℹ️
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <p class="font-semibold text-slate-900 text-sm">
                                {{ $notif->title }}
                                @if ($notif->isUnread())
                                    <span class="ml-2 inline-block w-2 h-2 rounded-full bg-red-500"></span>
                                @endif
                            </p>
                            <span class="text-xs text-slate-400 whitespace-nowrap ml-4">
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mt-1 whitespace-pre-line">{{ $notif->message }}</p>
                        @if ($notif->notifiable_type === \App\Models\Submission::class)
                            <a href="{{ route('submissions.show', $notif->notifiable_id) }}"
                               onclick="markRead({{ $notif->id }})"
                               class="text-xs text-red-600 hover:text-red-700 font-medium mt-2 inline-block">
                                View Submission →
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

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
@push('scripts')
<script>
    function markRead(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#dc2626',
            timer: 3000,
            timerProgressBar: true,
        });
    @endif
</script>
@endpush
@endsection
