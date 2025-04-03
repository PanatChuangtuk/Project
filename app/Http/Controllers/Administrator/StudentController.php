<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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


    public function add()
    {
        return view('administrator.student.add');
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return view('administrator.student.edit', compact('student'));
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'student_number' => 'required|string|max:20|unique:student,student_number',
        ], [
            'name.required' => 'กรุณากรอกชื่อ',
            'name.string' => 'ชื่อต้องเป็นตัวอักษร',
            'name.max' => 'ชื่อต้องไม่เกิน 255 ตัวอักษร',

            'student_number.required' => 'กรุณากรอกรหัสนักศึกษา',
            'student_number.string' => 'รหัสนักศึกษาต้องเป็นตัวอักษร',
            'student_number.max' => 'รหัสนักศึกษาต้องไม่เกิน 20 ตัวอักษร',
            'student_number.unique' => 'รหัสนักศึกษานี้ถูกใช้งานแล้ว กรุณาใช้รหัสอื่น',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_phone' => $request->mobile_phone,
            'student_number' => $request->student_number,
            'status' =>  $request->input('status', 0),
        ]);

        return redirect()->route('administrator.student');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $status = $request->input('status', 0);
        $student = Student::find($id);
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'student_number' => 'required',
        ], [
            'name.required' => 'กรุณากรอกชื่อ',
            'name.string' => 'ชื่อต้องเป็นตัวอักษร',
            'name.max' => 'ชื่อต้องไม่เกิน 255 ตัวอักษร',
            'student_number.required' => 'กรุณากรอกรหัสนักศึกษา',

        ]);



        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_phone' => $request->mobile_phone,
            'student_number' => $request->student_number,
            'status' =>  $status
        ]);

        return redirect()->route('administrator.student')->with('success', 'อัปเดตข้อมูลเรียบร้อย');
    }
    public function import(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        $file = $request->file('file');

        $filePath = $file->storeAs('file/product', $file->getClientOriginalName(), 'public');
        $filePath = public_path('upload/' . $filePath);

        (new FastExcel)->import($filePath, function ($line) {
            return Student::updateOrCreate(
                ['student_number' => $line['StudentNumber']],
                [
                    'first_name'   => $line['FirstName'] ?? null,
                    'last_name'    => $line['LastName'] ?? null,
                    'mobile_phone' => $line['MobilePhone'] ?? null,
                    'email' => $line['Email'] ?? null,
                    'status'       => 1,
                    'created_at'   => now(),
                ]
            );
        });
        return redirect()->back()->with('success', 'Data imported successfully.');
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
