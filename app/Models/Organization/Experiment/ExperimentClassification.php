<?php

namespace App\Models\Organization\Experiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ExperimentClassification extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = true;
    protected $softDelete = true;
    protected static $logAttributes = ['name', 'description', 'status'];
    protected static $logName = 'Experiment Classification';
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}
