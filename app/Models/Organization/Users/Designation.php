<?php

namespace App\Models\Organization\Users;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use SoftDeletes;
    use LogsActivity;
    protected static $logAttributes = ['name', 'description', 'status'];
    protected static $logName = 'Designation';
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
}
