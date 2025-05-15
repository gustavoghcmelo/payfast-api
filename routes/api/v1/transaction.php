<?php

use App\Http\Controllers\Api\v1\TransactionController;
use App\Http\Requests\Api\v1\Transaction\CreateTransactionRequest;
use App\Http\Requests\Api\v1\Transaction\CheckTransactionRequest;
use Illuminate\Support\Facades\Route;

Route::prefix('transaction')->group(function () {

    Route::put('/pix-imediato', function (CreateTransactionRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/pix-vencimento', function (CreateTransactionRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/boleto', function (CreateTransactionRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/checkout-credito', function (CreateTransactionRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/checkout-debito', function (CreateTransactionRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/consulta-pix', function (CheckTransactionRequest $request) {
        return app(TransactionController::class)->check_transaction($request);
    });
    Route::put('/consulta-boleto', function (CheckTransactionRequest $request) {
        return app(TransactionController::class)->check_transaction($request);
    });
});
