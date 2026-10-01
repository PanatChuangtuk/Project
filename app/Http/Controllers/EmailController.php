<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\EqmHistoryMaster;
use Carbon\Carbon;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $transactions = EqmHistoryMaster::where('status', 'overdue')
            ->where('due_at', '<', Carbon::now())
            ->get();

        foreach ($transactions as $transaction) {
            $memberEmail = $transaction->member->email;
            Mail::to($memberEmail)->send(new WelcomeMail($transaction));
        }

        return response()->json(['message' => 'เมลได้ถูกส่งแล้ว']);
    }
}
