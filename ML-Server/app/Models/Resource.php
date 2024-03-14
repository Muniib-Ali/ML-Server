<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    public $table = 'resource';
    protected $fillable = [
        'resource_group_id',
        'name',
        'cost',
        'resource_group_name',
        'threshold',
        'number'

        
    ];
}
