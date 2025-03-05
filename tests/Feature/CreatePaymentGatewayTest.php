<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

test('should create a new payment gateway class and add line into config file', function () {

    $gatewayName = 'GatewayTesteUm';
    $filePath = app_path("Services/Payment/Gateways/{$gatewayName}Gateway.php");

    $this->artisan("make:gateway $gatewayName")
        ->expectsOutput("Classe do gateway criada em: $filePath")
        ->expectsOutput("Gateway '$gatewayName' adicionado ao arquivo de configuração.")
        ->assertExitCode(0);
});

test('should show a warning message when gateway already exists', function () {

    $gatewayName = 'GatewayTesteUm';

    $this->artisan("make:gateway $gatewayName")
        ->expectsOutput("A classe do gateway '$gatewayName' já existe!")
        ->expectsOutput("O gateway '$gatewayName' já existe no arquivo de configuração.")
        ->assertExitCode(0);
});

test('after command execution should be exist Gateway Class on Services/Gateways', function () {

    $gatewayName = 'GatewayTesteUm';

    $filePath = app_path("Services/Payment/Gateways/{$gatewayName}Gateway.php");
    expect(File::exists($filePath))->toBeTrue();
});

test('after command execution should be contain Gateway data on gateway.php config file', function () {

    $gatewayName = 'GatewayTesteUm';
    $gatewaySlug = Str::kebab($gatewayName);

    $gateways = config('gateway.gateways');
    expect(array_keys($gateways))->toContain($gatewaySlug);

    // Removendo configuração do gateway teste um
    $config_file_path = config_path('gateway.php');
    removeLineByPassKey($config_file_path, $gatewaySlug);

    // Removendo class do gateway teste um
    $filePath = app_path("Services/Payment/Gateways/{$gatewayName}Gateway.php");
    File::delete($filePath);
});
