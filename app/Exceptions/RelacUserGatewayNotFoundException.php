<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RelacUserGatewayNotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    protected $message = "";
    public function __construct(protected int $gateway_id) {
        $this->message = "Gateway com identificador: $gateway_id não foi encontrado para este usuário.";
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
