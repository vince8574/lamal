<div class="max-w-full m-auto grid grid-cols-1 sm:grid-cols-4 gap-4 rounded-xl mt-4">
    <div class=" p-2 flex flex-col rounded-[10px] border-2 border-black m-2/5 w-full rounded-[10 px] bg-white gap-y-4 p-4">
        <div class="text-right">
            <label class="font-poetsen text-[30px]">{{$prime->cost}} CHF</label>
        </div>
        <div class='flex flex-col font-roboto text-[16px]'>

            <label>{{$prime->canton->key}}</label>
            <label class='font-bold'>{{$prime->insurer->name}}</label>
            <label>{{ $prime->tariftype->label }}</label>
            <label>Franchise : <span class='font-poetsen'>{{ $prime->franchise->numerique }} CHF</span></label>
            <label class="truncate">{{$prime->tarif_name}}</label>
            @if($prime->accident === 1)
            <label class='text-[10px]'>*Assurance accident incluse</label>
            @else <label class='text-[10px]'>*Assurance accident non incluse</label>
            @endif
        </div>
    </div>
</div>