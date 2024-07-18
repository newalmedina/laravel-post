<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserRequest;
use App\Models\Municipio;
use App\Models\PermissionsTree;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use App\Jobs\SendUserRegistrationEmailJob;
use App\Services\SettingsServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public $filtRoleId;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->filtRoleId = ($request->session()->has('users_filter_role_id')) ? ($request->session()->get('users_filter_role_id')) : [];
           return $next($request);
        });
    }

    public function index()
    {
        if (!auth()->user()->isAbleTo('admin-users')) {
            app()->abort(403);
        }

        $roles = Role::active()->where("roles.can_show", 1)->get();
        $pageTitle = trans('users/admin_lang.users');
        $title = trans('users/admin_lang.list');
        $users = User::orderBy('id', 'asc')->get();
     
        return view('users.admin_index', compact('pageTitle', 'title', "users", "roles"))->with([
            'filtRoleId' => $this->filtRoleId,
         
        ]);
    }

    public function create()
    {
        if (!auth()->user()->isAbleTo('admin-users-create')) {
            app()->abort(403);
        }
        $pageTitle = trans('users/admin_lang.new');
        $title = trans('users/admin_lang.list');
        $user = new User();;
        $tab = 'tab_1';

        return view('users.admin_edit', compact('pageTitle', 'title', "user"))
            ->with('tab', $tab);
    }

    public function edit($id)
    {
        if (!auth()->user()->isAbleTo('admin-users-update')) {
            app()->abort(403);
        }
        $user = User::with('userProfile')->find($id);

        if (empty($user)) {
            app()->abort(404);
        }

        $pageTitle = trans('users/admin_lang.edit');
        $title = trans('users/admin_lang.list');
        $tab = 'tab_1';
        return view('users.admin_edit', compact('pageTitle', 'title', "user"))
            ->with('tab', $tab);
    }

    public function show($id)
    {
        if (!auth()->user()->isAbleTo('admin-users-update')) {
            app()->abort(403);
        }
        $user = User::with('userProfile')->find($id);

        if (empty($user)) {
            app()->abort(404);
        }

        $pageTitle = trans('users/admin_lang.edit');
        $title = trans('users/admin_lang.list');
        $tab = 'tab_1';
        $disabled = "disabled";
        return view('users.admin_edit', compact('pageTitle', 'title', "user", "disabled"))
            ->with('tab', $tab);
    }

    public function update(AdminUserRequest $request, $id)
    {
        if (!auth()->user()->isAbleTo('admin-users-update')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $user = User::with('userProfile')->find($id);

            $user->email = $request->input('email');
            $user->active = $request->input('active', 0);
            $user->permit_recieve_emails = $request->input('permit_recieve_emails', 0);
            if (!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->userProfile->first_name = $request->input('user_profile.first_name');
            $user->userProfile->last_name = $request->input('user_profile.last_name');

            if (empty($user->password_changed_at) && $request->password_changed_at == 1) {
                $user->password_changed_at = Carbon::now();
            } elseif ($request->password_changed_at != 1) {
                $user->password_changed_at = null;
            }
            if (empty($user->email_verified_at) && $request->email_verified_at == 1) {
                $user->email_verified_at = Carbon::now();
            } elseif ($request->email_verified_at != 1) {
                $user->email_verified_at = null;
            }

            $user->push();

            DB::commit();
            $allowEmail = SettingsServices::allowEmails();
            if ($allowEmail) {
                //cambiar config del .env
                $setConfiguration = SettingsServices::setSmtpConfiguration();

                // SendUserRegistrationEmailJob::dispatch($user, $request->input('password'));
            }
    

            return redirect()->route('admin.users.edit', [$user->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('admin.users.edit', [$user->id])->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }

    public function store(AdminUserRequest $request)
    {
        if (!auth()->user()->isAbleTo('admin-users-create')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $user = new User();

            $user->email = $request->input('email');
            $user->active = $request->input('active', 0);
            $user->permit_recieve_emails = $request->input('permit_recieve_emails', 0);
            $user->email_verified_at = Carbon::now();
            if (!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }
            if (empty($user->password_changed_at) && $request->password_changed_at == 1) {
                $user->password_changed_at = Carbon::now();
            } elseif ($request->password_changed_at != 1) {
                $user->password_changed_at = null;
            }
            if (empty($user->email_verified_at) && $request->email_verified_at == 1) {
                $user->email_verified_at = Carbon::now();
            } elseif ($request->email_verified_at != 1) {
                $user->email_verified_at = null;
            }
            $user->save();

            if (!empty($user->id)) {

                $userProfile = new UserProfile();

                $userProfile->user_id = $user->id;
                $userProfile->first_name = $request->input('user_profile.first_name');
                $userProfile->last_name = $request->input('user_profile.last_name');
                $userProfile->save();
            }

            DB::commit();
            $allowEmail = SettingsServices::allowEmails();


            if ($allowEmail) {
                //cambiar config del .env
                $setConfiguration = SettingsServices::setSmtpConfiguration();

                SendUserRegistrationEmailJob::dispatch($user, $request->input('password'));
            }

            return redirect()->route('admin.users.edit', [$user->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/users/create'); // ->with('error-alert', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }

    public function getData()
    {
        if (!auth()->user()->isAbleTo('admin-users-list')) {
            app()->abort(403);
        }
        $query = User::select([
            'users.id',
            'users.email',
            'users.active',
            'user_profiles.first_name',
            'user_profiles.last_name',
            DB::raw('CONCAT(user_profiles.first_name, " ", user_profiles.last_name) as fullname'),

        ])
            // ->notPatients()
            ->distinct()
            ->leftJoin("user_profiles", "user_profiles.user_id", "=", "users.id")
            ->leftJoin("role_user", "role_user.user_id", "=", "users.id")
            ->leftJoin("roles", "roles.id", "=", "role_user.role_id")
           ;

        $this->addFilter($query);

        $table = DataTables::of($query);

        $table->filterColumn('fullname', function ($query, $keyword) {
            $query->whereRaw("CONCAT(user_profiles.first_name,' ',user_profiles.last_name) like ?", ["%{$keyword}%"]);
        });

        $table->editColumn('active', function ($data) {
            $permision = "";
            if (!auth()->user()->isAbleTo('admin-users-update')) {
                $permision = "disabled";
            }

            $state = $data->active ? "checked" : "";

            return  '<div class="form-check form-switch text-center">
                <input class="form-check-input" onclick="changeState(' . $data->id . ')" ' . $state . '  ' . $permision . '  value="1" name="active" type="checkbox" id="active">
            </div>';
        });
      

        $table->editColumn('roles', function ($data) {

            $user = User::find($data->id);
            return implode(", ", $user->roles->pluck('display_name')->toArray());
        });

        $table->editColumn('actions', function ($data) {
            $actions = '';
            if (auth()->user()->isAbleTo("admin-users-read")) {
                $actions .= '<a  class="btn btn-info btn-xs" data-bs-content="' . trans('general/admin_lang.show') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.users.show', $data->id) . '" ><i
                class="fa fa-eye fa-lg"></i></a> ';
            }
            if (auth()->user()->isAbleTo("admin-users-update")) {
                $actions .= '<a  class="btn btn-primary btn-xs" data-bs-content="' . trans('general/admin_lang.edit') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.users.edit', $data->id) . '" ><i
                class="fa fa-marker fa-lg"></i></a> ';
            }

            if (auth()->user()->isAbleTo("admin-users-delete")) {

                $actions .= '<button class="btn btn-danger btn-xs" data-bs-content="' . trans('general/admin_lang.delete') . '" data-bs-placement="left" data-bs-toggle="popover" onclick="javascript:deleteElement(\'' .
                    url('admin/users/' . $data->id) . '\');" data-content="' .
                    trans('general/admin_lang.borrar') . '" data-placement="left" data-toggle="popover">
                        <i class="fa fa-trash" aria-hidden="true"></i></button>';
            }
            if (auth()->user()->isAbleTo("admin-users-suplant-identity") && auth()->user()->id != $data->id) {

                $actions .= '<a  class="btn btn-primary btn-xs ms-1"  data-bs-content="' . trans('general/admin_lang.suplant') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.suplantar', $data->id) . '" ><i
                class="fa fa-user-secret" ></i></a> ';
            }

            return $actions;
        });

        $table->removeColumn('id');
        $table->rawColumns(['actions', 'active']);
        return $table->make();
    }

    public function saveFilter(Request $request)
    {
        $this->clearSesions($request);

        if (!empty($request->role_id) > 0)
            $request->session()->put('users_filter_role_id', $request->role_id);



        return redirect('admin/users');
    }
    private function clearSesions($request)
    {
        $request->session()->forget('users_filter_role_id');
    }

    public function removeFilter(Request $request)
    {
        $this->clearSesions($request);
        return redirect('admin/users');
    }

    private function addFilter(&$query)
    {

        if (!empty($this->filtRoleId)) {
            $query->whereIn("roles.id", $this->filtRoleId);
        }
        
    }

    public function destroy($id)
    {
        // Si no tiene permisos para modificar lo echamos
        if (!auth()->user()->isAbleTo('admin-users-delete')) {
            app()->abort(403);
        }
        $user = User::find($id);
        if (empty($user)) {
            app()->abort(404);
        }

        $user->delete();

        return response()->json(array(
            'success' => true,
            'msg' => trans("general/admin_lang.delete_ok"),
        ));
    }

    public function changeState($id)
    {
        if (!auth()->user()->isAbleTo('admin-users-update')) {
            app()->abort(403);
        }

        $user = User::find($id);

        if (!empty($user)) {
            $user->active = !$user->active;
            return $user->save() ? 1 : 0;
        }

        return 0;
    }

    public function editRoles($id)
    {
        if (!auth()->user()->isAbleTo('admin-users-update')) {
            app()->abort(403);
        }
        $user = User::find($id);
        if (is_null($user)) {
            app()->abort(500);
        }
        $pageTitle = trans('users/admin_lang.users');
        $title = trans('users/admin_lang.list');

        $roles = Role::active()->where("roles.can_show", 1)->get();
        $tab = "tab_2";
        return view('users.admin_edit_roles', compact(
            'pageTitle',
            'title',
            "user",
            'roles'
        ))
            ->with('tab', $tab);
    }

    public function showRoles($id)
    {
        if (!auth()->user()->isAbleTo('admin-users-read')) {
            app()->abort(403);
        }
        $user = User::find($id);
        if (is_null($user)) {
            app()->abort(500);
        }
        $pageTitle = trans('users/admin_lang.users');
        $title = trans('users/admin_lang.list');


        $roles = Role::active()->where("roles.can_show", 1)->get();
        $tab = "tab_2";

        $disabled = "disabled";
        return view('users.admin_edit_roles', compact(
            'pageTitle',
            'title',
            "user",
            "disabled",
            'roles'
        ))
            ->with('tab', $tab);
    }

    public function updateRoles(Request $request, $id)
    {

        if (!auth()->user()->isAbleTo('admin-users-update')) {
            app()->abort(403);
        }

        $user = User::find($id);

        if (is_null($user)) {
            app()->abort(500);
        }
        $idroles = explode(",", $request->input('role_ids'));
        try {
            DB::beginTransaction();
            $user->syncRoles($idroles);
            DB::commit();


            // Y Devolvemos una redirección a la acción show para mostrar el usuario
            return redirect()->to('/admin/users/roles/' . $user->id)->with('success', trans('general/admin_lang.save_ok'));
        } catch (\PDOException $e) {
            DB::rollBack();
            dd($e);

            return redirect()->to('/admin/users/roles/' . $user->id);
            // ->with('error-alert', trans('general/admin_lang.save_ko'));
        }
    }

   


    public function ShowPersonalInfo($id)
    {
        if (!auth()->user()->isAbleTo('admin-users-read')) {
            app()->abort(403);
        }
        //Obtengo la información del usuario para pasarsela al formulario
        $user = User::with('userProfile')->find($id);
        $tab = 'tab_4';
        $pageTitle =  trans('profile/admin_lang.my_profile');
        $title =  trans('profile/admin_lang.personal_information');

        $genders = [
            "male" => trans("general/admin_lang.male"),
            "female" => trans("general/admin_lang.female")
        ];

        $provincesList = Province::active()->get();
        $municipiosList = Municipio::active()->where("province_id", $user->userProfile->province_id)->get();

        $disabled = "disabled";
        return view(
            'users.admin_edit_personal_info',
            compact(
                'pageTitle',
                'title',
                'user',
                'provincesList',
                'municipiosList',
                'disabled',
                'genders'
            )
        )->with('tab', $tab);
    }
    public function personalInfo($id)
    {
        if (!auth()->user()->isAbleTo('admin-users-update')) {
            app()->abort(403);
        }
        //Obtengo la información del usuario para pasarsela al formulario
        $user = User::with('userProfile')->find($id);
        $tab = 'tab_4';
        $pageTitle =  trans('profile/admin_lang.my_profile');
        $title =  trans('profile/admin_lang.personal_information');

        $genders = [
            "male" => trans("general/admin_lang.male"),
            "female" => trans("general/admin_lang.female")
        ];

        $provincesList = Province::active()->get();
        $municipiosList = Municipio::active()->where("province_id", $user->userProfile->province_id)->get();

        return view(
            'users.admin_edit_personal_info',
            compact(
                'pageTitle',
                'title',
                'user',
                'provincesList',
                'municipiosList',
                'genders'
            )
        )->with('tab', $tab);
    }

    public function updatePersonalInfo(Request $request, $id)
    {
        if (!auth()->user()->isAbleTo('admin-users-update')) {
            app()->abort(403);
        }
        // Id actual
        // Creamos un nuevo objeto para nuestro nuevo usuario
        $user = User::with('userProfile')->find($id);
        // dd($user);
        // Si el usuario no existe entonces lanzamos un error 404 :(
        if (is_null($user)) {
            app()->abort(404);
        }

        try {
            DB::beginTransaction();

            $user->userProfile->birthday = !empty($request->input('user_profile.birthday')) ? Carbon::createFromFormat("d/m/Y", $request->input('user_profile.birthday'))->format("Y-m-d") : null;
            $user->userProfile->identification = $request->input('user_profile.identification');
            $user->userProfile->phone = $request->input('user_profile.phone');
            $user->userProfile->mobile = $request->input('user_profile.mobile');
            $user->userProfile->gender = $request->input('user_profile.gender');
            $user->userProfile->province_id = $request->input('user_profile.province_id');
            $user->userProfile->municipio_id = $request->input('user_profile.municipio_id');
            $user->userProfile->address = $request->input('user_profile.address');

            $user->userProfile->save();

            // Redirect to the new user page
            DB::commit();


            // Y Devolvemos una redirección a la acción show para mostrar el usuario
            return redirect('admin/users/personal-info/' . $id)->with('success', trans('general/admin_lang.save_ok'));
        } catch (\PDOException $e) {
            // Woopsy
            dd($e);
            DB::rollBack();

            return redirect('users'); // ->with('error-alert', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }

  
}
