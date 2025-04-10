<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\{Member, MemberInfo};
use Illuminate\Http\Request;
use App\Http\Requests\{MemberCreateRequest, MemberUpdateRequest};

class ApproveUserController extends Controller
{
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
        return view('administrator.user_approve.index', compact('users', 'query'));
    }
}
