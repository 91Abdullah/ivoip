<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $role = Auth::user()->roles->first()->name;
            $route = null;
            switch ($role) {
                case 'Agent':
                    $route = 'front.agent';
                    break;
                case 'Reporter':
                    $route = 'dashboard';
                    break;
                case 'Outbound':
                    $route = 'front.outbound';
                    break;
                case 'Blended':
                    $route = 'front.blended';
                    break;
                default:
                    abort(404);
                    break;
            }
            return redirect()->route($route);
        }

        return $next($request);
    }
}
