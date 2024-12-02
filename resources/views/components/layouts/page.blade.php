<x-layouts.base>
    @if (session('error'))
    <div class="alert">{{ session('error') }}</div>
    @endif
    <div class="py-4">
        {{$slot}}
    </div>
</x-layouts.base>