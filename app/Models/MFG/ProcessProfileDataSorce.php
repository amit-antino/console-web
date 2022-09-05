<?php

namespace App\Models\MFG;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ProcessProfileDataSorce extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logName = 'Process Simulation';
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}
