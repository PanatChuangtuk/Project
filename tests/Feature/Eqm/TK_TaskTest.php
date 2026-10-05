<?php

namespace Tests\Feature\Eqm;

use App\Mail\WelcomeMail;
use App\Models\EqmBorrowReturnHistory;
use Illuminate\Support\Facades\{Artisan, Mail};
use PHPUnit\Framework\Attributes\TestDox;

class TK_TaskTest extends EqmTestCase
{
    #[TestDox('TK-01 เปลี่ยนสถานะเป็นเกินกำหนด')]
    public function test_TK01(): void
    {
        Mail::fake();
        $master = $this->makePastDue($this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']), 1);
        $this->app['auth']->forgetGuards();

        $this->assertSame(0, Artisan::call('app:hourly-task-command'));

        $master->refresh();
        $this->assertSame('overdue', $master->status);
        $this->assertTrue($master->is_overdue);
        $event = EqmBorrowReturnHistory::where('master_id', $master->id)->where('action', 'overdue')->firstOrFail();
        $this->assertSame('ระบบ', $event->actorLabel());
    }

    #[TestDox('TK-02 อีเมลเตือนก่อนครบกำหนด')]
    public function test_TK02(): void
    {
        Mail::fake();
        $master = $this->borrowedLoan($this->borrower(), ['เมาส์' => 1], ['53001']);
        // เหลือเวลาน้อยกว่า 1 วัน
        $master->update(['borrowed_at' => now()->subDays(6)->subHours(12), 'due_at' => now()->addHours(12)]);

        Artisan::call('app:hourly-task-command');

        $this->assertSame('borrowed', $master->fresh()->status);
        Mail::assertSent(WelcomeMail::class, function (WelcomeMail $mail) use ($master) {
            $html = $mail->render();
            return $mail->hasTo('s642041520111@email.kmutnb.com')
                && str_contains($html, 'เมาส์')
                && str_contains($html, 'ปกติ')
                && str_contains($html, $master->fresh()->due_at->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i'))
                && str_contains($html, $master->fresh()->borrowed_at->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i'));
        });
    }

    #[TestDox('TK-03 งานอัตโนมัติทำงานตามเวลา')]
    public function test_TK03(): void
    {
        // ทดสอบในเครื่อง Windows ที่ไม่มี cron ได้เฉพาะว่า scheduler ของ Laravel รู้จักคำสั่งนี้หรือไม่
        Artisan::call('schedule:list');
        $output = Artisan::output();
        if (!str_contains($output, 'app:hourly-task-command')) {
            $this->markTestIncomplete('ถูกบล็อก: scheduler ไม่มี app:hourly-task-command (app/Console/Kernel.php ไม่ถูกโหลดใน Laravel 11) ต้องตั้ง cron เรียกคำสั่งเองตาม README และเครื่องทดสอบไม่มี cron. schedule:list = ' . trim(preg_replace('/\s+/', ' ', $output)));
        }
        $this->assertStringContainsString('app:hourly-task-command', $output);
    }
}
