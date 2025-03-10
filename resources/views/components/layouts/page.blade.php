<x-layouts.base>
    @if (session('error'))
        <div class="alert">{{ session('error') }}</div>
    @endif
    <div class="flex flex-row py-4 gap-8">
        {{ $slot }}
    </div>
</x-layouts.base>
