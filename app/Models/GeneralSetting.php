<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    // Define the table name if it's not the default plural form
    protected $table = 'general_settings';

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'upto_50',
        'upto_50_150',
        'upto_150_300',
        'above_300',
        'tariff_dg',
        'service_tax_dg',
        'electricity_upto',
        'electicity_value',
        'electicity_above_value',
        'late_percentage',
        'maintain_cost',
    ];

    // Optionally, disable timestamps if not needed
    public $timestamps = true;
}
