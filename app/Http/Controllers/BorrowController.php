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
        $cart = session()->get('cart', []);
        return view('borrow', compact('cart'));
    }
    public function submit(Request $request)
    {
        // dd($request->all());
        $items = $request->input('items', []);
        $loan = LoanTransaction::create([
            'member_id' => Auth::user()->id,
            'status_type' => 'borrowed',
            'status' => 'in_progress',
            'borrowed_at' => now(),
            'returned_at' => null,
            'created_at' => now(),
        ]);
        foreach ($items as $item) {
            LoanEquipment::create([
                'loan_transactions_id' => $loan->id,
                'equipment_item_id' => $item['id'],
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'created_at' => now(),
            ]);
        }
        session()->forget('cart');
        return redirect()->back()->with('success', 'ยืนยันการยืมเรียบร้อยแล้ว');
    }
}
