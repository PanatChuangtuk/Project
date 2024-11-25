<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('administrator.permissions.index', compact('roles', 'permissions'));
    }

    public function update(Request $request)
{
    $permissions = $request->input('permissions', []);

    foreach ($permissions as $permissionId => $roleIds) {
        $permission = Permission::find($permissionId);
        
        if ($permission) {
            $permission->roles()->sync($roleIds);
        }
    }

    $allPermissions = Permission::all();

    foreach ($allPermissions as $permission) {
        if (!isset($permissions[$permission->id])) {
            $permission->roles()->sync([]);
        }
    }

    return redirect()->route('administrator.permissions')->with('success', 'Permissions updated successfully.');
}

}
