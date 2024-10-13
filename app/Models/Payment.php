<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'bill_id',
        'received_amount',
        'late_fees',
    ];

    // A payment belongs to a bill
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }
}
