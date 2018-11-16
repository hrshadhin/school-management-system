<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
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

        $routeName = $request->route()->getName();

        if(!$request->user()->can($routeName)) {
            if($request->ajax()) {
                return response('Access denied!', 401);
            }
            abort(401);
        }
        return $next($request);
    }
}
