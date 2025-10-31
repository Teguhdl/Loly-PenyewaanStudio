<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('payment_type')->nullable(); // qris, bank_transfer, dll
            $table->string('status')->default('pending'); // pending, settlement, expired
            $table->json('response')->nullable(); // simpan respon Midtrans
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
