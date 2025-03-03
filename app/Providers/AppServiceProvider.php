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
        $this->app->bind(PaymentGatewayInterface::class, BradescoGateway::class);
        $this->app->bind('payment.gateway.bradesco', BradescoGateway::class);

        $this->app->bind(PaymentGatewayInterface::class, CieloGateway::class);
        $this->app->bind('payment.gateway.cielo', CieloGateway::class);

        $this->app->bind(PaymentGatewayInterface::class, InterGateway::class);
        $this->app->bind('payment.gateway.inter', InterGateway::class);


        // Configura o binding dinâmico para o PaymentService
        $this->app->when(PaymentService::class)
            ->needs(PaymentGatewayInterface::class)
            ->give(function () {
                // Resolve o request atual
                $request = $this->app->make(Request::class);

                // Obtém o gateway do corpo da requisição
                $gateway = $request->input('gateway');

                // Verifica se o gateway é válido
                $gatewayKey = "payment.gateway.$gateway";
                if (!$this->app->bound($gatewayKey)) {
                    throw new InvalidGatewayException($gateway);
                }

                // Retorna a instância do gateway
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
