<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Student;
use Rap2hpoutre\FastExcel\FastExcel;

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
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        $file = $request->file('file');

        $filePath = $file->storeAs('file/product', $file->getClientOriginalName(), 'public');
        $filePath = public_path('upload/' . $filePath);

        (new FastExcel)->import($filePath, function ($line) {
            return Student::updateOrCreate(
                ['student_number' => $line['student_number']],
                [
                    'first_name'   => $line['first_name'] ?? null,
                    'last_name'    => $line['last_name'] ?? null,
                    'mobile_phone' => $line['mobile_phone'] ?? null,
                    'status'       => 1,
                    'created_at'   => now(),
                ]
            );
        });
        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
