<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loan_transactions';

    protected $fillable = [
        'member_id',
        'status_type',
        'status',
        'borrowed_at',
        'returned_at'
    ];


    protected $dates = ['deleted_at'];
    public function loanEquipments()
    {
        return $this->hasMany(LoanEquipment::class, 'loan_transactions_id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
