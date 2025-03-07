<?php

use App\Dto\Core\TransactionResponse;

test('should return a new array from TransactionResponse structure', function () {

    $response = new TransactionResponse(null, [], '4561', 'PAGO');
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual([null, [], '4561', 'PAGO']);

});

test('should accept a null error value', function () {

    $response = new TransactionResponse(null, [], '4561', 'PAGO');
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual([null, [], '4561', 'PAGO']);

});

test('should accept a null data value', function () {

    $response = new TransactionResponse('FALHA NA TRANSACAO', [], '4561', 'PAGO');
    $arrayResponse = $response->toArray();

    expect($arrayResponse)->toEqual(['FALHA NA TRANSACAO', [], '4561', 'PAGO']);

});
