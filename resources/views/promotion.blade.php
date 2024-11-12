@extends('main') @section('title')
    @endsection @section('stylesheet')
    <style>
        .card-photo {
            width: 300px;
            height: 200px;
            overflow: hidden;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 10px;
        }

        .photo {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
    @endsection @section('content')
    <div class="section p-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item active">@lang('messages.promotion')</li>
            </ol>

            <div class="section-header filter">
                <h1 class="title-xl text-underline">@lang('messages.promotion')</h1>

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
                    @foreach ($promotion as $promotionItem)
                        <div class="col-md-4 col-6">
                            <div class="card-news">
                                <a class="card-link"
                                    href="{{ route('promotion.detail', ['lang' => app()->getLocale(), 'id' => $promotionItem->id]) }}"></a>
                                <div class="card-body">
                                    <h3>
                                        {{ $promotionItem->name }}
                                    </h3>

                                    <h4 class="title-icon">
                                        <img class="icons" src="{{ asset('img/icons/icon-circle-right-arrow.svg') }}"
                                            alt="" />
                                        @lang('messages.view')
                                    </h4>

                                    <p><small>@lang('messages.update') {{ $promotionItem->updated_at }}</small></p>
                                </div>
                                <!--card-body-->
                                <div class="card-photo">
                                    <div class="photo"
                                        style="
                                    background-image: url(img/thumb/photo-800x535--9.jpg);
                                ">
                                        <img src="{{ asset('upload/file/promotion/' . $promotionItem->image) }}"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                            <!--card-news-->
                        </div>
                    @endforeach
                </div>
                <!--row-->
            </div>
            @include('pagination-front', ['items' => $promotion])
        </div>
        <!--container-->
    </div>
    <!--section-->
    @endsection @section('script')
@endsection
