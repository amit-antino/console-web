<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class DatasetModel extends Model
{
    use HasFactory;
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['name', 'type', 'description', 'status'];
    protected static $logName = 'Experiments Dataset';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'tags' => 'array',
        'filename' => 'array'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "has been {$eventName}";
    }
}
