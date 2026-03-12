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
            'border' => 'border-emerald-300',
            'text' => 'text-emerald-700',
            'label' => 'Accept',
            'shadow' => 'shadow-sm shadow-emerald-200/50',
            'dot' => 'bg-emerald-500',
        ],
        'reject' => [
            'icon' => '✗',
            'bg' => 'bg-red-50',
            'border' => 'border-red-300',
            'text' => 'text-red-700',
            'label' => 'Reject',
            'shadow' => 'shadow-sm shadow-red-200/50',
            'dot' => 'bg-red-500',
        ],
        'minor' => [
            'icon' => '⚠',
            'bg' => 'bg-amber-50',
            'border' => 'border-amber-300',
            'text' => 'text-amber-700',
            'label' => 'Minor Revision',
            'shadow' => 'shadow-sm shadow-amber-200/50',
            'dot' => 'bg-amber-500',
        ],
        'major' => [
            'icon' => '●',
            'bg' => 'bg-orange-50',
            'border' => 'border-orange-300',
            'text' => 'text-orange-700',
            'label' => 'Major Revision',
            'shadow' => 'shadow-sm shadow-orange-200/50',
            'dot' => 'bg-orange-500',
        ],
        'pending' => [
            'icon' => '⏳',
            'bg' => 'bg-slate-100',
            'border' => 'border-slate-300',
            'text' => 'text-slate-600',
            'label' => 'Pending',
            'shadow' => 'shadow-sm shadow-slate-200/50',
            'dot' => 'bg-slate-400',
        ],
    ];

    $config = $configs[$type] ?? $configs['accept'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-2 px-3 py-1.5 rounded-full {$config['bg']} border {$config['border']} text-[11px] font-bold {$config['text']} {$config['shadow']} transition-all duration-200 hover:shadow-md"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }} opacity-80"></span>
    {{ $config['icon'] }}<span>{{ $count ?? $config['label'] }}</span>
</span>
