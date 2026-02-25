@extends('layouts.app')

@section('title', 'Pending Reviewer Assignments')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <a href="{{ route('dashboard.reviewer') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">← Back to Dashboard</a>
        <h1 class="text-4xl font-bold text-slate-900 mt-1">Pending Reviewer Assignments</h1>
        <p class="text-sm text-slate-500 mt-1">Page: {{ $assignments->currentPage() }} of {{ $assignments->lastPage() }} ({{ $assignments->total() }} total assignments)</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-800 text-white">
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Action</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">My Reviewer Number</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Manuscript Number</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Article Type</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Article Title</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Date Reviewer Invited</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Date Reviewer Agreed</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Date Review Due</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Days Until Review Due</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Editor's Name</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Corr. Author</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($assignments as $assignment)
                    <tr class="hover:bg-slate-50 transition-colors align-top">

                        {{-- Action Column --}}
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-1">
                                <a href="{{ route('submissions.show', $assignment->submission) }}"
                                   class="text-blue-600 hover:underline text-xs">View Submission</a>
                                <a href="{{ route('reviews.create', ['assignment' => $assignment]) }}"
                                   class="text-blue-600 hover:underline text-xs">Submit Recommendation</a>
                                <button onclick="alert('Manuscript Analysis')"
                                   class="text-blue-600 hover:underline text-xs text-left">Manuscript Analysis</button>
                                <button onclick="alert('Services')"
                                   class="text-blue-600 hover:underline text-xs text-left">Services</button>
                                <button onclick="alert('Linked References')"
                                   class="text-blue-600 hover:underline text-xs text-left">View Linked References</button>
                                <button onclick="alert('Reviewer Comments')"
                                   class="text-blue-600 hover:underline text-xs text-left">View Reviewer Comments</button>
                                <button onclick="alert('Decision Letter')"
                                   class="text-blue-600 hover:underline text-xs text-left">View Decision Letter</button>
                                <a href="mailto:{{ $assignment->editor->email }}"
                                   class="text-blue-600 hover:underline text-xs">Send E-mail</a>
                            </div>
                        </td>

                        {{-- Reviewer Number --}}
                        <td class="px-4 py-4 text-slate-700 whitespace-nowrap">
                            {{ $assignment->reviewer_number ?? '—' }}
                        </td>

                        {{-- Manuscript Number --}}
                        <td class="px-4 py-4 text-slate-700 whitespace-nowrap font-mono text-xs">
                            #{{ str_pad($assignment->submission_id, 5, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Article Type --}}
                        <td class="px-4 py-4 text-slate-700 whitespace-nowrap">
                            {{ $assignment->article_type ?? 'Research Article' }}
                        </td>

                        {{-- Article Title --}}
                        <td class="px-4 py-4 text-slate-900 font-medium max-w-xs">
                            <span title="{{ $assignment->submission->title }}">
                                {{ Str::limit($assignment->submission->title, 50) }}
                            </span>
                        </td>

                        {{-- Date Reviewer Invited --}}
                        <td class="px-4 py-4 text-slate-600 whitespace-nowrap">
                            {{ $assignment->invited_at?->format('M d, Y') ?? '—' }}
                        </td>

                        {{-- Date Reviewer Agreed --}}
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if ($assignment->agreed_at)
                                <span class="text-green-700 font-medium">{{ $assignment->agreed_at->format('M d, Y') }}</span>
                            @else
                                <span class="text-amber-600 text-xs font-semibold">Pending</span>
                            @endif
                        </td>

                        {{-- Date Review Due --}}
                        <td class="px-4 py-4 text-slate-600 whitespace-nowrap">
                            {{ $assignment->review_due_at?->format('M d, Y') ?? '—' }}
                        </td>

                        {{-- Days Until Review Due --}}
                        <td class="px-4 py-4 whitespace-nowrap">
                            @php $days = $assignment->daysUntilDue(); @endphp
                            @if ($days === null)
                                <span class="text-slate-400">—</span>
                            @elseif ($days < 0)
                                <span class="text-red-600 font-bold">{{ abs($days) }}d overdue</span>
                            @elseif ($days <= 3)
                                <span class="text-amber-600 font-bold">{{ $days }}d left</span>
                            @else
                                <span class="text-green-700 font-semibold">{{ $days }}d left</span>
                            @endif
                        </td>

                        {{-- Editor's Name --}}
                        <td class="px-4 py-4 text-slate-700 whitespace-nowrap">
                            {{ $assignment->editor->name ?? '—' }}
                        </td>

                        {{-- Corr. Author --}}
                        <td class="px-4 py-4 text-slate-700 whitespace-nowrap">
                            {{ $assignment->submission->author->name ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-16 text-center text-slate-500">
                            No pending reviewer assignments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-200 px-6 py-3 bg-slate-50">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
