<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes;
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'causer_id');
    }
    public function user_menu()
    {
        return $this->hasOne('App\Models\UserMenu', 'name', 'log_name');
    }
}
