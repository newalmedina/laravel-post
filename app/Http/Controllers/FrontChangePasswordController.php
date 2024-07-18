<?php

namespace App\Http\Controllers;

use App\Http\Requests\FrontChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class FrontChangePasswordController extends Controller
{
    public function index()
    {
        return view("auth.passwords.change_password");
    }
    public function update(FrontChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->password_old, $user->password)) {
            return redirect()
            ->back()
            ->withErrors(['password_old' =>  trans('auth/change_password/front_lang.password_old_error')])
            ->withInput();
        }
        $user->password=bcrypt($request->password);
        $user->password_changed_at=Carbon::now();
        $user->save();

        return redirect()->to('/')->with('success', trans('auth/change_password/front_lang.password_ok') );
    }
}
