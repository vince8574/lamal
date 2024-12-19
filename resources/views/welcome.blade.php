<x-layouts.page>

    <div class='flex flex-col gap-8 px-32 h-screen items-center justify-center'>
        <h1 class="font-bold mx-auto text-[30px]">Calculez votre prime pour 2025</h1>
        <span class='text-[22px]'>En cas de MODIFICATION souhaitée de votre police d'ASSURANCE de base, le faire par
            écrit avant le 30 novembre 2024. Veuillez consulter les conditions d'utilisation</span>
        <div class='mx-auto text-[30px]'>
            <select id="canton" wire:model.live="filter.canton" name="canton"
                class="font-bold rounded-[10px] border border-[#E0E0E0] py-3 pl-6 pr-3 text-center">
                <option value="">Cantons</option>
                @foreach ($cantons as $c)
                    <option value="{{ $c->id }}" {{ request()->get('canton') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <livewire:profile />
    </div>
</x-layouts.page>
