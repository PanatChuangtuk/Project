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
        $grouped = $this->transaction->details->groupBy('equipment_item_id')->map(function ($items) {
            return [
                'image' => $items->first()->equipmentItem?->image,
                'name' => $items->first()->name,
                'total_quantity' => $items->count(),
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
