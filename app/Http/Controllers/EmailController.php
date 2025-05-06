<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\LoanTransaction;
use Carbon\Carbon;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $transactions = LoanTransaction::where('status_type', 'overdue')
            ->where('borrowed_at', '<', Carbon::now()->subDays(7))
            ->get();

        foreach ($transactions as $transaction) {
            $memberEmail = $transaction->member->email;
            Mail::to($memberEmail)->send(new WelcomeMail($transaction));
        }

        return response()->json(['message' => 'เมลได้ถูกส่งแล้ว']);
    }
}
