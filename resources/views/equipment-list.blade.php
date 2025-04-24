@extends('main')

@section('title')
    Equipment Management
@endsection

@section('stylesheet')
@endsection

@section('content')
    <div class="section section-profile bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>อุปกรณ์</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($equipment as $item)
                                <div class="col-4 border-left">
                                    <a href="{{ url('/product-list/?type=' . $item->id . '&categoryid=' . $model->id) }}">
                                        <ul class="ul-collapse">
                                            <li
                                                href="{{ url('/product-list/?type=' . $item->id . '&categoryid=' . $model->id) }}">
                                                {{ $model->name }}</li>
                                        </ul>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection


@section('script')
@endsection
