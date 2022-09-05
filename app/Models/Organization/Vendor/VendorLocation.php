<?php

namespace App\Models\Organization\Vendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Country;

class VendorLocation extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = ['location_name'];
    protected static $logName = 'Vendor Location';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    public function country()
    {
        return $this->belongsTo(Country::class, "country_id", "id");
    }
   
}
