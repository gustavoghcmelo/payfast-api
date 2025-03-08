<?php

use App\Http\Controllers\Api\v1\TransactionController;
use Illuminate\Support\Facades\Route;

use App\Http\Requests\Api\v1\Transaction\BoletoRequest;
use App\Http\Requests\Api\v1\Transaction\ConsultaPixRequest;
use App\Http\Requests\Api\v1\Transaction\PixImediatoRequest;
use App\Http\Requests\Api\v1\Transaction\PixVencimentoRequest;
use App\Http\Requests\Api\v1\Transaction\CheckoutDebitoRequest;
use App\Http\Requests\Api\v1\Transaction\ConsultaBoletoRequest;
use App\Http\Requests\Api\v1\Transaction\CheckoutCreditoRequest;

Route::prefix('transaction')->group(function () {

    Route::put('/pix-imediato', function (PixImediatoRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/pix-vencimento', function (PixVencimentoRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/boleto', function (BoletoRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/checkout-credito', function (CheckoutCreditoRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/checkout-debito', function (CheckoutDebitoRequest $request) {
        return app(TransactionController::class)->execute_transaction($request);
    });
    Route::put('/consulta-pix', function (ConsultaPixRequest $request) {
        return app(TransactionController::class)->check_transaction($request);
    });
    Route::put('/consulta-boleto', function (ConsultaBoletoRequest $request) {
        return app(TransactionController::class)->check_transaction($request);
    });
});
