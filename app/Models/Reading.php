<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'readings';

    // Fillable properties for mass assignment
    protected $fillable = [
        'user_id',
        'reading_date',
        'units_used',
    ];

    // Define a relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
