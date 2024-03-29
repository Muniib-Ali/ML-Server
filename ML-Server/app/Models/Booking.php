<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'resource_group_id',
        'resource_id',
        'user_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'compare_start_date',
        'compare_end_date',
        'notes',
        'resource_name',
        'resource_group_name',
        'uThreshold',
        'lThreshold', 
        'email'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
