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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'paid', 'in_transit', 'delivered', 'cancelled'])
                ->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('coupon_id')
                ->nullable()
                ->default(null);
            $table->unsignedFloat('shipping_fee')
                ->default(0);
            $table->string('trx_id')
                ->unique();
            $table->json('billing_information');
            $table->unsignedDecimal('amount_paid');
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
        Schema::dropIfExists('invoices');
    }
};
