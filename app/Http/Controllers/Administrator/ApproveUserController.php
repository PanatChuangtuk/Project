<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, DB};
use App\Models\{Member, MemberInfo};
use Illuminate\Http\Request;
use App\Http\Requests\{MemberCreateRequest, MemberUpdateRequest};

class ApproveUserController extends Controller
{
    private $main_menu = 'user';
    public function index(Request $request)
    {
        $query = $request->input('query');

        $userQuery = Member::with('info')->where('role', 'user')
            ->where('status', 0);
        if ($query) {
            $userQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('email', 'LIKE', "%{$query}%")
                    ->orWhereHas('info', function ($infoQuery) use ($query) {
                        $infoQuery->where('first_name', 'LIKE', "%{$query}%")
                            ->orWhere('last_name', 'LIKE', "%{$query}%");
                    });
            });
        }
        $users = $userQuery->paginate(10)->appends([
            'query' => $query,
        ]);
        $main_menu = $this->main_menu;
        return view('administrator.user_approve.index', compact('users', 'query', 'main_menu'));
    }
    public function updateApprove(Request $request)
    {
        // dd($request->all());
        $query = $request->get('query');
        $student =  DB::table('member')
            ->where('id', $query)
            ->update([
                'status' => 1,
            ]);

        return response()->json(['results' => $student]);
    }
}
