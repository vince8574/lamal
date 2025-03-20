<div class='flex flex-col bg-customYellow w-full rounded-[10px] p-5 justify-between h-full'>
    <div>
        <span class='font-poetsen text-[24px]'>Comparatif</span>
    </div>
    <div id="summary" class="font-roboto text-[16px] mt-4 overflow-y-auto flex-grow flex flex-col gap-8 pb-16">
        @foreach ($profiles as $profile)
            <div class="flex flex-col">
                <div class="flex flex-col gap-0 w-full">
                    <span
                        class="w-full h-full text-customBlack rounded-t-[10px] font-poetsen text-[16px] px-4 py-0 my-0 capitalize">{{ $profile->name }}</span>
                    @foreach ($profile->cards as $card)
                        <div class="flex flex-row justify-between px-4">
                            <span class="font-roboto text-[16px]">{{ $card->prime->insurer->name }} :</span>
                            <span class="font-mono font-bold text-[16px]">{{ $card->prime->cost }} CHF</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class='flex justify-end xs:px-0 md:px-4'>
            <div class='bg-customPurple flex rounded-[10px] ml-auto'>
                <a href="{{ route('result') }}"
                    class='font-roboto font-bold text-customWhite text-center flex items-center justify-center gap-2 px-6 py-[9px] w-[120px] h-[40px]'>
                    Voir
                    <img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">
                </a>
            </div>

        </div>
    </div>
