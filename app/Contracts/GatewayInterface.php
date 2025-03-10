<?php

namespace App\Contracts;

use App\Dto\Core\CheckStatusTransactionResponse;
use App\Dto\Core\GatewayAuthResponse;
use App\Dto\Core\TransactionResponse;
use App\Models\Transaction;

interface GatewayInterface
{
    /**
     * @return GatewayAuthResponse
     */
    public function authenticate(): GatewayAuthResponse;

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return TransactionResponse
     */
    public function pix_imediato(string $access_token, array $data): TransactionResponse;

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return TransactionResponse
     */
    public function pix_vencimento(string $access_token, array $data): TransactionResponse;

    /**
     * @param string $access_token
     * @param Transaction $transaction
     * @return CheckStatusTransactionResponse
     */
    public function consulta_pix(string $access_token, Transaction $transaction): CheckStatusTransactionResponse;

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return TransactionResponse
     */
    public function boleto(string $access_token, array $data): TransactionResponse;

    /**
     * @param string $access_token
     * @param Transaction $transaction
     * @return CheckStatusTransactionResponse
     */
    public function consulta_boleto(string $access_token, Transaction $transaction): CheckStatusTransactionResponse;

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return TransactionResponse
     */
    public function checkout_credito(string $access_token, array $data): TransactionResponse;

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return TransactionResponse
     */
    public function checkout_debito(string $access_token, array $data): TransactionResponse;
}
