  <div x-data="{ open: false }" class="relative w-full" x-on:click.outside="open=false">

      <input type="text" wire:model.live="searchedValue" @focus="open = true"
          placeholder="{{ __('profile.autocomplete') }}"
          class="rounded-[10px] border border-gray-300 py-2 pr-3 pl-6 bg-customWhite font-roboto text-[22px] w-full" />



      <ul x-show="open"
          class="absolute left-0 top-full z-1000 bg-customWhite border border-gray-200 rounded-md text-[22px] w-full mt-1 overflow-y-scroll max-h-40">

          @foreach ($this->cities as $citie)
              <li wire:click="selectValue('{{ $citie->id }}')" @click="open = false"
                  class="cursor-pointer px-4 py-2 hover:bg-gray-100 flex flex-row items-center gap-3">
                  <strong>{{ $citie->full_name }}</strong>

                  <div class="text-sm text-gray-500 flex flex-row gap-1">
                      <img class="h-5 w-5"
                          src="{{ asset('images/svg/cantons_svg/' . $citie->municipality->district->canton->key . '.svg') }}" />
                      {{ ucfirst($citie->municipality->district->canton->name ?? '') }}
                  </div>
              </li>
          @endforeach
      </ul>
  </div>
