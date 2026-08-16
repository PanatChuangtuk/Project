<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Storage, Auth, Validator, Log};
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
    try {

        // ตรวจสอบสิทธิ์ Admin
        $admin = Member::select('id', 'role')
            ->where('id', Auth::guard('web')->user()->id)
            ->first();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์ในการเพิ่มคู่มือการใช้งาน'
            ], 403);
        }

        // Validate
        $request->validate([
            'name' => 'required|string|max:255',

            'video' => [
                'required',
                'file',
                'mimes:mp4,webm,ogg,mov,wmv',
                'max:512000',
            ],

        ], [

            'name.required' =>
                'กรุณากรอกชื่อคู่มือการใช้งาน',

            'video.required' =>
                'กรุณาอัปโหลดวิดีโอ',

            'video.file' =>
                'ไฟล์วิดีโอไม่ถูกต้อง',

            'video.mimes' =>
                'รองรับเฉพาะไฟล์ MP4, WEBM, OGG, MOV และ WMV',

            'video.max' =>
                'ขนาดไฟล์ต้องไม่เกิน 500 MB',

        ]);

        // ตรวจสอบไฟล์
        if (!$request->hasFile('video')) {

            return response()->json([
                'success' => false,
                'message' => 'ไม่พบไฟล์วิดีโอ'
            ], 422);
        }

        $file = $request->file('video');

        if (!$file->isValid()) {

            return response()->json([
                'success' => false,
                'message' => 'ไฟล์วิดีโอไม่สมบูรณ์'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | สร้างชื่อไฟล์
        |--------------------------------------------------------------------------
        */

        $name = trim($request->input('name'));

        // ป้องกันอักขระพิเศษในชื่อไฟล์
        $name = preg_replace(
            '/[\/\\\\:*?"<>|]/',
            '',
            $name
        );

        // ถ้าชื่อว่างหลังจากลบอักขระ
        if (!$name) {
            $name = 'video_' . time();
        }

        /*
        |--------------------------------------------------------------------------
        | สร้างชื่อไฟล์
        |--------------------------------------------------------------------------
        */

        $filename =
            $name . '_' .
            time() . '.' .
            $file->getClientOriginalExtension();

        /*
        |--------------------------------------------------------------------------
        | บันทึกไฟล์
        |--------------------------------------------------------------------------
        */

        $path = $file->storeAs(
            'file/admin/video',
            $filename,
            'public'
        );

        /*
        |--------------------------------------------------------------------------
        | ตรวจสอบว่าบันทึกสำเร็จจริง
        |--------------------------------------------------------------------------
        */

        if (!$path) {

            return response()->json([
                'success' => false,
                'message' => 'ไม่สามารถบันทึกไฟล์วิดีโอได้'
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | บันทึก Database
        |--------------------------------------------------------------------------
        */

        $guide = Guide::create([
            'video_name' => $name,
            'link_video' => $path,
            'status' => $request->input('status', 1),
            'created_by' => $admin->id,
            'created_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Response สำหรับ Uppy
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'เพิ่มคู่มือการใช้งานสำเร็จ',
            'url' => Storage::disk('public')->url($path),
            'path' => $path,
            'id' => $guide->id,
        ], 200);

    } catch (\Throwable $e) {

        Log::error('Guide video upload error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'เกิดข้อผิดพลาดในการอัปโหลดวิดีโอ',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $guide = Guide::find($id);
        return view('administrator.guide.edit', compact('guide', 'main_menu'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',

        'video' => [
            'nullable',
            'file',
            'mimes:mp4,mov,wmv',
            'max:512000',
        ],

    ], [

        'name.required' =>
            'กรุณากรอกชื่อคู่มือการใช้งาน',

        'video.file' =>
            'ไฟล์วิดีโอไม่ถูกต้อง',

        'video.mimes' =>
            'รองรับเฉพาะไฟล์ MP4, MOV และ WMV',

        'video.max' =>
            'ขนาดไฟล์ต้องไม่เกิน 500 MB',

    ]);


    $guide = Guide::findOrFail($id);


    /*
    |--------------------------------------------------------------------------
    | ชื่อวิดีโอ
    |--------------------------------------------------------------------------
    */

    $name = trim($request->name);


    // ป้องกันอักขระที่ใช้เป็นชื่อไฟล์ไม่ได้
    $name = preg_replace(
        '/[\/\\\\:*?"<>|]/',
        '',
        $name
    );


    /*
    |--------------------------------------------------------------------------
    | ถ้ามีการอัปโหลดวิดีโอใหม่
    |--------------------------------------------------------------------------
    */
if ($request->hasFile('video')) {

    $file = $request->file('video');

    $filename =
        $name . '.' .
        $file->getClientOriginalExtension();

    // บันทึกไฟล์ใหม่ก่อน
    $path = $file->storeAs(
        'file/admin/video',
        $filename,
        'public'
    );

    // ถ้าบันทึกใหม่สำเร็จ ค่อยลบไฟล์เก่า
    if (
        $guide->link_video &&
        Storage::disk('public')->exists($guide->link_video)
    ) {
        Storage::disk('public')->delete($guide->link_video);
    }

    $guide->link_video = $path;
}

    /*
    |--------------------------------------------------------------------------
    | Update Database
    |--------------------------------------------------------------------------
    */

    $guide->update([

        'video_name' =>
            $name,

        'link_video' =>
            $guide->link_video,

        'status' =>
            $request->input('status', 0),

        'updated_at' =>
            now(),

    ]);


    /*
    |--------------------------------------------------------------------------
    | ถ้าเป็น Krajee Upload
    |--------------------------------------------------------------------------
    */

    if ($request->ajax()) {

        return response()->json([

            'success' => true,

            'message' =>
                'แก้ไขคู่มือการใช้งานสำเร็จ',

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | ถ้าไม่มีไฟล์ใหม่และ Submit Form ปกติ
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('administrator.guide')
        ->with(
            'success',
            'แก้ไขคู่มือการใช้งานสำเร็จ'
        );
}
    public function destroy($id, Request $request)
    {
        $about = Guide::findOrFail($id);
        $about->delete();
        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.guide', ['page' => $currentPage])->with([
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
