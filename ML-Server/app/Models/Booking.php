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
        'notes',
        'resource_name'
    ];
}
