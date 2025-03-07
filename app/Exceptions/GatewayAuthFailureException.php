<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GatewayAuthFailureException extends Exception
{
    protected $code = Response::HTTP_UNAUTHORIZED;

    public function __construct(
        protected string $transaction_id,
        protected string $error
    )
    {
        Transaction::update_transaction_error($transaction_id, $error);
        parent::__construct($error, $this->code);
    }

    public function render(Request $request): JsonResponse
    {
        Log::channel('transaction')->error($this->error, $request->all());

        if ($request->is('api/*')) {
            return ApiResponse::error($this->error, [], $this->code);
        }
    }
}
