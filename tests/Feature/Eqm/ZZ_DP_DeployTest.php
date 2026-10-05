<?php

namespace Tests\Feature\Eqm;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Support\Facades\{Artisan, DB, Schema};
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

/**
 * กลุ่ม DP: ทดสอบการติดตั้งบนฐานข้อมูลเปล่า จึงไม่ใช้ RefreshDatabase (ล้างฐานข้อมูลทดสอบเอง)
 * ชื่อไฟล์ขึ้นต้น ZZ_ ให้รันหลังกลุ่มอื่น
 */
class ZZ_DP_DeployTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (DB::connection()->getDatabaseName() !== 'eqm_test') {
            $this->fail('ต้องรันบนฐานข้อมูล eqm_test เท่านั้น');
        }
        Artisan::call('db:wipe', ['--force' => true]);
    }

    protected function tearDown(): void
    {
        // ให้คลาสที่ใช้ RefreshDatabase สร้างฐานข้อมูลใหม่ถ้ารันต่อจากนี้
        RefreshDatabaseState::$migrated = false;
        parent::tearDown();
    }

    private function counts(): array
    {
        return [
            'member' => DB::table('member')->count(),
            'student' => DB::table('student')->count(),
            'adviser' => DB::table('adviser')->count(),
            'guide' => DB::table('guide')->count(),
            'equipment_category' => DB::table('equipment_category')->count(),
            'equipment_item' => DB::table('equipment_item')->count(),
            'equipment' => DB::table('equipment')->count(),
        ];
    }

    #[TestDox('DP-01 ติดตั้งบนฐานข้อมูลเปล่า')]
    public function test_DP01(): void
    {
        $this->assertSame(0, Artisan::call('migrate', ['--seed' => true, '--force' => true]));
        $output = Artisan::output();

        $this->assertSame(5, DB::table('migrations')->count());
        foreach (['MemberSeeder', 'EquipmentSeeder', 'ComputerEquipmentSeeder'] as $seeder) {
            $this->assertStringContainsString($seeder, $output);
        }
        $this->assertStringNotContainsStringIgnoringCase('error', $output);
    }

    #[TestDox('DP-02 ข้อมูลเริ่มต้นครบถ้วน')]
    public function test_DP02(): void
    {
        Artisan::call('migrate', ['--seed' => true, '--force' => true]);

        $this->assertSame([
            'member' => 3, 'student' => 3, 'adviser' => 26, 'guide' => 16,
            'equipment_category' => 7, 'equipment_item' => 32, 'equipment' => 77,
        ], $this->counts());
        $this->assertSame(0, DB::table('equipment')->where('status', '!=', 1)->count());
        $this->assertSame(0, Member::where('email', 'like', '%test%')->count());
    }

    #[TestDox('DP-03 รัน seeder ซ้ำ')]
    public function test_DP03(): void
    {
        Artisan::call('migrate', ['--seed' => true, '--force' => true]);
        $before = $this->counts();

        $this->assertSame(0, Artisan::call('db:seed', ['--force' => true]));

        $this->assertSame($before, $this->counts());
        $this->assertSame(77, DB::table('equipment')->distinct()->count('number'));
    }

    #[TestDox('DP-04 รูปอุปกรณ์แสดงครบ')]
    public function test_DP04(): void
    {
        Artisan::call('migrate', ['--seed' => true, '--force' => true]);

        $missing = [];
        foreach (DB::table('equipment_item')->whereNotNull('image')->get() as $item) {
            if (!is_file(public_path('upload/file/equipment_item/' . $item->image))) {
                $missing[] = $item->name . ' (' . $item->image . ')';
            }
        }
        foreach (DB::table('equipment')->whereNotNull('image')->get() as $unit) {
            if (!is_file(public_path('upload/file/qr_code/' . $unit->image))) {
                $missing[] = $unit->number . ' (' . $unit->image . ')';
            }
        }
        $this->assertSame([], $missing, 'รูปที่หาไม่พบ');

        // หน้ารายการอุปกรณ์ทุกหมวดเปิดได้
        $this->actingAs(Member::find(35), 'member');
        foreach (DB::table('equipment_category')->where('status', 1)->pluck('id') as $category) {
            $this->get(route('equipment.list', ['type' => $category]))->assertOk();
        }
    }

    #[TestDox('DP-05 ย้ายข้อมูลจากระบบเดิม')]
    public function test_DP05(): void
    {
        // ฐานข้อมูลเดิม: มีตาราง loan_transactions / loan_equipment
        Schema::create('loan_transactions', function ($t) {
            $t->integer('id', true);
            $t->integer('member_id');
            $t->string('status', 20);
            $t->string('status_type', 20);
            $t->dateTime('borrowed_at');
            $t->dateTime('returned_at')->nullable();
            $t->boolean('is_overdue')->default(false);
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('loan_equipment', function ($t) {
            $t->integer('id', true);
            $t->integer('loan_transactions_id');
            $t->integer('equipment_item_id');
            $t->integer('equipment_id')->nullable();
            $t->string('name', 50);
            $t->integer('quantity')->default(1);
            $t->timestamps();
            $t->softDeletes();
        });
        $old = [
            // id => [status, status_type, returned_at, is_overdue, [[item, equipment_id, qty]]]
            101 => ['pending', 'borrowed', null, 0, [[1, null, 2]]],
            102 => ['completed', 'borrowed', null, 0, [[1, 7, 1]]],
            103 => ['completed', 'returned', '2026-08-05 10:00:00', 0, [[4, 11, 1], [4, 12, 1]]],
            104 => ['pending', 'returned', '2026-08-06 10:00:00', 0, [[1, 8, 1]]],
            105 => ['completed', 'overdue', null, 1, [[2, 9, 1]]],
            106 => ['cancel', 'borrowed', null, 0, [[3, null, 1]]],
        ];
        foreach ($old as $id => [$status, $type, $returnedAt, $overdue, $lines]) {
            DB::table('loan_transactions')->insert([
                'id' => $id, 'member_id' => 35, 'status' => $status, 'status_type' => $type,
                'borrowed_at' => '2026-08-01 09:00:00', 'returned_at' => $returnedAt, 'is_overdue' => $overdue,
                'created_at' => '2026-08-01 09:00:00', 'updated_at' => '2026-08-01 09:00:00',
            ]);
            foreach ($lines as [$item, $equipment, $qty]) {
                DB::table('loan_equipment')->insert([
                    'loan_transactions_id' => $id, 'equipment_item_id' => $item, 'equipment_id' => $equipment,
                    'name' => 'อุปกรณ์ ' . $item, 'quantity' => $qty,
                    'created_at' => '2026-08-01 09:00:00', 'updated_at' => '2026-08-01 09:00:00',
                ]);
            }
        }

        $this->assertSame(0, Artisan::call('migrate', ['--seed' => true, '--force' => true]));

        $this->assertSame([101, 102, 103, 104, 105, 106], DB::table('eqm_history_master')->orderBy('id')->pluck('id')->all());
        $this->assertSame(
            ['pending', 'borrowed', 'returned', 'return_pending', 'overdue', 'cancelled'],
            DB::table('eqm_history_master')->orderBy('id')->pluck('status')->all()
        );
        $this->assertSame((int) DB::table('loan_equipment')->sum('quantity'), DB::table('eqm_history_detail')->count());
        $this->assertTrue(Schema::hasTable('loan_transactions'), 'ตารางเดิมต้องไม่ถูกลบ');

        $this->actingAs(Member::find(36), 'web');
        $this->get(route('administrator.return-equipment', ['all' => 1]))->assertOk()->assertSee('#103');
        $this->get(route('administrator.return-equipment.edit', 103))->assertOk()
            ->assertSee('ไม่ทราบเวลา')->assertSee('ย้ายจากข้อมูลเดิม');
    }
}
