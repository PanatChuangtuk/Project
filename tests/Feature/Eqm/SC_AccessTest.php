<?php

namespace Tests\Feature\Eqm;

use PHPUnit\Framework\Attributes\TestDox;

class SC_AccessTest extends EqmTestCase
{
    #[TestDox('SC-01 คืนหรือยกเลิกใบยืมของผู้อื่น')]
    public function test_SC01(): void
    {
        $borrowed = $this->borrowedLoan($this->otherBorrower(), ['เมาส์' => 1], ['53001']);
        $pending = $this->requestLoan($this->otherBorrower(), ['คีย์บอร์ด' => 1]);

        $this->as($this->borrower())->post(route('return.equipment', $borrowed->id))->assertNotFound();
        $this->post(route('cancel.equipment', $pending->id))->assertNotFound();

        $this->assertSame('borrowed', $borrowed->fresh()->status);
        $this->assertSame('pending', $pending->fresh()->status);
    }

    #[TestDox('SC-02 เข้าหน้าผู้ยืมโดยไม่เข้าสู่ระบบ')]
    public function test_SC02(): void
    {
        $this->get('/borrow-cart')->assertRedirect(route('login'));
        $this->get('/return')->assertRedirect(route('login'));
    }

    #[TestDox('SC-03 ผู้ยืมเข้าหน้าเจ้าหน้าที่')]
    public function test_SC03(): void
    {
        $this->as($this->borrower())->get('/administrator/return-equipment')->assertRedirect(route('login'));
        $this->get('/administrator/approve-equipment')->assertRedirect(route('login'));
    }
}
