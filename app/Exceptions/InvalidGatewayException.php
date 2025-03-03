<?php

namespace App\Exceptions;

use Exception;

class InvalidGatewayException extends Exception
{
    public function __construct(string $gateway)
    {
        parent::__construct("Gateway não suportado: $gateway", 400);
    }
}
