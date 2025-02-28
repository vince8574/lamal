<x-layouts.page>
    <div class='flex flex-row mx-32'>
        <div class='w-fit'>
            <a href="{{ route('search') }}"
                class='ml-0 bg-[#FF87AB] w-[157px] h-[73px] flex items-center justify-center m-auto rounded-[10px] gap-4 font-roboto font-bold text-[20px]'><img
                    src="{{ asset('images/svg/double_arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">Retour</a>
        </div>
        <h1 class='font-roboto text-[30px] font-bold m-auto'>Vos sélections</h1>
    </div>
    @foreach ($profiles as $profile)
        <div id="content" class='flex flex-col  m-auto mt-4 mx-32'>
            <div class="flex flex-col w-fit bg-[#f7f7f7] rounded-[10px] min-w-24 p-1 ml-0 pb-3">
                <div class="flex justify-end">
                    <div class="rounded-full bg-[#fff] flex text-center justify-center items-center px-1 h-fit  ">
                        <span
                            class="text-[8px] font-bold">{{ $cards->where('profile_id', $profile->id)->count() }}</span>
                    </div>
                </div>
                <span class="text-center font-bold">{{ $profile->name }}</span>
            </div>
            <div class="max-w-full m-auto grid grid-cols-1 sm:grid-cols-4 gap-8  rounded-xl mt-4 flex">
                @foreach ($profile->cards as $card)
                      <x-card :prime="$card->prime" class="border-white">
                            <a href="{{ route('card.select', ['prime_id' => $card->prime_id, 'profile_id' => $card->profile_id]) }}"
                                class='rounded-full bg-[#FF87AB] w-[23px] h-[23px] p-[6px] flex ml-auto justify-center items-center'>
                                <img src="{{ asset('images/svg/cross.svg') }}" alt="Cross" class="w-4 h-4">
                            </a>

                        </x-card>
            
                @endforeach
            </div>

        </div>
    @endforeach
</x-layouts.page>
