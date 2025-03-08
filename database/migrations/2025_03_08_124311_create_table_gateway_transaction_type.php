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
        Schema::create('gateway_transaction_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gateway_id')->references('id')->on('gateways');
            $table->unsignedBigInteger('transaction_type_id')->references('id')->on('transaction_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_transaction_type');
    }
};
