<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = Student::query();

        if ($query) {
            $userQuery->where('firstname', 'LIKE', "%{$query}%");
        }

        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);


        return view('administrator.student.index', compact('users', 'query'));
    }



    // public function add()
    // {
    //     return view('administrator.users.add');
    // }

    // public function edit($id)
    // {
    //     $user = Member::find($id);
    //     return view('administrator.users.edit', compact('user'));
    // }

    // public function submit(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'role_id' => 'required|exists:roles,id',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     Member::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role_id' => $request->role_id,
    //     ]);

    //     return redirect()->route('administrator.users');
    // }

    // public function update(Request $request, $id)
    // {
    //     $user = Member::find($id);
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255',
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'role_id' => 'required|exists:roles,id',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $user->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role_id' => $request->role_id,
    //         'password' => $request->password ? Hash::make($request->password) : $user->password,
    //     ]);

    //     return redirect()->route('administrator.users');
    // }
    public function import(Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {

            $path = $request->file('file')->getRealPath();

            Excel::import(new MembersImport, $path);

            return redirect()->back()->with('success', 'Data imported successfully.');
        }

        return redirect()->back()->with('error', 'No valid file selected.');
    }
}
