@extends('main')
@section('title')
    @lang('messages.promotion_detail')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section p-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ url(app()->getLocale() . '/promotion') }}">@lang('messages.promotion')</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $promotionContent->name ?? null }}
                </li>
            </ol>

            <div class="news-detail-boxed">
                <div class="news-hgroup">
                    <h1>
                        {{ $promotionContent->content_name ?? null }}
                    </h1>
                    <div class="date">
                        <img class="icons" src="{{ asset('img/icons/icon-calendar.svg') }}" alt="" />
                        @lang('messages.update') {{ $promotionContent->updated_at ?? null }}
                    </div>
                </div>

                <div class="news-details">
                    <div class="article">
                        <p>
                            {!! $promotionContent->content ?? null !!}
                        </p>
                    </div>
                    <!--article-->
                </div>
                <!--news-details-->
            </div>
            <!--news-detail-boxed-->
        </div>
        <!--container-->
    </div>
    <!--section-->
    @endsection @section('script')
@endsection
