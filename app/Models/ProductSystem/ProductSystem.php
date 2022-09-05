<?php

namespace App\Models\ProductSystem;

use App\Models\Master\ProcessSimulation\SimulationType;
use App\Models\MFG\ProcessSimulation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductSystem extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = [
        'name',
        'simulation_type',
        'process',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    ];
    protected static $logName = 'Product System';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'process' => 'array',
        'tags' => 'array'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}
