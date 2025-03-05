<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UserNotFoundException extends Exception
{
    public function __construct(int $user_id)
    {
        parent::__construct("Usuário com idenficador: $user_id não foi encontrado", Response::HTTP_NOT_FOUND);
    }
}
