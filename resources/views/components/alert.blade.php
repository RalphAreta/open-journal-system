@props([
    'type' => 'info', // info, success, danger, warning
    'title' => null,
    'message' => null,
    'dismissible' => false,
])

@php
    $configs = [
        'success' => [
            'bg' => 'bg-gradient-to-br from-emerald-50 to-green-50',
            'border' => 'border-emerald-300',
            'textColor' => 'text-emerald-800',
            'shadow' => 'shadow-sm shadow-emerald-200/40',
            'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />',
            'iconColor' => 'text-emerald-600',
        ],
        'danger' => [
            'bg' => 'bg-gradient-to-br from-red-50 to-rose-50',
            'border' => 'border-red-300',
            'textColor' => 'text-red-800',
            'shadow' => 'shadow-sm shadow-red-200/40',
            'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />',
            'iconColor' => 'text-red-600',
        ],
        'warning' => [
            'bg' => 'bg-gradient-to-br from-amber-50 to-yellow-50',
            'border' => 'border-amber-300',
            'textColor' => 'text-amber-800',
            'shadow' => 'shadow-sm shadow-amber-200/40',
            'icon' => '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />',
            'iconColor' => 'text-amber-600',
        ],
        'info' => [
            'bg' => 'bg-gradient-to-br from-blue-50 to-cyan-50',
            'border' => 'border-blue-300',
            'textColor' => 'text-blue-800',
            'shadow' => 'shadow-sm shadow-blue-200/40',
            'icon' => '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />',
            'iconColor' => 'text-blue-600',
        ],
    ];

    $config = $configs[$type] ?? $configs['info'];
@endphp

<div {{ $attributes->merge(['class' => "mb-5 px-5 py-4 {$config['bg']} border-1.5 {$config['border']} rounded-14 flex items-start gap-4 fade-up {$config['shadow']} transition-all duration-200"]) }}>
    <svg class="w-5 h-5 {$config['iconColor']} shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        {!! $config['icon'] !!}
    </svg>
    
    <div class="flex-1">
        {{ $slot }}
    </div>
    
    @if ($dismissible)
        <button class="text-gray-400 hover:text-gray-600 transition-colors shrink-0" onclick="this.parentElement.remove()">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    @endif
</div>
