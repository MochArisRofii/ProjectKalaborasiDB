<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        $roles = ['admin', 'kasir'];
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        // Default redirect jika role tidak dikenali
        return redirect('/');
    }
}
