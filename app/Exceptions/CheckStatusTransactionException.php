<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CheckStatusTransactionException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @var string
     */
    protected $message = "";

    public function __construct(
        protected string $transaction_id,
        protected string $error
    )
    {
        $this->message = "Falha na consulta da transação: $transaction_id com erro: $error";
        parent::__construct($this->message, $this->code);
    }

    public function render(Request $request): JsonResponse
    {
        Log::channel('transaction')->error($this->message, $request->all());
        return ApiResponse::error($this->message, [], $this->code);
    }
}
