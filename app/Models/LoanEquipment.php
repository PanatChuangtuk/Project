<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanEquipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loan_equipment';
    protected $fillable = [
        'equipment_item_id',
        'equipment_id',
        'loan_transactions_id',
        'name',
        'quantity'
    ];


    protected $dates = ['deleted_at'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function equipmentItem()
    {
        return $this->belongsTo(EquipmentItem::class, 'equipment_item_id');
    }

    public function loanTransaction()
    {
        return $this->belongsTo(LoanTransaction::class, 'loan_transactions_id');
    }
}
