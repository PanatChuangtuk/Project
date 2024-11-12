<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrdersProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends MainController
{
    public function cartIndex($lang, Request $request)
    {

        $cart = session()->get('cart', []);
        // session()->flush();
        // dd($cart);
        return view('cart');
    }

    public function addToCart($lang, $id)
    {

        $product = Product::find($id);
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


    public function removeCart($lang, $id)
    {
        $product = Product::find($id);

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id]) && $cart[$product->id]['quantity'] > 0) {
            $cart[$product->id]['quantity'] -= 1;
            session()->put('cart', $cart);
        }
        return response()->json([
            'status' => 'remove'
        ]);
    }
    public function deleteCart($lang, $id)
    {
        $product = Product::find($id);

        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);
        return response()->json([
            'status' => 'delete'
        ]);
    }

    public function order($lang, Request $request)
    {

        $subtotal = $request->input('subtotal');
        $vat = $request->input('vat');
        $shippingFee = $request->input('shipping_fee');
        $discount = $request->input('discount');
        $total = $request->input('total');
        $cart = session()->get('cart', []);
        $items  = $request->input('items');
        // dd($request->all(), $cart);
        $order = Order::create([
            'member_id' => Auth::guard('member')->user()->id ?? null,
            'order_number' => 0,
            'subtotal' =>  $subtotal,
            'vat' =>   $vat,
            'shipping_free' =>  50,
            'discount' =>   -50,
            'total' => $total,
            'created_at' => Carbon::now(),
        ]);

        foreach ($items as $item) {
            if (isset($cart[$item])) {
                $data = $cart[$item];
                OrdersProduct::create([
                    'product_id' => $item,
                    'order_id' => $order->id,
                    'name' =>  $data['name'],
                    'sku' =>  $data['sku'],
                    'size' =>  $data['size'],
                    'model' =>  $data['model'],
                    'price' =>  $data['price'],
                    'quantity' =>  $data['quantity'],
                    'total' => $data['price'] * $data['quantity'],
                    'created_at' => Carbon::now(),
                ]);
            } else {
                dd('Item not found in cart');
            }
        }
        return response()->json(['message' => 'ข้อมูลได้รับแล้ว', 'id']);
    }
}

    // public function clearSession()
    //     {
    //         // ล้างข้อมูลทั้งหมดในเซสชัน
    //         session()->flush();

    //         // ส่ง Response กลับเป็น JSON
    //         return  back();
    //     }
//  <form method="POST" action="{{ route('clear.session', ['lang' => app()->getLocale()]) }}">
//     @csrf
//     <button>Clear Session Storage</button>
// </form> 
