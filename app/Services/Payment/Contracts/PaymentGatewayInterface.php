<?php

namespace App\Services\Payment\Contracts;

interface PaymentGatewayInterface
{
    public function charge(array $data): array;
    public function refund(string $transactionId): array;
}
