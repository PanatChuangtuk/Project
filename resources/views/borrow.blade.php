@extends('main')

@section('title')
    Equipment Management
@endsection

@section('stylesheet')
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="equipment-section">
                    <h2 class="section-title">หมวดหมู่อุปกรณ์</h2>
                    @foreach ($cart as $id => $item)
                        {{ $cart[$id]['name'] }}
                    @endforeach
                    <div class="equipment-grid">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
