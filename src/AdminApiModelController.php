<?php

namespace VictorMaderaA\LaraQuickStart;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class AdminApiModelController extends Controller
{

    private static function getFilteredQueryBuilder(Request $request, AbstractModel $model): QueryBuilder
    {
        /** @var AbstractModel $modelClass */
        $modelClass = get_class($model);
        return $modelClass::getQueryBuilder($request, [
            'allowedFields' => $modelClass::getAllowedFields()->toArray(),
            'allowedSorts' => $modelClass::getAllowedSorts()->toArray(),
            'allowedFilters' => $modelClass::getAllowedFilters()->toArray(),
            'allowedAppends' => $modelClass::getAllowedAppends()->toArray(),
            'allowedIncludes' => $modelClass::getAllowedIncludes()->toArray(),
            'queryFilters' => []
        ]);
    }

    public static function adminIndex(Request $request, AbstractModel $model): JsonResponse
    {
        $query = static::getFilteredQueryBuilder($request, $model);
        $resources = AbstractModel::paginateQuery($query, $request);
        return ApiJsonResponse::laraApiResponse($resources);
    }

    public static function adminStore(Request $request, AbstractModel $model, array $allowedUpdates = null): JsonResponse
    {
        $newModel = new $model();
        foreach ($allowedUpdates ?? $model::getAllowedUpdates()->toArray() as $attribute) {
            $newModel->setAttribute($attribute, $request->get($attribute));
        }
        $newModel->saveOrFail();
        return ApiJsonResponse::laraApiResponse($newModel->attributesToArray());
    }

    public static function adminShow(Request $request, AbstractModel $model): JsonResponse
    {
        $query = static::getFilteredQueryBuilder($request, $model);
        return ApiJsonResponse::laraApiResponse($query->find($model->getKey()));
    }

    public static function adminUpdate(Request $request, AbstractModel $model, array $allowedUpdates = null): JsonResponse
    {
        foreach ($allowedUpdates ?? $model::getAllowedUpdates()->toArray() as $attribute) {
            $model->setAttribute($attribute, $request->get($attribute));
        }
        $model->saveOrFail();
        return ApiJsonResponse::laraApiResponse($model->attributesToArray());
    }

    public static function adminDestroy(Request $request, AbstractModel $model): JsonResponse
    {
        $model->delete();
        return ApiJsonResponse::laraApiResponse($model->attributesToArray());
    }

}
