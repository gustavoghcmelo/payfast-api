<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GatewayNotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    protected $message = "";

    public function __construct(protected string $gateway)
    {
        $this->message = "Gateway ID: $gateway não foi encontrado.";
        parent::__construct($this->message, $this->code);
    }

    public function render(Request $request): JsonResponse
    {
        Log::channel('transaction')->error($this->message, $request->all());

        if ($request->is('api/*')) {
            return ApiResponse::error($this->message, [], $this->code);
        }
    }
}
