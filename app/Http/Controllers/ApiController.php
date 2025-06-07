<?php

namespace App\Http\Controllers;

use App\Actions\CreateAnonymousUserAction;
use App\Actions\CreateProfileAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Prime;
use App\Models\Profile;
use App\Models\Card;
use App\Models\Tariftype;
use App\Models\Franchise;
use App\Models\Region;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CreateAnonymousUser;
use App\Http\Controllers\Concerns\CanHandleProfile;

use App\Filters\CantonFilter;
use App\Filters\RegionFilter;
use App\Filters\AgeRangeFilter;

class ApiController extends Controller
{
    use CanHandleProfile;
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

    public function primes(Request $request, $profile_id = null)
    {
        if ($request->isMethod('post')) {
            return $this->index($request);
        }

        if ($profile_id) {
            // GET /primes/{profile_id} - Récupérer les primes pour un profil
            $primes = Prime::where('profile_id', $profile_id)->get();
            return response()->json($primes);
        }

        // GET /primes - Récupérer toutes les primes avec filtres
        return $this->index($request);
    }

    public function tarifType(Request $request, $age_id = null)
    {
        if ($age_id) {
            // GET /age/{age_id} - Récupérer le type de tarif pour un âge spécifique
            $tarifType = Tariftype::where('age_id', $age_id)->first();

            if (!$tarifType) {
                return response()->json(['message' => 'Type de tarif non trouvé'], 404);
            }

            return response()->json($tarifType);
        }

        // GET /tarif_type - Récupérer tous les types de tarifs
        $tarifTypes = Tariftype::all();
        return response()->json($tarifTypes);
    }

    public function franchises(Request $request)
    {
        // GET /franchises - Récupérer toutes les franchises
        $franchises = Franchise::all();
        return response()->json($franchises);
    }

    public function franchise(Request $request, $age_id)
    {
        // GET /franchises/{age_id} - Récupérer les franchises pour un âge spécifique
        $franchises = Franchise::whereHas('primes', function ($query) use ($age_id) {
            $query->where('age_range_id', $age_id);
        })->get();
        return response()->json($franchises);
    }

    public function selection(Request $request, $profile_id = null, $prime_id = null)
    {
        if ($request->isMethod('get')) {
            // GET /selection - Récupérer toutes les sélections
            $selections = Card::with(['profile', 'prime'])->get();
            return response()->json($selections);
        }

        if ($request->isMethod('post') && $profile_id && $prime_id) {
            // POST /selection/{profile_id}/{prime_id} - Ajouter une sélection
            $selection = Card::create([
                'profile_id' => $profile_id,
                'prime_id' => $prime_id,
            ]);

            return response()->json($selection, 201);
        }

        if ($request->isMethod('delete') && $profile_id && $prime_id) {
            // DELETE /selection/{profile_id}/{prime_id} - Supprimer une sélection
            $selection = Card::where('profile_id', $profile_id)
                ->where('prime_id', $prime_id)
                ->first();

            if (!$selection) {
                return response()->json(['message' => 'Sélection non trouvée'], 404);
            }

            $selection->delete();
            return response()->json(['message' => 'Sélection supprimée avec succès'], 200);
        }

        return response()->json(['message' => 'Méthode non autorisée'], 405);
    }

    public function regions(Request $request)
    {
        return $this->index($request);
    }
}
