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
        Schema::create('primes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurer_id');
            $table->string('canton');
            $table->integer('year');
            $table->string('region_code');
            $table->foreignId('age_range_id');
            $table->boolean('accident');
            $table->string('tarif');
            $table->string('franchise_class');
            $table->foreignId('fran,chise_id');
            $table->decimal('cost',8,2);
            $table->string('tarif_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primes');
    }
};
