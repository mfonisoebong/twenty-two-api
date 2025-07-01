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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedDecimal('base_price', 20)->change();
            $table->unsignedDecimal('discounted_price', 20)
                ->nullable()
                ->default(null)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedDecimal('base_price')->change();
            $table->unsignedDecimal('discounted_price')
                ->nullable()
                ->default(null)
                ->change();
        });
    }
};
