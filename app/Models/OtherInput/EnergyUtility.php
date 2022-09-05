<?php

namespace App\Models\OtherInput;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class EnergyUtility extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = [
        'energy_name',
        'base_unit_type',
        'vendor_id'
    ];
    protected static $logName = 'Energy Utility';

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    protected static $logOnlyDirty = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'tags' => 'array'
    ];
    public function unit_type()
    {
        return $this->hasOne('App\Models\Master\MasterUnit', 'id', 'base_unit_type');
    }

    public function vendor()
    {
        return $this->hasOne('App\Models\Organization\Vendor\Vendor', 'id', 'vendor_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }

}
