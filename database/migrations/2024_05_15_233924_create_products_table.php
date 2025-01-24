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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('featured_image');
            $table->string('additional_images')
                ->default('');
            $table->unsignedDecimal('base_price');
            $table->unsignedDecimal('discounted_price')
                ->nullable()
                ->default(null);
            $table->longText('description');
            $table->longText('additional_information');
            $table->json('colors');
            $table->string('colors_list');
            $table->string('sizes');
            $table->bigInteger('available_units');
            $table->unsignedBigInteger('category_id')
                ->nullable()
                ->default(null);

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
