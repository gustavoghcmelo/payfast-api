<?php

use App\Http\Controllers\Api\v1\PaymentController;
use Illuminate\Support\Facades\Route;

Route::put('/charge', [PaymentController::class, 'charge']);
