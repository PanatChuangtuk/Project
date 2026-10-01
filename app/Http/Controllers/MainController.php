<?php

namespace App\Http\Controllers;

use App\Models\{Social, Contact, Language, Member, EquipmentItem, LoanEquipment, LoanTransaction};
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
        $total = $item->activeEquipment()->count();
        $borrowed = LoanEquipment::where('equipment_item_id', $item->id)
            ->whereHas('loanTransaction', function ($query) {
                $query->whereIn('status_type', ['borrowed', 'overdue'])
                    ->whereIn('status', ['in_process', 'completed']);
            })
            ->sum('quantity');

        return max($total - (int) $borrowed, 0);
    }

    /**
     * สมาชิกมีรายการยืมที่เกินกำหนดและยังไม่คืนหรือไม่ (ถ้ามี จะยืมเพิ่มไม่ได้จนกว่าจะคืน)
     */
    protected function hasOverdueLoan(?int $memberId = null): bool
    {
        $memberId ??= Auth::guard('member')->id();

        return $memberId !== null
            && LoanTransaction::where('member_id', $memberId)->overdueUnreturned()->exists();
    }
}
