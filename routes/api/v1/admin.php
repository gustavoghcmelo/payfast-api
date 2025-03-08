<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Admin\UserController;
use App\Http\Controllers\Api\v1\Admin\GatewayController;
use App\Http\Controllers\Api\v1\Admin\TransactionTypeController;

Route::post('user/gateway/{user_id}', [UserController::class, 'add_gateway']);
Route::delete('user/gateway/{user_id}', [UserController::class, 'remove_gateway']);
Route::resource('user', UserController::class);


Route::resource('gateway', GatewayController::class);
Route::resource('transaction-type', TransactionTypeController::class);
