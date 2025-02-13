<?php

namespace App\Livewire;

use App\Actions\CreateProfileAction;
use App\Actions\DeleteProfileAction;
use App\DTO\SearchFilter;
use App\DTO\SearchFilterForm;
use App\Facades\AnonymousUser;
use App\Models\Profile;
use App\ViewModels\FiltersValuesViewModel;
use App\ViewModels\FranchiseViewModel;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Canton;
use App\Livewire\Traits\HasSearchFilter;
use App\Models\Citie;


class SearchForm extends Component

{
    use HasSearchFilter;
    #[Url()]
    public int $profile_id;

    public $npa = '';
    public $searchCity = '';
    public $cities = [];

    protected $listeners = ['searchFormUpdated' => '$refresh'];

    public $searchCanton = '';
    public $cantons = [];

    public $suggestions = [];
    public $selectedCanton = null;

    public function dispatchFilterUpdate()
    {
        $this->dispatch('searchUpdate', value: $this->filter, profile_id: $this->profile_id);
    }

    public function mount()
    {
        //  dump(request()->all());
        //   $this->filter = SearchFilter::fromRequest(request());
        $profile = Profile::find($this->profile_id);
        $this->cantons = Canton::all();
        if ($profile) {
            // Vérifiez si le champ filter est une chaîne JSON valide
            if (is_string($profile->filter)) {
                $this->filter = json_decode($profile->filter, true) ?? [];
            } elseif (is_array($profile->filter)) {
                $this->filter = $profile->filter; // Si c'est déjà un tableau
            } else {
                $this->filter = []; // Valeur par défaut si non valide
            }
        }
    }



    public function updated($key, $value)
    {

        //$this->filter = $value === '' ? null : $value;

        $this->dispatchFilterUpdate();
    }

    public function selectProfile($profile_id)
    {

        $this->profile_id = $profile_id;

        $profile = Profile::find($profile_id);
        $filter = [];
        if ($profile) {
            $filter = $profile->filter; // Si c'est déjà un tableau
        }

        $this->filter = $filter;
        $this->dispatchFilterUpdate();
    }

    public function deleteProfile($profile_id)
    {
        try {


            DeleteProfileAction::make()->execute($profile_id);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect(route('search'));
    }

    public function updatedSearchCanton()
    {
        $this->cantons = Canton::where('name', 'like', '%' . $this->searchCanton . '%')->get();
    }

    public function selectCanton($cantonId, $cantonName)
    {

        $this->filter = array_merge($this->filter, ["canton" => $cantonId]);  // Met à jour le filtre avec l'ID du canton sélectionné
        $this->searchCanton = $cantonName;    // Met à jour le champ de recherche avec le nom du canton
        $this->selectedCanton = $cantonId;    // Met à jour le canton sélectionné
        $this->cities = [];

        // $this->updated('filter', $this->filter);
        $this->dispatchFilterUpdate();
    }

    public function updatedNpa()
    {
        if (!empty($this->npa)) {
            $this->suggestions = Citie::with(['municipalitie.district.canton'])
                ->where('npa', 'LIKE', "{$this->npa}%")
                ->limit(10)
                ->get()
                ->map(function ($citie) {
                    return [
                        'npa' => $citie->npa,
                        'city' => $citie->name,
                        'municipality' => $citie->municipalitie->name ?? '',
                        'district' => $citie->municipalitie->district->name ?? '',
                        'canton' => $citie->municipalitie->district->canton->name ?? '',
                    ];
                })
                ->toArray();
        } else {
            $this->suggestions = [];
        }
    }



    public function updatedSearchCity()
    {
        if (!empty($this->searchCity)) {
            $this->cities = Citie::with(['municipalitie.district.canton'])
                ->where('name', 'LIKE', "%{$this->searchCity}%")
                ->orWhere('npa', 'LIKE', "%{$this->searchCity}%")
                ->limit(10)
                ->get();

            $this->filter = array_merge($this->filter, [
                'citie' => $this->searchCity,
            ]);
        } else {
            $this->cities = [];
        }
    }



    public function selectCity($cityId)
    {
        $city = Citie::with(['municipalitie.district.canton'])->find($cityId);

        if ($city) {
            $this->npa = $city->npa;
            $this->searchCity = $city->name;
            $this->selectedCanton = $city->municipalitie->district->canton->name ?? '';

            $this->filter = array_merge($this->filter, [
                'city' => $city->name,
                'npa' => $city->npa,
                'canton' => $city->municipalitie->district->canton->id ?? '',
            ]);

            $this->dispatchFilterUpdate();
        }
    }

    public function render()
    {
        $filter = $this->getFilter();



        $franchiseVm = FranchiseViewModel::make($filter->age);
        $filtersvaluesvm = FiltersValuesViewModel::make();
        return view('livewire.search-form', [
            ...$filtersvaluesvm->all(),
            ...$franchiseVm->all(),
            'profiles' => Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->get()
        ]);
    }
}
