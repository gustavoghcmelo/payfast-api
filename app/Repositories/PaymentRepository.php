<?php

namespace App\Repositories;

use App\Models\Payment;
class PaymentRepository
{
    public static function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public static function updateStatus(string $transactionId, string $status): void
    {
        Payment::where('transaction_id', $transactionId)->update(['status' => $status]);
    }
}
