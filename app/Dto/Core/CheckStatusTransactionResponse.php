<?php

namespace App\Dto\Core;

use App\Exceptions\InvalidArgumentsCheckStatusTransactionResponseException;

class CheckStatusTransactionResponse
{
    public function __construct(
        protected string|null $error,
        protected array|null $data,
    ) {
        if ($error === null && $data === null) {
            throw new InvalidArgumentsCheckStatusTransactionResponseException();
        }
    }

    public function toArray(): array
    {
        return [
            $this->error,
            $this->data,
        ];
    }
}
