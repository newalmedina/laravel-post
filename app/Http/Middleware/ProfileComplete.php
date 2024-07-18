<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\SettingsServices;
use Closure;
use Illuminate\Http\Request;

class ProfileComplete
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
        $idprofile = auth()->user()->id;
        // Creamos un nuevo objeto para nuestro nuevo usuario
        $user = User::with('userProfile')->find($idprofile);

        if (
            empty($user->userProfile->birthday) ||
            empty($user->userProfile->identification) ||
            empty($user->userProfile->phone) ||
            empty($user->userProfile->gender) ||
            empty($user->userProfile->province_id) ||
            empty($user->userProfile->municipio_id) ||
            empty($user->userProfile->address)
        ) {
            return redirect('admin/profile/personal-info')->with('error-alert', trans('users/admin_lang.complete_personal_information'));
        }
        return $next($request);
    }
}
