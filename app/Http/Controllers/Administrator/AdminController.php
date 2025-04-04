<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\{Member, MemberInfo};
use Illuminate\Http\Request;
// use App\Imports\UsersImport;
// use App\Exports\UsersExport;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = Member::where('role', 'admin');

        if ($query) {
            $userQuery->where('name', 'LIKE', "%{$query}%");
        }

        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        return view('administrator.admin.index', compact('users', 'query'));
    }



    public function add()
    {
        return view('administrator.admin.add');
    }

    public function edit($id)
    {
        $admin = Member::find($id);
        return view('administrator.admin.edit', compact('admin'));
    }

    public function submit(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            // 'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:member,email',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ], [
            // 'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            // 'username.string' => 'ชื่อผู้ใช้ต้องเป็นตัวอักษร',
            // 'username.max' => 'ชื่อผู้ใช้ต้องไม่เกิน 255 ตัวอักษร',
            'email.required' => 'กรุณากรอกอีเมล์',
            'email.email' => 'กรุณากรอกอีเมล์ให้ถูกต้อง',
            'email.max' => 'อีเมล์ต้องไม่เกิน 255 ตัวอักษร',
            'email.unique' => 'อีเมล์นี้ถูกใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.string' => 'รหัสผ่านต้องเป็นตัวอักษร',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกัน',
            'image.required' => 'กรุณาอัพโหลดภาพ',
            'image.mimes' => 'ภาพที่อัพโหลดต้องเป็นไฟล์ประเภท jpeg, png, jpg',
            'image.max' => 'ขนาดไฟล์ภาพต้องไม่เกิน 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $member = Member::create([
            // 'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => $request->status ?? 0,
        ]);
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'admin');
        }
        MemberInfo::create([
            'member_id' => $member->id,
            'adviser_id' => 0,
            'student_id' => 0,
            'first_name' =>  $request->first_name,
            'last_name' =>  $request->last_name,
            'mobile' => $request->mobile_phone,
            'avatar' => $filename
        ]);
        return redirect()->back()
            ->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
    }

    public function update(Request $request, $id)
    {
        $member = Member::find($id);
        $validator = Validator::make($request->all(), [
            // 'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ], [
            // 'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            // 'username.string' => 'ชื่อผู้ใช้ต้องเป็นตัวอักษร',
            // 'username.max' => 'ชื่อผู้ใช้ต้องไม่เกิน 255 ตัวอักษร',
            'email.required' => 'กรุณากรอกอีเมล์',
            'email.email' => 'กรุณากรอกอีเมล์ให้ถูกต้อง',
            'email.max' => 'อีเมล์ต้องไม่เกิน 255 ตัวอักษร',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.string' => 'รหัสผ่านต้องเป็นตัวอักษร',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกัน',
            'image.mimes' => 'ภาพที่อัพโหลดต้องเป็นไฟล์ประเภท jpeg, png, jpg',
            'image.max' => 'ขนาดไฟล์ภาพต้องไม่เกิน 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $member->update([
            // 'username' => $request->username,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $member->password,
            'role' => 'admin',
            'status' => $request->status ?? 0,
        ]);

        $filename = $member->info->avatar;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'admin');
        }

        $member->info->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile_phone,
            'avatar' => $filename,
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกอัพเดตเรียบร้อยแล้ว');
    }
}
