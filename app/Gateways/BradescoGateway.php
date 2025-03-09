<?php

namespace App\Gateways;

use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Contracts\GatewayInterface;
use App\Dto\Core\GatewayAuthResponse;
use App\Dto\Core\TransactionResponse;
use App\Dto\Core\CheckStatusTransactionResponse;
use App\Exceptions\InvalidArgumentsTransactionResponseException;
use App\Exceptions\InvalidArgumentsCheckStatusTransactionResponseException;

class BradescoGateway implements GatewayInterface
{
    public function authenticate(): GatewayAuthResponse
    {
        return new GatewayAuthResponse(
            null,
            '3K4JH23KJH23K4HJ4HH432'
        );
    }

    /**
     * @param string $access_token
     * @param array $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     */
    public function pix_imediato(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

    /**
     * @param string $access_token
     * @param array $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     */
    public function pix_vencimento(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

    /**
     * @param string $access_token
     * @param Transaction $transaction
     * @return CheckStatusTransactionResponse
     * @throws InvalidArgumentsCheckStatusTransactionResponseException
     */
    public function consulta_pix(string $access_token, Transaction $transaction): CheckStatusTransactionResponse
    {
        return new CheckStatusTransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
        );
    }

    /**
     * @param string $access_token
     * @param array $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     */
    public function boleto(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

    /**
     * @param string $access_token
     * @param Transaction $transaction
     * @return CheckStatusTransactionResponse
     * @throws InvalidArgumentsCheckStatusTransactionResponseException
     */
    public function consulta_boleto(string $access_token, Transaction $transaction): CheckStatusTransactionResponse
    {
        return new CheckStatusTransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()]
        );
    }

    /**
     * @param string $access_token
     * @param array $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     */
    public function checkout_credito(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

    /**
     * @param string $access_token
     * @param array $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     */
    public function checkout_debito(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }
}
