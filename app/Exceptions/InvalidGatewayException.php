<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InvalidGatewayException extends Exception
{
    public function __construct(string $gateway)
    {
        parent::__construct("Gateway não suportado: $gateway", Response::HTTP_BAD_REQUEST);
    }
}
