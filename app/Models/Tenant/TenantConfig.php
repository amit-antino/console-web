<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TenantConfig extends Model
{
    use SoftDeletes, LogsActivity, HasFactory;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logAttributes = [];
    protected  $casts =
    [
        'menu_group' => 'array',
        'location' => 'array',
        'user_group' => 'array',
        'designation' => 'array',
        'user_permission' => 'array',
        'user_settings' => 'array',
        'calc_server' => 'array'
    ];
    protected static $logName = 'Tenant Config';
    protected static $logOnlyDirty = true;
}
