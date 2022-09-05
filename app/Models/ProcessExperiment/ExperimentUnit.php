<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Organization\Experiment\EquipmentUnit;

class ExperimentUnit extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['unit_name', 'condition', 'outcome', 'stream_flow', 'description', 'status'];
    protected static $logName = 'Experiment Units';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['experiment_unit_name','tenant_id','equipment_unit_id','description', 'tags', 'status'];
    protected $softDelete = true;
    public $timestamps = true;

    protected $casts = [
        'tags' => 'array'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "This Experiment Units has been {$eventName}";
    }

    public function exp_equip_unit()
    {
        return $this->belongsTo(EquipmentUnit::class, 'equipment_unit_id', 'id');
    }

    public function conditions()
    {
        return $this->hasMany(ExperimentConditionMaster::class);
    }
}
