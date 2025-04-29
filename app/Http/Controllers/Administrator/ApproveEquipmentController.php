<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, DB};
use App\Models\{LoanEquipment, LoanTransaction};
use Illuminate\Http\Request;

class ApproveEquipmentController extends Controller
{
    private $main_menu = 'approve_equipment';
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = LoanTransaction::whereIn('status_type', ['borrowed', 'overdue']);


        if ($query) {
            $userQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('member.info', function ($infoQuery) use ($query) {
                    $infoQuery->where('first_name', 'LIKE', "%{$query}%")
                        ->orWhere('last_name', 'LIKE', "%{$query}%");
                })
                    ->orWhereHas('member.info.student', function ($studentQuery) use ($query) {
                        $studentQuery->where('student_number', 'LIKE', "%{$query}%");
                    });
            });
        }
        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        $main_menu = $this->main_menu;
        return view('administrator.equipment_approve.index', compact('users', 'query', 'main_menu'));
    }
    // public function updateApprove(Request $request)
    // {
    //     // dd($request->all());
    //     $query = $request->get('query');
    //     $student =  DB::table('member')
    //         ->where('id', $query)
    //         ->update([
    //             'status' => 1,
    //         ]);

    //     return response()->json(['results' => $student]);
    // }
}
