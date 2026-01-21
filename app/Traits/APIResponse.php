<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait APIResponse{
    private function success($data, $message, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Common Error Response
     */
    private function error($message, $code = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}