<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการยืม-คืนอุปกรณ์ ตั้งแต่วันที่ {{ $startDate }} ถึง
        {{ $endDate }}</title>
    <style>
        /* Import Google Fonts for Thai typography */
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600;700&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
            font-size: 16pt;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            padding: 30px;
            margin: 0;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        h2 {
            text-align: center;
            color: #1a3c6d;
            font-weight: 700;
            margin-bottom: 2rem;
            font-size: 1.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1.5rem;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            border: 1px solid #000;
            white-space: nowrap;
            font-size: 11pt;
            padding: 6px 8px;
        }

        th {
            background-color: #1a3c6d;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e6f0ff;
            transition: background-color 0.2s ease;
        }

        td {
            color: #444;
        }

        /* Status-specific styling */
        td.status-borrowed {
            color: #d97706;
            font-weight: 600;
        }

        td.status-returned {
            color: #059669;
            font-weight: 600;
        }

        td.status-overdue {
            color: #dc2626;
            font-weight: 600;
        }

        td.status-completed {
            color: #059669;
            font-weight: 600;
        }

        td.status-cancel {
            color: #dc2626;
            font-weight: 600;
        }

        td.status-in_process {
            color: #d97706;
            font-weight: 600;
        }

        .no-print {
            text-align: center;
            margin-top: 2rem;
        }

        .print-button {
            background-color: #1a3c6d;
            color: #fff;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        .print-button:hover {
            background-color: #15325b;
            transform: translateY(-2px);
        }

        .print-button:active {
            transform: translateY(0);
        }

        /* Print-specific styles */
        @media print {
            body {
                background-color: #fff;
                padding: 0;
                font-size: 12pt;
            }

            h2 {
                color: #000;
                font-size: 1.5rem;
            }

            table {
                box-shadow: none;
                border-radius: 0;
            }

            th {
                background-color: #333;
                color: #fff;
            }

            tr:nth-child(even) {
                background-color: #fff;
            }

            tr:hover {
                background-color: #fff;
            }

            .no-print {
                display: none;
            }

            /* Remove shadows and hover effects for print */
            table,
            th,
            td {
                border: 1px solid #000;
                white-space: nowrap;
                font-size: 11pt;
                padding: 6px 8px;
            }
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            body {
                padding: 15px;
                font-size: 14pt;
            }

            h2 {
                font-size: 1.5rem;
            }

            th,
            td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .print-button {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
            border: 1px solid #000;
        }

        thead tr {
            background-color: #f2f2f2;
        }
    </style>
    <style>
        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .summary div {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 8px 16px;
            text-align: center;
            min-width: 120px;
        }

        .summary strong {
            display: block;
            font-size: 1.4rem;
        }

        .summary span {
            font-size: 11pt;
        }

        tbody.loan {
            break-inside: avoid;
        }

        /* เส้นหนาคั่นระหว่างรายการ ให้เห็นว่าแถวไหนอยู่รายการเดียวกัน */
        tbody.loan tr:first-child td {
            border-top: 2px solid #1a3c6d;
        }

        tbody.loan tr:nth-child(even) {
            background-color: transparent;
        }

        tbody.loan:nth-of-type(even) td {
            background-color: #f4f7fb;
        }

        td.text-start {
            text-align: left;
        }

        td.wrap {
            white-space: normal;
        }

        .sub {
            font-size: 10pt;
            color: #666;
        }

        .stage {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 10.5pt;
        }

        .stage-wait {
            background: #fff4dc;
            color: #b45309;
        }

        .stage-borrowed {
            background: #e0ecff;
            color: #1d4ed8;
        }

        .stage-overdue {
            background: #fde2e2;
            color: #b91c1c;
        }

        .stage-returned {
            background: #dcfce7;
            color: #047857;
        }

        .stage-cancel {
            background: #eee;
            color: #555;
        }

        .text-danger {
            color: #b91c1c;
        }

        .text-success {
            color: #047857;
        }

        .text-warning {
            color: #b45309;
        }

        .fw {
            font-weight: 600;
        }

        @media print {
            .summary div {
                border-color: #000;
            }

            tbody.loan:nth-of-type(even) td {
                background-color: #fff;
            }
        }
    </style>
</head>

<body>
    @php
        $fmt = fn($date) => $date
            ? \Carbon\Carbon::parse($date)->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i')
            : '-';
        $stageClass = [
            'รออนุมัติการยืม' => 'stage-wait',
            'กำลังยืม' => 'stage-borrowed',
            'เกินกำหนด (ยังไม่คืน)' => 'stage-overdue',
            'รอตรวจรับคืน' => 'stage-wait',
            'คืนแล้ว' => 'stage-returned',
            'ยกเลิก' => 'stage-cancel',
        ];
        $stages = $loans->map(fn($loan) => $loan->stageLabel());
        $damagedOrLost = $loans->sum(
            fn($loan) => $loan->loanEquipments->sum(fn($e) => (int) $e->damaged_qty + (int) $e->lost_qty),
        );
    @endphp

    <h2>รายงานการยืม-คืนอุปกรณ์ภาควิชาคอมพิวเตอร์ศึกษา คณะครุศาสตร์อุตสาหกรรม <br>ตั้งแต่วันที่ {{ $startDate }} ถึง
        {{ $endDate }} </h2>

    <div class="summary">
        <div><strong>{{ $loans->count() }}</strong><span>รายการทั้งหมด</span></div>
        <div><strong>{{ $stages->filter(fn($s) => $s === 'กำลังยืม')->count() }}</strong><span>กำลังยืม</span></div>
        <div class="text-danger"><strong>{{ $stages->filter(fn($s) => $s === 'เกินกำหนด (ยังไม่คืน)')->count() }}</strong><span>เกินกำหนดยังไม่คืน</span></div>
        <div class="text-success"><strong>{{ $stages->filter(fn($s) => $s === 'คืนแล้ว')->count() }}</strong><span>คืนแล้ว</span></div>
        <div class="text-warning"><strong>{{ $damagedOrLost }}</strong><span>อุปกรณ์ชำรุด/สูญหาย (ชิ้น)</span></div>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">รายการที่</th>
                <th rowspan="2">ผู้ยืม</th>
                <th colspan="2">การยืม</th>
                <th colspan="2">การคืน</th>
                <th rowspan="2">สถานะ</th>
                <th colspan="3">อุปกรณ์</th>
            </tr>
            <tr>
                <th>วันที่ยืม</th>
                <th>กำหนดคืน</th>
                <th>วันที่คืน</th>
                <th>เกินกำหนด</th>
                <th>ชื่ออุปกรณ์</th>
                <th>จำนวน</th>
                <th>สภาพที่ได้รับคืน</th>
            </tr>
        </thead>
        @forelse ($loans as $loan)
            @php
                $equipments = $loan->loanEquipments->isEmpty() ? collect([null]) : $loan->loanEquipments->values();
                $rows = $equipments->count();
                $stage = $loan->stageLabel();
                $overdueDays = $loan->overdueDays();
                $info = $loan->member?->info;
            @endphp
            {{-- tbody แยกต่อรายการ ให้แถวของรายการเดียวกันอยู่เป็นกลุ่ม และไม่ถูกตัดข้ามหน้าเวลาพิมพ์ --}}
            <tbody class="loan">
                @foreach ($equipments as $equipment)
                    <tr>
                        @if ($loop->first)
                            <td rowspan="{{ $rows }}">{{ $loan->id }}</td>
                            <td rowspan="{{ $rows }}" class="text-start">
                                {{ trim(($info->first_name ?? '') . ' ' . ($info->last_name ?? '')) ?: '-' }}
                                <div class="sub">{{ $info?->student?->student_number ?? '-' }}</div>
                            </td>
                            <td rowspan="{{ $rows }}">{{ $fmt($loan->borrowed_at) }}</td>
                            <td rowspan="{{ $rows }}">{{ $fmt($loan->dueAt()) }}</td>
                            <td rowspan="{{ $rows }}">{{ $fmt($loan->returned_at) }}</td>
                            <td rowspan="{{ $rows }}" class="{{ $overdueDays ? 'text-danger fw' : '' }}">
                                {{ $overdueDays ? $overdueDays . ' วัน' : '-' }}
                            </td>
                            <td rowspan="{{ $rows }}">
                                <span class="stage {{ $stageClass[$stage] ?? '' }}">{{ $stage }}</span>
                            </td>
                        @endif
                        <td class="text-start wrap">{{ $equipment->equipment_names ?? '-' }}</td>
                        <td>{{ $equipment->total_qty ?? '-' }}</td>
                        <td>
                            {{ $equipment ? \App\Http\Controllers\Administrator\ReturnEquipmentController::conditionSummary($equipment) ?: '-' : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @empty
            <tbody>
                <tr>
                    <td colspan="10">ไม่มีข้อมูลในช่วงวันที่ที่เลือก</td>
                </tr>
            </tbody>
        @endforelse
    </table>

    <div class="no-print">
        <button class="print-button" onclick="window.print()">พิมพ์รายงาน</button>
    </div>
</body>

</html>
