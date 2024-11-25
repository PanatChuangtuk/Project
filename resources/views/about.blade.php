@extends('main')

@section('title')
    @lang('messages.abouts')
@endsection

@section('stylesheet')
@endsection

@section('content')
    <div class="section pt-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item active">@lang('messages.about')</li>
            </ol>

            <div class="banner about rounded-16" data-aos="fade-in">
                <img class="w-100 " src="{{ asset('img/thumb/photo-1920x745--1.jpg') }}" alt="">
            </div>

            <div class="boxed py-4" style="--width:1120px" data-aos="fade-in">
                <div class="article text-center fs-20">
                    <h1 class="textrow"><span data-aos="fade-up">U&V HOLDING</span></h1>
                    <p class="fs-20" style="color:#375B51;"><strong>THAILAND</strong></p>

                    <p>@lang('messages.u&v')</p>
                </div>
            </div>

            <div class="py-xl-4 py-2"></div>

            <div class="article about milestone" data-aos="fade-in">
                <h3>{{ $aboutContent->content_name ?? null }}</h3>
                <div class="row pt-3">
                    <div class="col-md-8">
                        {!! $aboutContent->content ?? null !!}
                    </div>
                </div>
            </div>


            <div class="row card-about-lists">
                @foreach ($about as $aboutItem)
                    <div class="col-xl-3 col-sm-6" data-aos="fade-in">
                        <div class="card-about">
                            <div class="card-icon">
                                <img class="icons" src="{{ asset('upload/file/milestone/' . basename($aboutItem->icon)) }}"
                                    alt="">

                            </div>
                            <div class="card-body">
                                <h3>{{ $aboutItem->content_name ?? null }}</h3>
                                <p>{{ $aboutItem->description ?? null }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="article about ">
                <div class="row pt-3">
                    <div class="col-md-8">
                        <h3 class="mb-3"> {{ $service->content_name ?? null }}</h3>
                        <ul>
                            {!! $service->content ?? null !!}
                        </ul>
                    </div>
                </div>
            </div>

            <div class="testimonial-boxed" data-aos="fade-in">
                <div class="hgroup">
                    <h2>TESTIMONIAL</h2>
                    <p>@lang('messages.in_review')</p>
                </div>

                <div class="swiper-overflow testimonial">
                    <div class="swiper-container swiper-testimonial">
                        <div class="swiper-wrapper">
                            @foreach ($testimonial as $testimonialItem)
                                <div class="swiper-slide">
                                    <div class="card-testimonial">
                                        <span class="icons icon-quotes"></span>
                                        <p>{!! $testimonialItem->content ?? null !!}</p>
                                        <div class="customer-infos">
                                            <img class="avatar"
                                                src="{{ asset('upload/file/testimonial/' . $testimonialItem->profile_image ?? null) }}"
                                                alt="">
                                            <div>
                                                <h6>{{ $testimonialItem->profile_name ?? null }}</h6>
                                                <p>{{ $testimonialItem->profile_position ?? null }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-pagination-group">
                        <div class="swiper-pagination white"></div>
                    </div>
                </div>
            </div>
            <div class="brand-boxed">
                <h2 class="title-underline text-center">Our Brand</h2>
                <div class="row logo-brand-lists">
                    @foreach ($brand as $brandItem)
                        @if ($brandItem->image !== null && file_exists(public_path('upload/file/brand/' . $brandItem->image ?? null)))
                            <div class="col-2">
                                <a href=" {{ $brandItem->url ?? null }}"><img class="logo-brand"
                                        src="{{ asset('upload/file/brand/' . $brandItem->image ?? null) }}"
                                        alt=""></a>
                            </div>
                        @else
                            <div class="col-2">
                                <a href=" {{ $brandItem->url ?? null }}"><img class="logo-brand"
                                        src="{{ asset('upload/file/404.png') }}" alt=""></a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
@endsection
