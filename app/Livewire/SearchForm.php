<?php

namespace App\Livewire;

use App\Actions\CreateProfileAction;
use App\Actions\DeleteProfileAction;
use App\DTO\SearchFilter;
use App\Facades\AnonymousUser;
use App\Models\Profile;
use App\ViewModels\FiltersValuesViewModel;
use App\ViewModels\FranchiseViewModel;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Canton;

class SearchForm extends Component
{
    #[Url()]
    public int $profile_id;



    #[Url()]
    public array $filter = [];
    protected $listeners = ['searchFormUpdated' => '$refresh'];

    public $searchCanton = '';
    public $cantons = [];

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

        $this->filter = $value === '' ? null : $value;
        $this->dispatch('searchUpdate', value: $this->filter, profile_id: $this->profile_id);
    }

    public function selectProfile($profile_id)
    {

        $this->profile_id = $profile_id;

        $profile = Profile::find($profile_id);
        if ($profile) {
            // Vérifiez si la valeur est déjà un tableau ou une chaîne JSON
            if (is_string($profile->filter)) {
                $this->filter = json_decode($profile->filter, true) ?? [];
            } elseif (is_array($profile->filter)) {
                $this->filter = $profile->filter; // Si c'est déjà un tableau
            } else {
                $this->filter = []; // Valeur par défaut
            }
        } else {
            $this->filter = []; // Valeur par défaut si le profil est introuvable
        }

        $this->dispatch('searchUpdate', value: $this->filter, profile_id: $this->profile_id);
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

        $this->updated('filter', $this->filter);
    }

    public function render()
    {
        dump($this->filter);
        $filter = SearchFilter::from(
            $this->filter,

        );


        $franchiseVm = FranchiseViewModel::make($filter->age);
        $filtersvaluesvm = FiltersValuesViewModel::make();
        return view('livewire.search-form', [
            ...$filtersvaluesvm->all(),
            ...$franchiseVm->all(),
            'profiles' => Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->get()
        ]);
    }
}
