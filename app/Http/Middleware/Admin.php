<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class Admin
 * 
 * @category Middleware
 */
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request   
     * @param \Closure                 $next  
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && ! auth()->user()->hasRole('guest')) {
            return $next($request);
        }

        return response()->json('No autorizado', 401);
    }
}
