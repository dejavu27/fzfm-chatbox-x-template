<?php

namespace App\Http\Middleware;

use Closure;

class CheckForMaintenance
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
        if ($this->app->isDownForMaintenance())
        {
            return response('Be right back!', 503);
        }

        return $next($request);
    }
}
