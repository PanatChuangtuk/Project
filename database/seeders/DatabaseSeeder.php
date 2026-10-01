<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * ข้อมูลเริ่มต้นสำหรับติดตั้งเครื่องใหม่: php artisan migrate --seed
     */
    public function run(): void
    {
        $this->call([
            MemberSeeder::class,
            EquipmentSeeder::class,
            ComputerEquipmentSeeder::class,
        ]);
    }
}
