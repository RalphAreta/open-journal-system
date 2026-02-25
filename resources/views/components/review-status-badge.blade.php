@props([
    'type' => 'accept', // accept, reject, minor, major, pending
    'count' => null,
    'showIcon' => true,
])

@php
    $configs = [
        'accept' => [
            'icon' => '✓',
            'bg' => 'bg-emerald-50',
            'border' => 'border-emerald-200',
            'text' => 'text-emerald-700',
            'label' => 'Accept',
        ],
        'reject' => [
            'icon' => '✗',
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'text' => 'text-red-700',
            'label' => 'Reject',
        ],
        'minor' => [
            'icon' => '⚠',
            'bg' => 'bg-amber-50',
            'border' => 'border-amber-200',
            'text' => 'text-amber-700',
            'label' => 'Minor Revision',
        ],
        'major' => [
            'icon' => '●',
            'bg' => 'bg-orange-50',
            'border' => 'border-orange-200',
            'text' => 'text-orange-700',
            'label' => 'Major Revision',
        ],
        'pending' => [
            'icon' => '⏳',
            'bg' => 'bg-slate-100',
            'border' => 'border-slate-200',
            'text' => 'text-slate-500',
            'label' => 'Pending',
        ],
    ];

    $config = $configs[$type] ?? $configs['accept'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 px-" . ($count ? '2' : '2.5') . " py-" . ($count ? '0.5' : '1') . " rounded-full {$config['bg']} border {$config['border']} text-[10px] font-bold {$config['text']}"]) }}>
    {{ $config['icon'] }}{{ $count ?? $config['label'] }}
</span>
