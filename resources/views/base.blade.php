<x-layouts.page>
    <div class="flex flex-col md:flex-row w-full relative">
        <!-- Left column for search form and results -->
        <div class="flex flex-col flex-1">
            <livewire:search-form />
            <livewire:search-result />
        </div>

        <!-- Summary panel with slide functionality -->
        <div x-data="{ open: false }" class="fixed md:relative bottom-0 right-0 md:w-80 w-full z-10">
            <!-- Toggle button (visible only on mobile) -->
            <div @click="open = !open"
                class="bg-gray-300 p-2 rounded-t-lg flex items-center justify-center cursor-pointer md:hidden">
                <div class="flex items-center">
                    <span class="mr-2">Comparatif</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        :class="open ? 'transform rotate-90' : 'transform -rotate-90'"
                        class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>

            <!-- Summary content - hidden on mobile when closed, always visible on desktop -->
            <div x-bind:class="{ 'hidden': !open, 'block': open }" class="md:block h-full md:w-80 w-full shrink-0">
                <livewire:summary />
            </div>
        </div>
    </div>
</x-layouts.page>
