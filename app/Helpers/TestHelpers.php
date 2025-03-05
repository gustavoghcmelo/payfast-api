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
