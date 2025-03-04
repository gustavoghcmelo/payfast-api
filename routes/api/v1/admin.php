<?php

use App\Http\Controllers\Api\v1\Admin\GatewayController;
use Illuminate\Support\Facades\Route;

Route::resource('gateway', GatewayController::class);
