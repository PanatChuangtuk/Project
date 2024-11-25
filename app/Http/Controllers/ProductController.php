<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\Models\{News, Language, ProductModel, ProductCategory, ProductType, ProductInformation, ProductPrice, ProductAttribute, Review, ProductBrand};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator, Http};

class ProductController extends MainController
{
    public function productIndex()
    {
        $locale = app()->getLocale();
        $language = Language::where('code', $locale)->first();
        $news = News::select(
            'news.*',
            'news_content.*',
            'news_content.id as news_content.content_id ',
            'news_content.name as content_name',
            'news_image.image'
        )
            ->where('news.status', true)
            ->join('news_content', 'news_content.news_id', '=', 'news.id')
            ->where('news_content.language_id', $language->id)
            ->join('news_image', 'news_image.news_id', '=', 'news.id')
            ->paginate(10);

        $product_type = ProductType::get();
        $product_brand = ProductBrand::get();
        $product_category = ProductCategory::whereIn('product_type_id', $product_type->pluck('id'))->get();
        $product_attribute = ProductAttribute::whereIn('product_type_id', $product_type->pluck('id'))->get();

        return view('product', compact('news', 'product_type', 'product_category', 'product_attribute', 'product_brand'));
    }
    public function productDetail($lang, $id)
    {
        $product = ProductModel::with('products.productPrices')->find($id);
        $totalReviews = Review::where('product_model_id', $product->id)->count();

        $review = Review::join('member', 'reviews.member_id', '=', 'member.id')
            ->where('reviews.product_model_id', $product->id)
            ->select('reviews.*', 'member.*')
            ->paginate(2);


        $product_list = ProductPrice::with('product')
            ->where('member_group_id', 1)
            ->where('product_id', $id)
            ->get();


        $product_info = ProductInformation::with('productAttribute')
            ->where('product_model_id', $product->id)
            ->get();
        return view('product-detail', compact('product', 'product_list', 'product_info', 'review', 'totalReviews'));
    }
    public function submit($lang, Request $request)
    {
        try {
            $cart = session()->get('cart', []);
            $ids = $request->input('id');
            $prices = $request->input('price');
            $names = $request->input('name');
            $skus = $request->input('sku');
            $sizes = $request->input('size');
            $quantities = $request->input('quantity');
            $models = $request->input('model');
            foreach ($ids as $index => $id) {
                $name = isset($names[$index]) ? $names[$index] : 0;
                $sku = isset($skus[$index]) ? $skus[$index] : 0;
                $size = isset($sizes[$index]) ? $sizes[$index] : 0;
                $model = isset($models[$index]) ? $models[$index] : 0;
                $price = isset($prices[$index]) ? $prices[$index] : 0;
                $quantity = isset($quantities[$index]) ? $quantities[$index] : 0;
                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] += $quantity;
                } elseif ($quantity > 0) {
                    $cart[$id] = [
                        'name' => $name,
                        'sku' => $sku,
                        'size' => $size,
                        'model' => $model,
                        'quantity' => $quantity,
                        'price' => $price,
                    ];
                }
            }
            session()->put('cart', $cart);
            return redirect()->route('cart.index', ['lang' => app()->getLocale()]);
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการเพิ่มสินค้าไปยังรถเข็น: ' . $e->getMessage());
        }
    }
    public function productReviewSubmit($lang, Request $request)
    {

        if (!Auth::guard('member')->check()) {
            return redirect()->route('login', ['lang' => app()->getLocale()]);
        }
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => __('messages.captcha_is_required'),
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        $verificationResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('app.nocaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
        $result = $verificationResponse->json();

        if (!$result['success']) {
            return redirect()->back()->withErrors(['g-recaptcha-response' => __('messages.recaptcha_verification_failed')]);
        }

        $member_id = Auth::guard('member')->user()->id;
        Review::create([
            'member_id' => $member_id,
            'product_model_id' => $request->input('product_model_id'),
            'comments' => $request->input('comment'),
            'star_rating' => $request->input('star_rating'),
            'status' => $request->input('status', 1),
            'created_at' => Carbon::now(),
            'created_by' => $member_id
        ]);

        return redirect()->route('profile', ['lang' => app()->getLocale()]);
    }
}
