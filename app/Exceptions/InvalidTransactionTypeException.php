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
    protected $code = Response::HTTP_BAD_REQUEST;

    protected $message = "";

    public function __construct(protected string $error) {
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
