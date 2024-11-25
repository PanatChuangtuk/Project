@extends('main')
@section('title')
    @lang('messages.return_refund')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section section-cart bg-light pt-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="my-account.html">Profile</a>
                </li>
            </ol>

            <div class="hgroup w-100 d-flex pb-4 mb-1">
                <a href="my-purchase-cancel.html" class="btn btn-outline back">
                    <img class="svg-js icons" src="img/icons/icon-arrow-back.svg" alt="" />
                    Back
                </a>
            </div>
            <div class="card-info py-4 text-center">
                <h3 class="fs-18">Return&Refund</h3>
                <p class="m-0">Please Select Product For Return/Refund</p>
            </div>
            <!--card-info-->

            <div class="card-info">
                <h3 class="fs-18 mb-2">Select Products</h3>

                <div class="table-boxed">
                    @foreach ($allOrderProducts as $order_id => $products)
                        @foreach ($products as $index => $item)
                            {{ $item }}
                            <ul class="ul-table ul-table-body infos">
                                <li class="checker">
                                    <input type="checkbox" class="form-check-input" />
                                </li>
                                <li class="photo">
                                    <img src="img/thumb/photo-400x455--1.jpg" alt="" />
                                </li>
                                <li class="info">
                                    <div class="product-info">
                                        <h3>
                                            {{ $item->name }}
                                        </h3>
                                        <label class="label">Size : {{ $item->size }}</label>
                                        <p><small>Model : {{ $item->model }}</small></p>
                                    </div>
                                </li>
                                <li class="qty">
                                    <strong class="fs-16 text-black">x{{ $item->quantity }}</strong>
                                </li>
                                <li class="total"><strong>{{ number_format($item->price * $item->quantity, 2) }} ฿</strong>
                                </li>
                            </ul>
                        @endforeach
                    @endforeach


                </div>
                <!--table-boxed-->

                <div class="buttons pb-4">
                    <a href="return-refund-reason.html" class="btn ms-auto">
                        <span class="px-4">Continue</span>
                    </a>
                </div>
            </div>
            <!--card-info-->
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
@endsection
