<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class FrontLoginController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($this->credentials(), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // Podemos devolver una excepcion que nos retornara a la p�gina de origen o forzar a la de login
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ])
                ->redirectTo('/login');
        } else {
        }
    }
}
