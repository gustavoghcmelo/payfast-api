<?php

namespace App\Dto\Core;

class GatewayAuthResponse
{
    public function __construct(
        protected string|null $error,
        protected string|null $access_token,
    ) {}

    public function toArray(): array
    {
        return [
            $this->error,
            $this->access_token,
        ];
    }
}
