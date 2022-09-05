<?php

namespace App\Models\MFG;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\MFG\ProcessSimulation;
use App\Models\Master\ProcessSimulation\SimulationType;
use App\Models\Product\Chemical;

class ProcessProfile extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logName = 'Process Simulation Profile';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'data_source' => 'array',
        'mass_basic_io' => 'array',
        'mass_basic_pc' => 'array',
        'mass_basic_pd' => 'array',
        'energy_basic_io' => 'array',
        'energy_process_level' => 'array',
        'energy_detailed_level' => 'array',
        'equipment_capital_cost' => 'array',
        'key_process_info' => 'array',
        'quality_assesment' => 'array',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    public function processSimulation()
    {
        return $this->belongsTo(ProcessSimulation::class, "process_id", "id");
    }

    public function SimulationType()
    {
        return $this->belongsTo(SimulationType::class, "simulation_type", "id");
    }
    public function getProduct()
    {
        return $this->belongsTo(Chemical::class, "product", "id");
    }
}
