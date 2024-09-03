<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next, $guard = 'cus')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('cus.login');
        }

    return $next($request);
    }
}
