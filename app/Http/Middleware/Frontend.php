<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Helpers\AppHelper;


class Frontend
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
        $appSettings = AppHelper::getAppSettings();

        if (!isset($appSettings['frontend_website']) or $appSettings['frontend_website'] == 0) {
            return redirect('login');
        }


        return $next($request);
    }
}
