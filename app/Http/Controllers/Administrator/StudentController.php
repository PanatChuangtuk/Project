<?php

namespace App\Http\Controllers\Administrator;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\{Validator, Log, DB};
use Illuminate\Http\Request;
use App\Models\{Student, Adviser, Member, MemberInfo};
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Requests\{StudentUpdateRequest, StudentCreatRequest};

class StudentController extends Controller
{
    private $main_menu = 'admin';
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = Student::query();

        if ($query) {
            $userQuery->where('first_name', 'LIKE', "%{$query}%")
                ->orWhere('last_name', 'LIKE', "%{$query}%")
                ->orWhere('student_number', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%");
        }

        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        $main_menu = $this->main_menu;
        return view('administrator.student.index', compact('users', 'query', 'main_menu'));
    }

    public function add()
    {
        $main_menu = $this->main_menu;
        return view('administrator.student.add', compact('main_menu'));
    }

    public function edit($id)
    {
        $main_menu = $this->main_menu;
        $student = Student::find($id);
        return view('administrator.student.edit', compact('student', 'main_menu'));
    }

    public function submit(StudentCreatRequest $request)
    {
        // dd($request->all());
        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_phone' => $request->mobile_phone,
            'student_number' => $request->student_number,
            'status' =>  $request->input('status', 0),
            'adviser_id' => $request->input('adviser_id'),
        ]);

        return redirect()->back()
            ->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
    }

    public function update(StudentUpdateRequest $request, $id)
    {
        // dd($request->all());
        $status = $request->input('status', 0);
        $student = Student::find($id);
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'adviser_id' => $request->input('adviser_id') ?? $student->adviser_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_phone' => $request->mobile_phone,
            'student_number' => $request->student_number,
            'status' =>  $status
        ]);
        return redirect()->back()
            ->with('success', 'ข้อมูลถูกอัพเดตเรียบร้อยแล้ว');
    }
    public function import(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);

        $validator = Validator::make(
            $request->all(),
            [
                'file' => [
                    'required',
                    'file',
                    'mimetypes:text/plain,text/csv,application/vnd.ms-excel',
                ],
            ],
            [
                'file.required' => 'กรุณาเลือกไฟล์มา Import',
                'file.file'     => 'ไฟล์ที่เลือกไม่ถูกต้อง',
                'file.mimes'    => 'กรุณาอัปโหลดไฟล์ CSV เท่านั้น',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first())
                ->withErrors($validator);
        }

        try {
            $file = $request->file('file');

            // อ่านไฟล์
            $content = file_get_contents($file->getRealPath());

            // ตรวจว่าเป็น UTF-8 หรือไม่
            if (!mb_check_encoding($content, 'UTF-8')) {

                // แปลงจาก TIS-620 เป็น UTF-8
                $content = iconv(
                    'TIS-620',
                    'UTF-8//IGNORE',
                    $content
                );
            }

            // ลบ BOM UTF-8
            $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

            // ชื่อไฟล์
            $fileName = 'import_student_' . now()->format('Ymd_His') . '.csv';

            // Path ที่ต้องการบันทึก
            $uploadPath = public_path('upload/file/student');

            // สร้าง Folder ถ้ายังไม่มี
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Path เต็มของไฟล์
            $tempFile = $uploadPath . '/' . $fileName;

            // บันทึกไฟล์ UTF-8
            file_put_contents($tempFile, $content);
            DB::beginTransaction();

            (new FastExcel)->import($tempFile, function ($line) {

                if (
                    empty($line['คำนำหน้าชื่ออาจารย์ที่ปรึกษา']) ||
                    empty($line['ชื่ออาจารย์ที่ปรึกษา']) ||
                    empty($line['นามสกุลอาจารย์ที่ปรึกษา'])
                ) {
                    throw new \Exception('ข้อมูลอาจารย์ที่ปรึกษาไม่ครบถ้วน');
                }

                $adviser = Adviser::firstOrCreate([
                    'titles_name' => trim($line['คำนำหน้าชื่ออาจารย์ที่ปรึกษา']),
                    'first_name'  => trim($line['ชื่ออาจารย์ที่ปรึกษา']),
                    'last_name'   => trim($line['นามสกุลอาจารย์ที่ปรึกษา']),
                ]);

                Student::updateOrCreate(
                    [
                        'student_number' => trim($line['รหัสนักศึกษา']),
                    ],
                    [
                        'first_name'   => trim($line['ชื่อ'] ?? ''),
                        'last_name'    => trim($line['นามสกุล'] ?? ''),
                        'mobile_phone' => trim($line['เบอร์โทรศัพท์'] ?? ''),
                        'email'        => trim($line['อีเมล'] ?? ''),
                        'adviser_id'   => $adviser->id,
                        'status'       => 1,
                    ]
                );
            });

            DB::commit();

            // ลบไฟล์ชั่วคราว
            @unlink($tempFile);

            return redirect()->back()
                ->with('success', 'ข้อมูลถูกอัปเดตเรียบร้อยแล้ว');
        } catch (\Throwable $e) {

            DB::rollBack();

            // ลบไฟล์ชั่วคราวถ้ามี
            if (isset($tempFile) && file_exists($tempFile)) {
                @unlink($tempFile);
            }

            Log::error($e);

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
    public function destroy($id, Request $request)
    {
        $student = Student::findOrFail($id);

        if ($memberInfo = MemberInfo::where('student_id', $id)->first()) {
            optional(Member::where('member_id', $memberInfo->member_id)->first())->delete();
            $memberInfo->delete();
        }

        $student->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.student', ['page' => $currentPage])->with([
            'success' => 'ข้อมูลถูกลบเรียบร้อยแล้ว!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'status' => 'error',
                'message' => 'ไม่มีข้อมูลที่เลือกสำหรับการลบ'
            ], 400);
        }

        DB::transaction(function () use ($ids) {

            // ดึง member_id ของนักศึกษาที่มีบัญชีสมาชิก
            $memberIds = MemberInfo::whereIn('student_id', $ids)
                ->pluck('member_id');

            // ลบ Member ก่อน (ถ้ามี)
            if ($memberIds->isNotEmpty()) {
                Member::whereIn('id', $memberIds)->delete();
            }

            // ลบ MemberInfo (ถ้ามี)
            MemberInfo::whereIn('student_id', $ids)->delete();

            // ลบ Student
            Student::whereIn('id', $ids)->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'ข้อมูลที่เลือกถูกลบเรียบร้อยแล้ว',
            'deleted_ids' => $ids
        ]);
    }
}
