<?php

namespace App\DTO;

use Illuminate\Http\Request;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class SearchFilterForm extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?string $canton,
        public ?string $region_code,
        public ?string $age,
        public ?string $franchise,
        public ?string $tariftype,
        public bool $accident,
        public ?string $city,
    ) {}

    public static function fromRequest(Request $request)
    {

        return self::from($request->all());
    }
}
