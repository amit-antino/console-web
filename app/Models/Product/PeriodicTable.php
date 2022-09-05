<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PeriodicTable extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['element_name', 'element_sc', 'element_weight', 'status'];
    protected static $logName = 'Periodic Table';
    protected static $logOnlyDirty = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
}
