<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Admin\UserController;
use App\Http\Controllers\Api\v1\Admin\GatewayController;
use App\Http\Controllers\Api\v1\Admin\TransactionTypeController;

Route::post('user/{user_id}/gateway', [UserController::class, 'add_gateway']);
Route::delete('user/{user_id}/gateway', [UserController::class, 'remove_gateway']);
Route::resource('user', UserController::class);

Route::post('gateway/{gateway_id}/transaction-type', [GatewayController::class, 'add_transaction_type']);
Route::delete('gateway/{gateway_id}/transaction-type', [GatewayController::class, 'remove_transaction_type']);
Route::resource('gateway', GatewayController::class);

Route::resource('transaction-type', TransactionTypeController::class);
