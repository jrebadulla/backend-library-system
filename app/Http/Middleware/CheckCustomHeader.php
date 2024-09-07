<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCustomHeader
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('X-Custom-Header') !== 'expected-value') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
