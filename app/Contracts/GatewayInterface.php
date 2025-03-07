<?php

namespace App\Contracts;

use App\Dto\Core\CheckStatusTransactionResponse;
use App\Dto\Core\GatewayAuthResponse;
use App\Dto\Core\TransactionResponse;
use App\Models\Transaction;

interface GatewayInterface
{
    public function authenticate(): GatewayAuthResponse;
    public function pix_imediato(string $access_token, array $data): TransactionResponse;
    public function pix_vencimento(string $access_token, array $data): TransactionResponse;
    public function consulta_pix(string $access_token, Transaction $transaction): CheckStatusTransactionResponse;
    public function boleto(string $access_token, array $data): TransactionResponse;
    public function consulta_boleto(string $access_token, Transaction $transaction): CheckStatusTransactionResponse;
    public function checkout_credito(string $access_token, array $data): TransactionResponse;
    public function checkout_debito(string $access_token, array $data): TransactionResponse;
}
