<?php

namespace App\Models;

use App\Exceptions\DuplicatedRelacUserGatewayException;
use App\Exceptions\RelacUserGatewayNotFoundException;
use App\Exceptions\UserNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGateway extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_gateway';

    protected $fillable = [
      'user_id',
      'gateway_id',
    ];

    /**
     * @param $user_id
     * @param $gateway_id
     * @return void
     * @throws DuplicatedRelacUserGatewayException
     */
    public static function create_relac_user_gateway($data): void
    {
        if (!User::where('id', $data['user_id'])->exists()) {
            throw new UserNotFoundException($data['user_id']);
        }

        $gateway = UserGateway::where('user_id', $data['user_id'])
            ->where('gateway_id', $data['gateway_id'])
            ->first();

        if ($gateway) throw new DuplicatedRelacUserGatewayException($data['gateway_id']);

        UserGateway::create(['user_id' => $data['user_id'], 'gateway_id' => $data['gateway_id']]);
    }

    public static function remove_relac_user_gateway($data): void
    {
        $gateway = UserGateway::where('user_id', $data['user_id'])
            ->where('gateway_id', $data['gateway_id'])
            ->first();

        if (!$gateway) throw new RelacUserGatewayNotFoundException($data['gateway_id']);

        $gateway->forceDelete();
    }

}
