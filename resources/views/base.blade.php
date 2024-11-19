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
    <form method='GET'>
        <input type="hidden" name="profile_id" value="{{$current_profile_id}}" />
        <div class="flex flex-row mx-32">
            <div class="w-fit p-5 flex flex-col bg-[#FFFFFF] gap-y-4 rounded-l-[10px]">
                <div id="search" class="w-fit flex flex-wrap h-auto">
                    <select id="canton" name="canton" class="rounded-[10px] border border-[#E0E0E0] py-3 pl-6 pr-3 font-roboto font-bold text-[24px]">
                        <option value=''>Toutes</option>
                        @foreach ($cantons as $c)
                        <option value="{{$c->id}}" {{request()->get('canton') == $c->id ? 'selected':''}}>{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="bg-[#F7F7F7] flex flex-row">
                    @foreach ($profiles as $profile)
                    <div class="bg-[#F7F7F7] flex flex-row">
                        <a href="{{route('search',['profile_id'=>$profile->id])}}">
                            <div @class(["bg-white"=>$profile->id == $current_profile_id, "bg-[#F7F7F7]"=>$profile->id != $current_profile_id, 'flex flex-row gap-[18px] ml-1 px-1 mt-1 rounded-t-[10px]'])>
                                <label @class(["text-[#FF87AB]"=>$profile->id == $current_profile_id, "text-black"=>$profile->id != $current_profile_id])>{{ $profile->name }}</label>
                                <img src="{{ asset('images/svg/cross.svg') }}" alt="cross" class="text-[#FF87AB] remove-button" ">
                            </div>
                        </a>
                    </div>
                    @endforeach

                    <script>
                        document.querySelectorAll('.remove-button').forEach(button => {
                            button.addEventListener('click', function() {
                                const buttonName = this.dataset.name;
                                fetch(`{{ route('remove_button') }}?name=${buttonName}`, {
                                        method: 'GET'
                                    })
                                    .then(() => location.reload());
                            });
                        });
                    </script>

                    <div class='bg-white flex'>
                        <a href=" {{route('user')}}" class="group relative px-6 py-[2px] flex rounded-bl-[10px] bg-[#F7F7F7]">
                                <img src="{{ asset('images/svg/plus.svg') }}" alt="plus">
                                <span class="absolute inset-0 rounded-full bg-[#3B7080] opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col gap-y-4 font-roboto text-[16px]" method="GET">
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
                </div>

            </div>
            <div class='flex flex-col rounded-r-[10px] bg-[#F7F7F7] w-full p-5 justify-between'>
                <div class=''>
                    <span class='font-poetsen'>Comparatif</span>
                </div>
                <div id="summary" class="font-roboto text-[16px] mt-4">
                    <!-- Les informations sélectionnées apparaîtront ici -->
                </div>
                <div class='w-full flex flex-row'>

                    <div class='bg-[#FF87AB] flex rounded-[10px] ml-auto'>
                        <a href="{{ route('result') }}" class='font-roboto font-bold text-center flex items-center justify-center gap-2 px-6 py-[9px] w-[120px] h-[40px]'>
                            Voir
                            <img src="{{ asset('images/svg/right-arrow.svg') }}" alt="Right Arrow" class="w-4 h-4">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="content" class='flex flex-wrap items-center m-auto mx-32 gap-4'>
        <div class="max-w-full m-auto grid grid-cols-1 sm:grid-cols-4 gap-4 rounded-xl mt-4">
            @foreach ($primes as $prime)
            <div class="card p-2 flex flex-col rounded-[10px] m-2/5 w-full rounded-[10 px] bg-white gap-y-4 p-4" data-id="{{ $prime->id }}"
                data-cost="{{ $prime->cost }}"
                data-insurer="{{ $prime->insurer->name }}">

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
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const summaryContainer = document.getElementById('summary');

            // Fonction pour restaurer les sélections à partir du localStorage
            function restoreSelections() {
                const selectedItems = JSON.parse(localStorage.getItem('selectedItems')) || [];
                selectedItems.forEach(item => {
                    // Ajouter les éléments sauvegardés sous comparatif
                    const summaryItem = document.createElement('div');
                    summaryItem.classList.add('summary-item', 'flex', 'justify-between', 'font-roboto', 'text-[16px]');
                    summaryItem.setAttribute('data-id', item.id);
                    summaryItem.innerHTML = `
                <span class="font-roboto text-[16px]">${item.insurer} :</span>
                <span class="font-mono font-bold text-[16px]">${item.cost} CHF</span>
            `;
                    summaryContainer.appendChild(summaryItem);

                    // Ajouter la bordure aux cards correspondantes
                    const card = document.querySelector(`.card[data-id="${item.id}"]`);
                    if (card) {
                        card.classList.add('border-customPink');
                        card.classList.add('border-4');
                    }
                });

                // Si plus de 5 éléments, afficher "......"
                if (selectedItems.length > 5) {
                    const dotsItem = document.createElement('div');
                    dotsItem.classList.add('summary-item', 'flex', 'justify-center', 'font-roboto', 'text-[16px]');
                    dotsItem.innerHTML = `<span class="font-roboto text-[16px]">......</span>`;
                    summaryContainer.appendChild(dotsItem);
                }
            }

            // Fonction pour enregistrer les sélections dans le localStorage
            function saveSelections() {
                const selectedItems = [];
                summaryContainer.querySelectorAll('.summary-item').forEach(item => {
                    const id = item.getAttribute('data-id');
                    const cost = item.querySelector('.font-mono').textContent.replace(' CHF', '');
                    const insurer = item.querySelector('.font-roboto').textContent.split(':')[0].trim();
                    selectedItems.push({
                        id,
                        cost,
                        insurer
                    });
                });

                localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            }

            // Récupérer les sélections au chargement de la page
            restoreSelections();

            // Ajouter ou retirer des éléments du comparatif lorsque les cards sont sélectionnées
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('click', function() {
                    const primeId = this.dataset.id;
                    const primeCost = this.dataset.cost;
                    const primeInsurer = this.dataset.insurer;

                    // Toggle la bordure
                    this.classList.toggle('border-customPink');
                    this.classList.toggle('border-4');

                    const itemCount = summaryContainer.querySelectorAll('.summary-item').length;

                    if (this.classList.contains('border-customPink')) {
                        if (itemCount < 5) {
                            // Ajouter un élément de résumé
                            const summaryItem = document.createElement('div');
                            summaryItem.classList.add('summary-item', 'flex', 'justify-between', 'font-roboto', 'text-[16px]');
                            summaryItem.setAttribute('data-id', primeId);
                            summaryItem.innerHTML = `
                        <span class="font-roboto text-[16px]">${primeInsurer} :</span>
                        <span class="font-mono font-bold text-[16px]">${primeCost} CHF</span>
                    `;
                            summaryContainer.appendChild(summaryItem);
                        } else if (itemCount === 5) {
                            // Ajouter "......" après 5 éléments
                            const summaryItem = document.createElement('div');
                            summaryItem.classList.add('summary-item', 'flex', 'justify-center', 'font-roboto', 'text-[16px]');
                            summaryItem.setAttribute('data-id', 'point');
                            summaryItem.innerHTML = `
                        <span class="font-roboto text-[16px]">......</span>
                    `;
                            summaryContainer.appendChild(summaryItem);
                        }
                    } else {
                        // Supprimer l'élément de résumé correspondant
                        document.querySelector(`.summary-item[data-id="${primeId}"]`).remove();
                        const newExistingItems = summaryContainer.querySelectorAll('.summary-item');
                        const newItemCount = newExistingItems.length;
                        if (newItemCount < 6) {
                            document.querySelector(`.summary-item[data-id="point"]`).remove();
                        }
                    }

                    // Sauvegarder les sélections après chaque modification
                    saveSelections();
                });
            });
        });
    </script> -->
</body>

</html>