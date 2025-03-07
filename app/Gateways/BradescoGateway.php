<?php

namespace App\Gateways;

use App\Contracts\GatewayInterface;
use App\Dto\Core\CheckStatusTransactionResponse;
use App\Dto\Core\GatewayAuthResponse;
use App\Dto\Core\TransactionResponse;
use App\Models\Transaction;
use Illuminate\Support\Str;
class BradescoGateway implements GatewayInterface
{
    public function authenticate(): GatewayAuthResponse
    {
        return new GatewayAuthResponse(
            null,
            '3K4JH23KJH23K4HJ4HH432'
        );
    }

    public function pix_imediato(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            'O BANCO FECHOU E FUDEU TUDO',
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

    public function pix_vencimento(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

    public function consulta_pix(string $access_token, Transaction $transaction): CheckStatusTransactionResponse
    {
        return new CheckStatusTransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
        );
    }

    public function boleto(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

    public function consulta_boleto(string $access_token, Transaction $transaction): CheckStatusTransactionResponse
    {
        return new CheckStatusTransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()]
        );
    }

    public function checkout_credito(string $access_token, array $data): TransactionResponse
    {
        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

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
