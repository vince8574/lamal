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

<body class="bg-[#3B7080] font-roboto min-h-screen flex px-32">
    <form action="{{route('search')}}" class='flex flex-col gap-8 m-auto'>
        <h1 class="font-bold m-auto text-[30px]">Entrez votre joli nom</h1>

        <div class='flex flex-col text-[30px] m-auto gap-4'>
            <input name='name' placeholder="Entrez votre joli nom" class='rounded-[10px] py-3 text-center font-bold' {{request()->get('name')}}>
        </div>
        <button type="submit" class='rounded-[10px] bg-[#FF87AB] w-[343px] h-[108px] py-[24px] px-[17px] text-center justify-center flex items-center m-auto font-bold text-[20px] gap-4'>Comparer les primes<img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4"></button>

    </form>
</body>

</html>