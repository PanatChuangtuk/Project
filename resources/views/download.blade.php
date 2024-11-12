@extends('main')
@section('title')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section p-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item active">@lang('messages.download')</li>
            </ol>

            <div class="section-header p-0">
                <h1 class="title-xl text-underline">@lang('messages.download')</h1>
            </div>

            <div class="row download-lists">
                @foreach ($catalog as $catalogItem)
                    <div class="col-12">
                        <div class="card-download" data-aos="fade-in">
                            <div class="card-photo">
                                <div class="photo"
                                    style="
                                background-image: asset(img/thumb/photo-1000x670--1.jpg);
                            ">
                                    <img src="{{ asset('upload/file/catalog/image/' . $catalogItem->image) }}"
                                        alt="" />
                                </div>
                            </div>
                            <div class="card-body">
                                <h3>{{ $catalogItem->name }}</h3>
                                <p>
                                    {{ $catalogItem->description }}
                                </p>

                                <div class="buttons">
                                    <a class="btn"
                                        href="{{ route('download.catalog', ['lang' => app()->getLocale(), 'id' => $catalogItem->id]) }}">
                                        Catalog Download
                                        <span class="icons icon-next"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--card-product-->
                    </div>
                    <!--col-12-->
                @endforeach
                <!--card-product-->
            </div>
            <!--col-12-->
        </div>
        <!--row-->
    </div>
    <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
@endsection
