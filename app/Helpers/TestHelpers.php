<?php

function assertApiResponseSuccess($response, $status = 200, array $dataStructure = [])
{
    $response->assertStatus($status)
        ->assertJsonStructure([
            'status',
            'data' => $dataStructure,
            'message',
        ]);
}

function assertApiResponseError($response, int $code = 400, array $errorsStructure = [])
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

function removeLineByPassKey($arquivo, $palavra): void {
    $lines = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $file = fopen($arquivo, 'w');

    foreach ($lines as $linha) {
        if (strpos($linha, $palavra) === false) {
            fwrite($file, $linha . PHP_EOL);
        }
    }

    fclose($file);
}
