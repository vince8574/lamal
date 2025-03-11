<div>
    <div class="w-full p-5 flex flex-col bg-[#FFFFFF] gap-y-4 rounded-[10px]">

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
                <button wire:click="openProfileModal"
                    class="group relative px-6 py-[2px] flex items-center rounded-bl-[10px] bg-[#F7F7F7]">
                    <img src="{{ asset('images/svg/plus.svg') }}" alt="plus">
                </button>
            </div>
        </div>

        <livewire:autocomplete key="search-form" :searchedValue="$this->filter['city'] ?? null" :profile_id="$this->profile_id" event_key="search-form" />

        <div class="flex flex-col gap-y-4 font-roboto text-[16px]" method="GET">
            <div class="flex flex-row flex-wrap justify-between gap-4">
                <div class="flex flex-col w-full xl:w-auto xl:min-w-60">
                    <label for="age">Tranche d'âge</label>
                    <select id="age" name="age" wire:model.live="filter.age"
                        class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                        <option value="">Toutes</option>
                        @foreach ($ages as $age)
                            <option value="{{ $age->id }}">{{ $age->label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col w-full xl:w-auto xl:min-w-60">
                    <label for="franchise">Franchise</label>
                    <select id="franchise" name="franchise" wire:model.live="filter.franchise"
                        class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                        <option value="">Toutes</option>
                        @foreach ($franchises as $f)
                            <option value="{{ $f->id }}">{{ $f->numerique }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col w-full xl:w-auto xl:min-w-60">
                    <label for="tariftype">Modèle d'assurance</label>
                    <select id="tariftype" name="tariftype" wire:model.live="filter.tariftype"
                        class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                        <option value="">Toutes</option>
                        @foreach ($tariftypes as $tarif)
                            <option value="{{ $tarif->id }}">{{ $tarif->label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-control flex flex-row justify-between">
                <div>
                    <label class="label cursor-pointer flex items-center">
                        <div
                            class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" id="accident" name="accident" wire:model.live="filter.accident"
                                class="hidden peer" />
                            <div
                                class="h-6 w-12 rounded-full bg-gray-200 cursor-pointer transition-colors duration-200 ease-in-out peer-checked:bg-[#FF87AB]">
                            </div>
                            <div
                                class="absolute left-1 top-1 bg-white h-4 w-4 rounded-full transform transition-transform duration-200 ease-in-out peer-checked:translate-x-6">
                            </div>
                        </div>
                        <span class="label-text ml-2">Assurance accident de base</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
