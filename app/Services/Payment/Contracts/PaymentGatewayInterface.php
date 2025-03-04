<?php

namespace App\Services\Payment\Contracts;

use App\Dto\Core\MethodResponse;

interface PaymentGatewayInterface
{
    public function charge(array $data): MethodResponse;
    public function refund(string $transactionId): MethodResponse;
}
