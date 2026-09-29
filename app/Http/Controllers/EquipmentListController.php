<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentCategory, EquipmentItem, LoanTransaction};

class EquipmentListController extends MainController
{
    public function equipmentListIndex(Request $request)
    {
        // session()->forget('cart');
        $typeVaule = $request->query('type');
        $equipment = EquipmentItem::where('category_id', $typeVaule)
            ->where('status', 1)
            ->get();
        $borrowedItems = LoanTransaction::whereIn('status_type', ['borrowed', 'overdue'])->whereIn('status', ['in_process', 'completed'])
            ->with('loanEquipments')
            ->get();
        $borrowedCounts = [];
        foreach ($borrowedItems as $borrow) {
            foreach ($borrow->loanEquipments as $loanEquipment) {
                $equipmentId = $loanEquipment->equipment_item_id;
                $quantity = $loanEquipment->quantity;

                if (!isset($borrowedCounts[$equipmentId])) {
                    $borrowedCounts[$equipmentId] = 0;
                }
                $borrowedCounts[$equipmentId] += $quantity;
            }
        }

        return view('equipment-list', compact('equipment', 'borrowedCounts'));
    }
    public function equipmentCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'equipment_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'กรุณาเลือกจำนวนอุปกรณ์',
            'quantity.integer' => 'จำนวนอุปกรณ์ไม่ถูกต้อง',
            'quantity.min' => 'กรุณาเลือกจำนวนอุปกรณ์อย่างน้อย 1 ชิ้น',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $product = EquipmentItem::where('status', 1)->find($request->input('equipment_id'));
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'ไม่พบอุปกรณ์ที่ต้องการเพิ่ม',
            ], 404);
        }

        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity');
        $inCart = (int) ($cart[$product->id]['quantity'] ?? 0);

        // หน้าเว็บจำกัดจำนวนไว้แล้ว แต่ต้องตรวจซ้ำฝั่ง server ด้วย
        if ($inCart + $quantity > $this->availableStock($product)) {
            return response()->json([
                'status' => 'error',
                'message' => 'เกินจำนวนที่สามารถยืมได้',
            ], 422);
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $inCart + $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }
        session()->put('cart', $cart);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
