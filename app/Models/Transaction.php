<?php

namespace App\Models;

use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'transaction_type_id',
        'gateway_id',
        'gateway_transaction_id',
        'payload',
        'amount',
        'currency',
        'status',
        'description',
    ];

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction_type(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }
}
