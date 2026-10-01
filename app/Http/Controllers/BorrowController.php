<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EqmHistoryMaster, EquipmentItem};

class BorrowController extends MainController
{
    const OVERDUE_MESSAGE = 'คุณมีอุปกรณ์ที่ยืมเกินกำหนด กรุณาคืนอุปกรณ์ก่อนจึงจะยืมใหม่ได้';

    public function borrow(Request $request)
    {
        $borrowedCounts = $this->borrowedCounts();
        $cart = session()->get('cart', []);
        $hasOverdue = $this->hasOverdueLoan();
        return view('borrow', compact('cart', 'borrowedCounts', 'hasOverdue'));
    }
    public function submit(Request $request)
    {
        if ($this->hasOverdueLoan()) {
            return redirect()->back()->with('error', self::OVERDUE_MESSAGE);
        }

        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|distinct',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'ไม่มีอุปกรณ์ในตะกร้า',
            'items.min' => 'ไม่มีอุปกรณ์ในตะกร้า',
            'items.*.quantity.min' => 'จำนวนอุปกรณ์ต้องมีอย่างน้อย 1 ชิ้น',
            'items.*.*' => 'ข้อมูลอุปกรณ์ในตะกร้าไม่ถูกต้อง',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $items = collect($request->input('items'))->values();
        $equipmentItems = EquipmentItem::where('status', 1)
            ->whereIn('id', $items->pluck('id'))
            ->get()
            ->keyBy('id');

        // ตรวจจำนวนคงเหลือซ้ำตอนยืนยัน เพราะระหว่างที่อยู่ในตะกร้าอาจมีคนอื่นยืมไปแล้ว
        foreach ($items as $item) {
            $equipmentItem = $equipmentItems->get($item['id']);
            if (!$equipmentItem) {
                return redirect()->back()->with('error', 'ไม่พบอุปกรณ์บางรายการ หรืออุปกรณ์ถูกปิดใช้งานแล้ว');
            }
            if ((int) $item['quantity'] > $this->availableStock($equipmentItem)) {
                return redirect()->back()->with('error', 'อุปกรณ์ ' . $equipmentItem->name . ' มีจำนวนไม่เพียงพอ');
            }
        }

        DB::transaction(function () use ($items, $equipmentItems) {
            $master = EqmHistoryMaster::create([
                'member_id' => Auth::guard('member')->id(),
                'status' => 'pending',
                'borrowed_at' => now(),
                'due_at' => now()->addDays(EqmHistoryMaster::LOAN_DAYS),
            ]);

            foreach ($items as $item) {
                $quantity = (int) $item['quantity'];
                for ($i = 0; $i < $quantity; $i++) {
                    $detail = $master->details()->create([
                        'equipment_item_id' => $item['id'],
                        // ใช้ชื่อจากฐานข้อมูล ไม่ใช้ค่าที่ส่งมาจากฟอร์ม
                        'name' => $equipmentItems[$item['id']]->name,
                    ]);
                    $master->logEvent('request', $detail);
                }
            }
        });
        session()->forget('cart');
        return redirect()->back()->with('success', 'ยืนยันการยืมเรียบร้อยแล้ว');
    }
}
