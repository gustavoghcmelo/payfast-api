<?php

use App\Dto\Core\TransactionResponse;

test('should return a new array from TransactionResponse structure', function () {

    $response = new TransactionResponse([], []);
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual(["error" => [], "data" => []]);

});

test('should accept a null error value', function () {

    $response = new TransactionResponse(null, ['message' => 'test data']);
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual(["error" => null, "data" => ['message' => 'test data']]);

});

test('should accept a null data value', function () {

    $response = new TransactionResponse(['message' => 'teste error'], null);
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual(["error" => ['message' => 'teste error'], "data" => null]);

});
