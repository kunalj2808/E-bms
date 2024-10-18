<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillSetting extends Model
{
    use HasFactory;

    protected $table = 'bill_settings';

    // Fields that can be mass-assigned
    protected $fillable = [
        'upto_50',
        'upto_50_150',
        'upto_150_300',
        'above_300',
        'tariff_dg',
        'service_tax_dg',
        'electricity_upto',
        'electricity_value',
        'electricity_above_value',
        'late_percentage',
        'maintain_cost',
        'qr_image',
        'bill_id',
    ];

    // Define the relationship to the Bill model
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
