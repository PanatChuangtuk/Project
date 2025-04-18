<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\{Student, Adviser};
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Requests\{StudentUpdateRequest, StudentCreatRequest};

class StudentController extends Controller
{
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
        return view('administrator.student.index', compact('users', 'query'));
    }

    public function add()
    {
        return view('administrator.student.add');
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return view('administrator.student.edit', compact('student'));
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
        $file = $request->file('file');

        $filePath = $file->storeAs('file/student', $file->getClientOriginalName(), 'public');
        $filePath = public_path('upload/' . $filePath);

        (new FastExcel)->import($filePath, function ($line) {
            $line = array_change_key_case($line, CASE_LOWER);
            $fullName = trim($line['advisername'] ?? '');

            // รายชื่อคำนำหน้าหลายคำ (รองรับทั้งไทยและอังกฤษ)
            $prefixes = [
                'นาย',
                'นาง',
                'นางสาว',
                'ดร.',
                'ดร',
                'ศ.',
                'ศ',
                'อ.',
                'ผศ.',
                'รศ.',
                'ศ.ดร.',
                'รองศาสตราจารย์',
                'ผู้ช่วยศาสตราจารย์',
                'ศาสตราจารย์',
                'Mr.',
                'Mrs.',
                'Miss',
                'Ms.',
                'Dr.',
                'Prof.',
                'Mr',
                'Mrs',
                'Ms',
                'Dr',
                'Prof',
                'Asst.Prof.',
                'Asst. Prof.',
                'Assoc.Prof.',
                'Assoc. Prof.'
            ];
            usort($prefixes, fn($a, $b) => strlen($b) - strlen($a));

            $pattern = '/^(' . implode('|', array_map('preg_quote', $prefixes)) . ')\s+/iu';
            $fullName = preg_replace($pattern, '', $fullName);

            $parts = explode(' ', $fullName, 2);
            $firstName = $parts[0] ?? null;
            $lastName = $parts[1] ?? null;

            $adviser = Adviser::firstOrCreate(
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]
            );
            return Student::updateOrCreate(
                ['student_number' => $line['studentnumber']],
                [
                    'first_name'   => $line['firstname'] ?? null,
                    'last_name'    => $line['lastname'] ?? null,
                    'mobile_phone' => $line['mobilephone'] ?? null,
                    'email'        => $line['email'] ?? null,
                    'adviser_id'   => $adviser->id,
                    'status'       => 1,
                    'created_at'   => now(),
                ]
            );
        });
        return redirect()->back()
            ->with('success', 'ข้อมูลถูกอัพเดตเรียบร้อยแล้ว');
    }
    public function destroy($id, Request $request)
    {
        $about = Student::findOrFail($id);
        $about->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.student', ['page' => $currentPage])->with([
            'success' => 'About deleted successfully!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Student::whereIn('id', $ids)->delete();

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
