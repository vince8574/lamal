@props(['name'])
<div x-data="{ open: false, name: '{{ $name }}' }" x-on:click.outside="open = false" x-show="open"
    x-on:open-modal.window="open = (event.detail.name === name)"
    x-on:close-modal.window="open = !(event.detail.name === name)" x-on:keydown.escape.window="open = false"
    style="display:none;" class="fixed inset-0 z-50">

    <!-- Arrière-plan avec opacité de 20% -->
    <div x-on:click="open = false" class="fixed inset-0 bg-black opacity-20 z-40"></div>

    <!-- Contenu de la modale -->
    <div class="fixed bg-white w-[90%] h-[90%] max-w-3xlfixed inset-0 flex items-center justify-center z-50">
        <div class="fixed rounded-[15px] bg-white w-[90%] h-[90%] shadow-lg flex flex-col gap-8">
            <!-- Bouton de fermeture -->
            <div class="flex justify-end">
                <button x-on:click="open = false" class="absolute top-0 right-0 p-4">
                    <img src="{{ asset('images/svg/cross.svg') }}" alt="cross">
                </button>
            </div>

            <!-- Corps de la modale -->
            <div class="p-4 overflow-y-auto">
                {{ $body }}
            </div>
        </div>
    </div>
</div>
