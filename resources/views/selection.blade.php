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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&family=Poetsen+One&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


    <!-- Styles -->


</head>

<body class="bg-[#3B7080] font-roboto px-32 min-h-screen">
    <div class='flex flex-row ml-0'>
        <div class='w-fit'>
            <a href="{{route('search')}}" class='ml-0 bg-[#FF87AB] w-[157px] h-[73px] flex items-center justify-center m-auto rounded-[10px] gap-4 font-roboto font-bold text-[20px]'><img src="{{ asset('images/svg/double_arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">Retour</a>
        </div>
        <h1 class='font-roboto text-[30px] font-bold m-auto'>Vos sélections</h1>
    </div>
    @foreach ($profiles as $profile)
    <div id="content" class='flex flex-col  m-auto mt-4'>
        <div class="flex flex-col w-fit bg-[#f7f7f7] rounded-[10px] min-w-24 p-1 ml-0">
            <div class="flex justify-end">
                <div class="rounded-full bg-[#fff] flex text-center justify-center items-center px-1 h-fit  ">
                    <span class="text-[8px] font-bold">{{$cards->where('profile_id', $profile->id)->count()}}</span>
                </div>
            </div>
            <span class="text-center font-bold">{{$profile->name}}</span>
        </div>
        <div class="max-w-full m-auto grid grid-cols-1 sm:grid-cols-4 gap-4 rounded-xl mt-4 flex">
            @foreach ($cards->where('profile_id', $profile->id) as $card)

            <div class=" p-2 flex flex-col rounded-[10px] border-2 border-black m-2/5 w-full rounded-[10 px] bg-white gap-y-4 p-4">
                <a href="{{route('card.select', ['prime_id' => $card->prime_id, 'profile_id' => $card->profile_id]) }}" class='rounded-full bg-[#FF87AB] w-[23px] h-[23px] p-[6px] flex ml-auto justify-center items-center'>
                    <img src="{{ asset('images/svg/cross.svg') }}" alt="Cross" class="w-4 h-4">
                </a>
                <x-card :prime="$card->prime" type='card'></x-card>
            </div>
            @endforeach
        </div>

    </div>
    @endforeach
</body>

</html>