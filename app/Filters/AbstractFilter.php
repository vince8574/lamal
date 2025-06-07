<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    protected mixed $state;

    public function __construct(mixed $state)
    {
        $this->state = $state;
        $this->setUp();
    }

    public static function make(mixed $state): static
    {
        return new static($state);
    }

    abstract protected function setUp(): void;
    abstract public function apply(Builder $query): Builder;
}
