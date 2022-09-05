<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logAttributes = ['name'];
    protected  $casts =
    [
        'users' => 'array',
        'location' => 'array',
        'tags' => 'array',
    ];
    protected static $logName = 'Tenants';
    protected static $logOnlyDirty = true;
}
