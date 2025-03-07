<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserGatewayPermissionException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;

    protected $message = "";

    public function __construct(
        protected string $user,
        protected string $gateway
    )
    {
        $this->message = "A conta $this->user não tem permissão para utilizar o gateway $this->gateway";
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
