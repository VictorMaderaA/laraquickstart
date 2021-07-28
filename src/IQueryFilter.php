<?php


namespace VictorMaderaA\LaraQuickStart;


use Spatie\QueryBuilder\QueryBuilder;

interface IQueryFilter
{

    public function filter(QueryBuilder $query): QueryBuilder;

}
