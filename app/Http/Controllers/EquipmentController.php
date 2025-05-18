<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentCategory, EquipmentItem, LoanTransaction};

class EquipmentController extends MainController
{
    public function index()
    {
        $equipment = EquipmentCategory::where('status', 1)->get();

        return view('equipment', compact('equipment'));
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $action = $request->action;
        $cart = session()->get('cart', []);

        $item = EquipmentItem::withCount('equipment')->findOrFail($id);
        $totalStock = $item->equipment_count;

        $borrowedItems = LoanTransaction::whereIn('status_type', ['borrowed', 'overdue'])->whereIn('status', ['in_process', 'completed'])
            ->with('loanEquipments')
            ->get();
        $borrowedCounts = [];
        foreach ($borrowedItems as $borrow) {
            foreach ($borrow->loanEquipments as $loanEquipment) {
                $equipmentId = $loanEquipment->equipment_item_id;

                if (!isset($borrowedCounts[$equipmentId])) {
                    $borrowedCounts[$equipmentId] = 0;
                }
                $borrowedCounts[$equipmentId]++;
            }
        }
        $borrowedCount = isset($borrowedCounts[$id]) ? $borrowedCounts[$id] : 0;
        $available = max($totalStock - $borrowedCount, 0);
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
