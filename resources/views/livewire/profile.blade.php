<div @class([
    'flex flex-col text-[30px] mx-auto gap-4 w-full ',
    'w-full p-4 min-h-20' => $inModal,
])>

    <livewire:autocomplete key="profile" event_key="profile" />
    @error('city')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
    <div class='w-full'>
        <input name='name' placeholder="{{ __('profile.name_input') }}"
            class='bg-white rounded-[10px] border border-gray-300 w-full py-2 pr-3 pl-6 font-roboto  text-[22px]'
            wire:model="name">
        @error('name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="w-full flex justify-end">
        <a wire:click="createProfile"
            class='rounded-[10px] bg-customYellow h-auto py-2 px-6 text-center justify-center flex items-center justify-center text-[22px] gap-2 cursor-pointer'>
            Comparer
            les primes<img src="{{ asset('images/svg/right-arrow-forward-black.svg') }}" alt="Right Arrow"
                class="w-4 h-4"></a>
    </div>
</div>
