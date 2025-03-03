<?php

namespace App\Http\Controllers\Api\v1;

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

//        $payment = $this->paymentRepository::create([
//            'transaction_id' => $response['transaction_id'],
//            'amount' => $data['amount'],
//            'status' => $response['status'],
//        ]);

        return response()->json($response);
    }
}
