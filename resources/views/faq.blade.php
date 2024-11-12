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
                <li class="breadcrumb-item active">@lang('messages.qa')</li>
            </ol>

            <div class="section-header py-3">
                <h1 class="title-xl text-underline">@lang('messages.qa')</h1>
            </div>
            @foreach ($faq as $faqItem)
                <div class="accordion accordion-faq">
                    <div class="accordion-item">
                        <h2 class="accordion-header" data-bs-toggle="collapse" data-bs-target="#faq{{ $loop->index }}"
                            aria-expanded="false" aria-controls="faq{{ $loop->index }}">
                            <span class="icons"> </span>
                            {{ $faqItem->name }}
                        </h2>
                        <div id="faq{{ $loop->index }}" class="accordion-collapse collapse"
                            data-bs-parent=".accordion-faq">
                            <div class="accordion-body">
                                <p>
                                    {!! $faqItem->content !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--accordion-item-->
            @endforeach
        </div>
        <!--accordion-->
    </div>
    <!--container-->
    </div>
    <!--section-->
@endsection
@section('script')
@endsection
