<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Variation extends Model
{
    use SoftDeletes, LogsActivity, HasFactory;
    protected static $logAttributes = ['experiment_id', 'name', 'process_flow_table','process_flow_chart','unit_specification','models','dataset','datamodel'];
    protected static $logName = 'Experiments Variation';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'process_flow_table' => 'array',
        'process_flow_chart' => 'array',
        'unit_specification' => 'array',
        'models' => 'array',
        'dataset' => 'array',
        'datamodel' => 'array',
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "has been {$eventName}";
    }
}
