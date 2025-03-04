<?php

return [
    'gateways' => [
        'bradesco' => \App\Services\Payment\Gateways\BradescoGateway::class,
        'cielo' => \App\Services\Payment\Gateways\CieloGateway::class,
        'inter' => \App\Services\Payment\Gateways\InterGateway::class,
    ],
];
