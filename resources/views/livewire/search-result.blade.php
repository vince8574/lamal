<div id="content" class='flex flex-col flex-wrap items-center m-auto mx-32 gap-4'>

    <div wire:loading>
        <span class="loading loading-dots loading-lg"></span>
    </div>
    @if (isset($primes))

        <div wire:loading.class="opacity-50"
            class="max-w-full m-auto grid grid-cols-1 sm:grid-cols-4 gap-4 rounded-xl mt-4">



            @foreach ($primes as $prime)
                @php
                    $selected = $cards?->where('prime_id', $prime->id)->count() > 0;
                @endphp
                <x-card wire:click="selectPrime({{ $prime->id }})" :prime="$prime" wire:key="{{ $prime->id }}"
                    type='card' @class([
                        'border-[#FF87AB]' => $selected,
                        'border-white ' => !$selected,
                    ])></x-card>
            @endforeach
        </div>
        <div class='w-fit m-auto  justify-between font-bold'>
            {{ $primes->links() }}
        </div>
    @endif
</div>
