<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class RegionFilter extends AbstractFilter
{
    protected function setUp(): void
    {
        if (is_array($this->state)) {
            $this->state = $this->state['search'];
        }
    }

    public function apply(Builder $query): Builder
    {
        return $query->where('region', $this->state);
    }
}
