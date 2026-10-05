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

        .filter-chip {
            font-size: 0.85rem;
            padding: 0.45em 0.65em;
        }

        .dialog-section {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #8592a3;
            margin-bottom: 0.75rem;
        }

        #filterModal .select2-container .select2-selection--multiple {
            min-height: 38px;
        }

        .date-presets .btn {
            border-radius: 50rem;
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
                <li class="breadcrumb-item"><a
                        href="{{ route('administrator.return-equipment') }}">รายการคำร้องที่สำเร็จแล้ว</a>
                </li>
            </ol>

            {{-- เนื้อหา --}}
            <div class="card">
                <div class="card-body">
                    @php
                        $base = ['tab' => $tab === 'all' ? null : $tab, 'all' => $showAll ? 1 : null];
                        // ลิงก์หน้าเดิมโดยเปลี่ยนค่าตัวกรองบางตัว (คงแท็บไว้)
                        $link = fn(array $changes) => route(
                            'administrator.return-equipment',
                            array_filter(array_merge($filters, $base, $changes)),
                        );
                        $withoutId = fn(string $key, int $id) => $link([
                            $key => array_values(array_diff($filters[$key], [$id])),
                        ]);

                        // ป้ายตัวกรองที่ใช้อยู่ (report = ส่งต่อให้รายงานได้; ช่วงวันที่ของรายงานเลือกแยก)
                        $chips = [];
                        if ($filters['loan_no']) {
                            $chips[] = ['label' => 'ใบยืม #' . $filters['loan_no'], 'url' => $link(['loan_no' => null]), 'report' => true];
                        }
                        if ($filters['query']) {
                            $chips[] = ['label' => 'ผู้ยืม: ' . $filters['query'], 'url' => $link(['query' => null]), 'report' => true];
                        }
                        foreach ($filters['member_ids'] as $id) {
                            $chips[] = [
                                'label' => 'ผู้ยืม: ' . ($borrowers[$id] ?? '#' . $id),
                                'url' => $withoutId('member_ids', $id),
                                'report' => true,
                            ];
                        }
                        foreach ($filters['equipment_item_ids'] as $id) {
                            $chips[] = [
                                'label' => 'อุปกรณ์: ' . ($equipmentItems->firstWhere('id', $id)->name ?? '#' . $id),
                                'url' => $withoutId('equipment_item_ids', $id),
                                'report' => true,
                            ];
                        }
                        if ($filters['start_date'] || $filters['end_date']) {
                            $chips[] = [
                                'label' =>
                                    'วันที่: ' .
                                    collect([$filters['start_date'], $filters['end_date']])
                                        ->map(fn($d) => $d ? \Carbon\Carbon::parse($d)->locale('th')->translatedFormat('j M Y') : '…')
                                        ->implode(' – '),
                                'url' => $link(['start_date' => null, 'end_date' => null]),
                                'report' => false,
                            ];
                        }
                        // กลับไปหน้ารอการกรอง
                        $resetUrl = route('administrator.return-equipment');
                    @endphp

                    {{-- หัว: ตัวกรอง (ซ้าย) / รายงาน (ขวา) --}}
                    <div class="d-flex flex-wrap align-items-center gap-2 p-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#filterModal">
                            <i class="bx bx-filter-alt me-1"></i> ตัวกรอง
                            @if (count($chips))
                                <span class="badge bg-white text-primary ms-1">{{ count($chips) }}</span>
                            @endif
                        </button>
                        @foreach ($chips as $chip)
                            <span class="badge bg-label-primary d-inline-flex align-items-center filter-chip">
                                {{ $chip['label'] }}
                                <a href="{{ $chip['url'] }}" class="ms-1 text-primary" aria-label="ลบตัวกรอง"><i
                                        class="bx bx-x"></i></a>
                            </span>
                        @endforeach
                        @if ($showAll && !count($chips))
                            <span class="badge bg-label-primary d-inline-flex align-items-center filter-chip">
                                แสดงทั้งหมด
                                <a href="{{ $resetUrl }}" class="ms-1 text-primary" aria-label="ลบตัวกรอง"><i
                                        class="bx bx-x"></i></a>
                            </span>
                        @endif
                        @if (count($chips))
                            <a href="{{ $resetUrl }}" class="small">ล้างทั้งหมด</a>
                        @endif

                        <button type="button" class="btn btn-outline-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#reportModal">
                            <i class="bx bx-file me-1"></i> รายงาน
                        </button>
                    </div>

                    {{-- Dialog ตัวกรอง --}}
                    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="filterModalLabel">
                                        <i class="bx bx-filter-alt me-1"></i> ตัวกรอง
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="ปิด"></button>
                                </div>
                                <form id="filterForm" action="{{ route('administrator.return-equipment') }}"
                                    method="GET">
                                    <div class="modal-body">
                                        @if ($tab !== 'all')
                                            <input type="hidden" name="tab" value="{{ $tab }}">
                                        @endif
                                        <div class="dialog-section">ค้นหา</div>
                                        <div class="row g-3 mb-4">
                                            <div class="col-12">
                                                <label for="loan_no" class="form-label">เลขใบยืม</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">#</span>
                                                    <input type="text" id="loan_no" name="loan_no" class="form-control"
                                                        inputmode="numeric" placeholder="เช่น 12"
                                                        value="{{ $filters['loan_no'] }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="member_ids" class="form-label">ผู้ยืม</label>
                                                <select id="member_ids" name="member_ids[]" class="form-select" multiple
                                                    data-placeholder="ทุกคน — พิมพ์ชื่อหรือรหัสนักศึกษา">
                                                    @foreach ($borrowers as $id => $label)
                                                        <option value="{{ $id }}" @selected(in_array($id, $filters['member_ids']))>
                                                            {{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="equipment_item_ids" class="form-label">อุปกรณ์</label>
                                                <select id="equipment_item_ids" name="equipment_item_ids[]" class="form-select"
                                                    multiple data-placeholder="ทุกอุปกรณ์ — พิมพ์ชื่ออุปกรณ์">
                                                    @foreach ($equipmentItems as $item)
                                                        <option value="{{ $item->id }}" @selected(in_array($item->id, $filters['equipment_item_ids']))>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="dialog-section">ช่วงวันที่</div>
                                        <div class="d-flex flex-wrap gap-1 mb-2 date-presets" data-start="#start_date" data-end="#end_date">
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="today">วันนี้</button>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="7d">7 วันล่าสุด</button>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="month">เดือนนี้</button>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="lastmonth">เดือนก่อน</button>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="year">ปีนี้</button>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="text" id="start_date" name="start_date" class="form-control"
                                                    placeholder="วันที่เริ่มต้น" aria-label="วันที่เริ่มต้น"
                                                    value="{{ $filters['start_date'] }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" id="end_date" name="end_date" class="form-control"
                                                    placeholder="วันที่สิ้นสุด" aria-label="วันที่สิ้นสุด"
                                                    value="{{ $filters['end_date'] }}">
                                            </div>
                                        </div>
                                        <div class="form-text">แสดงใบยืมที่มีการยืมหรือการคืนในช่วงนี้</div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <a href="{{ route('administrator.return-equipment', ['all' => 1]) }}"
                                            class="btn btn-link px-0">แสดงทั้งหมด</a>
                                        <div class="d-flex gap-2">
                                            <button type="button" id="filterClear"
                                                class="btn btn-label-secondary">ล้าง</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-search me-1"></i> กรอง
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Dialog รายงาน --}}
                    @php
                        // ตัวกรองที่ส่งต่อให้รายงานได้ (ช่วงวันที่ของรายงานเลือกแยกใน dialog นี้)
                        $reportFilters = collect($chips)->where('report', true)->pluck('label');
                        $reportStart = $filters['start_date'] ?? now()->startOfMonth()->toDateString();
                        $reportEnd = $filters['end_date'] ?? now()->toDateString();
                    @endphp
                    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reportModalLabel">
                                        <i class="bx bx-file me-1"></i> ออกรายงานการยืม-คืนอุปกรณ์
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="ปิด"></button>
                                </div>
                                <form id="reportForm" action="{{ route('administrator.loan.printReport') }}"
                                    method="GET" target="_blank" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="reportToken"
                                        disabled>
                                    <div class="modal-body">
                                        <div class="dialog-section">ช่วงวันที่ <span class="text-danger">*</span></div>
                                        <div class="d-flex flex-wrap gap-1 mb-2 date-presets" data-start="#report_start" data-end="#report_end">
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="today">วันนี้</button>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="7d">7 วันล่าสุด</button>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="month">เดือนนี้</button>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="lastmonth">เดือนก่อน</button>
                                            <button type="button" class="btn btn-xs btn-outline-secondary" data-range="year">ปีนี้</button>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="text" id="report_start" name="start_date" class="form-control"
                                                    placeholder="วันที่เริ่มต้น" aria-label="วันที่เริ่มต้น"
                                                    value="{{ $reportStart }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" id="report_end" name="end_date" class="form-control"
                                                    placeholder="วันที่สิ้นสุด" aria-label="วันที่สิ้นสุด"
                                                    value="{{ $reportEnd }}">
                                            </div>
                                        </div>
                                        <div id="reportDateError" class="invalid-feedback">
                                            กรุณาเลือกวันที่เริ่มต้นและวันที่สิ้นสุด</div>
                                        <div class="form-text">รวมรายการยืมและรายการคืนที่เกิดขึ้นในช่วงนี้</div>

                                        @if (count($reportFilters))
                                            <div class="border rounded p-3 mt-4">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="reportUseFilters"
                                                        checked>
                                                    <label class="form-check-label" for="reportUseFilters">
                                                        ใช้ตัวกรองปัจจุบัน
                                                    </label>
                                                </div>
                                                <div class="small text-muted ms-4">{{ $reportFilters->implode(' · ') }}</div>
                                                <fieldset id="reportFilters">
                                                    @foreach (['loan_no', 'query'] as $key)
                                                        @if ($filters[$key])
                                                            <input type="hidden" name="{{ $key }}" value="{{ $filters[$key] }}">
                                                        @endif
                                                    @endforeach
                                                    @foreach (['member_ids', 'equipment_item_ids'] as $key)
                                                        @foreach ($filters[$key] as $id)
                                                            <input type="hidden" name="{{ $key }}[]" value="{{ $id }}">
                                                        @endforeach
                                                    @endforeach
                                                </fieldset>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="bx bx-show me-1"></i> ดูรายงาน
                                        </button>
                                        <button type="submit" class="btn btn-primary" data-export
                                            formaction="{{ route('administrator.return-equipment.export') }}"
                                            formmethod="POST" formtarget="_self">
                                            <i class="bx bx-download me-1"></i> ดาวน์โหลด Excel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- แท็บกรอง (แสดงเมื่อกรองแล้ว) --}}
                    @if ($filtered)
                    <ul class="nav nav-pills px-3 mb-3 flex-wrap gap-1">
                        @foreach (\App\Models\EqmHistoryMaster::TABS as $key => $label)
                            <li class="nav-item">
                                <a class="nav-link {{ $tab === $key ? 'active' : '' }}"
                                    href="{{ route('administrator.return-equipment', array_filter($filters + ['tab' => $key === 'all' ? null : $key, 'all' => $showAll ? 1 : null])) }}">
                                    {{ $label }}
                                    <span
                                        class="badge rounded-pill {{ $tab === $key ? 'bg-white text-primary' : 'bg-label-secondary' }} ms-1">{{ $tabCounts[$key] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @endif

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
                                $conditionClass = [
                                    'normal' => 'text-success',
                                    'damaged' => 'text-warning',
                                    'lost' => 'text-danger',
                                ];
                                $fmt = fn($date) => $date
                                    ?->setTimezone('Asia/Bangkok')
                                    ->locale('th')
                                    ->translatedFormat('d M Y H:i') ?? '-';
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
                                                        {{ trim(($info->first_name ?? '') . ' ' . ($info->last_name ?? '')) ?: '-' }}
                                                    </div>
                                                    <div class="text-muted small">
                                                        {{ $info?->student?->student_number ?? '-' }}</div>
                                                </td>
                                            @endif
                                            <td class="text-nowrap">
                                                <span
                                                    class="badge {{ $row->type === 'borrow' ? 'bg-label-primary' : 'bg-label-info' }}">{{ $row->type_label }}</span>
                                                <div class="small mt-1">{{ $fmt($row->date) }}</div>
                                                @if ($row->type === 'borrow' && !in_array($master->status, ['pending', 'cancelled']))
                                                    <div class="small text-muted">กำหนดคืน {{ $fmt($master->due_at) }}
                                                    </div>
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
                                                                — <span
                                                                    class="{{ $conditionClass[$detail->condition] ?? '' }}">{{ $detail->conditionLabel() }}</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $statusClass[$row->status_label] ?? 'bg-secondary' }}">{{ $row->status_label }}</span>
                                                @if ($row->overdue_days)
                                                    <span class="badge bg-danger">เกิน {{ $row->overdue_days }} วัน</span>
                                                @endif
                                                @if ($row->admin)
                                                    <div class="small text-muted mt-1">โดย
                                                        {{ \App\Models\EqmHistoryMaster::personName($row->admin) }}</div>
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
                                        <td colspan="5" class="text-center text-muted py-5">
                                            @if ($filtered)
                                                <i class="bx bx-search-alt display-6 d-block mb-2"></i>
                                                <div class="fw-semibold mb-1">ไม่พบข้อมูลตามตัวกรอง</div>
                                                <div class="small mb-3">ลองปรับเงื่อนไข หรือขยายช่วงวันที่</div>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal" data-bs-target="#filterModal">
                                                    <i class="bx bx-filter-alt me-1"></i> แก้ไขตัวกรอง
                                                </button>
                                            @else
                                                <i class="bx bx-filter-alt display-6 d-block mb-2"></i>
                                                <div class="fw-semibold mb-1">เลือกตัวกรองเพื่อแสดงข้อมูล</div>
                                                <div class="small mb-3">กรุณาเลือกตัวกรองเพื่อแสดงข้อมูล
                                                    หรือกด "แสดงทั้งหมด" ในหน้าต่างตัวกรอง</div>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#filterModal">
                                                    <i class="bx bx-filter-alt me-1"></i> เลือกตัวกรอง
                                                </button>
                                            @endif
                                        </td>
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
    <script src="{{ asset('js/delete.js') }}"></script>
    <script>
        (function() {
            const fmt = d => flatpickr.formatDate(d, 'Y-m-d');
            const today = new Date();
            const y = today.getFullYear();
            const m = today.getMonth();
            const presets = {
                today: () => [today, today],
                '7d': () => [new Date(y, m, today.getDate() - 6), today],
                month: () => [new Date(y, m, 1), today],
                lastmonth: () => [new Date(y, m - 1, 1), new Date(y, m, 0)],
                year: () => [new Date(y, 0, 1), today],
            };

            // ช่องวันที่เริ่มต้น-สิ้นสุดคู่กัน + ปุ่มลัดช่วงวันที่
            function rangePicker(group) {
                const startEl = document.querySelector(group.dataset.start);
                const endEl = document.querySelector(group.dataset.end);
                const buttons = group.querySelectorAll('[data-range]');
                const markActive = () => buttons.forEach(btn => {
                    const [from, to] = presets[btn.dataset.range]();
                    btn.classList.toggle('active', startEl.value === fmt(from) && endEl.value === fmt(to));
                });
                const options = {
                    locale: 'th',
                    altInput: true,
                    altFormat: 'j F Y',
                };
                const start = flatpickr(startEl, {
                    ...options,
                    maxDate: endEl.value || null,
                    onChange: (dates, str) => {
                        end.set('minDate', str || null);
                        markActive();
                        startEl.dispatchEvent(new Event('change', { bubbles: true }));
                    },
                });
                const end = flatpickr(endEl, {
                    ...options,
                    minDate: startEl.value || null,
                    onChange: (dates, str) => {
                        start.set('maxDate', str || null);
                        markActive();
                        endEl.dispatchEvent(new Event('change', { bubbles: true }));
                    },
                });

                buttons.forEach(btn => btn.addEventListener('click', () => {
                    const [from, to] = presets[btn.dataset.range]();
                    start.set('maxDate', null);
                    end.set('minDate', null);
                    start.setDate(from, true);
                    end.setDate(to, true);
                }));
                markActive();

                return {
                    start,
                    end,
                    clear() {
                        start.clear();
                        end.clear();
                    },
                };
            }

            const pickers = {};
            document.querySelectorAll('.date-presets').forEach(group => {
                pickers[group.dataset.start] = rangePicker(group);
            });

            // ตัวกรอง: ผู้ยืม/อุปกรณ์ เลือกได้หลายรายการ พิมพ์ค้นหาได้
            const filterModal = document.getElementById('filterModal');
            const multiSelects = $('#member_ids, #equipment_item_ids');
            multiSelects.each(function() {
                $(this).select2({
                    width: '100%',
                    placeholder: $(this).data('placeholder'),
                    closeOnSelect: false,
                    dropdownParent: $(filterModal),
                    language: {
                        noResults: () => 'ไม่พบรายการ',
                    },
                });
            });
            filterModal.addEventListener('shown.bs.modal', () => document.getElementById('loan_no').focus());
            document.getElementById('filterClear').addEventListener('click', () => {
                filterModal.querySelectorAll('input[type=text]').forEach(el => el.value = '');
                multiSelects.val(null).trigger('change');
                pickers['#start_date'].clear();
                document.getElementById('loan_no').focus();
            });

            // รายงาน: ตรวจช่วงวันที่ในฟอร์ม, ดูรายงาน = GET แท็บใหม่, Excel = POST (ต้องมี CSRF)
            const reportForm = document.getElementById('reportForm');
            const reportPicker = pickers['#report_start'];
            const dateInputs = () => [reportPicker.start.altInput, reportPicker.end.altInput];
            const useFilters = document.getElementById('reportUseFilters');
            if (useFilters) {
                useFilters.addEventListener('change', () => {
                    document.getElementById('reportFilters').disabled = !useFilters.checked;
                });
            }
            reportForm.addEventListener('change', () => {
                if (document.getElementById('report_start').value && document.getElementById('report_end').value) {
                    dateInputs().forEach(el => el.classList.remove('is-invalid'));
                    document.getElementById('reportDateError').classList.remove('d-block');
                }
            });
            reportForm.addEventListener('submit', e => {
                if (!document.getElementById('report_start').value || !document.getElementById('report_end').value) {
                    e.preventDefault();
                    dateInputs().forEach(el => el.classList.add('is-invalid'));
                    document.getElementById('reportDateError').classList.add('d-block');
                    return;
                }
                document.getElementById('reportToken').disabled = !(e.submitter && e.submitter.hasAttribute('data-export'));
            });
        })();
    </script>
    @unless ($filtered)
        <script>
            // ยังไม่ได้กรอง: เปิด dialog ตัวกรองให้ทันที
            document.addEventListener('DOMContentLoaded', function() {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('filterModal')).show();
            });
        </script>
    @endunless
@endsection
