<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;


class BasicResource extends JsonResource
{
    /**
     * Handle Response
     * @param array $handle
     * @param bool $status
     * @return JsonResponse
     */
    public static function result(Model $model, bool $status = true, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'response' => $model,
        ], $code);
    }

    /**
     * Handle Response
     * @param array $handle
     * @param bool $status
     * @return JsonResponse
     */
    public static function handle(array $handle, bool $status = false): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $handle[0]
        ], $handle[1]);
    }

    /**
     * Success Message
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function success(string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message
        ], $code);
    }

    /**
     * Error Message
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function error(string $message, int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}
