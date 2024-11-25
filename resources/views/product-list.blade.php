@extends('main')
@section('title')
    @lang('messages.product_list')
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
                <li class="breadcrumb-item active">Alfa Aesar</li>
            </ol>

            <div class="section-header filter">
                <h1 class="title-xl text-underline">@lang('messages.allproduct')</h1>

                <div class="d-flex gap-gl-4 gap-sm-3 gap-2">
                    <div class="select-pretty">
                        {{-- <img class="icons ms-3" src="img/icons/icon-row-vertical.svg" alt="" /> --}}
                        {{-- <div class="dropdown form-select"> --}}
                        {{-- <a href="#" class="fw-500 selected" data-bs-toggle="dropdown" data-bs-display="static"> --}}
                        {{-- 15 Products --}}
                        {{-- </a> --}}
                        {{-- <ul class="dropdown-menu">
                                <li class="active">15 Products</li>
                                <li>30 Products</li>
                                <li>60 Products</li>
                            </ul> --}}
                        {{-- </div> --}}
                    </div>

                    {{-- <div class="select-pretty">
                        <h6 class="ms-3">Sort By :</h6>
                        <div class="dropdown form-select">
                            <a href="#" class="fw-500 selected" data-bs-toggle="dropdown" data-bs-display="static">
                                Newest
                            </a>
                            <ul class="dropdown-menu">
                                <li class="active">Newest</li>
                                <li>Texttttt</li>
                                <li>Textttttttt</li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="row product-lists">
                @foreach ($product as $item)
                    <div class="col-12">
                        <div class="card-product" data-aos="fade-in">
                            <a href={{ route('product.detail', ['lang' => app()->getLocale(), 'id' => $item->id]) }}
                                class="card-link"></a>
                            <div class="card-photo">
                                <div class="photo"
                                    style="
                                background-image: url(img/thumb/photo-600x600--1.jpg);
                            ">
                                    <img src="{{ asset('img/thumb/frame-100x100.png') }}" alt="" />
                                </div>

                                <span class="status new">@lang('messages.new')</span>
                            </div>
                            <div class="card-body">
                                <h3>
                                    {{ $item->name }}
                                </h3>
                                <h6>{{ $item->code }}</h6>

                                <p>
                                    {!! $item->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @include('pagination-front', ['items' => $product])
        </div>
    </div>
    @endsection @section('script')
@endsection
