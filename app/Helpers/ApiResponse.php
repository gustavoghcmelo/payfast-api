<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Retorna uma resposta de sucesso.
     *
     * @param mixed $data
     * @param null|string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function success(
        array|null $data = null,
        null|string $message = 'Requisição finalizada com sucesso.',
        int $statusCode = 200,
    ): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Retorna uma resposta de erro.
     *
     * @param string $message
     * @param array $errors
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function error(
        string $message = 'Não foi possível executar sua requisição. Verifique os detalhes do erro.',
        array $errors = [],
        int $statusCode = 400
    ): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'code' => $statusCode,
            'errors' => $errors,
        ], $statusCode);
    }
}
