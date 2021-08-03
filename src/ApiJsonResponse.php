<?php


namespace VictorMaderaA\LaraQuickStart;

use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;


class ApiJsonResponse
{

    public static function laraApiResponse($data, int $statusCode = 200, bool $ok = true, string $message = 'ok'): JsonResponse
    {
        return response()->json(static::buildResponse($data, $statusCode, $ok, $message), $statusCode);
    }

    #[ArrayShape(["_data" => "", "_status" => "array"])] public static function buildResponse($data, int $statusCode = 200, bool $ok = true, string $message = 'ok'): array
    {
        if ($message === 'ok' && $statusCode !== 200) {
            $message = static::getDefStatusMessage($statusCode);
        }

        $apiVersion = env('APP_VERSION', '1.0.0');
        return [
            "_data" => $data,
            "_status" => [
                "ok" => $ok,
                "code" => $statusCode,
                "apiVersion" => $apiVersion,
                "message" => $message
            ]
        ];
    }

    public static function getDefStatusMessage($statusCode): string
    {
        return match ($statusCode) {
            201 => 'Created',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            405 => 'Method Not Allowed',
            404 => 'Not Found',
            409 => 'Conflict',
            410 => 'Gone',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            503 => 'Service Unavailable',
            default => 'DefOK',
        };
    }

}
