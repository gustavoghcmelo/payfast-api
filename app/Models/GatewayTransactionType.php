<?php

namespace App\Models;

use App\Exceptions\DuplicatedRelacGatewayTransactionTypeException;
use App\Exceptions\RelacGatewayTransactionTypeNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatewayTransactionType extends Model
{
    use SoftDeletes;

    protected $table = 'gateway_transaction_type';
    protected $fillable = [
        'gateway_id',
        'transaction_type_id',
    ];

    /**
     * @param $data
     * @return void
     * @throws DuplicatedRelacGatewayTransactionTypeException
     */
    public static function add_relac_gateway_transaction_type($data): void
    {
        $relac = GatewayTransactionType::where('gateway_id', $data['gateway_id'])
                ->where('transaction_type_id', $data['transaction_type_id'])
                ->exists();

        if ($relac) throw new DuplicatedRelacGatewayTransactionTypeException($data['gateway_id'], $data['transaction_type_id']);

        GatewayTransactionType::create($data);
    }

    /**
     * @param $data
     * @return void
     * @throws RelacGatewayTransactionTypeNotFoundException
     */
    public static function remove_relac_gateway_transaction_type($data): void
    {
        $relac = GatewayTransactionType::where('gateway_id', $data['gateway_id'])
            ->where('transaction_type_id', $data['transaction_type_id'])
            ->first();

        if (!$relac) throw new RelacGatewayTransactionTypeNotFoundException($data['gateway_id'], $data['transaction_type_id']);

        $relac->forceDelete();
    }
}
