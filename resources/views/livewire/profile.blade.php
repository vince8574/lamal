<div class='flex flex-col text-[30px] m-auto gap-4'>
    <div>
        <input name='name' placeholder="Entrez votre joli nom" class='rounded-[10px] py-3 text-center font-bold'
            wire:model="name">
    </div>
    <a href="{{ route('search') }}" wire:click="createProfile"
        class='rounded-[10px] bg-[#FF87AB] w-[343px] h-auto py-[18px] px-[17px] text-center justify-center flex items-center m-auto font-bold text-[20px] gap-4'>Comparer
        les primes<img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4"></a>
</div>
