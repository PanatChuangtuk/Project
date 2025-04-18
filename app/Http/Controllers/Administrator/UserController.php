<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\{Member, MemberInfo};
use Illuminate\Http\Request;
use App\Http\Requests\{MemberCreateRequest, MemberUpdateRequest};

class UserController extends Controller
{
    private $main_menu = 'user';
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = Member::with('info')->where('role', 'user')->where('status', 1);

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
        $main_menu = $this->main_menu;
        return view('administrator.user.index', compact('users', 'query', 'main_menu'));
    }

    public function add()
    {
        $main_menu = $this->main_menu;
        return view('administrator.user.add', compact('main_menu'));
    }

    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $admin = Member::find($id);
        return view('administrator.user.edit', compact('admin', 'main_menu'));
    }

    public function submit(MemberCreateRequest  $request)
    {
        // dd($request->all());
        $member = Member::create([
            // 'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => $request->status ?? 0,
        ]);
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'admin');
        }
        MemberInfo::create([
            'member_id' => $member->id,
            'adviser_id' => $request->adviser_id,
            'student_id' => $request->student_id,
            'first_name' =>  $request->first_name,
            'last_name' =>  $request->last_name,
            'mobile_phone' => $request->mobile_phone,
            'avatar' => $filename
        ]);
        return redirect()->back()
            ->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
    }

    public function update(MemberUpdateRequest $request, $id)
    {
        // dd($request->all());
        $member = Member::find($id);
        $member->update([
            // 'username' => $request->username,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $member->password,
            'role' => 'user',
            'status' => $request->status ?? 0,
        ]);

        $filename = $member->info->avatar;
        if ($request->hasFile('image')) {
            $filename = $this->uploadsImage($request->file('image'), 'admin');
        }

        $member->info->update([
            'adviser_id' => $request->adviser_id ?? $member->info->adviser_id,
            'student_id' => $request->student_id ?? $member->info->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_phone' => $request->mobile_phone,
            'avatar' => $filename,
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกอัพเดตเรียบร้อยแล้ว');
    }
    public function destroy($id, Request $request)
    {
        $about = Member::findOrFail($id);
        $about->forceDelete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.user', ['page' => $currentPage])->with([
            'success' => 'About deleted successfully!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Member::whereIn('id', $ids)->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Selected about have been deleted successfully.',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No about selected for deletion.'
        ], 400);
    }
}
