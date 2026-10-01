<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EqmHistoryMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\{DB, Log, Mail};
use App\Mail\WelcomeMail;

class TaskController extends Controller
{
    public function hourlyTask()
    {
        // เฉพาะรายการที่อนุมัติแล้ว คำขอที่ยังรออนุมัติไม่นับว่าเกินกำหนด
        EqmHistoryMaster::where('status', 'borrowed')
            ->where('due_at', '<=', Carbon::now()->addDay())
            ->chunkById(100, function ($masters) {
                foreach ($masters as $master) {
                    if ($master->due_at->isPast()) {
                        DB::transaction(function () use ($master) {
                            $master->update([
                                'status' => 'overdue',
                                'is_overdue' => true,
                            ]);
                            $master->logEvent('overdue');
                        });
                    }
                    $memberEmail = $master->member->email;
                    if ($memberEmail) {
                        Mail::to($memberEmail)->send(new WelcomeMail($master));
                    }
                }
            });
    }
}
