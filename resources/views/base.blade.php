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

<body class="bg-[#3B7080]">
    <div class="flex flex-row mx-32">
        <div class="w-fit p-5 flex flex-col bg-[#FFFFFF] gap-y-4 rounded-l-[10px]">
            <div id="search" class="w-fit flex flex-wrap h-auto">
                <select id="canton" name="canton" class="rounded-[10px] border border-[#E0E0E0] py-3 pl-6 pr-3 font-roboto font-bold text-[24px]">
                    <option value="">Toutes</option>
                    @foreach ($cantons as $c)
                    <option value="{{$c->id}}" {{request()->get('canton') == $c->id ? 'selected':''}}>{{$c->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="bg-[#F7F7F7] p-5">
                <!-- Nom de la personne -->
            </div>
            <form class="flex flex-col gap-y-4 font-roboto text-[16px]" method="GET">
                <div class="flex flex-row gap-x-4">
                    <div class="flex flex-col min-w-60">
                        <label for="age">Tranche d'âge</label>

                        <select id="age" name="age" class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                            <option value="">Toutes</option>
                            @foreach ($ages as $age)
                            <option value="{{$age->id}}" {{request()->get('age') == $age->id ? 'selected':''}}>{{$age->label}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col min-w-60">
                        <label for="franchise">Franchise</label>
                        <select id="franchise" name="franchise" class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                            <option value="">Toutes</option>
                            @foreach ($franchises as $f)
                            <option value="{{$f->id}}" {{request()->get('franchise') == $f->id ? 'selected':''}}>{{$f->numerique}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col min-w-60">
                        <label for="tarif_type">Modèle d'assurance</label>
                        <select id="tarif_type" name="tarif_type" class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                            <option value="">Toutes</option>
                            @foreach ($tariftypes as $tarif)
                            <option value="{{$tarif->id}}" {{request()->get('tarif_type') == $tarif->id ? 'selected':''}}>{{$tarif->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-control flex flex-row justify-between">
                    <div>
                        <label class="label cursor-pointer">
                            <input type="checkbox" id='accident' name='accident' class="toggle" value="1" {{filled(request()->get('accident')) ? 'checked':''}} />
                            <span class="label-text ml-4">Assurance accident de base</span>
                        </label>
                    </div>
                    <button type=" submit" class="btn btn-active btn-accent bg-[#FF87AB] px-6 py-[9px] w-[120px] h-[40px]"><img src="{{ asset('images/svg/search.svg') }}"></button>
                </div>
            </form>

        </div>
        <div class='flex flex-col rounded-r-[10px] bg-[#F7F7F7] w-full p-5 justify-between'>
            <div class=''>
                <span class='font-poetsen'>Comparatif</span>
            </div>
            <div class='w-full flex flex-row'>
                <div class='bg-[#FF87AB] flex rounded-[10px] ml-auto'>
                    <button class='font-roboto font-bold text-center flex items-center justify-center gap-2 px-6 py-[9px] w-[120px] h-[40px]'>
                        Voir
                        <img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="content" class='flex flex-wrap items-center m-auto mx-32 gap-4'>
        <div class="max-w-full m-auto grid grid-cols-1 sm:grid-cols-4 gap-4 rounded-xl mt-4">
            @foreach ($primes as $prime)
            <div class=" p-2 flex flex-col rounded-[10px] border-2 border-black m-2/5 w-full rounded-[10 px] bg-white gap-y-4 p-4">
                <div class="text-right">
                    <label class="font-poetsen text-[30px]">{{$prime->cost}} CHF</label>
                </div>
                <div class='flex flex-col font-roboto text-[16px]'>
                    <!-- {{$prime->id}} -->
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
            @endforeach

        </div>
        <div class='w-3/5 m-auto  justify-between font-bold'>
            {{$primes->links()}}
        </div>
    </div>

</body>

</html>