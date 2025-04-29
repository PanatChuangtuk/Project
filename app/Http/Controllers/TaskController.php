<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{LoanTransaction, LoanEquipment};
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function hourlyTask()
    {
        LoanTransaction::where('status_type', 'borrowed')
            ->where('borrowed_at', '<', Carbon::now()->subDays(7))
            ->chunkById(100, function ($transactions) {
                $transactions->each->update(['status_type' => 'overdue', 'is_overdue' => 1, 'status' => 'completed']);
            });
    }
}
