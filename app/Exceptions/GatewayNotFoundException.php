<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class GatewayNotFoundException extends Exception
{
    public function __construct(string $gateway)
    {
        parent::__construct("Gateway ID: $gateway não foi encontrado.", Response::HTTP_NOT_FOUND);
    }
}
