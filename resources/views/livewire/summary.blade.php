<div class='flex flex-col bg-[#F7F7F7] w-full p-5 justify-between h-full'>
    <div>
        <span class='font-poetsen text-[24px]'>Comparatif</span>
    </div>
    <div id="summary" class="font-roboto text-[16px] mt-4 overflow-y-auto flex-grow flex flex-col gap-8 pb-16">
        @foreach ($profiles as $profile)
            <div class="flex flex-col">
                <div class="flex flex-col gap-0 w-full">
                    <span
                        class="w-full h-full text-black bg-white rounded-t-[10px] font-bold px-4 py-0 my-0">{{ $profile->name }}</span>
                    @foreach ($profile->cards as $card)
                        <div class="flex flex-row justify-between bg-white px-4">
                            <span class="font-roboto text-[16px]">{{ $card->prime->insurer->name }} :</span>
                            <span class="font-mono font-bold text-[16px]">{{ $card->prime->cost }} CHF</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class='fixed bottom-4 left-1/2 transform -translate-x-1/2 max-w-screen-2xl w-full px-4'>
        <div class='flex justify-end xs:px-0 md:px-4'>
            <div class='bg-[#FF87AB] flex rounded-[10px] ml-auto'>
                <a href="{{ route('result') }}"
                    class='font-roboto font-bold text-center flex items-center justify-center gap-2 px-6 py-[9px] w-[120px] h-[40px]'>
                    Voir
                    <img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">
                </a>
            </div>
        </div>
    </div>
