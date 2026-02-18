@extends('layouts.app')

@section('title', 'Editor Expertise: ' . $user->name)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-5xl font-bold text-slate-900 mb-2">{{ $user->name }} - Expertise</h1>
        <p class="text-lg text-slate-600">{{ $user->email }}</p>
    </div>
    <a href="{{ route('admin.editor-expertise.edit', $user) }}" class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium shadow-sm">
        ✏️ Edit Expertise
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @if ($user->editorExpertise->count() > 0)
        @foreach ($user->editorExpertise as $expertise)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-bold text-slate-900">{{ $expertise->field_name }}</h3>
                    <form method="POST" action="{{ route('admin.editor-expertise.remove-field', $expertise) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 transition-colors" onclick="return confirm('Remove this field?')">
                            🗑️ Remove
                        </button>
                    </form>
                </div>
                @if ($expertise->description)
                    <p class="text-slate-600 text-sm">{{ $expertise->description }}</p>
                @else
                    <p class="text-slate-500 text-sm italic">No description provided</p>
                @endif
            </div>
        @endforeach
    @else
        <div class="col-span-2 bg-slate-50 border border-slate-200 rounded-xl p-8 text-center">
            <p class="text-slate-600 mb-4">No expertise fields assigned yet.</p>
            <a href="{{ route('admin.editor-expertise.edit', $user) }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                Add Expertise Fields
            </a>
        </div>
    @endif
</div>

<div class="mt-8">
    <a href="{{ route('admin.editor-expertise.index') }}" class="inline-block text-red-600 hover:text-red-700 transition-colors font-medium">
        ← Back to Editor List
    </a>
</div>
@endsection
