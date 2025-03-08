<?php

namespace App\Services;

use App\Contracts\GatewayInterface;
use App\Exceptions\CheckStatusTransactionException;
use App\Exceptions\GatewayAuthFailureException;
use App\Exceptions\GatewayTransactionTypePermissionException;
use App\Exceptions\TransactionFailureException;
use App\Exceptions\UserGatewayPermissionException;
use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Support\Str;

class TransactionService
{
    public Gateway $requested_gateway;
    public TransactionType $requested_transaction_type;

    public function __construct(
        public GatewayInterface $gateway
    ) {
        $this->requested_gateway = app('active_gateway');
        $this->requested_transaction_type = app('active_transaction_type');
    }

    /**
     * @param array $data
     * @return array
     * @throws GatewayAuthFailureException
     * @throws TransactionFailureException
     * @throws UserGatewayPermissionException
     * @throws GatewayTransactionTypePermissionException
     */
    public function execute_transaction(array $data): array
    {
        User::canUseGateway($this->requested_gateway);
        Gateway::canUseTransactionType($this->requested_gateway, $this->requested_transaction_type);

        $transaction = Transaction::create($data);

        [ $auth_error, $access_token ] = $this->gateway->authenticate()->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [
            $transaction_error,
            $transaction_data,
            $gateway_transaction_id,
            $gateway_transaction_status

        ] = $this->gatewayTransaction($access_token, $data);
        if ($transaction_error) throw new TransactionFailureException($transaction->id, $transaction_error);

        Transaction::update_transaction_success($transaction->id, $transaction_data, $gateway_transaction_id, $gateway_transaction_status);
        return $transaction_data;
    }

    /**
     * @param Transaction $transaction
     * @return array
     * @throws GatewayAuthFailureException
     * @throws CheckStatusTransactionException
     * @throws UserGatewayPermissionException
     * @throws GatewayTransactionTypePermissionException
     */
    public function check_transaction(Transaction $transaction): array
    {
        User::canUseGateway($this->requested_gateway);
        Gateway::canUseTransactionType($this->requested_gateway, $this->requested_transaction_type);

        [ $auth_error, $access_token ] = ($this->gateway->authenticate())->toArray();
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data ] = $this->gatewayTransaction($access_token, $transaction);
        if ($transaction_error) throw new CheckStatusTransactionException($transaction->id, $transaction_error);

        return $transaction_data;
    }

    protected function gatewayTransaction($access_token, $data): array
    {
        $methodName = Str::replace('-', '_', $this->requested_transaction_type->description);
        return $this->gateway->$methodName($access_token, $data)->toArray();
    }

}
