<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct(int $user_id)
    {
        parent::__construct("Usuário com idenficador: $user_id não foi encontrado", 400);
    }
}
