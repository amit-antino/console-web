<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\MFG\ProcessSimulation;

class ProcessComaprison extends Model
{
    //specify_weights,process_simulation_id
    use SoftDeletes, LogsActivity;
    use Notifiable;
    protected static $logAttributes = [
        'report_name',
        'report_type',
        'simulation_type',
        'process_simulation_id',
        'status',
    ];

    protected static $logName = 'Process Comparision Report';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = true;
    protected $casts = [
        'specify_weights' => 'array',
        'process_simulation_ids' => 'array',
        'tags' => 'array',

    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    public function processSimulation()
    {
        return $this->belongsTo(ProcessSimulation::class);
    }
}
