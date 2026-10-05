<?php

namespace Tests\Feature\Eqm;

use App\Models\{EqmHistoryMaster, EqmBorrowReturnHistory};
use PHPUnit\Framework\Attributes\TestDox;

class BR_BorrowTest extends EqmTestCase
{
    #[TestDox('BR-01 เพิ่มอุปกรณ์ลงตะกร้า')]
    public function test_BR01(): void
    {
        $this->as($this->borrower())
            ->get(route('equipment.list', ['type' => 5]))->assertOk()->assertSee('เมาส์');

        $this->postJson(route('equipment.list.cart'), ['equipment_id' => $this->item('เมาส์')->id, 'quantity' => 1])
            ->assertOk()->assertJson(['status' => 'success']);

        $this->get(route('borrow.cart'))->assertOk()->assertSee('เมาส์');
        $this->assertSame(1, session('cart')[$this->item('เมาส์')->id]['quantity']);
    }

    #[TestDox('BR-02 เพิ่มเกินจำนวนคงเหลือ')]
    public function test_BR02(): void
    {
        $this->assertSame(3, $this->stock('เมาส์'));

        $this->as($this->borrower())
            ->postJson(route('equipment.list.cart'), ['equipment_id' => $this->item('เมาส์')->id, 'quantity' => 4])
            ->assertStatus(422)->assertJson(['message' => 'เกินจำนวนที่สามารถยืมได้']);

        $this->assertEmpty(session('cart', []));
    }

    #[TestDox('BR-03 ยืนยันการยืม')]
    public function test_BR03(): void
    {
        $this->withSession(['cart' => ['x' => 1]]);
        $master = $this->requestLoan($this->borrower(), ['เมาส์' => 1, 'คีย์บอร์ด' => 1]);

        $this->assertEmpty(session('cart', []));
        $this->assertSame('pending', $master->status);
        $this->assertSame(2, $master->details()->count());
        $this->assertTrue($master->due_at->equalTo($master->borrowed_at->copy()->addDays(7)));

        $this->get(route('return.index'))->assertOk()
            ->assertSee('อยู่ระหว่างการดำเนินการ กรุณารอการยืนยัน');
    }

    #[TestDox('BR-04 ยืนยันการยืมเมื่อตะกร้าว่าง')]
    public function test_BR04(): void
    {
        $this->as($this->borrower())->from(route('borrow.cart'))
            ->post(route('borrow.submit'), [])
            ->assertSessionHas('error', 'ไม่มีอุปกรณ์ในตะกร้า');

        $this->assertSame(0, EqmHistoryMaster::count());
    }

    #[TestDox('BR-05 สต็อกถูกยืมไปก่อนกดยืนยัน')]
    public function test_BR05(): void
    {
        $tripod = $this->item('ขาตั้งกล้อง');
        $this->as($this->borrower())->postJson(route('equipment.list.cart'), ['equipment_id' => $tripod->id, 'quantity' => 3])->assertOk();
        // ผู้ยืม B ใช้เบราว์เซอร์อีกเครื่อง: ตะกร้าแยกกัน
        session()->forget('cart');
        $this->as($this->otherBorrower())->postJson(route('equipment.list.cart'), ['equipment_id' => $tripod->id, 'quantity' => 3])->assertOk();

        $this->requestLoan($this->borrower(), ['ขาตั้งกล้อง' => 3]);

        $this->as($this->otherBorrower())->from(route('borrow.cart'))
            ->post(route('borrow.submit'), ['items' => [['id' => $tripod->id, 'quantity' => 3]]])
            ->assertSessionHas('error', 'อุปกรณ์ ขาตั้งกล้อง มีจำนวนไม่เพียงพอ');

        $this->assertSame(0, EqmHistoryMaster::where('member_id', $this->otherBorrower()->id)->count());
    }

    #[TestDox('BR-06 ยกเลิกคำขอยืมที่รออนุมัติ')]
    public function test_BR06(): void
    {
        $master = $this->requestLoan($this->borrower(), ['เมาส์' => 2]);
        $this->assertSame(1, $this->stock('เมาส์'));

        $this->as($this->borrower())->from(route('return.index'))
            ->post(route('cancel.equipment', $master->id))->assertSessionHas('success');

        $this->assertSame('cancelled', $master->fresh()->status);
        $this->assertSame(3, $this->stock('เมาส์'));
        $event = EqmBorrowReturnHistory::where('master_id', $master->id)->where('action', 'cancel')->firstOrFail();
        $this->assertSame('ปณัติ ช่วงถึก (ผู้ยืม)', $event->actorLabel());
    }

    #[TestDox('BR-07 ยกเลิกคำขอที่อนุมัติแล้ว')]
    public function test_BR07(): void
    {
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);

        $this->as($this->borrower())->post(route('cancel.equipment', $master->id))
            ->assertStatus(422)->assertSee('รายการนี้ไม่สามารถยกเลิกได้');

        $this->assertSame('borrowed', $master->fresh()->status);
    }
}
