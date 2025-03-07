<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    /**
     * Rotas Administrativas do sistema
     */
    require __DIR__ . "/api/v1/admin.php";

    /**
     * Rotas das transações financeiras
     */
    require __DIR__ . "/api/v1/transaction.php";
});
