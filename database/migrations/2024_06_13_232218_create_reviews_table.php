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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nickname');
            $table->string('location');
            $table->string('email');
            $table->enum('bottom_line', ['recommend', 'not_recommend', 'highly_recommend']);
            $table->string('image')
                ->nullable()
                ->default(null);
            $table->string('video')
                ->nullable()
                ->default(null);
            $table->integer('rating')
                ->min(0)
                ->max(5);
            $table->longText('review')
                ->nullable()
                ->default(null);


            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
