<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Prime;
use App\Models\Profile;
use App\Models\Card;
use App\Models\TarifType;
use App\Models\Franchise;
use App\Models\Region;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
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
            $tarifType = TarifType::where('age_id', $age_id)->first();

            if (!$tarifType) {
                return response()->json(['message' => 'Type de tarif non trouvé'], 404);
            }

            return response()->json($tarifType);
        }

        // GET /tarif_type - Récupérer tous les types de tarifs
        $tarifTypes = TarifType::all();
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
        $franchises = Franchise::where('age_id', $age_id)->get();
        return response()->json($franchises);
    }

    public function selection(Request $request, $profile_id = null, $prime_card_id = null)
    {
        if ($request->isMethod('get')) {
            // GET /selection - Récupérer toutes les sélections
            $selections = Card::with(['profile', 'prime'])->get();
            return response()->json($selections);
        }

        if ($request->isMethod('post') && $profile_id && $prime_card_id) {
            // POST /selection/{profile_id}/{prime_card_id} - Ajouter une sélection
            $selection = Card::create([
                'profile_id' => $profile_id,
                'prime_card_id' => $prime_card_id,
            ]);

            return response()->json($selection, 201);
        }

        if ($request->isMethod('delete') && $profile_id && $prime_card_id) {
            // DELETE /selection/{profile_id}/{prime_card_id} - Supprimer une sélection
            $selection = Card::where('profile_id', $profile_id)
                ->where('prime_card_id', $prime_card_id)
                ->first();

            if (!$selection) {
                return response()->json(['message' => 'Sélection non trouvée'], 404);
            }

            $selection->delete();
            return response()->json(['message' => 'Sélection supprimée avec succès']);
        }

        return response()->json(['message' => 'Méthode non autorisée'], 405);
    }

    public function regions(Request $request)
    {
        return $this->index($request);
    }

    public function profile(Request $request, $uid)
    {
        if ($request->isMethod('post')) {
            // POST /profile/{uid} - Créer un profil
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'age' => 'required|integer|min:0|max:120',
                'canton' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'franchise_preference' => 'nullable|string',
            ]);

            $validatedData['uid'] = $uid;
            $profile = Profile::create($validatedData);

            return response()->json($profile, 201);
        }

        if ($request->isMethod('get')) {
            // GET /profile/{uid} - Récupérer un profil
            $profile = Profile::where('uid', $uid)->first();

            if (!$profile) {
                return response()->json(['message' => 'Profil non trouvé'], 404);
            }

            return response()->json($profile);
        }

        if ($request->isMethod('put')) {
            // PUT /profile/{uid} - Mettre à jour un profil
            $profile = Profile::where('uid', $uid)->first();

            if (!$profile) {
                return response()->json(['message' => 'Profil non trouvé'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'age' => 'sometimes|integer|min:0|max:120',
                'canton' => 'sometimes|string|max:255',
                'region' => 'sometimes|string|max:255',
                'franchise_preference' => 'nullable|string',
            ]);

            $profile->update($validatedData);

            return response()->json($profile);
        }

        if ($request->isMethod('delete')) {
            // DELETE /profile/{uid} - Supprimer un profil
            $profile = Profile::where('uid', $uid)->first();

            if (!$profile) {
                return response()->json(['message' => 'Profil non trouvé'], 404);
            }

            $profile->delete();

            return response()->json(['message' => 'Profil supprimé avec succès']);
        }

        return response()->json(['message' => 'Méthode non autorisée'], 405);
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
