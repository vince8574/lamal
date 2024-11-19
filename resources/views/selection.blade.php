<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css', 'resources/js/app.js')

    <title>Ouille iLamal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    <!-- Styles -->


</head>

<body class="bg-[#3B7080] font-roboto px-32">
    <div class='flex flex-row ml-0'>
        <div class='w-fit'>
            <a href="{{route('search')}}" class='ml-0 bg-[#FF87AB] w-[157px] h-[73px] flex items-center justify-center m-auto rounded-[10px] gap-4 font-roboto font-bold text-[20px]'><img src="{{ asset('images/svg/double_arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">Retour</a>
        </div>
        <h1 class='font-roboto text-[30px] font-bold m-auto'>Vos sélections</h1>
    </div>
    <div id="content" class='flex flex-wrap items-center m-auto'>
        <div class="max-w-full m-auto grid grid-cols-1 sm:grid-cols-4 gap-4 rounded-xl mt-4">
            @foreach ($cards as $card)
            <div class=" p-2 flex flex-col rounded-[10px] border-2 border-black m-2/5 w-full rounded-[10 px] bg-white gap-y-4 p-4">
                <form action="{{ route('delete.card') }}" method="POST">
                    @csrf
                    <div class='rounded-full bg-[#FF87AB] w-[23px] h-[23px] p-[6px] flex ml-auto justify-center items-center'>
                        <button type='submit'><img src="{{ asset('images/svg/cross.svg') }}" alt="Cross" class="w-4 h-4"></button>
                    </div>
                </form>
                <div class="text-right">
                    <label class="font-poetsen text-[30px]">{{$card->cost}} CHF</label>
                </div>
                <div class='flex flex-col font-roboto text-[16px]'>
                    <!-- {{$card->id}} -->
                    <label>{{$card->canton->key}}</label>
                    <label class='font-bold'>{{$card->insurer->name}}</label>
                    <label>{{ $card->tariftype->label }}</label>
                    <label>Franchise : <span class='font-poetsen'>{{ $card->franchise->numerique }} CHF</span></label>
                    <label class="truncate">{{$card->tarif_name}}</label>
                    @if($card->accident === 1)
                    <label class='text-[10px]'>*Assurance accident incluse</label>
                    @else <label class='text-[10px]'>*Assurance accident non incluse</label>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>
</body>