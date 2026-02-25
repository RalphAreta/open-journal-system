@if(session('success'))
    <x-alert type="success">
        <p class="text-xs font-semibold">{{ session('success') }}</p>
    </x-alert>
@endif

@if(session('error'))
    <x-alert type="danger">
        <p class="text-xs font-semibold">{{ session('error') }}</p>
    </x-alert>
@endif

@if(session('warning'))
    <x-alert type="warning">
        <p class="text-xs font-semibold">{{ session('warning') }}</p>
    </x-alert>
@endif

@if(session('info'))
    <x-alert type="info">
        <p class="text-xs font-semibold">{{ session('info') }}</p>
    </x-alert>
@endif
