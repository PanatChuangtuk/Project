<?php

namespace App\Imports;


use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Student([
            'student_number' => $row['student_number'],
            'first_name'     => $row['first_name'],
            'last_name'      => $row['last_name'],
            'mobile_phone'   => $row['mobile_phone'],
            'status'         => 1,
            'created_at'     => now(),
        ]);
    }
}
