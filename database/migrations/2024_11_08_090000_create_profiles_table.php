<?php

use App\Models\AgeRange;
use App\Models\AnonimousUser;
use App\Models\AnonymousUser;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(AnonymousUser::class)->constrained()->cascadeOnDelete();
            // $table->date('birthdate');
            $table->string('age_range_key')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
