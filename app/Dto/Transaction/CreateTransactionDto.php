<?php

namespace App\Dto\Transaction;

use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
final class CreateTransactionDto extends DataTransferObject
{
    public int $user_id;
    public ?string $payload;
    public string $amount;
    public string $currency;
    public ?string $status;
    public ?string $description;
}
