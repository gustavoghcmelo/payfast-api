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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('transaction_type_id')->references('id')->on('transaction_types');
            $table->unsignedBigInteger('gateway_id')->references('id')->on('gateways');
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_transaction_status')->default('PAYFAST_WAITING');
            $table->string('gateway_transaction_error')->nullable();
            $table->json('payload')->nullable();
            $table->decimal('amount');
            $table->string('currency')->default('BRL');
            $table->string('status')->default('PROCESSING');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
