  <div x-data="{ open: false }" class="relative z-1000 w-full" x-on:click.outside="open=false">
      <input type="text" wire:model.live="searchedValue" @focus="open = true"
          placeholder="Rechercher un code postal ou une ville"
          class="rounded-[10px] border border-gray-300 py-2 pr-3 pl-6 bg-white font-roboto font-bold text-[24px] w-full" />



      <ul x-show="open"
          class="absolute left-0 top-full z-1000 bg-white border border-gray-200 rounded-md w-full mt-1 shadow-lg">

          @foreach ($this->cities as $citie)
              <li wire:click="selectValue('{{ $citie->id }}')" @click="open = false"
                  class="cursor-pointer px-4 py-2 hover:bg-gray-100 flex flex-row items-center gap-2">
                  <strong>{{ $citie->npa }} - {{ $citie->name }}</strong>
                  ({{ $citie->municipality->district->name ?? '' }},
                  {{ $citie->municipality->district->canton->name ?? '' }}
                  <img class="h-4 w-4"
                      src="{{ asset('images/svg/cantons_svg/' . $citie->municipality->district->canton->key . '.svg') }}" />)
              </li>
          @endforeach
      </ul>
  </div>