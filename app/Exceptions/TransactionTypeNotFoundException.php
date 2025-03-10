<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TransactionTypeNotFoundException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_NOT_FOUND;

    /**
     * @var string
     */
    protected $message = "";

    public function __construct(protected int $transaction_type_id)
    {
        $this->message = "Tipo de transação não suportada. Identificador: $transaction_type_id";
        parent::__construct($this->message, $this->code);
    }

    public function render(Request $request): JsonResponse
    {
        Log::channel('transaction')->error($this->message, $request->all());
        return ApiResponse::error($this->message, [], $this->code);
    }
}
