<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Payment\ChargeRequest;
use App\Repositories\PaymentRepository;
use App\Services\Payment\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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

//        $payment = $this->paymentRepository::create([
//            'transaction_id' => $response['data']['transaction_id'],
//            'amount' => $data['amount'],
//            'status' => $response['status'],
//        ]);

        return ApiResponse::success(
            $response['data'],
            Response::HTTP_CREATED,
            'Transação realizada com sucesso.'
        );
    }
}
