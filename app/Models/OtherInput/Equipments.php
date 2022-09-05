<?php

namespace App\Models\OtherInput;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Equipments extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logAttributes = [
        'equipment_name',
        'installation_date',
        'purchased_date',
        'vendor_id',
        'availability',
        'country_id',
        'state',
        'city',
        'status'
    ];
    protected static $logName = 'Equipments';

    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }

    protected static $logOnlyDirty = true;
    protected $softDelete = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = true;
    protected $casts = [
        'tags' => 'array'
    ];

    public function vendor()
    {
        return $this->hasOne('App\Models\Organization\Vendor\Vendor', 'id', 'vendor_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }
}
