<?php

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

        DB::statement('UPDATE primes SET region_code = REPLACE(region_code, "PR-REG CH", "")');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
