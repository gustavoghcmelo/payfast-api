<?php

namespace App\Models;

use App\Exceptions\TransactionTypeNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;

class TransactionType extends Model
{
    use SoftDeletes;

    protected $table = 'transaction_type';
    protected $fillable = [
        'description',
    ];

    public static function index(array $queryParams): CursorPaginator
    {
        return DB::table('transaction_type')
            ->when($queryParams['description'], function (Builder $query, string $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            ->orderBy('created_at', 'desc')
            ->cursorPaginate($queryParams['limit']);
    }

    /**
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

        return TransactionType::find($transaction_type_id);
    }

    /**
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
}
