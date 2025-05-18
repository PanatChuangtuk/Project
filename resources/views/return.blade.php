@extends('main')

@section('title')
    โปรไฟล์ | รายการยืมคืน
@endsection

@section('stylesheet')
    <style>
        .card-info.purchase {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .card-info.purchase:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        }

        .info-row {
            padding: 15px 0;
        }

        .info-row.border-bottom-1 {
            border-bottom: 1px solid #eaeaea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .purchase-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .purchase-status.borrowed {
            background-color: #e6f7ff;
            color: #0088cc;
        }

        .purchase-status.overdue {
            background-color: #fff2e6;
            color: #ff8c00;
        }

        .purchase-status.returned {
            background-color: #e6fff2;
            color: #00cc88;
        }

        .purchase-status.in_process {
            background-color: #e6f7ff;
            color: #0088cc;
        }

        .purchase-status.completed {
            background-color: #e6fff2;
            color: #00cc88;
        }

        .purchase-status.cancel {
            background-color: #ffe6e6;
            color: #cc0000;
        }

        .ul-table-body {
            padding: 15px 0;
            border-bottom: 1px solid #eaeaea;
        }

        .ul-table-body .photo img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .ul-table-body .info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .return-btn {
            display: inline-block;
            padding: 8px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .return-btn:hover {
            background-color: #3e8e41;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
        }

        .cancel-btn {
            display: inline-block;
            padding: 8px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            background-color: #3e8e41;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
        }


        .equipment-status {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .delivery-info {
            background-color: #f8f9fa;
            padding: 14px;
            border-radius: 8px;
            font-size: 14px;
            border-left: 3px solid #4CAF50;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
        }

        .page-title i {
            margin-right: 10px;
            color: #4CAF50;
        }

        /* CSS จากที่คุณให้มา */
        .card-info.main {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .card-info.purchase {
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
            margin-bottom: 24px;
            transition: all 0.3s ease;
            background-color: #fff;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            position: relative;
        }

        /* ... รวม CSS อื่น ๆ ที่คุณให้มา ... */

        .tab-menu {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .tab-menu::-webkit-scrollbar {
            display: none;
        }

        .tab-item {
            padding: 12px 20px;
            font-weight: 500;
            color: #666;
            cursor: pointer;
            white-space: nowrap;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .tab-item:hover {
            color: #4CAF50;
        }

        .tab-item.active {
            color: #4CAF50;
            border-bottom-color: #4CAF50;
        }

        .tab-item .badge {
            background-color: #f0f0f0;
            color: #666;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
            margin-left: 5px;
        }

        .tab-item.active .badge {
            background-color: #e9f7ef;
            color: #27ae60;
        }

        /* ปรับเพิ่มเติมสำหรับ Mobile */
        @media (max-width: 768px) {
            .info-row.border-bottom-1 {
                flex-direction: column;
                align-items: flex-start;
            }

            .purchase-status {
                margin-top: 10px;
            }

            .info-row.d-flex {
                flex-direction: column;
                gap: 15px;
            }

            .return-btn {
                width: 100%;
            }

            .cancel-btn {
                width: 100%;
            }

            .loan-date {
                display: block;
                margin-bottom: 5px;
            }

            .ul-table-body {
                flex-wrap: wrap;
            }

            .ul-table-body .photo {
                margin-right: 10px;
            }

            .ul-table-body .photo img {
                width: 70px;
                height: 70px;
            }

            .ul-table-body .info {
                width: calc(100% - 95px);
            }

            .ul-table-body .qty {
                width: 100%;
                text-align: left;
                margin-top: 10px;
                padding: 0;
            }
        }

        .purchase-status.canceled {
            background-color: #f8d7da;
            /* Light red background */
            color: #721c24;
            /* Dark red text */
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            /* Space between icon and text */
            transition: background-color 0.3s ease;
        }

        .purchase-status.canceled:hover {
            background-color: #f5c6cb;
            /* Slightly darker red on hover */
        }

        .purchase-status.canceled i {
            font-size: 1.1em;
            /* Slightly larger icon */
        }

        .purchase-status.unknown {
            background-color: #f0f0f0;
            /* Neutral gray background */
            color: #666;
            /* Neutral text color */
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.3s ease;
        }

        .purchase-status.unknown:hover {
            background-color: #e0e0e0;
            /* Slightly darker gray on hover */
        }

        .purchase-status.unknown i {
            font-size: 1.1em;
        }
    </style>
@endsection

@section('content')
    <div class="section section-profile bg-light pt-4">
        <div class="container has-sidebar">
            <x-nav-profile />
            <!--sidebar-->

            <div class="content">
                <div class="card-info main px-4 py-3">
                    <h2 class="page-title"><i class="fas fa-box-open"></i> รายการยืมอุปกรณ์</h2>
                    <div class="tab-menu">
                        <div class="tab-item {{ request('status') == '' ? 'active' : '' }}">
                            <a href="{{ route('return.index', ['status' => '']) }}">
                                ทั้งหมด
                                <span class="badge">{{ count($statusBorrow) }}</span>
                            </a>
                        </div>
                        <div class="tab-item {{ request('status') == 'borrowed' ? 'active' : '' }}">
                            <a href="{{ route('return.index', ['status' => 'borrowed']) }}">
                                กำลังยืม
                                <span class="badge">{{ count($statusBorrow->where('status_type', 'borrowed')) }}</span>
                            </a>
                        </div>

                        <div class="tab-item {{ request('status') == 'returned' ? 'active' : '' }}">
                            <a href="{{ route('return.index', ['status' => 'returned']) }}">
                                คืนแล้ว
                                <span class="badge">{{ count($statusBorrow->where('status_type', 'returned')) }}</span>
                            </a>
                        </div>

                        <div class="tab-item {{ request('status') == 'overdue' ? 'active' : '' }}">
                            <a href="{{ route('return.index', ['status' => 'overdue']) }}">
                                เลยกำหนด
                                <span class="badge">{{ count($statusBorrow->where('status_type', 'overdue')) }}</span>
                            </a>
                        </div>
                    </div>
                    @if (count($borrow) == 0)
                        <div class="text-center py-5">
                            <h4>ไม่มีรายการยืมอุปกรณ์</h4>
                        </div>
                    @endif

                    @foreach ($borrow as $item)
                        <div class="card-info purchase pt-3 px-4 mb-4">
                            <div class="info-row border-bottom-1">
                                <div>
                                    @if ($item->status_type == 'borrowed' || $item->status_type == 'overdue')
                                        @if ($item->status === 'in_process')
                                            <label class="purchase-status {{ $item->status_type }}">
                                                อยู่ระหว่างดำเนินการ
                                            </label>
                                        @elseif ($item->status === 'completed')
                                            <p><strong>ยืมวันที่ : </strong>
                                                {{ \Carbon\Carbon::parse($item->borrowed_at)->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i') }}
                                                น.
                                            </p>
                                            <p class="mb-0" style="color: #ff5722;"><strong>กำหนดคืน : </strong>
                                                {{ \Carbon\Carbon::parse($item->borrowed_at)->setTimezone('Asia/Bangkok')->addDays(7)->locale('th')->translatedFormat('d M Y H:i') }}
                                                น.
                                            </p>
                                        @else<div class="purchase-status canceled">
                                                <i class="fas fa-times-circle"></i>
                                                <span>ยกเลิก</span>
                                            </div>
                                        @endif
                                    @else
                                        <p><strong>คืนวันที่ : </strong>
                                            {{ \Carbon\Carbon::parse($item->returned_at)->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i') }}
                                            น.
                                        </p>
                                    @endif
                                </div>

                                <label class="purchase-status {{ $item->status_type }}">
                                    @if ($item->status_type == 'borrowed')
                                        กำลังยืม
                                    @elseif ($item->status_type == 'overdue')
                                        เลยกำหนด
                                    @elseif ($item->status_type == 'returned')
                                        คืนแล้ว
                                    @endif
                                </label>
                            </div>

                            <div class="equipment-list">

                                @php
                                    $groupedEquipments = $item->loanEquipments->groupBy('equipment_item_id');
                                @endphp

                                @foreach ($groupedEquipments as $equipmentItemId => $equipments)
                                    @php
                                        $firstEquipment = $equipments->first();
                                        $totalQuantity = $equipments->sum('quantity');
                                    @endphp

                                    <ul class="ul-table ul-table-body infos">
                                        <li class="photo">
                                            <img src="{{ $firstEquipment->equipmentItem->image ? asset('upload/file/equipment_item/' . $firstEquipment->equipmentItem->image) : asset('images/default-image.png') }}"
                                                alt="{{ $firstEquipment->name }}" />
                                        </li>
                                        <li class="info">
                                            <div class="product-info">
                                                <h3>{{ $firstEquipment->name }}</h3>
                                            </div>
                                        </li>
                                        <li class="qty">
                                            <strong class="fs-16 text-black">x{{ $totalQuantity }}</strong>
                                        </li>
                                    </ul>
                                @endforeach
                            </div>

                            <div class="info-row d-flex justify-content-between align-items-center">
                                @if ($item->status === 'in_process')
                                    <div class="delivery-info" style="border-left: 3px solid #3f51b5;">
                                        <i class="fas fa-spinner me-2" style="color: #3f51b5;"></i>
                                        <span>อยู่ระหว่างการดำเนินการ กรุณารอการยืนยัน</span>
                                    </div>
                                @elseif ($item->status_type == 'overdue')
                                    <div class="delivery-info" style="border-left: 3px solid #ff5722;">
                                        <i class="fas fa-exclamation-triangle me-2" style="color: #ff5722;"></i>
                                        <span>อุปกรณ์เลยกำหนดการคืน กรุณาคืนอุปกรณ์โดยเร็วที่สุด</span>
                                    </div>
                                @elseif ($item->status_type == 'borrowed' && $item->status === 'completed')
                                    <div class="delivery-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span>กรุณาตรวจสอบอุปกรณ์และคืนตามกำหนดเวลา</span>
                                    </div>
                                @elseif ($item->status === 'cancel')
                                    <div class="delivery-info" style="border-left: 3px solid #e74c3c;">
                                        <i class="fas fa-ban me-2" style="color: #e74c3c;"></i>
                                        <span>คำร้องถูกยกเลิก</span>
                                    </div>
                                @elseif ($item->status_type == 'returned')
                                    <div class="delivery-info" style="border-left: 3px solid #27ae60;">
                                        <i class="fas fa-check-circle me-2" style="color: #27ae60;"></i>
                                        <span>คืนอุปกรณ์เรียบร้อยแล้ว</span>
                                    </div>
                                @endif

                                @if (($item->status_type == 'borrowed' || $item->status_type == 'overdue') && $item->status === 'completed')
                                    <a href="javascript:void(0);" class="return-btn" data-id="{{ $item->id }}"
                                        @if ($item->status_type == 'overdue') style="background-color: #ff5722;" @endif>
                                        <i class="fas fa-undo-alt me-1"></i> คืนอุปกรณ์
                                    </a>
                                @elseif($item->status_type == 'borrowed' && $item->status === 'in_process')
                                    <a href="javascript:void(0);" class="cancel-btn" data-id="{{ $item->id }}"
                                        @if ($item->status == 'in_process') style="background-color: #ff0000;" @endif>
                                        <i class="bi-trash"></i> ยกเลิก
                                    </a>
                                    {{-- @elseif($item->status === 'cancel')
                                    <div class="d-flex justify-content-end align-items-center text-danger">
                                        <i class="bi bi-x-octagon me-1"></i>
                                        <span>ถูกยกเลิก</span>
                                    </div> --}}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--card-info-->
            </div>
            <!--content-->
        </div>
        <!--container-->
    </div>
    <!--section-->
@endsection

@section('script')
    <script>
        $(document).on('click', '.return-btn', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var url = '/return-equipment/' + id;

            Swal.fire({
                title: 'ยืนยันการคืนอุปกรณ์?',
                text: "คุณต้องการคืนอุปกรณ์นี้ใช่หรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'คืนอุปกรณ์สำเร็จ!',
                                text: 'ทำการคืนอุปกรณ์เรียบร้อยแล้ว',
                                icon: 'success',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถคืนอุปกรณ์ได้',
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.cancel-btn', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var url = '/cancel-equipment/' + id;

            Swal.fire({
                title: 'ยืนยันการยกเลิกอุปกรณ์?',
                text: "คุณต้องการยกเลิกอุปกรณ์นี้ใช่หรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'คืนอุปกรณ์สำเร็จ!',
                                text: 'ทำการคืนอุปกรณ์เรียบร้อยแล้ว',
                                icon: 'success',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถคืนอุปกรณ์ได้',
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
