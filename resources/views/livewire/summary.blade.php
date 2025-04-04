<div class='flex flex-col bg-customYellow w-full md:rounded-[10px] p-5 justify-between gap-8'>
    <div class="hidden md:inline">
        <span class='font-poetsen text-[24px]'>Comparatif</span>
    </div>
    <div id="summary" class="font-roboto text-[16px] overflow-y-auto overflow-x-hidden grow flex flex-col gap-8 pb-16 ">
        @foreach ($profiles as $profile)
            <div class="flex
        flex-col" x-data="{ open: true }">
                <div class="flex flex-col gap-0 w-full">
                    <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                        <span
                            class="w-full h-full text-customBlack rounded-t-[10px] font-poetsen text-[16px]  py-0 my-0 capitalize">{{ $profile->name }}</span>
                        <div class="transform transition-transform duration-300"
                            :class="{ 'rotate-90': open, '-rotate-90': !open }">
                            <img src="{{ asset('images/svg/right-arrow-forward-black.svg') }}" alt="Chevron"
                                class="w-6 h-6">
                        </div>
                    </div>
                    <div x-show="open" x-transition class="card-container">
                        @foreach ($profile->cards as $card)
                            <div class="flex flex-row justify-between">
                                <span class="font-roboto text-[16px]">{{ $card->prime->insurer->name }} :</span>
                                <span class="font-mono font-bold text-[16px]">{{ $card->prime->cost }} CHF</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        <div class='flex justify-end xs:px-0 md:px-4'>
            <div class='bg-customPurple flex rounded-[10px] ml-auto'>
                <a href="{{ route('result') }}"
                    class='font-roboto font-bold text-customWhite text-center flex items-center justify-center gap-2 px-6 py-[9px] w-[120px] h-[40px]'>
                    Voir
                    <img src="{{ asset('images/svg/right-arrow-forward-white.svg') }}" alt="Right Arrow"
                        class="w-4 h-4">
                </a>
            </div>
        </div>
    </div>
</div>
