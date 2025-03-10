<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class InvalidArgumentsCheckStatusTransactionResponseException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    protected $message = "";

    public function __construct() {
        $this->message = "Ao menos :error ou :data devem está preenchidos";
        parent::__construct($this->message, $this->code);
    }

    public function render(Request $request): JsonResponse
    {
        Log::channel('transaction')->error($this->message, $request->all());
        return ApiResponse::error($this->message, [], $this->code);
    }
}
