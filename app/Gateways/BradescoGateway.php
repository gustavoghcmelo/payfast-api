<?php

namespace App\Gateways;

use App\Dto\Bradesco\BoletoDTO;
use App\Dto\Bradesco\CheckoutCreditoDTO;
use App\Dto\Bradesco\CheckoutDebitoDTO;
use App\Dto\Bradesco\ConsultaBoletoDTO;
use App\Dto\Bradesco\ConsultaPixDTO;
use App\Dto\Bradesco\PixImediatoDTO;
use App\Dto\Bradesco\PixVencimentoDTO;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Contracts\GatewayInterface;
use App\Dto\Core\GatewayAuthResponse;
use App\Dto\Core\TransactionResponse;
use App\Dto\Core\CheckStatusTransactionResponse;
use App\Exceptions\InvalidArgumentsTransactionResponseException;
use App\Exceptions\InvalidArgumentsCheckStatusTransactionResponseException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

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
     * @param array<mixed> $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     * @throws UnknownProperties
     */
    public function pix_imediato(string $access_token, array $data): TransactionResponse
    {
        $dto = new PixImediatoDTO($data);

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
     * @throws UnknownProperties
     */
    public function pix_vencimento(string $access_token, array $data): TransactionResponse
    {
        $dto = new PixVencimentoDTO($data);

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
     * @throws UnknownProperties
     */
    public function consulta_pix(string $access_token, Transaction $transaction): CheckStatusTransactionResponse
    {
        $dto = new ConsultaPixDTO($transaction->toArray());

        return new CheckStatusTransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
        );
    }

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     * @throws UnknownProperties
     */
    public function boleto(string $access_token, array $data): TransactionResponse
    {
        $dto = new BoletoDTO($data);

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
     * @throws UnknownProperties
     */
    public function consulta_boleto(string $access_token, Transaction $transaction): CheckStatusTransactionResponse
    {
        $dto = new ConsultaBoletoDTO($transaction->toArray());

        return new CheckStatusTransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()]
        );
    }

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     * @throws UnknownProperties
     */
    public function checkout_credito(string $access_token, array $data): TransactionResponse
    {
        $dto = new CheckoutCreditoDTO($data);

        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return TransactionResponse
     * @throws InvalidArgumentsTransactionResponseException
     * @throws UnknownProperties
     */
    public function checkout_debito(string $access_token, array $data): TransactionResponse
    {
        $dto = new CheckoutDebitoDTO($data);

        return new TransactionResponse(
            null,
            ['BRADESCO' => Str::uuid()->toString()],
            'TRANSACAO_SCAFOLDING_23H4HVHBHBRH34',
            'CONCLUIDA'
        );
    }
}
