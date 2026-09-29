<?php

namespace App\Http\Controllers;

use App\Models\{Social, Contact, Language, Member, EquipmentItem, LoanEquipment};
use Illuminate\Support\Facades\{View, Auth};

class MainController extends Controller
{
    function __construct()
    {
        $userId = Auth::guard('member')->user()->id ?? null;
        $profileUser = Member::join('member_infomation', 'member_infomation.member_id', '=', 'member.id')
            ->select('member.*', 'member_infomation.*')
            ->where('member.id', $userId)
            ->first();
        // View::share('cart',  $cart);
        // View::share('social', $social);
        // View::share('contact', $contact);
        View::share('profileUser', $profileUser);
    }

    /**
     * จำนวนอุปกรณ์ที่ยังให้ยืมได้ (ทั้งหมด - ที่กำลังถูกยืม/รออนุมัติ)
     */
    protected function availableStock(EquipmentItem $item): int
    {
        $total = $item->equipment()->count();
        $borrowed = LoanEquipment::where('equipment_item_id', $item->id)
            ->whereHas('loanTransaction', function ($query) {
                $query->whereIn('status_type', ['borrowed', 'overdue'])
                    ->whereIn('status', ['in_process', 'completed']);
            })
            ->sum('quantity');

        return max($total - (int) $borrowed, 0);
    }
}
