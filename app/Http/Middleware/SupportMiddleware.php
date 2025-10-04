<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SupportMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || (! $request->user()->isSupport() && ! $request->user()->isAdmin())) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
