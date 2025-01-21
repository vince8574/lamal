<?php

namespace App\DTO;

use App\Models\Franchise;
use App\ViewModels\FranchiseViewModel;
use Illuminate\Http\Request;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class SearchFilter extends Data implements Wireable
{

    use WireableData;
    public function __construct(
        public ?int $canton,
        public ?int $age,
        public ?int $franchise,
        public ?int $tariftype,
        public bool $accident = false,
    ) {


        if (FranchiseViewModel::make($this->age)->getFranchises()->where('id', $this->franchise)->count() == 0) {
            $this->franchise = null;
        }
    }


    public static function fromRequest(Request $request)
    {

        return self::from($request->all());
    }

    public static function fromForm(SearchFilterForm $form)
    {
        return self::from([
            'canton' => filled($form->canton) ? $form->canton : null,
            'age' => filled($form->age) ? $form->age : null,
            'franchise' => filled($form->franchise) ? $form->franchise : null,
            'tariftype' => filled($form->tariftype) ? $form->tariftype : null,
            'accident' => filled($form->accident) ? $form->accident : false,
        ]);
    }
}
