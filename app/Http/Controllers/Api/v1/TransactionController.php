<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Transaction\CreateTransactionRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Exceptions\TransactionNotFoundException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use App\Exceptions\GatewayAuthFailureException;
use App\Exceptions\GatewayTransactionTypePermissionException;
use App\Exceptions\InvalidTransactionTypeException;
use App\Exceptions\TransactionFailureException;
use App\Exceptions\UserGatewayPermissionException;
use App\Exceptions\CheckStatusTransactionException;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transaction_service,
    ) {}

    /**
     * @param CreateTransactionRequest $request
     * @return JsonResponse
     * @throws GatewayAuthFailureException
     * @throws GatewayTransactionTypePermissionException
     * @throws InvalidTransactionTypeException
     * @throws TransactionFailureException
     * @throws UserGatewayPermissionException
     * @throws UnknownProperties
     */
    public function execute_transaction(CreateTransactionRequest $request): JsonResponse
    {
        return ApiResponse::success($this->transaction_service->execute_transaction($request));
    }

    /**
     * @param FormRequest $request
     * @return JsonResponse
     * @throws GatewayAuthFailureException
     * @throws GatewayTransactionTypePermissionException
     * @throws InvalidTransactionTypeException
     * @throws UserGatewayPermissionException
     * @throws CheckStatusTransactionException
     * @throws TransactionNotFoundException
     */
    public function check_transaction(FormRequest $request): JsonResponse
    {
        return ApiResponse::success($this->transaction_service->check_transaction($request->all()));
    }
}
