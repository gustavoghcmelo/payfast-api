<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Payment\ChargeRequest;
use App\Repositories\PaymentRepository;
use App\Services\Payment\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected PaymentRepository $paymentRepository
    ) {}

    public function charge(ChargeRequest $request): JsonResponse
    {
        $data = $request->all();

        $response = $this->paymentService->charge($data);

        if ($response['error'] !== null) {
            return ApiResponse::error(
                'Falha ao realizar operação',
                $response['error'],
                422
            );
        }

//        $payment = $this->paymentRepository::create([
//            'transaction_id' => $response['data']['transaction_id'],
//            'amount' => $data['amount'],
//            'status' => $response['status'],
//        ]);

        return ApiResponse::success($response['data'], 'Transação realizada com sucesso.');
    }
}
