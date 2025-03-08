<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\User\AddGatewayRequest;
use App\Http\Requests\Api\v1\Admin\User\CreateRelacUserGatewayRequest;
use App\Http\Requests\Api\v1\Admin\User\GetRequest;
use App\Http\Requests\Api\v1\Admin\User\RemoveGatewayRequest;
use App\Http\Requests\Api\v1\Admin\User\RemoveRelacUserGatewayRequest;
use App\Http\Requests\Api\v1\Admin\User\UpdateRequest;
use App\Models\User;
use App\Models\UserGateway;
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

    public function add_gateway(int $user_id, AddGatewayRequest $request): JsonResponse
    {
        $request->merge(['user_id' => $user_id]);
        UserGateway::create_relac_user_gateway($request->all());
        return ApiResponse::success(null, 'Gateway adicionado com sucesso.', Response::HTTP_CREATED);
    }

    public function remove_gateway(int $user_id, RemoveGatewayRequest $request): JsonResponse
    {
        $request->merge(['user_id' => $user_id]);
        UserGateway::remove_relac_user_gateway($request->all());
        return ApiResponse::success(null, 'Gateway removido com sucesso.', Response::HTTP_OK);
    }
}
