<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการยืม-คืนอุปกรณ์ ปี {{ $year }}</title>
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

        td.status-in_progress {
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
</head>

<body>
    <h2>รายงานการยืม-คืนอุปกรณ์ภาควิชาคอมพิวเตอร์ศึกษา คณะครุศาสตร์อุตสาหกรรม ปี {{ $year }}</h2>

    <table>
        <thead>
            <tr>
                <th>รายการที่</th>
                <th>รหัสนักศึกษา</th>
                <th>ชื่อ-นามสกุล</th>
                <th>สถานะการยืม-คืน</th>
                <th>สถานะการอนุมัติ</th>
                <th>ชื่ออุปกรณ์</th>
                <th>จำนวน</th>
                <th>วันที่ยืม</th>
                <th>วันที่คืน</th>
                <th>คืนเกินเวลาที่กำหนด</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
                @foreach ($loan->loanEquipments as $equipment)
                    <tr>
                        <td>{{ $equipment->loanTransaction->id }}</td>
                        <td>{{ $equipment->loanTransaction->member->info->student->student_number }}</td>
                        <td>{{ $equipment->loanTransaction->member->info->first_name . ' ' . $equipment->loanTransaction->member->info->last_name ?? '-' }}
                        </td>
                        <td class="status-{{ $equipment->loanTransaction->status_type }}">
                            @if ($equipment->loanTransaction->status_type == 'borrowed')
                                ยืมอุปกรณ์
                            @elseif ($equipment->loanTransaction->status_type == 'returned')
                                คืนอุปกรณ์
                            @elseif ($equipment->loanTransaction->status_type == 'overdue')
                                เกินกำหนด
                            @endif
                        </td>
                        <td class="status-{{ $equipment->loanTransaction->status }}">
                            @if ($equipment->loanTransaction->status == 'completed')
                                อนุมัติ
                            @elseif ($equipment->loanTransaction->status == 'cancel')
                                ไม่อนุมัติ
                            @elseif ($equipment->loanTransaction->status == 'in_progress')
                                รอดำเนินการ
                            @endif
                        </td>
                        <td>{{ $equipment->equipment_names ?? '-' }}</td>
                        <td>{{ $equipment->total_qty ?? '-' }}</td>
                        <td>{{ $equipment->loanTransaction->borrowed_at ?? '-' }}</td>
                        <td>{{ $equipment->loanTransaction->returned_at ?? '-' }}</td>
                        <td>
                            @if ($equipment->loanTransaction->is_overdue === 1)
                                เกินเวลา
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="no-print">
        <button class="print-button" onclick="window.print()">พิมพ์รายงาน</button>
    </div>
</body>

</html>
