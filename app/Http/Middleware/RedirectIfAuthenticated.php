<?php

namespace App\Http\Middleware;

use App\Http\Helpers\AppHelper;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::viaRemember()) {
                session(['user_session_sha1' => AppHelper::getUserSessionHash()]);
                session(['user_role_id' => auth()->user()->role->role_id]);
            }
            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
