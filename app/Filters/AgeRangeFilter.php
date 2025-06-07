<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AgeRangeFilter extends AbstractFilter
{
    public $byId = false;

    protected function setUp(): void
    {
        if (is_numeric($this->state)) {
            $this->byId = true;
        }
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->byId, function (Builder $query) {
            return $query->where('id', $this->state);
        })
            ->when(!$this->byId, function (Builder $query) {
                return $query->where('label', 'like', '%' . $this->state . '%');
            });
    }
}
