<?php

namespace App\Models\OtherInput;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\OtherInput\EnergyUtility;


class EnergyUtilityProperty extends Model
{
    use SoftDeletes, LogsActivity;

    public $timestamps = true;
    protected $softDelete = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected static $logAttributes = ['name', 'description', 'status'];
    protected static $logName = 'Energy Utility Property';
    protected static $logOnlyDirty = true;
    protected $casts = [
        'prop_json' => 'array',
        'dynamic_prop_json' => 'array',
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return " has been {$eventName}";
    }
    public function energy_sub_property()
    {
        return $this->hasmany('App\Models\Master\EnergyUtilities\EnergySubPropertyMaster', 'id', 'sub_property_id');
    }
    public function getenergy()
    {
        return $this->belongsTo(EnergyUtility::class, "energy_id", "id");
    }
}
