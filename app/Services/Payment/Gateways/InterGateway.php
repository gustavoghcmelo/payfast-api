<?php

namespace App\Services\Payment\Gateways;

use App\Dto\Core\MethodResponse;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Str;

class InterGateway implements PaymentGatewayInterface
{
    public function charge(array $data): MethodResponse
    {
        return new MethodResponse(
            null,
            ['transactionId' => 'Inter_' . Str::uuid()->toString()]
        );
    }

    public function refund(string $transactionId): MethodResponse
    {
        return new MethodResponse(
            null,
            ['transactionId' => $transactionId]
        );
    }
}
