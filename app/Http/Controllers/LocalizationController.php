<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LocalizationController extends Controller
{
    public function index($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            if (!empty($user->userProfile->id)) {
                $user->userProfile->user_lang = $locale;
                $user->userProfile->save();
            }
        }
        return redirect()->back();
    }
}
