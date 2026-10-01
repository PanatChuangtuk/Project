<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * หมวด รายการอุปกรณ์ และอุปกรณ์รายชิ้นที่มีอยู่เดิม
 * ข้อมูลจากฐานข้อมูลเดิม ณ 2026-10-01
 */
class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('equipment_category')->upsert([
            ['id' => 1, 'name' => 'อุปกรณ์ไฟฟ้า', 'status' => 1, 'created_at' => '2025-04-22 05:39:37', 'updated_at' => '2025-04-22 05:50:43'],
            ['id' => 2, 'name' => 'อุปกรณ์เครือข่าย', 'status' => 1, 'created_at' => '2025-04-22 05:39:46', 'updated_at' => '2025-04-22 05:39:46'],
            ['id' => 4, 'name' => 'คอมพิวเตอร์', 'status' => 1, 'created_at' => '2025-04-24 04:08:28', 'updated_at' => '2025-04-24 04:08:28'],
            ['id' => 5, 'name' => 'อุปกรณ์ต่อพ่วง', 'status' => 1, 'created_at' => '2025-04-24 04:08:50', 'updated_at' => '2025-04-24 04:08:50'],
            ['id' => 6, 'name' => 'เครื่องมือช่าง', 'status' => 0, 'created_at' => '2025-04-24 04:09:06', 'updated_at' => '2026-08-23 12:20:15'],
        ], ['id']);

        DB::table('equipment_item')->upsert([
            ['id' => 1, 'category_id' => 1, 'name' => 'มัลติมิเตอร์', 'status' => 1, 'created_at' => '2025-04-22 05:42:47', 'updated_at' => '2025-04-22 08:33:35', 'image' => 'ca80a.jpg'],
            ['id' => 2, 'category_id' => 2, 'name' => 'สายแลน', 'status' => 1, 'created_at' => '2025-04-22 06:07:42', 'updated_at' => '2025-04-22 07:09:57', 'image' => null],
            ['id' => 3, 'category_id' => 1, 'name' => 'รางปลั๊กและอแดปเตอร์', 'status' => 1, 'created_at' => '2025-04-22 08:00:57', 'updated_at' => '2025-04-22 08:00:57', 'image' => null],
            ['id' => 4, 'category_id' => 1, 'name' => 'ล้อเก็บสายไฟ', 'status' => 1, 'created_at' => '2025-04-22 08:35:27', 'updated_at' => '2025-04-22 08:35:36', 'image' => 'c7095.jpg'],
            ['id' => 5, 'category_id' => 1, 'name' => 'ปลั๊กพ่วง', 'status' => 1, 'created_at' => '2025-04-22 09:24:48', 'updated_at' => '2025-04-22 09:24:48', 'image' => null],
            ['id' => 6, 'category_id' => 1, 'name' => 'อแดปเตอร์', 'status' => 1, 'created_at' => '2025-04-22 09:25:06', 'updated_at' => '2025-04-22 09:25:06', 'image' => null],
            ['id' => 7, 'category_id' => 1, 'name' => 'พาวเวอร์แทร็ก', 'status' => 1, 'created_at' => '2025-04-22 09:25:38', 'updated_at' => '2025-04-22 09:25:38', 'image' => null],
            ['id' => 11, 'category_id' => 6, 'name' => 'ปากกาวัดไฟแบบไม่สัมผัส', 'status' => 1, 'created_at' => '2026-07-02 04:24:05', 'updated_at' => '2026-07-02 04:27:44', 'image' => 'bf59b.webp'],
            ['id' => 12, 'category_id' => 4, 'name' => 'PC-01', 'status' => 1, 'created_at' => '2026-08-23 12:22:23', 'updated_at' => '2026-08-23 12:22:23', 'image' => 'pc-01.png'],
        ], ['id']);

        DB::table('equipment')->upsert([
            ['id' => 7, 'item_id' => 1, 'number' => '11001', 'equipment_number' => '210010', 'status' => 1, 'created_at' => '2025-04-22 09:18:37', 'updated_at' => '2026-10-01 12:49:12', 'image' => null],
            ['id' => 8, 'item_id' => 1, 'number' => '11002', 'equipment_number' => null, 'status' => 1, 'created_at' => '2025-04-22 09:18:57', 'updated_at' => '2026-10-01 13:58:41', 'image' => '7a618.jpg'],
            ['id' => 9, 'item_id' => 2, 'number' => '21001', 'equipment_number' => null, 'status' => 1, 'created_at' => '2025-04-22 09:19:18', 'updated_at' => '2025-04-22 09:19:18', 'image' => null],
            ['id' => 10, 'item_id' => 3, 'number' => '12001', 'equipment_number' => null, 'status' => 1, 'created_at' => '2025-04-22 09:19:33', 'updated_at' => '2025-04-22 09:20:07', 'image' => null],
            ['id' => 11, 'item_id' => 4, 'number' => '13001', 'equipment_number' => null, 'status' => 1, 'created_at' => '2025-04-22 09:19:55', 'updated_at' => '2025-04-22 09:20:00', 'image' => null],
            ['id' => 12, 'item_id' => 4, 'number' => '13002', 'equipment_number' => null, 'status' => 1, 'created_at' => '2025-04-22 09:20:16', 'updated_at' => '2025-04-22 09:20:16', 'image' => '02c92.jpg'],
            ['id' => 13, 'item_id' => 1, 'number' => '11003', 'equipment_number' => null, 'status' => 1, 'created_at' => '2025-04-22 09:20:34', 'updated_at' => '2026-10-01 12:49:12', 'image' => null],
            ['id' => 17, 'item_id' => 12, 'number' => '41001', 'equipment_number' => '3011', 'status' => 1, 'created_at' => '2026-08-23 12:24:14', 'updated_at' => '2026-08-23 12:24:14', 'image' => 'pc-01-41001.png'],
        ], ['id']);
    }
}
