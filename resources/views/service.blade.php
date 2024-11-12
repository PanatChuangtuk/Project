@extends('main') @section('title')
    @endsection @section('stylesheet')
    @endsection @section('content')
    <div class="section pt-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item active">@lang('messages.service')</li>
            </ol>

            <div class="banner about rounded-16 mb-4" data-aos="fade-in">
                <img class="w-100" src="{{ asset('img/thumb/photo-1920x745--2.jpg') }}" alt="" />
            </div>

            <h1 class="py-3 text-center">{{ $service->content_name }}</h1>
            <div class="article">
                <ul>
                    {!! $service->content !!}
                </ul>
            </div>

            <div class="buttons mb-5">
                <a class="btn btn-48 gap-3 px-5" href="product.html">
                    <img class="icons svg-js white" src="{{ asset('img/icons/icon-cart.svg') }}" alt="" />
                    Go to Shop
                    <img class="icons svg-js white" src="{{ asset('img/icons/icon-next-2.svg') }}" alt="" />
                </a>
            </div>
        </div>
        <!--container-->
    </div>
    <!--section-->
    @endsection @section('script')
@endsection
