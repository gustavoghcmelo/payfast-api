<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class InvalidTransactionTypeException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = "";

    public function __construct(
        protected string $transaction_type,
        protected string $gateway
    ) {
        $this->message = "O tipo de transação: $transaction_type não é suportado pelo $this->gateway";
        parent::__construct($this->message, $this->code);
    }

    public function render(Request $request): JsonResponse
    {
        Log::channel('transaction')->error($this->message, $request->all());
        return ApiResponse::error($this->message, [], $this->code);
    }
}
