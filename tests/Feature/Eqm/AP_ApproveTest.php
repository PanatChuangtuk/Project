<?php

namespace Tests\Feature\Eqm;

use App\Models\EqmBorrowReturnHistory;
use PHPUnit\Framework\Attributes\TestDox;

class AP_ApproveTest extends EqmTestCase
{
    #[TestDox('AP-01 อนุมัติพร้อมระบุเลขอุปกรณ์')]
    public function test_AP01(): void
    {
        $master = $this->requestLoan($this->borrower(), ['โน้ตบุ๊ก' => 2]);

        $this->as($this->admin())->get(route('administrator.approve-equipment'))->assertOk()->assertSee('ปณัติ');
        $this->approveBorrow($master, ['42001', '42002'])->assertSessionHas('success', 'อนุมัติการยืมสำเร็จ');

        $this->assertSame('borrowed', $master->fresh()->status);
        $events = EqmBorrowReturnHistory::where('master_id', $master->id)->where('action', 'approve_borrow')->get();
        $this->assertCount(2, $events);
        $this->assertSame(['42001', '42002'], $events->map(fn($e) => $e->equipment->number)->sort()->values()->all());
        $this->assertSame('panat chuangtuk (เจ้าหน้าที่)', $events->first()->actorLabel());

        $html = $this->get(route('administrator.approve-equipment.edit', $master->id))->assertOk()
            ->assertSee('อนุมัติการยืม')->assertSee('panat chuangtuk (เจ้าหน้าที่)')->getContent();
        $this->assertMatchesRegularExpression('/หมายเลข\s+42001/u', $html);
        $this->assertMatchesRegularExpression('/หมายเลข\s+42002/u', $html);
    }

    #[TestDox('AP-02 ระบุเลขอุปกรณ์ไม่ครบ')]
    public function test_AP02(): void
    {
        $master = $this->requestLoan($this->borrower(), ['โน้ตบุ๊ก' => 2]);

        $this->approveBorrow($master, ['42001'])
            ->assertSessionHas('error', 'กรุณาเลือกหมายเลขอุปกรณ์ให้ครบทุกรายการ');
        $this->assertSame('pending', $master->fresh()->status);
    }

    #[TestDox('AP-03 เลือกเลขอุปกรณ์ซ้ำ')]
    public function test_AP03(): void
    {
        $master = $this->requestLoan($this->borrower(), ['โน้ตบุ๊ก' => 2]);

        $this->approveBorrow($master, ['42001', '42001'])
            ->assertSessionHas('error', 'ห้ามเลือกหมายเลขอุปกรณ์ซ้ำกัน');
        $this->assertSame('pending', $master->fresh()->status);
    }

    #[TestDox('AP-04 เลือกเลขที่ถูกยืมอยู่')]
    public function test_AP04(): void
    {
        $this->borrowedLoan($this->otherBorrower(), ['โน้ตบุ๊ก' => 1], ['42001']);
        $master = $this->requestLoan($this->borrower(), ['โน้ตบุ๊ก' => 1]);

        $numbers = collect($this->as($this->admin())
            ->getJson('/get-equipment?item_id=' . $this->item('โน้ตบุ๊ก')->id . '&query=')
            ->assertOk()->json('results'))->pluck('number');
        $this->assertNotContains('42001', $numbers);
        $this->assertContains('42002', $numbers);

        $this->approveBorrow($master, ['42001'])
            ->assertSessionHas('error', 'มีหมายเลขอุปกรณ์ที่ถูกยืมอยู่แล้ว กรุณาเลือกใหม่');
        $this->assertSame('pending', $master->fresh()->status);
    }

    #[TestDox('AP-05 เลือกเลขที่ปิดใช้งาน')]
    public function test_AP05(): void
    {
        $this->unit('42003')->update(['status' => 0]);
        $master = $this->requestLoan($this->borrower(), ['โน้ตบุ๊ก' => 1]);

        $numbers = collect($this->as($this->admin())
            ->getJson('/get-equipment?item_id=' . $this->item('โน้ตบุ๊ก')->id . '&query=')
            ->json('results'))->pluck('number');
        $this->assertNotContains('42003', $numbers);

        $this->approveBorrow($master, ['42003'])
            ->assertSessionHas('error', 'อุปกรณ์หมายเลข 42003 ถูกปิดใช้งาน');
        $this->assertSame('pending', $master->fresh()->status);
    }

    #[TestDox('AP-06 เจ้าหน้าที่ยกเลิกคำขอยืม')]
    public function test_AP06(): void
    {
        $master = $this->requestLoan($this->borrower(), ['โน้ตบุ๊ก' => 1]);

        $this->as($this->admin())
            ->postJson(route('administrator.approve-equipment.update'), ['item' => $master->id, 'status' => 'cancel'])
            ->assertOk()->assertJson(['success' => true, 'message' => 'ยกเลิกคำขอยืมเรียบร้อยแล้ว']);

        $this->assertSame('cancelled', $master->fresh()->status);
        $event = EqmBorrowReturnHistory::where('master_id', $master->id)->where('action', 'cancel')->firstOrFail();
        $this->assertSame('panat chuangtuk (เจ้าหน้าที่)', $event->actorLabel());
    }
}
