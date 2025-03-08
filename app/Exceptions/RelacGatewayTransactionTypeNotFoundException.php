<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RelacGatewayTransactionTypeNotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    protected $message = "";
    public function __construct(
        protected int $gateway_id,
        protected int $transaction_type_id
    ) {
        $this->message = "Transação com identificador: $this->transaction_type_id não está configurada para o gateway com identificador: $this->gateway_id";
        parent::__construct($this->message, $this->code);
    }

    public function render(Request $request): JsonResponse
    {
        Log::channel('admin')->error($this->message, $request->all());

        if ($request->is('api/*')) {
            return ApiResponse::error($this->message, [], $this->code);
        }
    }
}
