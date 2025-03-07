<?php

use App\Http\Controllers\Api\v1\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('transaction')->group(function () {

        Route::put('/boleto', [TransactionController::class, 'boleto']);
        Route::put('/pix-imediato', [TransactionController::class, 'pix_imediato']);
        Route::put('/pix-vencimento', [TransactionController::class, 'pix_vencimento']);
        Route::put('/checkout-debito', [TransactionController::class, 'checkout_debito']);
        Route::put('/consulta-boleto', [TransactionController::class, 'consulta_boleto']);
        Route::put('/checkout-credito', [TransactionController::class, 'checkout_credito']);
});
