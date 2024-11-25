@extends('main')
@section('title')
    @lang('messages.product_detail')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section p-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ url(app()->getLocale() . '/product') }}">@lang('messages.allproduct')</a>
                </li>
                <li class="breadcrumb-item active">@lang('messages.product')</li>
            </ol>

            <div class="product-details">
                <div class="cols left">
                    <a class="card-photo" data-fancybox href="{{ asset('img/thumb/photo-800x800--1.jpg') }}">
                        <div class="photo"
                            style="
                            background-image: url({{ asset('img/thumb/photo-800x800--1.jpg') }});
                        ">
                            <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="" />
                        </div>

                        <span class="product-status new">@lang('messages.news')</span>
                    </a>
                </div>
                <!--cols-->
                <div class="cols right">
                    <h1 class="mb-sm-4 mb-2">
                        {{ $product->name }}
                    </h1>



                    <h6 class="mb-sm-4 mb-2">
                        @lang('messages.product_code') : <span class="text-black">{{ $product->code }}</span>
                    </h6>

                    <div class="d-flex mb-sm-4 mb-2">
                        <h6 class="title-icon">
                            <img class="icons w-20" src="{{ asset('img/icons/icon-star.svg') }}" alt="" />
                            (0 @lang('messages.reviews'))
                        </h6>

                        <div class="product-icons ms-auto">
                            <button class="btn btn-favorite" type="button">
                                <img class="svg-js icons" src="{{ asset('img/icons/icon-favorite.svg') }}" alt="" />
                            </button>
                            <!-- <button class="btn btn-favorite active" type="button">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <img class="svg-js icons" src="img/icons/icon-favorite.svg" alt="">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           </button> -->
                            <button class="btn btn-share" type="button">
                                <img class="svg-js icons" src="{{ asset('img/icons/icon-share.svg') }}" alt="" />
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <form action="{{ route('product.submit', ['lang' => app()->getLocale()]) }}" method="POST">
                            @csrf
                            <table class="table table-product-info">
                                <thead>
                                    <tr>
                                        <th class="pd-id"> @lang('messages.product_id')</th>
                                        <th class="pd-size"> @lang('messages.product_size')</th>
                                        <th class="pd-stock"> @lang('messages.stock')</th>
                                        <th class="pd-price"> @lang('messages.price')</th>
                                        <th class="pd-qty"> @lang('messages.quantity')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($product_list as $item)
                                        <tr>
                                            <input type="hidden" class="label" name="id[]"
                                                value="{{ $item->product->id ?? '' }}">
                                            <input type="hidden" class="label" name="model[]"
                                                value="{{ $item->product->model ?? '' }}">
                                            <input type="hidden" class="label" name="name[]"
                                                value="{{ $item->product->name ?? '' }}">

                                            <td data-title="Product ID">
                                                <input type="hidden" class="label" name="sku[]"
                                                    value="{{ $item->product->sku ?? '' }}">
                                                <span class="label">{{ $item->product->sku ?? 'N/A' }}</span>
                                            </td>
                                            <td data-title="Product size">
                                                <input type="hidden" class="label" name="size[]"
                                                    value="{{ $item->product->size ?? '' }}">
                                                {{ $item->product->size ?? 'N/A' }}
                                            </td>
                                            <td data-title="Stock">109</td>
                                            <td data-title="Price">
                                                <input type="hidden" class="label" name="price[]"
                                                    value="{{ $item->price }}">
                                                {{ number_format($item->price ?? 0, 2) }} ฿
                                            </td>
                                            <td data-title="Quantity">
                                                <div class="qty-item-group">
                                                    <div class="qty-item">
                                                        <div class="product">
                                                            <button class="btn sub" type="button"></button>
                                                        </div>
                                                        <input class="form-control count" type="number" name="quantity[]"
                                                            value="0" min="0" max="100" />
                                                        <div class="product">
                                                            <button class="btn add" type="button"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="buttons">
                                <button class="btn btn-secondary btn-48 ms-auto" type="submit"
                                    data-bs-target="#successModal" data-bs-toggle="modal">
                                    <span class="px-2">@lang('messages.add_to_cart')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--cols-->
            </div>
            <!--product-detail-->

            <div class="py-4">
                <hr class="green" />
            </div>

            <div class="product-infos">
                <div class="row g-md-4 g-3">
                    <div class="col-lg-7">
                        <h3 class="fs-20 text-black">@lang('messages.product_description')</h3>

                        <div class="article">
                            <ul>
                                <li>
                                    {!! $product->description !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--col-lg-7-->
                    <div class="col-lg-5">
                        <h3 class="fs-20 text-black">@lang('messages.other_information')</h3>

                        <table class="table table-spec mb-md-2 mb-0">
                            <thead>
                                <tr>
                                    <th colspan="2">@lang('messages.technical_details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_info as $item)
                                    <tr>
                                        <td style="width: 150px">{{ $item->productAttribute->name ?? '' }}</td>
                                        <td>{{ $item->detail }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--col-lg-5-->
                </div>
                <!--row-->
            </div>
            <!--product-infos-->

            <div class="py-xl-5 py-4">
                <hr class="green" />
            </div>
            <form method="POST" action="{{ route('product.review.submit', ['lang' => app()->getLocale()]) }}">
                @csrf
                <input type="hidden" name="product_model_id" value="{{ $product->id }}">
                <div class="product-reviews">
                    <div class="row">
                        <div class="col-md-3 col-lg-5">
                            <h2 class="mb-3">@lang('messages.reviews')</h2>

                            <p class="fs-20 mb-1">({{ $totalReviews }} @lang('messages.reviews'))</p>
                            <p class="fs-20">@lang('messages.write_reviews')</p>
                        </div>
                        <!--col-lg-5-->
                        <div class="col-md-9 col-lg-7">
                            <div class="rating-block mb-4">
                                <p>@lang('messages.star_rating')</p>
                                <div class="star-rating">
                                    <span class="icons" data-value="1"></span>
                                    <span class="icons" data-value="2"></span>
                                    <span class="icons" data-value="3"></span>
                                    <span class="icons" data-value="4"></span>
                                    <span class="icons" data-value="5"></span>
                                </div>
                                <input type="hidden" name="star_rating" id="star-rating-input">
                            </div>

                            <textarea class="form-control" name="comment" placeholder="Enter"></textarea>

                            <div class="recaptcha my-4 py-sm-1">
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="buttons pt-0 pb-3">
                                <button class="btn btn-48 me-auto" type="submit">
                                    <span class="px-5">@lang('messages.send')</span>
                                </button>
                            </div>

            </form>
            @if ($review->count())
                <div class="py-4">
                    <hr class="green" />
                </div>
                <h3 class="fs-20 mb-4">@lang('messages.featured_reviews')</h3>
            @endif
            @foreach ($review as $item)
                <div class="card-review">
                    <div class="card-header">
                        <img class="avatar" src="{{ asset('img/thumb/avatar-2.jpg') }}" alt="" />
                        <div>
                            <h4>
                                {{ $item->username }}
                            </h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="stars {{ $i <= $item->star_rating ? 'active' : '' }}"></span>
                            @endfor
                        </div>

                        <p>
                            {{ $item->comments }}
                        </p>
                    </div>
                </div>
            @endforeach


            {{-- <ul class="pagination pt-3">
                <li class="page-item">
                    <a class="page-link arrow prev" href="#">
                        <img class="icons svg-js" src="{{ asset('img/icons/icon-next.svg') }}" alt="" />
                    </a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">4</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">5</a>
                </li>
                <li class="page-item">
                    <a class="page-link arrow next" href="#">
                        <img class="icons svg-js" src="{{ asset('img/icons/icon-next.svg') }}" alt="" />
                    </a>
                </li>
            </ul> --}}
            @include('pagination-front', ['items' => $review])
        </div>
        <!--col-md-7-->
    </div>
    <!--row-->
    </div>
    <!--product-reviews-->

    {{-- <div class="product-related">
        <div class="hgroup">
            <h3>You may also like</h3>

            <a class="viewall" href="{{ url(app()->getLocale() . '/product') }}">View All <span
                    class="icons"></span></a>
        </div>

        <div class="product-related-lists">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="card-product thumb">
                        <a class="card-link" href="product-details.html"></a>
                        <div class="card-photo">
                            <div class="photo"
                                style="
                                        background-image: url(img/thumb/photo-600x600--3.jpg);
                                    ">
                                <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="" />
                            </div>

                            <span class="status new">NEW</span>
                        </div>
                        <div class="card-body px-0">
                            <h3>Bottle media wide mount GL80 5000ml ...</h3>
                            <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                            <div class="price-block">
                                <p class="price">฿7,290.00</p>
                                <p class="price-old">฿10,760.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card-product thumb">
                        <a class="card-link" href="product-details.html"></a>
                        <div class="card-photo">
                            <div class="photo"
                                style="
                                        background-image: url(img/thumb/photo-600x600--2.jpg);
                                    ">
                                <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="" />
                            </div>

                            <span class="status promotion">Promotion</span>
                        </div>
                        <div class="card-body px-0">
                            <h3>Nickel(II) carbonate 4H2O CP</h3>
                            <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                            <div class="price-block">
                                <p class="price">฿7,290.00</p>
                                <p class="price-old">฿10,760.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card-product thumb">
                        <a class="card-link" href="product-details.html"></a>
                        <div class="card-photo">
                            <div class="photo"
                                style="
                                        background-image: url(img/thumb/photo-600x600--1.jpg);
                                    ">
                                <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="" />
                            </div>

                            <span class="status new">NEW</span>
                        </div>
                        <div class="card-body px-0">
                            <h3>Acetonitrile Gradient Grade</h3>
                            <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                            <div class="price-block">
                                <p class="price">฿7,290.00</p>
                                <p class="price-old">฿10,760.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card-product thumb">
                        <a class="card-link" href="product-details.html"></a>
                        <div class="card-photo">
                            <div class="photo"
                                style="
                                        background-image: url(img/thumb/photo-600x600--4.jpg);
                                    ">
                                <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="" />
                            </div>

                            <span class="status new">NEW</span>
                        </div>
                        <div class="card-body px-0">
                            <h3>
                                Flask Volumetric, amber, PE stopper, 5ml,
                                Class...
                            </h3>
                            <p class="code">รหัสสินค้า : DAE-1217-2304</p>

                            <div class="price-block">
                                <p class="price">฿7,290.00</p>
                                <p class="price-old">฿10,760.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--row-->
        </div>
    </div> --}}
    <!--product-related-->
    </div>
    <!--container-->
    </div>
    <!--section-->
    @endsection @section('script')
    <script>
        const stars = document.querySelectorAll('.icons');
        const inputField = document.getElementById('star-rating-input');

        stars.forEach(star => {
            star.addEventListener('click', (e) => {
                const rating = e.target.getAttribute('data-value');
                updateStarRating(rating);
                inputField.value = rating;
            });

            star.addEventListener('mouseover', () => {
                const rating = star.getAttribute('data-value');
                updateStarRating(rating, true);
            });

            star.addEventListener('mouseout', () => {
                const rating = inputField.value;
                updateStarRating(rating);
            });
        });

        function updateStarRating(rating, isHover = false) {
            stars.forEach(star => {
                const starValue = star.getAttribute('data-value');
                if (starValue <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
                if (isHover && starValue > rating) {
                    star.classList.remove('active');
                }
            });
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js?hl={{ app()->getLocale() }}" async defer></script>
@endsection
