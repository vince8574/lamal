<?php

namespace App\Livewire;

use App\Actions\DeleteProfileAction;
use App\Actions\SaveCardAction;
use App\DTO\SearchFilter;
use App\Facades\AnonymousUser;
use App\Models\Card as ModelsCard;
use App\Models\Profile;
use App\ViewModels\FiltersValuesViewModel;
use App\ViewModels\FranchiseViewModel;
use App\ViewModels\SearchViewModel;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Http\Request;

class SearchResult extends Component
{

    protected $listeners = ['searchUpdate'];
    #[Url()]
    public ?int $profile_id = null;

    #[Url()]

    public array $filter = [];

    public function searchUpdate($value, $profile_id)
    {


        $this->filter = $value;
        $this->profile_id = $profile_id;
        Profile::where('id', $profile_id)->update([
            'filter' => json_encode($value),
        ]);
    }

    public function selectPrime($primeId)
    {



        SaveCardAction::make()->execute($primeId, $this->profile_id);

        return redirect()->back();
    }

    public function render()
    {
        if (!$this->profile_id) {
            return view('livewire.search-result');
        }
        $filter = SearchFilter::from($this->filter);

        $searchVm = SearchViewModel::make($this->profile_id, $filter);
        $currentProfile = Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->where('id', $this->profile_id)->first();

        return view('livewire.search-result', [
            ...$searchVm->all(),
            'cards' => $currentProfile->cards,
        ]);
    }
}
