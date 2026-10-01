@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <style>
        .swal2-container {
            z-index: 999990 !important;
        }

        /* เส้นคั่นระหว่างใบยืม ให้เห็นว่าแถวยืม/คืนไหนเป็นใบเดียวกัน */
        .eqm-list tbody.eqm-group {
            border-top: 2px solid #d9dee3;
        }

        .eqm-list tbody.eqm-group td {
            vertical-align: top;
        }

        .eqm-list tbody.eqm-group:hover {
            background: #f8f9fa;
        }

        .eqm-list .loan-cell {
            min-width: 180px;
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
                            <x-search-only />
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


                    {{-- แท็บกรอง --}}
                    <ul class="nav nav-pills px-3 mb-3 flex-wrap gap-1">
                        @foreach (\App\Models\EqmHistoryMaster::TABS as $key => $label)
                            <li class="nav-item">
                                <a class="nav-link {{ $tab === $key ? 'active' : '' }}"
                                    href="{{ route('administrator.return-equipment', array_filter(['tab' => $key === 'all' ? null : $key, 'query' => $query])) }}">
                                    {{ $label }}
                                    <span class="badge rounded-pill {{ $tab === $key ? 'bg-white text-primary' : 'bg-label-secondary' }} ms-1">{{ $tabCounts[$key] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- ตาราง --}}
                    <div class="table-responsive">
                        <table class="table eqm-list">
                            <thead>
                                <tr>
                                    <th>ใบยืม / ผู้ยืม</th>
                                    <th>ขั้นตอน</th>
                                    <th>อุปกรณ์</th>
                                    <th>ผล</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>

                            @php
                                $statusClass = [
                                    'รออนุมัติ' => 'bg-warning',
                                    'อนุมัติ' => 'bg-success',
                                    'ยกเลิก' => 'bg-secondary',
                                    'รอตรวจรับ' => 'bg-warning',
                                    'ตรวจรับแล้ว' => 'bg-success',
                                ];
                                $conditionClass = ['normal' => 'text-success', 'damaged' => 'text-warning', 'lost' => 'text-danger'];
                                $fmt = fn($date) => $date?->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i') ?? '-';
                            @endphp
                            @forelse ($users as $master)
                                @php
                                    $rows = $master->eventRows();
                                    $info = $master->member?->info;
                                @endphp
                                {{-- 1 ใบยืม = 1 กลุ่ม --}}
                                <tbody class="eqm-group">
                                    @foreach ($rows as $row)
                                        <tr>
                                            @if ($loop->first)
                                                <td rowspan="{{ $rows->count() }}" class="loan-cell">
                                                    <div class="fw-semibold">#{{ $master->id }}
                                                        {{ trim(($info->first_name ?? '') . ' ' . ($info->last_name ?? '')) ?: '-' }}</div>
                                                    <div class="text-muted small">{{ $info?->student?->student_number ?? '-' }}</div>
                                                </td>
                                            @endif
                                            <td class="text-nowrap">
                                                <span class="badge {{ $row->type === 'borrow' ? 'bg-label-primary' : 'bg-label-info' }}">{{ $row->type_label }}</span>
                                                <div class="small mt-1">{{ $fmt($row->date) }}</div>
                                                @if ($row->type === 'borrow' && !in_array($master->status, ['pending', 'cancelled']))
                                                    <div class="small text-muted">กำหนดคืน {{ $fmt($master->due_at) }}</div>
                                                @endif
                                            </td>
                                            <td class="small">
                                                @if ($row->type === 'borrow')
                                                    @foreach ($row->details->groupBy('equipment_item_id') as $details)
                                                        <div>{{ $details->first()->name }} x{{ $details->count() }}</div>
                                                    @endforeach
                                                @else
                                                    {{-- แถวคืน: แสดงสภาพของแต่ละชิ้น --}}
                                                    @foreach ($row->details as $detail)
                                                        <div>
                                                            {{ $detail->name }}
                                                            @if ($detail->condition)
                                                                — <span class="{{ $conditionClass[$detail->condition] ?? '' }}">{{ $detail->conditionLabel() }}</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $statusClass[$row->status_label] ?? 'bg-secondary' }}">{{ $row->status_label }}</span>
                                                @if ($row->overdue_days)
                                                    <span class="badge bg-danger">เกิน {{ $row->overdue_days }} วัน</span>
                                                @endif
                                                @if ($row->admin)
                                                    <div class="small text-muted mt-1">โดย {{ \App\Models\EqmHistoryMaster::personName($row->admin) }}</div>
                                                @endif
                                            </td>
                                            @if ($loop->first)
                                                <td rowspan="{{ $rows->count() }}" class="text-center">
                                                    <a class="btn btn-icon btn-outline-primary border-0 custom-tooltip"
                                                        data-tooltip="รายละเอียดคำร้อง"
                                                        href="{{ route('administrator.return-equipment.edit', ['id' => $master->id]) }}">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            @empty
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">ไม่มีข้อมูล</td>
                                    </tr>
                                </tbody>
                            @endforelse
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
