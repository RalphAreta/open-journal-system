@extends('layouts.app')

@section('title', 'Manage Editor Expertise')

@section('content')
<div class="mb-8">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-5xl font-bold text-slate-900 mb-2">Manage Editor Expertise</h1>
            <p class="text-lg text-slate-600">Set and update fields of expertise for each editor</p>
        </div>
        <a href="{{ route('admin.expertise-categories.index') }}"
           class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg transition-colors text-sm font-medium">
            ⚙️ Manage Categories
        </a>
    </div>
</div>

@if ($editors->count() > 0)
    <div class="grid gap-6">
        @foreach ($editors as $editor)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-200 p-6 transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $editor->name }}</h3>
                        <p class="text-sm text-slate-600">{{ $editor->email }}</p>
                    </div>
                    <a href="{{ route('admin.editor-expertise.edit', $editor) }}" class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        ✏️ Manage
                    </a>
                </div>

                @if ($editor->editorExpertise->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach ($editor->editorExpertise as $expertise)
                            <span class="bg-red-50 border border-red-200 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $expertise->field_name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500 italic">No expertise fields assigned yet</p>
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $editors->links() }}
    </div>
@else
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-8 text-center">
        <p class="text-slate-600">No editors found. Please create editor accounts first.</p>
    </div>
@endif
@endsection