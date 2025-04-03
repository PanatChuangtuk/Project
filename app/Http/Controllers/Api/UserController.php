<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\{Auth, DB, Http};

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $query = $request->get('query');
        $selectedIds = $request->input('selected_ids', []);
        $student = DB::table('student')->select('id', 'student_number')->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('id', 'like', '%' . $query . '%')
                ->orWhere('student_number', 'like', '%' . $query . '%');
        })->whereNotIn('id', $selectedIds)->whereNull('deleted_at')->take(10)->get();

        return response()->json(['results' => $student]);
    }
}
