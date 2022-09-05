<?php

namespace App\Models\DataManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Dataset extends Model
{
    use HasFactory;
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logAttributes = ['name'];
    protected  $casts =
    [
        'tags' => 'array',
        'experiment_data' => 'array',
    ];
    protected static $logName = 'Dataset';
    protected static $logOnlyDirty = true;
}
