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

class SearchForm extends Component
{
    #[Url()]
    public int $profile_id;



    #[Url()]
    public array $filter = [];


    public function mount()
    {
        //  dump(request()->all());
        //   $this->filter = SearchFilter::fromRequest(request());

    }



    public function updated($key, $value)
    {

        //dump($key, $value);
        $this->dispatch('searchUpdate', value: $this->filter, profile_id: $this->profile_id);
    }

    public function selectProfile($profile_id)
    {

        $this->profile_id = $profile_id;

        $this->dispatch('searchUpdate', value: $this->filter, profile_id: $this->profile_id);
    }

    public function deleteProfile($profile_id)
    {
        try {


            DeleteProfileAction::make()->execute($profile_id);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function render()
    {
        $filter = SearchFilter::from(
            $this->filter,

        );

        //dump($filter, $this->filter);
        $franchiseVm = FranchiseViewModel::make($filter->age);
        $filtersvaluesvm = FiltersValuesViewModel::make();
        return view('livewire.search-form', [
            ...$filtersvaluesvm->all(),
            ...$franchiseVm->all(),
            'profiles' => Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->get()
        ]);
    }
}
