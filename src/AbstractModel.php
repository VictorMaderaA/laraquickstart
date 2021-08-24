<?php


namespace VictorMaderaA\LaraQuickStart;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;

abstract class AbstractModel extends Model
{
    use HasFactory, SoftDeletes;

    protected static array $allowedUpdates = [];

    protected static array $allowedFields = [];
    protected static array $allowedSorts = [];
    protected static $allowedFilters = [];
    protected static array $allowedIncludes = [];
    protected static $allowedAppends = [];

    public static function getQueryBuilder(Request $request, array $options = []): QueryBuilder
    {
        $query = QueryBuilder::for(static::class);
        if (isset($options['allowedFields'])) {
            $query->allowedFields($options['allowedFields']);
        }
        if (isset($options['allowedSorts'])) {
            $query->allowedSorts($options['allowedSorts']);
        }
        if (isset($options['allowedFilters'])) {
            $query->allowedFilters($options['allowedFilters']);
        }
        if (isset($options['allowedIncludes'])) {
            $query->allowedIncludes($options['allowedIncludes']);
        }
        if (isset($options['allowedAppends'])) {
            $query->allowedAppends($options['allowedAppends']);
        }
        // Custom queryFilters
        if (isset($options['queryFilters']) && is_array($options['queryFilters'])) {
            foreach ($options['queryFilters'] as $queryFilter) {
                // If of type IQueryFilter run else warning
                if (is_subclass_of($queryFilter, IQueryFilter::class)) {
                    $query = (new $queryFilter())->filter($query);
                } else {
                    Log::warning("Tried to run $queryFilter as IQueryFilter::class");
                }
            }
        }
        return $query;
    }

    public static function paginateQuery(QueryBuilder $query, Request $request): LengthAwarePaginator
    {
        return $query->paginate((int)$request->get('per_page', 15))->appends($request->query());
    }

    public static function getAllowedUpdates(array $override = null): Collection
    {
        return collect($override ?? static::$allowedUpdates);
    }

    public static function getAllowedFields(array $override = null): Collection
    {
        return collect($override ?? static::$allowedFields);
    }

    public static function getAllowedSorts(array $override = null): Collection
    {
        return collect($override ?? static::$allowedSorts);
    }

    public static function getAllowedFilters(array $override = null): Collection
    {
        return collect($override ?? static::$allowedFilters);
    }

    public static function getAllowedIncludes(array $override = null): Collection
    {
        return collect($override ?? static::$allowedIncludes);
    }

    public static function getAllowedAppends(array $override = null): Collection
    {
        return collect($override ?? static::$allowedAppends);
    }

    public static function newModel(): AbstractModel
    {
        return new static();
    }

}
