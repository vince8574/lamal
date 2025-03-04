<?php

namespace App\Livewire;

use App\Actions\DeleteProfileAction;
use App\Facades\AnonymousUser;
use App\Livewire\Profile as LivewireProfile;
use App\Livewire\Traits\HasSearchFilter;
use App\Models\City;
use App\Models\Profile;
use App\ViewModels\FiltersValuesViewModel;
use App\ViewModels\FranchiseViewModel;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchForm extends Component
{
    use HasSearchFilter;

    #[Url()]
    public int $profile_id;

    public $npa = '';

    public $searchCity = '';

    public $cities = [];

    protected $listeners = ['searchFormUpdated' => '$refresh'];

    public function dispatchFilterUpdate()
    {
        $this->dispatch('searchUpdate', value: $this->filter, profile_id: $this->profile_id);
    }

    public function mount()
    {
        $profile = Profile::find($this->profile_id);
        if ($profile) {
            // Vérifiez si le champ filter est une chaîne JSON valide
            if (is_string($profile->filter)) {
                $this->filter = json_decode($profile->filter, true) ?? [];
            } elseif (is_array($profile->filter)) {
                $this->filter = $profile->filter; // Si c'est déjà un tableau
            } else {
                $this->filter = []; // Valeur par défaut si non valide
            }
            $this->searchCity = $this->filter['city'] ?? '';
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
        $this->searchCity = $this->filter['city'] ?? '';
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

    public function updatedSearchCity()
    {
        if (! empty($this->searchCity)) {
            $this->cities = City::with(['municipality.district.canton'])
                ->where('name', 'LIKE', "%{$this->searchCity}%")
                ->orWhere('npa', 'LIKE', "%{$this->searchCity}%")
                ->limit(10)
                ->get();

            $this->filter = array_merge($this->filter, [
                'city' => $this->searchCity,
            ]);
        } else {
            $this->cities = [];
        }
    }

    public function selectCity($cityId)
    {
        $city = City::with(['municipality.district.canton'])->find($cityId);

        if ($city) {
            $this->npa = $city->npa;
            $this->searchCity = $city->name;

            $this->filter = array_merge($this->filter, [
                'city' => $city->name,
                'npa' => $city->npa,
                'canton' => $city->municipality->district->canton->id ?? '',
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
            'profiles' => Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->get(),
        ]);
    }

    public function openProfileModal()
    {
        $this->dispatch('openModal', component: LivewireProfile::class, arguments: ['inModal' => true]);
    }
}
