<?php

use Illuminate\Testing\TestResponse;
use Illuminate\Http\JsonResponse;

/**
 * @param TestResponse<JsonResponse> $response
 * @param int $status
 * @param array<mixed> $dataStructure
 * @return void
 */
function assertApiResponseSuccess(TestResponse $response, int $status = 200, array $dataStructure = []): void
{
    $response->assertStatus($status)
        ->assertJsonStructure([
            'status',
            'data' => $dataStructure,
            'message',
        ]);
}

/**
 * @param TestResponse<JsonResponse> $response
 * @param int $code
 * @param array<mixed> $errorsStructure
 * @return void
 */
function assertApiResponseError(TestResponse $response, int $code = 400, array $errorsStructure = []): void
{
    $response->assertStatus($code)
        ->assertJsonStructure([
            'status',
            'message',
            'code',
            'errors' => $errorsStructure,
        ])
        ->assertJson([
            'status' => 'error',
            'code' => $code,
        ]);
}

function removeLineByPassKey(string $arquivo, string $palavra): void {
    $lines = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $file = fopen($arquivo, 'w');

    foreach ($lines as $linha) {
        if (strpos($linha, $palavra) === false) {
            fwrite($file, $linha . PHP_EOL);
        }
    }

    fclose($file);
}
