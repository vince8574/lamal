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
        public ?string $canton,
        public ?string $age,
        public ?string $franchise,
        public ?string $tariftype,
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
}
