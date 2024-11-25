@extends('main')

@section('title')
    @lang('messages.checkout')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <div class="section section-cart bg-light pt-0">
        <div class="container has-sidebar">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/profile ') }}">@lang('messages.profile')</a></li>
            </ol>
            <div class="hgroup w-100 d-flex pb-4 mb-1">
                <a href="{{ url(app()->getLocale() . '/my-purchase') }}" class="btn btn-outline back">
                    <img class="svg-js icons" src="{{ asset('img/icons/icon-arrow-back.svg') }}" alt="">
                    @lang('messages.back')
                </a>
            </div>


            <div class="content">
                <div class="card-info">
                    <h3 class="fs-18 mb-2 d-flex">
                        @lang('messages.address')
                        <a class="link-edit" href="#addressModal" data-bs-toggle="modal">@lang('messages.edit')</a>
                    </h3>
                    <form action="{{ route('cart.order.submit', ['lang' => app()->getLocale(), 'id' => $order->id]) }}"
                        method="POST">
                        @csrf

                        @foreach ($address as $itemAddress)
                            @if ($itemAddress->is_default)
                                <input type="text" class="form-control" name="id_address" value="{{ $itemAddress->id }}"
                                    style="display: none;" />
                                <div class="d-flex gap-3">
                                    <img class="icons mt-1" src="{{ asset('img/icons/icon-map-point.svg') }}"
                                        alt="">
                                    <div>
                                        <p class="m-0">
                                            <strong>{{ $itemAddress->first_name . ' ' . $itemAddress->last_name }}</strong>
                                        </p>
                                        <p>{{ $itemAddress->detail . ' ' . $itemAddress->district_id . ' ' . $itemAddress->subdistrict_id . ' ' . $itemAddress->province_id . ' ' . $itemAddress->postal_code }}<br>
                                            {{ $itemAddress->mobile_phone }}</p>

                                    </div>
                                </div>
                            @endif
                        @endforeach
                </div><!--card-info-->

                <div class="card-info">
                    <h3 class="fs-18 mb-2">
                        @lang('messages.product')
                    </h3>

                    <div class="table-boxed">
                        @foreach ($order_product as $item)
                            <ul class="ul-table ul-table-body infos">
                                <li class="photo">
                                    <img src="{{ asset('img/thumb/photo-400x455--1.jpg') }}" alt="">
                                </li>
                                <li class="info">
                                    <a class="product-info"
                                        href="{{ url(app()->getLocale() . '/product-detail/' . $item->product_id) }}">
                                        <h3>{{ $item->name }}</h3>
                                        <label class="label">Size : {{ $item->size }}</label>
                                        <p><small>Model : {{ $item->model }}</small></p>
                                    </a>
                                </li>
                                <li class="qty">
                                    <strong class="fs-16 text-black">x{{ $item->quantity }}</strong>
                                </li>
                                <li class="total"><strong>{{ number_format($item->price * $item->quantity, 2) }}
                                        ฿</strong>
                                </li>
                            </ul>
                        @endforeach
                    </div><!--table-boxed-->
                </div><!--card-info-->

                <div class="card-info">
                    <h3 class="fs-18 mb-3">
                        @lang('messages.shippings')
                    </h3>

                    <div class="d-flex gap-3">
                        <img class="icons" src="{{ asset('img/icons/icon-delivery-truck.svg') }}" alt="">
                        <div>
                            <p class="fs-15 text-black m-0"><strong>Shipping Official</strong></p>
                            <p class="fs-13 text-highlight">Estimated Delivery in 3 - 5 Days</p>
                        </div>

                        <p class="text-secondary ms-auto me-md-4">
                            <strong>50.00฿</strong>
                        </p>
                    </div>
                </div><!--card-info-->

                <div class="card-info">
                    <h3 class="fs-18 mb-2">
                        @lang('messages.work_description')
                    </h3>
                    <textarea class="form-control h-145" name="work_description" placeholder="@lang('messages.work_description')"></textarea>
                </div>
                <div class="card-info">
                    <h3 class="fs-18 mb-2 d-flex">
                        @lang('messages.tax_invoice')<small class="my-auto ms-2">(@lang('messages.optional'))</small>
                        <a class="link-edit" href="#taxInvoiceModal" data-bs-toggle="modal">@lang('messages.edit')</a>
                    </h3>
                    @foreach ($tax as $itemTax)
                        @if ($itemTax->is_default)
                            <input type="text" class="form-control" name="id_tax" value="{{ $itemTax->id }}"
                                style="display: none;" />
                            <div class="d-flex gap-3">
                                <img class="icons mt-1" src="{{ asset('img/icons/icon-map-point.svg') }}" alt="">
                                <div>
                                    <p class="m-0">
                                        <strong>{{ $itemTax->first_name . ' ' . $itemTax->last_name . '   TaxID : ' . $itemTax->tax_id }}</strong>
                                    </p>
                                    <p>{{ $itemTax->detail . ' ' . $itemTax->district_id . ' ' . $itemTax->subdistrict_id . ' ' . $itemTax->province_id . ' ' . $itemTax->postal_code }}<br>
                                        {{ $itemTax->mobile_phone }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="card-info">
                    <h3 class="fs-18 mb-2">
                        Payment
                    </h3>
                    <div class="form-check payment">
                        <input class="form-check-input" type="radio" id="credit" name="payment" checked>
                        <label class="form-check-label" for="credit">
                            Credit/Debit
                            <img class="icon" src="{{ asset('img/icons/icon-creditcard.png') }}" alt="">
                        </label>
                    </div>
                    <div class="form-check payment">
                        <input class="form-check-input" type="radio" id="promptpay" name="payment">
                        <label class="form-check-label" for="promptpay">
                            QR Promptpay
                            <img class="icon" src="{{ asset('img/icons/icon-promptpay.png') }}" alt="">
                        </label>
                    </div>
                    <div class="form-check payment">
                        <input class="form-check-input" type="radio" id="po" name="payment">
                        <label class="form-check-label d-block" for="po">
                            Purchase Order (PO Number)<br>
                            <input type="text" class="form-control bg-white mt-2" placeholder="Enter">
                        </label>
                    </div>
                </div>
            </div>
            <div class="sidebar">
                <div class="card-info">
                    <h3 class="fs-18 mb-2">@lang('messages.summary')</h3>
                    <table class="table-summary">
                        <tr>
                            <td>@lang('messages.subtotal')</td>
                            <td class="number">{{ number_format($order->subtotal, 2) }} ฿</td>
                        </tr>
                        <tr>
                            <td>@lang('messages.vat')</td>
                            <td class="number">{{ number_format($order->vat, 2) }} ฿</td>
                        </tr>
                        <tr>
                            <td>@lang('messages.shipping')</td>
                            <td class="number">{{ number_format($order->shipping_free, 2) }} ฿</td>
                        </tr>
                        <tr>
                            <td>@lang('messages.discount')</td>
                            <td class="number text-danger">{{ number_format($order->discount, 2) }} ฿</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr class="total">
                            <td>@lang('messages.total') </td>
                            <td class="number">{{ number_format($order->total, 2) }} ฿</td>
                        </tr>
                    </table>
                    <div class="buttons flex-column pb-0 pt-4">
                        <button class="btn btn-48" type="submit" data-bs-target="#ksherModal" data-bs-toggle="modal">
                            <span class="fs-13">@lang('messages.proceed_to_checkout')</span>
                        </button>
                    </div>

                    </form>

                </div>


                <div class="card-info d-flex">
                    <h3 class="fs-15">@lang('messages.points')</h3>
                    <span class="fs-15 ms-auto" style="color:#FFCA38;">+ 17 @lang('messages.points')</span>
                </div>
                <div class="card-info">
                    <div class="card-header">
                        <h3 class="title-icon fs-18">
                            <img class="icons" src="{{ asset('img/icons/icon-ticket.svg') }}" alt="">
                            @lang('messages.coupon_discount')
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group coupon has-value">
                            <input class="form-control">
                            <div class="label-lists">
                                <label class="label label-free">@lang('messages.shipping')</label>
                            </div>
                            <button class="btn" type="button">
                                <span class="icons"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-info">
                    <div class="card-header">
                        <h3 class="title-icon fs-18">
                            <img class="icons" src="{{ asset('img/icons/icon-crown.svg') }}" alt="">
                            @lang('messages.points')
                        </h3>
                        <div class="d-block ms-auto">
                            <span class="text-warning fs-15">599.50</span>
                            <span class="text-black fs-14">@lang('messages.points')</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group coupon" data-bs-toggle="modal" data-bs-target="#choseCouponModal">
                            <input class="form-control" value="" placeholder="Enter">
                            <button class="btn" type="button">
                                <span class="icons"></span>
                            </button>
                        </div>
                        <p class="fs-12 pt-2">10 @lang('messages.points') = 1 @lang('messages.currency')</p>
                    </div>
                </div>



                <!--receive-info-->
                <div class="card-info py-2">
                    <div class="info-row border-bottom-1">
                        <div class="d-flex w-100">
                            <h3 class="fs-15">Status Order :</h3>
                            <p class="fs-14 ms-auto"><strong>SH20240000101</strong></p>
                        </div>
                        <div class="d-flex w-100">
                            <h3 class="fs-15">Tacking Number :</h3>
                            <p class="fs-14 ms-auto"><strong>TH102E4C00101</strong> <a class="text-highlight"
                                    href="#">Copy</a></p>
                        </div>
                    </div>
                    <div class="info-row border-0">
                        <div class="d-flex fs-13 w-100">
                            <p>Place Order :</p>
                            <p class="ms-auto nowrap">22/09/2023 13:45</p>
                        </div>

                        <div class="d-flex fs-13 w-100">
                            <p>Paid :</p>
                            <p class="ms-auto nowrap">21/09/2023 14:00</p>
                        </div>

                        <div class="d-flex fs-13 w-100">
                            <p>Wait for shipping :</p>
                            <p class="ms-auto nowrap">21/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>บริษัทขนส่งเข้ารับพัสดุแล้ว<br>
                                สมุทรปราการ,บางพลี,บางปลา</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>ถูกส่งมอบให้บริษัทขนส่งแล้ว<br>
                                สมุทรปราการ,บางพลี,บางปลา</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>พัสดุถึงสาขาปลายทาง<br>
                                กรุงเทพ,บึงกุ่ม,นวมินทร์</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>พัสดุอยู่ระหว่างการนำจัดส่ง</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                    </div>
                </div>
                <!-- -->
                <!--card-delivery-->

                <div class="card-info">
                    <div class="info-row border-bottom-1">
                        <h3 class="fs-15">Status Order :</h3>
                        <p class="fs-14 ms-auto">SH20240000101</p>
                    </div>
                    <div class="info-row border-0">
                        <div class="d-flex fs-13 w-100">
                            <p>Place Order :</p>
                            <p class="ms-auto">22/09/2023 13:45</p>
                        </div>

                        <div class="d-flex fs-13 w-100">
                            <p>Paid :</p>
                            <p class="ms-auto">21/09/2023 14:00</p>
                        </div>

                        <div class="d-flex fs-13 w-100">
                            <p>Wait for shipping :</p>
                            <p class="ms-auto">21/09/2023 14:01</p>
                        </div>

                    </div>
                </div>

                <!-- -->
                <!--card-complete-->

                <div class="card-info py-2">
                    <div class="info-row border-bottom-1">
                        <div class="d-flex w-100">
                            <h3 class="fs-15">Status Order :</h3>
                            <p class="fs-14 ms-auto"><strong>SH20240000101</strong></p>
                        </div>
                        <div class="d-flex w-100">
                            <h3 class="fs-15">Tacking Number :</h3>
                            <p class="fs-14 ms-auto">
                                <strong>TH102E4C00101</strong>
                                <a class="text-highlight" href="#">Copy</a>
                            </p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>Shipped with :</p>
                            <p class="ms-auto nowrap">EMS Thai Post</p>
                        </div>
                    </div>
                    <div class="info-row border-0">
                        <div class="d-flex fs-13 w-100">
                            <p>Place Order :</p>
                            <p class="ms-auto nowrap">22/09/2023 13:45</p>
                        </div>

                        <div class="d-flex fs-13 w-100">
                            <p>Paid :</p>
                            <p class="ms-auto nowrap">21/09/2023 14:00</p>
                        </div>

                        <div class="d-flex fs-13 w-100">
                            <p>Wait for shipping :</p>
                            <p class="ms-auto nowrap">21/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>บริษัทขนส่งเข้ารับพัสดุแล้ว<br>
                                สมุทรปราการ,บางพลี,บางปลา</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>ถูกส่งมอบให้บริษัทขนส่งแล้ว<br>
                                สมุทรปราการ,บางพลี,บางปลา</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>พัสดุถึงสาขาปลายทาง<br>
                                กรุงเทพ,บึงกุ่ม,นวมินทร์</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100">
                            <p>พัสดุอยู่ระหว่างการนำจัดส่ง</p>
                            <p class="ms-auto nowrap">23/09/2023 14:01</p>
                        </div>
                        <div class="d-flex fs-13 w-100 text-success">
                            <p>พัสดุจัดส่งสำเร็จแล้ว</p>
                            <p class="ms-auto nowrap">25/09/2023 17:01</p>
                        </div>
                    </div>
                </div><!--card-info-->

                <div class="card-info text-center py-4">
                    <div class="buttons p-0 flex-column">
                        <button class="btn btn-green btn-34" type="button" data-bs-target="#receiveModal"
                            data-bs-toggle="modal">Receive</button>

                        <a class="btn btn-outline-orange btn-34" href="return-refund.html">Return&Refund</a>
                    </div>


                    <p class="fs-12 fw-300 mt-3 mb-0 text-success">The product has been shipped.<br>
                        Please press to receive the product.</p>
                </div><!--card-info-->

                <!-- -->
                <!--card-cancel-->

                <div class="card-info py-2">
                    <div class="info-row border-bottom-1">
                        <div class="d-flex w-100">
                            <h3 class="fs-15">Status Order :</h3>
                            <p class="fs-14 ms-auto"><strong>SH20240000101</strong></p>
                        </div>
                    </div>
                    <div class="info-row border-0">
                        <div class="d-flex fs-13 w-100">
                            <p>Place Order :</p>
                            <p class="ms-auto nowrap">22/09/2023 13:45</p>
                        </div>

                        <div class="d-flex fs-13 w-100 text-danger">
                            <p>Cancel Order :</p>
                            <p class="ms-auto nowrap">22/09/2023 13:45</p>
                        </div>
                    </div>
                </div><!--card-info-->

                <div class="card-info">
                    <h3 class="fs-15 mb-2">Cancel Detail</h3>
                    <p class="fs-12" style="color: #797979;">Lorem ipsum dolor sit amet consectetur. Id dignissim in
                        nibh
                        sed
                        pellentesque sit ullamcorper amet amet. Sodales neque cras aliquet tellus malesuada .</p>
                </div><!--card-info-->


                <!-- -->
                <!--card-topay-->


                <div class="card-info">
                    <div class="info-row border-bottom-1">
                        <h3 class="fs-15">Status Order :</h3>
                        <p class="fs-14 ms-auto">SH20240000101</p>
                    </div>
                    <div class="info-row border-0">
                        <p class="fs-13">Place Order :</p>
                        <p class="fs-13 ms-auto">22/09/2023 13:45</p>
                    </div>
                </div><!--card-info-->

                <div class="card-info text-center py-4">
                    <button class="btn btn-outline-red btn-34 w-100" type="button" style="--bs-btn-bg:#FBFBFB"
                        data-bs-target="#cancelOrderModal" data-bs-toggle="modal">Cancel</button>

                    <p class="fs-12 fw-300 px-sm-4 mt-3 mb-0">You can request to cancel your order. But it must be
                        within the company's conditions.</p>
                </div><!--card-info-->

            </div>




        </div><!--container-->
    </div><!--section-->
    <div id="addressModal" class="modal fade" style="--bs-modal-width:550px">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content px-sm-2">
                <div class="modal-body">
                    <h3 class="fs-20 mb-1">@lang('messages.my_address')</h3>
                    @foreach ($address as $itemAddress)
                        <div class="{{ $itemAddress->is_default ? 'card-address default border-0' : 'card-address' }}">
                            <a href="{{ route('profile.address.edit', ['lang' => app()->getLocale(), 'id' => $itemAddress->id]) }}"
                                class="link-edit">@lang('messages.edit')</a>
                            <img class="icons" src="{{ asset('img/icons/icon-map-point.svg') }}" alt="">

                            <div class="card-body">
                                <p class="m-0">
                                    <strong>{{ $itemAddress->first_name . ' ' . $itemAddress->last_name }}</strong>
                                </p>
                                <p>{{ $itemAddress->detail . ' ' . $itemAddress->district_id . ' ' . $itemAddress->subdistrict_id . ' ' . $itemAddress->province_id . ' ' . $itemAddress->postal_code }}<br>
                                    {{ $itemAddress->mobile_phone }}</p>
                                @if ($itemAddress->is_default)
                                    <button class="btn btn-default" type="button">
                                        @lang('messages.default')
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex py-2">
                        <a class="btn btn-address-add btn-light-2"
                            href="{{ url(app()->getLocale() . '/cart-address') }}">
                            <img class="icons svg-js" src="{{ asset('img/icons/icon-add-plus.svg') }}" alt="">
                            @lang('messages.add_address')
                        </a>
                    </div>

                    <div class="buttons button-confirm mt-4">
                        <button class="btn btn-outline-red" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div><!--modal-body-->
            </div><!--modal-content-->
        </div>
    </div>

    <div id="taxInvoiceModal" class="modal fade" style="--bs-modal-width:550px">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content px-sm-2">
                <div class="modal-body">
                    <h3 class="fs-20 mb-1">@lang('messages.full_tax_invoice')</h3>
                    @foreach ($tax as $itemTax)
                        <div class="{{ $itemTax->is_default ? 'card-address default border-0' : 'card-address' }}">
                            <a href="{{ route('tax.edit', ['lang' => app()->getLocale(), 'id' => $itemTax->id]) }}"
                                class="link-edit">@lang('messages.edit')</a>
                            <img class="icons" src="{{ asset('img/icons/icon-map-point.svg') }}" alt="">
                            <div class="card-body">
                                <p class="m-0">
                                    <strong>{{ $itemTax->first_name . ' ' . $itemTax->last_name . '   TaxID : ' . $itemTax->tax_id }}</strong>
                                </p>
                                <p>{{ $itemTax->detail . ' ' . $itemTax->district_id . ' ' . $itemTax->subdistrict_id . ' ' . $itemTax->province_id . ' ' . $itemTax->postal_code }}<br>
                                    {{ $itemTax->mobile_phone }}</p>
                                @if ($itemTax->is_default)
                                    <button class="btn btn-default" type="button">@lang('messages.default')</button>
                                @endif
                            </div>
                        </div>
                    @endforeach


                    <div class="d-flex py-2 mt-2">
                        <a class="btn btn-address-add btn-light-2"
                            href="{{ url(app()->getLocale() . '/request-full-tax-invoice') }}">
                            <img class="icons svg-js" src="{{ asset('img/icons/icon-add-plus.svg') }}" alt="" />
                            @lang('messages.add_tax_invoice')
                        </a>
                    </div>

                    <div class="buttons button-confirm mt-4">
                        <button class="btn btn-outline-red" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div><!--modal-body-->
            </div><!--modal-content-->
        </div>

    </div>
@endsection

@section('script')
@endsection
