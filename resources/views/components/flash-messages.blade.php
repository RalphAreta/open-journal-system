@if (session('success'))
    <x-alert
        type="success"
        class="animate-in fade-in slide-in-from-top-2 duration-300"
    >
        <p class="text-xs font-semibold">{{ session('success') }}</p>
    </x-alert>
@endif

@if (session('error'))
    <x-alert
        type="danger"
        class="animate-in fade-in slide-in-from-top-2 duration-300"
    >
        <p class="text-xs font-semibold">{{ session('error') }}</p>
    </x-alert>
@endif

@if (session('warning'))
    <x-alert
        type="warning"
        class="animate-in fade-in slide-in-from-top-2 duration-300"
    >
        <p class="text-xs font-semibold">{{ session('warning') }}</p>
    </x-alert>
@endif

@if (session('info'))
    <x-alert
        type="info"
        class="animate-in fade-in slide-in-from-top-2 duration-300"
    >
        <p class="text-xs font-semibold">{{ session('info') }}</p>
    </x-alert>
@endif
