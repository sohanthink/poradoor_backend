<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TransactionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        DB::beginTransaction();

        try {
            $response = $next($request);

            // Rollback if the response has a server error status (optional)
            if ($response->getStatusCode() >= 500) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            return $response;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e; // Rethrow so Laravel's exception handler can catch it
        }
    }
}