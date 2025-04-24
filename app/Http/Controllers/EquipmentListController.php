<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentCategory, EquipmentItem};

class EquipmentListController extends MainController
{
    public function equipmentListIndex(Request $request)
    {
        // session()->forget('cart');
        $typeVaule = $request->query('type');
        $equipment = EquipmentItem::where('category_id', $typeVaule)
            ->where('status', 1)
            ->get();
        // dd($equipment->item);
        return view('equipment-list', compact('equipment'));
    }
    public function equipmentCart(Request $request)
    {
        $product = EquipmentItem::find($request->input('equipment_id'));
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'ไม่พบอุปกรณ์ที่ต้องการเพิ่ม',
            ], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += 1;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
            ];
        }
        session()->put('cart', $cart);
        return response()->json([
            'status' => 'success'
        ]);
    }
    public function addToCart($lang, $id)
    {
        $product = EquipmentItem::find($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += 1;
        } else {
            $cart[$product->id]['quantity'] = 1;
        }
        session()->put('cart', $cart);
        return response()->json([
            'status' => 'add'
        ]);
    }
}
