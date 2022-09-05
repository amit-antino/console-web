<?php

namespace App\Models\Experiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\ProcessExperiment\ProcessExperiment;

class ProcessDiagram extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logName = 'Process Diagram ';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;

    protected $casts = [
        'to_unit' => 'array',
        'from_unit' => 'array',
        'products' => 'array',
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    public function getExp()
    {
        return $this->belongsTo(ProcessExperiment::class, "process_id", "id");
    }
}
