<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/admin/users";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function redirectTo()
    {
        return route('admin.users.index'); // Redireccionar a la ruta con nombre "dashboard"
    }
    protected function credentials(Request $request)
    {
        // Agrega la verificación de la columna "active" junto con el correo electrónico y la contraseña
        return array_merge($request->only('email', 'password'), ['active' => 1]);
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        // Verificar si el usuario está inactivo
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && !$user->active) {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => trans('auth.failed')]);
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => trans('auth.failed')]);
    }
    protected function login(Request $request)
    {
        // Verifica el reCAPTCHA
        // $recaptcha = new ReCaptcha(env('GOOGLE_RECAPTCHA_SECRET'));
        // $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        // if (!$response->isSuccess()) {
        //     // El reCAPTCHA no se ha validado correctamente
        //     return redirect()->back()->withErrors(['captcha' => 'El reCAPTCHA no se ha validado correctamente.']);
        // }


        $remember = $request->has('remember');

        if (auth()->attempt($this->credentials($request), $remember)) {
            // Autenticación exitosa
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => trans('auth.failed')]);
    }
}
