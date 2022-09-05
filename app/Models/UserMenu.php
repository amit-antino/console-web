<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMenu extends Model
{
    use SoftDeletes; 
    
    protected $casts = [
        'sub_menu' => 'array',
    ];
}
