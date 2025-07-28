<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{LoanTransaction, LoanEquipment};

class BorrowController extends MainController
{
    public function borrow(Request $request)
    {
        $borrowedItems = LoanTransaction::whereIn('status_type', ['borrowed', 'overdue'])
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
        $cart = session()->get('cart', []);
        return view('borrow', compact('cart', 'borrowedCounts'));
    }
    public function submit(Request $request)
    {
        // dd($request->all());
        $items = $request->input('items', []);
        $loan = LoanTransaction::create([
            'member_id' => Auth::user()->id,
            'status_type' => 'borrowed',
            'status' => 'in_process',
            'borrowed_at' => now(),
            'returned_at' => null,
            'created_at' => now(),
        ]);

        foreach ($items as $item) {
            $quantity = (int)$item['quantity'];
            for ($i = 0; $i < $quantity; $i++) {
                LoanEquipment::create([
                    'loan_transactions_id' => $loan->id,
                    'equipment_item_id' => $item['id'],
                    'name' => $item['name'],
                    'quantity' => 1,
                    'created_at' => now(),
                ]);
            }
        }
        session()->forget('cart');
        return redirect()->back()->with('success', 'ยืนยันการยืมเรียบร้อยแล้ว');
    }
}
