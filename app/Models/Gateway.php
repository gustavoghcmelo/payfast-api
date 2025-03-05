<?php

namespace App\Models;

use App\Exceptions\GatewayNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;

class Gateway extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gateways';
    protected $fillable = [
        'slug',
        'description',
    ];

    public static function index(array $queryParams): CursorPaginator
    {
        return DB::table('gateways')
            ->when($queryParams['slug'], function (Builder $query, string $slug) {
                return $query->where('slug', 'like', '%' . $slug . '%');
            })
            ->when($queryParams['description'], function (Builder $query, string $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            ->orderBy('created_at', 'desc')
            ->cursorPaginate($queryParams['limit']);
    }

    /**
     * @throws GatewayNotFoundException
     */
    public static function edit(array $data, int $gateway_id): Gateway
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
}
