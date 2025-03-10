<?php

namespace App\Models;

use App\Exceptions\UserGatewayPermissionException;
use App\Exceptions\UserNotFoundException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<User> find($column)
 * @method static \Illuminate\Database\Eloquent\Builder<User> where($column, $operator = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder<User> create(array<mixed> $attributes = [])
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @phpstan-ignore-next-line  */
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

    /**
     * @return HasMany<Transaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return BelongsToMany<Gateway, $this>
     */
    public function gateways(): BelongsToMany
    {
        return $this->belongsToMany(Gateway::class, 'user_gateway', 'user_id', 'gateway_id');
    }

    /**
     * @param int $user_id
     * @return Collection<int, User>
     */
    public static function gateway_array(int $user_id): Collection
    {
        $user = User::with('gateways')->find($user_id);
        /** @phpstan-ignore-next-line  */
        return $user->gateways->pipe(function ($gateway) {
            return $gateway->pluck('slug');
        });
    }

    /**
     * @param array{name: string, email: string, limit: string} $queryParams
     * @return CursorPaginator<int, User>
     */
    public static function index(array $queryParams): CursorPaginator
    {
        return User::query()
            ->when($queryParams['name'], function (Builder $query, string $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($queryParams['email'], function (Builder $query, string $email) {
                return $query->where('email', 'like', '%' . $email . '%');
            })
            ->with(['gateways' => function ($query) {
                $query->select('gateways.id', 'gateways.slug', 'gateways.description');
            }])
            ->orderBy('created_at', 'desc')
            ->cursorPaginate((int) $queryParams['limit']);
    }

    /**
     * @param array<mixed> $data
     * @param int $user_id
     * @return User
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

        return User::where('id', $user_id)->first();
    }

    /**
     * @param int $user_id
     * @return User
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

    /**
     * @param Gateway $gateway
     * @return void
     * @throws UserGatewayPermissionException
     */
    public static function canUseGateway(Gateway $gateway): void
    {
        $user = Auth::user();
        $active_gateway = $gateway->slug;

        /** @phpstan-ignore-next-line  */
        if(!$user->tokenCan($active_gateway)) {
            /** @phpstan-ignore-next-line  */
            throw new UserGatewayPermissionException($user->email, $active_gateway);
        }
    }
}
