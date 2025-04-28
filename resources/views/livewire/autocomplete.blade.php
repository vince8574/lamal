<div x-data="{
    open: false,
    highlightedIndex: 0,
    itemCount: {{ count($this->cities) }},

    init() {
        this.highlightedIndex = 0;
    },

    onKeyDown(e) {
        if (e.key === 'ArrowDown') {
            e.preventDefault();

            if (!this.open) {
                this.open = true;
                return;
            }

            this.highlightedIndex = Math.min(this.highlightedIndex + 1, this.itemCount - 1);

            // Forcer la mise à jour de l'interface
            this.$nextTick(() => {
                // Faire défiler vers l'élément surligné
                const items = this.$refs.dropdown.querySelectorAll('li');
                if (items && items[this.highlightedIndex]) {
                    items[this.highlightedIndex].scrollIntoView({ block: 'nearest' });
                }
            });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();

            this.highlightedIndex = Math.max(this.highlightedIndex - 1, 0);

            // Forcer la mise à jour de l'interface
            this.$nextTick(() => {
                // Faire défiler vers l'élément surligné
                const items = this.$refs.dropdown.querySelectorAll('li');
                if (items && items[this.highlightedIndex]) {
                    items[this.highlightedIndex].scrollIntoView({ block: 'nearest' });
                }
            });
        } else if (e.key === 'Enter') {
            e.preventDefault();

            if (this.open) {
                const items = this.$refs.dropdown.querySelectorAll('li');

                if (items && items[this.highlightedIndex]) {
                    const wireClick = items[this.highlightedIndex].getAttribute('wire:click');
                    const matches = wireClick.match(/selectValue\('([^']+)'\)/);

                    if (matches && matches[1]) {
                        const cityId = matches[1];
                        Livewire.find(this.$wire.$id).call('selectValue', cityId);
                        this.open = false;
                    }
                }
            }
        } else if (e.key === 'Escape') {
            e.preventDefault();
            this.open = false;
        }
    },

    resetHighlight() {
        this.highlightedIndex = 0;
    }
}" class="relative w-full" x-on:click.outside="open = false">

    <input type="text" wire:model.live="searchedValue" @focus="open = true" @keydown="onKeyDown($event)"
        @input="resetHighlight()" placeholder="{{ __('profile.autocomplete') }}"
        class="rounded-[10px] border border-gray-300 py-2 pr-3 pl-6 bg-customWhite font-roboto text-[22px] w-full" />

    <ul x-show="open" x-ref="dropdown"
        class="absolute left-0 top-full z-1000 bg-customWhite border border-gray-200 rounded-md text-[22px] w-full mt-1 overflow-y-scroll max-h-40">

        @foreach ($this->cities as $index => $citie)
            <li wire:click="selectValue('{{ $citie->id }}')" @click="open = false"
                @mouseenter="highlightedIndex = {{ $index }}"
                x-bind:class="{ 'bg-customYellow font-bold': highlightedIndex === {{ $index }} }"
                class="cursor-pointer px-4 py-2 flex flex-row items-center gap-3">
                <strong>{{ $citie->full_name }}</strong>

                <div class="text-sm text-gray-500 flex flex-row gap-1">
                    <img class="h-5 w-5"
                        src="{{ asset('images/svg/cantons_svg/' . $citie->municipality->district->canton->key . '.svg') }}" />
                    {{ ucfirst($citie->municipality->district->canton->name ?? '') }}
                </div>
            </li>
        @endforeach
    </ul>
</div>
