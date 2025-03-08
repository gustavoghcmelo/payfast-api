<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transaction_service,
    ) {}

    public function execute_transaction(FormRequest $request): JsonResponse
    {
        return ApiResponse::success($this->transaction_service->execute_transaction($request->all()));
    }

    public function check_transaction(FormRequest $request): JsonResponse
    {
        return ApiResponse::success($this->transaction_service->check_transaction($request->all()));
    }
}
