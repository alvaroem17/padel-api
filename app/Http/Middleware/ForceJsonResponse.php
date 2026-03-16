<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Force JSON behavior even if the client doesn't set Accept: application/json
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
