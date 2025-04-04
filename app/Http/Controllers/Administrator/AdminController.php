<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\{Member, MemberInfo};
use Illuminate\Http\Request;
use App\Http\Requests\{MemberCreateRequest, MemberUpdateRequest};

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = Member::with('info')->where('role', 'admin');

        if ($query) {
            $userQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('email', 'LIKE', "%{$query}%")
                    ->orWhereHas('info', function ($infoQuery) use ($query) {
                        $infoQuery->where('first_name', 'LIKE', "%{$query}%")
                            ->orWhere('last_name', 'LIKE', "%{$query}%");
                    });
            });
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

    public function submit(MemberCreateRequest  $request)
    {
        // dd($request->all());
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

    public function update(MemberUpdateRequest $request, $id)
    {
        $member = Member::find($id);
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
