<?php

namespace App\Models\OtherInput\Reaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ReactionProperty extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected static $logAttributes = ['properties'];
    protected static $logName = 'Reaction Properties';
    protected static $logOnlyDirty = true;
    protected $casts = [
        'properties' => 'array',
        
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}
