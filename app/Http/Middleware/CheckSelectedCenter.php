<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSelectedCenter
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
        if (!auth()->user()->hasSelectedCenter()) {
            return redirect()->route('admin.dashboard')->with('error-alert', trans('users/admin_lang.user_not_selected_center'));
        }
        return $next($request);
    }
}
