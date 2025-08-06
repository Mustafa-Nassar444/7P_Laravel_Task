<?php

namespace App\Http\Services;

use Illuminate\Http\JsonResponse;

class ResponseService
{
    /**
     * Handle API response
     *
     * @param mixed $data
     * @param int $statusCode
     * @param string|null $message
     * @param bool $success
     * @return \Illuminate\Http\JsonResponse
     */
    public static function handle($data = null, int $statusCode = 200, string $message = null, bool $success = true): JsonResponse
    {
        $response = [
            'success' => $success,
            'status' => $statusCode,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Success response
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseSuccess($data = null, string $message = null, int $statusCode = 200): JsonResponse
    {
        return self::handle($data, $statusCode, $message, true);
    }

    /**
     * Error response
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseError(string $message, int $statusCode = 400): JsonResponse
    {
        return self::handle(null, $statusCode, $message, false);
    }
}