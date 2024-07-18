<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRoleRequest;
use App\Models\PermissionsTree;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AdminRoleController extends Controller
{


    public function index()
    {
        if (!auth()->user()->isAbleTo('admin-roles')) {
            app()->abort(403);
        }


        $pageTitle = trans('roles/admin_lang.roles');
        $title = trans('roles/admin_lang.list');
        $roles = Role::orderBy('id', 'asc')->get();

        return view('roles.admin_index', compact('pageTitle', 'title', "roles"));
    }

    public function create()
    {
        if (!auth()->user()->isAbleTo('admin-roles-create')) {
            app()->abort(403);
        }

        $pageTitle = trans('roles/admin_lang.roles');
        $title = trans('roles/admin_lang.list');
        $role = new Role();
        $tab = 'tab_1';
        return view('roles.admin_edit', compact('pageTitle', 'title', "role"))
            ->with('tab', $tab);
    }
    public function store(AdminRoleRequest $request)
    {
        if (!auth()->user()->isAbleTo('admin-roles-create')) {
            app()->abort(403);
        }

        $role = new Role();
        $role->name = Str::slug($request->display_name);
        $role->can_delete = 1;
        $role->can_show = 1;

        $this->saveRole($role, $request);


        return redirect()->route('admin.roles.edit', [$role->id])->with('success', trans('general/admin_lang.save_ok'));
    }
    public function edit($id)
    {
        if (!auth()->user()->isAbleTo('admin-roles-update')) {
            app()->abort(403);
        }
        $pageTitle = trans('roles/admin_lang.roles');
        $title = trans('roles/admin_lang.list');
        $role = Role::find($id);
        $tab = 'tab_1';
        return view('roles.admin_edit', compact('pageTitle', 'title', "role"))
            ->with('tab', $tab);
    }

    public function update(AdminRoleRequest $request, $id)
    {
        if (!auth()->user()->isAbleTo('admin-roles-update')) {
            app()->abort(403);
        }

        $role = Role::find($id);
        $this->saveRole($role, $request);


        return redirect()->route('admin.roles.edit', [$role->id])->with('success', trans('general/admin_lang.save_ok'));
    }

    private function saveRole($role, $request)
    {

        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->active = isset($request->active) ? $request->active : 0;
        $role->save();
        return $role;
    }

    public function editPermissions($id)
    {
        if (!auth()->user()->isAbleTo('admin-roles-update')) {
            app()->abort(403);
        }

        $pageTitle = trans('roles/admin_lang.roles');
        $title = trans('roles/admin_lang.list');

        $permissionsTree = PermissionsTree::withDepth()->with('permission')->get()->sortBy('_lft');

        $role = Role::find($id);
        $a_arrayPermisos = $role->getArrayPermissions();

        if (is_null($role)) {
            app()->abort(500);
        }
        $tab = "tab_2";
        return view('roles.admin_edit_permissions', compact(
            'pageTitle',
            'title',
            'a_arrayPermisos',
            'permissionsTree',
            "role"
        ))
            ->with('tab', $tab);
    }

    public function updatePermissions(Request $request, $id)
    {
        if (!auth()->user()->isAbleTo('admin-roles-update')) {
            app()->abort(403);
        }

        $idpermissions = explode(",", $request->input('results'));


        // Compruebo que el rol al que se quieren asignar datos existe
        $role = Role::find($id);

        if (is_null($role)) {
            app()->abort(500);
        }
        try {
            DB::beginTransaction();

            // Asigno el array de permisos al rol
            $role->syncPermissions($idpermissions);

            DB::commit();

            // Y Devolvemos una redirección a la acción show para mostrar el usuario
            return redirect()->to('/admin/roles/permissions/' . $role->id)->with('success', trans('general/admin_lang.save_ok'));
        } catch (\PDOException $e) {
            DB::rollBack();
            dd($e);

            return redirect()->to('/admin/roles/permissions/' . $role->id);
            // ->with('error-alert', trans('general/admin_lang.save_ko'));
        }
    }

    public function getData()
    {

        if (!auth()->user()->isAbleTo('admin-roles-list')) {
            app()->abort(403);
        }
        $query = Role::select([
            'roles.active',
            'roles.id',
            'roles.display_name',
            'roles.can_delete',
            'roles.description',

        ])->where("roles.can_show", 1);

        $table = DataTables::of($query);

        $table->editColumn('active', function ($data) {
            $permision = "";
            if (!auth()->user()->isAbleTo('admin-roles-update')) {
                $permision = "disabled";
            }

            $state = $data->active ? "checked" : "";

            return  '<div class="form-check form-switch ">
                <input class="form-check-input" onclick="changeState(' . $data->id . ')" ' . $state . '  ' . $permision . '  value="1" name="active" type="checkbox" id="active">
            </div>';
        });


        $table->editColumn('actions', function ($data) {
            $actions = '';
            if (auth()->user()->isAbleTo("admin-roles-update")) {
                $actions .= '<a  class="btn btn-primary btn-xs" data-bs-content="' .trans('general/admin_lang.edit') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.roles.edit', $data->id) . '" ><i
                class="fa fa-marker fa-lg"></i></a> ';
            }

            if (auth()->user()->isAbleTo("admin-roles-delete") && $data->can_delete) {

                $actions .= '<button class="btn btn-danger btn-xs" data-bs-content="' .trans('general/admin_lang.delete'). '" data-bs-placement="left" data-bs-toggle="popover" onclick="javascript:deleteElement(\'' .
                    url('admin/roles/' . $data->id) . '\');" data-content="' .
                    trans('general/admin_lang.borrar') . '" data-placement="left" data-toggle="popover">
                        <i class="fa fa-trash" aria-hidden="true"></i></button>';
            }

            return $actions;
        });

        $table->removeColumn(['id', "can_delete"]);
        $table->rawColumns(['actions', 'active']);
        return $table->make();
    }

    public function destroy($id)
    {
        // Si no tiene permisos para modificar lo echamos
        if (!auth()->user()->isAbleTo('admin-roles-delete')) {
            app()->abort(403);
        }
        $role = Role::find($id);
        if (empty($role)) {
            app()->abort(404);
        }

        $role->delete();

        return response()->json(array(
            'success' => true,
            'msg' => trans("general/admin_lang.delete_ok"),
        ));
    }

    public function changeState($id)
    {
        if (!auth()->user()->isAbleTo('admin-roles-update')) {
            app()->abort(403);
        }

        $role = Role::find($id);

        if (!empty($role)) {
            $role->active = !$role->active;
            return $role->save() ? 1 : 0;
        }

        return 0;
    }
}
