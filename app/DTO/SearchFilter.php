<?php

namespace App\DTO;

use App\Models\Franchise;
use App\ViewModels\FranchiseViewModel;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class SearchFilter extends Data
{

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
}
