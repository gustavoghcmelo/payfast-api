<?php

namespace App\Dto\Core;

class MethodResponse
{
    public function __construct(
        protected array|null $error,
        protected array|null $data,
    ) {}

    public function toArray(): array
    {
        return [
            'error' => $this->error,
            'data' => $this->data,
        ];
    }
}
