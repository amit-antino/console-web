<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class SimulateInput extends Model
{
    use HasFactory;
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['variation_id', 'experiment_id', 'name', 'master_condition', 'raw_material', 'unit_condition', 'unit_outcome', 'master_outcome', 'simulate_input_type', 'simulation_type'];
    protected static $logName = 'Simulation Inputss';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'raw_material' => 'array',
        'master_condition' => 'array',
        'unit_condition' => 'array',
        'master_outcome' => 'array',
        'unit_outcome' => 'array',
        'simulation_type' => 'array',
    ];
   
    public function getDescriptionForEvent(string $eventName): string
    {
        return "has been {$eventName}";
    }
}
