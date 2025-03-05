<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\User\GetRequest;
use App\Http\Requests\Api\v1\Admin\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(GetRequest $request): JsonResponse
    {
        $gateways = User::index($request->all());
        return ApiResponse::success([$gateways]);
    }

    public function update(UpdateRequest $request, int $gateway_id): JsonResponse
    {
        return ApiResponse::success([
            User::edit($request->all(), $gateway_id)
        ], Response::HTTP_OK);
    }

    public function destroy(int $gateway_id): JsonResponse
    {
        return ApiResponse::success([
            User::remove($gateway_id)
        ], Response::HTTP_OK);
    }
}
