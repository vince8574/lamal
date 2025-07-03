<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegionsRequest;
use App\Repositories\PrimesRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $primesRepository;

    public function __construct(PrimesRepository $primesRepository)
    {
        $this->primesRepository = $primesRepository;
    }

    public function age($ageId)
    {
        $age = $this->primesRepository->age($ageId);
        return response()->json($age);
    }

    public function tarifType()
    {
        $tarifTypes = $this->primesRepository->tarifType();
        return response()->json($tarifTypes);
    }

    public function franchises($ageId = null)
    {
        if ($ageId) {
            $franchises = $this->primesRepository->franchise($ageId);
        } else {
            $franchises = $this->primesRepository->franchises();
        }
        return response()->json($franchises);
    }

    public function getPrimes(Request $request, $profileId)
    {
        $filters = $this->extractFilters($request);
        $primes = $this->primesRepository->primes($filters, $profileId);
        return response()->json($primes);
    }

    // public function storePrimes(Request $request)
    // {
    //     $validated = $request->validate([
    //         'profile_id' => 'required|integer',
    //         'data' => 'required|string',
    //     ]);

    //     
    //     $prime = $this->primesRepository->storePrime($validated);
    //     return response()->json($prime, 201);
    // }

    // public function getSelection()
    // {
    //     $selections = $this->primesRepository->getAllSelections(); // À ajouter
    //     return response()->json($selections);
    // }

    public function createSelection($profileId, $primeId)
    {
        try {
            $selection = $this->primesRepository->createSelection($profileId, $primeId);
            return response()->json($selection, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create selection'], 422);
        }
    }

    public function deleteSelection($profileId, $primeId)
    {
        $deleted = $this->primesRepository->deleteSelection($profileId, $primeId);

        if (!$deleted) {
            return response()->json(['message' => 'Selection not found'], 404);
        }

        return response()->json(['message' => 'Selection deleted successfully']);
    }

    public function storeRegions(StoreRegionsRequest $request)
    {
        $validated = $request->validated();

        $filters = ['region' => $validated['region_data']];
        $results = $this->primesRepository->regions($filters);

        return response()->json($results);
    }

    private function extractFilters(Request $request): array
    {
        return array_filter($request->only(['canton', 'region', 'age_range']));
    }
}
