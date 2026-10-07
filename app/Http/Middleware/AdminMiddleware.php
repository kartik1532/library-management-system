<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (! $request->user()) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login to continue.');
        }

        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}