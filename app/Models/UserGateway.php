<?php

namespace App\Models;

use App\Exceptions\DuplicatedRelacUserGatewayException;
use App\Exceptions\RelacUserGatewayNotFoundException;
use App\Exceptions\UserNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<UserGateway> where($column, $operator = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder<UserGateway> create(array<mixed> $attributes = [])
 */
class UserGateway extends Model
{
    /** @phpstan-ignore-next-line  */
    use HasFactory, SoftDeletes;

    protected $table = 'user_gateway';

    protected $fillable = [
      'user_id',
      'gateway_id',
    ];


    /**
     * @param array{user_id: int, gateway_id: string} $data
     * @return void
     * @throws DuplicatedRelacUserGatewayException
     * @throws UserNotFoundException
     */
    public static function create_relac_user_gateway(array $data): void
    {
        if (!User::where('id', $data['user_id'])->exists()) {
            throw new UserNotFoundException($data['user_id']);
        }

        $gateway = UserGateway::where('user_id', $data['user_id'])
            ->where('gateway_id', $data['gateway_id'])
            ->first();

        if ($gateway) throw new DuplicatedRelacUserGatewayException((int) $data['gateway_id']);

        UserGateway::create($data);
    }

    /**
     * @param array{user_id: int, gateway_id: string} $data
     * @return void
     * @throws RelacUserGatewayNotFoundException
     */
    public static function remove_relac_user_gateway(array $data): void
    {
        $gateway = UserGateway::where('user_id', $data['user_id'])
            ->where('gateway_id', $data['gateway_id'])
            ->first();

        if (!$gateway) throw new RelacUserGatewayNotFoundException((int) $data['gateway_id']);

        $gateway->forceDelete();
    }

}
