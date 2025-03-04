<?php

use App\Models\Canton;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //

        $cantons = DB::select('select distinct canton from primes');
        collect($cantons)->each(function ($canton) {
            $canton = $canton->canton;
            $c = Canton::firstOrCreate(['key' => $canton], ['name' => $canton, 'key' => $canton]);

            DB::statement('update primes set canton_id=? where canton=?', [$c->id, $canton]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
