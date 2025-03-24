<div id="content" class='flex flex-col flex-wrap items-center m-auto gap-4 w-full relative'>

    <div wire:loading.flex class="flex justify-center items-center mt-4 absolute inset-0">
        <div class="w-8 h-8 border-4 border-customYellow border-t-transparent rounded-full animate-spin"></div>
    </div>
    @if (isset($primes))

        <div wire:loading.class="opacity-50"
            class="w-full max-w-full m-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 rounded-xl mt-4">



            @foreach ($primes as $prime)
                @php
                    $selected = $cards?->where('prime_id', $prime->id)->count() > 0;
                @endphp
                <x-card wire:click="selectPrime({{ $prime->id }})" :prime="$prime" wire:key="{{ $prime->id }}"
                    type='card' @class([
                        'border-customYellow' => $selected,
                        'border-customBlack border-[2px] ' => !$selected,
                    ])></x-card>
            @endforeach
        </div>
        <div class='w-fit m-auto  justify-between font-bold'>
            {{ $primes->links() }}
        </div>
    @endif
</div>
