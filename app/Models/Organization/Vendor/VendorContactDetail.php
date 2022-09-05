<?php

namespace App\Models\Organization\Vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class VendorContactDetail extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['name'];
    protected static $logName = 'Vendor Contact';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
}
