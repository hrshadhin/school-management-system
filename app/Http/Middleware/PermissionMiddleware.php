<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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

        //check for user force logout
        if($request->user()->force_logout){
            $request->user()->force_logout = 0;
            $request->user()->save();

            Auth::logout();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
