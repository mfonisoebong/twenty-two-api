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
        Schema::table('billing_information', function (Blueprint $table) {
            $table->boolean('is_default')
                ->default(false);
            $table->string('country');
            $table->string('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing_information', function (Blueprint $table) {
            $table->dropColumn('is_default');
            $table->dropColumn('country');
            $table->dropColumn('state');
        });
    }
};
