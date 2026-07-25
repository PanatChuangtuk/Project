<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, Auth, Validator};
use App\Models\{Guide, Member};
use Illuminate\Http\Request;


class GuideController extends Controller
{
    private $main_menu = 'guide';

    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = Guide::with(['creator.info']);
        if ($query) {
            $userQuery->where('video_name', 'LIKE', "%{$query}%");
        }
        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        // dd($users);
        $main_menu = $this->main_menu;
        return view('administrator.guide.index', compact('users', 'query', 'main_menu'));
    }

    public function add()
    {
        $main_menu = $this->main_menu;
        return view('administrator.guide.add', compact('main_menu'));
    }
    public function submit(Request $request)
    {
        $admin_id = Member::select('id', 'role')->where('id', Auth::guard('web')->user()->id)->first();
        if ($admin_id->role !== 'admin') {
            return redirect()->route('administrator.guide.add')->with('error', 'คุณไม่มีสิทธิ์ในการเพิ่มคู่มือการใช้งาน');
        }
        $request->validate([
            'name' => 'required',
            'link_video' => [
                'required',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/'
            ],
        ], [
            'name.required' => 'กรุณากรอกชื่อคู่มือการใช้งาน',
            'link_video.required' => 'กรุณากรอกลิงก์วิดีโอ',
            'link_video.url' => 'กรุณากรอกลิงก์วิดีโอที่ถูกต้อง',
            'link_video.regex' => 'กรุณากรอกเฉพาะลิงก์ที่มาจาก YouTube เท่านั้น',
        ]);


        // dd($admin_id);
        Guide::create([
            'video_name' => $request->input('name'),
            'link_video' => $request->input('link_video'),
            'status' => $request->input('status', 1),
            'created_by' => $admin_id->id,
            'created_at' => now(),
        ]);
        return redirect()->back()->with('success', 'เพิ่มคู่มือการใช้งานสำเร็จ');
    }
    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $guide = Guide::find($id);
        return view('administrator.guide.edit', compact('guide', 'main_menu'));
    }
    public function update(Request $request, $id)
    {
        $admin_id = Member::select('id', 'role')->where('id', Auth::guard('web')->user()->id)->first();
        if ($admin_id->role !== 'admin') {
            return redirect()->route('administrator.guide.index')->with('error', 'คุณไม่มีสิทธิ์ในการแก้ไขคู่มือการใช้งาน');
        }
        $request->validate([
            'name' => 'required',
            'link_video' => [
                'required',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/'
            ],
        ], [
            'name.required' => 'กรุณากรอกชื่อคู่มือการใช้งาน',
            'link_video.required' => 'กรุณากรอกลิงก์วิดีโอ',
            'link_video.url' => 'กรุณากรอกลิงก์วิดีโอที่ถูกต้อง',
            'link_video.regex' => 'กรุณากรอกเฉพาะลิงก์ที่มาจาก YouTube เท่านั้น',
        ]);
        $guide = Guide::find($id);
        $guide->update([
            'video_name' => $request->input('name'),
            'link_video' => $request->input('link_video'),
            'status' => $request->input('status', 1),
            'updated_by' => $admin_id->id,
            'updated_at' => now(),
        ]);

        return redirect()->route('administrator.guide')->with('success', 'แก้ไขคู่มือการใช้งานสำเร็จ');
    }
    public function destroy($id, Request $request)
    {
        $about = Guide::findOrFail($id);
        $about->delete();
        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.student', ['page' => $currentPage])->with([
            'success' => 'ข้อมูลถูกลบเรียบร้อยแล้ว!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Guide::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'ข้อมูลที่เลือกถูกลบเรียบร้อยแล้ว',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'ไม่มีข้อมูลที่เลือกสำหรับการลบ'
        ], 400);
    }
}
