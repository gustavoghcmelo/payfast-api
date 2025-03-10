<?php

namespace App\Services;

use App\Contracts\GatewayInterface;
use App\Exceptions\CheckStatusTransactionException;
use App\Exceptions\GatewayAuthFailureException;
use App\Exceptions\GatewayTransactionTypePermissionException;
use App\Exceptions\InvalidTransactionTypeException;
use App\Exceptions\TransactionFailureException;
use App\Exceptions\TransactionNotFoundException;
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
     * @param array<mixed> $data
     * @return array<mixed>
     * @throws GatewayAuthFailureException
     * @throws TransactionFailureException
     * @throws UserGatewayPermissionException
     * @throws GatewayTransactionTypePermissionException
     * @throws InvalidTransactionTypeException
     */
    public function execute_transaction(array $data): array
    {
        User::canUseGateway($this->requested_gateway);
        Gateway::canUseTransactionType($this->requested_gateway, $this->requested_transaction_type);

        $transaction = Transaction::create($data);

        [ $auth_error, $access_token ] = $this->gateway->authenticate()->toArray();
        /** @phpstan-ignore-next-line  */
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [
            $transaction_error,
            $transaction_data,
            $gateway_transaction_id,
            $gateway_transaction_status

        ] = $this->gatewayTransaction($access_token, $data);
        /** @phpstan-ignore-next-line  */
        if ($transaction_error) throw new TransactionFailureException($transaction->id, $transaction_error);

        /** @phpstan-ignore-next-line  */
        Transaction::update_transaction_success($transaction->id, $transaction_data, $gateway_transaction_id, $gateway_transaction_status);
        return $transaction_data;
    }


    /**
     * @param array<mixed> $data
     * @return array<mixed>
     * @throws CheckStatusTransactionException
     * @throws GatewayAuthFailureException
     * @throws GatewayTransactionTypePermissionException
     * @throws InvalidTransactionTypeException
     * @throws TransactionNotFoundException
     * @throws UserGatewayPermissionException
     */
    public function check_transaction(array $data): array
    {
        $transaction = Transaction::getTransaction($data['transaction_id']);

        User::canUseGateway($this->requested_gateway);
        Gateway::canUseTransactionType($this->requested_gateway, $this->requested_transaction_type);

        [ $auth_error, $access_token ] = ($this->gateway->authenticate())->toArray();
        /** @phpstan-ignore-next-line  */
        if ($auth_error) throw new GatewayAuthFailureException($transaction->id, $auth_error);

        [ $transaction_error, $transaction_data ] = $this->gatewayTransaction($access_token, $data);
        /** @phpstan-ignore-next-line  */
        if ($transaction_error) throw new CheckStatusTransactionException($transaction->id, $transaction_error);

        return $transaction_data;
    }

    /**
     * @param string $access_token
     * @param array<mixed> $data
     * @return array<mixed>
     * @throws InvalidTransactionTypeException
     */
    protected function gatewayTransaction(string $access_token, array $data): array
    {
        $transaction_type = $this->requested_transaction_type->description;
        $methodName = Str::replace('-', '_', $transaction_type);

        if (!method_exists($this->gateway, $methodName)) {
            throw new InvalidTransactionTypeException($transaction_type, $this->requested_gateway->slug);
        }

        return (call_user_func([$this->gateway, $methodName], $access_token, $data))->toArray();
    }

}
