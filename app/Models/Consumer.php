<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'consumer_name',
        'flat_number',
        'meter_number',
        'mailing_address',
        'supply_at',
        'area',
    ];

    // A consumer has many bills
    public function bills()
    {
        return $this->hasMany(Bill::class, 'consumer_id');
    }
}
