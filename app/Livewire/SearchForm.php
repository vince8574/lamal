<?php

namespace App\Livewire;

use App\Actions\DeleteProfileAction;
use App\Facades\AnonymousUser;
use App\Livewire\Profile as LivewireProfile;
use App\Livewire\Traits\HasSearchFilter;
use App\Livewire\Traits\LoadProfileFilter;
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
    use LoadProfileFilter;

    #[Url()]
    public int $profile_id;


    protected $listeners = ['searchFormUpdated' => '$refresh', 'autocomplete_did_change.search-form' => 'selectCity'];

    public function dispatchFilterUpdate()
    {
        $this->dispatch('searchUpdate', profile_id: $this->profile_id);
    }
   
    public function saveSearchToProfile()
    {
        Profile::where('id', $this->profile_id)->update([
            'filter' => $this->filter,
        ]);
    }

    public function mount()
    {
        $this->loadProfileFilter();
        $this->dispatchFilterUpdate();
    }

    public function updated($key, $value)
    {

        if (strpos($key, 'filter') !== false) {
            $this->saveSearchToProfile();
        }


        $this->dispatchFilterUpdate();
    }

    public function selectProfile($profile_id)
    {

        $profile = Profile::find($profile_id);
        if ($profile) {
            $this->profile_id = $profile_id;
            $this->loadProfileFilter();
            $this->dispatchFilterUpdate();
            $this->dispatch('profileChanged', profile_id: $profile_id);
        }
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

    public function selectCity($value)
    {
        $cityId = $value;
        $city = City::with(['municipality.district.canton'])->find($cityId);

        if ($city) {
            if (!is_array($this->filter)) {
                $this->filter = [];
            }
            $this->filter['city'] = $city->id;

            $this->dispatchFilterUpdate();
            $this->saveSearchToProfile();
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
