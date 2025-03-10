<?php

namespace App\Models;

use App\Exceptions\GatewayNotFoundException;
use App\Exceptions\GatewayTransactionTypePermissionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<Gateway> create(array<mixed> $attributes = [])
 * @method static \Illuminate\Database\Eloquent\Builder<Gateway> where($column, $operator = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder<Gateway> find($id, $columns = ['*'])
 * @property int $id
 * @property string $description
 * @property string $slug
 */
class Gateway extends Model
{
    /** @phpstan-ignore-next-line */
    use HasFactory, SoftDeletes;

    protected $hidden = ['pivot'];

    protected $table = 'gateways';
    protected $fillable = [
        'slug',
        'description',
    ];

    /**
     * @param array<string, string> $queryParams
     * @return CursorPaginator<int, Gateway>
     */
    public static function index(array $queryParams): CursorPaginator
    {
        return Gateway::query()
            ->when($queryParams['slug'], function (Builder $query, string $slug) {
                return $query->where('slug', 'like', '%' . $slug . '%');
            })
            ->when($queryParams['description'], function (Builder $query, string $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            ->with(['transaction_types' => function ($query) {
                $query->select('transaction_type.id', 'transaction_type.description');
            }])
            ->orderBy('created_at', 'desc')
            ->cursorPaginate((int) $queryParams['limit']);
    }

    /**
     * @param array<mixed> $data
     * @param int $gateway_id
     * @return Builder<Gateway>
     * @throws GatewayNotFoundException
     */
    public static function edit(array $data, int $gateway_id): Builder
    {
        if (!Gateway::where('id', $gateway_id)->exists()) {
            throw new GatewayNotFoundException($gateway_id);
        }

        DB::table('gateways')
            ->where('id', $gateway_id)
            ->update($data);

        return Gateway::find($gateway_id);
    }

    /**
     * @throws GatewayNotFoundException
     */
    public static function remove(int $gateway_id): Gateway
    {
        $deleted = Gateway::destroy($gateway_id);

        if ($deleted === 0) {
            throw new GatewayNotFoundException($gateway_id);
        }

        return Gateway::withTrashed()->find($gateway_id);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_gateway',
            'gateway_id',
            'user_id'
        );
    }

    /**
     * @return BelongsToMany<TransactionType, $this>
     */
    public function transaction_types(): BelongsToMany
    {
        return $this->belongsToMany(
            TransactionType::class,
            'gateway_transaction_type',
            'gateway_id',
            'transaction_type_id'
        );
    }

    /**
     * @param Gateway $gateway
     * @param TransactionType $transaction_type
     * @return void
     * @throws GatewayTransactionTypePermissionException
     */
    public static function canUseTransactionType(Gateway $gateway, TransactionType $transaction_type): void
    {
        $canUse = GatewayTransactionType::where('gateway_id', $gateway->id)
            ->where('transaction_type_id', $transaction_type->id)
            ->exists();

        if(!$canUse) {
            throw new GatewayTransactionTypePermissionException(
                $transaction_type->description,
                $gateway->slug
            );
        }
    }
}
