<?php


namespace VictorMaderaA\LaraQuickStart;


use Spatie\QueryBuilder\QueryBuilder;

/**
 * Checks that the model has public property set to true
 *
 * Class PublicQueryFilter
 * @package InTable\QueryFilters
 */
class PublicQueryFilter implements IQueryFilter
{

    /**
     * Checks that the model has public property set to true
     *
     * @param QueryBuilder $query
     * @return QueryBuilder
     */
    public function filter(QueryBuilder $query): QueryBuilder
    {
        $query->where('public', true);
        return $query;
    }

}
