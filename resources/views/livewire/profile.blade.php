<div @class([
    'flex flex-col text-[30px] mx-auto gap-4',
    'p-4 min-h-20' => $inModal,
])>
    {{-- <div x-data="{ open: false }" class="relative z-1000 w-full" x-on:click.outside="open=false">
        <input type="text" wire:model.live="searchCity" @focus="open = true"
            placeholder="Rechercher un code postal ou une ville"
            class="rounded-[10px] border border-gray-300 py-2 pr-3 pl-6 bg-white font-roboto font-bold text-[24px] w-full" />



        <ul x-show="open"
            class="absolute left-0 top-full z-1000 bg-white border border-gray-200 rounded-md w-full mt-1 shadow-lg">

            @foreach ($cities as $citie)
                <li wire:click="selectCity('{{ $citie->id }}')" @click="open = false"
                    class="cursor-pointer px-4 py-2 hover:bg-gray-100 flex flex-row items-center gap-2">
                    <strong>{{ $citie->npa }} - {{ $citie->name }}</strong>
                    ({{ $citie->municipality->district->name ?? '' }},
                    {{ $citie->municipality->district->canton->name ?? '' }}
                    <img class="h-4 w-4" src="{{ asset('images/svg/cantons_svg/'.$citie->municipality->district->canton->key.'.svg') }}" />)
                </li>
            @endforeach
        </ul>

    </div> --}}
    <livewire:autocomplete key="profile"/>
    <div class='m-auto'>
        <input name='name' placeholder="Entrez votre joli nom" class='bg-white rounded-[10px] py-3 text-center font-bold'
            wire:model="name">
        @error('name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    <a wire:click="createProfile"
        class='rounded-[10px] bg-[#FF87AB] w-[343px] h-auto py-[18px] px-[17px] text-center justify-center flex items-center m-auto font-bold text-[20px] gap-4 cursor-pointer'>Comparer
        les primes<img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4"></a>
</div>
