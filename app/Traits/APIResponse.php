<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

trait APIResponse{
    private function success($message, $data = [], $code = 200): JsonResponse
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

    private function throw_error_with_condition($condition = true, $message, $code)
    {
        throw_if(
            condition: $condition,
            exception: function () use($message, $code): HttpResponseException{
                return new HttpResponseException($this->error($message, $code));
            }
        );
    }
    private function throw_error($message, $code): never
    {
        throw new HttpResponseException(response: $this->error($message, $code));
    }


}