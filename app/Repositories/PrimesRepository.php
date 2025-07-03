<?php

namespace App\Repositories;

use App\Contracts\PrimesRepositoryContract;
use App\Filters\AgeRangeFilter;
use App\Filters\CantonFilter;
use App\Filters\RegionFilter;
use App\Models\Card;
use App\Models\Franchise;
use App\Models\Prime;
use App\Models\Tariftype;
use Illuminate\Http\Request;
use App\DTO\Filter;
use App\Models\AgeRange;
use Illuminate\Database\Eloquent\Collection;

class PrimesRepository implements PrimesRepositoryContract
{
    public function primesQuery(array $filters): array
    {
        // Initialize query
        $query = Prime::query();

        // // Apply filters if they exist
        // if ($filters->has('filter')) {
        //     foreach ($request->get('filter') as $key => $value) {
        //         $filter = match ($key) {
        //             'canton' => CantonFilter::make($value),
        //             'region' => RegionFilter::make($value),
        //             'age_range' => AgeRangeFilter::make($value),
        //             default => null
        //         };

        //         if ($filter) {
        //             $query = $filter->apply($query);
        //         }
        //     }
        // }

        // // Execute query and return results
        // $results = $query->get();

        // return response()->json($results);
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
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

        return $query->get()->toArray();
    }

    public function primes(array $filters = [], $profile_id = null): Collection
    {
        //     if ($request->isMethod('post')) {
        //         return $this->primesQuery($request);
        //     }

        //     if ($profile_id) {
        //         // GET /primes/{profile_id} - Récupérer les primes pour un profil
        //         $primes = Prime::where('profile_id', $profile_id)->get();
        //         return response()->json($primes);
        //     }

        //     // GET /primes - Récupérer toutes les primes avec filtres
        //     return $this->primesQuery($request);
        // }
        $query = Prime::query();

        if ($profile_id) {
            $query->where('profile_id', $profile_id);
        }

        // Apply filters
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
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

        return $query->get();
    }

    public function age($age_id)
    {
        return AgeRange::where('id', $age_id)->first();
    }

    public function tarifType($age_id = null)
    {
        // if ($age_id) {
        //     // GET /age/{age_id} - Récupérer le type de tarif pour un âge spécifique
        //     $tarifType = Tariftype::where('age_id', $age_id)->first();

        //     if (!$tarifType) {
        //         return response()->json(['message' => 'Type de tarif non trouvé'], 404);
        //     }

        //     return response()->json($tarifType);
        // }

        // // GET /tarif_type - Récupérer tous les types de tarifs
        // $tarifTypes = Tariftype::all();
        // return response()->json($tarifTypes);
        if ($age_id) {
            return Tariftype::where('age_id', $age_id)->first();
        }

        return Tariftype::all();
    }

    public function franchises(): Collection
    {
        // // GET /franchises - Récupérer toutes les franchises
        // $franchises = Franchise::all();
        // return response()->json($franchises);

        return Franchise::all();
    }

    public function franchise($age_id): Collection
    {
        // // GET /franchises/{age_id} - Récupérer les franchises pour un âge spécifique
        // $franchises = Franchise::whereHas('primes', function ($query) use ($age_id) {
        //     $query->where('age_range_id', $age_id);
        // })->get();
        // return response()->json($franchises);

        return Franchise::whereHas('primes', function ($query) use ($age_id) {
            $query->where('age_range_id', $age_id);
        })->get();
    }

    // public function selection($profile_id = null, $prime_id = null): Collection
    // {
    //     if ($request->isMethod('get')) {
    //         // GET /selection - Récupérer toutes les sélections
    //         $selections = Card::with(['profile', 'prime'])->get();
    //         return response()->json($selections);
    //     }

    //     if ($request->isMethod('post') && $profile_id && $prime_id) {
    //         // POST /selection/{profile_id}/{prime_id} - Ajouter une sélection
    //         $selection = Card::create([
    //             'profile_id' => $profile_id,
    //             'prime_id' => $prime_id,
    //         ]);

    //         return response()->json($selection, 201);
    //     }

    //     if ($request->isMethod('delete') && $profile_id && $prime_id) {
    //         // DELETE /selection/{profile_id}/{prime_id} - Supprimer une sélection
    //         $selection = Card::where('profile_id', $profile_id)
    //             ->where('prime_id', $prime_id)
    //             ->first();

    //         if (!$selection) {
    //             return response()->json(['message' => 'Sélection non trouvée'], 404);
    //         }

    //         $selection->delete();
    //         return response()->json(['message' => 'Sélection supprimée avec succès'], 200);
    //     }

    //     return response()->json(['message' => 'Méthode non autorisée'], 405);
    // }

    public function createSelection($profile_id, $prime_id): Card
    {
        return Card::create([
            'profile_id' => $profile_id,
            'prime_id' => $prime_id,
        ]);
    }


    public function deleteSelection($profile_id, $prime_id): bool
    {
        $selection = Card::where('profile_id', $profile_id)
            ->where('prime_id', $prime_id)
            ->first();

        if (!$selection) {
            return false;
        }

        return $selection->delete();
    }


    public function findSelection($profile_id, $prime_id): ?Card
    {
        return Card::where('profile_id', $profile_id)
            ->where('prime_id', $prime_id)
            ->first();
    }

    public function regions(array $filters): array
    {
        return $this->primesQuery($filters);
    }
}
