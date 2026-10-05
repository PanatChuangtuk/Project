<?php

namespace Tests\Feature\Eqm;

use App\Models\EqmHistoryMaster;
use Illuminate\Support\Facades\{Artisan, Mail};
use PHPUnit\Framework\Attributes\TestDox;

class PN_OverduePenaltyTest extends EqmTestCase
{
    const MESSAGE = 'คุณมีอุปกรณ์ที่ยืมเกินกำหนด กรุณาคืนอุปกรณ์ก่อนจึงจะยืมใหม่ได้';

    private function overdueLoan(): EqmHistoryMaster
    {
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);
        $master = $this->makePastDue($master, 1);
        Mail::fake();
        Artisan::call('app:hourly-task-command');
        $this->assertSame('overdue', $master->fresh()->status);
        return $master->fresh();
    }

    #[TestDox('PN-01 หน้าตะกร้าเมื่อมีรายการเกินกำหนด')]
    public function test_PN01(): void
    {
        $this->overdueLoan();
        $this->withSession(['cart' => [$this->item('คีย์บอร์ด')->id => ['id' => $this->item('คีย์บอร์ด')->id, 'name' => 'คีย์บอร์ด', 'quantity' => 1, 'image' => null]]]);

        $html = $this->as($this->borrower())->get(route('borrow.cart'))->assertOk()
            ->assertSee('alert alert-danger', false)
            ->assertSee(self::MESSAGE)
            ->assertSee(route('return.index', ['status' => 'overdue']), false)
            ->getContent();

        $this->assertMatchesRegularExpression('/class="btn-borrow"\s+disabled/', $html);
    }

    #[TestDox('PN-02 เพิ่มลงตะกร้าเมื่อเกินกำหนด')]
    public function test_PN02(): void
    {
        $this->overdueLoan();

        $this->as($this->borrower())
            ->postJson(route('equipment.list.cart'), ['equipment_id' => $this->item('คีย์บอร์ด')->id, 'quantity' => 1])
            ->assertStatus(403)->assertJson(['message' => self::MESSAGE]);

        $this->assertEmpty(session('cart', []));
    }

    #[TestDox('PN-03 ส่งคำขอยืมตรงเมื่อเกินกำหนด')]
    public function test_PN03(): void
    {
        $this->overdueLoan();
        $before = EqmHistoryMaster::count();

        $this->as($this->borrower())->from(route('borrow.cart'))
            ->post(route('borrow.submit'), ['items' => [['id' => $this->item('คีย์บอร์ด')->id, 'quantity' => 1]]])
            ->assertSessionHas('error', self::MESSAGE);

        $this->assertSame($before, EqmHistoryMaster::count());
    }

    #[TestDox('PN-04 บล็อกแม้งานอัตโนมัติยังไม่รัน')]
    public function test_PN04(): void
    {
        $master = $this->makePastDue($this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']), 1);
        $this->assertSame('borrowed', $master->status);

        $this->as($this->borrower())->get(route('borrow.cart'))->assertOk()->assertSee(self::MESSAGE);
        $this->postJson(route('equipment.list.cart'), ['equipment_id' => $this->item('คีย์บอร์ด')->id, 'quantity' => 1])
            ->assertStatus(403);
    }

    #[TestDox('PN-05 ยืมได้หลังแจ้งคืน')]
    public function test_PN05(): void
    {
        $master = $this->overdueLoan();
        $this->requestReturn($master)->assertSessionHas('success');

        $this->as($this->borrower())->get(route('borrow.cart'))->assertOk()->assertDontSee(self::MESSAGE);
        $this->postJson(route('equipment.list.cart'), ['equipment_id' => $this->item('คีย์บอร์ด')->id, 'quantity' => 1])
            ->assertOk()->assertJson(['status' => 'success']);
        $this->requestLoan($this->borrower(), ['คีย์บอร์ด' => 1]);
    }

    #[TestDox('PN-06 คำขอที่ยังไม่อนุมัติไม่นับเป็นเกินกำหนด')]
    public function test_PN06(): void
    {
        $master = $this->makePastDue($this->requestLoan($this->borrower(), ['เมาส์' => 1]), 1);
        $master->update(['created_at' => now()->subDays(8)]);

        Mail::fake();
        Artisan::call('app:hourly-task-command');

        $this->assertSame('pending', $master->fresh()->status);
        $this->as($this->borrower())->get(route('borrow.cart'))->assertOk()->assertDontSee(self::MESSAGE);
    }
}
