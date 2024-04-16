<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'value',
        'status',
        'name',
        'email',
        'reason'
        
    ];
}
