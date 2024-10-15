<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';

    protected $fillable = [
        'consumer_id',
        'reporting_month',
        'bill_date',
        'bill_due_date',
        'remarks',
        'current_reading',
        'previous_reading',
        'current_bill_amount',
        'previous_due_amount',
        'tariff_dg',
        'is_previous',
        'discount_deposite_amount',
    ];

    // A bill belongs to a consumer
    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'consumer_id');
    }

    // A bill has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class, 'bill_id');
    }

     // Mutator to format bill_date as YYYY-MM when setting the value
     public function setBillDateAttribute($value)
     {
         $this->attributes['bill_date'] = \Carbon\Carbon::parse($value)->format('Y-m-d');
     }
 
     // Accessor to retrieve bill_date as YYYY-MM
     public function getBillDateAttribute($value)
     {
         return \Carbon\Carbon::parse($value)->format('Y-m-d');
     }
}
