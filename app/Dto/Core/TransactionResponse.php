<?php

namespace App\Dto\Core;

class TransactionResponse
{
    public function __construct(
        protected string|null $error,
        protected array|null $data,
        protected string|null $gateway_transaction_id,
        protected string|null $gateway_transaction_status,
    ) {}

    public function toArray(): array
    {
        return [
            $this->error,
            $this->data,
            $this->gateway_transaction_id,
            $this->gateway_transaction_status,
        ];
    }
}
