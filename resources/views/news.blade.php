@extends('main')
@section('title')
    @lang('messages.news')
@endsection
@section('stylesheet')
    <style>
        .custom-image {
            width: 100%;
            height: auto;
            max-height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="section p-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item active">@lang('messages.news')</li>
            </ol>

            <div class="section-header filter">
                <h1 class="title-xl text-underline">@lang('messages.news')</h1>

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
            <!--section-header-->
            <div class="card-news-lists promotion">
                <div class="row g-0">
                    @foreach ($news as $newsItem)
                        <div class="col-md-4 col-6">
                            <div class="card-news">
                                <div class="card-body">
                                    <h3>{{ $newsItem->name }}</h3>
                                    <h4 class="title-icon">
                                        <a
                                            href="{{ route('news.detail', ['lang' => app()->getLocale(), 'id' => $newsItem->slug ?: $newsItem->news_id]) }}">
                                            <img class="icons" src="{{ asset('img/icons/icon-circle-right-arrow.svg') }}"
                                                alt="Admin Icon">
                                            @lang('messages.view')
                                        </a>
                                    </h4>
                                    <p><small>@lang('messages.update') {{ $newsItem->updated_at }}</small></p>
                                </div>

                                <div class="card-photo">
                                    <div class="photo">
                                        @if ($newsItem->image !== null)
                                            <img src="{{ asset('upload/file/news/' . basename($newsItem->image)) }}"
                                                alt="" class="custom-image">
                                        @else
                                            <img src="{{ asset('upload/file/404.png') }}" alt="Default Icon"
                                                class="custom-image">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @include('pagination-front', ['items' => $news])
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
@endsection
