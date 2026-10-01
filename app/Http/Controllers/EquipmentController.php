<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentCategory, EquipmentItem};

class EquipmentController extends MainController
{
    public function index()
    {
        $equipment = EquipmentCategory::where('status', 1)->get();

        return view('equipment', compact('equipment'));
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'action' => 'required|in:increase,decrease,remove',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'ข้อมูลไม่ถูกต้อง'
            ], 422);
        }

        $id = (int) $request->id;
        $action = $request->action;
        $cart = session()->get('cart', []);

        $item = EquipmentItem::where('status', 1)->findOrFail($id);
        $available = $this->availableStock($item);
        $current = $cart[$id]['quantity'] ?? 0;
        if (!isset($cart[$id])) {
            $cart[$id] = [
                'name' => $item->name,
                'quantity' => 0,
            ];
        }
        if ($action === 'increase') {
            if ($current >= $available) {
                return response()->json([
                    'success' => false,
                    'message' => 'เกินจำนวนที่สามารถยืมได้'
                ]);
            }
            $cart[$id]['quantity']++;
        } elseif ($action === 'decrease') {
            $cart[$id]['quantity']--;
            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
            }
        } elseif ($action === 'remove') {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'quantity' => $cart[$id]['quantity'] ?? 0
        ]);
    }
}
