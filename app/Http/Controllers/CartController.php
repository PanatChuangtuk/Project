<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\{Product, MemberAddressTax, MemberAddress, Order, OrdersProduct, OrdersAddress, MemberInfo};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Http};
use Carbon\Carbon;
use App\Enum\TypeAddress;

class CartController extends MainController
{
    public function cartCheckIndex($lang, $id)
    {
        $order = Order::find($id);
        $order_product = OrdersProduct::where('order_id', $id)->get();
        $userId = Auth::guard('member')->user()->id;

        $address = MemberAddress::select('member_address.*')
            ->where('member_address.member_id', $userId)
            ->orderBy('is_default', 'desc')
            ->get();
        $tax = MemberAddressTax::select('member_address_tax.*')
            ->where('member_address_tax.member_id', $userId)
            ->orderBy('is_default', 'desc')
            ->get();

        return view('cart-check-out', compact('order_product', 'order', 'address', 'tax'));
    }
    public function cartIndex($lang, Request $request)
    {
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
        if (!Auth::guard('member')->check()) {
            return redirect()->route('login', ['lang' => app()->getLocale()]);
        }
        $subtotal = $request->input('subtotal');
        $vat = $request->input('vat');
        $shippingFee = $request->input('shipping_fee');
        $discount = $request->input('discount');
        $total = $request->input('total');
        $cart = session()->get('cart', []);
        $items  = $request->input('items');
        $order = Order::create([
            'member_id' => Auth::guard('member')->user()->id,
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
                session()->forget('cart.$item');
            } else {
                dd('Item not found in cart');
            }
        }
        return redirect()->route('cart.check.index', ['lang' => app()->getLocale(), 'id' => $order->id]);
    }

    public function orderAddress($lang, Request $request, $id)
    {

        if (!Auth::guard('member')->check()) {
            return redirect()->route('login', ['lang' => app()->getLocale()]);
        }

        $member = Auth::guard('member')->user();
        $address = MemberAddress::find($request->id_address);
        OrdersAddress::create([
            'order_id' => $id,
            'member_id' => $address->member_id,
            'first_name' => $address->first_name,
            'last_name' => $address->last_name,
            'mobile_phone' => $address->mobile_phone,
            'email' => $address->email,
            'province_id' => $address->province_id,
            'district_id' => $address->district_id,
            'subdistrict_id' => $address->subdistrict_id,
            'postal_code' => $address->postal_code,
            'detail' => $address->detail,
            'type' => TypeAddress::Shipping->value,
            'created_by' => $member->id
        ]);

        $tax = MemberAddressTax::find($request->id_tax);
        OrdersAddress::create([
            'order_id' => $id,
            'member_id' => $tax->member_id,
            'first_name' => $tax->first_name,
            'last_name' => $tax->last_name,
            'mobile_phone' => $tax->mobile_phone,
            'email' => $tax->email,
            'province_id' => $tax->province_id,
            'district_id' => $tax->district_id,
            'subdistrict_id' => $tax->subdistrict_id,
            'postal_code' => $tax->postal_code,
            'detail' => $tax->detail,
            'type' => TypeAddress::Bill->value,
            'created_by' => $member->id
        ]);

        $order = Order::find($id);
        $order_product = DB::table('orders')
            ->join('orders_product', 'orders.id', '=', 'orders_product.order_id')
            ->where('orders.id', $id)
            ->select(
                'orders.*',
                'orders_product.id as product_id',
                'orders_product.sku',
                'orders_product.quantity',
                'orders_product.price',
                'orders_product.product_id as product_id',
            )
            ->get();

        $info = MemberInfo::find($member->id);

        $formattedItems = $order_product->map(function ($item) {
            return [
                'lineNo' => (string)$item->id,
                'itemNo' => $item->sku,
                'quantity' => (float)$item->quantity,
                'unitOfMeasureCode' => "2efaad14-1aa0-41eb-8a8f-2dd59b388669",
                'unitPrice' => (float)$item->price,
                'lineDiscountAmount' => (float)$item->discount,
            ];
        });
        $orderDate = $order->created_at->toDateString();
        $payload = [
            "requestTime" => now(),
            "partnerCode" => "001",
            "transactionChannel" => "001",
            "orderNo" => "WSO2411-0004",
            "orderDate" =>  (string)$orderDate,
            "externalDocNo" => "EXTERNAL001",
            "remark" => "",
            "customerNo" => (string)$member->id,
            "customerName" => $member->username,
            "customerType" => $info->account_type,
            "vatRegistrationNo" => $info->vat_register_number,
            "address" => $address->detail,
            "district" =>  (string)$address->district_id,
            "city" => (string)$address->subdistrict_id,
            "province" => (string)$address->province_id,
            "postCode" => (string)$address->postal_code,
            "tel" => $address->mobile_phone,
            "email" => $address->email,
            "billToAddress" => $tax->detail,
            "billToDistrict" =>  (string)$tax->district_id,
            "billToCity" => (string)$tax->subdistrict_id,
            "billToProvince" => (string)$tax->province_id,
            "billToPostCode" => (string)$tax->postal_code,
            "billToTel" => $tax->mobile_phone,
            "billToEmail" => $tax->email,
            "shipToAddress" => $address->detail,
            "shipToDistrict" => (string) $address->district_id,
            "shipToCity" => (string)$address->subdistrict_id,
            "shipToProvince" => (string)$address->province_id,
            "shipToPostCode" => (string)$address->postal_code,
            "shipToTel" => $address->mobile_phone,
            "shipToEmail" => $address->email,
            "totalLine" => 4,
            "items" => $formattedItems->toArray()
        ];


        // dd(json_encode($payload));
        $response = Http::withBasicAuth('web', 'Nav#1234')->post(
            'http://183.88.232.152:14148/bc14uvtst/api/amco/app/v1.0/companies(66e8e884-a363-4012-aef1-ce9c4855f09f)/CreateSalesOrders',
            $payload
        );


        if ($response->successful()) {
            echo  $response->body();
        } else {
            $error = $response->body();
            echo "Failed to send data: $error";
            echo "Response: " . json_encode($response->json());
        }
        return;
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
