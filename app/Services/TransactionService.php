<?php

namespace App\Services;

use App\Contracts\GatewayInterface;
use App\Exceptions\CheckStatusTransactionException;
use App\Exceptions\GatewayAuthFailureException;
use App\Exceptions\TransactionFailureException;
use App\Models\Transaction;

class TransactionService
{
    protected GatewayInterface $gateway;

    public function __construct(GatewayInterface $gateway) {
        $this->gateway = $gateway;
    }

    /**
     * @param array $data
     * @return array
     * @throws GatewayAuthFailureException
     * @throws TransactionFailureException
     */
    public function pix_imediato(array $data): array
    {
        $transaction = Transaction::create($data);

        [ $auth_error, $access_token ] = $this->gateway->authenticate()->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data, $gateway_transaction_id, $gateway_transaction_status ] = $this->gateway->pix_imediato($access_token, $data)->toArray();
        if ($transaction_error) throw new TransactionFailureException($transaction->id, $transaction_error);

        Transaction::update_transaction_success($transaction->id, $transaction_data, $gateway_transaction_id, $gateway_transaction_status);
        return $transaction_data;
    }


    /**
     * @param array $data
     * @return array
     * @throws GatewayAuthFailureException
     * @throws TransactionFailureException
     */
    public function pix_vencimento(array $data): array
    {
        $transaction = Transaction::create($data);

        [ $auth_error, $access_token ] = $this->gateway->authenticate()->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data, $gateway_transaction_id, $gateway_transaction_status ] = $this->gateway->pix_vencimento($access_token, $data)->toArray();
        if ($transaction_error) throw new TransactionFailureException($transaction->id, $transaction_error);

        Transaction::update_transaction_success($transaction->id, $transaction_data, $gateway_transaction_id, $gateway_transaction_status);
        return $transaction_data;
    }


    /**
     * @param Transaction $transaction
     * @return array
     * @throws GatewayAuthFailureException
     * @throws CheckStatusTransactionException
     */
    public function consulta_pix(Transaction $transaction): array
    {
        [ $auth_error, $access_token ] = ($this->gateway->authenticate())->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data ] = $this->gateway->consulta_pix($access_token, $transaction)->toArray();
        if ($transaction_error) throw new CheckStatusTransactionException($transaction->id, $transaction_error);

        return $transaction_data;
    }


    /**
     * @param array $data
     * @return array
     * @throws GatewayAuthFailureException
     * @throws TransactionFailureException
     */
    public function boleto(array $data): array
    {
        $transaction = Transaction::create($data);

        [ $auth_error, $access_token ] = $this->gateway->authenticate()->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data, $gateway_transaction_id, $gateway_transaction_status ] = $this->gateway->boleto($access_token, $data)->toArray();
        if ($transaction_error) throw new TransactionFailureException($transaction->id, $transaction_error);

        Transaction::update_transaction_success($transaction->id, $transaction_data, $gateway_transaction_id, $gateway_transaction_status);
        return $transaction_data;
    }


    /**
     * @param Transaction $transaction
     * @return array
     * @throws GatewayAuthFailureException
     * @throws CheckStatusTransactionException
     */
    public function consulta_boleto(Transaction $transaction): array
    {
        [ $auth_error, $access_token ] = $this->gateway->authenticate()->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data ] = $this->gateway->consulta_boleto($access_token, $transaction)->toArray();
        if ($transaction_error) throw new CheckStatusTransactionException($transaction->id, $transaction_error);

        return $transaction_data;
    }


    /**
     * @param array $data
     * @return array
     * @throws GatewayAuthFailureException
     * @throws TransactionFailureException
     */
    public function checkout_credito(array $data): array
    {
        $transaction = Transaction::create($data);

        [ $auth_error, $access_token ] = $this->gateway->authenticate()->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data, $gateway_transaction_id, $gateway_transaction_status ] = $this->gateway->checkout_credito($access_token, $data)->toArray();
        if ($transaction_error) throw new TransactionFailureException($transaction->id, $transaction_error);

        Transaction::update_transaction_success($transaction->id, $transaction_data, $gateway_transaction_id, $gateway_transaction_status);
        return $transaction_data;
    }


    /**
     * @param array $data
     * @return array
     * @throws GatewayAuthFailureException
     * @throws TransactionFailureException
     */
    public function checkout_debito(array $data): array
    {
        $transaction = Transaction::create($data);

        [ $auth_error, $access_token ] = $this->gateway->authenticate()->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data, $gateway_transaction_id, $gateway_transaction_status ] = $this->gateway->checkout_debito($access_token, $data)->toArray();
        if ($transaction_error) throw new TransactionFailureException($transaction->id, $transaction_error);

        Transaction::update_transaction_success($transaction->id, $transaction_data, $gateway_transaction_id, $gateway_transaction_status);
        return $transaction_data;
    }
}
