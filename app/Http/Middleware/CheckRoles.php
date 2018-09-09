<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Auth;
use App\User;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = Auth::user()->roles;
        $mappedRoles = $roles->map(function ($item, $key) {
            return $item->name;
        });
        if(str_is("admin*", Route::current()->uri) && $mappedRoles->contains("Reporter")) {
            return $next($request);
        } elseif(str_is("agent*", Route::current()->uri && $mappedRoles->contains("Agent"))) {
            return $next($request);
        } elseif(str_is("outbound*", Route::current()->uri && $mappedRoles->contains("Outbound"))) {
            return $next($request);
        } elseif(str_is("blended*", Route::current()->uri && $mappedRoles->contains("Blended"))) {
            return $next($request);
        } else {
            abort(401);
        }
    }
}
