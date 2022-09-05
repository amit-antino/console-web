<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


class AssociatedModel extends Model
{
    use HasFactory;
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['name', 'model_type', 'description', 'configuration', 'status'];
    protected static $logName = 'Experiments Associated Model';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'tags' => 'array',
        'association' => 'array',
        'list_of_models' => 'array',
        'recommendations' => 'array',
        'assumptions' => 'array',

    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "has been {$eventName}";
    }
 
}
