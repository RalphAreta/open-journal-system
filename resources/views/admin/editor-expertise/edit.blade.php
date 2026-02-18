@extends('layouts.app')

@section('title', 'Edit Expertise: ' . $user->name)

@section('content')
<div class="mb-8">
    <h1 class="text-5xl font-bold text-slate-900 mb-2">Edit {{ $user->name }}'s Expertise</h1>
    <p class="text-lg text-slate-600">{{ $user->email }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 max-w-4xl">
    <form method="POST" action="{{ route('admin.editor-expertise.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-900 mb-4">Fields of Expertise</label>
            <div id="expertise-fields" class="space-y-4 mb-4">
                @forelse ($expertise as $expert)
                    <div class="expertise-field bg-slate-50 rounded-lg p-4 border border-slate-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-2">Field Name</label>
                                <select name="expertise[]" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                                    <option value="">-- Select a field --</option>
                                    @foreach ($fieldOptions as $value => $label)
                                        <option value="{{ $label }}" {{ $expert->field_name === $label ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-2">Description (Optional)</label>
                                <input type="text" name="description[]" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="e.g., 5+ years experience" value="{{ $expert->description }}">
                            </div>
                        </div>
                        <button type="button" class="text-sm text-red-600 hover:text-red-700 font-medium remove-expertise-btn">
                            Remove This Field
                        </button>
                    </div>
                @empty
                    <div class="expertise-field bg-slate-50 rounded-lg p-4 border border-slate-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-2">Field Name</label>
                                <select name="expertise[]" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="">-- Select a field --</option>
                                    @foreach ($fieldOptions as $value => $label)
                                        <option value="{{ $label }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-2">Description (Optional)</label>
                                <input type="text" name="description[]" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="e.g., 5+ years experience">
                            </div>
                        </div>
                        <button type="button" class="text-sm text-red-600 hover:text-red-700 font-medium remove-expertise-btn">
                            Remove This Field
                        </button>
                    </div>
                @endforelse
            </div>

            <button type="button" id="add-expertise-btn" class="inline-block bg-slate-200 text-slate-700 hover:bg-slate-300 transition-colors px-4 py-2 rounded-lg font-medium text-sm mb-6">
                + Add Another Field
            </button>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                ✓ Save Changes
            </button>
            <a href="{{ route('admin.editor-expertise.show', $user) }}" class="inline-block bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors px-6 py-3 rounded-lg font-semibold">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-expertise-btn').addEventListener('click', function() {
        const template = document.querySelector('.expertise-field').cloneNode(true);
        template.querySelectorAll('select, input').forEach(el => {
            el.value = '';
        });
        document.getElementById('expertise-fields').appendChild(template);
        attachRemoveListeners();
    });

    function attachRemoveListeners() {
        document.querySelectorAll('.remove-expertise-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (document.querySelectorAll('.expertise-field').length > 1) {
                    this.closest('.expertise-field').remove();
                } else {
                    alert('You must have at least one field of expertise.');
                }
            });
        });
    }

    attachRemoveListeners();
</script>
@endsection
