<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\CanHandleProfile;
use App\Repositories\PrimesRepository;

class ApiController extends Controller
{
    use CanHandleProfile;

    private $primesRepository;

    public function __construct(PrimesRepository $primesRepository)
    {
        $this->primesRepository = $primesRepository;
    }
    public function index(Request $request)
    {
        $results = $this->primesRepository->primesQuery($request);

        return $results;
    }
}
