<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Admin\UserController;
use App\Http\Controllers\Api\v1\Admin\GatewayController;
use App\Http\Controllers\Api\v1\Admin\TransactionTypeController;


Route::resource('user', UserController::class);
Route::resource('gateway', GatewayController::class);
Route::resource('transaction-type', TransactionTypeController::class);
