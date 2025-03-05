<?php

namespace App\Exceptions;

use Exception;

class TransactionTypeNotFoundException extends Exception
{
    public function __construct(string $transaction_type_id)
    {
        parent::__construct("Tipo de transação não suportada. Identificador: $transaction_type_id", 400);
    }
}
