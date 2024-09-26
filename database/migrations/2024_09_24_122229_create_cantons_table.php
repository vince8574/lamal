<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('primes', function (Blueprint $table) {
            $table->foreignId('canton_id')->after('canton'); //Rajoute un champs
        });
        Schema::create('cantons', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('primes', function (Blueprint $table) {
            $table->dropColumn('canton_id'); //enlève la colonne canton_id
        });
        Schema::dropIfExists('cantons');
    }
};
