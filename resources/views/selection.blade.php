<x-layouts.page>
    <div class="flex flex-col m-auto gap-16">
        <h1 class='font-poetsen text-[36px] font-bold text-customWhite m-auto'>Vos sélections</h1>
        <div class='flex flex-row mx-32'>
            <div class='w-fit'>
                <a href="{{ route('search') }}"
                    class='ml-0 bg-customWhite flex items-center justify-center m-auto rounded-[10px] gap-4 font-roboto text-[16px] text-customBlack px-4 py-2'><img
                        src="{{ asset('images/svg/left-arrow-back.svg') }}" alt="Right Arrow" class="w-4 h-4">Retour</a>
            </div>
        </div>
        @foreach ($profiles as $profile)
            <div id="content" class='flex flex-col mx-32'>
                <div class="flex flex-row rounded-t-[10px] ">
                    <div class="flex flex-col w-fit min-w-24 ml-0 pb-3">
                        {{-- <div class="flex justify-end">
                            <div
                                class="rounded-full bg-[#fff] flex text-center justify-center items-center px-1 h-fit  ">
                                <span
                                    class="text-[8px] font-bold">{{ $cards->where('profile_id', $profile->id)->count() }}</span>
                            </div>
                        </div> --}}
                        <span class="font-poetsen text-customYellow text-[30px] capitalize">{{ $profile->name }}</span>
                    </div>

                </div>
                @if ($profile->cards->count() > 0)
                    <div class="w-full grid grid-cols-1 sm:grid-cols-4 gap-8  rounded-b-xl rounded-tr-xl flex">
                        @foreach ($profile->cards as $card)
                            <x-card :prime="$card->prime" class="border-white w-full">
                                <a href="{{ route('card.select', ['prime_id' => $card->prime_id, 'profile_id' => $card->profile_id]) }}"
                                    class='w-[30px] h-[30px] flex ml-auto justify-center items-center'>
                                    <img src="{{ asset('images/svg/multiplier.svg') }}" alt="Cross" class="w-6 h-6">
                                </a>

                            </x-card>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</x-layouts.page>
