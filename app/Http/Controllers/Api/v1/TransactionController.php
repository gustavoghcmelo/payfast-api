<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Transaction\BoletoRequest;
use App\Http\Requests\Api\v1\Transaction\CheckoutCreditoRequest;
use App\Http\Requests\Api\v1\Transaction\CheckoutDebitoRequest;
use App\Http\Requests\Api\v1\Transaction\ConsultaBoletoRequest;
use App\Http\Requests\Api\v1\Transaction\ConsultaPixRequest;
use App\Http\Requests\Api\v1\Transaction\PixImediatoRequest;
use App\Http\Requests\Api\v1\Transaction\PixVencimentoRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $paymentService,
    ) {}

    public function pix_imediato(PixImediatoRequest $request): JsonResponse
    {
        return ApiResponse::success($this->paymentService->pix_imediato($request->all()));
    }

    public function pix_vencimento(PixVencimentoRequest $request): JsonResponse
    {
        return ApiResponse::success($this->paymentService->pix_vencimento($request->all()));
    }

    public function consulta_pix(ConsultaPixRequest $request): JsonResponse
    {
        return ApiResponse::success($this->paymentService->consulta_pix($request->all()));
    }

    public function boleto(BoletoRequest $request): JsonResponse
    {
        return ApiResponse::success($this->paymentService->consulta_pix($request->all()));
    }

    public function consulta_boleto(ConsultaBoletoRequest $request): JsonResponse
    {
        return ApiResponse::success($this->paymentService->consulta_pix($request->all()));
    }

    public function checkout_credito(CheckoutCreditoRequest $request): JsonResponse
    {
        return ApiResponse::success($this->paymentService->consulta_pix($request->all()));
    }

    public function checkout_debito(CheckoutDebitoRequest $request): JsonResponse
    {
        return ApiResponse::success($this->paymentService->consulta_pix($request->all()));
    }
}
