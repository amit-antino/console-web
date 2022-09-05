<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ProcessSimulationReport extends Model
{
    use SoftDeletes, LogsActivity;

    protected static $logAttributes = [
        'report_name',
        'report_type',
        'simulation_type',
        'process_simulation_id',
        'description',
        'status'
    ];
    protected static $logName = 'Process Simulation Report';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "This Process Simulation Report has been {$eventName}";
    }
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
}
