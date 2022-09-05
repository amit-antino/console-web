<?php

namespace App\Models\Master\EnergyUtilities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class EnergySubPropertyMaster extends Model
{
    use SoftDeletes, LogsActivity;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    public $timestamps = true;
    protected $casts = [
        'fields' => 'array',
        'dynamic_fields' => 'array',
    ];
    protected static $logAttributes = ['sub_property_name'];
    protected static $logName = 'Energy Sub Property Master';
    public function main_prop()
    {
        return $this->hasOne('App\Models\Master\EnergyUtilities\EnergyPropertyMaster', 'id', 'property_id');
    }
}
