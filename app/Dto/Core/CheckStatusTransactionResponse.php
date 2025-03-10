<?php

namespace App\Dto\Core;

use App\Exceptions\InvalidArgumentsCheckStatusTransactionResponseException;

class CheckStatusTransactionResponse
{
    /**
     * @param string|null $error
     * @param array<mixed>|null $data
     * @throws InvalidArgumentsCheckStatusTransactionResponseException
     */
    public function __construct(
        protected string|null $error,
        protected array|null $data,
    ) {
        if ($error === null && $data === null) {
            throw new InvalidArgumentsCheckStatusTransactionResponseException();
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
        ];
    }
}
