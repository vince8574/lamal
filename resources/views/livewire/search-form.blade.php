<div>
    <div class="w-fit p-5 flex flex-col bg-[#FFFFFF] gap-y-4 rounded-l-[10px]">

        <div class="bg-[#F7F7F7] flex flex-row">

            @foreach ($profiles as $profile)
                <div class="bg-[#F7F7F7] flex flex-row">
                    <div @class([
                        'bg-white' => $profile->id == $this->profile_id,
                        'bg-[#F7F7F7]' => $profile->id != $this->profile_id,
                        'cursor-pointer flex flex-row gap-[18px] ml-1 px-1 mt-1 rounded-t-[10px]',
                    ]) wire:click="selectProfile({{ $profile->id }})">

                        <label @class([
                            'cursor-pointer',
                            'text-[#FF87AB]' => $profile->id == $this->profile_id,
                            'text-black' => $profile->id != $this->profile_id,
                        ])>{{ $profile->name }} </label>

                        @if ($profiles->count() != 1)
                            <div wire:click="deleteProfile({{ $profile->id }})">
                                <img src="{{ asset('images/svg/cross.svg') }}" alt="cross" class="text-[#FF87AB]">
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach



            <div class='bg-white flex'>
                <button wire:click="openTestModal"
                    class="group relative px-6 py-[2px] flex items-center rounded-bl-[10px] bg-[#F7F7F7]">
                    <img src="{{ asset('images/svg/plus.svg') }}" alt="plus">

                </button>
            </div>
        </div>
        {{-- <div x-data="{ open: false }" class="relative  w-full" x-on:click.outside="open=false">
            <input type="text" wire:model.live="searchCity" @focus="open = true"
                placeholder="Rechercher un code postal ou une ville"
                class="rounded-[10px] bg-white border border-gray-300 py-2 pr-3 pl-6 font-roboto font-bold text-[24px] w-full" />



            <ul x-show="open"
                class="absolute left-0 top-full  bg-white border border-gray-200 rounded-md w-full mt-1 shadow-lg z-autocomplete">

                @foreach ($cities as $city)
                    <li wire:click="selectCity('{{ $city->id }}')" @click="open = false"
                        class="cursor-pointer px-4 py-2 hover:bg-gray-100 flex flex-row items-center gap-2">
                        <strong>{{ $city->npa }} - {{ $city->name }}</strong>
                        ({{ $city->municipality->district->name ?? '' }},
                        {{ $city->municipality->district->canton->name ?? '' }}
                        <img class="h-4 w-4" src=" {{ asset('images/svg/cantons_svg/'.$city->municipality->district->canton->key.'.svg') }}" />)
                    </li>
                @endforeach
            </ul>

        </div> --}}
        <livewire:autocomplete key="search-form" :searchedValue="$this->filter['city'] ?? null"/>

        <div class="flex flex-col gap-y-4 font-roboto text-[16px]" method="GET">
            <div class="flex flex-row gap-x-4">
                <div class="flex flex-col min-w-60">
                    <label for="age">Tranche d'âge</label>

                    <select id="age" name="age" wire:model.live="filter.age"
                        class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                        <option value="">Toutes</option>
                        @foreach ($ages as $age)
                            <option value="{{ $age->id }}">
                                {{ $age->label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col min-w-60">
                    <label for="franchise">Franchise</label>
                    <select id="franchise" name="franchise" wire:model.live="filter.franchise"
                        class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                        <option value="">Toutes</option>
                        @foreach ($franchises as $f)
                            <option value="{{ $f->id }}">
                                {{ $f->numerique }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col min-w-60">
                    <label for="tariftype">Modèle d'assurance</label>
                    <select id="tariftype" name="tariftype" wire:model.live="filter.tariftype"
                        class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                        <option value="">Toutes</option>
                        @foreach ($tariftypes as $tarif)
                            <option value="{{ $tarif->id }}">
                                {{ $tarif->label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-control flex flex-row justify-between">
                <div>
                    <label class="label cursor-pointer">
                        <input type="checkbox" id='accident' name='accident' class="toggle"
                            wire:model.live="filter.accident" />
                        <span class="label-text ml-4">Assurance accident de base</span>
                    </label>
                </div>

            </div>
        </div>

    </div>

</div>
