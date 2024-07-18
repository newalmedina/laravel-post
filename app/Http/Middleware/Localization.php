<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Localization
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            if (!empty($user->userProfile->id)) {
                App::setLocale($user->userProfile->user_lang);
            }
        } else {
            if (session()->has('locale')) {
                App::setLocale(session()->get('locale'));
            }
        }
        return $next($request);
    }
}
