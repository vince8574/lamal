<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Prime;
use App\Http\Controllers\Controller;


class ApiController extends Controller
{
    // filtrer les clés

    //

    public function index(Request $request)
    {
        // Initialize query
        $query = Prime::query();

        // Apply filters if they exist
        if ($request->has('filter')) {
            foreach ($request->get('filter') as $key => $value) {
                $filter = match ($key) {
                    'canton' => CantonFilter::make($value),
                    'region' => RegionFilter::make($value),
                    'age_range' => AgeRangeFilter::make($value),
                    default => null
                };

                if ($filter) {
                    $query = $filter->apply($query);
                }
            }
        }

        // Execute query and return results
        $results = $query->get();

        return response()->json($results);
    }
}

abstract class Filter
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


class CantonFilter extends Filter
{



    protected function setUp(): void
    {
        if (is_array($this->state)) {
            $this->state = $this->state['search'];
        }
    }

    public function apply(Builder $query): Builder
    {
        return $query->where('canton', $this->state);
    }
}

class AgeRangeFilter extends Filter
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
$filters = [];

$query = Prime::query();

foreach ($request->get('filter') as $key => $value) {
    $filter = match ($key) {
        'canton' => CantonFilter::make($value),
        'region' => RegionFilter::make($value),
        'canton' => CantonFilter::make($value),
        //default => null
    };

    //if($filter){
    $query->where($filter->apply($query));
    //}
}
class RegionFilter extends Filter
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
