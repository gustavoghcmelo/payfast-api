<?php

use App\Dto\Core\MethodResponse;

test('should return a new array from MethodResponse structure', function () {

    $response = new MethodResponse([], []);
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual(["error" => [], "data" => []]);

});

test('should accept a null error value', function () {

    $response = new MethodResponse(null, ['message' => 'test data']);
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual(["error" => null, "data" => ['message' => 'test data']]);

});

test('should accept a null data value', function () {

    $response = new MethodResponse(['message' => 'teste error'], null);
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual(["error" => ['message' => 'teste error'], "data" => null]);

});
