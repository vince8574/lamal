<div class='flex flex-col rounded-r-[10px] bg-[#F7F7F7] w-full p-5 justify-between'>
    <div>
        <span class='font-poetsen'>Comparatif</span>
    </div>
    <div id="summary" class="font-roboto text-[16px] mt-4 overflow-y-auto max-h-[150px] space-y-2">

        @foreach ($cards as $card)
            <div class="flex flex-row justify-between">
                <span class="font-roboto text-[16px]">{{ $card->prime->insurer->name }} :</span>
                <span class="font-mono font-bold text-[16px]">{{ $card->prime->cost }}</span>
            </div>
        @endforeach
    </div>
    <div class='w-full flex flex-row'>

        <div class='bg-[#FF87AB] flex rounded-[10px] ml-auto'>
            <a href="{{ route('result') }}"
                class='font-roboto font-bold text-center flex items-center justify-center gap-2 px-6 py-[9px] w-[120px] h-[40px]'>
                Voir
                <img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">
            </a>
        </div>
    </div>
</div>
