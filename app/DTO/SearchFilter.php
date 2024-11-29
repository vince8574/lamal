<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class SearchFilter extends Data
{

    public function __construct(
        public int $canton,
        public ?int $age,
        public ?int $franchise,
        public ?int $tariftype,
        public bool $accident = false,
    ) {}
}
