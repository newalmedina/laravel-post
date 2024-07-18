<?php

namespace App\Http\Middleware;

use App\Services\SettingsServices;
use Closure;
use Illuminate\Http\Request;

class AvailableSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $settings =  SettingsServices::getGeneral();
        if (!$settings->active) {
            app()->abort(503);
        }
        return $next($request);
    }
}
