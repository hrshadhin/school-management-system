<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(!$request->user()->hasRole($role)) {
            if($request->ajax()) {
                return response('Access denied!', 401);
            }
            abort(404);
        }
        if($permission !== null && !$request->user()->can($permission)) {
            if($request->ajax()) {
                return response('Access denied!', 401);
            }
            abort(401);
        }
        return $next($request);
    }
}
