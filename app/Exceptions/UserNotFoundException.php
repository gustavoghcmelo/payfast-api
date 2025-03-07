<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class UserNotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    protected $message = "";

    public function __construct(protected int $user_id)
    {
        $this->message = "Usuário com idenficador: $user_id não foi encontrado";
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
