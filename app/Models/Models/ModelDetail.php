<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


class ModelDetail extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['name'];
    protected static $logName = 'Models';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'recommendations' => 'array',
        'list_of_models' => 'array',
        'assumptions' => 'array',
        'association' => 'array',
        'files' => 'array',
        'tags' => 'array'
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    public function model_files()
    {
        return $this->hasMany('App\Models\Models\ModelFile', 'model_id', 'id');
    }
}
