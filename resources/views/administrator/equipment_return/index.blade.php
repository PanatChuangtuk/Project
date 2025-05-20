@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <style>
        .swal2-container {
            z-index: 999990 !important;
        }

        .text-cutome {
            font-size: 16px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('administrator.return-equipment') }}">อนุมัติการยืมอุปกรณ์</a>
                </li>
            </ol>

            {{-- เนื้อหา --}}
            <div class="card">
                <div class="card-body">
                    {{-- หัว --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.return-equipment') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            <x-search />
                            <button type="button" class="btn btn-outline-primary btn-lg me-2" data-bs-toggle="modal"
                                data-bs-target="#registerModal">
                                ข้อมูลการยืม-คืนอุปกรณ์
                            </button>
                        </form>
                    </div>
                    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="registerModalLabel">ข้อมูลนักศึกษา</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="ปิด"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Date Range Inputs -->
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">วันที่เริ่มต้น</label>
                                        <input type="text" id="start_date" name="start_date" class="form-control"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">วันที่สิ้นสุด</label>
                                        <input type="text" id="end_date" name="end_date" class="form-control" required>
                                    </div>

                                    <!-- Export Form -->
                                    <form id="exportForm" action="{{ route('administrator.return-equipment.export') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="start_date" id="exportStartDate">
                                        <input type="hidden" name="end_date" id="exportEndDate">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class='bx bx-download'></i> ดาวน์โหลดรายงาน
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Print Form -->
                                    <form id="printForm" action="{{ route('administrator.loan.printReport') }}"
                                        method="GET" target="_blank">
                                        <input type="hidden" name="start_date" id="printStartDate">
                                        <input type="hidden" name="end_date" id="printEndDate">
                                        <button type="submit" class="btn btn-secondary mt-2">ดูรายงาน</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- ตาราง --}}
                    <div class=" text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="font-size: 1rem;">
                                        <div class="form-check">
                                            <input class="form-check-input check-item" type="checkbox" id="checkAll" />
                                        </div>
                                    </th>
                                    <th>ลำดับ</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">รหัสนักศึกษา</th>
                                    <th class="text-center">ชนิดคำร้อง</th>
                                    <th class="text-center">สถานะคำร้อง</th>
                                    <th class="text-center">การจัดการ</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="userTableBody">
                                @foreach ($users as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check" style="font-size: 1rem;">
                                                <input type="checkbox" class="form-check-input check-item"
                                                    value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <div class="text-center">
                                                <div class="flex-grow-1">
                                                    {{ $item->member->info->first_name ?? null }}
                                                    {{ $item->member->info->last_name ?? null }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->member->info->student->student_number ?? null }}
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($item->status_type == 'borrowed')
                                                <span class="badge bg-warning text-cutome">ยืมอุปกรณ์</span>
                                            @elseif ($item->status_type == 'returned')
                                                <span class="badge bg-success text-cutome">คืนอุปกรณ์</span>
                                            @elseif ($item->status_type == 'overdue')
                                                <span class="badge bg-danger text-cutome">เกินกำหนด</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($item->status == 'completed')
                                                <span class="badge bg-success text-cutome">อนุมัติ</span>
                                            @elseif ($item->status == 'cancel')
                                                <span class="badge bg-danger text-cutome">ยกเลิก</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0 custom-tooltip"
                                                        data-tooltip="รายละเอียดคำร้อง"
                                                        href="{{ route('administrator.return-equipment.edit', ['id' => $item->id]) }}">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- การแบ่งหน้า --}}
                        <div>
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        const currentPath = window.location.pathname;
        const bulkDeleteUrl = currentPath.endsWith('/') ? currentPath + 'bulk-delete' : currentPath + '/bulk-delete';
    </script>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/delete.js') }}"></script>
    <script>
        $(document).ready(function() {
            function updateHiddenFields() {
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();
                $('#exportStartDate').val(startDate);
                $('#exportEndDate').val(endDate);
                $('#printStartDate').val(startDate);
                $('#printEndDate').val(endDate);
            }

            $('#start_date, #end_date').on('change', updateHiddenFields);

            $('#exportForm').on('submit', function(e) {
                if (!$('#start_date').val() || !$('#end_date').val()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกช่วงวันที่',
                        text: 'กรุณาระบุวันที่เริ่มต้นและสิ้นสุดก่อนดาวน์โหลดรายงาน',
                        confirmButtonText: 'ตกลง'
                    });
                }
            });

            $('#printForm').on('submit', function(e) {
                if (!$('#start_date').val() || !$('#end_date').val()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกช่วงวันที่',
                        text: 'กรุณาระบุวันที่เริ่มต้นและสิ้นสุดก่อนดูรายงาน',
                        confirmButtonText: 'ตกลง'
                    });
                }
            });
        });
    </script>
    <script>
        let startPicker = flatpickr("#start_date", {

            locale: "th",
            altInput: true,
            altFormat: "j F Y",
            defaultDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                endPicker.set('minDate', dateStr);
            }
        });

        let endPicker = flatpickr("#end_date", {

            locale: "th",
            altInput: true,
            altFormat: "j F Y",
            onChange: function(selectedDates, dateStr, instance) {
                startPicker.set('maxDate', dateStr);
            }
        });
    </script>
@endsection
