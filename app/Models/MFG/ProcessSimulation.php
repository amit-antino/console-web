<?php

namespace App\Models\MFG;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Master\ProcessSimulation\ProcessCategory;
use App\Models\Master\ProcessSimulation\ProcessStatus;
use App\Models\Master\ProcessSimulation\ProcessType;
use App\Models\Master\ProcessSimulation\SimulationType;
use App\Models\MFG\ProcessProfile;
use Illuminate\Notifications\Notifiable;

class ProcessSimulation extends Model
{
    use SoftDeletes, LogsActivity;
    use Notifiable;
    protected static $logAttributes = [
        'process_name',
        'process_type',
        'product',
        'energy',
        'main_feedstock',
        'main_product',
        'status',
    ];

    protected static $logName = 'Process Simulation';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = true;
    protected $casts = [
        'product' => 'array',
        'energy' => 'array',
        'tags' => 'array',
        'sim_stage' => 'array'
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    public function processType()
    {
        return $this->belongsTo(ProcessType::class, "process_type", "id");
    }

    public function processCategory()
    {
        return $this->belongsTo(ProcessCategory::class, "process_category", "id");
    }

    public function processStatus()
    {
        return $this->belongsTo(ProcessStatus::class, "process_status", "id");
    }

    public function SimulationType()
    {
        return $this->belongsTo(SimulationType::class, "sim_stage", "id");
    }

    public function processSimulation()
    {
        return $this->hasMany(ProcessProfile::class, "id", "process_id");
    }
}
