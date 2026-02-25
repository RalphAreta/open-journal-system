@props([
    'title' => 'Validation Errors',
])

@if ($errors->any())
    <x-alert type="danger">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[.06em]">
                {{ $title }}
            </p>
            <ul class="space-y-1 ml-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li class="text-xs font-medium">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </x-alert>
@endif
