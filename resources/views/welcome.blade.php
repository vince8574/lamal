
<x-layouts.page>
    <x-lang-selector />
    <section
        class='flex flex-col px-4 sm:px-6 md:px-12 lg:px-16 xl:px-32 min-h-screen items-center justify-center py-8 gap-5  w-full md:max-w-3xl lg:max-w-2/3 mx-auto'>
        <header class="w-full flex flex-col justify-center gap-2">

            <h1 class="font-poetsen font-bold text-[36px] text-customWhite text-left">
                {{ __('profile.title') }}
            </h1>
            <p class='text-[22px] text-customWhite leading-normal'>
                {{ __('profile.description') }}
               
            </p>
        </header>
        <div class="w-full">
            <livewire:profile />
        </div>
    </section>
</x-layouts.page>
