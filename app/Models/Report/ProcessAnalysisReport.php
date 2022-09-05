<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\MFG\ProcessSimulation;
use App\Models\MFG\ProcessProfile;

class ProcessAnalysisReport extends Model
{
    use SoftDeletes, LogsActivity;
    use Notifiable;
    protected static $logAttributes = [
        'report_name',
        'report_type',
        'simulation_type',
        'process_simulation_id',
        'main_feedstock',
        'main_product',
        'status',
    ];

    protected static $logName = 'Process Analysis Report';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = true;
    protected $casts = [

        'tags' => 'array',

    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    public function processSimulation()
    {
        return $this->belongsTo(ProcessSimulation::class, "process_id", "id")->withTrashed();
    }
    public function processDataset()
    {
        return $this->belongsTo(ProcessProfile::class, "dataset_id", "id")->withTrashed();
    }
}
