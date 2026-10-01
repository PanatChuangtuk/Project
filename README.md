# ระบบยืม-คืนอุปกรณ์ ภาควิชาคอมพิวเตอร์ศึกษา

Laravel 11 + MySQL/MariaDB

## ติดตั้งบนเครื่องใหม่

ต้องมี PHP 8.2+, Composer, Node.js และ MySQL/MariaDB

```bash
composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate
```

แก้ `.env` ให้ตรงกับเครื่อง (`APP_URL`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, ค่า `MAIL_*` สำหรับอีเมลแจ้งเตือนเกินกำหนด)
แล้วสร้างฐานข้อมูลเปล่า (utf8mb4) และรัน:

```bash
php artisan migrate --seed
```

### ข้อมูลที่ seed

| Seeder | ข้อมูล |
|---|---|
| `MemberSeeder` | อาจารย์ที่ปรึกษา, นักศึกษา, สมาชิก (ไม่รวมบัญชีทดสอบ), คู่มือวิดีโอ |
| `EquipmentSeeder` | หมวด รายการอุปกรณ์ และอุปกรณ์รายชิ้นเดิม |
| `ComputerEquipmentSeeder` | ครุภัณฑ์คอมพิวเตอร์ที่เพิ่ม 23 รายการ รายการละ 3 ชิ้น พร้อมรูป |

รัน seeder ซ้ำได้ ข้อมูลจะไม่ซ้ำ (`php artisan db:seed`)

รูปอุปกรณ์อยู่ใน `public/upload/file/` และถูกเก็บใน git ไม่ต้องคัดลอกแยก
รูปที่เพิ่มใหม่มาจาก Wikimedia Commons ดูที่มาและสัญญาอนุญาตใน `public/upload/file/equipment_item/CREDITS.txt`

### งานตามเวลา

ระบบเปลี่ยนสถานะรายการที่เกินกำหนดและส่งอีเมลเตือนผ่านคำสั่ง `app:hourly-task-command`
(หรือเปิด URL `/run-hourly-task`) ต้องตั้ง cron ให้เรียกเอง เช่นทุกชั่วโมง:

```
0 * * * * cd /path/to/project && php artisan app:hourly-task-command >> /dev/null 2>&1
```

> การบล็อกการยืมเมื่อเกินกำหนดตรวจจาก `due_at` โดยตรง จึงทำงานได้แม้ cron ยังไม่ได้ตั้ง
> แต่สถานะ "เกินกำหนด" และอีเมลเตือนจะอัปเดตเมื่อคำสั่งนี้ทำงานเท่านั้น

## โครงสร้างข้อมูลการยืม-คืน

| ตาราง | เก็บอะไร |
|---|---|
| `eqm_history_master` | ใบยืม 1 แถวต่อการยืม 1 ครั้ง และสถานะปัจจุบัน |
| `eqm_history_detail` | อุปกรณ์แต่ละชิ้นในใบยืม เลขเครื่องที่ได้รับ และสภาพตอนคืน |
| `eqm_borrow_return_history` | ทุกเหตุการณ์ (ขอยืม, อนุมัติ, เกินกำหนด, แจ้งคืน, ตรวจรับ, ปฏิเสธ, ยกเลิก) ว่าใครทำเมื่อไหร่ |
