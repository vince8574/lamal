<?php

namespace App\Livewire;

use App\Actions\SaveCardAction;
use App\Facades\AnonymousUser;
use App\Livewire\Traits\HasSearchFilter;
use App\Livewire\Traits\LoadProfileFilter;
use App\Models\Profile;
use App\ViewModels\SearchViewModel;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;


class SearchResult extends Component
{
    use HasSearchFilter;
    use WithPagination;
    use LoadProfileFilter;

    protected $listeners = ['profileChanged', 'searchUpdate' => 'profileChanged'];

    #[Url()]
    public int $profile_id;
    public function loadProfileFilter()
    {
        $profile = Profile::find($this->profile_id);
        if ($profile) {

            $this->filter = $profile->filter;
        }
    }
    public function profileChanged($profile_id)
    {
        $this->profile_id = $profile_id;
        $this->loadProfileFilter();
        $this->resetPage();
    }

    public function mount()
    {
        $this->loadProfileFilter();
    }

    public function selectPrime($primeId)
    {
        SaveCardAction::make()->execute($primeId, $this->profile_id);
        $this->dispatch('cardUpdated');

        return redirect()->back();
    }

    public function render()
    {
        if (! $this->profile_id) {
            return view('livewire.search-result');
        }
        $filter = $this->getFilter();

        $searchVm = SearchViewModel::make($this->profile_id, $filter);
        $currentProfile = Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->where('id', $this->profile_id)->first();

        return view('livewire.search-result', [
            ...$searchVm->all(),
            'cards' => $currentProfile?->cards,

        ]);
    }
}
