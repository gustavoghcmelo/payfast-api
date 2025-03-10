<?php

namespace App\Models;

use App\Exceptions\TransactionTypeNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<TransactionType> find($column)
 * @method static \Illuminate\Database\Eloquent\Builder<TransactionType> where($column, $operator = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder<TransactionType> create(array<mixed> $attributes = [])
 * @property int $id
 * @property string $description
 */
class TransactionType extends Model
{
    /** @phpstan-ignore-next-line  */
    use HasFactory, SoftDeletes;

    protected $table = 'transaction_type';

    protected $hidden = ['pivot'];

    protected $fillable = [
        'description',
    ];

    /**
     * @param array{description: string, limit: string} $queryParams
     * @return CursorPaginator<int, TransactionType>
     */
    public static function index(array $queryParams): CursorPaginator
    {
        return DB::table('transaction_type')
            ->when($queryParams['description'], function (QueryBuilder $query, string $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            ->orderBy('created_at', 'desc')
            ->cursorPaginate((int) $queryParams['limit']);
    }

    /**
     * @param array<mixed> $data
     * @param int $transaction_type_id
     * @return TransactionType
     * @throws TransactionTypeNotFoundException
     */
    public static function edit(array $data, int $transaction_type_id): TransactionType
    {
        if (!TransactionType::where('id', $transaction_type_id)->exists()) {
            throw new TransactionTypeNotFoundException($transaction_type_id);
        }

        DB::table('transaction_type')
            ->where('id', $transaction_type_id)
            ->update($data);

        return TransactionType::where('id', $transaction_type_id)->first();
    }

    /**
     * @param int $transaction_type_id
     * @return TransactionType
     * @throws TransactionTypeNotFoundException
     */
    public static function remove(int $transaction_type_id): TransactionType
    {
        $deleted = TransactionType::destroy($transaction_type_id);

        if ($deleted === 0) {
            throw new TransactionTypeNotFoundException($transaction_type_id);
        }

        return TransactionType::withTrashed()->find($transaction_type_id);
    }

    /**
     * @return BelongsToMany<Gateway, $this>
     */
    public function gateways(): BelongsToMany
    {
        return $this->belongsToMany(Gateway::class, 'gateway_transaction_type', 'transaction_type_id', 'gateway_id');
    }
}
