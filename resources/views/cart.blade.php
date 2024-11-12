@extends('main')
@section('title')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <form action="{{ route('order.submit', ['lang' => app()->getLocale()]) }}" id="orderForm" method="POST">
        @csrf
        <div class="section section-cart bg-light pt-0">
            <div class="container has-sidebar">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item">@lang('messages.cart')</li>
                </ol>

                <div class="hgroup py-3 w-100">
                    <h1 class="h2 text-capitalize text-underline">@lang('messages.cart')</h1>
                </div>

                <div class="content">

                    <div class="table-boxed">
                        <ul class="ul-table ul-table-header cart">
                            <li class="checker">
                                <input type="checkbox" id="select_all" class="form-check-input" />
                            </li>
                        </ul>

                        @if (empty($cart))
                            <div class="empty-cart-message">
                                <h3>@lang('messages.item_is_empty')</h3>
                            </div>
                        @else
                            @foreach ($cart as $id => $item)
                                <ul class="ul-table ul-table-body cart">
                                    <li class="checker">
                                        <input type="checkbox" class="form-check-input" id="select_id"name="items[]"
                                            data-id="{{ $id }}" value="{{ $id }}" />
                                    </li>
                                    <li class="photo">
                                        <img src="{{ asset('img/thumb/photo-400x455--1.jpg') }}" alt="" />
                                    </li>
                                    <li class="info">
                                        <a class="product-info" href="{{ url(app()->getLocale() . '/product-detail') }}">
                                            <h3>{{ $item['name'] }}</h3>
                                            <label class="label">Size : {{ $item['size'] }}</label>
                                            <p><small>Model : {{ $item['model'] }}</small></p>
                                        </a>
                                    </li>
                                    <li class="qty">
                                        <div class="qty-item">

                                            <button type="button" data-id="{{ $id }}" class="btn sub"></button>

                                            <input class="form-control count" type="number"
                                                value="{{ $item['quantity'] ?? 0 }}" min="0" />

                                            <button type="button" data-id="{{ $id }}" class="btn add"></button>

                                        </div>
                                    </li>
                                    <li class="price"><strong>{{ number_format($item['price'], 2) }} ฿</strong></li>
                                    <li class="total"><strong>0.00 ฿</strong></li>
                                    <li class="action">

                                        <button type="button" data-id="{{ $id }}"
                                            class="btn btn-action btn-trans">
                                            <img class="icons svg-js red" src="{{ asset('img/icons/icon-trash.svg') }}"
                                                alt="" />
                                        </button>

                                    </li>
                                </ul>
                            @endforeach
                        @endif

                    </div>
                </div>

                <div class="sidebar">
                    <div class="card-info">
                        <h3 class="fs-18 mb-2">@lang('messages.summary')</h3>

                        <table class="table-summary">
                            <tr>
                                <td>@lang('messages.subtotal')</td>
                                <input type="hidden" name="subtotal" id="subtotal">
                                <td class="number subtotal">0.00 ฿</td>
                            </tr>
                            <tr>
                                <input type="hidden" name="vat" id="vat">
                                <td>@lang('messages.vat')</td>
                                <td class="number vat">0.00 ฿</td>
                            </tr>
                            <tr> <input type="hidden" name="shipping_fee" id="shippingFee">
                                <td>@lang('messages.shipping')</td>
                                <td class="number shipping-Free">50.00 ฿</td>
                            </tr>
                            <tr>
                                <input type="hidden" name="discount" id="discount">
                                <td>@lang('messages.discount')</td>
                                <td class="number discount text-danger">-50.00 ฿</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr />
                                </td>
                            </tr>
                            <tr class="total">
                                <input type="hidden" name="total" id="total">
                                <td>@lang('messages.total')</td>
                                <td class="net-total number">0.00 ฿</td>
                            </tr>
                        </table>

                        <div class="buttons flex-column pb-0 pt-4">
                            <input class="btn btn-48" type="submit" value="Continue">
                            <a class="btn btn-48 btn-dark" href="{{ url(app()->getLocale() . '/product') }}">
                                <span class="fs-13">Add Product</span>
                            </a>
                        </div>
                    </div>

                    {{-- href="{{ url(app()->getLocale() . '/cart-check-out') }}" --}}


    </form>

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
                    <label class="label label-free">@lang('messages.free_shipping')</label>
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

            <p class="fs-12 pt-2">10 @lang('messages.points') = 1 @lang('messages.currency_th')</p>
        </div>
    </div><!--card-info-->
    </div>
    </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            function calculateTotal() {
                let subtotal = 0;
                $('.ul-table-body.cart').each(function() {
                    const qty = parseInt($(this).find('.count').val()) || 0;
                    const price = parseFloat($(this).find('.price strong').text().replace(/[^0-9.-]+/g,
                        '')) || 0;
                    const itemTotal = qty * price;
                    $(this).find('.total strong').text(itemTotal.toFixed(2) + ' ฿');
                    subtotal += itemTotal;
                });

                $('.subtotal').text(subtotal.toFixed(2) + ' ฿');
                $('#subtotal').val(subtotal.toFixed(2));
                calculateVAT(subtotal);
                calculateNetTotal(subtotal);
            }

            function calculateVAT(subtotal) {
                const vatRate = 0.07;
                const vat = subtotal * vatRate;
                $('#vat').val(vat.toFixed(2));
                $('.vat').text(vat.toFixed(2) + ' ฿');
            }

            function calculateNetTotal(subtotal) {
                const shippingFee = 50;
                const discount = -50;
                const vat = subtotal * 0.07;
                const netTotal = subtotal + vat + shippingFee + discount;
                $('#total').val(netTotal.toFixed(2));
                $('.net-total').text(netTotal.toFixed(2) + ' ฿');
            }

            $('.ul-table-body').on('click', '.add', function() {
                const input = $(this).siblings('.count');
                let currentValue = parseInt(input.val()) || 0;
                input.val(currentValue++);
                calculateTotal();
            });

            $('.ul-table-body').on('click', '.sub', function() {
                const input = $(this).siblings('.count');
                let currentValue = parseInt(input.val()) || 0;
                if (currentValue > 0) {
                    input.val(currentValue--);
                }
                calculateTotal();
            });

            $('#select_all').on('click', function() {
                $('.form-check-input').not('#select_all').prop('checked', this.checked);
            });

            $('.form-check-input').not('#select_all').on('click', function() {
                $('#select_all').prop('checked', $('.form-check-input').not('#select_all').length === $(
                    '.form-check-input:checked').not('#select_all').length);
            });
            $('.btn.sub').on('click', function() {
                var itemId = $(this).data('id');
                $.ajax({
                    url: '{{ route('cart.remove', ['lang' => app()->getLocale(), 'id' => ':id']) }}'
                        .replace(':id', itemId),
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                });
            });
            calculateTotal();
            $('.btn.add').on('click', function() {
                var itemId = $(this).data('id');
                $.ajax({
                    url: '{{ route('cart.add', ['lang' => app()->getLocale(), 'id' => ':id']) }}'
                        .replace(':id', itemId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                });
            });
            calculateTotal();

            $('.btn-action').on('click', function() {
                var itemId = $(this).data('id');
                var itemElement = $(this).closest('ul.ul-table-body.cart');
                $.ajax({
                    url: '{{ route('cart.delete', ['lang' => app()->getLocale(), 'id' => ':id']) }}'
                        .replace(':id', itemId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status == 'delete') {
                            itemElement.fadeOut(320, function() {
                                $(this).remove();
                                calculateTotal();
                            });
                        }
                    },
                });
            });
            calculateTotal();


        });
    </script>
@endsection
