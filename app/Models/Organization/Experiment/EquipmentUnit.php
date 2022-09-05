<?php

namespace App\Models\Organization\Experiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Experiment\ExperimentUnitImage;
use App\Models\Master\MasterUnit;
use ExperimentConditionMaster;

class EquipmentUnit extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logAttributes = ['equipment_name', 'unit_image', 'description'];
    protected static $logName = 'Experiment Equipment Units';
    protected static $logOnlyDirty = true;

    protected $casts = [
        'condition' => 'array',
        'outcome' => 'array',
        'stream_flow' => 'array',
        'tags' => 'array'
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    public function exp_unit_image()
    {
        return $this->belongsTo(ExperimentUnitImage::class, 'unit_image', 'id');
    }

    public function unit_types()
    {
        return $this->belongsTo(MasterUnit::class, 'unit_type', 'id');
    }

    public function conditions()
    {
        return $this->hasMany(ExperimentConditionMaster::class);
    }
}
