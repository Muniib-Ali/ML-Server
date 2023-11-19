<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceGroup extends Model
{
    use HasFactory;
    public $table = 'resource_group';
    protected $fillable = [
        'resource_group'
        
    ];
}
