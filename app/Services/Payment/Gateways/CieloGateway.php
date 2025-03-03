<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Str;

class CieloGateway implements PaymentGatewayInterface
{
    public function charge(array $data): array
    {
        return ['status' => 'success', 'transaction_id' => 'cielo_' . Str::uuid()->toString()];
    }

    public function refund(string $transactionId): array
    {
        return ['status' => 'refunded'];
    }
}
