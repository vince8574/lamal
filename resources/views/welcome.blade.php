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

<body class="bg-[#3B7080] font-roboto min-h-screen flex px-32">
    <form action="{{route('search')}}" method="GET" class='flex flex-col gap-8 m-auto'>
        <h1 class="font-bold m-auto text-[30px]">Calculez votre prime pour 2025</h1>
        <span class='text-[22px]'>En cas de MODIFICATION souhaitée de votre police d'ASSURANCE de base, le faire par écrit avant le 30 novembre 2024. Veuillez consulter les conditions d'utilisation</span>

        <div class='m-auto text-[30px] mt-8'>
            <select id="canton" name="canton" class="font-bold rounded-[10px] border border-[#E0E0E0] py-3 pl-6 pr-3 text-center">
                <option value="">Cantons</option>
                @foreach ($cantons as $c)
                <option value="{{$c->id}}" {{request()->get('canton') == $c->id ? 'selected':''}}>{{$c->name}}</option>
                @endforeach
            </select>
        </div>
        <div class='flex flex-col text-[30px] m-auto gap-4'>
            <input name='name' placeholder="Entrez votre joli nom" class='rounded-[10px] py-3 text-center font-bold' {{request()->get('name')}}>
        </div>
        <button type="submit" class='rounded-[10px] bg-[#FF87AB] w-[343px] h-auto py-[18px] px-[17px] text-center justify-center flex items-center m-auto font-bold text-[20px] gap-4'>Comparer les primes<img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4"></button>

    </form>
</body>

</html>