<x-layouts.page>
    <form method='GET'>
        <input type="hidden" name="profile_id" value="{{$current_profile_id}}" />
        <div class="flex flex-row mx-32 ">
            <div class="w-fit p-5 flex flex-col bg-[#FFFFFF] gap-y-4 rounded-l-[10px]">
                <div id="search" class="w-fit flex flex-wrap h-auto">
                    <select id="canton" name="canton" class="rounded-[10px] border border-[#E0E0E0] py-3 pl-6 pr-3 font-roboto font-bold text-[24px]">
                        <option value=''>Toutes</option>
                        @foreach ($cantons as $c)
                        <option value="{{$c->id}}" {{$filter->canton == $c->id ? 'selected':''}}>{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="bg-[#F7F7F7] flex flex-row">

                    @foreach ($profiles as $profile)
                    <div class="bg-[#F7F7F7] flex flex-row">
                        <div @class(["bg-white"=>$profile->id == $current_profile_id, "bg-[#F7F7F7]"=>$profile->id != $current_profile_id, 'flex flex-row gap-[18px] ml-1 px-1 mt-1 rounded-t-[10px]'])>
                            <a href="{{route('search',['profile_id'=>$profile->id,'canton'=>$filter->canton])}}">
                                <label @class(["text-[#FF87AB]"=>$profile->id == $current_profile_id, "text-black"=>$profile->id != $current_profile_id])>{{ $profile->name }}</label>
                            </a>
                            @if($profiles->count()!=1)
                            <a href="{{route('user.delete',['profile_id'=>$profile->id])}}">
                                <img src="{{ asset('images/svg/cross.svg') }}" alt="cross" class="text-[#FF87AB]">
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach



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
                                <option value="{{$age->id}}" {{$filter->age == $age->id ? 'selected':''}}>{{$age->label}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col min-w-60">
                            <label for="franchise">Franchise</label>
                            <select id="franchise" name="franchise" class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                                <option value="">Toutes</option>
                                @foreach ($franchises as $f)
                                <option value="{{$f->id}}" {{$filter->franchise == $f->id ? 'selected':''}}>{{$f->numerique}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col min-w-60">
                            <label for="tariftype">Modèle d'assurance</label>
                            <select id="tariftype" name="tariftype" class="rounded-[10px] border border-[#E0E0E0] py-[10px] pl-6 pr-[10px] font-bold">
                                <option value="">Toutes</option>
                                @foreach ($tariftypes as $tarif)
                                <option value="{{$tarif->id}}" {{$filter->tariftype == $tarif->id ? 'selected':''}}>{{$tarif->label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-control flex flex-row justify-between">
                        <div>
                            <label class="label cursor-pointer">
                                <input type="checkbox" id='accident' name='accident' class="toggle" value="1" {{$filter->accident ? 'checked':''}} />
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
                    @foreach ($cards as $card)
                    <div class="flex flex-row justify-between">
                        <span class="font-roboto text-[16px]">{{$card->prime->insurer->name}} :</span>
                        <span class="font-mono font-bold text-[16px]">{{$card->prime->cost}}</span>
                    </div>
                    @endforeach
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
    <div id="content" class='flex flex-col flex-wrap items-center m-auto mx-32 gap-4'>
        <div class="max-w-full m-auto grid grid-cols-1 sm:grid-cols-4 gap-4 rounded-xl mt-4">
            @foreach ($primes as $prime)
            @php
            $selected = $cards->where('prime_id',$prime->id)->count()>0;
            @endphp

            <a href="{{route('card.select', ['prime_id' => $prime->id, 'profile_id' => $current_profile_id]) }}">
                <x-card :prime="$prime" type='card' @class(["cursor-pointer","border-[#FF87AB] border-4"=> $selected, "border-none" => !$selected])></x-card>
            </a>
            @endforeach

        </div>
        <div class='w-fit m-auto  justify-between font-bold'>
            {{$primes->links()}}
        </div>
    </div>

</x-layouts.page>