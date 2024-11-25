@extends('main')
@section('title')
    @lang('messages.track_and_trace')
@endsection
@section('stylesheet')
@endsection
@section('content')
    <div class="section p-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url(app()->getLocale() . '/ ') }}">@lang('messages.home')</a></li>
                <li class="breadcrumb-item active">@lang('messages.track_and_trace')</li>
            </ol>

            <h1 class="h2 pt-2 text-capitalize text-underline">@lang('messages.track_and_trace')</h1>

            <div class="boxed track-trace my-4">
                <img class="img" src="{{ asset('img/thumb/photo-sammy-delivery.jpg') }}" alt="" />

                <div class="form-group search-tracking">
                    <input type="text" class="form-control" placeholder="Maximum 30 tracking numbers, Support”,”Space”"
                        value="EM28209172639TH" />

                    <button class="btn btn-secondary" type="button">Track</button>
                </div>

                <table class="tracking-infos">
                    <tr>
                        <td>Shipped with :</td>
                        <td>EMS Thai Post</td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <hr class="my-2" />
                        </td>
                    </tr>

                    <tr>
                        <td>Place Order :</td>
                        <td>21/09/2023 13:45</td>
                    </tr>
                    <tr>
                        <td>Paid :</td>
                        <td>21/09/2023 14:00</td>
                    </tr>
                    <tr>
                        <td>Wait for shipping :</td>
                        <td>21/09/2023 14:01</td>
                    </tr>
                    <tr>
                        <td>
                            บริษัทขนส่งเข้ารับพัสดุแล้ว<br />
                            สมุทรปราการ,บางพลี,บางปลา
                        </td>
                        <td>23/09/2023 14:01</td>
                    </tr>
                    <tr>
                        <td>
                            ถูกส่งมอบให้บริษัทขนส่งแล้ว<br />
                            สมุทรปราการ,บางพลี,บางปลา
                        </td>
                        <td>23/09/2023 14:01</td>
                    </tr>
                    <tr>
                        <td>
                            พัสดุถึงสาขาปลายทาง<br />
                            กรุงเทพ,บึงกุ่ม,นวมินทร์
                        </td>
                        <td>23/09/2023 14:01</td>
                    </tr>
                    <tr>
                        <td>พัสดุอยู่ระหว่างการนำจัดส่ง</td>
                        <td>25/09/2023 14:01</td>
                    </tr>
                    <tr class="text-success">
                        <td>พัสดุจัดส่งสำเร็จแล้ว</td>
                        <td>25/09/2023 17:01</td>
                    </tr>
                </table>

                <div class="p-5"></div>
            </div>
            <!--boxed-->
        </div>
        <!--container-->
    </div>
    <!--section-->
    @endsection @section('script')
@endsection
