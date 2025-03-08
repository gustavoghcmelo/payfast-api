<?php

namespace App\Providers;

use App\Contracts\GatewayInterface;
use App\Exceptions\InvalidGatewayException;
use App\Exceptions\InvalidTransactionTypeException;
use App\Models\Gateway;
use App\Models\TransactionType;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class GatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $gateways = config('gateway.gateways');

        foreach ($gateways as $gateway => $gatewayClass) {
            $this->app->bind(GatewayInterface::class, $gatewayClass);
            $this->app->bind("payment.gateway.$gateway", $gatewayClass);
        }

        $this->app->when(TransactionService::class)
            ->needs(GatewayInterface::class)
            ->give(function () {
                $request = $this->app->make(Request::class);
                $gateway = $request->input('gateway', 'unknown');

                $gatewayKey = "payment.gateway.$gateway";
                if (!$this->app->bound($gatewayKey)) {
                    throw new InvalidGatewayException($gateway);
                }

                $this->app->singleton("active_gateway", function () use ($gateway) {
                    $active_gateway = Gateway::where('slug', $gateway)->first();
                    if (!$gateway) {
                        throw new InvalidGatewayException($gateway);
                    }
                    return $active_gateway;
                });

                $this->app->singleton("active_transaction_type", function () use ($request) {
                    $transactionRequest = Str::afterLast($request->path(), '/');
                    $active_transaction_type = TransactionType::where('description', $transactionRequest)->first();
                    if (!$active_transaction_type) {
                        throw new InvalidTransactionTypeException($transactionRequest, app('active_gateway')->slug);
                    }
                    return $active_transaction_type;
                });

                return $this->app->make($gatewayKey);
            });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
