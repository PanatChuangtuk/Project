@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <style>
        .swal2-container {
            z-index: 999990 !important;
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
                                    <!-- Dropdown ปี -->
                                    <div class="mb-3">
                                        <label for="year" class="form-label">เลือกปีที่ต้องการออกรายงาน</label>
                                        <select id="year" class="form-select" required>
                                            <option value="">-- เลือกปี --</option>
                                            @foreach ($years as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Export Form -->
                                    <form id="exportForm" action="{{ route('administrator.return-equipment.export') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="year" id="exportYear">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class='bx bx-download'></i> ดาวน์โหลดรายงาน
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Print Form -->
                                    <form id="printForm" action="{{ route('administrator.loan.printReport') }}"
                                        method="GET" target="_blank">
                                        <input type="hidden" name="year" id="printYear">
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
                                        <td class="text-center  align-middle">
                                            @if ($item->status_type == 'borrowed')
                                                <span class="badge bg-warning">ยืมอุปกรณ์</span>
                                            @elseif ($item->status_type == 'returned')
                                                <span class="badge bg-success">คืนอุปกรณ์</span>
                                            @elseif ($item->status_type == 'overdue')
                                                <span class="badge bg-danger">เกินกำหนด</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($item->status == 'completed')
                                                <span class="badge bg-success">อนุมัติ</span>
                                            @elseif ($item->status == 'cancel')
                                                <span class="badge bg-danger">ยกเลิก</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0"
                                                        href="{{ route('administrator.return-equipment.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
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
            $('#year').on('change', function() {
                let selectedYear = $(this).val();
                $('#exportYear').val(selectedYear);
                $('#printYear').val(selectedYear);
            });

            $('#exportForm').on('submit', function(e) {
                if (!$('#year').val()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกปี',
                        text: 'กรุณาเลือกปีเพื่อดาวน์โหลดรายงาน',
                        confirmButtonText: 'ตกลง'
                    });
                }
            });

            $('#printForm').on('submit', function(e) {
                if (!$('#year').val()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกปี',
                        text: 'กรุณาเลือกปีก่อนดูรายงาน',
                        confirmButtonText: 'ตกลง'
                    });
                }
            });
        });
    </script>
@endsection
