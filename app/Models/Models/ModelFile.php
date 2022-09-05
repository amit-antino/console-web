<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
class ModelFile extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['file_name'];
    protected static $logName = 'Models';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}
