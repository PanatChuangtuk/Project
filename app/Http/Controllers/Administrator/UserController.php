<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = User::with('role');

        if ($query) {
            $userQuery->where('name', 'LIKE', "%{$query}%");
        }

        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);

        // $roles = Role::all();

        return view('administrator.users.index', compact('users', 'query'));
    }



    public function add()
    {
        return view('administrator.users.add');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('administrator.users.edit', compact('user'));
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('administrator.users');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('administrator.users');
    }

    public function destroy($id, Request $request)
    {
        $user = User::findOrFail($id);

        $role = $user->role;
        $user->delete();

        if ($role) {
            $role->decrement('user_count');
        }

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.users', ['page' => $currentPage])->with([
            'success' => 'User deleted successfully!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            $users = User::whereIn('id', $ids)->with('role')->get();

            foreach ($users as $user) {
                $role = $user->role;
                $user->delete();

                if ($role) {
                    $role->decrement('user_count');
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Selected users have been deleted successfully.',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No users selected for deletion.'
        ], 400);
    }
}
