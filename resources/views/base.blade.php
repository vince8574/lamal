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

<body>
    <div class="flex flex-nowrap">
        <div id="sidebar" class="w-1/4 bg-[#a5b4fc] px-16 flex flex-wrap h-auto">

            <form class="flex flex-wrap flex-col mt-16" method="GET">
                <!-- @csrf -->
                <label for="canton">Canton</label>

                <select id="canton" name="canton">
                    <option value="">Toutes</option>
                    @foreach ($cantons as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach

                    <!-- <option value="AR">Appenzell Rhodes-Extérieures</option>
                    <option value="AI">Aigle</option>
                    <option value="AG">Argovie</option>
                    <option value="balecamp">Bâle-Campagne</option>
                    <option value="baleville">Bâle-Ville</option>
                    <option value="berne">Berne</option>
                    <option value="fribourg">Fribourg</option>
                    <option value="geneve">Genève</option>
                    <option value="glaris">Glaris</option>
                    <option value="grisons">Grisons</option>
                    <option value="jura">Jura</option>
                    <option value="lucerne">Lucerne</option>
                    <option value="neuchatel">Neuchâtel</option>
                    <option value="nidwald">Nidwald</option>
                    <option value="obwald">Obwald</option>
                    <option value="stgall">Saint-Gall</option>
                    <option value="schaffhouse">Schaffhouse</option>
                    <option value="schwytz">Schwytz</option>
                    <option value="soleure">Soleure</option>
                    <option value="tessin">Tessin</option>
                    <option value="thurgovie">Thurgovie</option>
                    <option value="uri">Uri</option>
                    <option value="valais">Valais</option>
                    <option value="vaud">Vaud</option>
                    <option value="zoug">Zoug</option>
                    <option value="zurich">Zurich</option> -->
                </select>

                <label for="age" class="mt-8">Tranche d'âge</label>

                <select id="age" name="age">
                    <option value="">Toutes</option>
                    @foreach ($ages as $age)
                    <option value="{{$age->id}}" {{request()->get('age') == $age->id ? 'selected':''}}>{{$age->key}}</option>
                    @endforeach
                    <!-- <option value="AKL-KIN">0-17 ans</option>
                    <option value="AKL-JUG">18-25 ans</option>
                    <option value="AKL-ERW">26 ans et +</option> -->
                </select>

                <label for="franchise" class="mt-8">Franchise</label>
                <select id="franchise" name="franchise">
                    <option value="">Toutes</option>
                    @foreach ($franchises as $f)
                    <option value="{{$f->id}}" {{request()->get('franchise') == $f->id ? 'selected':''}}>{{$f->key}}</option>
                    @endforeach
                </select>
                <label for="tarif_type" class="mt-8">Type de tarif</label>
                <select id="tarif_type" name="tarif_type">
                    <option value="">Toutes</option>
                    @foreach ($tariftypes as $tarif)
                    <option value="{{$tarif->id}}" {{request()->get('tarif_type') == $tarif->id ? 'selected':''}}>{{$tarif->label}}</option>
                    @endforeach
                </select>
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text pr-4">Accident</span>
                        <input type="checkbox" id='accident' name='accident' class="toggle" value="1" checked="checked" {{request()->get('accident')==0 ? 'checked':1}} />
                    </label>
                </div>
                <button type=" submit" class="btn btn-active btn-accent mt-8">Rechercher</button>

            </form>

        </div>
        <div id="content" class='bg-[#E6F1FA] w-3/4 flex flex-wrap items-center'>
            <h1 class='uppercase text-center mt-16 m-auto'>Calculez votre prime pour 2024</h1>
            <p class="mt-8 mx-32">En cas de MODIFICATION souhaitée de votre police d'ASSURANCE de base, le faire par écrit avant le 30 novembre 2023. Veuillez consulter les conditions d'utilisation.</p>
            <div class="w-3/5 m-auto grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-xl mt-4">
                @foreach ($primes as $prime)
                <div class=" p-2 flex flex-col m-auto rounded-xl border-2 border-black m-2/5 w-full  text-center rounded-xl bg-white">
                    <!-- {{$prime->id}} -->
                    <label>{{$prime->insurer->name}}</label>
                    <label>Tarif : {{str_replace('.',',',$prime->cost)}} CHF</label>
                    <label>Franchise : {{ $prime->franchise->franchise_numerique }} CHF</label>
                    @if($prime->accident === 1)
                    <label>Avec accident</label>
                    @else <label>Sans accident</label>
                    @endif
                    <label>Type de tarif : {{ $prime->tariftype->label }}</label>
                    <label class="truncate">Nom du tarif: {{$prime->tarif_name}}</label>
                </div>
                @endforeach

            </div>
            <div class='w-3/5 m-auto  justify-between font-bold'>
                {{$primes->links()}}
            </div>
        </div>
    </div>

</body>

</html>