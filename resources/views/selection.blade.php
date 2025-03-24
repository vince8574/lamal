<x-layouts.page>
    <div class="flex flex-col m-auto gap-8 md:gap-16 px-4 sm:px-8 md:px-16 w-full max-w-full overflow-hidden">
        <h1
            class='font-poetsen text-[28px] sm:text-[32px] md:text-[36px] font-bold text-customWhite m-auto text-center md:text-left'>
            Vos sélections</h1>

        <div class='flex flex-row w-full md:mx-0 lg:mx-0'>
            <div class='w-fit'>
                <a href="{{ route('search') }}"
                    class='ml-0 bg-customWhite flex items-center justify-center rounded-[10px] gap-2 font-roboto text-[14px] sm:text-[16px] text-customBlack px-3 sm:px-4 py-2'><img
                        src="{{ asset('images/svg/left-arrow-back.svg') }}" alt="Right Arrow"
                        class="w-3 h-3 sm:w-4 sm:h-4">Retour</a>
            </div>
        </div>

        <div class="w-full max-w-full overflow-x-hidden">
            @foreach ($profiles as $profile)
                <div id="content" class='flex flex-col w-full md:mx-0 lg:mx-0 mb-8'>
                    <div class="flex flex-row rounded-t-[10px]">
                        <div class="flex flex-col w-fit min-w-16 sm:min-w-24 ml-0 pb-2 sm:pb-3">
                            <span
                                class="font-poetsen text-customWhite text-[22px] sm:text-[26px] md:text-[30px] capitalize">{{ $profile->name }}</span>
                        </div>
                    </div>

                    @if ($profile->cards->count() > 0)
                        <div
                            class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 rounded-b-xl rounded-tr-xl">
                            @foreach ($profile->cards as $card)
                                <x-card :prime="$card->prime" class="border-customBlack border-[1px] w-full">
                                    <a href="{{ route('card.select', ['prime_id' => $card->prime_id, 'profile_id' => $card->profile_id]) }}"
                                        class='w-[26px] sm:w-[30px] h-[26px] sm:h-[30px] flex ml-auto justify-center items-center'>
                                        <img src="{{ asset('images/svg/multiplier.svg') }}" alt="Cross"
                                            class="w-5 h-5 sm:w-6 sm:h-6">
                                    </a>
                                </x-card>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.page>
