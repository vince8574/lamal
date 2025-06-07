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
        Schema::create('medianes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canton_id')->nullable()->constrained();
            $table->foreignId('age_range_id')->nullable()->constrained();
            $table->foreignId('franchise_id')->nullable()->constrained();
            $table->foreignId('tariftype_id')->nullable()->constrained();
            $table->boolean('accident')->nullable();
            $table->integer('count')->default(0);
            $table->decimal('median_value', 10, 2);
            $table->string('type', 50); // 'global', 'by_canton', 'by_filters'   
            $table->year('year');        
            $table->timestamps();

            $table->index(['type', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medianes');
    }
};
