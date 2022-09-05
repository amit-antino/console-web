<?php

namespace App\Models\DataManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class DataCuration extends Model
{
    use HasFactory;
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logAttributes = ['name'];
    protected  $casts =
    [
        'output' => 'array',
    ];
    protected static $logName = 'Data Curation';
    protected static $logOnlyDirty = true;
}
