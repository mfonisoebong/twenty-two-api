<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hero_details', function (Blueprint $table) {
            $table->string('image_sm')
                ->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_details', function (Blueprint $table) {
            $table->dropColumn('image_sm');
        });
    }
};
