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

        $borrowedItems = LoanTransaction::whereIn('status_type', ['borrowed', 'overdue'])
            ->with('loanEquipments')
            ->get();
        $borrowedCounts = [];
        foreach ($borrowedItems as $borrow) {
            foreach ($borrow->loanEquipments as $loanEquipment) {
                // dump($loanEquipment);
                $equipmentId = $loanEquipment->equipment_item_id;

                if (!isset($borrowedCounts[$equipmentId])) {
                    $borrowedCounts[$equipmentId] = 0;
                }
                $borrowedCounts[$equipmentId]++;
            }
        }
        return view('equipment-list', compact('equipment', 'borrowedCounts'));
    }
    public function equipmentCart(Request $request)
    {
        // dd($request->all());
        $product = EquipmentItem::find($request->input('equipment_id'));
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'ไม่พบอุปกรณ์ที่ต้องการเพิ่ม',
            ], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->input('quantity');
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $request->input('quantity'),
                'image' => $product->image,
            ];
        }
        session()->put('cart', $cart);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
