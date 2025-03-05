<?php

namespace App\Services\Payment;

use App\Services\Payment\Contracts\PaymentGatewayInterface;

class PaymentService
{
    protected PaymentGatewayInterface $gateway;

    public function __construct(PaymentGatewayInterface $gateway) {
        $this->gateway = $gateway;
    }

    public function charge(array $data): array
    {
        return $this->gateway->charge($data)->toArray();
    }

    public function refund(string $transactionId): array
    {
        return $this->gateway->refund($transactionId)->toArray();
    }
}
