@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <style>
        .photo {
            width: 100px;
            flex-shrink: 0;
        }

        .equipment-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--border-radius);
            margin-right: 1.5rem;
            border: 1px solid var(--gray-200);
            transition: var(--transition);
            background-color: var(--white);
            padding: 0.25rem;
        }

        .equipment-item:hover .equipment-img {
            border-color: var(--secondary);
        }

        .equipment-img {
            width: 100%;
            height: auto;
            max-height: 150px;
            object-fit: contain;
            margin-right: 0;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าหลัก</a></li>
        <li class="breadcrumb-item"><a href="{{ route('administrator.approve-equipment') }}">อนุมัติการยืมอุปกรณ์</a></li>
    </ol>

    <div class="card p-4">
        <div class="mb-4 row">
            <label for="member_id" class="col-md-2 fw-bold">ชื่อ-นามสกุล :</label>
            <div class="col-md-10">
                {{ $borrow->member->info->first_name ?? null }} {{ $borrow->member->info->last_name ?? null }}
            </div>
        </div>

        <div class="mb-4 row">
            <label for="member_id" class="col-md-2 fw-bold">เบอร์โทร :</label>
            <div class="col-md-10">
                {{ $borrow->member->info->mobile_phone ?? null }}
            </div>
        </div>

        <div class="mb-4 row">
            <label for="member_id" class="col-md-2 fw-bold">รหัสนักศึกษา :</label>
            <div class="col-md-10">
                {{ $borrow->member->email ?? null }}
            </div>
        </div>

        <div class="mb-4 row">
            <label for="member_id" class="col-md-2 fw-bold">รหัสนักศึกษา :</label>
            <div class="col-md-10">
                {{ $borrow->member->info->student->student_number ?? null }}
            </div>
        </div>
        <div class="mb-4 row">
            <label for="member_id" class="col-md-2 fw-bold">สถานะคำร้อง :</label>
            <div class="col-md-10">
                <x-approve-dropdown :status="$borrow->status" :item="$borrow->id" />
            </div>
        </div>

        <div class="card p-4">
            <h4 class="display-4">อุปกรณ์</h4>
            <form method="POST" action="{{ route('administrator.approve-equipment.approveEquipment') }}">
                @csrf
                <div class="table">
                    <table class="table table-bordered border-light">
                        <thead>
                            <tr>
                                <th class="text-center"> </th>
                                <th class="text-center">ชื่ออุปกรณ์</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-center">เลขอุปกรณ์</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="orderTableBody">
                            @foreach ($borrow->loanEquipments as $key => $item)
                                <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                <tr>
                                    <td class="text-center align-middle">
                                        <img src="{{ $item->equipmentItem->image ? asset('upload/file/equipment_item/' . $item->equipmentItem->image) : asset('images/default-image.png') }}"
                                            class="equipment-img">
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->name ?? null }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->quantity ?? null }} ชิ้น
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->equipment->number ?? null }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </form>
        </div>


    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'สำเร็จ!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'ตกลง'
            }).then(function() {
                window.location.href = '{{ route('administrator.return-equipment') }}';
            });
        </script>
    @endif
    <script>
        $(document).on('click', '.dropdown-item', function() {
            var status = $(this).data('status');
            var item = $(this).data('item');
            $.ajax({
                url: '{{ route('administrator.approve-equipment.update') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    item: item,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            text: 'อัปเดตสถานะสำเร็จ',
                            confirmButtonText: 'OK'
                        });
                    }
                },
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                var status = $(this).data('status');
                var button = $(this).closest('.dropdown').find('button');

                if (status == 'completed') {
                    button.text('อนุมัติ');
                } else if (status == 'cancel') {
                    button.text('ยกเลิก');
                } else {
                    button.text('รอดำเนินการ');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.adviser-select').each(function(index) {
                var selectId = $(this).attr('id');
                var itemId = $(this).data('item-id');

                $('#' + selectId).select2({
                    ajax: {
                        url: '{{ url('api/get-equipment') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                query: params.term,
                                item_id: itemId
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results.map(function(item) {
                                    return {
                                        id: item.id,
                                        text: item.number,
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });
            });
        });
    </script>
@endsection
