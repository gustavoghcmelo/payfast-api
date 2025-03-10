<?php

namespace App\Dto\Core;

use App\Exceptions\InvalidArgumentsTransactionResponseException;

class TransactionResponse
{
    /**
     * @param string|null $error
     * @param array<mixed>|null $data
     * @param string|null $gateway_transaction_id
     * @param string|null $gateway_transaction_status
     * @throws InvalidArgumentsTransactionResponseException
     */
    public function __construct(
        protected string|null $error,
        protected array|null $data,
        protected string|null $gateway_transaction_id,
        protected string|null $gateway_transaction_status,
    ) {
        if ($error === null && $data === null) {
            throw new InvalidArgumentsTransactionResponseException();
        }
    }

    /**
     * @return array<mixed>
     */
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
