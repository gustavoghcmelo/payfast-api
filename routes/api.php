<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::post('/auth/token', [AuthenticatedSessionController::class, 'authenticate_api']);

Route::middleware('auth:sanctum')->group(function () {

    require __DIR__ . "/api/v1/admin.php";
    require __DIR__ . "/api/v1/transaction.php";
});
