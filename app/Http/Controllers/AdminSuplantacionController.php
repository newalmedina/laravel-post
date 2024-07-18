<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminSuplantacionController extends Controller
{

    public function suplantar($id)
    {



        if (!auth()->user()->isAbleTo("admin-users-suplant-identity")) {
            abort(404);
        }
        $user = User::findOrFail($id);

        $originalUser = auth()->id();

        if ($user->id !== $originalUser) {
            session()->put("original-user-suplantar", $originalUser);
            auth()->login($user);
        }

        return redirect("/admin/dashboard");
    }

    public function revertir()
    {

        if (!session()->has("original-user-suplantar")) {
            abort(404);
        }

        $originalUser = session()->get("original-user-suplantar");
        auth()->loginUsingId($originalUser);
        session()->forget("original-user-suplantar");

        return redirect("admin/users");
    }
}
