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

        .table-bordered.custom-table {
            border: 3px solid #3EB489;
            /* เส้นขอบตารางหนา 3px สีดำ */
        }

        .table-bordered.custom-table th,
        .table-bordered.custom-table td {
            border: 3px solid #3EB489;
            /* เส้นขอบเซลล์หนา 3px สีดำ */
        }

        .table-bordered.custom-table thead th {
            background-color: #f7f7f7;
            /* พื้นหลังส่วนหัวสีเทาเข้ม */
            color: #000000;
            /* ตัวอักษรสีขาว */
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
            <label for="member_id" class="col-md-2 fw-bold">อีเมลนักศึกษา :</label>
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

        @php
            $isPending = $borrow->status === 'pending';
            $isReturn = $borrow->status === 'return_pending';
            $canAct = $isPending || $isReturn;
            $fmt = fn($date) => $date ? $date->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i') : '-';
            $typeClass = ['ยืมอุปกรณ์' => 'bg-warning', 'คืนอุปกรณ์' => 'bg-success', 'เกินกำหนด' => 'bg-danger'];
        @endphp

        <div class="mb-4 row">
            <label class="col-md-2 fw-bold">ชนิดคำร้อง :</label>
            <div class="col-md-10">
                <span class="badge {{ $typeClass[$borrow->requestTypeLabel()] ?? 'bg-secondary' }} px-3 py-2 rounded-pill fw-normal">
                    {{ $borrow->requestTypeLabel() }}
                </span>
            </div>
        </div>

        <div class="mb-4 row">
            <label class="col-md-2 fw-bold">สถานะ :</label>
            <div class="col-md-10">{{ $borrow->stageLabel() }}</div>
        </div>

        <div class="mb-4 row">
            <label class="col-md-2 fw-bold">วันที่ยืม :</label>
            <div class="col-md-10">
                {{ $fmt($borrow->borrowed_at) }}
                <span class="text-muted ms-3">กำหนดคืน {{ $fmt($borrow->due_at) }}</span>
                @if ($borrow->overdueDays())
                    <span class="text-danger ms-3">เกินกำหนด {{ $borrow->overdueDays() }} วัน</span>
                @endif
            </div>
        </div>

        <div class="card p-4">
            <h4 class="display-4">อุปกรณ์</h4>
            <form id="approveForm" method="POST" action="{{ route('administrator.approve-equipment.approveEquipment') }}">
                @csrf
                <input type="hidden" name="master_id" value="{{ $borrow->id }}">
                <div class="table">
                    <table class="table table-bordered  custom-table">
                        <thead>
                            <tr>
                                <th class="text-center">รูปอุปกรณ์</th>
                                <th class="text-center">ชื่ออุปกรณ์</th>
                                <th class="text-center">อุปกรณ์ที่ให้ยืม</th>
                                @if ($isReturn)
                                    <th class="text-center">สภาพอุปกรณ์ที่ได้รับคืน</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-dark" id="orderTableBody">
                            @foreach ($borrow->details as $key => $item)
                                <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                <tr>
                                    <td class="text-center align-middle">
                                        <img src="{{ $item->equipmentItem?->image ? asset('upload/file/equipment_item/' . $item->equipmentItem->image) : asset('images/default-image.png') }}"
                                            class="equipment-img">
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->name ?? null }}
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($isPending)
                                            <select name="equipments_id[]" id="equipmentsSelect{{ $key }}"
                                                class="form-control adviser-select"
                                                data-item-id="{{ $item->equipment_item_id ?? '' }}" required>
                                                <option value="">เลขอุปกรณ์</option>
                                            </select>
                                        @else
                                            <span class="badge bg-success">{{ $item->equipment->number ?? '-' }}</span>
                                        @endif
                                    </td>
                                    @if ($isReturn)
                                        <td class="align-middle">
                                            <select name="conditions[]" class="form-select mb-2" required>
                                                @foreach (\App\Models\EqmHistoryDetail::CONDITIONS as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ ($item->condition ?? 'normal') === $value ? 'selected' : '' }}>
                                                        {{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="condition_notes[]" class="form-control"
                                                maxlength="255" placeholder="หมายเหตุ (ถ้ามี)"
                                                value="{{ $item->condition_note }}">
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($canAct)
                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <button type="button" class="btn btn-outline-danger btn-cancel" data-item="{{ $borrow->id }}"
                            data-status="cancel">
                            <i class="fas fa-times-circle me-1"></i> {{ $isReturn ? 'ปฏิเสธการคืน' : 'ยกเลิกการยืม' }}
                        </button>
                        <button type="submit"id="submitBtn" class="btn btn-primary">
                            <i class="fas fa-check-circle me-1"></i> {{ $isReturn ? 'ยืนยันการคืน' : 'ยืนยันการยืม' }}
                        </button>
                    </div>
                @endif
            </form>
        </div>

        @include('administrator.partials.eqm_timeline', ['borrow' => $borrow])

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
                window.location.href = '{{ route('administrator.approve-equipment') }}';
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                // title: 'กรุณาเลือกหมายเลขอุปกรณ์!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'ตกลง'
            });
        </script>
    @endif
    <script>
        $('#submitBtn').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'ยืนยันการดำเนินการ',
                text: @json($isReturn ? 'คุณต้องการยืนยันการคืนอุปกรณ์ใช่หรือไม่? อุปกรณ์ที่ชำรุด/สูญหายจะถูกปิดใช้งานอัตโนมัติ' : 'คุณต้องการยืนยันการยืมอุปกรณ์ใช่หรือไม่?'),
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#approveForm').submit();
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-cancel', function() {
            var status = $(this).data('status');
            var item = $(this).data('item');

            Swal.fire({
                title: 'ยืนยันการดำเนินการ',
                text: @json($isReturn ? 'ปฏิเสธการคืน? รายการจะกลับเป็นกำลังยืม' : 'คุณต้องการยกเลิกรายการนี้ใช่หรือไม่?'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
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
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                }).then(function() {
                                    window.location.href =
                                        '{{ route('administrator.approve-equipment') }}';
                                });
                            }
                        },
                    });
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
