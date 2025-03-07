<?php

namespace App\Dto\Core;

class CheckStatusTransactionResponse
{
    public function __construct(
        protected string|null $error,
        protected array|null $data,
    ) {}

    public function toArray(): array
    {
        return [
            $this->error,
            $this->data,
        ];
    }
}
