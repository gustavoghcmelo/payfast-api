<?php

namespace App\Models;

use App\Exceptions\TransactionNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<Transaction> create(array<mixed> $attributes = [])
 * @method static \Illuminate\Database\Eloquent\Builder<Transaction> where($column, $operator = null, $value = null)
 */
class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'transaction_type_id',
        'gateway_id',
        'gateway_transaction_id',
        'gateway_transaction_error',
        'payload',
        'amount',
        'currency',
        'status',
        'description',
    ];

    /**
     * @param string $transaction_id
     * @param array<mixed>|object $payload
     * @param string $gateway_transaction_id
     * @param string $gateway_transaction_status
     * @return void
     */
    public static function update_transaction_success(
        string $transaction_id,
        array|object $payload,
        string $gateway_transaction_id,
        string $gateway_transaction_status
    ): void
    {
        Transaction::where('id', $transaction_id)->update(
            [
                'payload' => json_encode($payload),
                'gateway_transaction_id' => $gateway_transaction_id,
                'gateway_transaction_status' => $gateway_transaction_status,
                'status' => 'SUCCESS',
            ]
        );
    }

    /**
     * @param string $transaction_id
     * @param string|null $error
     * @param array<mixed>|object|null $payload
     * @return void
     */
    public static function update_transaction_error(
        string $transaction_id,
        string|null $error,
        array|object|null $payload = null
    ): void
    {
        Transaction::where('id', $transaction_id)->update(
            [
                'gateway_transaction_error' => $error,
                'payload' => $payload,
                'status' => 'FAILURE',
            ]
        );
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = 1;
            $model->gateway_id = app('active_gateway')->id;
            $model->transaction_type_id = app('active_transaction_type')->id;
        });

        static::updating(function ($model) {
            $model->user_id = 1;
            $model->gateway_id = app('active_gateway')->id;
            $model->transaction_type_id = app('active_transaction_type')->id;
        });
    }

    /**
     * @param int $transaction_id
     * @return Transaction
     * @throws TransactionNotFoundException
     */
    public static function getTransaction(int $transaction_id): Transaction
    {
        $transaction = Transaction::where('id', $transaction_id)->first();
        if (!$transaction) {
            throw new TransactionNotFoundException($transaction_id);
        }

        return $transaction;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<TransactionType, $this>
     */
    public function transaction_type(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    /**
     * @return BelongsTo<Gateway, $this>
     */
    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }
}
