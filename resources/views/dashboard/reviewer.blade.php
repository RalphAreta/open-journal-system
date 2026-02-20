@extends('layouts.app')

@section('title', 'Reviewer Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-5xl font-bold text-slate-900 mb-2">Reviewer Dashboard</h1>
    <p class="text-lg text-slate-600">Track and complete your review assignments</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-slate-200 p-5 transition-all duration-200 hover:border-red-200">
        <div class="flex items-center justify-between mb-3">
            <p class="text-md font-medium text-slate-700">Pending Reviews</p>
            <span class="text-5xl">⏰</span>
        </div>
        <p class="text-3xl font-bold text-red-600">{{ $stats['pending'] }}</p>
        <p class="text-xs text-slate-700 mt-2">Awaiting your submission</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-slate-200 p-5 transition-all duration-200 hover:border-green-200">
        <div class="flex items-center justify-between mb-3">
            <p class="text-md font-medium text-slate-700">Completed Reviews</p>
            <span class="text-5xl">✅</span>
        </div>
        <p class="text-3xl font-bold text-green-600">{{ $stats['completed'] }}</p>
        <p class="text-xs text-slate-700 mt-2">Submitted</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
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
                        @else 📋
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
                           <a href="{{ route('reviewer.pending-assignments') }}"
                            onclick="markRead({{ $notif->id }})"
                            class="text-xs text-red-600 hover:text-red-700 font-medium mt-2 inline-block">
                                View Assignments →
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
    <div class="border-b border-slate-200 bg-slate-50 px-6 py-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-slate-900">Review Assignments</h2>
        <a href="{{ route('reviewer.pending-assignments') }}"
           class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
            📋 Pending Reviewer Assignments
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Submission</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($assignments as $a)
                    <tr class="hover:bg-slate-50 transition-colors duration-200">
                        <td class="px-6 py-4 text-sm text-slate-900 font-medium">{{ Str::limit($a->submission->title ?? '', 40) }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $a->submission->author->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $a->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($a->status === 'assigned')
                                <a href="{{ route('reviews.create', ['assignment' => $a]) }}" class="inline-flex items-center gap-1 text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200">
                                    <span>✎</span> Submit Review
                                </a>
                            @else
                                <span class="text-green-600 text-sm font-medium">✓ Completed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">No review assignments. Your assigned reviews will appear here.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-200 px-6 py-3 bg-slate-50">{{ $assignments->links() }}</div>
</div>
@push('scripts')
<script>
    function markRead(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        });
    }
</script>
@endpush
@endsection