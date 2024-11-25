<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\{Order, OrdersProduct};
use Illuminate\Support\Facades\Auth;

class RefundController extends MainController
{
    public function refundIndex($lang, $id)
    {
        $userId = Auth::guard('member')->user()->id;
        $orders = Order::where('member_id', $userId)->orderBy('id', 'desc')->get();
        $allOrderProducts = [];
        foreach ($orders as $order) {
            $orderProducts = OrdersProduct::where('order_id', $order->id)->get();
            $allOrderProducts[$order->id] = $orderProducts;
        }

        return view('return-refund', compact('orderProducts', 'allOrderProducts'));
    }
}
