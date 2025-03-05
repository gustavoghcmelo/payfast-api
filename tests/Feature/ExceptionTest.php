<?php

use App\Exceptions\GatewayNotFoundException;
use App\Exceptions\InvalidGatewayException;
use App\Exceptions\TransactionTypeNotFoundException;
use App\Exceptions\UserNotFoundException;

test('should throw a GatewayNotFoundException', function () {
    $this->expectException(GatewayNotFoundException::class);
    $this->expectExceptionMessage("Gateway ID: bradesco não foi encontrado.");
    $this->expectExceptionCode(404);

    throw new GatewayNotFoundException('bradesco');
});

test('should throw a InvalidGatewayException', function () {
    $this->expectException(InvalidGatewayException::class);
    $this->expectExceptionMessage("Gateway não suportado: cielo");
    $this->expectExceptionCode(400);

    throw new InvalidGatewayException('cielo');
});

test('should throw a TransactionTypeNotFoundException', function () {
    $this->expectException(TransactionTypeNotFoundException::class);
    $this->expectExceptionMessage("Tipo de transação não suportada. Identificador: 123");
    $this->expectExceptionCode(404);

    throw new TransactionTypeNotFoundException(123);
});

test('should throw a UserNotFoundException', function () {
    $this->expectException(UserNotFoundException::class);
    $this->expectExceptionMessage("Usuário com idenficador: 456 não foi encontrado");
    $this->expectExceptionCode(404);

    throw new UserNotFoundException(456);
});
