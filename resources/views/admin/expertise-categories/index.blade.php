@extends('layouts.app')

@section('title', 'Manage Expertise Categories')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-4xl font-bold text-slate-900 mb-1">Expertise Categories</h1>
        <p class="text-slate-600">Manage the list of expertise fields available for editors</p>
    </div>
    <a href="{{ route('admin.editor-expertise.index') }}"
       class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors text-sm font-medium">
        ← Back to Editor Expertise
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- LEFT: Add new category form --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sticky top-6">
            <h2 class="text-lg font-bold text-slate-900 mb-1">Add New Category</h2>
            <p class="text-sm text-slate-500 mb-5">Custom categories will be marked with a badge and can be edited or deleted later.</p>

            <form method="POST" action="{{ route('admin.expertise-categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Category Name</label>
                    <input
                        id="name" type="text" name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. Nanotechnology"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                               @error('name') border-red-500 @enderror"
                    />
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold
                           px-4 py-2.5 rounded-lg transition-colors">
                    + Add Category
                </button>
            </form>
        </div>
    </div>

    {{-- RIGHT: Category list --}}
    <div class="lg:col-span-2 space-y-3">
        <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">
            Default Categories <span class="text-slate-400 font-normal normal-case">(cannot be deleted)</span>
        </h2>

        @foreach ($categories as $category)
            @if (! $category->is_custom)
                <div class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-700">{{ $category->name }}</span>
                    <span class="text-xs text-slate-400 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-full">Default</span>
                </div>
            @endif
        @endforeach

        @php $customCategories = $categories->filter(fn($c) => $c->is_custom); @endphp

        @if ($customCategories->count() > 0)
            <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-2">
                Custom Categories
            </h2>

            @foreach ($customCategories as $category)
                <div class="bg-white border border-red-100 rounded-lg px-4 py-3 flex items-center justify-between gap-4 group">
                    <form method="POST" action="{{ route('admin.expertise-categories.update', $category) }}"
                          class="flex items-center gap-2 flex-1">
                        @csrf @method('PUT')
                        <input
                            type="text" name="name"
                            value="{{ $category->name }}"
                            class="flex-1 px-3 py-1.5 text-sm border border-transparent rounded-md
                                   bg-transparent focus:bg-white focus:border-slate-300 focus:outline-none
                                   focus:ring-1 focus:ring-red-400 transition-all"
                        />
                        <button type="submit"
                            class="text-xs text-red-600 hover:text-red-800 font-semibold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                            Save
                        </button>
                    </form>

                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-xs text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">Custom</span>
                        <form method="POST" action="{{ route('admin.expertise-categories.destroy', $category) }}"
                              onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="text-slate-400 hover:text-red-600 transition-colors text-lg leading-none"
                                title="Delete">
                                &times;
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="mt-4 bg-slate-50 border border-slate-200 rounded-lg p-5 text-center text-sm text-slate-500 italic">
                No custom categories yet. Add one using the form on the left.
            </div>
        @endif

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
