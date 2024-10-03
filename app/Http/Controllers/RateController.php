<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    public function index(Request $request)
    {

        $request->validate([
            'canton' => 'required|string',
            'age' => 'required|string',
            'franchise' => 'required|string',
        ]);

        /* $primes = DB::table('Prime')
            ->where('canton', $request->canton)
            ->where('age', $request->age)
            ->where('franchise', $request->franchise);
        dd($primes);
        return $primes;*/
    }
}
