@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f9f7f2]">
    <div class="max-w-5xl mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('layout-editor.dashboard') }}" class="text-[#2D8176] hover:text-[#1f5d54] font-bold mb-4 inline-block">
                ← Back to Dashboard
            </a>
            <h1 class="font-libre text-3xl font-bold text-[#2D8176] mb-2">{{ $assignment->submission->title }}</h1>
            <p class="text-[#6a7890]">Layout editing assignment for {{ $paper['author'] }}</p>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-8">
            <!-- Paper Details Card -->
            <div class="col-span-2 bg-white rounded-xl p-6 border border-[#e0d8cc]">
                <h2 class="font-bold text-lg text-[#2D8176] mb-4">Paper Details</h2>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Title</p>
                        <p class="font-bold text-[#1a1a1a]">{{ $paper['title'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Author</p>
                        <p class="font-bold text-[#1a1a1a]">{{ $paper['author'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Research Field</p>
                        <p class="font-bold text-[#1a1a1a]">{{ $paper['category'] }}</p>
                    </div>
                    <div class="border-t border-[#e0d8cc] pt-4">
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-2">Abstract</p>
                        <p class="text-sm text-[#4a5568] leading-relaxed">{{ $paper['abstract'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="bg-white rounded-xl p-6 border border-[#e0d8cc]">
                <h2 class="font-bold text-lg text-[#2D8176] mb-4">Assignment Status</h2>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Status</p>
                        <span class="inline-block px-3 py-1 bg-[#c9a84c]/10 text-[#c9a84c] font-bold rounded-full text-sm">
                            {{ ucfirst($assignment->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Assigned</p>
                        <p class="font-bold text-[#2D8176]">{{ $assignment->assigned_at->format('M d, Y') }}</p>
                        <p class="text-xs text-[#6a7890]">{{ $assignment->assigned_at->diffForHumans() }}</p>
                    </div>
                    @if ($assignment->started_at)
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Started</p>
                        <p class="font-bold text-[#2D8176]">{{ $assignment->started_at->format('M d, Y') }}</p>
                    </div>
                    @endif
                    @if ($assignment->completed_at)
                    <div>
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider mb-1">Completed</p>
                        <p class="font-bold text-[#2D8176]">{{ $assignment->completed_at->format('M d, Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- File Management Section -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            <!-- Original File Card -->
            <div class="bg-white rounded-xl p-6 border border-[#e0d8cc]">
                <h2 class="font-bold text-lg text-[#2D8176] mb-4">📥 Original File</h2>
                <p class="text-sm text-[#6a7890] mb-4">Download the file from the editor and make layout adjustments.</p>
                <a href="{{ route('layout-editor.download', $assignment->id) }}"
                   class="block w-full px-4 py-3 bg-[#2D8176] text-white rounded-lg font-bold text-center hover:bg-[#1f5d54] transition-colors">
                    Download Original File
                </a>
            </div>

            <!-- Upload Layout Card -->
            <div class="bg-white rounded-xl p-6 border border-[#e0d8cc]">
                <h2 class="font-bold text-lg text-[#2D8176] mb-4">📤 Upload Layout Version</h2>
                <p class="text-sm text-[#6a7890] mb-4">
                    @if ($assignment->status === 'completed')
                        ✓ Layout file uploaded successfully
                    @else
                        Upload your edited layout file after making adjustments.
                    @endif
                </p>

                @if ($assignment->status !== 'completed')
                    <form action="{{ route('layout-editor.upload', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-2">Upload File</label>
                            <input type="file" name="file" accept=".pdf" required
                                   class="w-full px-3 py-2 border border-[#e0d8cc] rounded-lg focus:border-[#2D8176] focus:outline-none">
                            @error('file')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-[#6a7890] mt-1">Accepted: PDF only (Max 10MB)</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-2">Notes (Optional)</label>
                            <textarea name="notes" rows="4" placeholder="Add any notes about the layout adjustments..."
                                      class="w-full px-3 py-2 border border-[#e0d8cc] rounded-lg focus:border-[#2D8176] focus:outline-none"></textarea>
                            @error('notes')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-[#c9a84c] text-white rounded-lg font-bold hover:bg-[#b89940] transition-colors">
                            Upload Layout File
                        </button>
                    </form>
                @else
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700 font-bold mb-2">✓ Layout file uploaded on {{ $assignment->completed_at->format('M d, Y') }}</p>
                        <a href="{{ route('layout-editor.download-layout', $assignment->id) }}"
                           class="text-green-600 hover:text-green-700 font-bold text-sm">
                            Download your layout file
                        </a>
                    </div>

                    @if ($assignment->notes)
                    <div class="mt-4 p-4 bg-[#f9f7f2] border border-[#e0d8cc] rounded-lg">
                        <p class="text-xs text-[#6a7890] uppercase tracking-wider font-bold mb-2">Your Notes</p>
                        <p class="text-sm text-[#4a5568]">{{ $assignment->notes }}</p>
                    </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Author's Revision Notes Section -->
        @php
            $latestRevision = $submission->revisionRequests()
                ->whereNotNull('revision_notes')
                ->orderBy('created_at', 'desc')
                ->first();
        @endphp
        @if ($latestRevision && $latestRevision->revision_notes)
        <div class="bg-blue-50 rounded-xl p-6 border border-blue-200 mb-8">
            <div class="flex items-start gap-3">
                <span class="text-2xl">💬</span>
                <div class="flex-1">
                    <h2 class="font-bold text-lg text-blue-900 mb-2">Author's Revision Notes</h2>
                    <p class="text-sm text-blue-700 mb-4">
                        The author submitted the following notes when revising their manuscript:
                    </p>
                    <div class="bg-white rounded-lg p-4 border-l-4 border-blue-400">
                        <p class="text-sm text-[#4a5568] whitespace-pre-wrap">{{ $latestRevision->revision_notes }}</p>
                    </div>
                    @if ($latestRevision->revised_at)
                    <p class="text-xs text-blue-600 mt-3">
                        📅 Submitted: {{ $latestRevision->revised_at->format('M d, Y \a\t g:i A') }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Workflow Info -->
        <div class="bg-[#2D8176]/5 rounded-xl p-6 border border-[#2D8176]/20">
            <h3 class="font-bold text-[#2D8176] mb-3">📋 Layout Editing Workflow</h3>
            <ol class="space-y-2 text-sm text-[#4a5568]">
                <li><strong>1. Review:</strong> Download and review the file sent by the editor</li>
                <li><strong>2. Edit:</strong> Make any necessary layout adjustments</li>
                <li><strong>3. Upload:</strong> Upload your edited version with notes (if needed)</li>
                <li><strong>4. Review:</strong> Editor will review your layout and send to author for final approval</li>
                <li><strong>5. Author:</strong> Author confirms and the paper is published</li>
            </ol>
        </div>
    </div>
</div>
@endsection
