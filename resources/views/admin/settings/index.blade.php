@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
<h1 class="text-2xl font-semibold mb-6">System Settings</h1>
<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
    @csrf
    @method('PUT')
    @foreach($settings as $group => $items)
        <div class="bg-white rounded-lg shadow border border-slate-200 p-6">
            <h2 class="text-lg font-medium text-slate-800 mb-4">{{ ucfirst($group) }}</h2>
            <div class="space-y-4">
                @foreach($items as $setting)
                    <div>
                        <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-slate-700">{{ $setting->key }}</label>
                        @if($setting->type === 'boolean')
                            <input type="hidden" name="setting_{{ $setting->key }}" value="0">
                            <input type="checkbox" name="setting_{{ $setting->key }}" value="1" {{ \App\Models\SystemSetting::getValue($setting->key) ? 'checked' : '' }} class="rounded border-slate-300">
                        @else
                            <input type="text" id="setting_{{ $setting->key }}" name="setting_{{ $setting->key }}" value="{{ \App\Models\SystemSetting::getValue($setting->key) }}"
                                class="mt-1 block w-full max-w-md rounded-md border-slate-300 shadow-sm">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium shadow-sm transition-colors">Save Settings</button>
</form>
@if($settings->isEmpty())
    <p class="text-slate-700">No settings defined. Add settings via the database or a seeder.</p>
@endif
@endsection
