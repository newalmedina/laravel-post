<?php

namespace App\Http\Livewire\Roles;

use App\Models\PermissionsTree;
use App\Models\Role;
use Livewire\Component;

class RoleComponent extends Component
{
    public $view = '';
    public $selectedRole = null;
    public   $a_arrayPermisos = [];
    public   $permissionsTree = [];
    public function __construct()
    {
        $this->title =  trans('roles/admin_lang.list');
    }


    public function render()
    {
        $roles = Role::orderBy('id', 'desc')->paginate(10);
        return view('livewire.roles.role-component', compact("roles"));
    }
    public function edit($id)
    {
        $this->selectedRole = Role::find($id);
        $this->display_name = $this->selectedRole->name;
        $this->description = $this->selectedRole->description;

        $this->permissionsTree = PermissionsTree::withDepth()->with('permission')->get()->sortBy('_lft');

        $this->a_arrayPermisos = $this->selectedRole->getArrayPermissions();

        $this->view = 'edit';
    }
}
