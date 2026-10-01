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

        .status-row {
            display: inline-flex;
            align-items: center;
            vertical-align: middle;
            margin-left: 15px;
        }

        .status-value {
            display: inline-block;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 14px;
            vertical-align: middle;
        }

        .status-overdue {
            background-color: #ffebee;
            color: #d32f2f;
            border: 1px solid #ffcdd2;
        }

        .status-icon {
            margin-right: 6px;
            font-size: 16px;
        }

        /* สไตล์สำหรับหัวข้อที่มีสถานะ */
        h4.display-4 {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* รองรับการแสดงผลบนอุปกรณ์มือถือ */
        @media (max-width: 768px) {
            h4.display-4 {
                flex-direction: column;
                align-items: flex-start;
            }

            .status-row {
                margin-left: 0;
                margin-top: 10px;
            }
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
            $fmt = fn($date) => $date ? $date->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i') : '-';
            $typeClass = ['ยืมอุปกรณ์' => 'bg-warning', 'คืนอุปกรณ์' => 'bg-success', 'เกินกำหนด' => 'bg-danger'];
            $overdueDays = $borrow->overdueDays();
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
            <label class="col-md-2 fw-bold">วันที่ยืม / คืน :</label>
            <div class="col-md-10">
                ยืม {{ $fmt($borrow->borrowed_at) }}
                <span class="text-muted ms-3">กำหนดคืน {{ $fmt($borrow->due_at) }}</span>
                <span class="ms-3">คืน {{ $fmt($borrow->returned_at) }}</span>
            </div>
        </div>

        <div class="card p-4">
            <h4 class="display-4">
                อุปกรณ์
                @if ($overdueDays)
                    <div class="status-row">
                        <div class="status-value">
                            <span class="status-badge status-overdue" id="overdue">
                                <span class="status-icon">⚠️</span> ยืมอุปกรณ์เกินกำหนด
                                <span class="ms-2 text-danger">({{ $overdueDays }} วัน)</span>
                            </span>
                        </div>
                    </div>
                @endif
            </h4>
            <div class="table">
                <table class="table table-bordered custom-table">
                    <thead>
                        <tr>
                            <th class="text-center">รูปอุปกรณ์</th>
                            <th class="text-center">ชื่ออุปกรณ์</th>
                            <th class="text-center">เลขอุปกรณ์</th>
                            <th class="text-center">สภาพอุปกรณ์</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="orderTableBody">
                        @foreach ($borrow->details as $item)
                            <tr>
                                <td class="text-center align-middle">
                                    <img src="{{ $item->equipmentItem?->image ? asset('upload/file/equipment_item/' . $item->equipmentItem->image) : asset('images/default-image.png') }}"
                                        class="equipment-img">
                                </td>
                                <td class="text-center align-middle">
                                    {{ $item->name ?? null }}
                                </td>
                                <td class="text-center align-middle">
                                    {{ $item->equipment->number ?? '-' }}
                                </td>
                                <td class="text-center align-middle">
                                    @if ($item->condition === 'normal')
                                        <span class="badge bg-success">ปกติ</span>
                                    @elseif ($item->condition === 'damaged')
                                        <span class="badge bg-warning">ชำรุด</span>
                                    @elseif ($item->condition === 'lost')
                                        <span class="badge bg-danger">สูญหาย</span>
                                    @else
                                        -
                                    @endif
                                    @if ($item->condition_note)
                                        <div class="small text-muted mt-1">{{ $item->condition_note }}</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
