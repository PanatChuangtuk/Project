<?php

namespace Tests\Feature\Eqm;

use App\Models\EqmHistoryMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\TestDox;
use Rap2hpoutre\FastExcel\FastExcel;

class HR_HistoryReportTest extends EqmTestCase
{
    private function returnedLoan(): EqmHistoryMaster
    {
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);
        $this->requestReturn($master);
        $this->inspectReturn($master, ['normal']);
        return $master->fresh();
    }

    // ข้อมูลหลายสถานะ สำหรับทดสอบแท็บ
    private function mixedLoans(): void
    {
        $this->returnedLoan();                                                            // คืนแล้ว
        $this->requestLoan($this->otherBorrower(), ['คีย์บอร์ด' => 1]);                   // รอดำเนินการ
        $this->borrowedLoan($this->otherBorrower(), ['ลำโพง' => 1], ['81001']);            // กำลังยืม
        $damaged = $this->borrowedLoan($this->otherBorrower(), ['จอมอนิเตอร์' => 1], ['51001']);
        $this->requestReturn($damaged);
        $this->inspectReturn($damaged, [['damaged', 'ขาหัก']]);                            // ชำรุด
        $cancel = $this->requestLoan($this->borrower(), ['แฟลชไดรฟ์' => 1]);
        $this->as($this->borrower())->post(route('cancel.equipment', $cancel->id));        // ยกเลิก
        // สร้างรายการเกินกำหนดเป็นลำดับสุดท้าย เพราะเมื่อเกินกำหนดแล้วผู้ยืมจะยืมเพิ่มไม่ได้ (PN)
        $this->makePastDue($this->borrowedLoan($this->borrower(), ['เว็บแคม' => 1], ['57001']), 3); // เกินกำหนด
    }

    #[TestDox('HR-01 เส้นเวลาประวัติในหน้ารายละเอียด')]
    public function test_HR01(): void
    {
        $master = $this->returnedLoan();

        $this->as($this->admin())->get(route('administrator.return-equipment.edit', $master->id))->assertOk()
            ->assertSeeInOrder(['ขอยืม', 'โดย ปณัติ ช่วงถึก (ผู้ยืม)', 'อนุมัติการยืม', 'โดย panat chuangtuk (เจ้าหน้าที่)', 'แจ้งคืน', 'โดย ปณัติ ช่วงถึก (ผู้ยืม)', 'ตรวจรับคืน', 'โดย panat chuangtuk (เจ้าหน้าที่)'])
            ->assertDontSee('ไม่ทราบเวลา')
            ->assertSee(' น.');
    }

    #[TestDox('HR-02 หน้ารายการจัดกลุ่มตามใบยืม')]
    public function test_HR02(): void
    {
        $returned = $this->returnedLoan();
        $this->travel(1)->minutes();
        $open = $this->borrowedLoan($this->otherBorrower(), ['ลำโพง' => 1], ['81001']);

        $response = $this->as($this->admin())->get(route('administrator.return-equipment', ['all' => 1]))->assertOk();
        $html = $response->getContent();

        // ใบล่าสุดอยู่บน และแต่ละใบเป็น 1 กลุ่ม (tbody)
        $response->assertSeeInOrder(['#' . $open->id, '#' . $returned->id]);
        $this->assertSame(2, substr_count($html, 'class="eqm-group"'));
        preg_match_all('/<tbody class="eqm-group">(.*?)<\/tbody>/s', $html, $groups);
        $this->assertSame(1, substr_count($groups[1][0], '>ยืม</span>'));  // ใบที่ยังไม่คืน: แถวยืมเท่านั้น
        $this->assertSame(0, substr_count($groups[1][0], '>คืน</span>'));
        $this->assertSame(1, substr_count($groups[1][1], '>ยืม</span>'));  // ใบที่คืนแล้ว: แถวยืม + แถวคืน
        $this->assertSame(1, substr_count($groups[1][1], '>คืน</span>'));
    }

    #[TestDox('HR-03 แท็บกรอง')]
    public function test_HR03(): void
    {
        $this->mixedLoans();
        $expected = ['all' => 6, 'waiting' => 1, 'borrowing' => 1, 'overdue' => 1, 'returned' => 2, 'damaged' => 1, 'cancelled' => 1];

        $this->as($this->admin());
        foreach ($expected as $tab => $count) {
            $response = $this->get(route('administrator.return-equipment', ['tab' => $tab, 'all' => 1]))->assertOk();
            $this->assertSame($count, $response->viewData('users')->total(), "แท็บ $tab");
            $this->assertSame($count, $response->viewData('tabCounts')[$tab], "ตัวเลขบนแท็บ $tab");
        }
    }

    #[TestDox('HR-04 ค้นหาตามชื่อหรือรหัสนักศึกษา')]
    public function test_HR04(): void
    {
        $this->mixedLoans();

        $response = $this->as($this->admin())
            ->get(route('administrator.return-equipment', ['query' => '6402041520111']))->assertOk();
        $loans = collect($response->viewData('users')->items());
        $this->assertSame(3, $loans->count());
        $this->assertTrue($loans->every(fn($m) => $m->member_id === 35));
        $this->assertSame(3, $response->viewData('tabCounts')['all']);
        $this->assertSame(0, $response->viewData('tabCounts')['waiting']);

        $byName = $this->get(route('administrator.return-equipment', ['query' => 'ศิริพร']));
        $this->assertTrue(collect($byName->viewData('users')->items())->every(fn($m) => $m->member_id === 40));
    }

    #[TestDox('HR-05 รายงานแบบพิมพ์')]
    public function test_HR05(): void
    {
        Mail::fake();
        $this->travelTo(Carbon::parse('2026-08-20 10:00'));
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);
        $this->travelTo(Carbon::parse('2026-10-01 09:00'));
        $this->requestReturn($master);
        $this->inspectReturn($master, ['normal']);
        // ใบยืมเดือน ต.ค. อีกใบ (อยู่ในช่วงทั้งหมด)
        $this->borrowedLoan($this->otherBorrower(), ['ลำโพง' => 1], ['81001']);
        $this->travelBack();

        $response = $this->as($this->admin())
            ->get(route('administrator.loan.printReport', ['start_date' => '2026-10-01', 'end_date' => '2026-10-31']))->assertOk();
        $html = $response->getContent();

        $response->assertSee('#' . $master->id)->assertSee('(นอกช่วงรายงาน)');
        $this->assertSame(1, substr_count($html, 'class="out-of-range"'));
        // ตัวเลขสรุป: ยืมในช่วง 1 ครั้ง คืนในช่วง 1 ครั้ง (แถวยืมเดือน ส.ค. ไม่นับ)
        $this->assertSame(1, $response->viewData('loans')->filter(fn($l) => $l->borrowed_at->between(Carbon::parse('2026-10-01'), Carbon::parse('2026-10-31 23:59:59')))->count());
        preg_match_all('/<strong>(\d+)<\/strong><span>([^<]+)<\/span>/u', $html, $m);
        $summary = array_combine($m[2], array_map('intval', $m[1]));
        fwrite(STDERR, 'HR-05 summary: ' . json_encode($summary, JSON_UNESCAPED_UNICODE) . PHP_EOL);
        $this->assertSame(1, $summary['คืนเกินกำหนด'] ?? null, 'คืนช้ากว่ากำหนด 1 รายการ');
    }

    #[TestDox('HR-06 ส่งออก Excel')]
    public function test_HR06(): void
    {
        $this->returnedLoan();

        $response = $this->as($this->admin())->post(route('administrator.return-equipment.export'), [
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
        ])->assertOk();

        $this->assertStringContainsString('.xlsx', $response->headers->get('content-disposition'));
        $file = tempnam(sys_get_temp_dir(), 'eqm') . '.xlsx';
        file_put_contents($file, $response->streamedContent());
        $rows = (new FastExcel)->import($file);
        unlink($file);

        $this->assertSame(
            ['วันที่', 'ชนิด', 'รายการที่', 'รหัสนักศึกษา', 'ชื่อ-นามสกุล', 'ชื่ออุปกรณ์', 'จำนวน', 'เลขอุปกรณ์', 'ผู้ดำเนินการ', 'สถานะ', 'กำหนดคืน', 'เกินกำหนด (วัน)', 'สภาพอุปกรณ์ที่ได้รับคืน'],
            array_keys($rows->first())
        );
        $this->assertSame(['ยืม', 'คืน'], $rows->pluck('ชนิด')->all());
        $this->assertSame('ปกติ 1', $rows->last()['สภาพอุปกรณ์ที่ได้รับคืน']);
    }

    #[TestDox('HR-08 dialog ตัวกรอง: เลขใบยืม อุปกรณ์ ผู้ยืม ช่วงวันที่')]
    public function test_HR08(): void
    {
        $this->travelTo(Carbon::parse('2026-08-20 10:00'));
        $old = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);
        $this->requestReturn($old);
        $this->inspectReturn($old, ['normal']);
        $this->travelTo(Carbon::parse('2026-10-01 09:00'));
        $speaker = $this->borrowedLoan($this->otherBorrower(), ['ลำโพง' => 1], ['81001']);
        $mouse = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);
        $this->travelBack();

        $this->as($this->admin());
        $ids = fn(array $filters) => collect($this->get(route('administrator.return-equipment', $filters))->assertOk()
            ->viewData('users')->items())->pluck('id')->sort()->values()->all();

        $this->assertSame([$speaker->id], $ids(['loan_no' => '#' . $speaker->id]));
        $this->assertSame([$old->id, $mouse->id], $ids(['equipment_item_ids' => [$this->item('เมาส์')->id]]));
        // เลือกได้หลายรายการ = ตรงกับรายการใดรายการหนึ่ง
        $this->assertSame([$old->id, $speaker->id, $mouse->id], $ids(['equipment_item_ids' => [$this->item('เมาส์')->id, $this->item('ลำโพง')->id]]));
        $this->assertSame([$old->id, $mouse->id], $ids(['member_ids' => [$this->borrower()->id]]));
        $this->assertSame([$old->id, $speaker->id, $mouse->id], $ids(['member_ids' => [$this->borrower()->id, $this->otherBorrower()->id]]));
        $this->assertSame([$speaker->id], $ids(['member_ids' => [$this->borrower()->id, $this->otherBorrower()->id], 'equipment_item_ids' => [$this->item('ลำโพง')->id]]));
        $this->assertSame([$speaker->id, $mouse->id], $ids(['start_date' => '2026-10-01', 'end_date' => '2026-10-31']));
        $this->assertSame([$old->id], $ids(['end_date' => '2026-08-31']));
        // หลายเงื่อนไขพร้อมกัน + ชื่อเต็ม
        $this->assertSame([$mouse->id], $ids(['query' => 'ปณัติ ช่วงถึก', 'start_date' => '2026-10-01', 'end_date' => '2026-10-31']));
        // ค่าไม่ถูกต้องถูกละไว้ ไม่ error
        $this->assertSame([], $ids(['loan_no' => 'abc']));
        $this->assertCount(3, $ids(['start_date' => 'not-a-date', 'all' => 1]));

        // ตัวเลขบนแท็บและลิงก์แบ่งหน้าใช้ตัวกรองเดียวกัน
        $response = $this->get(route('administrator.return-equipment', ['equipment_item_ids' => [$this->item('ลำโพง')->id]]));
        $this->assertSame(1, $response->viewData('tabCounts')['all']);
        $this->assertSame(0, $response->viewData('tabCounts')['returned']);

        // รายงานใช้ตัวกรองเดียวกัน
        $report = $this->get(route('administrator.loan.printReport', [
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-31',
            'equipment_item_ids' => [$this->item('ลำโพง')->id],
        ]))->assertOk();
        $this->assertSame([$speaker->id], $report->viewData('loans')->pluck('id')->all());

        // ป้ายตัวกรอง: 1 ป้ายต่อ 1 รายการที่เลือก
        $this->get(route('administrator.return-equipment', ['member_ids' => [$this->borrower()->id, $this->otherBorrower()->id]]))
            ->assertSee('ผู้ยืม: ปณัติ ช่วงถึก (6402041520111)')
            ->assertSee('ผู้ยืม: ศิริพร', false);
    }

    #[TestDox('HR-09 เปิดหน้าครั้งแรก: รอการกรองก่อน ยังไม่แสดงข้อมูล')]
    public function test_HR09(): void
    {
        $master = $this->returnedLoan();

        $response = $this->as($this->admin())->get(route('administrator.return-equipment'))->assertOk()
            ->assertSee('กรุณาเลือกตัวกรองเพื่อแสดงข้อมูล');
        $this->assertFalse((bool) $response->viewData('filtered'));
        $this->assertSame(0, $response->viewData('users')->total());
        $this->assertStringNotContainsString('class="eqm-group"', $response->getContent());

        // กดแสดงทั้งหมด หรือกรอง แล้วจึงแสดงข้อมูล
        $this->get(route('administrator.return-equipment', ['all' => 1]))->assertSee('#' . $master->id);
        $this->get(route('administrator.return-equipment', ['loan_no' => $master->id]))->assertSee('#' . $master->id);
        $this->get(route('administrator.return-equipment', ['loan_no' => $master->id + 1]))->assertSee('ไม่พบข้อมูลตามตัวกรอง');
    }

    #[TestDox('HR-07 ช่วงวันที่ไม่ถูกต้อง')]
    public function test_HR07(): void
    {
        $this->as($this->admin())->from(route('administrator.return-equipment'))
            ->get(route('administrator.loan.printReport', ['start_date' => '2026-10-31', 'end_date' => '2026-10-01']))
            ->assertRedirect(route('administrator.return-equipment'))
            ->assertSessionHasErrors(['end_date' => 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น']);
    }
}
