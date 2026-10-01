<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * ครุภัณฑ์คอมพิวเตอร์ที่เพิ่มใหม่ (รูปจาก Wikimedia Commons ดู public/upload/file/equipment_item/CREDITS.txt)
 * รันซ้ำได้: อ้างอิงรายการด้วยชื่อ และอุปกรณ์รายชิ้นด้วยเลขเครื่อง
 * เลขเครื่อง = หมวด + ลำดับรายการในหมวด + เลขชิ้น 3 หลัก (เช่น 42001 = หมวด 4 รายการที่ 2 ชิ้นที่ 1)
 */
class ComputerEquipmentSeeder extends Seeder
{
    const UNITS_PER_ITEM = 3;

    // หมวด => [ชื่อหมวด, [ชื่อรายการ => รูป]]
    const CATALOG = [
        4 => ['คอมพิวเตอร์', [
            'โน้ตบุ๊ก' => 'wm-laptop.jpg',
            'แท็บเล็ต' => 'wm-tablet.jpg',
            'Raspberry Pi' => 'wm-raspberry-pi.jpg',
            'ชุดบอร์ด Arduino' => 'wm-arduino.jpg',
        ]],
        5 => ['อุปกรณ์ต่อพ่วง', [
            'จอมอนิเตอร์' => 'wm-monitor.jpg',
            'คีย์บอร์ด' => 'wm-keyboard.jpg',
            'เมาส์' => 'wm-mouse.jpg',
            'โปรเจกเตอร์' => 'wm-projector.jpg',
            'ฮาร์ดดิสก์พกพา' => 'wm-external-hdd.jpg',
            'แฟลชไดรฟ์' => 'wm-flash-drive.jpg',
            'เว็บแคม' => 'wm-webcam.jpg',
            'สาย HDMI' => 'wm-hdmi-cable.jpg',
            'ตัวแปลง USB-C เป็น HDMI' => 'wm-usbc-hdmi.jpg',
        ]],
        2 => ['อุปกรณ์เครือข่าย', [
            'สวิตช์' => 'wm-switch.jpg',
            'เราเตอร์ไร้สาย' => 'wm-router.jpg',
            'คีมเข้าหัว RJ45' => 'wm-crimper.jpg',
            'เครื่องทดสอบสายแลน' => 'wm-cable-tester.jpg',
        ]],
        7 => ['กล้อง / อุปกรณ์ถ่ายภาพ', [
            'กล้อง DSLR' => 'wm-dslr.jpg',
            'ขาตั้งกล้อง' => 'wm-tripod.jpg',
        ]],
        8 => ['เครื่องเสียง', [
            'ลำโพง' => 'wm-speaker.jpg',
            'ไมโครโฟนไร้สาย' => 'wm-wireless-mic.jpg',
        ]],
        6 => ['เครื่องมือช่าง', [
            'ชุดไขควง' => 'wm-screwdriver-set.jpg',
            'หัวแร้งบัดกรี' => 'wm-soldering-iron.jpg',
        ]],
    ];

    public function run(): void
    {
        $now = now();

        foreach (self::CATALOG as $categoryId => [$categoryName, $items]) {
            // สร้างหมวดถ้ายังไม่มี และเปิดใช้งาน (มีอุปกรณ์ให้ยืมแล้ว)
            DB::table('equipment_category')->updateOrInsert(
                ['id' => $categoryId],
                ['name' => $categoryName, 'status' => 1, 'updated_at' => $now, 'deleted_at' => null]
            );
            DB::table('equipment_category')->where('id', $categoryId)->whereNull('created_at')->update(['created_at' => $now]);

            foreach ($items as $name => $image) {
                $itemId = DB::table('equipment_item')->where('category_id', $categoryId)->where('name', $name)->value('id')
                    ?? DB::table('equipment_item')->insertGetId([
                        'category_id' => $categoryId,
                        'name' => $name,
                        'status' => 1,
                        'image' => $image,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                $prefix = $categoryId . $this->itemOrder($categoryId, $itemId);
                for ($i = 1; $i <= self::UNITS_PER_ITEM; $i++) {
                    $number = $prefix . str_pad($i, 3, '0', STR_PAD_LEFT);
                    if (DB::table('equipment')->where('number', $number)->exists()) {
                        continue;
                    }
                    DB::table('equipment')->insert([
                        'item_id' => $itemId,
                        'number' => $number,
                        'status' => 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }

    /**
     * ลำดับของรายการในหมวด: ใช้ลำดับเดิมถ้ามีเลขเครื่องอยู่แล้ว ไม่งั้นต่อจากลำดับสูงสุดในหมวด
     */
    private function itemOrder(int $categoryId, int $itemId): int
    {
        $existing = DB::table('equipment')->where('item_id', $itemId)->value('number');
        if ($existing) {
            return (int) substr($existing, strlen((string) $categoryId), -3);
        }

        $used = DB::table('equipment')
            ->join('equipment_item', 'equipment_item.id', '=', 'equipment.item_id')
            ->where('equipment_item.category_id', $categoryId)
            ->pluck('equipment.number')
            ->map(fn($n) => (int) substr($n, strlen((string) $categoryId), -3))
            ->max() ?? 0;

        return $used + 1;
    }
}
