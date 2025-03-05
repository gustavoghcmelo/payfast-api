<?php

namespace App\Exceptions;

use Exception;

class UpdateEmailDenyException extends Exception
{
    public function __construct()
    {
        parent::__construct("Alteração de email não permitida. Para maiores detalhes em contato com o suporte.", 400);
    }
}
