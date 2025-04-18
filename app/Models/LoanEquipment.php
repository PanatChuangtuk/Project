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
        'equipment_id',
        'loan_transactions_id',
        'name',
        'quantity'
    ];


    protected $dates = ['deleted_at'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    public function loanTransaction()
    {
        return $this->belongsTo(LoanTransaction::class, 'loan_transactions_id');
    }
}
