<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TenantMenuGroup extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logAttributes = ['name'];
    protected static $logName = 'Tenant Menu Groups';
    protected static $logOnlyDirty = true;
    protected $casts = [
        'menu_list' => 'array',
    ];
}
