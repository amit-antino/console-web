<?php

namespace App\Models\ProcessExperiment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Organization\Users\User;

class DataRequestModel extends Model
{
    use HasFactory;
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['type', 'requestor_id', 'description', 'status'];
    protected static $logName = 'Experiments Data Request';
    protected static $logOnlyDirty = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;


    public function getDescriptionForEvent(string $eventName): string
    {
        return "has been {$eventName}";
    }
    public function getCreatedBy()
    {
        return $this->belongsTo(User::class, "created_by", "id");
    }
}
