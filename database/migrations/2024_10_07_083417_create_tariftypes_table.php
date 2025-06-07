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
            $table->foreignId('tariftype_id')->after('tarif'); //Rajoute un champs
        });

        Schema::create('tariftypes', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('code');
            $table->string('label');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariftypes');
    }
};
