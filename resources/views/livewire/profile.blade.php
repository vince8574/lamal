<div class='flex flex-col text-[30px] mx-auto gap-4'>
    <div class='mx-auto text-[30px]'>
        <select id="canton" wire:model="canton" name="canton"
            class="font-bold rounded-[10px] border border-[#E0E0E0] py-3 pl-6 pr-3 text-center">
            <option value="">Cantons</option>
            @foreach ($cantons as $c)
                <option value="{{ $c->id }}" {{ request()->get('canton') == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class='m-auto'>
        <input name='name' placeholder="Entrez votre joli nom" class='rounded-[10px] py-3 text-center font-bold'
            wire:model="name">
        @error('name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    <a href="{{ route('search') }}" wire:click="createProfile"
        class='rounded-[10px] bg-[#FF87AB] w-[343px] h-auto py-[18px] px-[17px] text-center justify-center flex items-center m-auto font-bold text-[20px] gap-4'
        :class="{ 'opacity-0 cursor-not-allowed': !@this.name }" :disabled="!@this.name">Comparer
        les primes<img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4"></a>
</div>
