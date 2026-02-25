@props([
    'type' => 'info', // info, success, danger, warning
    'title' => null,
    'message' => null,
    'dismissible' => false,
])

@php
    $configs = [
        'success' => [
            'bg' => 'bg-emerald-50',
            'border' => 'border-emerald-200',
            'textColor' => 'text-emerald-700',
            'bgDark' => 'bg-emerald-50',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />',
            'iconColor' => 'text-emerald-600',
        ],
        'danger' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'textColor' => 'text-red-700',
            'bgDark' => 'bg-red-50',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />',
            'iconColor' => 'text-red-600',
        ],
        'warning' => [
            'bg' => 'bg-amber-50',
            'border' => 'border-amber-200',
            'textColor' => 'text-amber-700',
            'bgDark' => 'bg-amber-50',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 0v2m0-10V8m0 0V6" />',
            'iconColor' => 'text-amber-600',
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-200',
            'textColor' => 'text-blue-700',
            'bgDark' => 'bg-blue-50',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'iconColor' => 'text-blue-600',
        ],
    ];

    $config = $configs[$type] ?? $configs['info'];
@endphp

<div {{ $attributes->merge(['class' => "mb-5 px-4 py-3 {$config['bg']} border {$config['border']} rounded-[9px] flex items-start gap-3 fade-up"]) }}>
    <svg class="w-4 h-4 {$config['iconColor']} shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $config['icon'] !!}
    </svg>

    {{ $slot }}
</div>
