<?php

namespace Tests\Feature\Eqm;

use App\Models\{EqmHistoryMaster, Equipment, EquipmentItem, Member};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * ฐานของกรณีทดสอบตามเอกสาร TD-EQM-001 (docs/testing)
 * ใช้ข้อมูลจาก seeder จริง: ผู้ยืม member 35 / 40, เจ้าหน้าที่ member 36
 * รันบนฐานข้อมูล eqm_test เท่านั้น (ตั้งใน phpunit.xml)
 */
abstract class EqmTestCase extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        // กันไม่ให้ RefreshDatabase ล้างฐานข้อมูลที่ใช้งานจริง
        if (DB::connection()->getDatabaseName() !== 'eqm_test') {
            $this->fail('ต้องรันบนฐานข้อมูล eqm_test เท่านั้น');
        }
    }

    protected function borrower(): Member
    {
        return Member::findOrFail(35);
    }

    protected function otherBorrower(): Member
    {
        return Member::findOrFail(40);
    }

    protected function admin(): Member
    {
        return Member::findOrFail(36);
    }

    // เปลี่ยนผู้ใช้ เหมือนเปิดเบราว์เซอร์คนละเครื่อง (ไม่ให้ guard ของคนก่อนค้าง)
    protected function as(Member $member): static
    {
        $this->app['auth']->forgetGuards();
        return $this->actingAs($member, $member->role === 'admin' ? 'web' : 'member');
    }

    protected function item(string $name): EquipmentItem
    {
        return EquipmentItem::where('name', $name)->firstOrFail();
    }

    protected function unit(string $number): Equipment
    {
        return Equipment::where('number', $number)->firstOrFail();
    }

    /**
     * ผู้ยืมส่งคำขอยืมผ่านหน้าเว็บ [ชื่ออุปกรณ์ => จำนวน] คืนใบยืมที่สร้าง
     */
    protected function requestLoan(Member $member, array $items): EqmHistoryMaster
    {
        $payload = [];
        foreach ($items as $name => $quantity) {
            $payload[] = ['id' => $this->item($name)->id, 'quantity' => $quantity];
        }
        $this->as($member)->from(route('borrow.cart'))
            ->post(route('borrow.submit'), ['items' => $payload])
            ->assertSessionHas('success');

        return EqmHistoryMaster::where('member_id', $member->id)->latest('id')->firstOrFail();
    }

    /**
     * เจ้าหน้าที่อนุมัติการยืม โดยระบุเลขเครื่องตามลำดับชิ้นในใบยืม
     */
    protected function approveBorrow(EqmHistoryMaster $master, array $numbers)
    {
        $details = $master->details()->orderBy('id')->get();
        return $this->as($this->admin())->from(route('administrator.approve-equipment.edit', $master->id))
            ->post(route('administrator.approve-equipment.approveEquipment'), [
                'master_id' => $master->id,
                'item_id' => $details->pluck('id')->all(),
                'equipments_id' => collect($numbers)->map(fn($n) => $this->unit($n)->id)->all(),
            ]);
    }

    protected function borrowedLoan(Member $member, array $items, array $numbers): EqmHistoryMaster
    {
        $master = $this->requestLoan($member, $items);
        $this->approveBorrow($master, $numbers)->assertSessionHas('success');
        return $master->fresh();
    }

    // เลื่อนวันยืมย้อนหลัง ให้กำหนดคืนเลยมาแล้ว $days วัน
    protected function makePastDue(EqmHistoryMaster $master, int $days): EqmHistoryMaster
    {
        $borrowedAt = now()->subDays(EqmHistoryMaster::LOAN_DAYS + $days)->subMinutes(5);
        $master->update(['borrowed_at' => $borrowedAt, 'due_at' => $borrowedAt->copy()->addDays(EqmHistoryMaster::LOAN_DAYS)]);
        return $master->fresh();
    }

    protected function requestReturn(EqmHistoryMaster $master)
    {
        return $this->as($master->member)->from(route('return.index'))
            ->post(route('return.equipment', $master->id));
    }

    /**
     * เจ้าหน้าที่ตรวจรับคืน [สภาพ] หรือ [[สภาพ, หมายเหตุ]] ตามลำดับชิ้น
     */
    protected function inspectReturn(EqmHistoryMaster $master, ?array $conditions)
    {
        $details = $master->details()->orderBy('id')->get();
        $payload = ['master_id' => $master->id, 'item_id' => $details->pluck('id')->all()];
        if ($conditions !== null) {
            $payload['conditions'] = array_map(fn($c) => is_array($c) ? $c[0] : $c, $conditions);
            $payload['condition_notes'] = array_map(fn($c) => is_array($c) ? $c[1] : '', $conditions);
        }
        return $this->as($this->admin())->from(route('administrator.return-equipment.edit', $master->id))
            ->post(route('administrator.return-equipment.approveEquipment'), $payload);
    }

    protected function stock(string $name): int
    {
        $item = $this->item($name);
        $active = DB::table('eqm_history_detail')
            ->join('eqm_history_master', 'eqm_history_master.id', '=', 'eqm_history_detail.master_id')
            ->whereNull('eqm_history_master.deleted_at')
            ->whereIn('eqm_history_master.status', EqmHistoryMaster::ACTIVE_STATUSES)
            ->where('equipment_item_id', $item->id)
            ->count();
        return $item->activeEquipment()->count() - $active;
    }
}
