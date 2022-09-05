<?php

namespace App\Models\Organization\Lists;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ClassificationList extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['classification_name'];
    protected static $logName = 'Lists';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}
