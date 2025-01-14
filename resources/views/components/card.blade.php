<div {{ $attributes->merge(['class' => "card card-$type"]) }}>
    <div class="card p-2 flex flex-col rounded-[10px] m-2/5 w-full rounded-[10 px] bg-white gap-y-4 p-4 cursor-pointer"
        data-id="{{ $prime->id }}" data-cost="{{ $prime->cost }}" data-insurer="{{ $prime->insurer->name }}">
        {{ $slot }}
        <div class="text-right">
            <label class="font-poetsen text-[30px] cursor-pointer">{{ $prime->cost }} CHF</label>
        </div>


        <div class='flex flex-col font-roboto text-[16px]'>
            <!-- {{ $prime->id }} -->
            <label class="cursor-pointer">{{ $prime->canton->key }}</label>
            <label class='font-bold cursor-pointer'>{{ $prime->insurer->name }}</label>
            <label class="cursor-pointer">{{ $prime->tariftype->label }}</label>
            <label class="cursor-pointer">Franchise : <span class='font-poetsen'>{{ $prime->franchise->numerique }}
                    CHF</span></label>
            <label class="truncate cursor-pointer">{{ $prime->tarif_name }}</label>
            @if ($prime->accident === 1)
                <label class='text-[10px] cursor-pointer'>*Assurance accident incluse</label>
            @else
                <label class='text-[10px] cursor-pointer'>*Assurance accident non incluse</label>
            @endif
        </div>

    </div>
</div>
