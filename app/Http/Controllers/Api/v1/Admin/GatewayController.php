<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\Gateway\CreateRequest;
use App\Http\Requests\Api\v1\Admin\Gateway\GetRequest;
use App\Http\Requests\Api\v1\Admin\Gateway\UpdateRequest;
use App\Models\Gateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GatewayController extends Controller
{
    public function index(GetRequest $request): JsonResponse
    {
        $gateways = Gateway::index($request->all());
        return ApiResponse::success([$gateways]);
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $saved = Gateway::create([
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ]);

        return ApiResponse::success([$saved], Response::HTTP_CREATED);
    }

    public function update(UpdateRequest $request, int $gateway_id): JsonResponse
    {
        return ApiResponse::success([
            Gateway::edit($request->all(), $gateway_id)
        ], Response::HTTP_OK);
    }

    public function destroy(int $gateway_id): JsonResponse
    {
        return ApiResponse::success([
            Gateway::remove($gateway_id)
        ], Response::HTTP_OK);
    }
}
