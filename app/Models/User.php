<?php

namespace App\Models;

use App\Exceptions\UserNotFoundException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function gateways(): BelongsToMany
    {
        return $this->belongsToMany(Gateway::class, 'user_gateway', 'user_id', 'gateway_id');
    }

    public static function gateway_array($user_id): Collection
    {
        $user = User::with('gateways')->find($user_id);
        return $user->gateways->pipe(function ($gateway) {
            return $gateway->pluck('slug');
        });
    }

    public static function index(array $queryParams): CursorPaginator
    {
        return DB::table('users')
            ->when($queryParams['name'], function (Builder $query, string $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($queryParams['email'], function (Builder $query, string $email) {
                return $query->where('description', 'like', '%' . $email . '%');
            })
            ->orderBy('created_at', 'desc')
            ->cursorPaginate($queryParams['limit']);
    }

    /**
     * @throws UserNotFoundException
     */
    public static function edit(array $data, int $user_id): User
    {
        if (!User::where('id', $user_id)->exists()) {
            throw new UserNotFoundException($user_id);
        }

        DB::table('users')
            ->where('id', $user_id)
            ->update($data);

        return User::find($user_id);
    }

    /**
     * @throws UserNotFoundException
     */
    public static function remove(int $user_id): User
    {
        $deleted = User::destroy($user_id);

        if ($deleted === 0) {
            throw new UserNotFoundException($user_id);
        }

        return User::withTrashed()->find($user_id);
    }
}
