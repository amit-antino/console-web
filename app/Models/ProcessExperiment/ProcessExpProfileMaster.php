<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ProcessExpProfileMaster extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['process_exp_id', 'condition', 'outcome', 'chemical', 'reaction'];
    protected static $logName = 'Experiments profile Master';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [

        'condition' => 'array',
        'outcome' => 'array',
        'reaction' => 'array',
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "has been {$eventName}";
    }
    public function experiment()
    {
        return $this->belongsTo(ProcessExperiment::class, "process_exp_id", "id");
    }
}
