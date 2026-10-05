<?php

namespace Tests\Feature\Eqm;

use App\Models\EqmBorrowReturnHistory;
use PHPUnit\Framework\Attributes\TestDox;

class RT_ReturnTest extends EqmTestCase
{
    #[TestDox('RT-01 ผู้ยืมแจ้งคืน')]
    public function test_RT01(): void
    {
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);

        $this->requestReturn($master)->assertSessionHas('success');

        $master->refresh();
        $this->assertSame('return_pending', $master->status);
        $this->assertNotNull($master->returned_at);
        $event = EqmBorrowReturnHistory::where('master_id', $master->id)->where('action', 'return_request')->firstOrFail();
        $this->assertSame('ปณัติ ช่วงถึก (ผู้ยืม)', $event->actorLabel());
    }

    #[TestDox('RT-02 ตรวจรับสภาพปกติ')]
    public function test_RT02(): void
    {
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 2], ['53001', '53002']);
        $this->requestReturn($master);
        $this->assertSame(1, $this->stock('เมาส์'));

        $this->inspectReturn($master, ['normal', 'normal'])->assertSessionHas('success', 'ตรวจรับคืนอุปกรณ์สำเร็จ');

        $this->assertSame('returned', $master->fresh()->status);
        $this->assertSame(1, $this->unit('53001')->status);
        $this->assertSame(1, $this->unit('53002')->status);
        $this->assertSame(3, $this->stock('เมาส์'));
    }

    #[TestDox('RT-03 ตรวจรับชำรุด/สูญหาย')]
    public function test_RT03(): void
    {
        $master = $this->borrowedLoan($this->borrower(), ['จอมอนิเตอร์' => 2], ['51001', '51002']);
        $this->requestReturn($master);

        $this->inspectReturn($master, [['damaged', 'จอแตก'], ['lost', '']])->assertSessionHas('success');

        $this->assertSame(0, $this->unit('51001')->status);
        $this->assertSame(0, $this->unit('51002')->status);
        $this->assertSame(1, $this->stock('จอมอนิเตอร์'));

        $this->as($this->admin())->get(route('administrator.return-equipment.edit', $master->id))->assertOk()
            ->assertSee('ชำรุด')->assertSee('สูญหาย')->assertSee('จอแตก');
        $this->get(route('administrator.loan.printReport', ['start_date' => now()->toDateString(), 'end_date' => now()->toDateString()]))
            ->assertOk()->assertSee('ชำรุด')->assertSee('สูญหาย')->assertSee('จอแตก');
        $this->as($this->borrower())->get(route('return.index'))->assertOk()->assertSee('จอแตก');
    }

    #[TestDox('RT-04 ไม่ระบุสภาพอุปกรณ์')]
    public function test_RT04(): void
    {
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);
        $this->requestReturn($master);

        $this->inspectReturn($master, null)->assertSessionHas('error', 'กรุณาระบุสภาพอุปกรณ์ให้ครบทุกรายการ');
        $this->assertSame('return_pending', $master->fresh()->status);
    }

    #[TestDox('RT-05 ปฏิเสธการคืน')]
    public function test_RT05(): void
    {
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);
        $this->requestReturn($master);

        $this->as($this->admin())
            ->postJson(route('administrator.return-equipment.update'), ['item' => $master->id, 'status' => 'cancel'])
            ->assertOk()->assertJson(['success' => true]);

        $master->refresh();
        $this->assertSame('borrowed', $master->status);
        $this->assertNull($master->returned_at);
        $this->assertTrue(EqmBorrowReturnHistory::where('master_id', $master->id)->where('action', 'reject_return')->exists());

        // ถ้าเลยกำหนดแล้ว ต้องกลับเป็นเกินกำหนด
        $late = $this->makePastDue($this->borrowedLoan($this->otherBorrower(), ['เมาส์' => 1], ['53002']), 1);
        $this->requestReturn($late);
        $this->as($this->admin())
            ->postJson(route('administrator.return-equipment.update'), ['item' => $late->id, 'status' => 'cancel'])->assertOk();
        $this->assertSame('overdue', $late->fresh()->status);
    }

    #[TestDox('RT-06 คืนช้ากว่ากำหนด')]
    public function test_RT06(): void
    {
        $master = $this->makePastDue($this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']), 2);
        $this->requestReturn($master);
        $this->inspectReturn($master, ['normal'])->assertSessionHas('success');

        $master->refresh();
        $this->assertTrue($master->is_overdue);
        $this->assertSame(2, $master->overdueDays());

        $this->as($this->admin())->get(route('administrator.return-equipment', ['all' => 1]))->assertOk()->assertSee('เกิน 2 วัน');
        $this->get(route('administrator.loan.printReport', ['start_date' => now()->subDays(10)->toDateString(), 'end_date' => now()->toDateString()]))
            ->assertOk()->assertSee('เกิน 2 วัน');
    }

    #[TestDox('RT-07 ผู้ยืมเห็นผลการตรวจรับ')]
    public function test_RT07(): void
    {
        $master = $this->borrowedLoan($this->borrower(), ['จอมอนิเตอร์' => 2], ['51001', '51002']);
        $this->requestReturn($master);
        $this->inspectReturn($master, [['damaged', 'จอแตก'], ['lost', '']]);

        $html = $this->as($this->borrower())->get(route('return.index', ['status' => 'returned']))->assertOk()
            ->assertSee('ตรวจรับคืนแล้ว พบอุปกรณ์ชำรุด/สูญหาย กรุณาติดต่อเจ้าหน้าที่')
            ->assertSee('หมายเหตุ: จอแตก')
            ->getContent();
        $this->assertMatchesRegularExpression('/ชำรุด\s+1 ชิ้น/u', $html);
        $this->assertMatchesRegularExpression('/สูญหาย\s+1 ชิ้น/u', $html);
    }

    #[TestDox('RT-08 อุปกรณ์รอตรวจรับยังไม่นับว่าง')]
    public function test_RT08(): void
    {
        $master = $this->borrowedLoan($this->borrower(), ['ลำโพง' => 3], ['81001', '81002', '81003']);
        $this->requestReturn($master);
        $this->assertSame('return_pending', $master->fresh()->status);

        $this->as($this->otherBorrower())->get(route('equipment.list', ['type' => 8]))->assertOk()
            ->assertSee('ลำโพง')->assertSee('ไม่มีอุปกรณ์ให้ยืม');
        $this->assertSame(0, $this->stock('ลำโพง'));

        $this->inspectReturn($master, ['normal', 'normal', 'normal']);
        $this->assertSame(3, $this->stock('ลำโพง'));
    }
}
