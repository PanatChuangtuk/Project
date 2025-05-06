<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        $grouped = $this->transaction->loanEquipments->groupBy(function ($item) {
            return $item->equipmentItem->name;
        })->map(function ($items, $name) {
            return [
                'image' => $items->first()->equipmentItem->image,
                'name' => $name,
                'total_quantity' => $items->sum('quantity'),
            ];
        });

        return $this->subject('การยืมเกินกำหนด')
            ->view('email.welcome')
            ->with([
                'transaction' => $this->transaction,
                'groupedEquipments' => $grouped,
            ]);
    }
}
