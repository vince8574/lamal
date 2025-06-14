<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
