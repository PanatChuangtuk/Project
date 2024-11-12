<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
{
    $roles = Role::withCount('users')->paginate(10);
    $permissions = Permission::all();

    return view('administrator.roles.index', compact('roles', 'permissions'));
}

public function updatePermissions(Request $request)
{
    $request->validate([
        'permissions' => 'array',
    ]);

    foreach ($request->input('permissions') as $roleId => $perms) {
        $role = Role::findOrFail($roleId);
        $role->permissions()->sync($perms);
    }

    return redirect()->route('administrator.roles.index')->with('success', 'Permissions updated successfully.');
}


    public function create() 
    {
        return view('administrator.roles.create'); 
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create($request->all());
        return redirect()->route('administrator.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('administrator.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $role->update($request->all());
        return redirect()->route('administrator.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id, Request $request)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('administrator.roles.index')->with('success', 'Role deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Role::whereIn('id', $ids)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Selected roles have been deleted successfully.',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No roles selected for deletion.'
        ], 400);
    }
}
