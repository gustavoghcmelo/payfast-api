<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\TransactionType\CreateRequest;
use App\Http\Requests\Api\v1\Admin\TransactionType\GetRequest;
use App\Http\Requests\Api\v1\Admin\TransactionType\UpdateRequest;
use App\Models\TransactionType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TransactionTypeController extends Controller
{
    public function index(GetRequest $request): JsonResponse
    {
        $gateways = TransactionType::index($request->all());
        return ApiResponse::success([$gateways]);
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $saved = TransactionType::create([
            'description' => $request->input('description'),
        ]);

        return ApiResponse::success([$saved], Response::HTTP_CREATED);
    }

    public function update(UpdateRequest $request, int $gateway_id): JsonResponse
    {
        return ApiResponse::success([
            TransactionType::edit($request->all(), $gateway_id)
        ], Response::HTTP_OK);
    }

    public function destroy(int $gateway_id): JsonResponse
    {
        return ApiResponse::success([
            TransactionType::remove($gateway_id)
        ], Response::HTTP_OK);
    }
}
