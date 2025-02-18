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
        Schema::table('cantons', function (Blueprint $table) {
            $table->string('armoirie')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cantons', function (Blueprint $table) {
            $table->dropColumn('armoirie'); //enlève la colonne canton
        });
    }
};
