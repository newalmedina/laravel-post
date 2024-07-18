<?php

namespace App\Http\Middleware;

use App\Services\SettingsServices;
use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ChangePassword
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
       
        if (Auth::check()) {
           if(empty(Auth::user()->password_changed_at)){
                return redirect('change-password');
           }
        } 
        return $next($request);
    }
}
