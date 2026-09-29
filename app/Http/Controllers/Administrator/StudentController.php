<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\{Validator, Log, DB};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $student = Student::findOrFail($id);
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
        $student = Student::findOrFail($id);
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
                'file.mimetypes' => 'กรุณาอัปโหลดไฟล์ CSV เท่านั้น',
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

            // เก็บไฟล์ชั่วคราวไว้นอก public เพื่อไม่ให้เข้าถึงผ่านเว็บได้
            $uploadPath = storage_path('app/tmp/student-import');

            // สร้าง Folder ถ้ายังไม่มี
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Path เต็มของไฟล์
            $tempFile = $uploadPath . '/' . $fileName;

            // บันทึกไฟล์ UTF-8
            file_put_contents($tempFile, $content);
            DB::beginTransaction();

            $rowNumber = 1; // แถวที่ 1 คือหัวตาราง
            $seenStudentNumbers = [];
            $seenEmails = [];

            (new FastExcel)->import($tempFile, function ($line) use (&$rowNumber, &$seenStudentNumbers, &$seenEmails) {
                $rowNumber++;

                $row = [
                    'student_number' => trim((string) ($line['รหัสนักศึกษา'] ?? '')),
                    'first_name'     => trim((string) ($line['ชื่อ'] ?? '')),
                    'last_name'      => trim((string) ($line['นามสกุล'] ?? '')),
                    'mobile_phone'   => trim((string) ($line['เบอร์โทรศัพท์'] ?? '')),
                    'email'          => trim((string) ($line['อีเมล'] ?? '')),
                    'adviser_title'  => trim((string) ($line['คำนำหน้าชื่ออาจารย์ที่ปรึกษา'] ?? '')),
                    'adviser_first'  => trim((string) ($line['ชื่ออาจารย์ที่ปรึกษา'] ?? '')),
                    'adviser_last'   => trim((string) ($line['นามสกุลอาจารย์ที่ปรึกษา'] ?? '')),
                ];

                // ใช้เงื่อนไขเดียวกับ StudentCreatRequest / AdviserCreateRequest
                $validator = Validator::make($row, [
                    'student_number' => 'required|string|max:20',
                    'first_name'     => 'required|string|max:255',
                    'last_name'      => 'required|string|max:255',
                    'mobile_phone'   => 'nullable|digits_between:9,10',
                    'email'          => [
                        'required',
                        'email',
                        'max:255',
                        // อีเมลห้ามซ้ำกับนักศึกษาคนอื่น (คนเดิมที่ถูกอัปเดตได้)
                        Rule::unique('student', 'email')->ignore($row['student_number'], 'student_number'),
                    ],
                    'adviser_title'  => 'required|string|max:255',
                    'adviser_first'  => 'required|string|max:255',
                    'adviser_last'   => 'required|string|max:255',
                ], [
                    'student_number.required' => 'ไม่มีรหัสนักศึกษา',
                    'student_number.max'      => 'รหัสนักศึกษาต้องไม่เกิน 20 ตัวอักษร',
                    'first_name.required'     => 'ไม่มีชื่อนักศึกษา',
                    'last_name.required'      => 'ไม่มีนามสกุลนักศึกษา',
                    'mobile_phone.digits_between' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลข 9-10 หลัก',
                    'email.required'          => 'ไม่มีอีเมล',
                    'email.email'             => 'รูปแบบอีเมลไม่ถูกต้อง',
                    'email.unique'            => 'อีเมลนี้ถูกใช้โดยนักศึกษาคนอื่นแล้ว',
                    'adviser_title.required'  => 'ข้อมูลอาจารย์ที่ปรึกษาไม่ครบถ้วน',
                    'adviser_first.required'  => 'ข้อมูลอาจารย์ที่ปรึกษาไม่ครบถ้วน',
                    'adviser_last.required'   => 'ข้อมูลอาจารย์ที่ปรึกษาไม่ครบถ้วน',
                    '*.max'                   => 'ข้อมูลยาวเกินกำหนด',
                ]);

                if ($validator->fails()) {
                    throw new \Exception("แถวที่ {$rowNumber}: " . $validator->errors()->first());
                }

                if (isset($seenStudentNumbers[$row['student_number']])) {
                    throw new \Exception("แถวที่ {$rowNumber}: รหัสนักศึกษาซ้ำกับแถวที่ {$seenStudentNumbers[$row['student_number']]}");
                }
                $emailKey = mb_strtolower($row['email']);
                if (isset($seenEmails[$emailKey])) {
                    throw new \Exception("แถวที่ {$rowNumber}: อีเมลซ้ำกับแถวที่ {$seenEmails[$emailKey]}");
                }
                $seenStudentNumbers[$row['student_number']] = $rowNumber;
                $seenEmails[$emailKey] = $rowNumber;

                // ค้นจากชื่อ-นามสกุล เพื่อไม่สร้างอาจารย์ซ้ำกับข้อมูลเดิมที่ยังไม่มีคำนำหน้า
                $adviser = Adviser::updateOrCreate(
                    [
                        'first_name' => $row['adviser_first'],
                        'last_name'  => $row['adviser_last'],
                    ],
                    [
                        'titles_name' => $row['adviser_title'],
                    ]
                );

                Student::updateOrCreate(
                    [
                        'student_number' => $row['student_number'],
                    ],
                    [
                        'first_name'   => $row['first_name'],
                        'last_name'    => $row['last_name'],
                        'mobile_phone' => $row['mobile_phone'],
                        'email'        => $row['email'],
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

        DB::transaction(function () use ($student) {
            // ลบบัญชีสมาชิกแบบถาวร ให้ตรงกับ AdminController/UserController
            $memberIds = MemberInfo::where('student_id', $student->id)->pluck('member_id');

            Member::whereIn('id', $memberIds)->forceDelete();
            MemberInfo::where('student_id', $student->id)->forceDelete();

            $student->delete();
        });

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

            // ลบบัญชีสมาชิกแบบถาวร ให้ตรงกับ AdminController/UserController
            Member::whereIn('id', $memberIds)->forceDelete();
            MemberInfo::whereIn('student_id', $ids)->forceDelete();

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
