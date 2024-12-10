<div class="w-fit p-5 flex flex-col bg-[#FFFFFF] gap-y-4 rounded-l-[10px]">
    <div id="search" class="w-fit flex flex-wrap h-auto">
        <select id="canton" wire:model.live="filter.canton" name="canton"
            class="rounded-[10px] border border-[#E0E0E0] py-3 pl-6 pr-3 font-roboto font-bold text-[24px]">
            <option value=''>Toutes</option>
            @foreach ($cantons as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="bg-[#F7F7F7] flex flex-row">

        @foreach ($profiles as $profile)
            <div class="bg-[#F7F7F7] flex flex-row">
                <div @class([
                    'bg-white' => $profile->id == $this->profile_id,
                    'bg-[#F7F7F7]' => $profile->id != $this->profile_id,
                    'cursor-pointer flex flex-row gap-[18px] ml-1 px-1 mt-1 rounded-t-[10px]',
                ]) wire:click="selectProfile({{ $profile->id }})">
                    <a>
                        <label @class([
                            'text-[#FF87AB]' => $profile->id == $this->profile_id,
                            'text-black' => $profile->id != $this->profile_id,
                        ])>{{ $profile->name }}</label>
                    </a>
                    @if ($profiles->count() != 1)
                        <div wire:click="deleteProfile({{ $profile->id }})">
                            <img src="{{ asset('images/svg/cross.svg') }}" alt="cross" class="text-[#FF87AB]">
                        </div>
                    @endif
                </div>
            </div>
        @endforeach



        <div class='bg-white flex'>
            <a href=" {{ route('user') }}" class="group relative px-6 py-[2px] flex rounded-bl-[10px] bg-[#F7F7F7]">
                <img src="{{ asset('images/svg/plus.svg') }}" alt="plus">
                <span
                    class="absolute inset-0 rounded-full bg-[#3B7080] opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
            </a>
        </div>
    </div>

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
            <button type=" submit" class="btn btn-active btn-accent bg-[#FF87AB] px-6 py-[9px] w-[120px] h-[40px]"><img
                    src="{{ asset('images/svg/search.svg') }}"></button>
        </div>
    </div>

</div>
