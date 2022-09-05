<?php

namespace App\Models\Experiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Master\MasterUnit;

class ExperimentOutcomeMaster extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['name', 'description', 'status'];
    protected static $logName = 'Experiment Outcome';
    protected static $logOnlyDirty = true;
    protected $fillable = ['name','unittype','tenant_id','description', 'status'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    public function unit_types()
    {
        return $this->belongsTo(MasterUnit::class, 'unittype', 'id');
    }
}
