<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Storage, Auth, Log};
use Illuminate\Http\{Request, UploadedFile};
use App\Models\Guide;


class GuideController extends Controller
{
    private $main_menu = 'guide';

    private const VIDEO_DIR = 'file/admin/video';

    private const VIDEO_RULES = ['file', 'mimes:mp4,webm,ogg,mov,wmv', 'max:512000'];

    private const VIDEO_MESSAGES = [
        'name.required' => 'กรุณากรอกชื่อคู่มือการใช้งาน',
        'video.required' => 'กรุณาอัปโหลดวิดีโอ',
        'video.file' => 'ไฟล์วิดีโอไม่ถูกต้อง',
        'video.mimes' => 'รองรับเฉพาะไฟล์ MP4, WEBM, OGG, MOV และ WMV',
        'video.max' => 'ขนาดไฟล์ต้องไม่เกิน 500 MB',
    ];

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
        $admin = Auth::guard('web')->user();

        if ($admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์ในการเพิ่มคู่มือการใช้งาน'
            ], 403);
        }

        // validate อยู่นอก try เพื่อให้ Laravel ตอบ 422 พร้อม errors ตามปกติ
        $request->validate([
            'name' => 'required|string|max:255',
            'video' => ['required', ...self::VIDEO_RULES],
        ], self::VIDEO_MESSAGES);

        try {
            $name = $this->sanitizeName($request->input('name'));
            $path = $this->storeVideo($request->file('video'), $name);

            if (!$path) {
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่สามารถบันทึกไฟล์วิดีโอได้'
                ], 500);
            }

            $guide = Guide::create([
                'video_name' => $name,
                'link_video' => $path,
                'status' => $request->input('status', 1),
                'created_by' => $admin->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'เพิ่มคู่มือการใช้งานสำเร็จ',
                'url' => asset('upload/' . $path),
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
            ], 500);
        }
    }

    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $guide = Guide::findOrFail($id);
        return view('administrator.guide.edit', compact('guide', 'main_menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'video' => ['nullable', ...self::VIDEO_RULES],
        ], self::VIDEO_MESSAGES);

        $guide = Guide::findOrFail($id);
        $name = $this->sanitizeName($request->input('name'));
        $linkVideo = $guide->link_video;

        if ($request->hasFile('video')) {
            // บันทึกไฟล์ใหม่ (ชื่อไม่ซ้ำไฟล์เดิม) ก่อน แล้วค่อยลบไฟล์เก่า
            $path = $this->storeVideo($request->file('video'), $name);

            if ($path) {
                $this->deleteVideoFile($linkVideo);
                $linkVideo = $path;
            }
        }

        $guide->update([
            'video_name' => $name,
            'link_video' => $linkVideo,
            'status' => $request->input('status', 0),
            'updated_by' => Auth::guard('web')->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'แก้ไขคู่มือการใช้งานสำเร็จ',
            ]);
        }

        return redirect()
            ->route('administrator.guide')
            ->with('success', 'แก้ไขคู่มือการใช้งานสำเร็จ');
    }

    public function destroy($id, Request $request)
    {
        $guide = Guide::findOrFail($id);
        $this->deleteVideoFile($guide->link_video);
        $guide->forceDelete();

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
            Guide::whereIn('id', $ids)->get()->each(function (Guide $guide) {
                $this->deleteVideoFile($guide->link_video);
                $guide->forceDelete();
            });

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

    private function sanitizeName(?string $name): string
    {
        // ลบอักขระที่ใช้เป็นชื่อไฟล์ไม่ได้
        $name = preg_replace('/[\/\\\\:*?"<>|]/', '', trim((string) $name));

        return $name !== '' ? $name : 'video_' . time();
    }

    private function storeVideo(UploadedFile $file, string $name): string|false
    {
        $filename = $name . '_' . time() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs(self::VIDEO_DIR, $filename, 'public');
    }

    private function deleteVideoFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
