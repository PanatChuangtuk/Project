<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งเตือนการยืมอุปกรณ์ครุภัณฑ์</title>
</head>

<body
    style="font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f0f2f5; margin: 0; padding: 0; color: #2d3748;">
    <div
        style="max-width: 640px; margin: 30px auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); overflow: hidden;">
        <!-- Header -->
        <div
            style="background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); color: #ffffff; padding: 30px 20px; text-align: center; border-radius: 12px 12px 0 0;">
            <h1 style="margin: 0; font-size: 28px; font-weight: 700; letter-spacing: 0.5px;">แจ้งเตือนการยืมที่เกินกำหนด
            </h1>
            <p style="margin: 8px 0 0; font-size: 16px; opacity: 0.9;">กรุณาคืนอุปกรณ์ของท่านโดยเร็วที่สุด</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <p style="font-size: 16px; margin: 0 0 20px; font-weight: 500;">เรียน
                {{ $transaction->member->info->first_name . ' ' . $transaction->member->info->last_name }}</p>
            <p style="font-size: 15px; line-height: 1.6; margin: 0 0 20px; color: #4b5563;">
                @if ($transaction->status_type === 'overdue')
                    รายการยืมของท่านเกินกำหนดแล้ว!
                @else
                    เราได้ตรวจพบว่ารายการยืมต่อไปนี้ของท่านใกล้เกินกำหนดเวลาคืนอุปกรณ์แล้ว
                @endif
            </p>

            <ul style="list-style: none; padding: 0; margin: 0 0 20px;">
                <li
                    style="background-color: #f8fafc; margin-bottom: 15px; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0; transition: transform 0.2s ease;">
                    <div>
                        {{-- <strong style="color: #3b82f6; font-weight: 600; font-size: 15px;">รหัสการยืม:</strong>
                        {{ $transaction->id ?? 'N/A' }}<br> --}}
                        <strong style="color: #3b82f6; font-weight: 600; font-size: 15px;">ชื่อผู้ยืม:</strong>
                        {{ $transaction->member->info->first_name . ' ' . $transaction->member->info->last_name }}<br>
                        <strong style="color: #3b82f6; font-weight: 600; font-size: 15px;">วันที่ยืม:</strong>
                        {{ $transaction->borrowed_at }}<br>
                        <strong style="color: #3b82f6; font-weight: 600; font-size: 15px;">สถานะ:</strong>
                        <span
                            style="color: {{ $transaction->status_type === 'overdue' ? '#ef4444' : '#22c55e' }}; font-weight: bold; font-size: 15px;">
                            {{ $transaction->status_type === 'overdue' ? 'เกินกำหนด' : 'ปกติ' }}
                        </span><br>
                    </div>

                    <!-- Equipment List as Table -->
                    <div
                        style="margin-top: 15px; padding: 15px; background-color: #ffffff; border-radius: 8px; border-left: 4px solid #3b82f6;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 15px; color: #2d3748;">
                            <thead>
                                <tr style="background-color: #f1f5f9; text-align: left;">
                                    <th
                                        style="padding: 12px; font-weight: 600; color: #3b82f6; border-bottom: 1px solid #e2e8f0;">
                                        อุปกรณ์</th>
                                    <th
                                        style="padding: 12px; font-weight: 600; color: #3b82f6; border-bottom: 1px solid #e2e8f0;">
                                        จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedEquipments as $equipment)
                                    <tr style="border-bottom: 1px solid #e2e8f0;">
                                        <td style="padding: 12px; color: #4b5563;">
                                            {{ $equipment['name'] }}
                                            <br>
                                            <img src="{{ asset('upload/file/equipment_item/' . $equipment['image']) }}"
                                                alt="{{ $equipment['name'] }}"
                                                style="max-width: 80px; border-radius: 6px; margin-top: 8px; display: block;">
                                        </td>
                                        <td style="padding: 12px; color: #4b5563;">{{ $equipment['total_quantity'] }}
                                            ชิ้น</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>

            <!-- Call to Action -->
            {{-- <div style="text-align: center; margin: 20px 0;">
                <a href="mailto:support@equipment-system.com"
                    style="display: inline-block; background-color: #3b82f6; color: #ffffff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-size: 15px; font-weight: 600; transition: background-color 0.2s ease;">ติดต่อเราทันที</a>
            </div> --}}

            {{-- 
            <p style="font-size: 15px; line-height: 1.6; margin: 0 0 10px; color: #4b5563;">หากมีข้อสงสัยเพิ่มเติม
                กรุณาติดต่อเราที่ <a href="mailto:support@equipment-system.com"
                    style="color: #3b82f6; text-decoration: none;">support@equipment-system.com</a> หรือโทร
                [หมายเลขติดต่อ]</p>
            <p style="font-size: 15px; margin: 0; color: #4b5563;">ขอขอบคุณที่ให้ความร่วมมือ<br><strong
                    style="color: #3b82f6;">ทีมงานระบบยืม-คืนอุปกรณ์</strong></p> --}}
        </div>

        <!-- Footer -->
        <div
            style="background-color: #1f2937; text-align: center; padding: 15px; font-size: 13px; color: #d1d5db; border-radius: 0 0 12px 12px;">
            <p style="margin: 0;">© 2025 ระบบยืม-คืนอุปกรณ์. สงวนลิขสิทธิ์.</p>
            {{-- <p style="margin: 5px 0 0;"><a href="#"
                    style="color: #93c5fd; text-decoration: none;">ยกเลิกการรับอีเมล</a></p> --}}
        </div>
    </div>
</body>

</html>
