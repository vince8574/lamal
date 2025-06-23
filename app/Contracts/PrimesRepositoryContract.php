<?php

namespace App\Contracts;

use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface PrimesRepositoryContract
{
    public function primesQuery(array $filters): array;

    public function primes(array $filters = [], $profile_id = null): Collection;

    public function tarifType($age_id = null);

    public function franchises(): Collection;

    public function franchise($age_id): Collection;

    public function createSelection($profile_id, $prime_id): Card;

    public function deleteSelection($profile_id, $prime_id): bool;

    public function findSelection($profile_id, $prime_id): ?Card;

    public function regions(array $filters): array;
}
