<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Member, MemberInfo};
use Illuminate\Support\Facades\{Auth, DB, Http};

class UserApiController extends Controller
{
    public function getUser(Request $request)
    {
        $query = $request->get('query');
        $selectedIds = MemberInfo::pluck('student_id')->toArray();
        $student = DB::table('student')->select('id', 'student_number')->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('id', 'like', '%' . $query . '%')
                ->orWhere('student_number', 'like', '%' . $query . '%');
        })->whereNotIn('id', $selectedIds)->whereNull('deleted_at')->take(10)->get();

        return response()->json(['results' => $student]);
    }
    public function getAdviser(Request $request)
    {
        $query = $request->get('query');
        // $selectedIds = MemberInfo::pluck('student_id')->toArray();
        $student = DB::table('adviser')->select('id', 'first_name', 'last_name')->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('id', 'like', '%' . $query . '%')
                ->orWhere('first_name', 'like', '%' . $query . '%')->orWhere('last_name', 'like', '%' . $query . '%');
        })->whereNull('deleted_at')->take(10)->get();

        return response()->json(['results' => $student]);
    }
}
