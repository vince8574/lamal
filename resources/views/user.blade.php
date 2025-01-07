<x-layouts.page>
    <div class='flex flex-row mx-32'>
        <div class='w-fit'>
            <a href="{{ route('search') }}"
                class='ml-0 bg-[#FF87AB] w-[157px] h-[73px] flex items-center justify-center m-auto rounded-[10px] gap-4 font-roboto font-bold text-[20px]'><img
                    src="{{ asset('images/svg/double_arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">Retour</a>
        </div>
    </div>
    <div class='flex flex-col gap-4 px-32 h-screen items-center justify-center'>

        <livewire:profile />
    </div>

</x-layouts.page>
