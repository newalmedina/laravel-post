<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontRegisterRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontRegisterUserController extends Controller
{
    protected $redirectTo = 'admin/categories';
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(FrontRegisterRequest $request)
    {
        /*$request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);*/

        try {
            DB::beginTransaction();

            // Creamos un nuevo objeto para nuestro nuevo usuario y su relación
            $user = new User();

            // Obtenemos los datos enviados por el usuario

            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));

            $user->active = true;

            // Guardamos el usuario
            $user->push();
            if ($user->id) {
                $userProfile = new UserProfile();

                $userProfile->first_name = $request->input('user_profile.first_name');
                $userProfile->last_name = $request->input('user_profile.last_name');
                $userProfile->gender = 'male';
                $userProfile->user_lang = 'es';

                $user->userProfile()->save($userProfile);


                DB::commit();
            } else {
                dd("error");
                DB::rollBack();
                // En caso de error regresa a la acción create con los datos y los errores encontrados
                return redirect()->back()
                    ->withInput($request->except('password'))
                    ->withErrors($user->errors);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()
                ->withInput($request->except('password'))
                ->with('error-alert', $e->getMessage());
            // ->with('error-alert', trans('users/lang.error_en_accion'));
        }

        Auth::login($user);

        return redirect($this->redirectTo);
    }
}
