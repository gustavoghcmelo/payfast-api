<?php

namespace App\Providers;

use App\Exceptions\InvalidGatewayException;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Gateways\BradescoGateway;
use App\Services\Payment\Gateways\CieloGateway;
use App\Services\Payment\Gateways\InterGateway;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $gateways = config('gateway.gateways');

        foreach ($gateways as $gateway => $gatewayClass) {
            $this->app->bind(PaymentGatewayInterface::class, $gatewayClass);
            $this->app->bind("payment.gateway.$gateway", $gatewayClass);
        }

        $this->app->when(PaymentService::class)
            ->needs(PaymentGatewayInterface::class)
            ->give(function () {
                $request = $this->app->make(Request::class);

                $gateway = $request->input('gateway');

                $gatewayKey = "payment.gateway.$gateway";
                if (!$this->app->bound($gatewayKey)) {
                    throw new InvalidGatewayException($gateway);
                }

                return $this->app->make($gatewayKey);
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
